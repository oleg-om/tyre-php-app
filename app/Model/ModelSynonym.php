<?php
class ModelSynonym extends AppModel {
	public $name = 'ModelSynonym';
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'message' => 'error_title_empty'
		)
	);
}