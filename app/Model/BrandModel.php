<?php
class BrandModel extends AppModel {
	public $name = 'BrandModel';
	public $validationDomain = 'admin_models';
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'message' => 'error_title_empty'
		),
		'category_id' => array(
			array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'error_category_id_empty',
				'last' => true
			),
			array(
				'rule' => array('comparison', '>', 0),
				'required' => true,
				'message' => 'error_category_id_numeric'
			)
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
		)
	);
	public $seasons = array();
	public $materials = array();
	public $auto = array();
	public $files_path = null;
	public $allowed_file_types = array('image/pjpeg', 'image/jpeg', 'image/gif', 'image/bmp', 'image/png', 'image/x-png');
	public $tmp_file = null;
	public $tmp_ext = null;
	public $tmp_name = null;
	public $tmp_data = null;
	public function __construct() {
		parent::__construct();
		$this->auto = array(
			'cars' => __d('admin_tyres', 'auto_cars'),
			'trucks' => __d('admin_tyres', 'auto_trucks'),
			'light_trucks' => __d('admin_tyres', 'auto_light_trucks'),
			'special' => __d('admin_tyres', 'auto_special'),
            'loader' => __d('admin_tyres', 'auto_loader'),
			'agricultural' => __d('admin_tyres', 'auto_agricultural'),
			'moto' => __d('admin_tyres', 'auto_moto')
		);
		$this->seasons = array(
			'summer' => __d('admin_tyres', 'season_summer'),
			'winter' => __d('admin_tyres', 'season_winter'),
			'all' => __d('admin_tyres', 'season_all')
		);
		$this->materials = array(
			'steel' => __d('admin_disks', 'material_steel'),
			'cast' => __d('admin_disks', 'material_cast'),
			'forged' => __d('admin_disks', 'material_forged')
		);
		$this->virtualFields['is_deletable'] = 'BrandModel.products_count=0';
		$this->virtualFields['old_brand_id'] = 'BrandModel.brand_id';
		$this->files_path = WWW_ROOT . 'files' . DS . 'models';
	}
	function _getFolderById() {
		$id = $this->id;
		$folder = $this->files_path . DS . $id . DS;
		if (!is_dir($folder)) {
			mkdir($folder);
			chmod($folder, 0777);
		}
		return $folder;
	}
	public function beforeSave($options = array()) {
		if (parent::beforeSave()) {
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
		return false;
	}
	public function afterSave($created, $options = array()) {
		// Пропускаем пересчет счетчиков и удаление кеша во время импорта (для ускорения)
		$skip_after_save = Configure::read('Product.skip_recount_on_save');
		
		if (!$skip_after_save) {
			$fields = array('brand_id' => 'Brand');
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
					$this->{$model}->recountModels($ids);
				}
			}
		}
		
		if (isset($this->data[$this->name]['old_brand_id']) && isset($this->data[$this->name]['brand_id']) && $this->data[$this->name]['old_brand_id'] != $this->data[$this->name]['brand_id']) {
			$this->Product = ClassRegistry::init('Product');
			$this->Product->updateAll(array('brand_id' => $this->data[$this->name]['brand_id']), array('brand_id' => $this->data[$this->name]['old_brand_id'], 'model_id' => $this->id));
		}
		if ($this->tmp_file != null && !empty($this->id)) {
			$folder = $this->_getFolderById();
			$from = TMP . $this->tmp_file;
			$to = $folder . $this->tmp_name . '.' . $this->tmp_ext;
			if (is_dir($folder)) {
				if ($dh = opendir($folder)) {
					while ($file = readdir($dh)) {
						if ($file != '.' && $file != '..') {
							unlink($folder . $file);
						}
					}
					closedir($dh);
				}
			}
			if (file_exists($from)) {
				rename($from, $to);
				chmod($to, 0777);
			}
		}
		
		// Удаляем кеш только если не идет импорт (для ускорения импорта)
		// Во время импорта кеш будет очищен один раз в конце
		if (!$skip_after_save) {
			Cache::delete('brands_1', 'long');
			Cache::delete('brands_2', 'long');
			Cache::delete('brands_3', 'long');
			Cache::delete('import_models_1', 'long');
			Cache::delete('import_models_2', 'long');
			Cache::delete('import_models_by_id_1', 'long');
			Cache::delete('import_models_by_id_2', 'long');
		}
	}
	public function afterDelete() {
		if (!empty($this->tmp_data)) {
			$fields = array('brand_id' => 'Brand');
			foreach ($fields as $field => $model) {
				if (isset($this->tmp_data[$this->name][$field]) && $this->tmp_data[$this->name][$field] != 0) {
					$this->{$model} = ClassRegistry::init($model);
					$this->{$model}->recountModels($this->tmp_data[$this->name][$field]);
				}	
			}
		}
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
		Cache::delete('brands_1', 'long');
		Cache::delete('brands_2', 'long');
		Cache::delete('brands_3', 'long');
		Cache::delete('import_models_1', 'long');
		Cache::delete('import_models_2', 'long');
		Cache::delete('import_models_by_id_1', 'long');
		Cache::delete('import_models_by_id_2', 'long');
		return true;
	}
	public function beforeDelete($cascade = true) {
		if (parent::beforeDelete()) {
			$this->tmp_data = $this->read(array('is_deletable', 'brand_id'));
			if (!$this->tmp_data[$this->name]['is_deletable']) return false;
			return true;
		}
		return false;
	}
	public function recountProducts($ids) {
		if (!is_array($ids)) $ids = array($ids);
		if (empty($ids)) return;
		
		$this->Product = ClassRegistry::init('Product');
		
		// Оптимизация: используем один запрос для всех моделей вместо отдельных запросов
		$ids_str = implode(',', array_map('intval', $ids));
		
		// Получаем все счетчики одним запросом
		$results = $this->Product->query("
			SELECT 
				model_id,
				COUNT(*) as products_count,
				SUM(CASE WHEN is_active = 1 AND price > 0 THEN 1 ELSE 0 END) as active_products_count,
				MAX(CASE WHEN in_stock = 1 THEN 1 ELSE 0 END) as products_in_stock
			FROM products
			WHERE model_id IN ({$ids_str})
			GROUP BY model_id
		");
		
		// Обновляем каждую модель
		foreach ($ids as $id) {
			$found = false;
			foreach ($results as $result) {
				// Безопасный доступ к результату запроса (CakePHP может возвращать разные форматы)
				$model_id = isset($result[0]['model_id']) ? $result[0]['model_id'] : (isset($result['model_id']) ? $result['model_id'] : null);
				if ($model_id == $id) {
					$products_count = isset($result[0]['products_count']) ? $result[0]['products_count'] : (isset($result['products_count']) ? $result['products_count'] : 0);
					$active_products_count = isset($result[0]['active_products_count']) ? $result[0]['active_products_count'] : (isset($result['active_products_count']) ? $result['active_products_count'] : 0);
					$products_in_stock = isset($result[0]['products_in_stock']) ? $result[0]['products_in_stock'] : (isset($result['products_in_stock']) ? $result['products_in_stock'] : 0);
					
					$this->id = $id;
					$this->save(array(
						'products_count' => $products_count,
						'active_products_count' => $active_products_count,
						'products_in_stock' => $products_in_stock
					), false);
					$found = true;
					break;
				}
			}
			// Если модель не найдена в результатах, значит у неё 0 продуктов
			if (!$found) {
				$this->id = $id;
				if ($data = $this->read(array('id'))) {
					$this->save(array(
						'products_count' => 0,
						'active_products_count' => 0,
						'products_in_stock' => 0
					), false);
				}
			}
		}
	}
}