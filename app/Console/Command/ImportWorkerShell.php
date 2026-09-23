<?php
App::uses('AppShell', 'Console/Command');
// AppController не объявляет App::uses для базового класса — в вебе его грузит диспетчер
App::uses('Controller', 'Controller');
App::uses('AppController', 'Controller');
App::uses('ImportController', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');

/**
 * Фоновый обработчик очереди импорта/конвертации (таблица import_jobs).
 *
 * Выполняет не больше одной задачи за запуск и завершается, чтобы каждая задача
 * шла в чистом процессе PHP. Перезапуск в цикле — в команде контейнера tyre-app-worker.
 *
 *   cake import_worker [--wait 300]
 */
class ImportWorkerShell extends AppShell {

	public $uses = array('ImportJob');

	// Сколько дней хранить завершённые задачи и файлы конвертации
	const KEEP_DAYS = 7;

	private $currentJobId = null;

	public function getOptionParser() {
		$parser = parent::getOptionParser();
		$parser->description('Обрабатывает одну задачу из очереди импорта/конвертации.');
		$parser->addOption('wait', array(
			'help' => 'Сколько секунд ждать задачу, если очередь пуста.',
			'default' => 300
		));
		return $parser;
	}

	public function main() {
		Configure::write('Config.language', 'ru');
		ini_set('memory_limit', '512M');
		set_time_limit(0);
		register_shutdown_function(array($this, 'onShutdown'));

		$this->ImportJob->failInterrupted();
		$this->ImportJob->purgeOld(self::KEEP_DAYS);

		$deadline = time() + (int)$this->params['wait'];
		do {
			if ($job = $this->ImportJob->claimNext()) {
				$this->_run($job);
				return;
			}
			sleep(2);
		} while (time() < $deadline);
	}

	private function _run($job) {
		$this->currentJobId = $job['id'];
		$action = array_search($job['kind'], ImportJobController::kinds(), true);
		$path = TMP . basename($job['tmp_file']);
		$this->out(sprintf('[%s] job #%d %s "%s"', date('Y-m-d H:i:s'), $job['id'], $job['kind'], $job['file_name']));

		$status = ImportJob::STATUS_FAILED;
		$result = array();
		$error = null;
		if ($action === false) {
			$error = 'Неизвестный тип задачи: ' . $job['kind'];
		} elseif (!file_exists($path)) {
			$error = 'Файл задачи не найден';
		} else {
			$data = array('Import' => (array)$job['params']);
			$data['Import']['file'] = array(
				'name' => $job['file_name'],
				'type' => '',
				'tmp_name' => $path,
				'error' => 0,
				'size' => filesize($path)
			);
			$request = new CakeRequest(null, false);
			$request->data = $data;
			$request->addParams(array('controller' => 'import', 'action' => $action, 'prefix' => 'admin', 'admin' => true, 'plugin' => null, 'pass' => array(), 'named' => array()));
			$controller = new ImportJobController($request, new CakeResponse());
			$controller->constructClasses();
			$controller->startJob($this->ImportJob, $job['id']);
			try {
				$controller->{$action}();
			} catch (Exception $e) {
				$error = get_class($e) . ': ' . $e->getMessage();
			}
			// Экшен удаляет свою копию файла только при успешном чтении Excel
			if (isset($controller->Import) && $controller->Import->tmp_file && file_exists(TMP . $controller->Import->tmp_file)) {
				unlink(TMP . $controller->Import->tmp_file);
			}
			list($status, $result, $jobError) = $controller->jobResult();
			if ($error === null) {
				$error = $jobError;
			} else {
				$status = ImportJob::STATUS_FAILED;
			}
		}
		$this->ImportJob->finish($job['id'], $status, $result, $error);
		$this->currentJobId = null;
		if (file_exists($path)) {
			unlink($path);
		}
		$this->out(sprintf('[%s] job #%d %s%s', date('Y-m-d H:i:s'), $job['id'], $status, $error ? ': ' . $error : ''));
	}

	/**
	 * Фатальная ошибка PHP (например, нехватка памяти) не ловится try/catch —
	 * помечаем задачу упавшей здесь, иначе она останется «выполняется».
	 */
	public function onShutdown() {
		if ($this->currentJobId === null) {
			return;
		}
		$error = error_get_last();
		$message = 'Воркер аварийно завершился';
		if ($error && in_array($error['type'], array(E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR))) {
			$message .= ': ' . $error['message'] . ' (' . basename($error['file']) . ':' . $error['line'] . ')';
		}
		$this->ImportJob->finish($this->currentJobId, ImportJob::STATUS_FAILED, array(), $message);
	}
}

/**
 * ImportController, запущенный вне веб-запроса: вместо вывода страницы, редиректов
 * и сессии собирает результат экшена для сохранения в задаче.
 */
class ImportJobController extends ImportController {

	// Имя задаёт домен переводов (admin_import) и пути, как у исходного контроллера
	public $name = 'Import';

	public $inWorker = true;

	// Пауза на каждые TICK_ROWS строк прайса, чтобы запросы сайта успевали между записями импорта
	const TICK_ROWS = 200;

	private $jobModel;
	private $jobId;
	private $flash = array();
	private $throttle;

	public static function kinds() {
		$vars = get_class_vars('ImportController');
		return $vars['jobKinds'];
	}

	public function startJob($jobModel, $jobId) {
		$this->jobModel = $jobModel;
		$this->jobId = $jobId;
		$this->Session = new ImportJobSession();
		$this->sections = array();
		$ms = getenv('IMPORT_THROTTLE_MS');
		$this->throttle = ($ms === false || $ms === '' ? 50 : (int)$ms) * 1000;
	}

	protected function _jobTick($rows) {
		if ($rows % self::TICK_ROWS != 0) {
			return;
		}
		$this->jobModel->setProgress($this->jobId, $rows);
		if ($this->throttle > 0) {
			usleep($this->throttle);
		}
	}

	public function render($view = null, $layout = null) {
		$this->autoRender = false;
		return $this->response;
	}

	public function redirect($url, $status = null, $exit = true) {
	}

	public function info($message = '') {
		$this->flash[] = array('type' => 'info', 'text' => $message);
	}

	public function error($message = '') {
		$this->flash[] = array('type' => 'error', 'text' => $message);
	}

	/**
	 * @return array (статус, результат для страницы, текст ошибки или null)
	 */
	public function jobResult() {
		$result = array('flash' => $this->flash);
		// Импорт после «редиректа» сам переносит message_lines из сессии в viewVars
		foreach (array('filename', 'stat', 'errors', 'message_lines') as $key) {
			if (isset($this->viewVars[$key])) {
				$result[$key] = $this->viewVars[$key];
			}
		}
		if (!isset($result['message_lines']) && $this->Session->check('message_lines')) {
			$result['message_lines'] = $this->Session->read('message_lines');
		}

		$errors = array();
		if (isset($this->Import) && !empty($this->Import->validationErrors)) {
			foreach ($this->Import->validationErrors as $messages) {
				$errors = array_merge($errors, (array)$messages);
			}
		}
		foreach ($this->flash as $item) {
			if ($item['type'] == 'error') {
				$errors[] = $item['text'];
			}
		}
		if (!empty($errors)) {
			return array(ImportJob::STATUS_FAILED, $result, implode('; ', $errors));
		}
		return array(ImportJob::STATUS_DONE, $result, null);
	}
}

/**
 * Замена SessionComponent для запуска вне веб-запроса: хранит значения в памяти.
 */
class ImportJobSession {
	private $data = array();

	public function write($key, $value = null) {
		$this->data[$key] = $value;
		return true;
	}

	public function read($key = null) {
		return isset($this->data[$key]) ? $this->data[$key] : null;
	}

	public function check($key) {
		return isset($this->data[$key]);
	}

	public function delete($key) {
		unset($this->data[$key]);
		return true;
	}

	public function close() {
	}

	public function setFlash($message, $element = 'default', $params = array(), $key = 'flash') {
	}

	public function __call($name, $args) {
		return null;
	}
}
