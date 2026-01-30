<?php
class Brand extends AppModel {
	public $name = 'Brand';
	public $validationDomain = 'admin_brands';
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
		)
	);
	public $files_path = null;
	public $allowed_file_types = array('image/pjpeg', 'image/jpeg', 'image/gif', 'image/bmp', 'image/png', 'image/x-png');
	public $tmp_file = null;
	public $tmp_ext = null;
	public $tmp_name = null;
	public function __construct() {
		parent::__construct();
		$this->virtualFields['is_deletable'] = 'Brand.products_count=0 AND Brand.models_count=0';
		$this->files_path = WWW_ROOT . 'files' . DS . 'brands';
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
		Cache::delete('brands_1', 'long');
		Cache::delete('brands_2', 'long');
		Cache::delete('brands_3', 'long');
		Cache::delete('import_brands_1', 'long');
		Cache::delete('import_brands_2', 'long');
		Cache::delete('import_brands_by_id_1', 'long');
		Cache::delete('import_brands_by_id_2', 'long');
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
		Cache::delete('brands_1', 'long');
		Cache::delete('brands_2', 'long');
		Cache::delete('brands_3', 'long');
		Cache::delete('import_brands_1', 'long');
		Cache::delete('import_brands_2', 'long');
		Cache::delete('import_brands_by_id_1', 'long');
		Cache::delete('import_brands_by_id_2', 'long');
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
	public function recountProducts($ids) {
		if (!is_array($ids)) $ids = array($ids);
		if (empty($ids)) return;
		
		$this->Product = ClassRegistry::init('Product');
		$db = $this->getDataSource();
		
		// Оптимизация: используем один запрос для всех брендов вместо отдельных запросов
		$ids_str = implode(',', array_map('intval', $ids));
		
		// Получаем все счетчики одним запросом
		$sql = "
			SELECT 
				brand_id,
				COUNT(*) as products_count,
				SUM(CASE WHEN is_active = 1 AND price > 0 THEN 1 ELSE 0 END) as active_products_count
			FROM products
			WHERE brand_id IN ({$ids_str})
			GROUP BY brand_id
		";
		
		$results = $db->fetchAll($sql);
		
		// Создаем массив для быстрого поиска по brand_id
		$counts_by_brand = array();
		foreach ($results as $result) {
			// fetchAll() возвращает результаты в формате:
			// $result['table_name']['field_name'] для обычных полей
			// $result[0]['field_name'] для агрегатных функций
			$brand_id = isset($result['products']['brand_id']) ? intval($result['products']['brand_id']) : null;
			$products_count = isset($result[0]['products_count']) ? intval($result[0]['products_count']) : 0;
			$active_products_count = isset($result[0]['active_products_count']) ? intval($result[0]['active_products_count']) : 0;
			
			if ($brand_id !== null) {
				$counts_by_brand[$brand_id] = array(
					'products_count' => $products_count,
					'active_products_count' => $active_products_count
				);
			}
		}
		
		// Обновляем каждый бренд используя прямой SQL запрос
		foreach ($ids as $id) {
			$id = intval($id);
			if (isset($counts_by_brand[$id])) {
				$counts = $counts_by_brand[$id];
				$sql = "
					UPDATE brands 
					SET products_count = " . intval($counts['products_count']) . ",
						active_products_count = " . intval($counts['active_products_count']) . "
					WHERE id = " . $id;
			} else {
				// Если бренд не найден в результатах, значит у него 0 продуктов
				$sql = "
					UPDATE brands 
					SET products_count = 0,
						active_products_count = 0
					WHERE id = " . $id;
			}
			$db->execute($sql);
		}
	}
	public function recountModels($ids) {
		if (!is_array($ids)) $ids = array($ids);
		if (empty($ids)) return;
		
		$this->BrandModel = ClassRegistry::init('BrandModel');
		$db = $this->getDataSource();
		
		// Оптимизация: используем один запрос для всех брендов вместо отдельных запросов
		$ids_str = implode(',', array_map('intval', $ids));
		
		// Получаем все счетчики одним запросом
		$sql = "
			SELECT 
				brand_id,
				COUNT(*) as models_count,
				SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active_models_count
			FROM brand_models
			WHERE brand_id IN ({$ids_str})
			GROUP BY brand_id
		";
		
		$results = $db->fetchAll($sql);
		
		// Создаем массив для быстрого поиска по brand_id
		$counts_by_brand = array();
		foreach ($results as $result) {
			// fetchAll() возвращает результаты в формате:
			// $result['table_name']['field_name'] для обычных полей
			// $result[0]['field_name'] для агрегатных функций
			$brand_id = isset($result['brand_models']['brand_id']) ? intval($result['brand_models']['brand_id']) : null;
			$models_count = isset($result[0]['models_count']) ? intval($result[0]['models_count']) : 0;
			$active_models_count = isset($result[0]['active_models_count']) ? intval($result[0]['active_models_count']) : 0;
			
			if ($brand_id !== null) {
				$counts_by_brand[$brand_id] = array(
					'models_count' => $models_count,
					'active_models_count' => $active_models_count
				);
			}
		}
		
		// Обновляем каждый бренд используя прямой SQL запрос
		foreach ($ids as $id) {
			$id = intval($id);
			if (isset($counts_by_brand[$id])) {
				$counts = $counts_by_brand[$id];
				$sql = "
					UPDATE brands 
					SET models_count = " . intval($counts['models_count']) . ",
						active_models_count = " . intval($counts['active_models_count']) . "
					WHERE id = " . $id;
			} else {
				// Если бренд не найден в результатах, значит у него 0 моделей
				$sql = "
					UPDATE brands 
					SET models_count = 0,
						active_models_count = 0
					WHERE id = " . $id;
			}
			$db->execute($sql);
		}
	}
}