<?php
class UsedTyre extends AppModel {
	public $name = 'UsedTyre';
	public $validationDomain = 'admin_used_tyres';
	public $validate = array(
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
		)
	);
	public $belongsTo = array(
		'Photo' => array(
			'className' => 'UsedTyrePhoto',
			'foreignKey' => 'photo_id'
		)
	);
	public $seasons = array();
	public function __construct() {
		parent::__construct();
		$this->virtualFields['is_deletable'] = 1;
		$this->virtualFields['photo_id'] = 'Photo.id';
		$this->virtualFields['photo_filename'] = 'Photo.filename';
		$this->seasons = array(
			'summer' => __d('admin_used_tyres', 'season_summer'),
			'winter' => __d('admin_used_tyres', 'season_winter'),
			'all' => __d('admin_used_tyres', 'season_all')
		);
	}
	public function afterSave($created, $options = array()) {
		Cache::delete('used_tyre_size1', 'long');
		Cache::delete('used_tyre_size2', 'long');
		Cache::delete('used_tyre_size3', 'long');
	}
	public function afterDelete() {
		Cache::delete('used_tyre_size1', 'long');
		Cache::delete('used_tyre_size2', 'long');
		Cache::delete('used_tyre_size3', 'long');
		return true;
	}
	public function beforeDelete($cascade = true) {
		if (parent::beforeDelete()) {
			$data = $this->read(array('is_deletable'));
			if (!$data[$this->name]['is_deletable']) return false;
			return true;
		}
		return false;
	}
	public function beforeValidate($options = array()) {
		if (parent::beforeValidate()) {
			if (isset($this->data[$this->name]['brand']) && !empty($this->data[$this->name]['brand'])) {
				unset($this->validate['brand_id']);
			}
			if (isset($this->data[$this->name]['model']) && !empty($this->data[$this->name]['model'])) {
				unset($this->validate['model_id']);
			}
			return true;
		}
	}
	public function setDefaultPhoto($id) {
		$this->bindModel(
			array(
				'hasOne' => array(
					'UsedTyrePhoto' => array(
						'order' => array('UsedTyrePhoto.id' => 'asc')
					)
				)
			)
		);
		if ($item = $this->find('first', array('conditions' => array('UsedTyre.id' => $id), 'fields' => array('UsedTyrePhoto.id')))) {
			if (!empty($item['UsedTyrePhoto']['id'])) {
				$this->id = $id;
				$this->saveField('photo_id', $item['UsedTyrePhoto']['id']);
			}
		}
	}
}