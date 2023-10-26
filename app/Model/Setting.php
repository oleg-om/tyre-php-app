<?php
class Setting extends AppModel {
	public $name = 'Setting';

	public function get() {
		return $this->find('list', array('fields' => array('variable', 'value')));
	}
	
	public function afterSave($created, $options = array()) {
		Cache::delete('settings', 'long');
	}
}