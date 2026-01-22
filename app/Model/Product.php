<?php
class Product extends AppModel {
	public $name = 'Product';
	public $validationDomain = 'admin_products';
	public $validate = array(
		'sku' => array(
			'rule' => 'notEmpty',
			'message' => 'error_sku_empty'
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
		'type' => array(
			array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'error_type_empty',
				'last' => true
			),
			array(
				'rule' => array('inList', array('car_tube', 'moto_tube', 'flap')),
				'required' => true,
				'message' => 'error_type_list'
			)
		),
	);
	public $tmp_data = null;
	public $seasons = array();
	public $types = array();
	public $bolt_types = array();
	public $auto = array();
	public $stud = array();
	public $files_path = null;
	public $allowed_file_types = array('image/pjpeg', 'image/jpeg', 'image/gif', 'image/bmp', 'image/png', 'image/x-png');
	public $tmp_file = null;
	public $tmp_ext = null;
	public $tmp_name = null;
	public function __construct() {
		parent::__construct();
		$this->virtualFields['is_deletable'] = 1;
		$this->virtualFields['old_brand_id'] = 'Product.brand_id';
		$this->virtualFields['old_model_id'] = 'Product.model_id';
		$this->seasons = array(
			'summer' => __d('admin_tyres', 'season_summer'),
			'winter' => __d('admin_tyres', 'season_winter'),
			'all' => __d('admin_tyres', 'season_all')
		);
		$this->stud = array(
			0 => __d('admin_tyres', 'stud_0'),
			1 => __d('admin_tyres', 'stud_1'),
			2 => __d('admin_tyres', 'stud_2')
		);
		$this->auto = array(
			'cars' => __d('admin_tyres', 'auto_cars'),
            'light_trucks' => __d('admin_tyres', 'auto_light_trucks'),
			'trucks' => __d('admin_tyres', 'auto_trucks'),
			'agricultural' => __d('admin_tyres', 'auto_agricultural'),
            'special' => __d('admin_tyres', 'auto_special'),
            'loader' => __d('admin_tyres', 'auto_loader'),
			'moto' => __d('admin_tyres', 'auto_moto')
		);
		$this->types = array(
			'car_tube' => __d('admin_tyres', 'type_car_tube'),
			'moto_tube' => __d('admin_tyres', 'type_moto_tube'),
			'flap' => __d('admin_tyres', 'type_flap')
		);
		$this->bolt_types = array(
			'bolt' => __d('admin_bolts', 'type_bolt'),
			'nut' => __d('admin_bolts', 'type_nut'),
			'ring' => __d('admin_bolts', 'type_ring'),
			'valve' => __d('admin_bolts', 'type_valve')
		);
		$this->files_path = WWW_ROOT . 'files' . DS . 'akb';
	}
	function _getFolderById() {
		$id = $this->id;
		if (isset($this->data[$this->name]['category_id']) && $this->data[$this->name]['category_id'] == 4) {
			$this->files_path = WWW_ROOT . 'files' . DS . 'tubes';
		}

        if (isset($this->data[$this->name]['category_id']) && $this->data[$this->name]['category_id'] == 3) {
            $id = 'akb_images';
        }

		$folder = $this->files_path . DS . $id . DS;

		if (!is_dir($folder)) {
			mkdir($folder);
			chmod($folder, 0777);
		}
		return $folder;
	}
	public function beforeValidate($options = array()) {
		if (parent::beforeValidate()) {
			if (isset($this->data[$this->name]['category_id'])) {
				if ($this->data[$this->name]['category_id'] == 3) {
					unset($this->validate['sku']);
				}
				if ($this->data[$this->name]['category_id'] == 4) {
					unset($this->validate['brand_id']);
					unset($this->validate['model_id']);
				}
				elseif ($this->data[$this->name]['category_id'] == 5) {
					unset($this->validate['brand_id']);
					unset($this->validate['model_id']);
					unset($this->validate['type']);
					unset($this->validate['sku']);
				}
				else {
					unset($this->validate['type']);
				}
			}
			return true;
		}
	}
	public function beforeSave($options = array()) {
		if (parent::beforeSave()) {
			if (isset($this->data[$this->name]['category_id']) && $this->data[$this->name]['category_id'] == 1) {
				if (isset($this->data[$this->name]['size3'])) {
					$this->data[$this->name]['size3'] = str_replace('С', 'C', $this->data[$this->name]['size3']);
				}
			}
			if (isset($this->data[$this->name]['category_id']) && $this->data[$this->name]['category_id'] == 5) {
				$this->files_path = WWW_ROOT . 'files' . DS . 'bolts';
			}
			$uploaded_image = false;
			$error_message = null;
			if (isset($this->data[$this->name]['delete_file']) && $this->data[$this->name]['delete_file']) {
				$this->data[$this->name]['filename'] = '';
			}
			if (isset($this->data[$this->name]['file']['tmp_name']) && $this->data[$this->name]['file']['tmp_name'] != '') {
				$this->tmp_file = md5(uniqid(rand(), true));
				$this->tmp_name = time();
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
	}
	public function afterSave($created, $options = array()) {
		$fields = array('brand_id' => 'Brand', 'model_id' => 'BrandModel');
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
				$this->{$model}->recountProducts($ids);
			}
		}
		if ($this->tmp_file != null) {
			$folder = $this->_getFolderById();
			$from = TMP . $this->tmp_file;
			$to = $folder . $this->tmp_name . '.' . $this->tmp_ext;
			if ($dh = opendir($folder) && $this->id != 3) {
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

        if (!empty($this->data[$this->name]['model_id'])) {
            $this->BrandModel = ClassRegistry::init('BrandModel');
            $model_id = $this->data[$this->name]['model_id'];

            $brand_model = $this->BrandModel->find('first', array('conditions' => array('BrandModel.id' => $model_id)));
            $existing_file_names = explode('|', $brand_model['BrandModel']['extra_filenames']);

            $file_names_array = array();

            $new_file_params = intval($this->data[$this->name]['ah']) . '-' . $this->data[$this->name]['f2'] . '-' . $this->data[$this->name]['width'] . '-' . $this->data[$this->name]['height'] . '-' . $this->data[$this->name]['length'] . '-' . intval($this->data[$this->name]['current']) . '-' . $this->data[$this->name]['f1'];
            $new_file_path = $this->data[$this->name]['filename'];

            if ($existing_file_names != '' && !empty($existing_file_names)) {
                foreach ($existing_file_names as $key => $img) {
                    list($akb_params, $img_file) = explode(':', $img);
                    if (!empty($akb_params)) {
                        $file_names_array[$akb_params] = $img_file;
                    }
                }
            }
            $file_names_array[$new_file_params] = $new_file_path;

            foreach ($file_names_array as $params => $img) {
                if (!empty($img)) {
                    list($ah_value, $f2_value, $width_value, $height_value, $length_value, $current_value, $f1_value) = explode('-', $params);
                    $akb_params = $ah_value . '-' . $f2_value . '-' . $width_value . '-' . $height_value . '-' . $length_value . '-' . intval($current_value) . '-' . $f1_value;

                    if (empty($width_value) && empty($height_value) && empty($length_value) && empty($current_value)) {
                        $akb_params = $ah_value . '-' . $f2_value;
                    }

                    $file_names_array[$akb_params] = $akb_params . ':' . $img;
                }
            }
            $file_names_array = array_filter($file_names_array);

            if (!empty($file_names_array)) {
                $update_data = array('BrandModel' => array('id' => $model_id, 'extra_filenames' => implode('|', $file_names_array)));
                $this->BrandModel->save($update_data, false);
            }

        }

		Cache::delete('brands_1', 'long');
		Cache::delete('brands_2', 'long');
		Cache::delete('brands_3', 'long');
		Cache::delete('akb_ah', 'long');
		Cache::delete('akb_current', 'long');
		Cache::delete('akb_height', 'long');
		Cache::delete('akb_length', 'long');
		Cache::delete('akb_width', 'long');
		Cache::delete('disk_size1', 'long');
		Cache::delete('disk_size2', 'long');
		Cache::delete('tyre_axis', 'long');
		Cache::delete('tyre_size1', 'long');
		Cache::delete('tyre_size2', 'long');
		Cache::delete('tyre_size3', 'long');
	}
	public function afterDelete() {
		if (!empty($this->tmp_data)) {
			$fields = array('brand_id' => 'Brand', 'model_id' => 'BrandModel');
			foreach ($fields as $field => $model) {
				if (isset($this->tmp_data[$this->name][$field]) && $this->tmp_data[$this->name][$field] != 0) {
					$this->{$model} = ClassRegistry::init($model);
					$this->{$model}->recountProducts($this->tmp_data[$this->name][$field]);
				}	
			}
		}
		$folder = $this->_getFolderById();
//		if ($dh = opendir($folder)) {
//			while ($file = readdir($dh)) {
//				if ($file != '.' && $file != '..') {
//					unlink($folder . $file);
//				}
//			}
//			closedir($dh);
//		}
//		rmdir($folder);
		Cache::delete('brands_1', 'long');
		Cache::delete('brands_2', 'long');
		Cache::delete('brands_3', 'long');
		Cache::delete('akb_ah', 'long');
		Cache::delete('akb_current', 'long');
		Cache::delete('akb_height', 'long');
		Cache::delete('akb_length', 'long');
		Cache::delete('akb_width', 'long');
		Cache::delete('disk_size1', 'long');
		Cache::delete('disk_size2', 'long');
		Cache::delete('tyre_axis', 'long');
		Cache::delete('tyre_size1', 'long');
		Cache::delete('tyre_size2', 'long');
		Cache::delete('tyre_size3', 'long');
		return true;
	}
	public function beforeDelete($cascade = true) {
		if (parent::beforeDelete()) {
			$this->tmp_data = $this->read(array('is_deletable', 'category_id', 'brand_id', 'model_id'));
			if (isset($this->tmp_data[$this->name]['category_id'])) {
				if ($this->tmp_data[$this->name]['category_id'] == 1) {
					$this->files_path = WWW_ROOT . 'files' . DS . 'tyres';
				}
				elseif ($this->tmp_data[$this->name]['category_id'] == 2) {
					$this->files_path = WWW_ROOT . 'files' . DS . 'disks';
				}
				elseif ($this->tmp_data[$this->name]['category_id'] == 3) {
					$this->files_path = WWW_ROOT . 'files' . DS . 'akb';
				}
			}
			if (!$this->tmp_data[$this->name]['is_deletable']) return false;
			return true;
		}
		return false;
	}
}