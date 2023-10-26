<?php
class ProductsController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'Product.title' => 'asc'
		)
	);
	public $filter_fields = array('Product.id' => 'int', 'Product.category_id' => 'int', 'Product.title' => 'text');
	public $model = 'Product';
	public function _list() {
		parent::_list();
		$this->loadModel('Category');
		$this->set('categories', $this->Category->find('list', array('fields' => array('Category.id', 'Category.title'), 'order' => array('Category.lft' => 'asc'))));
	}
	public function api(){
		
		$this->loadModel('Product');
		$products = $this->Product->find('all');
		$products = json_encode($products, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		print_r($products);
		exit;
	}
	public function _edit($id = null) {
		$id = intval($id);
		$this->loadModel($this->model);
		$this->{$this->model}->id = $id;
		$data = $this->{$this->model}->read();
		if (empty($this->request->data)) {
			if ($id != 0) {
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
						unset($this->request->data[$this->model]['is_active']);
					}
					unset($this->request->data[$this->model]['slug']);
				}
			}
			if ($this->{$this->model}->save($this->request->data)) {
				$product_id = $this->{$this->model}->id;
				$this->info($this->t('message_item_saved'));
				$this->loadModel('ProductField');
				$this->ProductField->deleteAll(array('ProductField.product_id' => $product_id));
				if (isset($this->request->data['ProductField'])) {
					for ($i = 1; $i < 4; $i ++) {
						for ($j = 0; $j < count($this->request->data['ProductField']['group' . $i]); $j ++) {
							$save_data = array(
								'product_id' => $product_id,
								'field_id' => $this->request->data['ProductField']['group' . $i][$j]
							);
							$this->ProductField->create();
							$this->ProductField->save($save_data);
						}
					}
				}
				$this->loadModel('ProductPhoto');
				if (isset($data['ProductPhoto'])) {
					foreach ($data['ProductPhoto'] as $item) {
						if (!isset($this->request->data['ExistProductPhoto']['file'][$item['id']])) {
							$this->ProductPhoto->delete($item['id']);
						}
						else {
							$save_data = array(
								'product_id' => $product_id,
								'file' => $this->request->data['ExistProductPhoto']['file'][$item['id']],
								'sort_order' => $this->request->data['ExistProductPhoto']['sort_order'][$item['id']]
							);
							$this->ProductPhoto->id = $item['id'];
							$this->ProductPhoto->save($save_data);
						}
					}
				}
				if (isset($this->request->data['ProductPhoto'])) {
					for ($i = 0; $i < count($this->request->data['ProductPhoto']['file']); $i ++) {
						$save_data = array(
							'product_id' => $product_id,
							'file' => $this->request->data['ProductPhoto']['file'][$i],
							'sort_order' => $this->request->data['ProductPhoto']['sort_order'][$i]
						);
						$this->ProductPhoto->create();
						$this->ProductPhoto->save($save_data);
					}
				}
				if ($this->request->data[$this->model]['action'] == 'save') {
					$this->redirect(array('controller' => Inflector::underscore($this->name), 'action' => 'admin_edit', $this->{$this->model}->id));
				}
				else {
					$this->redirect(array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list'));
				}
			}
			else {
				$this->error($this->t('error_item_not_saved'));
			}
		}
		$is_deletable = 1;
		$title = '';
		$this->loadModel('Category');
		if (!empty($data)) {
			$this->loadModel('Field');
			$this->Category->id = $data['Product']['category_id'];
			$this->set('category', $this->Category->read(array('field_group1', 'field_group2', 'field_group3')));
			$this->set('fields', $this->Field->find('all', array('conditions' => array('Field.category_id' => $data['Product']['category_id']), 'order' => array('Field.sort_order' => 'asc'))));
			$is_deletable = $data[$this->model]['is_deletable'];
			if ($this->{$this->model}->hasField('title')) {
				$title = $data[$this->model]['title'];
			}
			elseif ($this->{$this->model}->hasField('name')) {
				$title = $data[$this->model]['name'];
			}
		}
		$this->set('data', $data);
		$this->set('is_deletable', $is_deletable);
		$this->set('categories', $this->Category->find('list', array('fields' => array('Category.id', 'Category.title'), 'order' => array('Category.lft' => 'asc'))));
		return $title;
	}
	public function view($category_slug = null, $slug = null) {
		$this->loadModel('Section');
		if ($section = $this->Section->find('first', array('conditions' => array('Section.is_active' => 1, 'Section.type' => 'section', 'Section.section' => 'catalog')))) {
			$this->loadModel('Category');
			if ($category = $this->Category->find('first', array('conditions' => array('Category.is_active' => 1, 'Category.slug' => $category_slug)))) {
				$this->loadModel('Product');
				if ($product = $this->Product->find('first', array('conditions' => array('Product.is_active' => 1, 'Product.category_id' => $category['Category']['id'], 'Product.slug' => $slug)))) {
					$this->set('product', $product);
					$this->set('category', $category);
					$this->setMeta('title', !empty($product['Product']['meta_title']) ? $product['Product']['meta_title'] : htmlspecialchars_decode($product['Product']['title']));
					$this->setMeta('keywords', $product['Product']['meta_keywords']);
					$this->setMeta('description', $product['Product']['meta_description']);
					$this->set('section_id', $section['Section']['id']);
					$this->set('color', $section['Section']['color']);
					$this->set('page_title', !empty($section['Section']['page_title']) ? $section['Section']['page_title'] : $section['Section']['title']);
				}
			}
			else {
				$this->response->statusCode(404);
				$this->response->send();
				$this->render(false);
				return;
			}
		}
		else {
			$this->response->statusCode(404);
			$this->response->send();
			$this->render(false);
			return;
		}
	}
}