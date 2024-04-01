<?php
class Import extends AppModel {
	public $name = 'Import';
	public $useTable = false;
	public $validationDomain = 'admin_import';
	public $validate = array(
		'type' => array(
			array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'error_type_empty',
				'last' => true
			),
			array(
				'rule' => array('comparison', '>', 0),
				'required' => true,
				'message' => 'error_type_numeric'
			)
		)
	);
	public $tmp_file = null;
	public $types = array();
	public function __construct() {
		parent::__construct();
		$this->types = array(
			1 => __d('admin_import', 'type_1'),
            9 => __d('admin_import', 'type_9'),
			2 => __d('admin_import', 'type_2'),
            8 => __d('admin_import', 'type_8'),
            11 => __d('admin_import', 'type_11'),
			3 => __d('admin_import', 'type_3'),
			4 => __d('admin_import', 'type_4'),
			5 => __d('admin_import', 'type_5'),
			6 => __d('admin_import', 'type_6'),
            10 => __d('admin_import', 'type_10'),
			7 => __d('admin_import', 'type_7')
		);
	}
	public function beforeValidate($options = array()) {
		if (parent::beforeValidate()) {
			$uploaded_file = false;
			$error_message = null;
			if (isset($this->data[$this->name]['file']['tmp_name']) && $this->data[$this->name]['file']['tmp_name'] != '') {
				$this->tmp_file = md5(uniqid(rand(), true));
				$this->tmp_name = time();
				if (copy($this->data[$this->name]['file']['tmp_name'], TMP . $this->tmp_file)) {
					$uploaded_file = true;
				}
				else {
					$error_message = 'error_file_upload';
				}
			}
			elseif (isset($this->data[$this->name]['file']['error']) && $this->data[$this->name]['file']['error'] > 0 && $this->data[$this->name]['file']['error'] != 4) {
				$error_message = 'error_file_size';
			}
			else {
				$error_message = 'error_file_empty';
			}
			if (!$uploaded_file) {
				$this->invalidate('file', __d('admin_import', $error_message));
				return false;
			}
			return true;
		}
		return false;
	}
}