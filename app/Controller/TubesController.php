<?php
class TubesController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'Product.sku' => 'asc'
		)
	);
	public $filter_fields = array('Product.id' => 'int', 'Product.type' => 'text', 'Product.sku' => 'text', 'Product.supplier_id' => 'int');
	public $model = 'Product';
	public $submenu = 'products';
	public $conditions = array('Product.category_id' => 4);
	public function _list() {
		parent::_list();
		$this->set('types', $this->Product->types);
		$this->loadModel('Supplier');
        $this->set('suppliers', $this->Supplier->find('list', array('fields' => array('Supplier.id', 'Supplier.title'), 'order' => array('Supplier.title' => 'asc'))));
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
		// Отключаем пересчет счетчиков в afterDelete для ускорения массового удаления
		Configure::write('Product.skip_recount_on_delete', true);
		$this->{$this->model}->deleteAll($this->conditions, true, true);
		Configure::write('Product.skip_recount_on_delete', false);
		// Обнуляем счетчики одним запросом после удаления
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
        if (isset($this->request->query['mode']) && in_array($this->request->query['mode'], array('block', 'table'))) {
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
        if (isset($this->request->query['in_stock'])) {
            if ($this->request->query['in_stock'] == 1) {
                $conditions['Product.in_stock'] = 1;
            }
            elseif ($this->request->query['in_stock'] == 0) {
                $conditions['Product.in_stock'] = 0;
            }
        }
        else {
            $this->request->query['in_stock'] = 2;
            $conditions['Product.in_stock'] = 2;
        }
        if (isset($this->request->query['size3']) && !empty($this->request->query['size3'])) {
            $conditions['Product.size3'] = $this->_get_sizes($this->request->query['size3']);
        }
        if (isset($this->request->query['auto']) && !empty($this->request->query['auto'])) {
            $conditions['Product.auto'] = $this->request->query['auto'];
        }
        $this->_filter_tubes_params($conditions);
		$this->loadModel('Product');
        $this->loadModel('BrandModel');

        $models = $this->BrandModel->find('list', array('conditions' => array('BrandModel.category_id' => 4, 'BrandModel.is_active' => 1, 'BrandModel.active_products_count > 0'), 'order' => array('BrandModel.title' => 'asc'), 'fields' => array('BrandModel.id', 'BrandModel.title', 'BrandModel.valve')));
        $this->set('models', $models);


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
        $this->set('show_left_filter', true);
	}
	public function view($id) {
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
		if ($product = $this->Product->find('first', array('conditions' => array('Product.id' => $id, 'Product.category_id' => 4, 'Product.is_active' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0)))) {
            $this->loadModel('BrandModel');
            $this->set('types', $this->Product->types);
			$title = 'Автокамеры';
            $path = $this->check_truck($product['Product']['auto'])['path'];
			$breadcrumbs = array();
            if ($path == 'truck-tubes') {
                $breadcrumbs[] = array(
                    'url' => array('controller' => 'tubes', 'action' => 'index', '?' => array('auto' => 'trucks', 'in_stock' => 2)),
                    'title' => $title
                );
            } else {
                $breadcrumbs[] = array(
                    'url' => array('controller' => 'tubes', 'action' => 'index'),
                    'title' => $title
                );
            }

			$breadcrumbs[] = array(
				'url' => null,
				'title' => $this->Product->types[$product['Product']['type']] . ' ' . $product['Product']['sku']
			);
			$this->set('breadcrumbs', $breadcrumbs);
			$this->set('additional_js', array('lightbox'));
			$this->set('additional_css', array('lightbox'));
			$this->setMeta('title', $this->Product->types[$product['Product']['type']] . ' ' . $product['Product']['sku']);
			$this->set('product', $product);
            $this->set('active_menu', $path);
            $this->set('show_left_menu', false);
		}
		else {
			$this->response->statusCode(404);
			$this->response->send();
			$this->render(false);
			return;
		}
	}

    private function _filter_tubes_params($conditions = array()) {
        $this->loadModel('Product');
        $temp_cond = $conditions;
        unset($temp_cond['Product.type']);
        $products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.type', 'order' => 'Product.type'));
        $tubes_type = array();
        foreach ($products as $item) {
            $type = $item['Product']['type'];
            $tubes_type[$type] = $this->Product->types[$type];
        }
        natsort($tubes_type);
        $temp_cond = $conditions;
        unset($temp_cond['Product.size3']);
        $products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.size3', 'order' => 'Product.size3'));
        $tubes_size3 = array();
        foreach ($products as $item) {
            $numeric_size = str_replace(',', '.', $item['Product']['size3']);
            if (is_numeric($numeric_size)) {
                $size = number_format(str_replace(',', '.', $item['Product']['size3']), 1, '.', '');
                if (!empty($size) && $size != '') {
                    $size = str_replace('.0', '', $size);
                    $tubes_size3[$size] = $size;
                }
            }
            else {
                $size = trim($item['Product']['size3']);
                if (!empty($size) && $size != '') {
                    $tubes_size3[$size] = $size;
                }
            }
        }
        natsort($tubes_size3);
        $temp_cond = $conditions;
        unset($temp_cond['Product.auto']);
        $products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.auto', 'order' => 'Product.auto'));
        $truck_auto = array();
        $light_auto = array();

        $truck_cars = array('trucks','agricultural','special','loader');
        $usual_cars = array('cars','light_trucks');

        foreach ($products as $item) {
            if (isset($this->Product->auto[$item['Product']['auto']])) {
                $auto[$item['Product']['auto']] = $this->Product->auto[$item['Product']['auto']];

                if (in_array($item['Product']['auto'], $truck_cars)) {
                    $truck_auto[$item['Product']['auto']] = $this->Product->auto[$item['Product']['auto']];
                }
                if (in_array($item['Product']['auto'], $usual_cars)) {
                    $light_auto[$item['Product']['auto']] = $this->Product->auto[$item['Product']['auto']];
                }
            }
        }

        if ($this->request->is('ajax')) {
            $result = array(
                'tubes_type' => $tubes_type,
                'tubes_size3' => $tubes_size3
            );
            return $result;
        }
        else {
            $this->set('tubes_type', $tubes_type);
            $this->set('tubes_size3', $tubes_size3);
            $this->set('filter_truck_auto', $truck_auto);
            $this->set('filter_light_auto', $light_auto);
        }
    }

    private function _get_sizes($size) {
        if (substr_count($size, '.') > 0) {
            $sizes = array(
                $size,
                str_replace('.', ',', $size)
            );
            $parts = explode('.', $size);
            if (strlen($parts[1]) == 2 && substr($parts[1], 1) == '0') {
                $new_size = substr($size, 0, -1);
                $sizes[] = $new_size;
                $sizes[] = str_replace('.', ',', $new_size);
            }
            elseif (strlen($parts[1]) == 1) {
                $new_size = $size . '0';
                $sizes[] = $new_size;
                $sizes[] = str_replace('.', ',', $new_size);
            }
            return $sizes;
        }
        else {
            return $size;
        }
    }
}
