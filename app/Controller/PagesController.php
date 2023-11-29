<?php
class PagesController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'Page.id' => 'asc'
		)
	);
	public $filter_fields = array('Page.id' => 'int', 'Page.title' => 'text', 'Page.slug' => 'text');
	public $model = 'Page';
	public function home() {
		$this->loadModel('Page');
		$this->_filter_params();
		if ($page = $this->Page->find('first', array('conditions' => array('Page.is_active' => 1, 'Page.slug' => 'home')))) {
			$this->setMeta('title', !empty($page['Page']['meta_title']) ? $page['Page']['meta_title'] : $page['Page']['title']);
			$this->setMeta('keywords', $page['Page']['meta_keywords']);
			$this->setMeta('description', $page['Page']['meta_description']);
			$this->set('page', $page);
			$this->set('active_menu', 'home');
            $this->set('show_left_menu', true);
		}
		$this->set('additional_css', array('jcarousel.responsive.css'));
		$this->set('additional_js', array('jquery.jcarousel.min.js'));
	}
	public function city($slug) {
		$this->loadModel('DeliveryCity');
		$this->DeliveryCity->bindModel(
			array(
				'belongsTo' => array(
					'DeliveryRegion' => array(
						'foreignKey' => 'region_id'
					)
				),
				'hasMany' => array(
					'DeliveryStore' => array(
						'order' => array('DeliveryStore.id' => 'asc'),
						'conditions' => array('DeliveryStore.is_active' => 1),
						'foreignKey' => 'city_id'
					)
				)
			),
			false
		);
		$breadcrumbs = array();
		if ($city = $this->DeliveryCity->find('first', array('conditions' => array('DeliveryCity.is_active' => 1, 'DeliveryCity.slug' => $slug)))) {
			$this->loadModel('Page');
			$this->_filter_params();
			if ($page = $this->Page->find('first', array('conditions' => array('Page.is_active' => 1, 'Page.slug' => 'delivery')))) {
				$this->setMeta('title', !empty($page['Page']['meta_title']) ? $page['Page']['meta_title'] : $page['Page']['title']);
				$this->setMeta('keywords', $page['Page']['meta_keywords']);
				$this->setMeta('description', $page['Page']['meta_description']);
				$breadcrumbs[] = array(
					'url' => array('controller' => 'pages', 'action' => 'delivery'),
					'title' => $page['Page']['title']
				);
				$this->set('page', $page);
				$this->set('active_menu', '');
			}
			$breadcrumbs[] = array(
				'url' => null,
				'title' => $city['DeliveryCity']['title']
			);
			$this->set('breadcrumbs', $breadcrumbs);
			$this->setMeta('title', 'Шины ' . $city['DeliveryCity']['title'] . ', купить диски в ' . $city['DeliveryCity']['title'] . ', ' . $city['DeliveryRegion']['title']);
			$this->setMeta('description', 'Купить шины и диски в ' . $city['DeliveryCity']['title'] . '. Доставка авто шин и дисков в ' . $city['DeliveryCity']['title'] . ', ' . $city['DeliveryRegion']['title'] . '. Сроки доставки 1-4 дня.');

			$this->loadModel('DeliveryRegion');
			$this->DeliveryRegion->bindModel(
				array(
					'hasMany' => array(
						'DeliveryCity' => array(
							'order' => array('DeliveryCity.title' => 'asc'),
							'conditions' => array('DeliveryCity.is_active' => 1),
							'foreignKey' => 'region_id'
						)
					)
				),
				false
			);
			$this->set('regions', $this->DeliveryRegion->find('all', array('conditions' => array('DeliveryRegion.is_active' => 1))));
			$this->set('city', $city);
			$this->set('active_region', $city['DeliveryRegion']['id']);
			$this->set('active_city', $city['DeliveryCity']['id']);
		}
		else {
			$this->response->statusCode(404);
			$this->response->send();
			$this->render(false);
			return;
		}
	}
	public function delivery() {
		/*
		Configure::write('debug', 2);
		$this->loadModel('Brand');
		$this->loadModel('BrandModel');
		if ($brands = $this->Brand->find('all')) {
			foreach ($brands as $brand) {
				if ($models = $this->BrandModel->find('all', array('conditions' => array('BrandModel.brand_id' => $brand['Brand']['id'])))) {
					foreach ($models as $model) {
						$this->BrandModel->recountProducts($model['BrandModel']['id']);
					}
				}
				$this->Brand->recountProducts($brand['Brand']['id']);
				$this->Brand->recountModels($brand['Brand']['id']);
			}
		}

		Configure::write('debug', 2);
		$this->loadModel('Brand');
		$this->loadModel('BrandModel');
		if ($brands = $this->Brand->find('all')) {
			foreach ($brands as $brand) {
				if ($models = $this->BrandModel->find('all', array('conditions' => array('BrandModel.brand_id' => $brand['Brand']['id'])))) {
					foreach ($models as $model) {
						$title = 'Шина ';
						if ($model['BrandModel']['category_id'] == 2) {
							$title = 'Автомобильный диск ';
						}
						$this->BrandModel->id = $model['BrandModel']['id'];
						$this->BrandModel->saveField('meta_title', $title . $brand['Brand']['title'] . ' ' . $model['BrandModel']['title']);
					}
				}
			}
		}
		exit();
		*/
		$this->loadModel('Page');
		$this->_filter_params();
		if ($page = $this->Page->find('first', array('conditions' => array('Page.is_active' => 1, 'Page.slug' => 'delivery')))) {
			$this->setMeta('title', !empty($page['Page']['meta_title']) ? $page['Page']['meta_title'] : $page['Page']['title']);
			$this->setMeta('keywords', $page['Page']['meta_keywords']);
			$this->setMeta('description', $page['Page']['meta_description']);
			$breadcrumbs = array();
			$breadcrumbs[] = array(
				'url' => null,
				'title' => $page['Page']['title']
			);
			$this->set('page', $page);
			$this->set('active_menu', '');
			$this->set('breadcrumbs', $breadcrumbs);
		}
		$this->loadModel('DeliveryRegion');
		$this->DeliveryRegion->bindModel(
			array(
				'hasMany' => array(
					'DeliveryCity' => array(
						'order' => array('DeliveryCity.title' => 'asc'),
						'conditions' => array('DeliveryCity.is_active' => 1),
						'foreignKey' => 'region_id'
					)
				)
			),
			false
		);
		$this->set('regions', $this->DeliveryRegion->find('all', array('conditions' => array('DeliveryRegion.is_active' => 1))));
	}
	public function view($slug) {
		/*
		$slugs = array();
		$this->loadModel('City');
		if ($cities = $this->City->find('all')) {
			foreach ($cities as $item) {
				$slug = $this->_transliterate($item['City']['title']);
				$test_slug = $slug;
				$i = 2;
				while (in_array($test_slug, $slugs)) {
					$test_slug = $slug . $i;
					$i ++;
				}
				$slug = $test_slug;
				$slugs[] = $slug;
				$this->City->id = $item['City']['id'];
				$this->City->saveField('slug', $slug);
			}
		}*/
		$this->loadModel('Page');
		$this->_filter_params();
		if ($page = $this->Page->find('first', array('conditions' => array('Page.is_active' => 1, 'Page.slug' => $slug)))) {
			$this->setMeta('title', !empty($page['Page']['meta_title']) ? $page['Page']['meta_title'] : $page['Page']['title']);
			$this->setMeta('keywords', $page['Page']['meta_keywords']);
			$this->setMeta('description', $page['Page']['meta_description']);
			$breadcrumbs = array();
			$breadcrumbs[] = array(
				'url' => null,
				'title' => $page['Page']['title']
			);
			if ($page['Page']['gallery']) {
				$this->set('additional_css', array('galleryview'));
				$this->set('additional_js', array('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js', 'galleryview'));
			}
			if ($slug == 'service') {
				$this->set('additional_js', array('jquery-1.10.2.min', 'lightbox-2.6.min'));
				$this->set('additional_css', array('lightbox-2.6'));
			}
			$this->set('page', $page);
			$this->set('active_menu', $slug);
			$this->set('breadcrumbs', $breadcrumbs);
		}
		else {
			$this->response->statusCode(404);
			$this->response->send();
			$this->render(false);
			return;
		}
	}
	public function sales() {
		$this->loadModel('Page');
		$this->_filter_params();
		if ($page = $this->Page->find('first', array('conditions' => array('Page.is_active' => 1, 'Page.slug' => 'sales')))) {
			$this->setMeta('title', !empty($page['Page']['meta_title']) ? $page['Page']['meta_title'] : $page['Page']['title']);
			$this->setMeta('keywords', $page['Page']['meta_keywords']);
			$this->setMeta('description', $page['Page']['meta_description']);
			$breadcrumbs = array();
			$breadcrumbs[] = array(
				'url' => null,
				'title' => $page['Page']['title']
			);
			$this->set('page', $page);
			$this->set('active_menu', '');
			$this->set('breadcrumbs', $breadcrumbs);
		}
		$mode = 'block';
		if (isset($this->request->query['mode']) && in_array($this->request->query['mode'], array('block', 'list', 'table'))) {
			$mode = $this->request->query['mode'];
		}
		$tab = 'tyres';
		if (isset($this->request->query['tab']) && in_array($this->request->query['tab'], array('tyres', 'disks'))) {
			$tab = $this->request->query['tab'];
		}
		$this->loadModel('Product');
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
		$this->set('data', $this->Product->find('all', array('conditions' => array('Product.is_active' => 1, 'Product.sale' => 1, 'Brand.is_active' => 1, 'BrandModel.is_active' => 1))));
		$this->set('show_left_menu', true);
		$this->set('mode', $mode);
		$this->set('tab', $tab);
		$this->set('seasons', $this->Product->seasons);
		$this->set('additional_js', array('lightbox', 'functions'));
		$this->set('additional_css', array('lightbox'));
	}
	public function calculator() {
		$this->loadModel('Page');
		if ($page = $this->Page->find('first', array('conditions' => array('Page.is_active' => 1, 'Page.slug' => 'calculator')))) {
			$this->setMeta('title', !empty($page['Page']['meta_title']) ? $page['Page']['meta_title'] : $page['Page']['title']);
			$this->setMeta('keywords', $page['Page']['meta_keywords']);
			$this->setMeta('description', $page['Page']['meta_description']);
			$this->set('page', $page);
		}
		$this->_filter_params();
		$this->set('active_menu', '');
		$breadcrumbs = array();
		$breadcrumbs[] = array(
			'url' => null,
			'title' => 'Шинно-дисковый калькулятор'
		);
		$this->set('show_left_menu', false);
		$this->set('breadcrumbs', $breadcrumbs);
		$this->set('additional_css', array('app'));
		$this->set('additional_js', array('gen_forms'));
	}
	public function feedback() {
		$empty = false;
		if (!empty($this->request->data)) {
			$captcha_key = '0';
			if (isset($this->request->data['Feedback']['captcha_key']) && !empty($this->request->data['Feedback']['captcha_key'])) {
				$captcha_key = $this->request->data['Feedback']['captcha_key'];
			}
			if ($this->Session->check('Captcha.code.' . $captcha_key)) {
				$this->request->data['Feedback']['captcha_code'] = $this->Session->read('Captcha.code.' . $captcha_key);
			}
			else {
				unset($this->request->data['Feedback']['code']);
			}
			$phone_code = $this->request->data['Feedback']['phone_code'];
			$phone_number = $this->request->data['Feedback']['phone_number'];
			$this->request->data['Feedback']['phone_code'] = '(' . $this->request->data['Feedback']['phone_code'] . ') ' . $this->request->data['Feedback']['phone_number'];
			$this->Session->delete('Feedback.code');
			$this->loadModel('Feedback');
			if ($this->Feedback->save($this->request->data)) {
				App::uses('CakeEmail', 'Network/Email');
				$host = env('HTTP_HOST');
				$emails = explode(',', CONST_FEEDBACK_EMAIL);
				foreach ($emails as $email) {
					$cake_email = new CakeEmail('default');
					$cake_email->to(trim($email));
					$from = 'noreply@' . $host;
					$cake_email->template('feedback', 'email');
					$cake_email->from($from);
					$cake_email->replyTo('info@' . $host);
					$cake_email->returnPath('info@' . $host);
					$cake_email->emailFormat('html');
					$cake_email->subject('Обратная свзяь на сайте ' . $host);
					$cake_email->viewVars(array(
						'name' => $this->request->data['Feedback']['name'],
						'email' => $this->request->data['Feedback']['email'],
						'phone' => $this->request->data['Feedback']['phone_code'],
						'message' => $this->request->data['Feedback']['message'],
						'host' => $host
					));
					$cake_email->send();
				}
				$this->info('Спасибо. Ваше сообщение отправлено');
				$this->request->data['Feedback'] = array();
				$this->request->data['Feedback']['phone_code'] = '495';
			}
			else {
				$this->request->data['Feedback']['phone_code'] = $phone_code;
				$this->request->data['Feedback']['phone_number'] = $phone_number;
				$this->error('Заполните все поля');
			}
			$this->request->data['Feedback']['code'] = '';
		}
		else {
			$empty = true;
			$this->request->data['Feedback']['phone_code'] = '495';
		}
		$this->setMeta('title', 'Обратная связь');
		if ($this->request->isAjax()) {
			$this->set('ajax', true);
			if (!$empty) {
				$this->layout = 'ajax';
			}
			else {
				$this->layout = 'empty';
			}
		}
		else {
			$this->set('ajax', false);
		}
	}
	public function last() {
		$this->_filter_params();
		$this->loadModel('Product');
		$this->set('active_menu', '');
		$this->set('show_left_menu', true);
		$this->set('seasons', $this->Product->seasons);
		$this->set('additional_js', array('lightbox', 'functions'));
		$this->set('additional_css', array('lightbox'));
	}
	
	public function test(){

		$this->loadModel('Order');
		$orders = $this->Order->find('all');
		foreach($orders as $o)
		{
			$str = $o['Order']['created'].";".$o['Order']['name'].";".$o['Order']['name'].";".$o['Order']['phone'].";".$o['Order']['email'].";".$o['Order']['city']."\n";
			file_put_contents("data.txt", $str, FILE_APPEND);
			
		}
		echo 'done';
		exit;
		
	}
}