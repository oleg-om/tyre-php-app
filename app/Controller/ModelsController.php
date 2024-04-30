<?php
class ModelsController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'BrandModel.title' => 'asc'
		)
	);
	public $filter_fields = array('BrandModel.products_in_stock' => 'int', 'BrandModel.id' => 'int', 'BrandModel.category_id' => 'int', 'BrandModel.brand_id' => 'int', 'BrandModel.title' => 'text');
	public $model = 'BrandModel';
	public $submenu = 'products';
	public function api(){
		
		$this->loadModel('BrandModel');
		$products = $this->BrandModel->find('all');
		$products = json_encode($products, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		print_r($products);
		exit;
	}
	public function _list() {
		parent::_list();
		$this->loadModel('Brand');
		$this->loadModel('Category');
		$this->set('categories', $this->Category->find('list', array('fields' => array('Category.id', 'Category.title'), 'order' => array('Category.lft' => 'asc'))));
		if (isset($this->request->data['BrandModel']['category_id'])) {
			$this->set('brands', $this->Brand->find('list', array('fields' => array('Brand.id', 'Brand.title'), 'conditions' => array('Brand.category_id' => $this->request->data['BrandModel']['category_id']), 'order' => array('Brand.title' => 'asc'))));
		}
		else {
			$this->set('brands', array('' => __d('admin_common', 'list_all_items')));
		}
		$this->set('all_brands', $this->Brand->find('list', array('fields' => array('Brand.id', 'Brand.title'), 'order' => array('Brand.title' => 'asc'))));
	}
	public function _edit($id) {
		$id = intval($id);
		$this->loadModel($this->model);
		$this->{$this->model}->bindModel(
			array(
				'hasMany' => array(
					'ModelSynonym' => array(
						'foreignKey' => 'model_id'
					)
				)
			)
		);
		$this->{$this->model}->id = $id;
		$data = $this->{$this->model}->read();
		if (empty($this->request->data)) {
			if ($id != 0) {
				if (!empty($data['ModelSynonym'])) {
					$data['BrandModel']['synonyms'] = '';
					$synonyms = array();
					foreach ($data['ModelSynonym'] as $item) {
						$synonyms[] = $item['title'];
					}
					$data['BrandModel']['synonyms'] = implode("\n", $synonyms);
				}
				$this->request->data = $data;
			}
			else {
				$this->request->data[$this->model]['is_active'] = 1;
			}
		}
		else {
			if (!empty($data)) {
				if (!$data[$this->model]['is_deletable']) {
					if (isset($this->request->data[$this->model]['is_active']) && !$this->request->data[$this->model]['is_active']) {
						//unset($this->request->data[$this->model]['is_active']);
					}
					//unset($this->request->data[$this->model]['slug']);
				}
			}
			else {
				if ($this->{$this->model}->hasField('administrator_id')) {
					$this->request->data[$this->model]['administrator_id'] = $this->Auth->user('id');
				}
			}
			if ($this->{$this->model}->save($this->request->data)) {
				if (!empty($this->request->data[$this->model]['synonyms'])) {
					$model_id = $this->{$this->model}->id;
					$this->loadModel('ModelSynonym');
					$this->ModelSynonym->deleteAll(array('ModelSynonym.model_id' => $model_id));
					$synonyms = explode("\n", $this->request->data[$this->model]['synonyms']);
					foreach ($synonyms as $synonym) {
						$save_data = array(
							'model_id' => $model_id,
							'title' => $synonym
						);
						$this->ModelSynonym->create();
						$this->ModelSynonym->save($save_data);
					}

				}
				$this->info($this->t('message_item_saved'));
				if ($this->request->data[$this->model]['action'] == 'save') {
					$this->redirect(array('controller' => Inflector::underscore($this->name), 'action' => 'admin_edit', $this->{$this->model}->id));
				}
				else {
					$this->redirect(array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list'));
				}
			}
			else {
				debug($this->{$this->model}->validationErrors);
				$this->error($this->t('error_item_not_saved'));
			}
		}
		$is_deletable = 1;
		$sort_order = 1;
		$title = '';
		if (!empty($data)) {
			$is_deletable = $data[$this->model]['is_deletable'];
			if ($this->{$this->model}->hasField('title')) {
				$title = $data[$this->model]['title'];
			}
			elseif ($this->{$this->model}->hasField('name')) {
				$title = $data[$this->model]['name'];
			}
			elseif ($this->{$this->model}->hasField('sku')) {
				$title = $data[$this->model]['sku'];
			}
		}
		else {
			if ($this->{$this->model}->hasField('sort_order')) {
				if (method_exists($this->{$this->model}, 'getSortOrder')) {
					$sort_order = $this->{$this->model}->getSortOrder();
				}
				$this->set('sort_order', $sort_order);
			}
		}
		$this->set('sort_order', $sort_order);
		$this->set('is_deletable', $is_deletable);
		$this->loadModel('Brand');
		$this->loadModel('Category');
		$this->set('categories', $this->Category->find('list', array('fields' => array('Category.id', 'Category.title'), 'order' => array('Category.lft' => 'asc'))));
		if (isset($this->request->data['BrandModel']['category_id'])) {
			$this->set('brands', $this->Brand->find('list', array('fields' => array('Brand.id', 'Brand.title'), 'conditions' => array('Brand.category_id' => $this->request->data['BrandModel']['category_id']), 'order' => array('Brand.title' => 'asc'))));
		}
		else {
			$this->set('brands', array('' => __d('admin_common', 'list_any_items')));
		}
		$this->set('materials', $this->BrandModel->materials);
		$this->set('seasons', $this->BrandModel->seasons);
		$this->set('auto', $this->BrandModel->auto);
        $this->set('extra_filenames', $data[$this->model]['extra_filenames']);
        $this->set('brand_model_id', $data[$this->model]['id']);
        $this->set('brand_id', $data[$this->model]['brand_id']);
		return $title;
	}
	public function admin_merge() {
		$filter = $this->redirectFields($this->model, null);
		$this->loadModel($this->model);
		if (!empty($this->request->data) && isset($this->request->data[$this->model])) {
			$ids = array();
			foreach ($this->request->data[$this->model] as $id => $item) {
				if (isset($item['delete']) && $item['delete'] == 1) {
					$ids[] = $id;
				}
			}
			if (count($ids) > 1) {
				$this->BrandModel->id = $ids[0];
				if ($main_model = $this->BrandModel->read()) {
					$has_photo = false;
					if (!empty($main_model['BrandModel']['filename'])) {
						$has_photo = true;
					}
					$this->loadModel('ModelSynonym');
					for ($i = 1; $i < count($ids); $i ++) {
						$this->BrandModel->id = $ids[$i];
						if ($model = $this->BrandModel->read()) {
							if (!$has_photo && !empty($model['BrandModel']['filename'])) {
								$save_data = array();
								$save_data['file']['tmp_name'] = $this->BrandModel->_getFolderById() . $model['BrandModel']['filename'];
								$save_data['file']['name'] = '1.png';
								$save_data['file']['type'] = 'image/png';
								$this->BrandModel->tmp_file = null;
								$this->BrandModel->create();
								$this->BrandModel->id = $main_model['BrandModel']['id'];
								if ($this->BrandModel->save($save_data, false)) {
									$has_photo = true;
								}
								$this->BrandModel->tmp_file = null;
							}
							$this->BrandModel->query('UPDATE products SET model_id=' . $main_model['BrandModel']['id'] . ' WHERE model_id=' . $model['BrandModel']['id']);
							$this->BrandModel->query('UPDATE model_synonyms SET model_id=' . $main_model['BrandModel']['id'] . ' WHERE model_id=' . $model['BrandModel']['id']);
							$this->BrandModel->recountProducts($model['BrandModel']['id']);
							$this->BrandModel->delete($model['BrandModel']['id']);
							$save_data = array(
								'model_id' => $main_model['BrandModel']['id'],
								'title' => $model['BrandModel']['title']
							);
							$this->ModelSynonym->create();
							$this->ModelSynonym->save($save_data);
						}
					}
					$this->loadModel('Brand');
					$this->Brand->recountModels($main_model['BrandModel']['brand_id']);
					$this->BrandModel->recountProducts($main_model['BrandModel']['id']);
					$this->info($this->t('message_items_merged'));
				}
				else {
					$this->error($this->t('error_items_not_merged'));
				}
			}
			else {
				$this->error($this->t('error_select_items_to_merge'));
			}
		}
		else {
			$this->error($this->t('error_items_not_merged'));
		}
		$url = array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list');
		$url = array_merge($url, $filter);
		$this->redirect($url);
	}
	public function set_model() {
		if (!empty($this->data['id'])) {
			$id = (int)$this->data['id'];
			$this->loadModel('BrandModel');
			$this->BrandModel->bindModel(
					array(
						'belongsTo' => array(
							'Brand'
						),
						'hasMany' => array(
							'Product' => array(
								'foreignKey' => 'model_id',
								'conditions' => array('Product.is_active' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0),
								'order'      => 'Product.price ASC'
							)
						)
					),
					false
				);
			if ($model = $this->BrandModel->find('first', array('conditions' => array('BrandModel.id' => $id))) ) {
				print_r($model);
				$this->setLastModels($model);
			}
		}
		$this->layout = false;
		$this->render(false);
	}
	public function get_models($brand_id = 0) {
		$this->layout = false;
		$data = array(array('0' => '...'));
		$brand_id = intval($brand_id);
		$this->loadModel('BrandModel');
		if ($car_models = $this->BrandModel->find('list', array('order' => array('BrandModel.title' => 'asc'), 'conditions' => array('BrandModel.is_active' => 1, 'BrandModel.brand_id' => $brand_id)))) {
			foreach ($car_models as $key => $value) {
				$data[] = array($key => $value);
			}
		}
		echo json_encode($data);
		$this->render(false);
	}
}