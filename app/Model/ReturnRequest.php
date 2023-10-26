<?php
class ReturnRequest extends AppModel {
	public $name = 'ReturnRequest';
	public $validationDomain = 'admin_return_requests';
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'message' => 'error_name_empty'
		),
		'phone' => array(
			array(
				'last' => true,
				'rule' => 'notEmpty',
				'message' => 'error_phone_empty'
			),
			array(
				'rule' => 'naturalNumber',
				'message' => 'error_phone_number'
			)				
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
	);
	public $belongsTo = array(
		'StorageRequest'
	);
	public $statuses = array();
	public function __construct() {
		parent::__construct();
		$this->virtualFields['is_deletable'] = 1;
		$this->virtualFields['request_id'] = 'CONCAT(StorageRequest.code,LPAD(StorageRequest.id,5,\'0\'))';
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
			return true;
		}
		return false;
	}
}