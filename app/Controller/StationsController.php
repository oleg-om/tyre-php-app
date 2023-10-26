<?php
class StationsController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'Station.sort_order' => 'asc'
		)
	);
	public $filter_fields = array('Station.id' => 'int', 'Station.title' => 'text', 'Station.phone' => 'text');
	public $model = 'Station';
	public $submenu = 'stations';
	public function _edit($id) {
		$title = parent::_edit($id);
		$this->set('additional_js', array('http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU'));
		return $title;
	}
	public function booking() {
		$this->loadModel('Request');
		$this->loadModel('CarBrand');
		$this->loadModel('CarModel');
		$current_date = date('Y-m-d');
		$time = strtotime($current_date);
		if (isset($this->request->query['date'])) {
			$date = $this->request->query['date'];
			$t = strtotime($date);
			if ($t >= $time) {
				$time = $t;
				$current_date = date('Y-m-d', $time);
			}
		}
		$station_title = '';
		$request_time = '';
		$show_form = false;
		if (!empty($this->request->data['Request'])) {
			if (!empty($this->request->data['Request']['station_id'])) {
				$this->Station->id = $this->request->data['Request']['station_id'];
				if ($station = $this->Station->read(array('title'))) {
					$station_title = $station['Station']['title'];
				}
			}
			$this->request->data['Request']['date'] = $current_date;
			if ($this->Request->save($this->request->data)) {
				$request_id = $this->Request->id;
				if ($this->Session->check('requests')) {
					$requests = $this->Session->read('requests');
				}
				else {
					$requests = array();
				}
				$requests[] = $request_id;
				$this->Session->write('requests', $requests);
				$brand_name = $model_name = '';
				if (!empty($this->request->data['Request']['brand_id'])) {
					$this->CarBrand->id = $this->request->data['Request']['brand_id'];
					if ($brand = $this->CarBrand->read(array('title'))) {
						$brand_name = $brand['CarBrand']['title'];
					}
				}
				if (!empty($this->request->data['Request']['model_id'])) {
					$this->CarModel->id = $this->request->data['Request']['model_id'];
					if ($model = $this->CarModel->read(array('title'))) {
						$model_name = $model['CarModel']['title'];
					}
				}
				$notification_emails = explode(',', CONST_REQUEST_EMAILS);
				foreach ($notification_emails as $email) {
					$email = trim($email);
					$this->Sender->sendEmail(
						$email,
						'request',
						array(
							'station_title' => h($station_title),
							'date' => date('d.m.Y', $time),
							'time' => h($this->request->data['Request']['time']),
							'number' => h($this->request->data['Request']['number']),
							'name' => h($this->request->data['Request']['name']),
							'phone' => h($this->request->data['Request']['phone']),
							'email' => h($this->request->data['Request']['email']),
							'radius' => h($this->request->data['Request']['radius']),
							'car_type' => $this->Request->types[$this->request->data['Request']['type']],
							'brand' => h($brand_name),
							'model' => h($model_name)
						)
					);
				}
				$this->redirect(array('controller' => 'stations', 'action' => 'thanks', 'id' => $request_id));
			}
			else {
				$show_form = true;
				if (!empty($this->request->data['Request']['time'])) {
					$request_time = $this->request->data['Request']['time'];
				}
			}
		}
		$this->loadModel('Page');
		if ($page = $this->Page->find('first', array('conditions' => array('Page.is_active' => 1, 'Page.slug' => 'booking')))) {
			$this->setMeta('title', !empty($page['Page']['meta_title']) ? $page['Page']['meta_title'] : $page['Page']['title']);
			$this->setMeta('keywords', $page['Page']['meta_keywords']);
			$this->setMeta('description', $page['Page']['meta_description']);
			$this->set('page', $page);
			$this->set('active_menu', 'booking');
		}
		$this->set('car_brands', $this->CarBrand->find('list', array('fields' => array('CarBrand.id', 'CarBrand.title'), 'order' => array('CarBrand.title' => 'asc'))));
		if (isset($this->request->data['Request']['brand_id'])) {
			$this->set('car_models', $this->CarModel->find('list', array('fields' => array('CarModel.id', 'CarModel.title'), 'conditions' => array('CarModel.brand_id' => $this->request->data['Request']['brand_id']), 'order' => array('CarModel.title' => 'asc'))));
		}
		else {
			$this->set('car_models', array());
		}
		$this->set('show_left_menu', false);
		$this->set('show_right_menu', true);
		$this->loadModel('Station');
		$this->Station->bindModel(
			array(
				'hasMany' => array(
					'Request' => array(
						'conditions' => array(
							'Request.created >=' => date('Y-m-d 00:00:00', $time),
							'Request.created <=' => date('Y-m-d 23:59:59', $time)
						)
					)
				)
			),
			false
		);
		$this->set('stations', $this->Station->find('all', array('conditions' => array('Station.is_active' => 1), 'order' => array('Station.sort_order' => 'asc'))));
		$this->set('current_date', $current_date);
		$this->set('show_form', $show_form);
		$this->set('station_title', $station_title);
		$this->set('request_time', $request_time);
		$this->set('radiuses', $this->Request->radiuses);
		$this->set('types', $this->Request->types);
	}
	public function thanks($id = null) {
		if ($this->Session->check('requests')) {
			$requests = $this->Session->read('requests');
		}
		else {
			$requests = array();
		}
		if (!in_array($id, $requests)) {
			$this->redirect(array('controller' => 'stations', 'action' => 'booking'));
			return;
		}
		else {
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
			if (!empty($id)) {
				$this->Request->id = $id;
				if ($request = $this->Request->read()) {
					$this->loadModel('Page');
					if ($page = $this->Page->find('first', array('conditions' => array('Page.is_active' => 1, 'Page.slug' => 'booking')))) {
						$this->setMeta('title', !empty($page['Page']['meta_title']) ? $page['Page']['meta_title'] : $page['Page']['title']);
						$this->setMeta('keywords', $page['Page']['meta_keywords']);
						$this->setMeta('description', $page['Page']['meta_description']);
						$this->set('page', $page);
						$this->set('active_menu', 'booking');
					}
					$this->set('types', $this->Request->types);
					$this->set('request', $request);
					$this->set('show_left_menu', false);
					$this->set('show_right_menu', false);
				}
			}
			else {
				$this->response->statusCode(404);
				$this->response->send();
				$this->render(false);
				return;
			}
		}
	}
	public function view($slug) {
		$this->loadModel('Station');
		if ($station = $this->Station->find('first', array('conditions' => array('Station.is_active' => 1, 'Station.slug' => $slug)))) {
			$this->setMeta('title', !empty($station['Station']['meta_title']) ? $station['Station']['meta_title'] : $station['Station']['title']);
			$this->setMeta('keywords', $station['Station']['meta_keywords']);
			$this->setMeta('description', $station['Station']['meta_description']);
			$this->set('station', $station);
			$this->set('active_menu', 'station');
			$this->set('additional_js', array('http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU'));
		}
		else {
			$this->response->statusCode(404);
			$this->response->send();
			$this->render(false);
			return;
		}
	}
}