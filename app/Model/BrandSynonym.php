<?php
class BrandSynonym extends AppModel {
	public $name = 'BrandSynonym';
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'message' => 'error_title_empty'
		)
	);
}