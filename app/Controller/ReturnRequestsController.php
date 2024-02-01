<?php
class ReturnRequestsController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'ReturnRequest.created' => 'desc'
		)
	);
	public $filter_fields = array('ReturnRequest.status' => 'text', 'ReturnRequest.request_id' => 'text', 'ReturnRequest.phone' => 'text', 'ReturnRequest.date_from' => 'from', 'ReturnRequest.date_to' => 'to', 'ReturnRequest.created_from' => 'from', 'ReturnRequest.created_to' => 'to', 'ReturnRequest.name' => 'text', 'ReturnRequest.email' => 'text', 'ReturnRequest.time' => 'text');
	public $model = 'ReturnRequest';
	public $submenu = 'return_requests';
	private function _view($id) {
		$this->loadModel('ReturnRequest');
		$this->ReturnRequest->bindModel(
			array(
				'belongsTo' => array(
					'Station',
					'CarBrand' => array(
						'foreignKey' => 'car_brand_slug'
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
					'ReturnRequestService'
				)
			),
			false
		);
		if ($request = $this->ReturnRequest->find('first', array('conditions' => array('ReturnRequest.id' => $id)))) {
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
		return $request;
	}
	public function admin_view($id) {
		$request = $this->_view($id);
		$this->set('section', $this->getSection($this->getSubmenu()));
		$this->set('submenu', $this->getSubmenu());
		$this->set('action', 'admin_view');
		$this->set('title_for_layout', $this->t('title_view', $request['ReturnRequest']['request_id']));
		$this->layout = 'admin';
		$this->render('admin_view');
	}
}