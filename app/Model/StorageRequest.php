<?php
class StorageRequest extends AppModel {
	public $name = 'StorageRequest';
	public $validationDomain = 'admin_storage_requests';
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'message' => 'error_name_empty'
		),
		'phone' => array(
			'rule' => 'notEmpty',
			'message' => 'error_phone_empty'
		),
		'email' => array(
			'rule' => 'email',
			'message' => 'error_email_format',
			'allowEmpty' => true
		),
		'date' => array(
			'rule' => 'notEmpty',
			'message' => 'error_date_empty'
		),
		'time' => array(
			'rule' => 'notEmpty',
			'message' => 'error_time_empty'
		),
		'station_id' => array(
			array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'error_station_id_empty',
				'last' => true
			),
			array(
				'rule' => array('comparison', '>', 0),
				'required' => true,
				'message' => 'error_station_id_numeric'
			)
		)
	);
	public function __construct() {
		parent::__construct();
		$this->virtualFields['is_deletable'] = 1;
		$this->virtualFields['request_id'] = 'CONCAT(StorageRequest.code,LPAD(StorageRequest.id,4,\'0\'))';
	}
	public function beforeSave($options = array()) {
		if (parent::beforeSave()) {
			if (isset($this->data[$this->name]['date']) && substr_count($this->data[$this->name]['date'], '.') > 0) {
				$date_parts = explode('.', $this->data[$this->name]['date']);
				$this->data[$this->name]['date'] = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
			}
			if (isset($this->data[$this->name]['time']) && strlen($this->data[$this->name]['time']) < 8) {
				$this->data[$this->name]['time'] .= ':00';
			}
			if (!$this->exists()) {
				$this->data[$this->name]['code'] = $this->_generateCode();
			}
			return true;
		}
		return false;
	}
	private function _generateCode() {
		$letters = 'ABCEFHKMPRSTUXYZ';
		return $letters[mt_rand(0, 15)] . $letters[mt_rand(0, 15)];
	}
}