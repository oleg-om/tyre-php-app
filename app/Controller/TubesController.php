<?php
class TubesController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'Product.sku' => 'asc'
		)
	);
	public $filter_fields = array('Product.id' => 'int', 'Product.type' => 'text', 'Product.sku' => 'text');
	public $model = 'Product';
	public $submenu = 'products';
	public $conditions = array('Product.category_id' => 4);
	public function _list() {
		parent::_list();
		$this->set('types', $this->Product->types);
	}
	public function _edit($id) {
		$title = parent::_edit($id);
		$this->set('types', $this->Product->types);
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
		$this->{$this->model}->query('UPDATE brands SET products_count=0,active_products_count=0 WHERE category_id=4');
		$this->{$this->model}->query('UPDATE brand_models SET products_count=0,active_products_count=0 WHERE category_id=4');
		$this->info($this->t('message_data_cleared'));
		$url = array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list');
		$this->redirect($url);
	}

    public function check_truck($auto) {
        $is_truck_page = $this->request->query['auto'] == 'trucks' || $this->request->query['auto'] == 'agricultural' || $this->request->query['auto'] == 'special'  || $this->request->query['auto'] == 'loader';

        $path = 'tubes';
        if ($is_truck_page) {
            $path = 'truck-tubes';
        }

        if (!empty($auto)) {
            if ($auto === 'trucks' || $auto === 'agricultural' || $auto === 'special' || $auto === 'loader') {
                $path = 'truck-tubes';
            }
        }

        return array('path' => $path);
    }

	public function index() {
        $mode = 'block';
        if (isset($this->request->query['mode']) && in_array($this->request->query['mode'], array('block', 'list', 'table'))) {
            $mode = $this->request->query['mode'];
        }
        $this->request->data['Product']['mode'] = $mode;
        $this->set('mode', $mode);

        $limit = 30;
        if (isset($this->request->query['limit']) && in_array($this->request->query['limit'], array('10', '20', '30', '50'))) {
            $limit = $this->request->query['limit'];
        }
        $this->paginate['limit'] = $limit;
        $this->set('limit', $limit);


		$conditions = array('Product.is_active' => 1, 'Product.category_id' => 4, 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
		if (isset($this->request->query['type']) && !empty($this->request->query['type'])) {
			$conditions['Product.type'] = $this->request->query['type'];
		}
		if (isset($this->request->query['info']) && !empty($this->request->query['info'])) {
			$conditions['Product.sku LIKE'] = '%' . $this->request->query['info'] . '%';
		}
		if (isset($this->request->query['in_stock']) && $this->request->query['in_stock']) {
			$conditions['Product.in_stock'] = 1;
		}
		$this->loadModel('Product');
		$this->request->data['Product'] = $this->request->query;
		$this->set('filter', $this->request->query);
        $auto = $this->request->query['auto'];
		$this->paginate['order'] = array('Product.price' => 'asc');
		$products = $this->paginate('Product', $conditions);
		$this->set('products', $products);
		$title = $meta_title = 'Автокамеры';
		$breadcrumbs = array();
		$breadcrumbs[] = array(
			'url' => null,
			'title' => $title
		);
		$this->set('breadcrumbs', $breadcrumbs);
		$this->setMeta('title', $meta_title);
		$this->set('types', $this->Product->types);
		$this->set('additional_js', array('lightbox'));
		$this->set('additional_css', array('lightbox'));
		$this->set('show_filter', 6);
        $path = $this->check_truck($auto)['path'];
        $this->set('active_menu', $path);
	}
	public function view($id) {
		$this->loadModel('Product');
		if ($product = $this->Product->find('first', array('conditions' => array('Product.id' => $id, 'Product.category_id' => 4, 'Product.is_active' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0)))) {
			$this->set('types', $this->Product->types);
			$title = 'Автокамеры';
			$breadcrumbs = array();
			$breadcrumbs[] = array(
				'url' => array('controller' => 'tubes', 'action' => 'index'),
				'title' => $title
			);
			$breadcrumbs[] = array(
				'url' => null,
				'title' => $this->Product->types[$product['Product']['type']] . ' ' . $product['Product']['sku']
			);
			$this->set('breadcrumbs', $breadcrumbs);
			$this->set('additional_js', array('lightbox'));
			$this->set('additional_css', array('lightbox'));
			$this->setMeta('title', $this->Product->types[$product['Product']['type']] . ' ' . $product['Product']['sku']);
			$this->set('product', $product);
            $path = $this->check_truck($product['Product']['auto'])['path'];
            $this->set('active_menu', $path);
		}
		else {
			$this->response->statusCode(404);
			$this->response->send();
			$this->render(false);
			return;
		}
	}
}