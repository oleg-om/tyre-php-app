<?php
class CurrenciesController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'Currency.sort_order' => 'asc'
		)
	);
	public $filter_fields = array();
	public $model = 'Currency';
	public $submenu = 'currencies';
}