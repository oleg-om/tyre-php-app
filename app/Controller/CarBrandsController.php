<?php
class CarBrandsController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'CarBrand.title' => 'asc'
		)
	);
	public $filter_fields = array('CarBrand.id' => 'int', 'CarBrand.title' => 'text');
	public $model = 'CarBrand';
	public $submenu = 'cars';
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
		$this->loadModel('CarModel');
		if ($models = $this->CarModel->find('list', array('conditions' => array('CarModel.brand_id' => $brand_id), 'order' => array('CarModel.title' => 'asc'), 'fields' => array('CarModel.id', 'CarModel.title')))) {
			$data = $data + $models;
		}
		$this->set(compact('data'));
		$this->render(false);
	}
	public function index() {
		$this->setMeta('title', 'Подбор по авто');
		$this->loadModel('Page');
		if ($page = $this->Page->find('first', array('conditions' => array('Page.is_active' => 1, 'Page.slug' => 'selection')))) {
			$this->setMeta('title', !empty($page['Page']['meta_title']) ? $page['Page']['meta_title'] : $page['Page']['title']);
			$this->setMeta('keywords', $page['Page']['meta_keywords']);
			$this->setMeta('description', $page['Page']['meta_description']);
			$this->set('page', $page);
		}
		$this->category_id = 4;
		$this->set('car_models', array());
		$this->set('car_years', array());
		$this->set('car_modifications', array());
		$breadcrumbs = array();
		$breadcrumbs[] = array(
			'url' => null,
			'title' => 'Подбор по авто'
		);
		$this->setCarBrands();
		$this->set('all_brands', $this->CarBrand->find('all', array('conditions' => array('CarBrand.is_active' => 1, 'CarBrand.active_cars_count >' => 0), 'order' => array('CarBrand.title' => 'asc'))));
		$this->set('breadcrumbs', $breadcrumbs);
		$this->set('active_menu', 'selection');
		$this->set('show_filter', 4);
		$this->set('show_left_menu', true);
	}
	public function view($slug) {
		$this->set('car_models', array());
		$this->set('car_years', array());
		$this->set('car_modifications', array());
		$this->category_id = 4;
		$this->loadModel('CarBrand');
		if ($brand = $this->CarBrand->find('first', array('conditions' => array('CarBrand.is_active' => 1, 'CarBrand.slug' => $slug)))) {
			$this->loadModel('CarModel');
			$this->set('models', $this->CarModel->find('all', array('conditions' => array('CarModel.brand_id' => $brand['CarBrand']['id'], 'CarModel.is_active' => 1, 'CarModel.active_cars_count > 0'), 'order' => array('CarModel.title' => 'asc'))));
			$breadcrumbs = array();
			$breadcrumbs[] = array(
				'url' => array('controller' => 'car_brands', 'action' => 'index'),
				'title' => 'Подбор по авто'
			);
			$breadcrumbs[] = array(
				'url' => null,
				'title' => $brand['CarBrand']['title']
			);
			$this->request->data['Car']['brand_id'] = $brand['CarBrand']['id'];
			$this->set('car_models', $this->CarModel->find('list', array( 'order' => array('CarModel.title' => 'asc'), 'conditions' => array('CarModel.is_active' => 1, 'CarModel.brand_id' => $brand['CarBrand']['id']))));
			$this->setCarBrands();
			$this->set('breadcrumbs', $breadcrumbs);
			$this->set('brand_id', $brand['CarBrand']['id']);
			$this->setMeta('title', 'Подбор по авто ' . $brand['CarBrand']['title']);
			$this->set('brand', $brand);
			$this->set('show_left_menu', true);
			$this->set('active_menu', 'selection');
			$this->set('show_filter', 4);
		}
		else {
			$this->response->statusCode(404);
			$this->response->send();
			$this->render(false);
			return;
		}
	}
}