<?php
class Template extends AppModel {
	public $name = 'Template';
	public $validationDomain = 'admin_templates';
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'message' => 'error_title_empty'
		),
		'subject' => array(
			'rule' => 'notEmpty',
			'message' => 'error_subject_empty'
		)
	);
	public function __construct() {
		parent::__construct();
		$this->virtualFields['is_deletable'] = '0';
	}
	public function beforeDelete($cascade = true) {
		if (parent::beforeDelete()) {
			$data = $this->read(array('is_deletable'));
			if (!$data[$this->name]['is_deletable']) return false;
			return true;
		}
		return false;
	}
	public function get($key) {
		return $this->find('first', array('conditions' => array('Template.key' => $key)));
	}
}