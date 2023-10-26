<?php
class BrandsController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'Brand.title' => 'asc'
		)
	);
	public $filter_fields = array('Brand.id' => 'int', 'Brand.category_id' => 'int', 'Brand.title' => 'text');
	public $model = 'Brand';
	public $submenu = 'products';
	public function _list() {
		parent::_list();
		$this->loadModel('Category');
		$this->set('categories', $this->Category->find('list', array('fields' => array('Category.id', 'Category.title'), 'order' => array('Category.lft' => 'asc'))));
	}
	public function api(){
		
		$this->loadModel('Brand');
		$products = $this->Brand->find('all');
		$products = json_encode($products, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		print_r($products);
		exit;
	}
	public function _edit($id) {
		$id = intval($id);
		$this->loadModel($this->model);
		$this->{$this->model}->bindModel(
			array(
				'hasMany' => array(
					'BrandSynonym' => array(
						'foreignKey' => 'brand_id'
					)
				)
			)
		);
		$this->{$this->model}->id = $id;
		$data = $this->{$this->model}->read();
		if (empty($this->request->data)) {
			if ($id != 0) {
				if (!empty($data['BrandSynonym'])) {
					$data['Brand']['synonyms'] = '';
					$synonyms = array();
					foreach ($data['BrandSynonym'] as $item) {
						$synonyms[] = $item['title'];
					}
					$data['Brand']['synonyms'] = implode("\n", $synonyms);
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
					$brand_id = $this->{$this->model}->id;
					$this->loadModel('BrandSynonym');
					$this->BrandSynonym->deleteAll(array('BrandSynonym.brand_id' => $brand_id));
					$synonyms = explode("\n", $this->request->data[$this->model]['synonyms']);
					foreach ($synonyms as $synonym) {
						$save_data = array(
							'brand_id' => $brand_id,
							'title' => $synonym
						);
						$this->BrandSynonym->create();
						$this->BrandSynonym->save($save_data);
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
		$this->loadModel('Category');
		$this->set('categories', $this->Category->find('list', array('fields' => array('Category.id', 'Category.title'), 'order' => array('Category.lft' => 'asc'))));
		return $title;
	}
	function admin_models() {
		Configure::write('debug', 0);
		$brand_id = $this->request->query['brand_id'];
		$any = 0;
		if (isset($this->request->query['any'])) {
			$any = $this->request->query['any'];
		}
		$this->layout = 'json';
		if ($any) {
			$data = array('' => __d('admin_common', 'list_any_item'));
		}
		else {
			$data = array('' => __d('admin_common', 'list_all_items'));
		}
		$this->loadModel('BrandModel');
		if ($models = $this->BrandModel->find('list', array('conditions' => array('BrandModel.brand_id' => $brand_id), 'order' => array('BrandModel.title ASC'), 'fields' => array('BrandModel.id', 'BrandModel.title')))) {
			//echo"---------1111";
			$data = $data + $models;
		}
		$this->set(compact('data'));
		$this->render(false);
	}
}