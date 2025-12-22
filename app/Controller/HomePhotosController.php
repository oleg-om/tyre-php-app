<?php
class HomePhotosController extends AppController {
	public $uses = array();
	public $layout = 'main';
	public $paginate = array(
		'order' => array(
			'HomePhoto.sort_order' => 'asc'
		)
	);
	public $filter_fields = array('HomePhoto.id' => 'int', 'HomePhoto.link' => 'text');
	public $model = 'HomePhoto';
	public $submenu = 'home_photos';
	function all() {
		$this->loadModel('HomePhoto');
		$home_photos = $this->HomePhoto->find('all', array('order' => array('HomePhoto.sort_order' => 'asc'), 'conditions' => array('HomePhoto.is_active' => 1), 'fields' => array('HomePhoto.id', 'HomePhoto.filename', 'HomePhoto.link', 'HomePhoto.date_start', 'HomePhoto.date_end')));
		
		// Фильтруем по датам показа
		$filtered_photos = array();
		$current_date = date('d.m');
		
		foreach ($home_photos as $photo) {
			$date_start = !empty($photo['HomePhoto']['date_start']) ? trim($photo['HomePhoto']['date_start']) : '';
			$date_end = !empty($photo['HomePhoto']['date_end']) ? trim($photo['HomePhoto']['date_end']) : '';
			
			// Если обе даты установлены, проверяем диапазон
			if (!empty($date_start) && !empty($date_end)) {
				if ($this->_isDateInRange($current_date, $date_start, $date_end)) {
					$filtered_photos[] = $photo;
				}
			} else {
				// Если даты не установлены, показываем слайд всегда
				$filtered_photos[] = $photo;
			}
		}
		
		return $filtered_photos;
	}
	
	/**
	 * Проверяет, попадает ли текущая дата в диапазон показа
	 * @param string $current_date Текущая дата в формате DD.MM
	 * @param string $date_start Дата начала в формате DD.MM
	 * @param string $date_end Дата окончания в формате DD.MM
	 * @return bool
	 */
	private function _isDateInRange($current_date, $date_start, $date_end) {
		// Парсим даты
		list($current_day, $current_month) = explode('.', $current_date);
		list($start_day, $start_month) = explode('.', $date_start);
		list($end_day, $end_month) = explode('.', $date_end);
		
		$current_timestamp = (int)$current_month * 100 + (int)$current_day;
		$start_timestamp = (int)$start_month * 100 + (int)$start_day;
		$end_timestamp = (int)$end_month * 100 + (int)$end_day;
		
		// Если диапазон не переходит через новый год (например, 01.01 - 31.12)
		if ($start_timestamp <= $end_timestamp) {
			return $current_timestamp >= $start_timestamp && $current_timestamp <= $end_timestamp;
		} else {
			// Если диапазон переходит через новый год (например, 01.12 - 01.01)
			return $current_timestamp >= $start_timestamp || $current_timestamp <= $end_timestamp;
		}
	}
}