<?php
class Supplier extends AppModel {
	public $name = 'Supplier';
	public $validationDomain = 'admin_suppliers';
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'message' => 'error_title_empty'
		)
	);
	public function __construct() {
		parent::__construct();
		$this->virtualFields['is_deletable'] = 1;
	}
}