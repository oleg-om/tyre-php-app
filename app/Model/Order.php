<?php
class Order extends AppModel {
	public $name = 'Order';
	public $validationDomain = 'admin_orders';
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'message' => 'error_name_empty',
			'required' => true
		),
		'phone' => array(
			'rule' => 'notEmpty',
			'message' => 'error_phone_empty',
			'required' => true
		),
		'email' => array(
			'rule' => 'email',
			'message' => 'error_email_format',
			'allowEmpty' => true
		),
		'payment_type_id' => array(
			array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'error_payment_type_id_empty',
				'last' => true
			),
			array(
				'rule' => array('comparison', '>', 0),
				'required' => true,
				'message' => 'error_payment_type_id_numeric'
			)
		),
		'shipping_method_id' => array(
			array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'error_shipping_method_id_empty',
				'last' => true
			),
			array(
				'rule' => array('comparison', '>', 0),
				'required' => true,
				'message' => 'error_shipping_method_id_numeric'
			)
		),
		'shipping_type_id' => array(
			array(
				'rule' => 'notEmpty',
				'allowEmpty' => true,
				'message' => 'error_shipping_type_id_empty',
				'last' => true
			),
			array(
				'rule' => array('comparison', '>', 0),
				'allowEmpty' => true,
				'message' => 'error_shipping_type_id_numeric'
			)
		)
	);
	public $hasMany = array(
		'OrderProduct' => array(
			'order' => array(
				'OrderProduct.id' => 'asc'
			),
			'dependent' => true
		),
		'OrderEvent' => array(
			'order' => array(
				'OrderEvent.created' => 'desc'
			),
			'dependent' => true
		)
	);
	public $belongsTo = array(
		'Currency'
	);
	public function __construct() {
		parent::__construct();
		$this->virtualFields['is_deletable'] = 1;
		$this->virtualFields['currency_template'] = 'Currency.short_title';
		$this->virtualFields['round'] = 'Currency.round';
		$this->virtualFields['decimals'] = 'Currency.decimals';
		$this->virtualFields['round_down'] = 'Currency.round_down';
	}
	public function beforeValidate($options = array()) {
		if (isset($this->data[$this->name]['shipping_method_id']) && $this->data[$this->name]['shipping_method_id'] == 1) {
			$this->validate['region_id'] = array(
				array(
					'rule' => 'notEmpty',
					'message' => 'error_region_id_empty',
					'last' => true
				),
				array(
					'rule' => array('comparison', '>', 0),
					'message' => 'error_region_id_numeric'
				)
			);
			$this->validate['city_id'] = array(
				array(
					'rule' => 'notEmpty',
					'message' => 'error_city_id_empty',
					'last' => true
				),
				array(
					'rule' => array('comparison', '>', 0),
					'message' => 'error_city_id_numeric'
				)
			);
			$this->validate['store_id'] = array(
				array(
					'rule' => 'notEmpty',
					'message' => 'error_store_id_empty',
					'last' => true
				),
				array(
					'rule' => array('comparison', '>', 0),
					'message' => 'error_store_id_numeric'
				)
			);
		}
	}
	public function beforeSave($options = array()) {
		if (parent::beforeSave()) {
			unset($this->data[$this->name]['is_deletable']);
			return true;
		}
		return false;
	}
	public function beforeDelete($cascade = true) {
		if (parent::beforeDelete()) {
			$data = $this->read(array('is_deletable'));
			if (!$data[$this->name]['is_deletable']) return false;
			return true;
		}
		return false;
	}
}