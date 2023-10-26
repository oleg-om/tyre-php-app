<?php
class Page extends AppModel {
	public $name = 'Page';
	public $validationDomain = 'admin_pages';
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'message' => 'error_title_empty'
		),
		'slug' => array(
			array(
				'rule' => 'notEmpty',
				'message' => 'error_slug_empty',
				'last' => true
			),
			array(
				'rule' => '/^[A-z0-9_-]+$/',
				'message' => 'error_slug_format',
				'last' => true
			),
			array(
				'rule' => 'isUnique',
				'message' => 'error_slug_unique'
			)
		)
	);
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