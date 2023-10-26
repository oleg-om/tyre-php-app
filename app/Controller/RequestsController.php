<?php
class RequestsController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'Request.created' => 'desc'
		)
	);
	public $filter_fields = array('Request.id' => 'int', 'Request.station_id' => 'int', 'Request.phone' => 'text', 'Request.date_from' => 'from', 'Request.date_to' => 'to', 'Request.created_from' => 'from', 'Request.created_to' => 'to');
	public $model = 'Request';
	public $submenu = 'requests';
	public function _list() {
		parent::_list();
		$this->loadModel('Station');
		$this->set('stations', $this->Station->find('list', array('order' => array('Station.sort_order' => 'asc'))));
	}
	public function admin_view($id) {
		$this->loadModel('Request');
		$this->Request->bindModel(
			array(
				'belongsTo' => array(
					'CarBrand' => array(
						'foreignKey' => 'brand_id'
					),
					'CarModel' => array(
						'foreignKey' => 'model_id'
					),
					'Station'
				)
			),
			false
		);
		if ($request = $this->Request->find('first', array('conditions' => array('Request.id' => $id)))) {
			$this->set('request', $request);
			$this->set('id', $id);
		}
		else {
			$this->response->statusCode(404);
			$this->response->send();
			$this->render(false);
			return;
		}
		$this->set('types', $this->Request->types);
		$this->set('section', $this->getSection($this->getSubmenu()));
		$this->set('submenu', $this->getSubmenu());
		$this->set('action', 'admin_list');
		$this->set('title_for_layout', $this->t('title_view', $id));
		$this->layout = 'admin';
		$this->render('admin_view');
	}
}