<?php
exit();
App::uses('Security', 'Utility');
class GenerateController extends Controller {
	public $uses = array('Product', 'Category', 'Brand', 'BrandModel', 'CarBrand', 'CarModel', 'CarModification', 'Car', 'Disk', 'UsedTyre');
	public $layout = 'debug';
	public $path;
	public $photos;
	public function beforeFilter() {
		$this->path = ROOT . DS . '..' . DS . 'media' . DS;
		$this->photos = $this->path . 'photos' . DS;
	}
	public function index() {
		/*
		$this->loadModel('Brand2');
		$this->loadModel('BrandModel2');
		if ($brands = $this->Brand2->find('all')) {
			foreach ($brands as $brand) {
				$conditions = array(
					'Brand.category_id' => $brand['Brand2']['category_id'],
					'Brand.title' => $brand['Brand2']['title']
				);
				$current_brand_id = $brand['Brand2']['id'];
				if ($new_brand = $this->Brand->find('first', array('conditions' => $conditions))) {
					$brand_id = $new_brand['Brand']['id'];
					if ($models = $this->BrandModel2->find('all', array('conditions' => array('BrandModel2.brand_id' => $current_brand_id, 'BrandModel2.filename !=' => '')))) {
						foreach ($models as $model) {
							$conditions = array(
								'BrandModel.brand_id' => $brand_id,
								'BrandModel.title' => $model['BrandModel2']['title']
							);
							$current_model_id = $model['BrandModel2']['id'];
							if ($new_model = $this->BrandModel->find('first', array('conditions' => $conditions))) {
								$model_id = $new_model['BrandModel']['id'];
								$this->BrandModel->id = $model_id;
								$folder = $this->BrandModel->_getFolderById();
								$path = ROOT . DS . 'products2' . DS . $current_model_id . DS . $model['BrandModel2']['filename'];
								if (is_file($path)) {
									if (!copy($path, $folder . $model['BrandModel2']['filename'])) {
										
										echo 'not copied:<br />';
										echo $model_id . '<br />';
									}
									else {
										$this->BrandModel->id = $model_id;
										$this->BrandModel->saveField('filename', $model['BrandModel2']['filename']);
										echo 'copied ' . $path . ' to ' . $folder . $model['BrandModel2']['filename'] . '<br />';
									}
								}
								else {
									//$this->BrandModel->saveField('filename', '');
									//echo 'not found:<br />';
									//echo $model_id . '<br />';
									//echo $item['BrandModel']['original_filename'] . '<br />';
								}
							}
						}
						//debug($models);
						//exit();
					}
				}
			}
			//debug($brands);
		}
		exit();
		*/
		if ($models = $this->BrandModel->find('all', array('conditions' => array('BrandModel.original_filename !=' => '', 'BrandModel.filename' => '')))) {
			foreach ($models as $item) {
				$this->BrandModel->id = $item['BrandModel']['id'];
				$folder = $this->BrandModel->_getFolderById();
				if (is_file(ROOT . DS . 'products' . DS . $item['BrandModel']['original_filename'])) {
					if (!copy(ROOT . DS . 'products' . DS . $item['BrandModel']['original_filename'], $folder . $item['BrandModel']['original_filename'])) {
						echo 'not copied:<br />';
						echo $item['BrandModel']['id'] . '<br />';
					}
				}
				else {
					$this->BrandModel->saveField('filename', '');
					echo 'not found:<br />';
					echo $item['BrandModel']['id'] . '<br />';
					echo $item['BrandModel']['original_filename'] . '<br />';
				}
			}
		}
		return;
		$brand_ids = array_keys($this->Brand->find('list'));
		$model_ids = array_keys($this->BrandModel->find('list'));
		$this->Brand->recountProducts($brand_ids);
		$this->BrandModel->recountProducts($model_ids);
		$this->Brand->recountModels($brand_ids);
		return;
		set_time_limit(0);
		$brands = array_keys($this->Brand->find('list'));
		$models = array_keys($this->BrandModel->find('list'));
		$this->BrandModel->recountProducts($models);
		$this->Brand->recountModels($brands);
		$this->Brand->recountProducts($brands);
		exit();
		/* used tyres */
		$this->clear('used_tyres');
		$brands = $this->Brand->find('all', array('conditions' => array('Brand.category_id' => 1)));
		$models = $this->BrandModel->find('all', array('conditions' => array('BrandModel.category_id' => 1)));
		$brand_ids = array();
		$model_ids = array();
		foreach ($brands as $brand) {
			$brand_ids[$brand['Brand']['title']] = $brand['Brand']['id'];
			$model_ids[$brand['Brand']['id']] = array();
			foreach ($models as $model) {
				if ($brand['Brand']['id'] == $model['BrandModel']['brand_id']) {
					$model_ids[$brand['Brand']['id']][$model['BrandModel']['title']] = $model['BrandModel']['id'];
				}
			}
		}
		define('DBHOST', 'localhost');
		define('DBUSER', 'root');
		define('DBPASS', 'password');
		define('DBNAME', 'kerchshina_old');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		mysql_select_db(DBNAME, $link) or die(mysql_error());
		mysql_query('SET NAMES utf8', $link) or die(mysql_error());
		$result = mysql_query('SELECT Tyre.*,Brand.title AS brand_title,Model.title AS model_title FROM catalog_shitem AS Tyre LEFT JOIN catalog_brand AS Brand ON Tyre.brand_id=Brand.id LEFT JOIN catalog_model AS Model ON Tyre.model_id=Model.id ORDER BY Tyre.id DESC', $link) or die(mysql_error());
		$seasons = array(
			'L' => 'summer',
			'Z' => 'winter',
			'VS' => 'all'
		);
		$brands = array();
		$models = array();
		while ($row = mysql_fetch_assoc($result)) {
			$brand_id = $brand_ids[$row['brand_title']];
			$model_id = $model_ids[$brand_id][$row['model_title']];
			$season = 'summer';
			if (isset($seasons[$row['season']])) {
				$season = $seasons[$row['season']];
			}
			$save_data = array(
				'is_active' => 1,
				'brand_id' => $brand_id,
				'model_id' => $model_id,
				'size1' => $row['size1'],
				'size2' => $row['size2'],
				'size3' => $row['size3'],
				'protector_width' => $row['protect'],
				'price' => $row['price'],
				'count' => $row['count'],
				'season' => $season
			);
			if (is_file($this->path . $row['image'])) {
				$save_data['file']['tmp_name'] = $this->path . $row['image'];
				$save_data['file']['name'] = '1.png';
				$save_data['file']['type'] = 'image/png';
			}
			$this->UsedTyre->create();
			if ($this->UsedTyre->save($save_data)) {
			}
			else {
				debug($this->UsedTyre->validationErrors);
				debug($save_data);
			}
		}
		/**/
		/* generate data for selection
		$lines = file(WWW_ROOT . 'l.dat');
		foreach ($lines as $line) {
			$line = trim($line);
			if (!empty($line)) {
				list($brand_id, $model_id, $modification_id, $car_id, $length, $width, $height, $ah_from, $ah_to, $current, $f1, $f2) = explode('~', $line);
				$save_data = array(
					'length' => $length,
					'width' => $width,
					'height' => $height,
					'ah_from' => $ah_from,
					'ah_to' => $ah_to,
					'current' => $current,
					'f1' => $f1,
					'f2' => $f2
				);
				$this->Car->id = $car_id;
				$this->Car->save($save_data);
			}
		}
		*/
		/* copy cars
		$this->clear('cars');
		$disks = $this->Disk->find('all');
		$brands = array();
		$models = array();
		$modifications = array();
		foreach ($disks as $item) {
			$brand = $item['Disk']['vendor'];
			$model = $item['Disk']['car'];
			$modification = $item['Disk']['modification'];
			if (!isset($brands[$brand])) {
				$save_data = array(
					'is_active' => 1,
					'title' => $brand,
					'slug' => $this->_transliterate($brand)
				);
				$this->CarBrand->create();
				if ($this->CarBrand->save($save_data)) {
					$brand_id = $this->CarBrand->id;
					$brands[$brand] = $brand_id;
					$save_data = array(
						'is_active' => 1,
						'title' => $model,
						'brand_id' => $brand_id,
						'slug' => $this->_transliterate($model)
					);
					$this->CarModel->create();
					if ($this->CarModel->save($save_data)) {
						$model_id = $this->CarModel->id;
						$models[$brand][$model] = $model_id;
						$save_data = array(
							'is_active' => 1,
							'title' => $modification,
							'brand_id' => $brand_id,
							'model_id' => $model_id
						);
						$this->CarModification->create();
						if ($this->CarModification->save($save_data)) {
							$modification_id = $this->CarModification->id;
							$modifications[$brand][$model][$modification] = $modification_id;
						}
					}
				}
			}
			else {
				$brand_id = $brands[$brand];
			}
			if (!isset($models[$brand][$model])) {
				$save_data = array(
					'is_active' => 1,
					'title' => $model,
					'brand_id' => $brand_id,
					'slug' => $this->_transliterate($model)
				);
				$this->CarModel->create();
				if ($this->CarModel->save($save_data)) {
					$model_id = $this->CarModel->id;
					$models[$brand][$model] = $model_id;
					$save_data = array(
						'is_active' => 1,
						'title' => $modification,
						'brand_id' => $brand_id,
						'model_id' => $model_id
					);
					$this->CarModification->create();
					if ($this->CarModification->save($save_data)) {
						$modification_id = $this->CarModification->id;
						$modifications[$brand][$model][$modification] = $modification_id;
					}
				}
			}
			else {
				$model_id = $models[$brand][$model];
			}
			if (!isset($modifications[$brand][$model][$modification])) {
				$save_data = array(
					'is_active' => 1,
					'title' => $modification,
					'brand_id' => $brand_id,
					'model_id' => $model_id
				);
				$this->CarModification->create();
				if ($this->CarModification->save($save_data)) {
					$modification_id = $this->CarModification->id;
					$modifications[$brand][$model][$modification] = $modification_id;
				}
			}
			else {
				$modification_id = $modifications[$brand][$model][$modification];
			}
			$save_data = array(
				'is_active' => 1,
				'brand_id' => $brand_id,
				'model_id' => $model_id,
				'modification_id' => $modification_id,
				'year' => $item['Disk']['year'],
				'pcd' => $item['Disk']['pcd'],
				'diameter' => $item['Disk']['diametr'],
				'nut' => $item['Disk']['gaika'],
				'factory_tyres' => $item['Disk']['zavod_shini'],
				'replace_tyres' => $item['Disk']['zamen_shini'],
				'tuning_tyres' => $item['Disk']['tuning_shini'],
				'factory_disks' => $item['Disk']['zavod_diskov'],
				'replace_disks' => $item['Disk']['zamen_diskov'],
				'tuning_disks' => $item['Disk']['tuning_diski']
			);
			$this->Car->create();
			$this->Car->save($save_data);
		}
		*/
		/* copy catalog 
		$brand_ids = array();
		$model_ids = array();
		$models = $this->BrandModel->find('all');
		foreach ($models as $model) {
			$product_hashes = array();
			$deleted = false;
			$category_id = 0;
			if ($products = $this->Product->find('all', array('conditions' => array('Product.model_id' => $model['BrandModel']['id'])))) {
				foreach ($products as $product) {
					$category_id = $product['Product']['category_id'];
					switch ($product['Product']['category_id']) {
						case 1:
							$hash = md5($product['Product']['size1'] . '~' . $product['Product']['size2'] . '~' . $product['Product']['size3'] . '~' . $product['Product']['f1'] . '~' . $product['Product']['f2']);
							break;
						case 2:
							$hash = md5($product['Product']['size1'] . '~' . $product['Product']['size2'] . '~' . $product['Product']['size3'] . '~' . $product['Product']['et'] . '~' . $product['Product']['hub']);
							break;
						case 3:
							$hash = md5($product['Product']['ah'] . '~' . $product['Product']['current'] . '~' . $product['Product']['width'] . '~' . $product['Product']['length'] . '~' . $product['Product']['height'] . '~' . $product['Product']['f1'] . '~' . $product['Product']['f2']);
							break;
					}
					$product_hashes[$hash][] = $product;
				}
				switch ($category_id) {
					case 1:
						$fields = array('size1', 'size2', 'size3', 'f1', 'f2', 'auto', 'season', 'truck');
						break;
					case 2:
						$fields = array('size1', 'size2', 'size3', 'et', 'hub', 'color', 'material');
						break;
					case 3:
						$fields = array('ah', 'current', 'width', 'length', 'height', 'f1', 'f2');
						break;
				}
				foreach ($product_hashes as $hash => $products) {
					if (count($products) > 1) {
						$deleted = true;
						$product_fields_counts = array();
						foreach ($products as $product) {
							$fields_count = 0;
							foreach ($fields as $field) {
								if (!empty($product['Product'][$field])) {
									$fields_count ++;
								}
							}
							$product_fields_counts[$product['Product']['id']] = $fields_count;
						}
						arsort($product_fields_counts);
						$products_to_delete = array_slice(array_keys($product_fields_counts), 1);
						foreach ($products_to_delete as $product_id) {
							$this->Product->delete($product_id);
						}
						//debug($products_to_delete);
						//debug($products);
					}
				}
			}
			if ($deleted) {
				$model_ids[] = $model['BrandModel']['id'];
				if (!in_array($model['BrandModel']['brand_id'], $brand_ids)) {
					$model_ids[] = $model['BrandModel']['brand_id'];
				}
			}
		}
		$this->Brand->recountProducts($brand_ids);
		$this->BrandModel->recountProducts($model_ids);
		*/
		/* copy catalog 
		define('DBHOST', 'localhost');
		define('DBUSER', 'root');
		define('DBPASS', 'password');
		define('DBNAME', 'kerchshina_old');
		$this->clear('catalog');
		$link = mysql_connect(DBHOST, DBUSER, DBPASS);
		mysql_select_db(DBNAME, $link) or die(mysql_error());
		mysql_query('SET NAMES utf8', $link) or die(mysql_error());
		$result = mysql_query('SELECT * FROM catalog_diskbrand ORDER BY title ASC', $link) or die(mysql_error());
		while ($row = mysql_fetch_assoc($result)) {
			$slug = $this->_transliterate(trim($row['uid']));
			$check_slug = $slug;
			$i = 2;
			while (isset($slugs[$check_slug])) {
				$check_slug = $slug . $i;
				$i ++;
			}
			$slugs[$check_slug] = 1;
			$slug = $check_slug;
			$save_data = array();
			$save_data = array(
				'title' => $row['title'],
				'slug' => $slug,
				'meta_title' => $row['title'],
				'is_active' => 1,
				'category_id' => 2
			);
			if (!empty($row['logo'])) {
				if (is_file($this->path . $row['logo'])) {
					$save_data['file']['tmp_name'] = $this->path . $row['logo'];
					$save_data['file']['name'] = '1.png';
					$save_data['file']['type'] = 'image/png';
				}
			}
			elseif (is_file($this->path . 'brandlogos' . DS . $row['title'] . '.png')) {
				$save_data['file']['tmp_name'] = $this->path . 'brandlogos' . DS . $row['title'] . '.png';
				$save_data['file']['name'] = '1.png';
				$save_data['file']['type'] = 'image/png';
			}
			elseif (is_file($this->path . 'brandlogos' . DS . $row['title'] . '.jpg')) {
				$save_data['file']['tmp_name'] = $this->path . 'brandlogos' . DS . $row['title'] . '.jpg';
				$save_data['file']['name'] = '1.jpg';
				$save_data['file']['type'] = 'image/jpeg';
			}
			$this->Brand->tmp_file = null;
			$this->Brand->create();
			if ($this->Brand->save($save_data)) {
				$this->Brand->tmp_file = null;
				$brand_id = $this->Brand->id;
				$brands[] = $brand_id;
				$result2 = mysql_query('SELECT * FROM catalog_diskmodel WHERE brand_id=' . $row['id'] . ' ORDER BY title ASC', $link) or die(mysql_error());
				while ($row2 = mysql_fetch_assoc($result2)) {
					$save_data = array(
						'title' => $row2['title'],
						'meta_title' => $row2['title'],
						'is_active' => 1,
						'category_id' => 2,
						'brand_id' => $brand_id
					);
					$model_has_photo = false;
					$this->BrandModel->tmp_file = null;
					$this->BrandModel->create();
					if ($this->BrandModel->save($save_data)) {
						$this->BrandModel->tmp_file = null;
						$model_id = $this->BrandModel->id;
						$models[] = $model_id;
						$result3 = mysql_query('SELECT * FROM catalog_diskitem WHERE brand_id=' . $row['id'] . ' AND model_id=' . $row2['id'] . ' ORDER BY title ASC', $link) or die(mysql_error());
						while ($row3 = mysql_fetch_assoc($result3)) {
							$row3['c'] = trim(str_replace(array('ET', 'et'), '', $row3['c']));
							$save_data = array(
								'sku' => $row3['title'],
								'is_active' => 1,
								'in_stock' => empty($row3['yard']) ? 0 : 1,
								'category_id' => 2,
								'brand_id' => $brand_id,
								'model_id' => $model_id,
								'size1' => $row3['s1'],
								'size2' => $row3['s2'],
								'size3' => $row3['height'],
								'et' => floatval(str_replace(',', '.', $row3['c'])),
								'hub' => floatval(str_replace(',', '.', $row3['d'])),
								'price' => $row3['price'],
								'stock_count' => $row3['count'],
								'material' => $row3['material'],
								'color' => $row3['color']
							);
							if (is_file($this->path . 'products' . DS . 'disk' . DS . $row3['cat_im'])) {
								if (!$model_has_photo) {
									$file_data = array();
									$file_data['file']['tmp_name'] = $this->path . 'products' . DS . 'disk' . DS . $row3['cat_im'];
									$file_data['file']['name'] = '1.png';
									$file_data['file']['type'] = 'image/png';
									$this->BrandModel->id = $model_id;
									if ($this->BrandModel->save($file_data, false)) {
										$model_has_photo = true;
										$this->BrandModel->tmp_file = null;
									}
								}
							}
							$this->Product->tmp_file = null;
							$this->Product->create();
							if ($this->Product->save($save_data)) {
							}
							else {
								debug($this->Product->validationErrors);
								debug($save_data);
							}
						}
					}
					else {
						debug($this->BrandModel->validationErrors);
						debug($save_data);
					}
				}
			}
			else {
				debug($this->Brand->validationErrors);
				debug($save_data);
			}
			$rows_count ++;
		}
		$result = mysql_query('SELECT * FROM catalog_brand ORDER BY title ASC', $link) or die(mysql_error());
		$rows_count = 0;
		$slugs = array();
		$seasons = array(
			'L' => 'summer',
			'Z' => 'winter',
			'VS' => 'all'
		);
		$autos = array(
			'L' => 'cars',
			'G' => 'trucks',
			'LG' => 'light_trucks',
			'SP' => 'special',
			'SH' => 'agricultural'
		);
		$brands = array();
		$models = array();
		while ($row = mysql_fetch_assoc($result)) {
			$slug = $this->_transliterate(trim($row['uid']));
			$check_slug = $slug;
			$i = 2;
			while (isset($slugs[$check_slug])) {
				$check_slug = $slug . $i;
				$i ++;
			}
			$slugs[$check_slug] = 1;
			$slug = $check_slug;
			$save_data = array();
			$save_data = array(
				'title' => $row['title'],
				'slug' => $slug,
				'meta_title' => $row['title'],
				'is_active' => 1,
				'category_id' => 1
			);
			if (is_file($this->path . 'brandlogos' . DS . $row['title'] . '.png')) {
				$save_data['file']['tmp_name'] = $this->path . 'brandlogos' . DS . $row['title'] . '.png';
				$save_data['file']['name'] = '1.png';
				$save_data['file']['type'] = 'image/png';
			}
			elseif (is_file($this->path . 'brandlogos' . DS . $row['title'] . '.jpg')) {
				$save_data['file']['tmp_name'] = $this->path . 'brandlogos' . DS . $row['title'] . '.jpg';
				$save_data['file']['name'] = '1.jpg';
				$save_data['file']['type'] = 'image/jpeg';
			}
			$this->Brand->tmp_file = null;
			$this->Brand->create();
			if ($this->Brand->save($save_data)) {
				$this->Brand->tmp_file = null;
				$brand_id = $this->Brand->id;
				$brands[] = $brand_id;
				$result2 = mysql_query('SELECT * FROM catalog_model WHERE brand_id=' . $row['id'] . ' ORDER BY title ASC', $link) or die(mysql_error());
				while ($row2 = mysql_fetch_assoc($result2)) {
					$save_data = array(
						'title' => $row2['title'],
						'meta_title' => $row2['title'],
						'content' => $row2['content'],
						'is_active' => 1,
						'category_id' => 1,
						'brand_id' => $brand_id
					);
					$model_has_photo = false;
					if (is_file($this->path . $row2['image'])) {
						$save_data['file']['tmp_name'] = $this->path . $row2['image'];
						$save_data['file']['name'] = '1.png';
						$save_data['file']['type'] = 'image/png';
						$model_has_photo = true;
					}
					$this->BrandModel->tmp_file = null;
					$this->BrandModel->create();
					if ($this->BrandModel->save($save_data)) {
						$this->BrandModel->tmp_file = null;
						$model_id = $this->BrandModel->id;
						$models[] = $model_id;
						$result3 = mysql_query('SELECT * FROM catalog_item WHERE brand_id=' . $row['id'] . ' AND model_id=' . $row2['id'] . ' ORDER BY title ASC', $link) or die(mysql_error());
						while ($row3 = mysql_fetch_assoc($result3)) {
							$season = 'summer';
							$auto = 'cars';
							if (isset($autos[$row3['auto']])) {
								$auto = $autos[$row3['auto']];
							}
							if (isset($seasons[$row3['season']])) {
								$season = $seasons[$row3['season']];
							}
							$save_data = array(
								'sku' => $row3['title'],
								'is_active' => 1,
								'in_stock' => empty($row3['yard']) ? 0 : 1,
								'category_id' => 1,
								'brand_id' => $brand_id,
								'model_id' => $model_id,
								'size1' => $row3['size1'],
								'size2' => $row3['size2'],
								'size3' => $row3['size3'],
								'f1' => $row3['f1'],
								'f2' => $row3['f2'],
								'price' => $row3['price'],
								'stock_count' => $row3['count'],
								'truck' => $row3['truck'],
								'auto' => $auto,
								'season' => $season
							);
							$this->Product->tmp_file = null;
							$this->Product->create();
							if ($this->Product->save($save_data)) {
								if (!$model_has_photo) {
									if (is_file($this->path . 'products' . DS . 'tire' . DS . $row3['catalog_image'])) {
										$file_data = array();
										$file_data['file']['tmp_name'] = $this->path . 'products' . DS . 'tire' . DS . $row3['catalog_image'];
										$file_data['file']['name'] = '1.png';
										$file_data['file']['type'] = 'image/png';
										$this->BrandModel->id = $model_id;
										if ($this->BrandModel->save($file_data, false)) {
											$model_has_photo = true;
											$this->BrandModel->tmp_file = null;
										}
									}
								}
							}
							else {
								debug($this->Product->validationErrors);
								debug($save_data);
							}
						}
					}
					else {
						debug($this->BrandModel->validationErrors);
						debug($save_data);
					}
				}
			}
			else {
				debug($this->Brand->validationErrors);
				debug($save_data);
			}
			$rows_count ++;
		}
		$result = mysql_query('SELECT * FROM catalog_akbbrand ORDER BY title ASC', $link) or die(mysql_error());
		while ($row = mysql_fetch_assoc($result)) {
			$slug = $this->_transliterate(trim($row['uid']));
			$check_slug = $slug;
			$i = 2;
			while (isset($slugs[$check_slug])) {
				$check_slug = $slug . $i;
				$i ++;
			}
			$slugs[$check_slug] = 1;
			$slug = $check_slug;
			$save_data = array();
			$save_data = array(
				'title' => $row['title'],
				'slug' => $slug,
				'meta_title' => $row['title'],
				'is_active' => 1,
				'category_id' => 3
			);
			if (!empty($row['logo'])) {
				if (is_file($this->path . $row['logo'])) {
					$save_data['file']['tmp_name'] = $this->path . $row['logo'];
					$save_data['file']['name'] = '1.png';
					$save_data['file']['type'] = 'image/png';
				}
			}
			elseif (is_file($this->path . 'brandlogos' . DS . $row['title'] . '.png')) {
				$save_data['file']['tmp_name'] = $this->path . 'brandlogos' . DS . $row['title'] . '.png';
				$save_data['file']['name'] = '1.png';
				$save_data['file']['type'] = 'image/png';
			}
			elseif (is_file($this->path . 'brandlogos' . DS . $row['title'] . '.jpg')) {
				$save_data['file']['tmp_name'] = $this->path . 'brandlogos' . DS . $row['title'] . '.jpg';
				$save_data['file']['name'] = '1.jpg';
				$save_data['file']['type'] = 'image/jpeg';
			}
			$this->Brand->tmp_file = null;
			$this->Brand->create();
			if ($this->Brand->save($save_data)) {
				$this->Brand->tmp_file = null;
				$brand_id = $this->Brand->id;
				$brands[] = $brand_id;
				$result2 = mysql_query('SELECT * FROM catalog_akbmodel WHERE brand_id=' . $row['id'] . ' ORDER BY title ASC', $link) or die(mysql_error());
				while ($row2 = mysql_fetch_assoc($result2)) {
					$save_data = array(
						'title' => $row2['title'],
						'meta_title' => $row2['title'],
						'is_active' => 1,
						'category_id' => 3,
						'brand_id' => $brand_id
					);
					$this->BrandModel->tmp_file = null;
					$this->BrandModel->create();
					if ($this->BrandModel->save($save_data)) {
						$this->BrandModel->tmp_file = null;
						$model_id = $this->BrandModel->id;
						$models[] = $model_id;
						$result3 = mysql_query('SELECT * FROM catalog_akbitem WHERE brand_id=' . $row['id'] . ' AND model_id=' . $row2['id'] . ' ORDER BY id ASC', $link) or die(mysql_error());
						while ($row3 = mysql_fetch_assoc($result3)) {
							$save_data = array(
								'is_active' => 1,
								'in_stock' => empty($row3['yard']) ? 0 : 1,
								'category_id' => 3,
								'brand_id' => $brand_id,
								'model_id' => $model_id,
								'width' => $row3['size1'],
								'length' => $row3['size2'],
								'height' => $row3['size3'],
								'f1' => $row3['type'],
								'f2' => $row3['polar'],
								'ah' => intval($row3['ah']),
								'current' => intval($row3['cur']),
								'price' => $row3['price'],
								'stock_count' => $row3['count']
							);
							$this->Product->tmp_file = null;
							$this->Product->create();
							if ($this->Product->save($save_data)) {
							}
							else {
								debug($this->Product->validationErrors);
								debug($save_data);
							}
						}
					}
					else {
						debug($this->BrandModel->validationErrors);
						debug($save_data);
					}
				}
			}
			else {
				debug($this->Brand->validationErrors);
				debug($save_data);
			}
			$rows_count ++;
		}
		mysql_close($link);
		$this->Brand->recountModels($brands);
		$this->Brand->recountProducts($brands);
		$this->BrandModel->recountProducts($models);
		print $rows_count;
		*/
		$this->render(false);
	}
	private function _normalize($number) {
		switch (strlen($number)) {
			case 1:
				return $number;
				break;
			case 2:
				return round($number / 5) * 5;
				break;
			case 3:
				return round($number / 10) * 10;
				break;
			case 4:
				return round($number / 50) * 50;
				break;
			case 5:
				return round($number / 100) * 100;
				break;
			case 6:
			case 7:
			case 8:
				return round($number / 1000) * 1000;
				break;
		}
		return $number;
	}
	private function clear($type) {
		clearstatcache();
		if ($type == 'catalog') {
			$this->Product->query('TRUNCATE TABLE products');
			$this->Product->query('TRUNCATE TABLE brands');
			$this->Product->query('TRUNCATE TABLE brand_models');
			$this->Product->query('UPDATE categories SET products_count=0');
			$folders = array('brands', 'models');
			foreach ($folders as $folder) {
				if ($dh = opendir(IMAGES . $folder)) {
					while ($file = readdir($dh)) {
						if ($file != '..' && $file != '.') {
							$this->_clearFolder(IMAGES . $folder . DS . $file);
						}
					}
					closedir($dh);
				}
			}
		}
		elseif ($type == 'cars') {
			$this->Product->query('TRUNCATE TABLE car_brands');
			$this->Product->query('TRUNCATE TABLE car_models');
			$this->Product->query('TRUNCATE TABLE car_modifications');
			$this->Product->query('TRUNCATE TABLE cars');
		}
		elseif ($type == 'used_tyres') {
			$this->Product->query('TRUNCATE TABLE used_tyres');
			$folders = array('tyres');
			foreach ($folders as $folder) {
				if ($dh = opendir(IMAGES . $folder)) {
					while ($file = readdir($dh)) {
						if ($file != '..' && $file != '.') {
							$this->_clearFolder(IMAGES . $folder . DS . $file);
						}
					}
					closedir($dh);
				}
			}
		}
		$this->layout = false;
		$this->render(false);
	}
	private function _clearFolder($dir) {
		if ($dh = opendir($dir)) {
			while ($file = readdir($dh)) {
				if ($file != '..' && $file != '.') {
					if (is_dir($dir . DS . $file)) {
						$this->_clearFolder($dir . DS . $file);
					}
					else {
						unlink($dir . DS . $file);
					}
				}
			}
			closedir($dh);
			rmdir($dir);
		}
	}
	private function _random($lang = 'ru') {
		if ($lang == 'ru') {
			$url = 'http://ru.wikipedia.org/wiki/Служебная:Random';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; ru; rv:1.9.2.15) Gecko/20110303 Firefox/3.6.15');
			$result = curl_exec($ch);
			curl_close($ch);
			if ($result != false) {
				if (preg_match('/<title>(.+?)<\//', $result, $match)) {
					$title = str_replace(' — Википедия', '', $match[1]);
					if (preg_match('/<p>(.+?)<\/p/', $result, $match)) {
						$text = strip_tags($match[1], '<p><b><strong><i><u><ol><ul><li>');
						$text = preg_replace('/(\[[0-9]+?\])/', '', $text);
						return array($title, $text);
					}
				}
			}
		}
		elseif ($lang == 'en') {
			$url = 'http://en.wikipedia.org/wiki/Special:Random';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; ru; rv:1.9.2.15) Gecko/20110303 Firefox/3.6.15');
			$result = curl_exec($ch);
			curl_close($ch);
			if ($result != false) {
				if (preg_match('/<title>(.+?)<\//', $result, $match)) {
					$title = str_replace(' - Wikipedia, the free encyclopedia', '', $match[1]);
					if (preg_match('/<p>(.+?)<\/p/', $result, $match)) {
						$text = strip_tags($match[1], '<p><b><strong><i><u><ol><ul><li>');
						$text = preg_replace('/(\[[0-9]+?\])/', '', $text);
						return array($title, $text);
					}
				}
			}
		}
		return false;
	}
	private function _sku() {
		$sku = '';
		$letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$letters_count = 3;
		$numbers_count = 4;
		for ($i = 0; $i < $letters_count; $i ++) {
			$sku .= $letters[mt_rand(0, 25)];
		}
		for ($i = 0; $i < $numbers_count; $i ++) {
			$sku .= mt_rand(0, 9);
		}
		return $sku;
	}
	private function _transliterate($title) {
		$replaces[0] = array('а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я');
		$replaces[1] = array('a', 'b', 'v', 'g', 'd', 'e', 'e', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'y', 'f', 'h', 'ts', 'ch', 'sh', 'shh', '', 'i', '', 'e', 'yu', 'ya', 'A', 'B', 'V', 'G', 'D', 'E', 'E', 'Zh', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'Y', 'F', 'H', 'Ts', 'Ch', 'Sh', 'Shh', '', 'I', '', 'E', 'Yu', 'Ya');
		$title = iconv('utf-8', 'windows-1251', $title);
		for ($i=0;$i<count($replaces[0]);$i++) {
			$replaces[0][$i] = iconv('utf-8', 'windows-1251', $replaces[0][$i]);
		}
		$slug = trim(preg_replace(iconv('utf-8', 'windows-1251', '/[^A-zА-я0-9 \_-]+/'), '', $title));
		$slug = str_replace($replaces[0], $replaces[1], $slug);
		$slug = str_replace(' ', '-', $slug);
		$slug = strtolower(preg_replace('/-+/', '-', $slug));
		return $slug;
	}
	public static function truncate($text, $length = 100, $options = array()) {
		$default = array(
			'ending' => '...', 'exact' => true, 'html' => false
		);
		$options = array_merge($default, $options);
		extract($options);

		if (!function_exists('mb_strlen')) {
			class_exists('Multibyte');
		}

		if ($html) {
			if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
				return $text;
			}
			$totalLength = mb_strlen(strip_tags($ending));
			$openTags = array();
			$truncate = '';

			preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
			foreach ($tags as $tag) {
				if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
					if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
						array_unshift($openTags, $tag[2]);
					} elseif (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
						$pos = array_search($closeTag[1], $openTags);
						if ($pos !== false) {
							array_splice($openTags, $pos, 1);
						}
					}
				}
				$truncate .= $tag[1];

				$contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
				if ($contentLength + $totalLength > $length) {
					$left = $length - $totalLength;
					$entitiesLength = 0;
					if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
						foreach ($entities[0] as $entity) {
							if ($entity[1] + 1 - $entitiesLength <= $left) {
								$left--;
								$entitiesLength += mb_strlen($entity[0]);
							} else {
								break;
							}
						}
					}

					$truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
					break;
				} else {
					$truncate .= $tag[3];
					$totalLength += $contentLength;
				}
				if ($totalLength >= $length) {
					break;
				}
			}
		} else {
			if (mb_strlen($text) <= $length) {
				return $text;
			} else {
				$truncate = mb_substr($text, 0, $length - mb_strlen($ending));
			}
		}
		if (!$exact) {
			$spacepos = mb_strrpos($truncate, ' ');
			if ($html) {
				$truncateCheck = mb_substr($truncate, 0, $spacepos);
				$lastOpenTag = mb_strrpos($truncateCheck, '<');
				$lastCloseTag = mb_strrpos($truncateCheck, '>');
				if ($lastOpenTag > $lastCloseTag) {
					preg_match_all('/<[\w]+[^>]*>/s', $truncate, $lastTagMatches);
					$lastTag = array_pop($lastTagMatches[0]);
					$spacepos = mb_strrpos($truncate, $lastTag) + mb_strlen($lastTag);
				}
				$bits = mb_substr($truncate, $spacepos);
				preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
				if (!empty($droppedTags)) {
					if (!empty($openTags)) {
						foreach ($droppedTags as $closingTag) {
							if (!in_array($closingTag[1], $openTags)) {
								array_unshift($openTags, $closingTag[1]);
							}
						}
					} else {
						foreach ($droppedTags as $closingTag) {
							array_push($openTags, $closingTag[1]);
						}
					}
				}
			}
			$truncate = mb_substr($truncate, 0, $spacepos);
		}
		$truncate .= $ending;

		if ($html) {
			foreach ($openTags as $tag) {
				$truncate .= '</' . $tag . '>';
			}
		}

		return $truncate;
	}
}