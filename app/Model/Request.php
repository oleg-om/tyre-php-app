<?php
class Request extends AppModel {
	public $name = 'Request';
	public $validationDomain = 'admin_requests';
	public $validate = array(
		'number' => array(
			'rule' => 'notEmpty',
			'message' => 'error_number_empty'
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
		'radius' => array(
			array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'error_radius_empty',
				'last' => true
			),
			array(
				'rule' => array('comparison', '>', 0),
				'required' => true,
				'message' => 'error_radius_numeric'
			)
		)
	);
	public $radiuses = array(
		'10' => '10',
		'11' => '11',
		'12' => '12',
		'13' => '13',
		'14' => '14',
		'15' => '15',
		'16' => '16',
		'16.5' => '16.5',
		'17' => '17',
		'18' => '18',
		'19' => '19',
		'19.5' => '19.5',
		'20' => '20',
		'21' => '21',
		'22' => '22',
		'24' => '24'
	);
	public $types = array();
	public function __construct() {
		parent::__construct();
		$this->virtualFields['is_deletable'] = 1;
		$this->types = array(
			'car' => __d('admin_prices', 'type_car'),
			'suv' => __d('admin_prices', 'type_suv')
		);
	}
}