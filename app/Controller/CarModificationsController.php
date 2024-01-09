<?php
class CarModificationsController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'CarModification.title' => 'asc'
		)
	);
	public $filter_fields = array('CarModification.id' => 'int', 'CarModification.brand_id' => 'int', 'CarModification.model_id' => 'int', 'CarModification.title' => 'text');
	public $model = 'CarModification';
	public $submenu = 'cars';
	public function _list() {
		parent::_list();
		$this->loadModel('CarBrand');
		$this->loadModel('CarModel');
		$this->set('brands', $this->CarBrand->find('list', array('fields' => array('CarBrand.id', 'CarBrand.title'), 'order' => array('CarBrand.title' => 'asc'))));
		if (isset($this->request->data['CarModification']['brand_id'])) {
			$this->set('models', $this->CarModel->find('list', array('fields' => array('CarModel.id', 'CarModel.title'), 'conditions' => array('CarModel.brand_id' => $this->request->data['CarModification']['brand_id']), 'order' => array('CarModel.title' => 'asc'))));
		}
		else {
			$this->set('models', array('' => __d('admin_common', 'list_all_items')));
		}
		$this->set('all_models', $this->CarModel->find('list', array('fields' => array('CarModel.id', 'CarModel.title'), 'order' => array('CarModel.title' => 'asc'))));
	}
	public function _edit($id) {
		$title = parent::_edit($id);
		$this->loadModel('CarBrand');
		$this->loadModel('CarModel');
		$this->set('brands', $this->CarBrand->find('list', array('fields' => array('CarBrand.id', 'CarBrand.title'), 'order' => array('CarBrand.title' => 'asc'))));
		if (isset($this->request->data['CarModification']['brand_id'])) {
			$this->set('models', $this->CarModel->find('list', array('fields' => array('CarModel.id', 'CarModel.title'), 'conditions' => array('CarModel.brand_id' => $this->request->data['CarModification']['brand_id']), 'order' => array('CarModel.title' => 'asc'))));
		}
		else {
			$this->set('models', array('' => __d('admin_common', 'list_any_items')));
		}
		return $title;
	}
	public function view($brand_slug, $model_slug, $year) {
		$this->set('car_models', array());
		$this->set('car_years', array());
		$this->set('car_modifications', array());
		$this->category_id = 4;
		$this->loadModel('CarBrand');
		if ($brand = $this->CarBrand->find('first', array('conditions' => array('CarBrand.is_active' => 1, 'CarBrand.slug' => $brand_slug)))) {
			$this->loadModel('CarModel');
			if ($model = $this->CarModel->find('first', array('conditions' => array('CarModel.is_active' => 1, 'CarModel.brand_id' => $brand['CarBrand']['id'], 'CarModel.slug' => $model_slug)))) {
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
				if ($this->Car->find('count', array('conditions' => array('Car.brand_id' => $brand['CarBrand']['id'], 'Car.model_id' => $model['CarModel']['id'], 'Car.is_active' => 1, 'CarModification.is_active' => 1, 'Car.year' => $year)))) {
					$this->set('models', $this->CarModel->find('all', array('conditions' => array('CarModel.brand_id' => $brand['CarBrand']['id'], 'CarModel.is_active' => 1, 'CarModel.active_cars_count > 0'), 'order' => array('CarModel.title' => 'asc'))));
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
					$this->set('modifications', $this->Car->find('all', array('conditions' => array('Car.brand_id' => $brand['CarBrand']['id'], 'Car.model_id' => $model['CarModel']['id'], 'Car.is_active' => 1, 'Car.year' => $year, 'CarModification.is_active' => 1), 'order' => array('CarModification.title' => 'asc'))));



					$this->request->data['Car']['brand_id'] = $brand['CarBrand']['id'];
					$this->request->data['Car']['model_id'] = $model['CarModel']['id'];
					$this->request->data['Car']['year'] = $year;
					$this->set('car_models', $this->CarModel->find('list', array( 'order' => array('CarModel.title' => 'asc'), 'conditions' => array('CarModel.is_active' => 1, 'CarModel.brand_id' => $brand['CarBrand']['id']))));
					$years = array();
					if ($cars = $this->Car->find('all', array( 'order' => array('Car.year' => 'desc'), 'fields' => array('Car.year'), 'conditions' => array('Car.model_id' => $model['CarModel']['id'], 'Car.is_active' => 1, 'CarModification.is_active' => 1)))) {
						$years = array();
						foreach ($cars as $item) {
							$years[$item['Car']['year']] = $item['Car']['year'];
						}
					}
					$this->set('car_years', $years);
					if ($car_mods = $this->Car->find('all', array('fields' => array('CarModification.id', 'CarModification.title'), 'conditions' => array('Car.brand_id' => $brand['CarBrand']['id'], 'Car.model_id' => $model['CarModel']['id'], 'Car.is_active' => 1, 'Car.year' => $year, 'CarModification.is_active' => 1), 'order' => array('CarModification.title' => 'asc')))) {
						$mods = array();
						foreach ($car_mods as $item) {
							$mods[$item['CarModification']['id']] = $item['CarModification']['title'];
						}
					}
					$this->set('car_modifications', $mods);

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
					$this->set('brand_id', $brand['CarBrand']['id']);
					$this->set('model_id', $model['CarModel']['id']);
					$this->setMeta('title', 'Подбор по авто ' . $brand['CarBrand']['title'] . ' ' . $model['CarModel']['title'] . ' ' . $year);
					$this->set('brand', $brand);
					$this->set('model', $model);
					$this->set('year', $year);
					$this->set('show_left_menu', true);
					$this->set('active_menu', 'selection');
					$this->set('show_filter', 4);
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
			$this->response->statusCode(404);
			$this->response->send();
			$this->render(false);
			return;
		}
	}
	public function get_modifications($brand_id = 0, $model_id = 0, $year = 0) {
		$this->layout = false;
		$data = array(array('0' => '...'));
		$brand_id = intval($brand_id);
		$model_id = intval($model_id);
		$year = intval($year);
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
		if ($car_mods = $this->Car->find('all', array('fields' => array('CarModification.id', 'CarModification.title'), 'conditions' => array('Car.brand_id' => $brand_id, 'Car.model_id' => $model_id, 'Car.is_active' => 1, 'Car.year' => $year, 'CarModification.is_active' => 1), 'order' => array('CarModification.title' => 'asc')))) {
            foreach ($car_mods as $item) {
                $data[] = array($item['CarModification']['id'] => $item['CarModification']['title']);
            }
		}
		echo json_encode($data);
		$this->render(false);
	}
}