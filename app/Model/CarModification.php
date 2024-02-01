<?php
class CarModification extends AppModel {
	public $name = 'CarModification';
	public $validationDomain = 'admin_car_modifications';
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'message' => 'error_title_empty'
		),
		'slug' => array(
			array(
				'rule' => 'notEmpty',
				'message' => 'error_slug_empty',
				'last' => true,
				'required' => true
			),
			array(
				'rule' => '/^[A-z0-9_-]+$/',
				'message' => 'error_slug_format',
				'last' => true,
				'required' => true
			)
		),
        'generation_slug' => array(
            array(
                'rule' => 'notEmpty',
                'message' => 'error_slug_empty',
                'last' => true,
                'required' => true
            ),
            array(
                'rule' => '/^[A-z0-9_-]+$/',
                'message' => 'error_slug_format',
                'last' => true,
                'required' => true
            )
        )
	);
	public function __construct() {
		parent::__construct();
//		$this->virtualFields['is_deletable'] = 'CarModification.cars_count=0';
//		$this->virtualFields['old_model_id'] = 'CarModification.model_id';
	}
	public function afterSave($created, $options = array()) {
		$fields = array('model_id' => 'CarModel');
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
				$this->{$model}->recountModifications($ids);
			}
		}
	}
	public function afterDelete() {
		if (!empty($this->tmp_data)) {
			$fields = array('model_id' => 'CarModel');
			foreach ($fields as $field => $model) {
				if (isset($this->tmp_data[$this->name][$field]) && $this->tmp_data[$this->name][$field] != 0) {
					$this->{$model} = ClassRegistry::init($model);
					$this->{$model}->recountModifications($this->tmp_data[$this->name][$field]);
				}	
			}
		}
		return true;
	}
	public function beforeDelete($cascade = true) {
		if (parent::beforeDelete()) {
			$this->tmp_data = $this->read(array('is_deletable', 'model_id'));
			if (!$this->tmp_data[$this->name]['is_deletable']) return false;
			return true;
		}
		return false;
	}
	public function recountCars($ids) {
//		if (!is_array($ids)) $ids = array($ids);
//		$this->Car = ClassRegistry::init('Car');
//		foreach ($ids as $id) {
//			$this->id = $id;
//			if ($data = $this->read(array('id'))) {
//				$cars_count = $this->Car->find('count', array('conditions' => array('Car.modification_id' => $id)));
//				$active_cars_count = $this->Car->find('count', array('conditions' => array('Car.modification_id' => $id, 'Car.is_active' => 1)));
//				$this->save(array('cars_count' => $cars_count, 'active_cars_count' => $active_cars_count), false);
//			}
//		}
	}
}