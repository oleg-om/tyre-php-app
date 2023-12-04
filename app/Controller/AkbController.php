<?php
class AkbController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'Product.ah' => 'asc'
		)
	);
	public $filter_fields = array('Product.id' => 'int', 'Product.brand_id' => 'int', 'Product.model_id' => 'int', 'Product.sku' => 'text');
	public $model = 'Product';
	public $submenu = 'products';
	public $conditions = array('Product.category_id' => 3);
	public function _list() {
		parent::_list();
		$this->loadModel('Brand');
		$this->loadModel('BrandModel');
		$this->set('brands', $this->Brand->find('list', array('fields' => array('Brand.id', 'Brand.title'), 'order' => array('Brand.title' => 'asc'), 'conditions' => array('Brand.category_id' => 3))));
		if (isset($this->request->data['Product']['brand_id'])) {
			$this->set('models', $this->BrandModel->find('list', array('fields' => array('BrandModel.id', 'BrandModel.title'), 'conditions' => array('BrandModel.brand_id' => $this->request->data['Product']['brand_id']), 'order' => array('BrandModel.title' => 'asc'))));
		}
		else {
			$this->set('models', array('' => __d('admin_common', 'list_all_items')));
		}
		$this->set('all_models', $this->BrandModel->find('list', array('fields' => array('BrandModel.id', 'BrandModel.title'), 'order' => array('BrandModel.title' => 'asc'), 'conditions' => array('BrandModel.category_id' => 3))));
	}
	public function _edit($id) {
		$title = parent::_edit($id);
		$this->loadModel('Brand');
		$this->loadModel('BrandModel');
		$this->set('brands', $this->Brand->find('list', array('fields' => array('Brand.id', 'Brand.title'), 'order' => array('Brand.title' => 'asc'), 'conditions' => array('Brand.category_id' => 3))));
		if (isset($this->request->data['Product']['brand_id'])) {
			$this->set('models', $this->BrandModel->find('list', array('fields' => array('BrandModel.id', 'BrandModel.title'), 'conditions' => array('BrandModel.brand_id' => $this->request->data['Product']['brand_id']), 'order' => array('BrandModel.title' => 'asc'))));
		}
		else {
			$this->set('models', array('' => __d('admin_common', 'list_any_items')));
		}
		return $title;
	}
	public function admin_apply() {
		$filter = $this->redirectFields($this->model, null);
		$this->loadModel($this->model);
		if (!empty($this->request->data) && isset($this->request->data[$this->model])) {
			foreach ($this->request->data[$this->model] as $id => $item) {
				if (isset($item['price'])) {
					$save_data = array(
						'price' => $item['price'],
						'stock_count' => $item['stock_count']
					);
					$this->{$this->model}->id = $id;
					$this->{$this->model}->save($save_data, false);
				}
			}
			$this->info($this->t('message_data_saved'));
		}
		$url = array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list');
		$url = array_merge($url, $filter);
		$this->redirect($url);
	}
	public function admin_stockon($id = 0) {
		$this->_stock($id, 1);
	}
	public function admin_stockoff($id = 0) {
		$this->_stock($id, 0);
	}
	private function _stock($id, $state) {
		Configure::write('debug', 2);
		$this->layout = 'switcher';
		$this->set('id', $id);
		$this->set('url', '/admin/' . Inflector::underscore($this->name) . '/');
		$this->set('icon', 'stock');
		$this->set('url_enabled', 'stockon');
		$this->set('url_disabled', 'stockoff');
		$this->set('title_enabled', $this->t('title_stockon'));
		$this->set('title_disabled', $this->t('title_stockoff'));
		$this->set('prefix', 'stock');
		$this->loadModel($this->model);
		$this->{$this->model}->id = $id;
		if ($this->{$this->model}->saveField('in_stock', $state, false)) {
			$this->set('status', $state);
		}
		else {
			$this->set('status', abs($state - 1));
		}
		$this->render(false);
	}
	public function admin_clear() {
		$this->loadModel($this->model);
		$this->{$this->model}->deleteAll($this->conditions, true, true);
		$this->{$this->model}->query('UPDATE brands SET products_count=0,active_products_count=0 WHERE category_id=3');
		$this->{$this->model}->query('UPDATE brand_models SET products_count=0,active_products_count=0 WHERE category_id=3');
		$this->info($this->t('message_data_cleared'));
		$url = array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list');
		$this->redirect($url);
	}
	public function index() {
        $mode = 'block';
        if (isset($this->request->query['mode']) && in_array($this->request->query['mode'], array('block', 'list', 'table'))) {
            $mode = $this->request->query['mode'];
        }
        $view = 'models';
        if (isset($this->request->query['view'])) {
            $view = $this->request->query['view'];
        }
        $this->request->data['Product']['mode'] = $mode;
        $this->set('mode', $mode);

		$this->category_id = 3;


        $this->loadModel('Brand');
        $this->loadModel('BrandModel');
        $this->loadModel('Product');
        $models = $this->BrandModel->find('list', array('conditions' => array('BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.is_active' => 1, 'BrandModel.active_products_count > 0'), 'order' => array('BrandModel.title' => 'asc'), 'fields' => array('BrandModel.id', 'BrandModel.title')));
        $this->set('models', $models);

        $this->BrandModel->virtualFields['full_title'] = 'CONCAT(Brand.title,\' \',BrandModel.title)';
        $sort_orders = array(
            'price_asc' => array('Product.price' => 'ASC'),
            'price_desc' => array('Product.price' => 'DESC'),
            'name' => array('BrandModel.full_title' => 'ASC'),
        );

        $sort = 'price_asc';
        if (isset($this->request->query['sort']) && in_array($this->request->query['sort'], array('name', 'price_asc', 'price_desc'))) {
            $sort = $this->request->query['sort'];
        }

        $this->Product->bindModel(
            array(
                'belongsTo' => array(
                    'BrandModel' => array(
                        'foreignKey' => 'model_id'
                    ),
                    'Brand'
                )
            ),
            false
        );
		$conditions = array('Product.is_active' => 1, 'Product.category_id' => 3, 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
		if (isset($this->request->query['brand_id']) && !empty($this->request->query['brand_id'])) {
			$brand_id = intval($this->request->query['brand_id']);
			if ($brand_id != 0) {
				$this->loadModel('Brand');
				if ($brand = $this->Brand->find('first', array('conditions' => array('Brand.id' => $brand_id, 'Brand.is_active' => 1), 'fields' => array('Brand.slug')))) {
					$this->redirect(array('controller' => 'akb', 'action' => 'brand', 'slug' => $brand['Brand']['slug'], '?' => $this->request->query));
					return;
				}
			}
		}

		if (CONST_DISABLE_FILTERS == '0') {
			$filter_conditions = $this->get_conditions($conditions);
		}
		else {
			$filter_conditions = $conditions;
		}
		$this->_filter_akb_params($filter_conditions);
		if (isset($this->request->query['ah']) && !empty($this->request->query['ah'])) {
			$conditions['Product.ah'] = $this->request->query['ah'];
		}
		if (isset($this->request->query['f1']) && !empty($this->request->query['f1'])) {
			$conditions['Product.f1'] = $this->request->query['f1'];
		}
		if (isset($this->request->query['current']) && !empty($this->request->query['current'])) {
			$conditions['Product.current'] = $this->request->query['current'];
		}
		if (isset($this->request->query['width']) && !empty($this->request->query['width'])) {
			$conditions['Product.width'] = $this->request->query['width'];
		}
		if (isset($this->request->query['height']) && !empty($this->request->query['height'])) {
			$conditions['Product.height'] = $this->request->query['height'];
		}
		if (isset($this->request->query['length']) && !empty($this->request->query['length'])) {
			$conditions['Product.length'] = $this->request->query['length'];
		}
		$this->request->data['Product'] = $this->request->query;



		if (count($conditions) > 4) {
			$this->set('filter', $this->request->query);
			$this->paginate['limit'] = 30;
			$this->paginate['order'] = array('Product.price' => 'asc');
			$this->Product->bindModel(
				array(
					'belongsTo' => array(
						'Brand',
						'BrandModel' => array(
							'foreignKey' => 'model_id'
						)
					)
				),
				false
			);
			$products = $this->paginate('Product', $conditions);
			$this->set('products', $products);
		}
		else {
			//$this->loadModel('Brand');
			$this->set('all_brands', $this->Brand->find('all', array('order' => array('Brand.title' => 'asc'), 'conditions' => array('Brand.category_id' => $this->category_id, 'Brand.is_active' => 1, 'Brand.active_products_count > 0'), 'fields' => array('Brand.id', 'Brand.filename', 'Brand.slug', 'Brand.title'))));
		}
        $this->paginate['order'] = $sort_orders[$sort];
        $products = $this->paginate('Product', $conditions);
        $this->set('products', $products);
//        $this->set('brand', $brand);
        $this->set('models', $models);
        $this->set('view', $view);
        $this->set('sort', $sort);
//        $this->set('brand_models', $models);
//        $this->set('brand_id', $brand['Brand']['id']);
		$breadcrumbs = array();
		$breadcrumbs[] = array(
			'url' => null,
			'title' => 'Аккумуляторы'
		);
        $this->_filter_params($filter_conditions);
		$meta_title = 'Купить аккумуляторы Керчь, Феодосия Шинный центр Авто Дом';
		$meta_keywords = 'Купить, аккумуляторы, Керчь, Феодосия, Шинный центр Авто Дом';
		$meta_description = 'Шинный центр Авто Дом предлагает купить автомобильные аккумуляторы в Керчи и Феодосии по лучшим ценам, у нас бесплатная доставка и сервисное обслуживание.';
		$this->set('breadcrumbs', $breadcrumbs);
		$this->setMeta('title', $meta_title);
		$this->setMeta('keywords', $meta_keywords);
		$this->setMeta('description', $meta_description);
		$this->set('active_menu', 'akb');
		$this->set('additional_js', array('lightbox'));
		$this->set('additional_css', array('lightbox'));
        $this->set('show_filter', 3);
	}
	public function brand($slug) {
        $mode = 'block';
        if (isset($this->request->query['mode']) && in_array($this->request->query['mode'], array('block', 'table'))) {
            $mode = $this->request->query['mode'];
        }
        $this->set('mode', $mode);

		$this->category_id = 3;
		$this->loadModel('Brand');
        $this->loadModel('BrandModel');
        $this->loadModel('Product');

        $sort = 'price_asc';
        if (isset($this->request->query['sort']) && in_array($this->request->query['sort'], array('name', 'price_asc', 'price_desc'))) {
            $sort = $this->request->query['sort'];
        }

		if ($brand = $this->Brand->find('first', array('conditions' => array('Brand.is_active' => 1, 'Brand.category_id' => 3, 'Brand.slug' => $slug)))) {
			if (isset($this->request->query['brand_id'])) {
				$brand_id = intval($this->request->query['brand_id']);
                $sort_orders = array(
                    'price_asc' => array('Product.price' => 'ASC'),
                    'price_desc' => array('Product.price' => 'DESC'),
                    'name' => array('Product.title' => 'ASC'),
                );
				if ($brand['Brand']['id'] != $brand_id) {
					if ($brand_id == 0) {
						$filter = $this->request->query;
						unset($filter['brand_id']);
						unset($filter['model_id']);
						$this->redirect(array('controller' => 'akb', 'action' => 'index', '?' => $filter));
						return;
					}
					elseif ($new_brand = $this->Brand->find('first', array('conditions' => array('Brand.id' => $brand_id, 'Brand.is_active' => 1), 'fields' => array('Brand.slug')))) {
						$this->redirect(array('controller' => 'akb', 'action' => 'brand', 'slug' => $new_brand['Brand']['slug'], '?' => $this->request->query));
						return;
					}
					
				}
			}
			$conditions = array('Product.is_active', 'Product.brand_id' => $brand['Brand']['id'], 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
			if (CONST_DISABLE_FILTERS == '0') {
				$filter_conditions = $this->get_conditions($conditions);
			}
			else {
				$filter_conditions = $conditions;
			}
            $this->_filter_params($filter_conditions);
			$this->_filter_akb_params($filter_conditions);




			$models = $this->BrandModel->find('list', array('conditions' => array('BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.is_active' => 1, 'BrandModel.active_products_count > 0'), 'order' => array('BrandModel.title' => 'asc'), 'fields' => array('BrandModel.id', 'BrandModel.title')));
			$model_id = null;
			if (isset($this->request->query['model_id'])) {
				$model_id = intval($this->request->query['model_id']);
				if (!isset($models[$model_id])) {
					$model_id = null;
				}
			}
			if (!empty($model_id)) {
				$conditions['Product.model_id'] = $model_id;
				$this->set('model_id', $model_id);
			}
			if (isset($this->request->query['ah']) && !empty($this->request->query['ah'])) {
				$conditions['Product.ah'] = $this->request->query['ah'];
			}
			if (isset($this->request->query['f1']) && !empty($this->request->query['f1'])) {
				$conditions['Product.f1'] = $this->request->query['f1'];
			}			
			if (isset($this->request->query['current']) && !empty($this->request->query['current'])) {
				$conditions['Product.current'] = $this->request->query['current'];
			}
			if (isset($this->request->query['width']) && !empty($this->request->query['width'])) {
				$conditions['Product.width'] = $this->request->query['width'];
			}
			if (isset($this->request->query['height']) && !empty($this->request->query['height'])) {
				$conditions['Product.height'] = $this->request->query['height'];
			}
			if (isset($this->request->query['length']) && !empty($this->request->query['length'])) {
				$conditions['Product.length'] = $this->request->query['length'];
			}
			$this->request->data['Product'] = $this->request->query;
            $this->request->data['Product']['mode'] = $mode;
			$this->request->data['Product']['brand_id'] = $brand['Brand']['id'];
			$this->set('models', $models);
			$this->set('brand_models', $models);
			$breadcrumbs = array();
			$breadcrumbs[] = array(
				'url' => array('controller' => 'akb', 'action' => 'index'),
				'title' => 'Аккумуляторы'
			);
			$meta_title = !empty($brand['Brand']['meta_title']) ? $brand['Brand']['meta_title'] : $brand['Brand']['title'];
			$meta_keywords = $brand['Brand']['meta_keywords'];
			$meta_description = $brand['Brand']['meta_description'];
			if (!empty($model_id)) {
				$breadcrumbs[] = array(
					'url' => array('controller' => 'akb', 'action' => 'brand', 'slug' => $slug),
					'title' => $brand['Brand']['title']
				);
				$breadcrumbs[] = array(
					'url' => null,
					'title' => $models[$model_id]
				);
				if ($model = $this->BrandModel->find('first', array('conditions' => array('BrandModel.id' => $model_id)))) {
					$meta_title = $meta_title . ' ' . (!empty($model['BrandModel']['meta_title']) ? $model['BrandModel']['meta_title'] : $model['BrandModel']['title']);
					$meta_keywords = $model['BrandModel']['meta_keywords'];
					$meta_description = $model['BrandModel']['meta_description'];
					$this->set('model_content', $model['BrandModel']['content']);
				}
			}
			else {
				$breadcrumbs[] = array(
					'url' => null,
					'title' => $brand['Brand']['title']
				);
			}
			$this->set('breadcrumbs', $breadcrumbs);
			$this->paginate['limit'] = 30;

            $this->paginate['order'] = $sort_orders[$sort];
			$this->Product->bindModel(
				array(
					'belongsTo' => array(
						'BrandModel' => array(
							'foreignKey' => 'model_id'
						)
					)
				),
				false
			);
			$meta_title = 'Купить аккумуляторы Керчь, Феодосия Шинный центр Авто Дом';
			$meta_keywords = 'Купить, аккумуляторы, Керчь, Феодосия, Шинный центр Авто Дом';
			$meta_description = 'Шинный центр Авто Дом предлагает купить автомобильные аккумуляторы в Керчи и Феодосии по лучшим ценам, у нас бесплатная доставка и сервисное обслуживание.';
			$products = $this->paginate('Product', $conditions);

			$this->set('products', $products);
			$this->set('filter', $this->request->query);
			$this->set('brand_id', $brand['Brand']['id']);
			$this->setMeta('title', $meta_title);
			$this->setMeta('keywords', $meta_keywords);
			$this->setMeta('description', $meta_description);
			$this->set('brand', $brand);
            $this->set('sort', $sort);
			$this->set('active_menu', 'akb');
			$this->set('additional_js', array('lightbox'));
			$this->set('additional_css', array('lightbox'));
		}
		else {
			$this->response->statusCode(404);
			$this->response->send();
			$this->render(false);
			return;
		}
	}
	public function view($slug, $id) {
		$this->category_id = 3;
		$this->loadModel('Brand');
		if ($brand = $this->Brand->find('first', array('conditions' => array('Brand.is_active' => 1, 'Brand.category_id' => 3, 'Brand.slug' => $slug)))) {
			$this->loadModel('Product');
			$this->Product->bindModel(
				array(
					'belongsTo' => array(
						'BrandModel' => array(
							'foreignKey' => 'model_id'
						)
					)
				),
				false
			);
			if ($product = $this->Product->find('first', array('conditions' => array('Product.id' => $id, 'Product.brand_id' => $brand['Brand']['id'], 'Product.is_active' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0)))) {
				$this->loadModel('BrandModel');
				$models = $this->BrandModel->find('list', array('conditions' => array('BrandModel.brand_id' => $brand['Brand']['id'], 'BrandModel.is_active' => 1, 'BrandModel.active_products_count > 0'), 'order' => array('BrandModel.title' => 'asc'), 'fields' => array('BrandModel.id', 'BrandModel.title')));
				$breadcrumbs = array();
				$breadcrumbs[] = array(
					'url' => array('controller' => 'akb', 'action' => 'index'),
					'title' => 'Аккумуляторы'
				);
				$breadcrumbs[] = array(
					'url' => array('controller' => 'akb', 'action' => 'brand', 'slug' => $slug),
					'title' => $brand['Brand']['title']
				);
				$breadcrumbs[] = array(
					'url' => array('controller' => 'akb', 'action' => 'brand', 'slug' => $slug, '?' => array('model_id' => $product['Product']['model_id'])),
					'title' => $product['BrandModel']['title']
				);
				$sku = $brand['Brand']['title'] . ' ' . $product['BrandModel']['title'] . ' ' . $product['Product']['ah'] . 'ач ' . $product['Product']['f1'];
				$breadcrumbs[] = array(
					'url' => null,
					'title' => $sku
				);
				$this->set('breadcrumbs', $breadcrumbs);
				$this->set('additional_js', array('lightbox'));
				$this->set('additional_css', array('lightbox'));
				$this->set('models', $models);
				$this->set('brand_id', $brand['Brand']['id']);
				$this->set('model_id', $product['Product']['model_id']);
				$this->setMeta('title', $sku);
				$this->setMeta('keywords', $product['BrandModel']['meta_keywords']);
				$this->setMeta('description', $product['BrandModel']['meta_description']);
				$this->set('brand', $brand);
				$this->set('product', $product);
				$this->set('active_menu', 'akb');
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
	public function set_filter() {
		$conditions = array(
			'Product.is_active' => 1,
			'Product.category_id' => 3,
			'Product.price > ' => 0,
			'Product.stock_count > ' => 0
		);
		if (CONST_DISABLE_FILTERS == '0') {
			$conditions = $this->get_conditions($conditions);
			if (isset($this->request->query['brand_id']) && !empty($this->request->query['brand_id'])) {
				$brand_id = intval($this->request->query['brand_id']);
				if ($brand_id != 0) {
					$conditions['Product.brand_id'] = $this->request->query['brand_id'];
				}
			}
		}
		$result = $this->_filter_akb_params($conditions);
		echo json_encode($result);
		$this->layout = false;
		$this->render(false);
	}
	private function get_conditions($conditions) {
		if (isset($this->request->query['ah']) && !empty($this->request->query['ah'])) {
			$conditions['Product.ah'] = $this->request->query['ah'];
		}
		if (isset($this->request->query['f1']) && !empty($this->request->query['f1'])) {
			$conditions['Product.f1'] = $this->request->query['f1'];
		}
		if (isset($this->request->query['current']) && !empty($this->request->query['current'])) {
			$conditions['Product.current'] = $this->request->query['current'];
		}
		if (isset($this->request->query['width']) && !empty($this->request->query['width'])) {
			$conditions['Product.width'] = $this->request->query['width'];
		}
		if (isset($this->request->query['height']) && !empty($this->request->query['height'])) {
			$conditions['Product.height'] = $this->request->query['height'];
		}
		if (isset($this->request->query['length']) && !empty($this->request->query['length'])) {
			$conditions['Product.length'] = $this->request->query['length'];
		}
		return $conditions;
	}
	private function _filter_akb_params($conditions = array()) {
		$this->loadModel('Product');
		$temp_cond = $conditions;
		unset($temp_cond['Product.ah']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.ah', 'order' => 'Product.ah'));
		$akb_ah = array();
		foreach ($products as $item) {
			$ah = $item['Product']['ah'];
			if ($ah > 0) {
				$akb_ah[$ah] = $ah . 'ач';
			}
		}
		natsort($akb_ah);
		$temp_cond = $conditions;
		unset($temp_cond['Product.current']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.current', 'order' => 'Product.current'));
		$akb_current = array();
		foreach ($products as $item) {
			$current = $item['Product']['current'];
			if ($current > 0) {
				$akb_current[$current] = $current;
			}
		}
		natsort($akb_f1);
		$temp_cond = $conditions;
		unset($temp_cond['Product.current']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.current', 'order' => 'Product.current'));
		$akb_current = array();
		foreach ($products as $item) {
			$current = $item['Product']['current'];
			if ($current > 0) {
				$akb_current[$current] = $current;
			}
		}		
		natsort($akb_current);
		$temp_cond = $conditions;
		unset($temp_cond['Product.length']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.length', 'order' => 'Product.length'));
		$akb_length = array();
		foreach ($products as $item) {
			$length = $item['Product']['length'];
			if ($length > 0) {
				$akb_length[$length] = $length;
			}
		}
		natsort($akb_length);
		$temp_cond = $conditions;
		unset($temp_cond['Product.width']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.width', 'order' => 'Product.width'));
		$akb_width = array();
		foreach ($products as $item) {
			$width = $item['Product']['width'];
			if ($width > 0) {
				$akb_width[$width] = $width;
			}
		}
		natsort($akb_width);
		$temp_cond = $conditions;
		unset($temp_cond['Product.height']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.height', 'order' => 'Product.height'));
		$akb_height = array();
		foreach ($products as $item) {
			$height = $item['Product']['height'];
			if ($height > 0) {
				$akb_height[$height] = $height;
			}
		}
		natsort($akb_height);
		unset($conditions['Product.brand_id']);
		$brand_ids = $this->Product->find('list', array(
			'fields' => array('Product.brand_id'),
			'conditions' => $conditions
		));
		$brand_ids = array_unique($brand_ids);
		$brand_conditions = array('Brand.category_id' => 3, 'Brand.is_active' => 1, 'Brand.active_products_count > 0');
		$brand_conditions['Brand.id'] = $brand_ids;
		$this->loadModel('Brand');
		$brands = $this->Brand->find('list', array('order' => array('Brand.title' => 'asc'), 'conditions' => $brand_conditions, 'fields' => array('Brand.id', 'Brand.title')));
		if ($this->request->is('ajax')) {
			$result = array(
				'ah' => $akb_ah,
				'current' => $akb_current,
				'length' => $akb_length,
				'width' => $akb_width,
				'height' => $akb_height,
				'f1' => $akb_f1,
				'brand_id' => $brands
			);
			return $result;
		}
		else {
			$this->set('akb_ah', $akb_ah);
			$this->set('akb_current', $akb_current);
			$this->set('akb_length', $akb_length);
			$this->set('akb_width', $akb_width);
			$this->set('akb_height', $akb_height);
			$this->set('akb_f1', $akb_f1);
			$this->set('show_filter', 3);
			$this->set('filter_brands', $brands);
		}
	}
}