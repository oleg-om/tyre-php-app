<?php
class StorageRequestsController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'StorageRequest.created' => 'desc'
		)
	);
	public $filter_fields = array('StorageRequest.request_id' => 'text', 'StorageRequest.station_id' => 'int', 'StorageRequest.phone' => 'text', 'StorageRequest.date_from' => 'from', 'StorageRequest.date_to' => 'to', 'StorageRequest.created_from' => 'from', 'StorageRequest.created_to' => 'to');
	public $model = 'StorageRequest';
	public $submenu = 'storage_requests';
	public function _list() {
		parent::_list();
		$this->loadModel('Station');
		$this->set('stations', $this->Station->find('list', array('order' => array('Station.sort_order' => 'asc'))));
	}
	public function admin_view($id) {
		$this->loadModel('StorageRequest');
		$this->StorageRequest->bindModel(
			array(
				'belongsTo' => array(
					'Station',
					'CarBrand' => array(
						'foreignKey' => 'car_brand_id'
					),
					'CarModel' => array(
						'foreignKey' => 'car_model_id'
					),
					'Brand' => array(
						'foreignKey' => 'brand_id'
					),
					'BrandModel' => array(
						'foreignKey' => 'model_id'
					)
				),
				'hasMany' => array(
					'StorageRequestService'
				)
			),
			false
		);
		if ($request = $this->StorageRequest->find('first', array('conditions' => array('StorageRequest.id' => $id)))) {
			$this->loadModel('Price');
			$prices = $this->Price->find('all', array('conditions' => array('Price.is_active' => 1), 'order' => array('Price.sort_order' => 'asc')));
			if ($prices = $this->Price->find('all')) {
				foreach ($prices as $item) {
					$prices_list[$item['Price']['id']] = $item;
				}
			}
			$this->loadModel('Product');
			$this->loadModel('BrandModel');
			$this->loadModel('Currency');
			$currencies = $this->Currency->find('all', array('conditions' => array('Currency.is_active' => 1), 'order' => array('Currency.sort_order' => 'asc')));
			$this->set('types', $this->Price->types);
			$this->set('seasons', $this->Product->seasons);
			$this->set('materials', $this->BrandModel->materials);
			$this->set('prices', $prices_list);
			$this->set('currencies', $currencies);
			$this->set('request', $request);
			$this->set('id', $id);
		}
		else {
			$this->response->statusCode(404);
			$this->response->send();
			$this->render(false);
			return;
		}
		$this->set('section', $this->getSection($this->getSubmenu()));
		$this->set('submenu', $this->getSubmenu());
		$this->set('action', 'admin_list');
		$this->set('title_for_layout', $this->t('title_view', $request['StorageRequest']['request_id']));
		$this->layout = 'admin';
		$this->render('admin_view');
	}
	public function index() {
		$this->loadModel('Station');
		$this->loadModel('Price');
		$this->loadModel('Product');
		$this->loadModel('Brand');
		$this->loadModel('BrandModel');
		$this->loadModel('CarBrand');
		$this->loadModel('CarModel');
		$prices = $this->Price->find('all', array('conditions' => array('Price.is_active' => 1), 'order' => array('Price.sort_order' => 'asc')));
		if (!empty($this->request->data['StorageRequest'])) {
			$this->loadModel('StorageRequest');
			$services = array();
			$total = 0;
			foreach ($prices as $item) {
				if (isset($this->request->data['StorageRequest']['price_id_' . $item['Price']['id']]) && $this->request->data['StorageRequest']['price_id_' . $item['Price']['id']] == '1') {
					$qty = intval($this->request->data['StorageRequest']['quantity_' . $item['Price']['id']]);
					if ($qty > 0) {
						$services[] = array(
							'title' => $item['Price']['title'],
							'price_id' => $item['Price']['id'],
							'quantity' => $qty,
							'price' => $item['Price']['price'],
							'total' => $item['Price']['price'] * $qty
						);
						$total += $item['Price']['price'] * $qty;
					}
				}
			}
			if (!empty($services)) {
				$station_title = $brand_name = $model_name = $car_brand_name = $car_model_name = '';
				if (!empty($this->request->data['StorageRequest']['station_id'])) {
					$this->Station->id = $this->request->data['StorageRequest']['station_id'];
					if ($station = $this->Station->read(array('title'))) {
						$station_title = $station['Station']['title'];
					}
				}
				if (!empty($this->request->data['StorageRequest']['car_brand_id'])) {
					$this->CarBrand->id = $this->request->data['StorageRequest']['car_brand_id'];
					if ($brand = $this->CarBrand->read(array('title'))) {
						$car_brand_name = $brand['CarBrand']['title'];
					}
				}
				if (!empty($this->request->data['StorageRequest']['car_model_id'])) {
					$this->CarModel->id = $this->request->data['StorageRequest']['car_model_id'];
					if ($model = $this->CarModel->read(array('title'))) {
						$car_model_name = $model['CarModel']['title'];
					}
				}
				if (!empty($this->request->data['StorageRequest']['brand_id'])) {
					$this->Brand->id = $this->request->data['StorageRequest']['brand_id'];
					if ($brand = $this->Brand->read(array('title'))) {
						$brand_name = $brand['Brand']['title'];
					}
				}
				if (!empty($this->request->data['StorageRequest']['model_id'])) {
					$this->BrandModel->id = $this->request->data['StorageRequest']['model_id'];
					if ($model = $this->BrandModel->read(array('title'))) {
						$model_name = $model['BrandModel']['title'];
					}
				}
				$this->request->data['StorageRequest']['total_price'] = $total;
				$tyre_info = $disk_info = '';
				$tyre_info = $brand_name . ' ' . $model_name;
				$tyre_info .= ' ' . $this->request->data['StorageRequest']['size1'] . '/' . $this->request->data['StorageRequest']['size2'] . ' R' . $this->request->data['StorageRequest']['size3'];
				if (!empty($this->request->data['StorageRequest']['season'])) {
					$tyre_info .= ' (' . $this->Product->seasons[$this->request->data['StorageRequest']['season']] . ')';
				}
				if (!empty($this->request->data['StorageRequest']['radius'])) {
					$disk_info = 'R' . $this->request->data['StorageRequest']['radius'];
				}
				if (!empty($this->request->data['StorageRequest']['material'])) {
					$disk_info .= ' ' . $this->BrandModel->materials[$this->request->data['StorageRequest']['material']];
				}
				if ($this->StorageRequest->save($this->request->data)) {
					$request_id = $this->StorageRequest->id;
					$this->loadModel('StorageRequestService');
					$ordered_services = array();
					foreach ($services as $item) {
						$save_data = $item;
						$save_data['storage_request_id'] = $request_id;
						$this->StorageRequestService->create();
						$this->StorageRequestService->save($save_data);
						$ordered_services[] = '<li>' . $save_data['title'] . ', ' . $save_data['quantity'] . ' шт. — ' . $this->getStoragePrice($save_data['price'] * $save_data['quantity']) . '</li>' . "\n";
					}
					$notification_emails = explode(',', CONST_STORAGE_REQUEST_EMAILS);
					foreach ($notification_emails as $email) {
						$email = trim($email);
						$this->Sender->sendEmail(
							$email,
							'storage_request',
							array(
								'station_title' => h($station_title),
								'date' => h($this->request->data['StorageRequest']['date']),
								'time' => h($this->request->data['StorageRequest']['time']),
								'number' => h($this->request->data['StorageRequest']['number']),
								'name' => h($this->request->data['StorageRequest']['name']),
								'phone' => h($this->request->data['StorageRequest']['phone']),
								'email' => h($this->request->data['StorageRequest']['email']),
								'brand' => h($car_brand_name),
								'model' => h($car_model_name),
								'services' => '<ol>' . implode(' ', $ordered_services) . '</ol>' . "\n",
								'total' => $this->getStoragePrice($total),
								'tyre_info' => h($tyre_info),
								'treadwear' => h($this->request->data['StorageRequest']['treadwear']),
								'tyre_condition' => h($this->request->data['StorageRequest']['tyre_condition']),
								'disk_condition' => h($this->request->data['StorageRequest']['disk_condition']),
								'disk_info' => h($disk_info)
							)
						);
					}
					$this->info('Спасибо! Ваша заявка принята в обработку');
					$this->redirect(array('controller' => 'storage_requests', 'action' => 'index'));
				}
			}
			else {
				$this->error('Выберите услуги');
			}
		}
		$this->loadModel('Page');
		if ($page = $this->Page->find('first', array('conditions' => array('Page.is_active' => 1, 'Page.slug' => 'storage')))) {
			$this->setMeta('title', !empty($page['Page']['meta_title']) ? $page['Page']['meta_title'] : $page['Page']['title']);
			$this->setMeta('keywords', $page['Page']['meta_keywords']);
			$this->setMeta('description', $page['Page']['meta_description']);
			$this->set('page', $page);
			$this->set('active_menu', 'storage');
		}
		$this->set('prices', $prices);
		$this->set('stations', $this->Station->find('all', array('conditions' => array('Station.is_active' => 1), 'order' => array('Station.sort_order' => 'asc'))));
		$this->_filter_params();
		$this->_filter_disc_params();
		$this->set('car_brands', $this->CarBrand->find('list', array('fields' => array('CarBrand.id', 'CarBrand.title'), 'order' => array('CarBrand.title' => 'asc'))));
		if (isset($this->request->data['StorageRequest']['car_brand_id'])) {
			$this->set('car_models', $this->CarModel->find('list', array('fields' => array('CarModel.id', 'CarModel.title'), 'conditions' => array('CarModel.brand_id' => $this->request->data['StorageRequest']['car_brand_id']), 'order' => array('CarModel.title' => 'asc'))));
		}
		else {
			$this->set('car_models', array());
		}
		$this->set('additional_js', array('jquery.timepicker.min', 'bootstrap-datepicker'));
		$this->set('additional_css', array('jquery.timepicker', 'bootstrap-datepicker'));
	}
	protected function _filter_params($filter_conditions = null) {
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
		//unset($filter_conditions['Product.model_id']);
		$conditions = array('Product.category_id' => 1);
		if ($filter_conditions) {
			$conditions = $filter_conditions;
		}
		$temp_cond = $conditions;
		unset($temp_cond['Product.size1']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.size1', 'order' => 'Product.size1'));
		
		$tyre_size1 = array();
		foreach ($products as $item) {
			$size = number_format(str_replace(',', '.', $item['Product']['size1']), 2, '.', '');
			$size = str_replace('.00', '', $size);
			$tyre_size1[$size] = $size;
		}
		natsort($tyre_size1);
		unset($tyre_size1[0]);
		$temp_cond = $conditions;
		unset($temp_cond['Product.size2']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.size2', 'order' => 'Product.size2'));
		$tyre_size2 = array();
		foreach ($products as $item) {
			$size = number_format(floatval(str_replace(',', '.', $item['Product']['size2'])), 1, '.', '');
			if (!empty($size) && $size != '') {
				$size = str_replace('.0', '', $size);
				$tyre_size2[$size] = $size;
			}
		}
		natsort($tyre_size2);
		unset($tyre_size2[0]);
		$temp_cond = $conditions;
		unset($temp_cond['Product.size3']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.size3', 'order' => 'Product.size3'));
		$tyre_size3 = array();
		foreach ($products as $item) {
			$numeric_size = str_replace(',', '.', $item['Product']['size3']);
			if (is_numeric($numeric_size)) {
				$size = number_format(str_replace(',', '.', $item['Product']['size3']), 1, '.', '');
				if (!empty($size) && $size != '') {
					$size = str_replace('.0', '', $size);
					$tyre_size3[$size] = $size;
				}
			}
			else {
				$size = trim($item['Product']['size3']);
				if (!empty($size) && $size != '') {
					$tyre_size3[$size] = $size;
				}
			}
		}
		natsort($tyre_size3);
		unset($tyre_size3[0]);
		$seasons = $this->Product->seasons;
		$brand_conditions = array('Brand.category_id' => 1);
		$this->loadModel('Brand');
		$brands = $this->Brand->find('list', array('order' => array('Brand.title' => 'asc'), 'conditions' => $brand_conditions, 'fields' => array('Brand.id', 'Brand.title')));
		$models = array();
		if (isset($conditions['Product.brand_id'])) {
			$temp_cond = $conditions;
			unset($temp_cond['Product.model_id']);
			$models = $this->Product->find('all', array(
				'fields' => array('Product.model_id'),
				'conditions' => $temp_cond
			));
			
			$model_ids = array();
			foreach ($models as $model) {
				if (!in_array($model['Product']['model_id'], $model_ids)) {
					$model_ids[] = $model['Product']['model_id'];
				}
			}
			$model_conditions = array('BrandModel.category_id' => 1);
			$model_conditions['BrandModel.id'] = $model_ids;
			$this->loadModel('BrandModel');
			$models = $this->BrandModel->find('list', array('order' => array('BrandModel.title' => 'asc'), 'conditions' => $model_conditions, 'fields' => array('BrandModel.id', 'BrandModel.title')));
		}
		if ($this->request->is('ajax')) {
			$result = array(
				'size1' => $tyre_size1,
				'size2' => $tyre_size2,
				'size3' => $tyre_size3,
				'season' => $seasons,
				'brand_id' => $brands,
				'model_id' => $models

			);
			return $result;
		}
		else {
			$this->set('tyre_size1', $tyre_size1);
			$this->set('tyre_size2', $tyre_size2);
			$this->set('tyre_size3', $tyre_size3);
			$this->set('tyre_seasons', $seasons);
			$this->set('tyre_brands', $brands);
			$this->set('tyre_models', $models);
		}
	}
	private function get_conditions($conditions) {
		if (isset($this->request->query['data']['StorageRequest']['season']) && !empty($this->request->query['data']['StorageRequest']['season'])) {
			$conditions[] = array(
				'or' => array(
					array(
						'BrandModel.season IS NOT NULL',
						'BrandModel.season' => $this->request->query['data']['StorageRequest']['season']
					),
					array(
						'BrandModel.season IS NULL',
						'Product.season' => $this->request->query['data']['StorageRequest']['season']
					)
				)
			);
			if (is_array($this->request->query['data']['StorageRequest']['season'])) {
				if (count($this->request->query['data']['StorageRequest']['season']) == 1) {
					$this->request->data['Product']['season'] = $this->request->query['data']['StorageRequest']['season'][0];
				} else {
					unset($this->request->data['Product']['season']);
				}
			}
		}
		if (isset($this->request->query['data']['StorageRequest']['size1']) && !empty($this->request->query['data']['StorageRequest']['size1'])) {
			$conditions['Product.size1'] = $this->_get_sizes($this->request->query['data']['StorageRequest']['size1']);
		}
		if (isset($this->request->query['data']['StorageRequest']['size2']) && !empty($this->request->query['data']['StorageRequest']['size2'])) {
			$conditions['Product.size2'] = $this->_get_sizes($this->request->query['data']['StorageRequest']['size2']);
		}
		if (isset($this->request->query['data']['StorageRequest']['size3']) && !empty($this->request->query['data']['StorageRequest']['size3'])) {
			$conditions['Product.size3'] = $this->_get_sizes($this->request->query['data']['StorageRequest']['size3']);
		}
		return $conditions;
	}
	public function set_filter() {
		Configure::write('debug', 0);
		$conditions = array('Product.category_id' => 1);
		$conditions = $this->get_conditions($conditions);
		if (isset($this->request->query['data']['StorageRequest']['brand_id']) && !empty($this->request->query['data']['StorageRequest']['brand_id'])) {
			$brand_id = intval($this->request->query['data']['StorageRequest']['brand_id']);
			if ($brand_id != 0) {
				$conditions['Product.brand_id'] = $this->request->query['data']['StorageRequest']['brand_id'];
			}
		}
		if (isset($this->request->query['data']['StorageRequest']['model_id']) && !empty($this->request->query['data']['StorageRequest']['model_id'])) {
			$model_id = intval($this->request->query['data']['StorageRequest']['model_id']);
			if ($model_id != 0) {
				$conditions['Product.model_id'] = $this->request->query['data']['StorageRequest']['model_id'];
			}
		}
		$result = $this->_filter_params($conditions);
		echo json_encode($result);
		$this->layout = false;
		$this->render(false);
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
	protected function _filter_disc_params($filter_conditions = null) {
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
		unset($filter_conditions['Product.model_id']);
		$conditions = array('Product.category_id' => 2);
		if ($filter_conditions) { $conditions = $filter_conditions;}
		$temp_cond = $conditions;
		unset($temp_cond['Product.size1']);
		
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.size1', 'order' => 'Product.size1'));

		$disk_size1 = array();
		foreach ($products as $item) {
			$size = intval($item['Product']['size1']);
			if ($size > 0) {
				$disk_size1[$size] = $size;
			}
		}
		natsort($disk_size1);

		$materials = $this->BrandModel->materials;
		if ($this->request->is('ajax')) {
			$result = array(
				'size1' => $disk_size1,
				'material' => $materials
			);
			return $result;
		} else {
			
			$this->set('disk_size1', $disk_size1);
			$this->set('materials', $materials);
		}
		
	}
	public function _edit($id) {
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
		return $title;
	}
}