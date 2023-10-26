<?php
class PricesController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'Price.sort_order' => 'asc'
		)
	);
	public $filter_fields = array('Price.id' => 'int', 'Price.title' => 'text', 'Price.time' => 'text', 'Price.price' => 'text', 'Price.type' => 'text');
	public $model = 'Price';
	public $submenu = 'prices';
	public function _list() {
		parent::_list();
		$this->loadModel('Currency');
		if ($currency = $this->Currency->find('first', array('conditions' => array('Currency.storage' => 1), 'fields' => array('Currency.short_title')))) {
			$storage_currency = trim(str_replace(array('{before}', '{after}', '{value}', '{between}'), '', $currency['Currency']['short_title']));
		}
		else {
			$storage_currency = 'руб.';
		}
		$this->set('storage_currency', $storage_currency);
		$this->set('types', $this->Price->types);
	}
	public function _edit($id) {
		$title = parent::_edit($id);
		$this->loadModel('Currency');
		if ($currency = $this->Currency->find('first', array('conditions' => array('Currency.storage' => 1), 'fields' => array('Currency.short_title')))) {
			$storage_currency = trim(str_replace(array('{before}', '{after}', '{value}', '{between}'), '', $currency['Currency']['short_title']));
		}
		else {
			$storage_currency = 'руб.';
		}
		$this->set('storage_currency', $storage_currency);
		$this->set('types', $this->Price->types);
		return $title;
	}
}