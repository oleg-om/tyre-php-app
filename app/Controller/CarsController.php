<?php
class CarsController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'Car.year' => 'asc'
		)
	);
	public $filter_fields = array('Car.id' => 'int', 'Car.brand_id' => 'int', 'Car.model_id' => 'int', 'Car.modification_id' => 'int', 'Car.year' => 'text');
	public $model = 'Car';
	public $submenu = 'cars';
	public function _list() {
		parent::_list();
		$this->loadModel('CarBrand');
		$this->loadModel('CarModel');
		$this->loadModel('CarModification');
		$this->set('brands', $this->CarBrand->find('list', array('fields' => array('CarBrand.id', 'CarBrand.title'), 'order' => array('CarBrand.title' => 'asc'))));
		if (isset($this->request->data['Car']['brand_slug'])) {
			$this->set('models', $this->CarModel->find('list', array('fields' => array('CarModel.id', 'CarModel.title'), 'conditions' => array('CarModel.brand_slug' => $this->request->data['Car']['brand_slug']), 'order' => array('CarModel.title' => 'asc'))));
			$this->set('modifications', $this->CarModification->find('list', array('fields' => array('CarModification.id', 'CarModification.title'), 'conditions' => array('CarModification.model_id' => $this->request->data['Car']['model_id']), 'order' => array('CarModification.title' => 'asc'))));
		}
		else {
			$this->set('models', array('' => __d('admin_common', 'list_all_items')));
			$this->set('modifications', array('' => __d('admin_common', 'list_all_items')));
		}
		$this->set('all_models', $this->CarModel->find('list', array('fields' => array('CarModel.id', 'CarModel.title'), 'order' => array('CarModel.title' => 'asc'))));
		$this->set('all_modifications', $this->CarModification->find('list', array('fields' => array('CarModification.id', 'CarModification.title'), 'order' => array('CarModification.title' => 'asc'))));
	}
	public function _edit($id) {
		$title = parent::_edit($id);
		$this->loadModel('CarBrand');
		$this->loadModel('CarModel');
		$this->loadModel('CarModification');
		$this->set('brands', $this->CarBrand->find('list', array('fields' => array('CarBrand.id', 'CarBrand.title'), 'order' => array('CarBrand.title' => 'asc'))));
		if (isset($this->request->data['Car']['brand_id'])) {
			$this->set('models', $this->CarModel->find('list', array('fields' => array('CarModel.id', 'CarModel.title'), 'conditions' => array('CarModel.brand_slug' => $this->request->data['Car']['brand_slug']), 'order' => array('CarModel.title' => 'asc'))));
			$this->set('modifications', $this->CarModification->find('list', array('fields' => array('CarModification.id', 'CarModification.title'), 'conditions' => array('CarModification.model_id' => $this->request->data['Car']['model_id']), 'order' => array('CarModification.title' => 'asc'))));
		}
		else {
			$this->set('models', array('' => __d('admin_common', 'list_any_items')));
			$this->set('modifications', array('' => __d('admin_common', 'list_any_items')));
		}
		if (isset($this->request->data['Car']['id'])) {
			$title = $this->viewVars['brands'][$this->request->data['Car']['brand_id']] . ' ' . $this->viewVars['models'][$this->request->data['Car']['model_id']] . ' ' . $this->viewVars['modifications'][$this->request->data['Car']['modification_id']] . ' ' . $this->request->data['Car']['year'];
		}
		return $title;
	}
	public function view() { 
        $brand_id = abs(intval($this->request->query['brand_id']));
        $brand_slug = abs(intval($this->request->query['brand_slug']));
		$this->request->data['Car']['brand_id'] = $brand_id;
		if (isset($this->request->query['model_id'])) {
	        $model_id = abs(intval($this->request->query['model_id']));
			$this->request->data['Car']['model_id'] = $model_id;
			if (isset($this->request->query['year'])) {
				$year = abs(intval($this->request->query['year']));
				$this->request->data['Car']['year'] = $year;
				if (isset($this->request->query['mod'])) {
					 $modification_id = abs(intval($this->request->query['mod']));
					$this->request->data['Car']['mod'] = $modification_id;
				}
			}
		}
		$this->category_id = 4;
		$this->loadModel('CarBrand');
		if ($brand = $this->CarBrand->find('first', array('conditions' => array('CarBrand.is_active' => 1, 'CarBrand.id' => $brand_id)))) {
			$this->set('brand', $brand);
			if (isset($model_id) && $model_id > 0) {
				$this->loadModel('CarModel');
				if ($model = $this->CarModel->find('first', array('conditions' => array('CarModel.is_active' => 1, 'CarModel.brand_slug' => $brand['CarBrand']['slug'], 'CarModel.id' => $model_id)))) {
					$this->set('model', $model);
					if (isset($year) && $year > 0) {
						$this->loadModel('Car');
						$this->Car->bindModel(
							array(
								'belongsTo' => array(
									'CarModification' => array(
										'foreignKey' => 'modification_id'
									)
								)
							),
							false
						);
						if ($cars = $this->Car->find('all', array( 'order' => array('Car.year' => 'desc'), 'fields' => array('Car.year'), 'conditions' => array('Car.model_id' => $model_id, 'Car.year' => $year, 'Car.is_active' => 1, 'CarModification.is_active' => 1)))) {
							$this->set('year', $year);
							if (isset($modification_id) && $modification_id > 0) {
								$this->loadModel('CarModification');
								if ($modification = $this->CarModification->find('first', array('conditions' => array('CarModification.is_active' => 1, 'CarModification.generation_slug' => $brand['CarBrand']['id'], 'CarModification.model_id' => $model['CarModel']['id'], 'CarModification.id' => $modification_id)))) {
									$this->loadModel('Car');
									if ($car = $this->Car->find('first', array('conditions' => array('Car.brand_id' => $brand['CarBrand']['id'], 'Car.model_id' => $model['CarModel']['id'], 'Car.modification_id' => $modification['CarModification']['id'], 'Car.is_active' => 1, 'Car.year' => $year)))) {
										$akb = array();
										if (!empty($car['Car']['width'])) {
											$this->loadModel('Product');
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
											$conditions = array('Product.is_active' => 1, 'Product.category_id' => 3, 'Product.width <=' => $car['Car']['length'], 'Product.length <=' => $car['Car']['width'], 'Product.height <=' => $car['Car']['height'], 'Product.ah >=' => $car['Car']['ah_from'], 'Product.ah <=' => $car['Car']['ah_to'], 'Product.current <=' => $car['Car']['current'], 'Product.f1' => $car['Car']['f2'], 'Product.f2' => $car['Car']['f1']);
											//$conditions = array('Product.is_active' => 1, 'Product.category_id' => 3, 'Product.width <=' => $car['Car']['length'], 'Product.length <=' => $car['Car']['width'], 'Product.height <=' => $car['Car']['height']);
											$akb = $this->Product->find('all', array('conditions' => $conditions, 'order' => array('Product.ah' => 'asc')));
										}
										$this->set('akb', $akb);
										$this->set('models', $this->CarModel->find('all', array('conditions' => array('CarModel.brand_slug' => $brand['CarBrand']['slug'], 'CarModel.is_active' => 1, 'CarModel.items_count > 0'), 'order' => array('CarModel.title' => 'asc'))));
										$this->Car->bindModel(
											array(
												'belongsTo' => array(
													'CarModification' => array(
														'foreignKey' => 'modification_id'
													)
												)
											),
											false
										);
										$this->set('models', $this->CarModel->find('all', array('conditions' => array('CarModel.brand_slug' => $brand['CarBrand']['slug'], 'CarModel.is_active' => 1, 'CarModel.items_count > 0'), 'order' => array('CarModel.title' => 'asc'))));
										$this->set('car_models', $this->CarModel->find('list', array( 'order' => array('CarModel.title' => 'asc'), 'conditions' => array('CarModel.is_active' => 1, 'CarModel.brand_slug' => $brand_slug))));
										$this->loadModel('Car');
										$years = array();
										if ($cars = $this->Car->find('all', array( 'order' => array('Car.year' => 'desc'), 'fields' => array('Car.year'), 'conditions' => array('Car.model_id' => $model_id, 'Car.is_active' => 1, 'CarModification.is_active' => 1)))) {
											$years = array();
											foreach ($cars as $item) {
												$years[$item['Car']['year']] = $item['Car']['year'];
											}
										}
										$this->set('car_years', $years);
										$all_cars = $this->Car->find('all', array('conditions' => array('Car.brand_id' => $brand['CarBrand']['id'], 'Car.model_id' => $model['CarModel']['id'], 'Car.is_active' => 1, 'CarModification.is_active' => 1), 'order' => array('Car.year' => 'asc'), 'fields' => array('Car.year')));
										$used_years = array();
										$cars = array();
										foreach ($all_cars as $item) {
											if (!in_array($item['Car']['year'], $used_years)) {
												$cars[] = $item;
												$used_years[] = $item['Car']['year'];
											}
										}
										$this->set('cars', $cars);
										if ($car_mods = $this->Car->find('all', array('fields' => array('CarModification.id', 'CarModification.title'), 'conditions' => array('Car.brand_id' => $brand_id, 'Car.model_id' => $model_id, 'Car.is_active' => 1, 'Car.year' => $year, 'CarModification.is_active' => 1), 'order' => array('CarModification.title' => 'asc')))) {
											$mods = array();
											foreach ($car_mods as $item) {
												$mods[$item['CarModification']['id']] = $item['CarModification']['title'];
											}
										}
										$this->set('car_modifications', $mods);
										$this->set('modifications', $this->Car->find('all', array('conditions' => array('Car.brand_id' => $brand['CarBrand']['id'], 'Car.model_id' => $model['CarModel']['id'], 'Car.is_active' => 1, 'Car.year' => $year, 'CarModification.is_active' => 1), 'order' => array('CarModification.title' => 'asc'))));
										$breadcrumbs = array();
										$breadcrumbs[] = array(
											'url' => array('controller' => 'car_brands', 'action' => 'index'),
											'title' => 'Подбор по авто'
										);
										$breadcrumbs[] = array(
											'url' => array('controller' => 'car_brands', 'action' => 'view', 'slug' => $brand['CarBrand']['slug']),
											'title' => $brand['CarBrand']['title']
										);
										$breadcrumbs[] = array(
											'url' => array('controller' => 'car_models', 'action' => 'view', 'brand_slug' => $brand['CarBrand']['slug'], 'model_slug' => $model['CarModel']['slug']),
											'title' => $model['CarModel']['title']
										);
										$breadcrumbs[] = array(
											'url' => array('controller' => 'car_modifications', 'action' => 'view', 'brand_slug' => $brand['CarBrand']['slug'], 'model_slug' => $model['CarModel']['slug'], 'year' => $year),
											'title' => $year
										);
										$breadcrumbs[] = array(
											'url' => null,
											'title' => $modification['CarModification']['title']
										);
										$this->set('breadcrumbs', $breadcrumbs);
										$this->set('car_brands', $this->CarBrand->find('list', array('conditions' => array('CarBrand.is_active' => 1, 'CarBrand.items_count >' => 0), 'order' => array('CarBrand.title' => 'asc'))));
										$this->set('brand_id', $brand['CarBrand']['id']);
										$this->set('model_id', $model['CarModel']['id']);
										$this->set('modification_id', $modification['CarModification']['id']);
										$this->setMeta('title', 'Подбор по авто ' . $brand['CarBrand']['title'] . ' ' . $model['CarModel']['title'] . ' ' . $year . ' ' . $modification['CarModification']['title']);
										$this->set('brand', $brand);
										$this->set('model', $model);
										$this->set('modification', $modification);
										$this->set('year', $year);
										$this->set('car', $car);
										$this->set('active_menu', 'selection');
										$this->set('show_filter', 4);
										$this->set('show_left_menu', true);
                                        $this->set('show_switch_params_and_auto', false);
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
							else {
								// modifications by year
								$this->set('models', $this->CarModel->find('all', array('conditions' => array('CarModel.brand_slug' => $brand['CarBrand']['slug'], 'CarModel.is_active' => 1, 'CarModel.items_count > 0'), 'order' => array('CarModel.title' => 'asc'))));
								$this->set('car_models', $this->CarModel->find('list', array( 'order' => array('CarModel.title' => 'asc'), 'conditions' => array('CarModel.is_active' => 1, 'CarModel.brand_slug' => $brand_slug))));
								$this->loadModel('Car');
								$years = array();
								if ($cars = $this->Car->find('all', array( 'order' => array('Car.year' => 'desc'), 'fields' => array('Car.year'), 'conditions' => array('Car.model_id' => $model_id, 'Car.is_active' => 1, 'CarModification.is_active' => 1)))) {
									$years = array();
									foreach ($cars as $item) {
										$years[$item['Car']['year']] = $item['Car']['year'];
									}
								}
								$this->set('car_years', $years);
								$all_cars = $this->Car->find('all', array('conditions' => array('Car.brand_id' => $brand['CarBrand']['id'], 'Car.model_id' => $model['CarModel']['id'], 'Car.is_active' => 1, 'CarModification.is_active' => 1), 'order' => array('Car.year' => 'asc'), 'fields' => array('Car.year')));
								$used_years = array();
								$cars = array();
								foreach ($all_cars as $item) {
									if (!in_array($item['Car']['year'], $used_years)) {
										$cars[] = $item;
										$used_years[] = $item['Car']['year'];
									}
								}
								$this->set('cars', $cars);
								if ($car_mods = $this->Car->find('all', array('fields' => array('CarModification.id', 'CarModification.title'), 'conditions' => array('Car.brand_id' => $brand_id, 'Car.model_id' => $model_id, 'Car.is_active' => 1, 'Car.year' => $year, 'CarModification.is_active' => 1), 'order' => array('CarModification.title' => 'asc')))) {
									$mods = array();
									foreach ($car_mods as $item) {
										$mods[$item['CarModification']['id']] = $item['CarModification']['title'];
									}
								}
								$this->set('car_modifications', $mods);
								$this->set('modifications', $this->Car->find('all', array('conditions' => array('Car.brand_id' => $brand['CarBrand']['id'], 'Car.model_id' => $model['CarModel']['id'], 'Car.is_active' => 1, 'Car.year' => $year, 'CarModification.is_active' => 1), 'order' => array('CarModification.title' => 'asc'))));
								$breadcrumbs = array();
								$breadcrumbs[] = array(
									'url' => array('controller' => 'car_brands', 'action' => 'index'),
									'title' => 'Подбор по авто'
								);
								$breadcrumbs[] = array(
									'url' => array('controller' => 'car_brands', 'action' => 'view', 'slug' => $brand['CarBrand']['slug']),
									'title' => $brand['CarBrand']['title']
								);
								$breadcrumbs[] = array(
									'url' => array('controller' => 'car_models', 'action' => 'view', 'brand_slug' => $brand['CarBrand']['slug'], 'model_slug' => $model['CarModel']['slug']),
									'title' => $model['CarModel']['title']
								);
								$breadcrumbs[] = array(
									'url' => null,
									'title' => $year
								);
								$this->setCarBrands();
								$this->set('breadcrumbs', $breadcrumbs);
								$this->setMeta('title', 'Подбор по авто ' . $brand['CarBrand']['title'] . ' ' . $model['CarModel']['title'] . ' ' . $year);
								$this->set('brand', $brand);
								$this->set('model', $model);
								$this->set('year', $year);
								$this->set('brand_id', $brand['CarBrand']['id']);
								$this->set('model_id', $model['CarModel']['id']);
								$this->set('show_left_menu', true);
								$this->set('active_menu', 'selection');
								$this->set('show_filter', 4);
								$this->render('view_year');
                                $this->set('show_switch_params_and_auto', false);
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
						// years by model
						$this->set('models', $this->CarModel->find('all', array('conditions' => array('CarModel.brand_slug' => $brand['CarBrand']['slug'], 'CarModel.is_active' => 1, 'CarModel.items_count > 0'), 'order' => array('CarModel.title' => 'asc'))));
						$this->set('car_models', $this->CarModel->find('list', array( 'order' => array('CarModel.title' => 'asc'), 'conditions' => array('CarModel.is_active' => 1, 'CarModel.brand_slug' => $brand_slug))));
						$this->loadModel('Car');
						$this->Car->bindModel(
							array(
								'belongsTo' => array(
									'CarModification' => array(
										'foreignKey' => 'modification_id'
									)
								)
							),
							false
						);
						$years = array();
						if ($cars = $this->Car->find('all', array( 'order' => array('Car.year' => 'desc'), 'fields' => array('Car.year'), 'conditions' => array('Car.model_id' => $model_id, 'Car.is_active' => 1, 'CarModification.is_active' => 1)))) {
							$years = array();
							foreach ($cars as $item) {
								$years[$item['Car']['year']] = $item['Car']['year'];
							}
						}
						$this->set('car_years', $years);
						$all_cars = $this->Car->find('all', array('conditions' => array('Car.brand_id' => $brand['CarBrand']['id'], 'Car.model_id' => $model['CarModel']['id'], 'Car.is_active' => 1, 'CarModification.is_active' => 1), 'order' => array('Car.year' => 'asc'), 'fields' => array('Car.year')));
						$used_years = array();
						$cars = array();
						foreach ($all_cars as $item) {
							if (!in_array($item['Car']['year'], $used_years)) {
								$cars[] = $item;
								$used_years[] = $item['Car']['year'];
							}
						}
						$this->set('cars', $cars);
						$breadcrumbs = array();
						$breadcrumbs[] = array(
							'url' => array('controller' => 'car_brands', 'action' => 'index'),
							'title' => 'Подбор по авто'
						);
						$breadcrumbs[] = array(
							'url' => array('controller' => 'car_brands', 'action' => 'view', 'slug' => $brand['CarBrand']['slug']),
							'title' => $brand['CarBrand']['title']
						);
						$breadcrumbs[] = array(
							'url' => null,
							'title' => $model['CarModel']['title']
						);
						$this->setCarBrands();
						$this->set('breadcrumbs', $breadcrumbs);
						$this->set('brand_id', $brand['CarBrand']['id']);
						$this->set('model_id', $model['CarModel']['id']);
						$this->setMeta('title', 'Подбор по авто ' . $brand['CarBrand']['title'] . ' ' . $model['CarModel']['title']);
						$this->set('show_left_menu', true);
						$this->set('active_menu', 'selection');
						$this->set('show_filter', 4);
						$this->render('view_model');
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
				// models by brand
				$this->loadModel('CarModel');
				$this->set('car_models', $this->CarModel->find('list', array( 'order' => array('CarModel.title' => 'asc'), 'conditions' => array('CarModel.is_active' => 1, 'CarModel.brand_slug' => $brand_slug))));
				$this->set('models', $this->CarModel->find('all', array('conditions' => array('CarModel.brand_slug' => $brand['CarBrand']['slug'], 'CarModel.is_active' => 1, 'CarModel.items_count > 0'), 'order' => array('CarModel.title' => 'asc'))));
				$breadcrumbs = array();
				$breadcrumbs[] = array(
					'url' => array('controller' => 'car_brands', 'action' => 'index'),
					'title' => 'Подбор по авто'
				);
				$breadcrumbs[] = array(
					'url' => null,
					'title' => $brand['CarBrand']['title']
				);
				$this->setCarBrands();
				$this->set('breadcrumbs', $breadcrumbs);
				$this->set('brand_id', $brand['CarBrand']['id']);
				$this->setMeta('title', 'Подбор по авто ' . $brand['CarBrand']['title']);
				$this->set('show_left_menu', true);
				$this->set('active_menu', 'selection');
				$this->set('show_filter', 4);
				$this->render('view_brand');
			}
		}
		else {
			$this->response->statusCode(404);
			$this->response->send();
			$this->render(false);
			return;
		}
	}
	public function car_view($brand_slug, $model_slug, $generation_slug, $modification_slug) {
        $this->loadModel('CarTyres');
        $this->loadModel('CarWheels');
        $this->loadModel('CarBatteries');
        $this->loadModel('CarBrand');
        $this->loadModel('CarModel');
        $this->loadModel('CarGeneration');
        $this->loadModel('CarModification');

        if ($car_modification = $this->CarModification->find('first', array('conditions' => array('CarModification.is_active' => 1, 'CarModification.slug' => $modification_slug)))) {
            $car_generation = $this->CarGeneration->find('first', array('conditions' => array('CarGeneration.is_active' => 1, 'CarGeneration.slug' => $car_modification['CarModification']['generation_slug'])));
            $car_model = $this->CarModel->find('first', array('conditions' => array('CarModel.is_active' => 1, 'CarModel.slug' => $car_generation['CarGeneration']['model_slug'])));
            $car_brand = $this->CarBrand->find('first', array('conditions' => array('CarBrand.is_active' => 1, 'CarBrand.slug' => $car_model['CarModel']['brand_slug'])));

            $this->set('car_modification', $car_modification);
            $this->set('car_generation', $car_generation);
            $this->set('car_model', $car_model);
            $this->set('car_brand', $car_brand);
            $this->set('modification_slug', $modification_slug);

            // tyres

            $car_tyres = $this->CarTyres->find('first', array('conditions' => array('CarTyres.modification_slug' => $modification_slug)));

            $this->set('$car_tyres', $car_tyres);
            $this->set('car_image', $car_generation['CarGeneration']['image_default']);

            $factory_tyres = explode('|', $car_tyres['CarTyres']['factory_tyres']);
            $tuning_tyres = explode('|', $car_tyres['CarTyres']['tuning_tyres']);

            $this->set('factory_tyres', $factory_tyres);
            $this->set('tuning_tyres', $tuning_tyres);

            $factory_wheels = $this->CarWheels->find('all', array('conditions' => array('CarWheels.modification_slug' => $modification_slug, 'CarWheels.factory' => 1)));
            $tuning_wheels = $this->CarWheels->find('all', array('conditions' => array('CarWheels.modification_slug' => $modification_slug, 'CarWheels.factory' => 0)));

            $this->set('factory_wheels', $factory_wheels);
            $this->set('tuning_wheels', $tuning_wheels);

            $factory_akb = $this->CarBatteries->find('all', array('conditions' => array('CarBatteries.modification_slug' => $modification_slug, 'CarBatteries.is_factory' => 1)));
            $tuning_akb = $this->CarBatteries->find('all', array('conditions' => array('CarBatteries.modification_slug' => $modification_slug, 'CarBatteries.is_factory' => 0)));

            $this->set('car_image', $car_generation['CarGeneration']['image_default']);

            $this->set('factory_akb', $factory_akb);
            $this->set('tuning_akb', $tuning_akb);
            if (!empty($this->request->query['start_stop'])) {
                $this->set('start_stop', $this->request->query['start_stop']);
            }


            $this->set('car_image', $car_generation['CarGeneration']['image_default']);

            			$breadcrumbs = array();
						$breadcrumbs[] = array(
							'url' => array('controller' => 'car_brands', 'action' => 'index'),
							'title' => 'Подбор по авто'
						);
						$breadcrumbs[] = array(
							'url' => array('controller' => 'car_brands', 'action' => 'view', 'slug' => $car_brand['CarBrand']['slug']),
							'title' => $car_brand['CarBrand']['title']
						);
						$breadcrumbs[] = array(
							'url' => array('controller' => 'car_models', 'action' => 'view', 'brand_slug' => $car_brand['CarBrand']['slug'], 'model_slug' => $car_model['CarModel']['slug']),
							'title' => $car_model['CarModel']['title']
						);
						$breadcrumbs[] = array(
							'url' => array('controller' => 'car_generations', 'action' => 'view', 'brand_slug' => $car_brand['CarBrand']['slug'], 'model_slug' => $car_model['CarModel']['slug'], 'generation_slug' => $car_generation['CarGeneration']['slug']),
							'title' => $car_generation['CarGeneration']['title']
						);
						$breadcrumbs[] = array(
							'url' => null,
							'title' => $car_modification['CarModification']['title']
						);

            $this->set('breadcrumbs', $breadcrumbs);

            $this->set('show_left_menu', false);

        } else {
            $this->response->statusCode(404);
            $this->response->send();
            $this->render(true);
            return;
        }

//		$this->set('car_tyres', array());
//		$this->set('car_years', array());
//		$this->set('car_modifications', array());
//		$this->category_id = 4;
//		$this->loadModel('CarTyres');
//        $this->loadModel('CarModification');
//
//        if ($modification = $this->CarModification->find('first', array('conditions' => array('CarModification.is_active' => 1, 'CarModification.slug' => $modification_slug)))) {
//            $car_tyres = $this->CarTyres->find('all', array('conditions' => array('CarTyres.modification_slug' => $modification_slug)));
//            $model = $this->CarModel->find('first', array('conditions' => array('CarModel.slug' => $model_slug)));
//            $this->set('modification', $modification);
//
//            $this->set('car_tyres', $car_tyres);
//            $this->set('model', $model);
//        } else {
//            $this->response->statusCode(404);
//            $this->response->send();
//            $this->render(false);
//            return;
//        }



//		if ($brand = $this->CarBrand->find('first', array('conditions' => array('CarBrand.is_active' => 1, 'CarBrand.slug' => $brand_slug)))) {
//			$this->loadModel('CarModel');
//			if ($model = $this->CarModel->find('first', array('conditions' => array('CarModel.is_active' => 1, 'CarModel.brand_slug' => $brand['CarBrand']['slug'], 'CarModel.slug' => $model_slug)))) {
//				$this->loadModel('CarModification');
//				if ($modification = $this->CarModification->find('first', array('conditions' => array('CarModification.is_active' => 1, 'CarModification.generation_slug' => $brand['CarBrand']['id'], 'CarModification.model_id' => $model['CarModel']['id'], 'CarModification.slug' => $modification_slug)))) {
//					$this->loadModel('Car');
//					if ($car = $this->Car->find('first', array('conditions' => array('Car.brand_id' => $brand['CarBrand']['id'], 'Car.model_id' => $model['CarModel']['id'], 'Car.modification_id' => $modification['CarModification']['id'], 'Car.is_active' => 1, 'Car.year' => $year)))) {
//						$akb = array();
//						if (!empty($car['Car']['width'])) {
//							$this->loadModel('Product');
//							$this->Product->bindModel(
//								array(
//									'belongsTo' => array(
//										'Brand',
//										'BrandModel' => array(
//											'foreignKey' => 'model_id'
//										)
//									)
//								),
//								false
//							);
//							$conditions = array('Product.is_active' => 1, 'Product.category_id' => 3, 'Product.width <=' => $car['Car']['length'], 'Product.length <=' => $car['Car']['width'], 'Product.height <=' => $car['Car']['height'], 'Product.ah >=' => $car['Car']['ah_from'], 'Product.ah <=' => $car['Car']['ah_to'], 'Product.current <=' => $car['Car']['current'], 'Product.f1' => $car['Car']['f2'], 'Product.f2' => $car['Car']['f1']);
//							//$conditions = array('Product.is_active' => 1, 'Product.category_id' => 3, 'Product.width <=' => $car['Car']['length'], 'Product.length <=' => $car['Car']['width'], 'Product.height <=' => $car['Car']['height']);
//							$akb = $this->Product->find('all', array('conditions' => $conditions, 'order' => array('Product.ah' => 'asc')));
//						}
//						$this->set('akb', $akb);
//						$this->set('models', $this->CarModel->find('all', array('conditions' => array('CarModel.brand_slug' => $brand['CarBrand']['slug'], 'CarModel.is_active' => 1, 'CarModel.items_count > 0'), 'order' => array('CarModel.title' => 'asc'))));
//						$this->Car->bindModel(
//							array(
//								'belongsTo' => array(
//									'CarModification' => array(
//										'foreignKey' => 'modification_id'
//									)
//								)
//							),
//							false
//						);
//						$all_cars = $this->Car->find('all', array('conditions' => array('Car.brand_id' => $brand['CarBrand']['id'], 'Car.model_id' => $model['CarModel']['id'], 'Car.is_active' => 1, 'CarModification.is_active' => 1), 'order' => array('Car.year' => 'asc'), 'fields' => array('Car.year')));
//						$used_years = array();
//						$cars = array();
//						foreach ($all_cars as $item) {
//							if (!in_array($item['Car']['year'], $used_years)) {
//								$cars[] = $item;
//								$used_years[] = $item['Car']['year'];
//							}
//						}
//						$this->set('cars', $cars);
//						$this->set('modifications', $this->Car->find('all', array('conditions' => array('Car.brand_id' => $brand['CarBrand']['id'], 'Car.model_id' => $model['CarModel']['id'], 'Car.is_active' => 1, 'Car.year' => $year, 'CarModification.is_active' => 1), 'order' => array('CarModification.title' => 'asc'))));
//						$this->request->data['Car']['brand_id'] = $brand['CarBrand']['id'];
//						$this->request->data['Car']['model_id'] = $model['CarModel']['id'];
//						$this->request->data['Car']['year'] = $year;
//						$this->request->data['Car']['mod'] = $modification['CarModification']['id'];
//						$this->set('car_models', $this->CarModel->find('list', array( 'order' => array('CarModel.title' => 'asc'), 'conditions' => array('CarModel.is_active' => 1, 'CarModel.brand_slug' => $brand['CarBrand']['slug']))));
//						$years = array();
//						if ($cars = $this->Car->find('all', array( 'order' => array('Car.year' => 'desc'), 'fields' => array('Car.year'), 'conditions' => array('Car.model_id' => $model['CarModel']['id'], 'Car.is_active' => 1, 'CarModification.is_active' => 1)))) {
//							$years = array();
//							foreach ($cars as $item) {
//								$years[$item['Car']['year']] = $item['Car']['year'];
//							}
//						}
//						$this->set('car_years', $years);
//						if ($car_mods = $this->Car->find('all', array('fields' => array('CarModification.id', 'CarModification.title'), 'conditions' => array('Car.brand_id' => $brand['CarBrand']['id'], 'Car.model_id' => $model['CarModel']['id'], 'Car.is_active' => 1, 'Car.year' => $year, 'CarModification.is_active' => 1), 'order' => array('CarModification.title' => 'asc')))) {
//							$mods = array();
//							foreach ($car_mods as $item) {
//								$mods[$item['CarModification']['id']] = $item['CarModification']['title'];
//							}
//						}
//						$this->set('car_modifications', $mods);
//						$breadcrumbs = array();
//						$breadcrumbs[] = array(
//							'url' => array('controller' => 'car_brands', 'action' => 'index'),
//							'title' => 'Подбор по авто'
//						);
//						$breadcrumbs[] = array(
//							'url' => array('controller' => 'car_brands', 'action' => 'view', 'slug' => $brand['CarBrand']['slug']),
//							'title' => $brand['CarBrand']['title']
//						);
//						$breadcrumbs[] = array(
//							'url' => array('controller' => 'car_models', 'action' => 'view', 'brand_slug' => $brand['CarBrand']['slug'], 'model_slug' => $model['CarModel']['slug']),
//							'title' => $model['CarModel']['title']
//						);
//						$breadcrumbs[] = array(
//							'url' => array('controller' => 'car_modifications', 'action' => 'view', 'brand_slug' => $brand['CarBrand']['slug'], 'model_slug' => $model['CarModel']['slug'], 'year' => $year),
//							'title' => $year
//						);
//						$breadcrumbs[] = array(
//							'url' => null,
//							'title' => $modification['CarModification']['title']
//						);
//						$this->setCarBrands();
//						$this->set('breadcrumbs', $breadcrumbs);
//						$this->set('brand_id', $brand['CarBrand']['id']);
//						$this->set('model_id', $model['CarModel']['id']);
//						$this->set('modification_id', $modification['CarModification']['id']);
//						$this->setMeta('title', 'Подбор по авто ' . $brand['CarBrand']['title'] . ' ' . $model['CarModel']['title'] . ' ' . $year . ' ' . $modification['CarModification']['title']);
//						$this->set('brand', $brand);
//						$this->set('model', $model);
//						$this->set('modification', $modification);
//						$this->set('year', $year);
//						$this->set('car', $car);
//						$this->set('active_menu', 'selection');
//						$this->set('show_left_menu', true);
//						$this->set('show_filter', 4);
//                        $this->set('show_switch_params_and_auto', false);
//						$this->render('view');
//
//					}
//					else {
//						$this->response->statusCode(404);
//						$this->response->send();
//						$this->render(false);
//						return;
//					}
//				}
//				else {
//					$this->response->statusCode(404);
//					$this->response->send();
//					$this->render(false);
//					return;
//				}
//			}
//			else {
//				$this->response->statusCode(404);
//				$this->response->send();
//				$this->render(false);
//				return;
//			}
//		}
//		else {
//			$this->response->statusCode(404);
//			$this->response->send();
//			$this->render(false);
//			return;
//		}
	}
}