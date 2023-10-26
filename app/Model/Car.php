<?php
class Car extends AppModel {
	public $name = 'Car';
	public $validationDomain = 'admin_cars';
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'message' => 'error_title_empty'
		),
		'brand_id' => array(
			array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'error_brand_id_empty',
				'last' => true
			),
			array(
				'rule' => array('comparison', '>', 0),
				'required' => true,
				'message' => 'error_brand_id_numeric'
			)
		),
		'model_id' => array(
			array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'error_model_id_empty',
				'last' => true
			),
			array(
				'rule' => array('comparison', '>', 0),
				'required' => true,
				'message' => 'error_model_id_numeric'
			)
		),
		'modification_id' => array(
			array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'error_modification_id_empty',
				'last' => true
			),
			array(
				'rule' => array('comparison', '>', 0),
				'required' => true,
				'message' => 'error_modification_id_numeric'
			)
		),
		'year' => array(
			'rule' => 'notEmpty',
			'message' => 'error_slug_empty',
			'required' => true
		)
	);
	public function __construct() {
		parent::__construct();
		$this->virtualFields['is_deletable'] = 1;
		$this->virtualFields['old_brand_id'] = 'Car.brand_id';
		$this->virtualFields['old_model_id'] = 'Car.model_id';
		$this->virtualFields['old_modification_id'] = 'Car.modification_id';
	}
	public function afterSave($created, $options = array()) {
		$fields = array('brand_id' => 'CarBrand', 'model_id' => 'CarModel', 'modification_id' => 'CarModification');
		foreach ($fields as $field => $model) {
			$ids = array();
			if (isset($this->data[$this->name]['old_' . $field]) && $this->data[$this->name]['old_' . $field] > 0) {
				$ids[] = $this->data[$this->name]['old_' . $field];
			}
			if (isset($this->data[$this->name][$field]) && $this->data[$this->name][$field] > 0) {
				$ids[] = $this->data[$this->name][$field];
			}
			if (!empty($ids)) {
				$ids = array_unique($ids);
				$this->{$model} = ClassRegistry::init($model);
				$this->{$model}->recountCars($ids);
			}
		}
	}
	public function afterDelete() {
		if (!empty($this->tmp_data)) {
			$fields = array('brand_id' => 'CarBrand', 'model_id' => 'CarModel', 'modification_id' => 'CarModification');
			foreach ($fields as $field => $model) {
				if (isset($this->tmp_data[$this->name][$field]) && $this->tmp_data[$this->name][$field] != 0) {
					$this->{$model} = ClassRegistry::init($model);
					$this->{$model}->recountCars($this->tmp_data[$this->name][$field]);
				}	
			}
		}
		return true;
	}
	public function beforeDelete($cascade = true) {
		if (parent::beforeDelete()) {
			$this->tmp_data = $this->read(array('is_deletable', 'brand_id', 'model_id', 'modification_id'));
			if (!$this->tmp_data[$this->name]['is_deletable']) return false;
			return true;
		}
		return false;
	}
}