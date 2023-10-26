<?php
class SuppliersController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'Supplier.title' => 'asc'
		)
	);
	public $filter_fields = array('Supplier.id' => 'int', 'Supplier.title' => 'text');
	public $model = 'Supplier';
	public $submenu = 'suppliers';
}