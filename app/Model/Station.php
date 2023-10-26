<?php
class Station extends AppModel {
	public $name = 'Station';
	public $validationDomain = 'admin_stations';
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'message' => 'error_title_empty'
		),
		'phone' => array(
			'rule' => 'notEmpty',
			'message' => 'error_phone_empty'
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
		),
		'places' => array(
			array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'error_places_empty',
				'last' => true
			),
			array(
				'rule' => array('comparison', '>', 0),
				'required' => true,
				'message' => 'error_places_numeric'
			)
		)
	);
	public function __construct() {
		parent::__construct();
		$this->virtualFields['is_deletable'] = 1;
	}
}