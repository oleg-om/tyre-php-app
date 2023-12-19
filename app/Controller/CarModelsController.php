<?php
class CarModelsController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'CarModel.title' => 'asc'
		)
	);
	public $filter_fields = array('CarModel.id' => 'int', 'CarModel.brand_id' => 'int', 'CarModel.title' => 'text');
	public $model = 'CarModel';
	public $submenu = 'cars';
	public function _list() {
		parent::_list();
		$this->loadModel('CarBrand');
		$this->set('brands', $this->CarBrand->find('list', array('fields' => array('CarBrand.id', 'CarBrand.title'), 'order' => array('CarBrand.title' => 'asc'))));
	}
	public function _edit($id) {
		$title = parent::_edit($id);
		$this->loadModel('CarBrand');
		$this->set('brands', $this->CarBrand->find('list', array('fields' => array('CarBrand.id', 'CarBrand.title'), 'order' => array('CarBrand.title' => 'asc'))));
		return $title;
	}
	function admin_modifications() {
		Configure::write('debug', 0);
		$model_id = $this->request->query['model_id'];
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
		$this->loadModel('CarModification');
		if ($models = $this->CarModification->find('list', array('conditions' => array('CarModification.model_id' => $model_id), 'order' => array('CarModification.title' => 'asc'), 'fields' => array('CarModification.id', 'CarModification.title')))) {
			$data = $data + $models;
		}
		$this->set(compact('data'));
		$this->render(false);
	}
	public function view($brand_slug, $model_slug) {
		$this->set('car_models', array());
		$this->set('car_years', array());
		$this->set('car_modifications', array());
		$this->category_id = 4;
		$this->loadModel('CarBrand');
		if ($brand = $this->CarBrand->find('first', array('conditions' => array('CarBrand.is_active' => 1, 'CarBrand.slug' => $brand_slug)))) {
			$this->loadModel('CarModel');
			if ($model = $this->CarModel->find('first', array('conditions' => array('CarModel.is_active' => 1, 'CarModel.brand_id' => $brand['CarBrand']['id'], 'CarModel.slug' => $model_slug)))) {
				$this->set('models', $this->CarModel->find('all', array('conditions' => array('CarModel.brand_id' => $brand['CarBrand']['id'], 'CarModel.is_active' => 1, 'CarModel.active_cars_count > 0'), 'order' => array('CarModel.title' => 'asc'))));

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
				$this->request->data['Car']['brand_id'] = $brand['CarBrand']['id'];
				$this->request->data['Car']['model_id'] = $model['CarModel']['id'];
				$this->set('car_models', $this->CarModel->find('list', array( 'order' => array('CarModel.title' => 'asc'), 'conditions' => array('CarModel.is_active' => 1, 'CarModel.brand_id' => $brand['CarBrand']['id']))));
				$years = array();
				if ($cars = $this->Car->find('all', array( 'order' => array('Car.year' => 'desc'), 'fields' => array('Car.year'), 'conditions' => array('Car.model_id' => $model['CarModel']['id'], 'Car.is_active' => 1, 'CarModification.is_active' => 1)))) {
					$years = array();
					foreach ($cars as $item) {
						$years[$item['Car']['year']] = $item['Car']['year'];
					}
				}
				$this->set('car_years', $years);
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
				$this->set('brand', $brand);
				$this->set('model', $model);
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
	public function get_models($brand_id = 0) {
		$this->layout = false;
		$data = array(array('0' => '...'));
		$brand_id = intval($brand_id);
		$this->loadModel('CarModel');
		if ($car_models = $this->CarModel->find('list', array('order' => array('CarModel.title' => 'asc'), 'conditions' => array('CarModel.is_active' => 1, 'CarModel.brand_id' => $brand_id)))) {
			foreach ($car_models as $key => $value) {
				$data[] = array($key => $value);
			}
		}
		echo json_encode($data);
		$this->render(false);
	}
	public function get_years($model_id = 0) {
		$this->layout = false;
		$data = array(array('0' => '...'));
		$model_id = intval($model_id);
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
		if ($cars = $this->Car->find('all', array( 'order' => array('Car.year' => 'desc'), 'fields' => array('Car.year'), 'conditions' => array('Car.model_id' => $model_id, 'Car.is_active' => 1, 'CarModification.is_active' => 1)))) {
			foreach ($cars as $item) {
				$data[] = array($item['Car']['year'] => $item['Car']['year']);
			}
		}
		echo json_encode($data);
		$this->render(false);
	}
}