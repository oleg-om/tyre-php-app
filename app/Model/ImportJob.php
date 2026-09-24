<?php
/**
 * Очередь фоновых задач импорта и конвертации прайсов.
 *
 * Работает с таблицей import_jobs напрямую через SQL, без схемы модели:
 * таблица создаётся на лету (ensureTable), а закешированный список таблиц
 * Cake о ней бы не знал.
 */
class ImportJob extends AppModel {
	public $name = 'ImportJob';
	public $useTable = false;

	const STATUS_QUEUED = 'queued';
	const STATUS_RUNNING = 'running';
	const STATUS_DONE = 'done';
	const STATUS_FAILED = 'failed';

	private static $tableChecked = false;

	public function ensureTable() {
		if (self::$tableChecked) {
			return;
		}
		$this->_query("CREATE TABLE IF NOT EXISTS `import_jobs` (
			`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
			`kind` VARCHAR(32) NOT NULL,
			`status` VARCHAR(16) NOT NULL DEFAULT 'queued',
			`params` MEDIUMTEXT NULL,
			`file_name` VARCHAR(255) NULL,
			`tmp_file` VARCHAR(64) NULL,
			`rows_done` INT UNSIGNED NOT NULL DEFAULT 0,
			`result` MEDIUMTEXT NULL,
			`error` TEXT NULL,
			`created` DATETIME NOT NULL,
			`started` DATETIME NULL,
			`finished` DATETIME NULL,
			PRIMARY KEY (`id`),
			KEY `status_idx` (`status`, `id`),
			KEY `kind_idx` (`kind`, `id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		self::$tableChecked = true;
	}

	public function enqueue($kind, $params, $fileName, $tmpFile) {
		$this->ensureTable();
		$this->_query(
			'INSERT INTO `import_jobs` (`kind`, `status`, `params`, `file_name`, `tmp_file`, `created`) VALUES (?, ?, ?, ?, ?, NOW())',
			array($kind, self::STATUS_QUEUED, json_encode($params), $fileName, $tmpFile)
		);
		return $this->getDataSource()->lastInsertId();
	}

	/**
	 * Атомарно забирает самую старую задачу из очереди.
	 */
	public function claimNext() {
		$this->ensureTable();
		$rows = $this->_fetch('SELECT `id` FROM `import_jobs` WHERE `status` = ? ORDER BY `id` LIMIT 1', array(self::STATUS_QUEUED));
		if (empty($rows)) {
			return null;
		}
		$id = $rows[0]['import_jobs']['id'];
		$this->_query(
			'UPDATE `import_jobs` SET `status` = ?, `started` = NOW() WHERE `id` = ? AND `status` = ?',
			array(self::STATUS_RUNNING, $id, self::STATUS_QUEUED)
		);
		if ($this->getDataSource()->lastAffected() != 1) {
			return null;
		}
		return $this->get($id);
	}

	/**
	 * Помечает как упавшие задачи, которые остались в работе после остановки воркера.
	 * Воркер один, поэтому на момент его старта ни одна задача не может выполняться.
	 */
	public function failInterrupted() {
		$this->ensureTable();
		$rows = $this->_fetch('SELECT `tmp_file` FROM `import_jobs` WHERE `status` = ?', array(self::STATUS_RUNNING));
		foreach ($rows as $row) {
			$path = TMP . basename($row['import_jobs']['tmp_file']);
			if ($row['import_jobs']['tmp_file'] && file_exists($path)) {
				unlink($path);
			}
		}
		$this->_query(
			'UPDATE `import_jobs` SET `status` = ?, `error` = ?, `finished` = NOW() WHERE `status` = ?',
			array(self::STATUS_FAILED, 'Задача прервана: воркер был перезапущен или аварийно завершился', self::STATUS_RUNNING)
		);
	}

	/**
	 * Удаляет завершённые задачи старше $days дней вместе с их файлами
	 * (результат конвертации в webroot/xls и загруженный прайс, если остался).
	 */
	public function purgeOld($days) {
		$this->ensureTable();
		$rows = $this->_fetch(
			'SELECT `id`, `tmp_file`, `result` FROM `import_jobs` WHERE `status` IN (?, ?) AND COALESCE(`finished`, `created`) < NOW() - INTERVAL ' . (int)$days . ' DAY',
			array(self::STATUS_DONE, self::STATUS_FAILED)
		);
		foreach ($rows as $row) {
			$job = $this->_format($row['import_jobs']);
			$files = array();
			if (!empty($job['result']['filename'])) {
				$files[] = WWW_ROOT . 'xls' . DS . basename($job['result']['filename']);
			}
			if (!empty($job['tmp_file'])) {
				$files[] = TMP . basename($job['tmp_file']);
			}
			foreach ($files as $path) {
				if (file_exists($path)) {
					unlink($path);
				}
			}
			$this->_query('DELETE FROM `import_jobs` WHERE `id` = ?', array($job['id']));
		}
		return count($rows);
	}

	public function setProgress($id, $rowsDone) {
		$this->_query('UPDATE `import_jobs` SET `rows_done` = ? WHERE `id` = ?', array((int)$rowsDone, $id));
	}

	public function finish($id, $status, $result, $error = null) {
		$this->_query(
			'UPDATE `import_jobs` SET `status` = ?, `result` = ?, `error` = ?, `finished` = NOW() WHERE `id` = ?',
			array($status, json_encode($result), $error, $id)
		);
	}

	public function get($id) {
		$rows = $this->_fetch('SELECT * FROM `import_jobs` WHERE `id` = ?', array($id));
		return empty($rows) ? null : $this->_format($rows[0]['import_jobs']);
	}

	public function recent($kind, $limit = 5) {
		$this->ensureTable();
		$rows = $this->_fetch(
			'SELECT * FROM `import_jobs` WHERE `kind` = ? ORDER BY `id` DESC LIMIT ' . (int)$limit,
			array($kind)
		);
		$jobs = array();
		foreach ($rows as $row) {
			$job = $this->_format($row['import_jobs']);
			if ($job['status'] == self::STATUS_QUEUED) {
				$job['ahead'] = $this->countAhead($job['id']);
			}
			$jobs[] = $job;
		}
		return $jobs;
	}

	public function countAhead($id) {
		$rows = $this->_fetch(
			'SELECT COUNT(*) AS `cnt` FROM `import_jobs` WHERE `id` < ? AND `status` IN (?, ?)',
			array($id, self::STATUS_QUEUED, self::STATUS_RUNNING)
		);
		return (int)$rows[0][0]['cnt'];
	}

	private function _format($job) {
		$job['params'] = json_decode($job['params'], true);
		$job['result'] = json_decode($job['result'], true);
		return $job;
	}

	private function _fetch($sql, $params = array()) {
		// Без кеша: статус задачи должен читаться актуальным
		return $this->getDataSource()->fetchAll($sql, $params, array('cache' => false));
	}

	private function _query($sql, $params = array()) {
		// Не rawQuery(): в Cake 2.6 он теряет параметры запроса
		return $this->getDataSource()->execute($sql, array(), $params);
	}
}
