<?php
class Administrator extends AppModel {
	public $name = 'Administrator';
	public $validationDomain = 'admin_administrators';
	public $validate = array(
		'username' => array(
			array(
				'rule' => 'notEmpty',
				'message' => 'error_username_empty',
				'last' => true,
				'required' => true
			),
			array(
				'rule' => 'isUnique',
				'message' => 'error_username_unique',
				'last' => true,
				'required' => true
			),
			array(
				'rule' => array('between', 4, 32),
				'message' => 'error_username_length',
				'last' => true,
				'required' => true
			),
			array(
				'rule' => '/^[A-z0-9_-]+$/',
				'message' => 'error_username_format',
				'last' => true,
				'required' => true
			)
		),
		'email' => array(
			array(
				'rule' => 'notEmpty',
				'message' => 'error_email_empty',
				'last' => true
			),
			array(
				'rule' => 'email',
				'message' => 'error_email_format',
				'last' => true
			),
			array(
				'rule' => 'isUnique',
				'message' => 'error_email_unique'
			)
		),
		'name' => array(
			array(
				'rule' => 'notEmpty',
				'message' => 'error_name_empty'
			)
		),
		'pswd' => array(
			array(
				'rule' => 'notEmpty',
				'message' => 'error_password_empty',
				'last' => true,
				'required' => true
			),
			array(
				'rule' => array('between', 4, 32),
				'message' => 'error_password_length',
				'last' => true,
				'required' => true
			)
		),
		'password_repeat' => array(
			array(
				'rule' => array('isIdentical', 'pswd'),
				'message' => 'error_password_repeat_empty',
				'required' => true
			)
		)
	);
	public $tmp_data = null;
	public function __construct() {
		parent::__construct();
	}
	public function beforeSave($options = array()) {
		if (parent::beforeSave()) {
			if (isset($this->data[$this->name]['pswd'])) {
				$this->data[$this->name]['password'] = Security::hash($this->data[$this->name]['pswd'], null, true);
			}
			return true;
		}
	}
	public function isIdentical($check, $compare_field = '') {
		list($value) = array_values($check);
		if ($value !== $this->data[$this->name][$compare_field]) {
			return false;
		}
		return true;
	}
	public function beforeValidate($options = array()) {
		if (isset($this->data[$this->name]['change_password'])) {
			if ($this->data[$this->name]['change_password'] == 0) {
				unset($this->validate['password_repeat']);
				unset($this->data[$this->name]['password_repeat']);
				unset($this->validate['pswd']);
				unset($this->data[$this->name]['pswd']);
			}
		}
	}
}