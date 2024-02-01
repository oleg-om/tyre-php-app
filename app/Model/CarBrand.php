<?php
class CarBrand extends AppModel {
	public $name = 'CarBrand';
	public $validationDomain = 'admin_car_brands';
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
			),
			array(
				'rule' => 'isUnique',
				'message' => 'error_slug_unique',
				'required' => true
			)
		)
	);
	public $files_path = null;
	public $allowed_file_types = array('image/pjpeg', 'image/jpeg', 'image/gif', 'image/bmp', 'image/png', 'image/x-png');
	public $tmp_file = null;
	public $tmp_ext = null;
	public $tmp_name = null;
	public function __construct() {
		parent::__construct();
		$this->virtualFields['is_deletable'] = 'CarBrand.items_count=0';
		$this->files_path = IMAGES . 'car_brands';
	}
	function _getFolderById() {
		$id = $this->id;
		$folder = $this->files_path . DS;
		return $folder;
	}
	public function beforeSave($options = array()) {
		if (parent::beforeSave()) {
			$uploaded_image = false;
			$error_message = null;
			if (isset($this->data[$this->name]['file']['tmp_name']) && $this->data[$this->name]['file']['tmp_name'] != '') {
				$this->tmp_file = md5(uniqid(rand(), true));
				$this->tmp_name = $this->data[$this->name]['slug'];
				if (in_array($this->data[$this->name]['file']['type'], $this->allowed_file_types)) {
					if (copy($this->data[$this->name]['file']['tmp_name'], TMP . $this->tmp_file)) {
						if ($size = getimagesize(TMP . $this->tmp_file)) {
							$uploaded_image = true;
							switch ($size[2]) {
								case 1:
									$this->tmp_ext = 'gif';
									break;
								case 2:
									$this->tmp_ext = 'jpg';
									break;
								case 3:
									$this->tmp_ext = 'png';
									break;
								case 6:
									$this->tmp_ext = 'bmp';
									break;
								default:
									$error_message = 'file_type';
									$uploaded_image = false;
							}
						}
						else {
							$error_message = 'error_file_corrupted';
						}
					}
					else {
						$error_message = 'error_file_upload';
					}
				}
				else {
					$error_message = 'error_file_format';
				}
			}
			if ($uploaded_image) {
				$this->data[$this->name]['filename'] = $this->tmp_name . '.' . $this->tmp_ext;
				unset($this->data[$this->name]['file']);
			}
			elseif (!is_null($error_message)) {
				$this->invalidate('file', __d($this->validationDomain, $error_message));
				return false;
			}
			return true;
		}
		return false;
	}
	public function afterSave($created, $options = array()) {
		if ($this->tmp_file != null) {
			$folder = $this->_getFolderById();
			$from = TMP . $this->tmp_file;
			$to = $folder . $this->tmp_name . '.' . $this->tmp_ext;
			if ($dh = opendir($folder)) {
				while ($file = readdir($dh)) {
					if ($file != '.' && $file != '..') {
						unlink($folder . $file);
					}
				}
				closedir($dh);
			}
			rename($from, $to);
			chmod($to, 0777);
		}
	}
	public function afterDelete() {
		$folder = $this->_getFolderById();
		if ($dh = opendir($folder)) {
			while ($file = readdir($dh)) {
				if ($file != '.' && $file != '..') {
					unlink($folder . $file);
				}
			}
			closedir($dh);
		}
		rmdir($folder);
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
	public function recountCars($ids) {
		if (!is_array($ids)) $ids = array($ids);
		$this->Car = ClassRegistry::init('Car');
		foreach ($ids as $id) {
			$this->id = $id;
			if ($data = $this->read(array('id'))) {
				$cars_count = $this->Car->find('count', array('conditions' => array('Car.brand_id' => $id)));
				$active_cars_count = $this->Car->find('count', array('conditions' => array('Car.brand_id' => $id, 'Car.is_active' => 1)));
				$this->save(array('cars_count' => $cars_count, 'active_cars_count' => $active_cars_count), false);
			}
		}
	}
	public function recountModels($ids) {
		if (!is_array($ids)) $ids = array($ids);
		$this->CarModel = ClassRegistry::init('CarModel');
		foreach ($ids as $id) {
			$this->id = $id;
			if ($data = $this->read(array('id'))) {
				$models_count = $this->CarModel->find('count', array('conditions' => array('CarModel.brand_slug' => $id)));
				$active_models_count = $this->CarModel->find('count', array('conditions' => array('CarModel.brand_slug' => $id, 'CarModel.is_active' => 1)));
				$this->save(array('models_count' => $models_count, 'active_models_count' => $active_models_count), false);
			}
		}
	}
}