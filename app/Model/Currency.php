<?php
class Currency extends AppModel {
	public $name = 'Currency';
	public $validationDomain = 'admin_currencies';
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'message' => 'error_title_empty'
		),
		'short_title' => array(
			'rule' => 'notEmpty',
			'message' => 'error_short_title_empty'
		),
		'rate' => array(
			array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'error_rate_empty',
				'last' => true
			),
			array(
				'rule' => array('comparison', '>', 0),
				'required' => true,
				'message' => 'error_rate_numeric'
			)
		)
	);
	public function __construct() {
		parent::__construct();
		$this->virtualFields['is_deletable'] = '0';
	}
	public function afterSave($created, $options = array()) {
		if (isset($this->data[$this->alias]['default']) && $this->data[$this->alias]['default']) {
			$this->updateAll(array($this->alias . '.default' => 0), array($this->alias . '.id !=' => $this->id));
		}
		if (isset($this->data[$this->alias]['cart']) && $this->data[$this->alias]['cart']) {
			$this->updateAll(array($this->alias . '.cart' => 0), array($this->alias . '.id !=' => $this->id));
		}
		if (isset($this->data[$this->alias]['storage']) && $this->data[$this->alias]['storage']) {
			$this->updateAll(array($this->alias . '.storage' => 0), array($this->alias . '.id !=' => $this->id));
		}
		Cache::delete('currencies', 'long');
	}
	public function beforeDelete($cascade = true) {
		if (parent::beforeDelete()) {
			$data = $this->read(array('is_deletable'));
			if (!$data[$this->name]['is_deletable']) return false;
			return true;
		}
		return false;
	}
	public function recountProducts($ids) {
		if (!is_array($ids)) $ids = array($ids);
		$this->Product = ClassRegistry::init('Product');
		foreach ($ids as $id) {
			$this->id = $id;
			if ($data = $this->read(array('id'))) {
				$products_count = $this->Product->find('count', array('conditions' => array('Product.brand_id' => $id)));
				$active_products_count = $this->Product->find('count', array('conditions' => array('Product.brand_id' => $id, 'Product.is_active' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0)));
				$this->save(array('products_count' => $products_count, 'active_products_count' => $active_products_count), false);
			}
		}
	}
	public function recountModels($ids) {
		if (!is_array($ids)) $ids = array($ids);
		$this->BrandModel = ClassRegistry::init('BrandModel');
		foreach ($ids as $id) {
			$this->id = $id;
			if ($data = $this->read(array('id'))) {
				$models_count = $this->BrandModel->find('count', array('conditions' => array('BrandModel.brand_id' => $id)));
				$active_models_count = $this->BrandModel->find('count', array('conditions' => array('BrandModel.brand_id' => $id, 'BrandModel.is_active' => 1)));
				$this->save(array('models_count' => $models_count, 'active_models_count' => $active_models_count), false);
			}
		}
	}
}