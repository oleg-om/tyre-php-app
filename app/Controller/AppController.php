<?php
class AppController extends Controller {
	public $components = array('Auth', 'Session', 'Cookie', 'Sender');
	public $helpers = array('Form', 'Html', 'Js', 'Session', 'Paginator', 'Text', 'Time', 'Number', 'Backend', 'Frontend');
	public $meta_title = null;
	public $meta_keywords = null;
	public $meta_description = null;
	public $sections = array();
	public $limits = array(10 => 10, 20 => 20, 30 => 30, 40 => 40, 50 => 50, 100 => 100, 500 => 500);
	public $submenu = null;
	public $section = null;
	public $conditions = array();
	public $currencies = array();
	public $category_id = 1;
	public $layout = 'default';
	
	
	public function beforeFilter() {
				/*
		$this->loadModel('BrandModel');
		if ($models = $this->BrandModel->find('list', array('fields' => array('BrandModel.id', 'BrandModel.id')))) {
			$this->BrandModel->recountProducts(array_keys($models));
		}

		$this->loadModel('City');
		$this->loadModel('Region');
		$this->loadModel('Store');
		$shipping_type_id = 3;
		$lines = file(ROOT . DS . 'sat.csv');
		$regions = array();
		$cities = array();
		foreach ($lines as $line) {
			$line = trim($line);
			if (!empty($line)) {
				$item = explode(';', $line);
				if (!isset($regions[$item[3]])) {
					$save_data = array(
						'is_active' => 1,
						'shipping_type_id' => $shipping_type_id,
						'title' => $item[3]
					);
					$this->Region->create();
					if ($this->Region->save($save_data)) {
						$regions[$item[3]] = $this->Region->id;
						$cities[$item[3]] = array();
					}
				}
				if (!isset($cities[$item[3]][$item[0]])) {
					$save_data = array(
						'is_active' => 1,
						'shipping_type_id' => $shipping_type_id,
						'region_id' => $regions[$item[3]],
						'title' => $item[0]
					);
					$this->City->create();
					if ($this->City->save($save_data)) {
						$cities[$item[3]][$item[0]] = $this->City->id;
					}
				}
				$save_data = array(
					'is_active' => 1,
					'shipping_type_id' => $shipping_type_id,
					'region_id' => $regions[$item[3]],
					'city_id' => $cities[$item[3]][$item[0]],
					'title' => $item[1],
					'phone' => trim($item[2])
				);
				$this->Store->create();
				$this->Store->save($save_data);
			}
		}
		
		*/
				
				//exit();

				//phpinfo();
			//	exit();
					
		$admin = false;
		if (isset($this->request->params['admin']) && $this->request->params['admin'] == 1) {
			$admin = true;
		}
		$this->Cookie->name = 'kerch';
		Configure::write('Config.language', 'ru');
		$this->Session->write('Config.language', 'ru');
		if ($admin) {
			AuthComponent::$sessionKey = 'Auth.Administrator';
			$this->Auth->authError = __d('admin_administrators', 'error_auth');
			$this->Auth->loginError = __d('admin_administrators', 'error_login');
			$this->Auth->loginAction = array('controller' => 'administrators', 'action' => 'login', 'admin' => true);
			$this->Auth->logoutAction = array('controller' => 'administrators', 'action' => 'logout', 'admin' => true);
			$this->Auth->loginRedirect = array('controller' => 'dashboard', 'action' => 'admin_index');
			$this->Auth->logoutRedirect = array('controller' => 'administrators', 'action' => 'login', 'admin' => true);
	        $this->Auth->authenticate = array(
				'Form' => array(
					'userModel' => 'Administrator',
					'scope' => array('Administrator.is_active' => 1)
				)
			);
			$this->Auth->authorize = array('Controller');
			if ($this->Auth->isAuthorized()) {
				$this->_getSections();
				$this->loadModel('Administrator');
				$this->Administrator->id = $this->Auth->user('id');
				$this->Administrator->saveField('logged', date('Y-m-d H:i:s'));
			}
			if ($this->Auth->user()) {
				if (!$this->isAuthorized()) {
					if ($this->request->isAjax()) {
						$data = array();
						$data['deny'] = true;
						$data['return_html'] = '';
						header('Content-type: application/json');
						$json = json_encode($data);
						if (isset($this->request->params['url']['callback'])) {
							echo $this->request->params['url']['callback'] . '(' . $json . ')';
						}
						else {
							echo $json;
						}
						exit();
					}
					else {
						$error_message = __d('admin_common', 'error_access_denied');
						if ($this->action == 'admin_delete') {
							$error_message = __d('admin_common', 'error_delete_denied');
						}
						$this->error($error_message);
						$referer = $this->referer();
						if ($referer == '/') {
							$referer = array('controller' => 'dashboard', 'action' => 'admin_index');
						}
						$this->redirect($referer);
						return;
					}
				}
			}
			$m_state = $this->Cookie->read('m_state');
			if ($m_state == null) $m_state = 0;
			$s_state = array();
			for ($i = 0; $i < 4; $i ++) {
				$s_state[$i] = $this->Cookie->read('s_state_' . $i);
				if ($s_state[$i] == null) $s_state[$i] = 0;
			}
			$this->set('m_state', $m_state);
			$this->set('s_state', $s_state);
			$this->set('menu_sections', $this->sections);
			$this->set('action', $this->action);
		}
		else {
			$this->Components->disable('Auth');
			if ($this->Session->check('cart')) {
				$cart = $this->Session->read('cart');
			}
			else {
				$cart = array('items' => array(), 'total' => 0);
				$this->Session->write('cart', $cart);
			}
			$this->set('cart', $cart);
			$this->setCurrencies();
		}
		$this->setSettings();
		$this->set('host', env('HTTP_HOST'));
	}
	public function isAuthorized($user = null) {
		return true;
	}
	public function beforeRender() {
		if (!isset($this->request->params['admin'])) {
			$meta_title = $this->getMeta('title');
			$meta_keywords = $this->getMeta('keywords');
			$meta_description = $this->getMeta('description');
			if (empty($meta_title)) {
				$meta_title = CONST_META_TITLE;
			}
			else {
				$meta_title .= CONST_META_TITLE_DELIMITER . CONST_META_TITLE_SUFFIX;
			}
			if (empty($meta_keywords)) {
				$meta_keywords = CONST_META_KEYWORDS;
			}
			if (empty($meta_description)) {
				$meta_description = CONST_META_DESCRIPTION;
			}
			$this->setBrands();
			$this->set('meta_title', $meta_title);
			$this->set('meta_keywords', $meta_keywords);
			$this->set('meta_description', $meta_description);
			$this->set('last_models', $this->Session->read('last_models'));
            $this->getCurrentSeason();
            $this->setCarBrandsForLeftMenu();
		}
	}

    public function getCurrentSeason() {
        $month = date('m');

        if($month > 3 && $month < 11){
            $season = 'summer';
        } else {
            $season = 'winter';
        }
        $this->set('current_season', $season);
        return $season;
    }
	private function setSettings() {
		$settings = Cache::read('settings', 'long');
		if (empty($settings)) {
			$this->loadModel('Setting');
			$settings = $this->Setting->get();
			Cache::write('settings', $settings, 'long');
		}
		foreach ($settings as $key => $value) {
			if (!defined('CONST_' . $key)) {
				define('CONST_' . $key, $value);
			}
		}
        define('CONST_DEFAULT_TYRES_PATH', '?auto=&axis=&size1=&season=&brand_id=&stud=0&in_stock4=0&in_stock=2&upr_all=1');
        define('CONST_DEFAULT_DISKS_PATH', '?size3=&size1=&material=&et_from=&et_to=&size2=&hub=&brand_id=&in_stock4=0&in_stock=2');
        define('CONST_DEFAULT_AKB_PATH', '?ah_from=60&current=&f1=&width=&length=&height=&brand_id=');
        define('CONST_DEFAULT_TRUCK_TYRES_PATH', '?auto=trucks&in_stock4=0&in_stock=2&upr_all=1');
        define('CONST_DEFAULT_TRUCK_DISKS_PATH', '?auto=trucks&size3=&size1=&material=&et_from=&et_to=&size2=&hub=&brand_id=&in_stock4=0&in_stock=2');

        $stock_places = array(0 => 'ул. Мирошника 5, Автодом', 1 => 'ул. Шевякова (район авторынка), Vianor Tip-top', 2 => 'ул. Куль-обинское шоссе 1, MICHELIN',
            3 => 'АТП', 4 => 'ул. Вокзальное шоссе 36, шиномонтаж Таксо', 5 => 'ул. Вокзальное шоссе 44, VIANOR', 6 => 'ул. Чкалова 147А, VIANOR',
            7 => 'Таврида', 8 => 'Грузовой склад');

        $this->set('filter_all_places', $stock_places);

        $stock_places_short = array(0 => 'ул. Мирошника 5, Автодом', 1 => 'ул. Шевякова (район авторынка), Vianor Tip-top', 2 => 'ул. Куль-обинское шоссе 1',
            3 => 'АТП', 4 => 'ул. Вокзальное шоссе 36, шиномонтаж Таксо', 5 => 'ул. Вокзальное шоссе 44', 6 => 'ул. Чкалова 147А, VIANOR',
            7 => 'Таврида', 8 => 'Грузовой склад');

        $this->set('filter_all_places_short', $stock_places_short);
	}
	private function setCurrencies() {
		$currencies = Cache::read('currencies', 'long');
		if (empty($currencies)) {
			$this->loadModel('Currency');
			$currencies = $this->Currency->find('all', array('conditions' => array('Currency.is_active' => 1), 'order' => array('Currency.sort_order' => 'asc')));
			Cache::write('currencies', $currencies, 'long');
		}
		$this->currencies = $currencies;
		$this->set('currencies', $currencies);
	}
	public function setBrands() {
		if ($this->category_id < 4) {
			$brands = Cache::read('brands_' . $this->category_id, 'long');
			if (empty($brands)) {
				$this->loadModel('Brand');
				if ($brands = $this->Brand->find('all', array('order' => array('Brand.title' => 'asc'), 'conditions' => array('Brand.category_id' => $this->category_id, 'Brand.is_active' => 1, 'Brand.active_products_count > 0'), 'fields' => array('Brand.id', 'Brand.slug', 'Brand.title')))) {
					Cache::write('brands_' . $this->category_id, $brands, 'long');
				}
			}
			$this->set('brands', $brands);
		}
		$car_brands_index = Cache::read('car_brands_index', 'long');
		if (empty($car_brands_index)) {
			$this->loadModel('CarBrand');
			if ($car_brands_index = $this->CarBrand->find('all', array('conditions' => array('CarBrand.is_active' => 1, 'CarBrand.items_count >' => 0), 'order' => array('CarBrand.title' => 'asc')))) {
				Cache::write('car_brands_index', $car_brands_index, 'long');
			}
		}
		$this->set('car_brands_index', $car_brands_index);
		$this->set('category_id', $this->category_id);
	}

	public function setCarBrands() {
			$brands = Cache::read('car_brands', 'long');
			if (empty($brands)) {
				$this->loadModel('Brand');
				if ($temp = $this->CarBrand->find('all', array('conditions' => array('CarBrand.is_active' => 1, 'CarBrand.items_count >' => 0), 'order' => array('CarBrand.title' => 'asc')))) {

                    $object = new stdClass();
                    foreach ($temp as $key => $value)
                    {
                        $object->$value['CarBrand']['slug'] = $value['CarBrand']['title'];
                    }
					Cache::write('car_brands', $object, 'long');
                    $this->set('car_brands', $object);
				}
			} else {
                $this->set('car_brands', $brands);
            }

		$this->set('category_id', $this->category_id);
	}

    public function setCarBrandsForLeftMenu() {
        $this->setCarBrands();
    }
	public function setMeta($key, $value) {
		if (!empty($value))
			$this->{'meta_'.$key} = $value;
	}
	private function getMeta($key) {
		return $this->{'meta_'.$key};
	}
	public function info($message = '') {
		$this->Session->setFlash($message, 'default', array(), 'info');
	}
	public function error($message = '') {
		
		$this->Session->setFlash($message, 'default', array(), 'error');
	}
	private function getLimit() {
		$limit = isset($this->passedArgs['limit']) ? $this->passedArgs['limit'] : 30;
		if (!isset($this->limits[$limit])) $limit = 30;
		return $limit;
	}
	private function filterFields() {
		foreach ($this->filter_fields as $key => $type) {
			list($model_name, $field_name) = explode('.', $key);
			$this->request->data[$model_name][$field_name] = isset($this->request->named[$key]) ? $this->request->named[$key] : '';
		}
	}
	public function redirectFields($model, $id) {
		if ($id != null) {
			$this->filterFields();
		}
		$filter = array();
		foreach ($this->filter_fields as $key => $type) {
			list($model_name, $field_name) = explode('.', $key);
			if (isset($this->request->data[$model_name][$field_name]) && $this->request->data[$model_name][$field_name] != '') {
				$filter[$key] = $this->request->data[$model_name][$field_name];
			}
			unset($this->request->data[$model_name][$field_name]);
		}
		if (isset($this->request->data[$model]['limit'])) {
			$filter['limit'] = $this->request->data[$model]['limit'];
			unset($this->request->data[$model]['limit']);
		}
		elseif (isset($this->passedArgs['limit'])) {
			$filter['limit'] = $this->passedArgs['limit'];
		}
		if (isset($this->request->data[$model]['page'])) {
			$filter['page'] = $this->request->data[$model]['page'];
			unset($this->request->data[$model]['page']);
		}
		elseif (isset($this->passedArgs['page'])) {
			$filter['page'] = $this->passedArgs['page'];
		}
		if (isset($this->request->data[$model]['sort'])) {
			$filter['sort'] = $this->request->data[$model]['sort'];
			unset($this->request->data[$model]['sort']);
		}
		elseif (isset($this->passedArgs['sort'])) {
			$filter['sort'] = $this->passedArgs['sort'];
		}
		if (isset($this->request->data[$model]['direction'])) {
			$filter['direction'] = $this->request->data[$model]['direction'];
			unset($this->request->data[$model]['direction']);
		}
		elseif (isset($this->passedArgs['direction'])) {
			$filter['direction'] = $this->passedArgs['direction'];
		}
		return $filter;
	}
	private function _getSections() {
		$this->_setSections();
		$sections = array();
		for ($i = 0; $i < count($this->sections); $i ++) {
			$_sections = array();
			foreach ($this->sections[$i]['menu_items'] as $key => $subsections) {
				$_section = array();
				$_section['title'] = $subsections['title'];
				$_section['link'] = $subsections['link'];
				$_section['submenu'] = array();
				for ($j = 0; $j < count($subsections['submenu']); $j ++) {
					$submenu_items = array();
					foreach ($subsections['submenu'][$j]['items'] as $item) {
						$submenu_items[] = $item;
					}
					if (!empty($submenu_items)) {
						$_section['submenu'][] = array('title' => $subsections['submenu'][$j]['title'], 'items' => $submenu_items);
					}
				}
				if (empty($_section['submenu'])) {
					unset($_section['submenu']);
				}
				elseif (!isset($_section['link'])) {
					$_section['title'] = $subsections['title'];
					$_section['link'] = $_section['submenu'][0]['items'][0]['link'];
				}
				if (!empty($_section)) {
					$_sections[$key] = $_section;
				}
			}
			if (!empty($_sections)) {
				$sections[$i] = array();
				$sections[$i]['title'] = $this->sections[$i]['title'];
				$sections[$i]['icon'] = $this->sections[$i]['icon'];
				$sections[$i]['class'] = $this->sections[$i]['class'];
				$sections[$i]['menu_items'] = $_sections;
			}
		}
		$this->sections = $sections;
	}
	private function _setSections() {
		App::uses('Xml', 'Utility');
		$sections = Xml::toArray(Xml::build(APP . 'Config' . DS . 'sections.xml'));
		if (isset($sections['sections']['section']['@key'])) {
			$sections['sections']['section'] = array($sections['sections']['section']);
		}
		foreach ($sections['sections']['section'] as $i => $section_node) {
			$section_key = $section_node['@key'];
			$section = array();
			$section['title'] = __d('admin_menu_sections', 'section_' . $section_key);
			$section['icon'] = $section_key;
			$section['class'] = 'box' . $i;
			$section['menu_items'] = array();
			if (!empty($section_node['menu'])) {
				if (!isset($section_node['menu'][0])) {
					$section_node['menu'] = array($section_node['menu']);
				}
				foreach ($section_node['menu'] as $menu_node) {
					$menu_key = $menu_node['@key'];
					$section['menu_items'][$menu_key] = array();
					$section['menu_items'][$menu_key]['title'] = __d('admin_menu_sections', 'menu_' . $menu_key);
					$section['menu_items'][$menu_key]['submenu'] = array();
					if (!empty($menu_node['submenu'])) {
						if (!isset($menu_node['submenu'][0])) {
							$menu_node['submenu'] = array($menu_node['submenu']);
						}
						foreach ($menu_node['submenu'] as $submenu_node) {
							if (isset($submenu_node['@key'])) {
								$submenu_key = $submenu_node['@key'];
							}
							else {
								$submenu_key = $menu_key;
							}
							$submenu = array();
							$submenu['title'] = __d('admin_menu_sections', 'submenu_' . $submenu_key);
							$submenu['items'] = array();
							if (!is_array($submenu_node['action'])) {
								$submenu_node['action'] = array($submenu_node['action']);
							}
							foreach ($submenu_node['action'] as $action_key) {
								$submenu['items'][] = array(
									'title' => __d('admin_menu_sections', $submenu_key . '_' . $action_key),
									'icon' => $submenu_key . '-' . $action_key,
									'link' => array(
										'controller' => $submenu_key,
										'action' => $action_key,
										'admin' => true
									)
								);
							}
							$section['menu_items'][$menu_key]['submenu'][] = $submenu;
						}
						if (!empty($section['menu_items'][$menu_key]['submenu'])) {
							$section['menu_items'][$menu_key]['link'] = $section['menu_items'][$menu_key]['submenu'][0]['items'][0]['link'];
						}
					}
				}
			}
			$this->sections[] = $section;
		}
	}
	public function t($message, $title = '') {
		return __d('admin_' . Inflector::underscore($this->name), $message, $title);
	}
	public function admin_list() {
		$this->_list();
		$this->set('section', $this->getSection($this->getSubmenu()));
		$this->set('submenu', $this->getSubmenu());
		$this->set('title_for_layout', $this->t('title_list'));
		$this->layout = 'admin';
		$this->render('admin_list');
	}
	public function admin_add() {
		$this->_edit(0);
		$this->set('section', $this->getSection($this->getSubmenu()));
		$this->set('submenu', $this->getSubmenu());
		$this->set('title_for_layout', $this->t('title_add'));
		$this->layout = 'admin';
		$this->render('admin_form');
	}
	public function admin_edit($id = null) {
		$title = $this->_edit($id);
		$this->set('section', $this->getSection($this->getSubmenu()));
		$this->set('submenu', $this->getSubmenu());
		$this->set('title_for_layout', $this->t('title_edit', $title));
		$this->layout = 'admin';
		$this->render('admin_form');
	}
	public function admin_enable($id = 0) {
		$this->_status($id, 1);
	}
	public function admin_disable($id = 0) {
		$this->_status($id, 0);
	}
	private function _status($id, $state) {
		Configure::write('debug', 0);
		$this->layout = 'switcher';
		$this->set('id', $id);
		$this->set('url', '/admin/' . Inflector::underscore($this->name) . '/');
		$this->set('icon', 'lightbulb');
		$this->set('url_enabled', 'enable');
		$this->set('url_disabled', 'disable');
		$this->set('title_enabled', $this->t('title_enabled'));
		$this->set('title_disabled', $this->t('title_disabled'));
		$this->set('prefix', 'status');
		$this->loadModel($this->model);
		$this->{$this->model}->id = $id;
		if ($this->{$this->model}->saveField('is_active', $state, false)) {
			$this->{$this->model}->afterSave();
			$this->set('status', $state);
		}
		else {
			$this->set('status', abs($state - 1));
		}
		$this->render(false);
	}
	public function admin_apply() {
		$filter = $this->redirectFields($this->model, null);
		$this->loadModel($this->model);
		if (!empty($this->request->data) && isset($this->request->data[$this->model])) {
			foreach ($this->request->data[$this->model] as $id => $item) {
				if (isset($item['sort_order'])) {
					$this->{$this->model}->id = $id;
					$this->{$this->model}->saveField('sort_order', $item['sort_order']);
				}
			}
			$this->info($this->t('message_sort_order_saved'));
		}
		$url = array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list');
		$url = array_merge($url, $filter);
		$this->redirect($url);
	}
	public function admin_delete($id = null) {
		$filter = $this->redirectFields($this->model, $id);
		$this->loadModel($this->model);
		if ($id != null) {
			if ($this->{$this->model}->delete($id)) {
				$this->info($this->t('message_item_deleted'));
			}
			else {
				$this->error($this->t('error_item_not_deleted'));
			}
		}
		else {
			if (!empty($this->request->data) && isset($this->request->data[$this->model])) {
				$deleted_items = 0;
				$delete_items = 0;
				foreach ($this->request->data[$this->model] as $id => $item) {
					if (isset($item['delete']) && $item['delete'] == 1) {
						$delete_items++;
						if ($this->{$this->model}->delete($id)) {
							$deleted_items++;
						}
					}
				}
				if ($delete_items == 0) {
					$this->error($this->t('error_select_items_to_delete'));
				}
				elseif ($delete_items == $deleted_items) {
					$this->info($this->t('message_items_deleted'));
				}
				else {
					$this->error($this->t('error_items_not_deleted'));
				}
			}
		}
		$url = array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list');
		$url = array_merge($url, $filter);
		$this->redirect($url);
	}
	public function admin_up($id = 0) {
		$filter = $this->redirectFields($this->model, $id);
		$this->loadModel($this->model);
		if ($this->{$this->model}->moveUp($id)) {
			$this->info($this->t('message_item_moved_up'));
		}
		else {
			$this->error($this->t('error_item_moved_up'));
		}
		$url = array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list');
		$url = array_merge($url, $filter);
		$this->redirect($url);
	}
	public function admin_down($id = 0) {
		$filter = $this->redirectFields($this->model, $id);
		$this->loadModel($this->model);
		if ($this->{$this->model}->moveDown($id)) {
			$this->info($this->t('message_item_moved_down'));
		}
		else {
			$this->error($this->t('error_item_moved_down'));
		}
		$url = array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list');
		$url = array_merge($url, $filter);
		$this->redirect($url);
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
	public function _list() {
		$this->loadModel($this->model);
		$this->paginate['limit'] = $this->getLimit();
		$this->request->data[$this->model]['limit'] = $this->paginate['limit'];
		$this->filterFields($this->model);
		$date_fields = array();
		foreach ($this->filter_fields as $key => $type) {
			if ($type == 'from' || $type == 'to') {
				$date_fields[$key] = null;
			}
		}
		if (!empty($this->request->data)) {
			foreach ($this->filter_fields as $key => $type) {
				list($model_name, $field_name) = explode('.', $key);
				if ($type == 'from' || $type == 'to') {
					if (substr_count($this->request->data[$this->model][$field_name], '.') == 2) {
						list($d, $m, $y) = explode('.', $this->request->data[$this->model][$field_name]);
						if (checkdate($m, $d, $y)) {
							if ($type == 'from') {
								$date_fields[$field_name] = mktime(0, 0, 0, $m, $d, $y);
							}
							else {
								$date_fields[$field_name] = mktime(23, 59, 59, $m, $d, $y);
							}
						}
					}
				}
			}
		}
		$conditions = $this->conditions;
		foreach ($this->filter_fields as $key => $type) {
			list($model_name, $field_name) = explode('.', $key);
			$value = $this->request->data[$this->model][$field_name];
			if ($value != '') {
				switch ($type) {
					case 'text':
						$conditions[$key . ' LIKE'] = '%' . $value . '%';
						break;
					case 'from':
						if (!empty($date_fields[$field_name])) {
							$field = str_replace('_from', '', $key);
							$conditions[$field . ' >='] = date('Y-m-d H:i:s', $date_fields[$field_name]);
							$this->request->data[$this->model][$field_name] = date('d.m.Y', $date_fields[$field_name]);
						}
						break;
					case 'to':
						if (!empty($date_fields[$field_name])) {
							$field = str_replace('_to', '', $key);
							$conditions[$field . ' <='] = date('Y-m-d H:i:s', $date_fields[$field_name]);
							$this->request->data[$this->model][$field_name] = date('d.m.Y', $date_fields[$field_name]);
						}
						break;
					default:
						$conditions[$key] = $value;
				}
			}
		}
		$data = $this->paginate($this->model, $conditions);
		$this->set(compact('data'));
		$this->set('filter_fields', array_keys($this->filter_fields));
		$this->set('limits', $this->limits);
	}
	public function getSection($submenu) {
		$section = null;
		foreach ($this->sections as $key => $item) {
			if (isset($item['menu_items'][$submenu])) {
				$section = $key;
				break;
			}
		}
		return $section;
	}
	public function getSubmenu() {
		if (empty($this->submenu)) {
			$this->submenu = strtolower(Inflector::underscore($this->name));
		}
		return $this->submenu;
	}
	public function _getMode() {
		$mode = 'grid';
		if (isset($this->request->query['mode']) && in_array($this->request->query['mode'], array('grid', 'list'))) {
			$mode = $this->request->query['mode'];
		}
		else {
			$cookie_mode = $this->Cookie->read('mode');
			if (!empty($cookie_mode)) {
				$mode = $cookie_mode;
			}
		}
		$this->Cookie->write('mode', $mode, false, '1 year');
		return $mode;
	}
	public function _getSortField() {
		$sort_field = 'price';
		if (isset($this->request->query['sort_field']) && in_array($this->request->query['sort_field'], array('price', 'name', 'category', 'manufacturer'))) {
			$sort_field = $this->request->query['sort_field'];
		}
		else {
			$cookie_sort_field = $this->Cookie->read('sort_field');
			if (!empty($cookie_sort_field)) {
				$sort_field = $cookie_sort_field;
			}
		}
		$this->Cookie->write('sort_field', $sort_field, false, '1 year');
		return $sort_field;
	}
	public function _getDateWithMonth($date) {
		$timestamp = strtotime($date);
		list($day, $month, $year) = explode('-', date('j-n-Y', $timestamp));
		return $day . ' ' . $this->monthes[$month] . ' ' . $year;
	}
	public function _transliterate($title) {
		$replaces[0] = array('а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я');
		$replaces[1] = array('a', 'b', 'v', 'g', 'd', 'e', 'e', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'y', 'f', 'h', 'ts', 'ch', 'sh', 'shh', '', 'i', '', 'e', 'yu', 'ya', 'A', 'B', 'V', 'G', 'D', 'E', 'E', 'Zh', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'Y', 'F', 'H', 'Ts', 'Ch', 'Sh', 'Shh', '', 'I', '', 'E', 'Yu', 'Ya');
		$title = iconv('utf-8', 'windows-1251', $title);
		for ($i=0;$i<count($replaces[0]);$i++) {
			$replaces[0][$i] = iconv('utf-8', 'windows-1251', $replaces[0][$i]);
		}
		$slug = trim(preg_replace(iconv('utf-8', 'windows-1251', '/[^A-zА-я0-9 \_-]+/'), '', $title));
		$slug = str_replace($replaces[0], $replaces[1], $slug);
		$slug = str_replace(' ', '-', $slug);
		$slug = strtolower(preg_replace('/-+/', '-', $slug));
		return $slug;
	}
	public function comments($id, $type) {
		$this->loadModel('Comment');
		if (!empty($this->request->data)) {
			$captcha_key = '0';
			if (isset($this->request->data['Comment']['captcha_key']) && !empty($this->request->data['Comment']['captcha_key'])) {
				$captcha_key = $this->request->data['Comment']['captcha_key'];
			}
			if ($this->Session->check('Captcha.code.' . $captcha_key)) {
				$this->request->data['Comment']['captcha_code'] = $this->Session->read('Captcha.code.' . $captcha_key);
			}
			else {
				unset($this->request->data['Comment']['code']);
			}
			$this->request->data['Comment']['is_active'] = 1;
			$this->request->data['Comment']['ip'] = ip2long($this->request->clientIp());
			$this->request->data['Comment']['date'] = date('Y-m-d H:i:s');
			$this->request->data['Comment']['type'] = $type;
			$this->request->data['Comment']['publication_id'] = $id;
			if ($this->Auth->isAuthorized()) {
				$this->request->data['Comment']['user_id'] = $this->Auth->user('id');
			}
			else {
				unset($this->request->data['Comment']['user_id']);
			}
			$this->request->data['Comment']['comment'] = strip_tags($this->request->data['Comment']['comment'], '<b><i><u><span><br><ul><li><ol><p>');
			app::import('Vendor', 'htmlpurifier', array('file' => 'htmlpurifier' . DS . 'HTMLPurifier.auto.php'));
			$config = HTMLPurifier_Config::createDefault();
			$config->set('AutoFormat.RemoveEmpty', true);
			$config->set('AutoFormat.RemoveSpansWithoutAttributes', true);
			$config->set('HTML.ForbiddenAttributes', array('*@style', '*@class'));
			$purifier = new HTMLPurifier($config);
			$this->request->data['Comment']['comment'] = $purifier->purify($this->request->data['Comment']['comment']);
			$this->request->data['Comment']['comment'] = String::truncate($this->request->data['Comment']['comment'], 750, array('ending' => '', 'exact' => false, 'html' => true));
			$this->Session->delete('Captcha.code');
			if ($this->Comment->save($this->request->data)) {
				$model = 'News';
				switch ($type) {
					case 'article':
						$model = 'Article';
						break;
					case 'user':
						$model = 'UserPublication';
						break;
					case 'post':
						$model = 'Post';
						break;
					case 'photo':
						$model = 'Photo';
						break;
					case 'video':
						$model = 'Video';
						break;
				}
				$this->loadModel($model);
				$this->{$model}->recountComments($id);
				$this->info('Спасибо. Ваш комментарий добавлен');
				$this->redirect($this->referer());
				return;
			}
			else {
				$this->error('Заполните все обязательные поля');
			}
		}
		$this->Comment->bindModel(
			array(
				'belongsTo' => array(
					'User'
				)
			),
			false
		);
		$this->paginate['limit'] = 10;
		$this->paginate['order'] = array(
			'Comment.date' => 'desc'
		);
		//$this->paginate['joins'] = array('FORCE INDEX(main_index)');
		$this->paginate['fields'] = array(
			'Comment.user_id',
			'Comment.date',
			'Comment.name',
			'Comment.comment',
			'User.firstname',
			'User.lastname'
		);
		$conditions = array(
			'Comment.publication_id' => $id,
			'Comment.is_active' => 1
		);
		$comments = $this->paginate('Comment', $conditions);
		$this->set('comments', $comments);
	}

	protected function _filter_params($filter_conditions = null) {
        $truck_cars = array('trucks','agricultural','special','loader');
        $usual_cars = array('cars','light_trucks');
        $auto_query = $this->request->query['auto'];
        $is_truck_cars = $auto_query == 'trucks' || $auto_query == 'agricultural' || $auto_query == 'special' || $auto_query == 'loader';
        $is_usual_cars = empty($auto_query) || $auto_query == 'cars' || $auto_query == 'light_trucks';

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
		//$tyre_size1 = Cache::read('tyre_size1', 'long');
		$conditions = array('Product.category_id' => 1, 'Product.is_active' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
		if (CONST_DISABLE_FILTERS == '0') {
			if ($filter_conditions) {
				$conditions = $filter_conditions;
			}
		}
		
		
		if (empty($tyre_size1)) {
			$temp_cond = $conditions;
			unset($temp_cond['Product.size1']);
//			echo"111111111";
			
			//*********** Вывод в фильтре кроме .... при выборе auto => все ... сортируем по типу авто
			if($is_usual_cars):
				$temp_cond['AND'] = array('Product.auto !=' => $truck_cars);
			endif;
            if($is_truck_cars):
                $temp_cond['AND'] = array('Product.auto !=' => $usual_cars);
                $temp_cond = array('Product.auto' => $auto_query);
            endif;
			//*********** Вывод в фильтре кроме .... при выборе auto => все ... сортируем по типу авто
			
			//print_r($temp_cond);
			$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.size1', 'order' => 'Product.size1'));
			
			$tyre_size1 = array();

			foreach ($products as $item) {
				$size = number_format(str_replace(',', '.', $item['Product']['size1']), 2, '.', '');
				$size = str_replace('.00', '', $size);
				$tyre_size1[$size] = $size;

			}
			natsort($tyre_size1);
			unset($tyre_size1[0]);
			
		//	print_r($tyre_size1);
			
			Cache::write('tyre_size1', $tyre_size1, 'long');
		}
		//$tyre_size2 = Cache::read('tyre_size2', 'long');
		if (empty($tyre_size2)) {
			$temp_cond = $conditions;
			unset($temp_cond['Product.size2']);

            //*********** Вывод в фильтре кроме .... при выборе auto => все ... сортируем по типу авто
            if($is_usual_cars):
                $temp_cond['AND'] = array('Product.auto !=' => $truck_cars);
            endif;
            if($is_truck_cars):
                $temp_cond['AND'] = array('Product.auto !=' => $usual_cars);
                $temp_cond = array('Product.auto' => $auto_query);
            endif;
            //*********** Вывод в фильтре кроме .... при выборе auto => все ... сортируем по типу авто

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
			Cache::write('tyre_size2', $tyre_size2, 'long');
		}
		
		//$tyre_size3 = Cache::read('tyre_size3', 'long');
		if (empty($tyre_size3)) {
			$temp_cond = $conditions;
			unset($temp_cond['Product.size3']);

            //*********** Вывод в фильтре кроме .... при выборе auto => все ... сортируем по типу авто
            if($is_usual_cars):
                $temp_cond['AND'] = array('Product.auto !=' => $truck_cars);
            endif;
            if($is_truck_cars):
                $temp_cond['AND'] = array('Product.auto !=' => $usual_cars);
                $temp_cond = array('Product.auto' => $auto_query);
            endif;
            //*********** Вывод в фильтре кроме .... при выборе auto => все ... сортируем по типу авто

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
			Cache::write('tyre_size3', $tyre_size3, 'long');
		}
		
		$tyre_axis = Cache::read('tyre_axis', 'long');
		
		if (empty($seasons)) {
			$temp_cond = $conditions;
			foreach ($temp_cond as $i => $cond) {
				if (is_array($cond) && isset($cond['or']) && isset($cond['or'][0]['BrandModel.season'])) {
					unset($temp_cond[$i]);
					break;
				}
			}
			$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT(IF(BrandModel.season IS NULL,Product.season,BrandModel.season)) AS season', 'order' => 'Product.season'));
			foreach ($products as $item) {
				$seasons[$item[0]['season']] = $this->Product->seasons[$item[0]['season']];
			}
		}
		if (empty($auto)) {
			
			$temp_cond = $conditions;
			foreach ($temp_cond as $i => $cond) {
				if (is_array($cond) && isset($cond['or']) && isset($cond['or'][0]['BrandModel.auto'])) {
					unset($temp_cond[$i]);
					break;
				}
			}
			
			$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT(IF(BrandModel.auto IS NULL,Product.auto,BrandModel.auto)) AS auto', 'order' => 'Product.auto'));
			$auto = array();
            $truck_auto = array();
            $light_auto = array();
			foreach ($products as $item) {
				if (isset($this->Product->auto[$item[0]['auto']])) {
					$auto[$item[0]['auto']] = $this->Product->auto[$item[0]['auto']];

                    if (in_array($item[0]['auto'], $truck_cars)) {
                        $truck_auto[$item[0]['auto']] = $this->Product->auto[$item[0]['auto']];
                    }
                    if (in_array($item[0]['auto'], $usual_cars)) {
                        $light_auto[$item[0]['auto']] = $this->Product->auto[$item[0]['auto']];
                    }
				}
			}

		}

		$tyre_axis = array();
		$temp_cond = $conditions;
		unset($temp_cond['Product.axis']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.axis', 'order' => 'Product.axis'));
		foreach ($products as $item) {
			$axis = trim($item['Product']['axis']);
			if (!empty($axis) && $axis != '') {
				$tyre_axis[$item['Product']['axis']] = $item['Product']['axis'];
			}
		}

		$temp_cond = $conditions;
		$temp_cond['Product.stud'] = 1;
		$stud = $this->Product->find('count', array('conditions' => $temp_cond));


		$temp_cond = $conditions;
		$temp_cond['Product.in_stock'] = 1;
		$in_stock = $this->Product->find('count', array('conditions' => $temp_cond));


		$temp_cond = $conditions;
		$temp_cond['Product.stock_count >= '] = 4;
		$in_stock4 = $this->Product->find('count', array('conditions' => $temp_cond));

		unset($conditions['Product.brand_id']);

        //*********** Вывод в фильтре кроме .... при выборе auto => все ... сортируем по типу авто
        if($is_usual_cars):
            $conditions['AND'] = array('Product.auto !=' => $truck_cars);
        endif;
        if($is_truck_cars):
            $conditions['AND'] = array('Product.auto !=' => $usual_cars);
            $conditions = array('Product.auto' => $auto_query);
        endif;
        //*********** Вывод в фильтре кроме .... при выборе auto => все ... сортируем по типу авто

		$brands = $this->Product->find('all', array(
			'fields' => array('Product.brand_id'),
			'conditions' => $conditions
		));
		$brand_ids = array();
		foreach ($brands as $brand) {
			if (!in_array($brand['Product']['brand_id'], $brand_ids)) {
				$brand_ids[] = $brand['Product']['brand_id'];
			}
		}
		$brand_conditions = array('Brand.category_id' => $this->category_id, 'Brand.is_active' => 1, 'Brand.active_products_count > 0');
		$brand_conditions['Brand.id'] = $brand_ids;
		$this->loadModel('Brand');
		$brands = $this->Brand->find('list', array('order' => array('Brand.title' => 'asc'), 'conditions' => $brand_conditions, 'fields' => array('Brand.id', 'Brand.title')));

        function mb_ucfirst($string, $encoding)
        {
            $firstChar = mb_substr($string, 0, 1, $encoding);
            $then = mb_substr($string, 1, null, $encoding);
            return mb_strtoupper($firstChar, $encoding) . $then;
        }

        foreach($brands as $index => $brand) {
            $brands[$index] = mb_ucfirst(mb_strtolower($brand, 'UTF-8'), 'UTF-8');
        }

//        $brands = array_map('strtolower', $yourArray);

		if ($this->request->is('ajax')) {
			$result = array(
				'size1' => $tyre_size1,
				'size2' => $tyre_size2,
				'size3' => $tyre_size3,
				'season' => $seasons,
				'auto' => $auto,
				'brand_id' => $brands,
				'stud' => $stud,
				'in_stock' => $in_stock,
				'in_stock4' => $in_stock4,
				'axis' => $tyre_axis
			);
			return $result;
		} else {
			$this->set('tyre_size1', $tyre_size1);
			$this->set('tyre_size2', $tyre_size2);
			$this->set('tyre_size3', $tyre_size3);
			$this->set('tyre_axis', $tyre_axis);
			$this->set('filter_seasons', $seasons);
			$this->set('filter_auto', $auto);
            $this->set('filter_truck_auto', $truck_auto);
            $this->set('filter_light_auto', $light_auto);
			$this->set('stud', $stud);
			$this->set('in_stock', $in_stock);
			$this->set('in_stock4', $in_stock4);
			$this->set('show_filter', 1);
			$this->set('filter_brands', $brands);
			$this->set('seasons', $this->Product->seasons);
			$this->set('auto', $this->Product->auto);

		}
	}
	protected function _filter_disc_params($filter_conditions = null) {
        $truck_cars = array('trucks','agricultural','special','loader','light_trucks');
        $usual_cars = array('cars');
        $auto_query = $this->request->query['auto'];
        $is_truck_cars = $auto_query == 'trucks' || $auto_query == 'agricultural' || $auto_query == 'special' || $auto_query == 'loader';
        $is_usual_cars = empty($auto_query) || $auto_query == 'cars' || $auto_query == 'light_trucks';

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
		//$disk_size1 = Cache::read('disk_size1', 'long');
		$conditions = array('Product.category_id' => 2, 'Product.is_active' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
		if (CONST_DISABLE_FILTERS == '0') {
			if ($filter_conditions) {
				$conditions = $filter_conditions;
			}
		}


		if (empty($disk_size1)) {
			$temp_cond = $conditions;
			unset($temp_cond['Product.size1']);


            //*********** Вывод в фильтре кроме .... при выборе auto => все ... сортируем по типу авто
            if($is_usual_cars):
                $temp_cond['OR'] = array('Product.auto !=' => $truck_cars, 'Product.auto' => NULL);
            endif;
            if($is_truck_cars):
                $temp_cond['AND'] = array('Product.auto !=' => $usual_cars);
                $temp_cond['Product.auto'] = $auto_query;
            endif;
            //*********** Вывод в фильтре кроме .... при выборе auto => все ... сортируем по типу авто
			
			$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.size1', 'order' => 'Product.size1'));

			$disk_size1 = array();
			foreach ($products as $item) {
				$size = intval($item['Product']['size1']);
				if ($size > 0) {
					$disk_size1[$size] = $size;
				}
			}
			natsort($disk_size1);
			//Cache::write('disk_size1', $disk_size1, 'long');
		}
		
		//$disk_size2 = Cache::read('disk_size2', 'long');
		if (empty($disk_size2)) {
			$temp_cond = $conditions;
			unset($temp_cond['Product.size2']);

            //*********** Вывод в фильтре кроме .... при выборе auto => все ... сортируем по типу авто
            if($is_usual_cars):
                $temp_cond['AND'] = array('Product.auto !=' => $truck_cars);
            endif;
            if($is_truck_cars):
                $temp_cond['AND'] = array('Product.auto !=' => $usual_cars);
                $temp_cond['Product.auto'] = $auto_query;
            endif;
            //*********** Вывод в фильтре кроме .... при выборе auto => все ... сортируем по типу авто

			$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.size2', 'order' => 'Product.size2'));
			$disk_size2 = array();
			foreach ($products as $item) {
				$size = str_replace(',', '.', $item['Product']['size2']);
				if (!empty($size) && $size != '') {
					$parts = explode('/', $size);
					if (count($parts) == 2) {
						$size = $parts[0];
					}
					$disk_size2[$size] = $size;
				}
			}
			natsort($disk_size2);
			//Cache::write('disk_size2', $disk_size2, 'long');
		}

		if (empty($disk_hub)) {
			$temp_cond = $conditions;
			unset($temp_cond['Product.hub']);

            //*********** Вывод в фильтре кроме .... при выборе auto => все ... сортируем по типу авто
            if($is_usual_cars):
                $temp_cond['AND'] = array('Product.auto !=' => $truck_cars);
            endif;
            if($is_truck_cars):
                $temp_cond['AND'] = array('Product.auto !=' => $usual_cars);
                $temp_cond['Product.auto'] = $auto_query;
            endif;
            //*********** Вывод в фильтре кроме .... при выборе auto => все ... сортируем по типу авто

			$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.hub', 'order' => 'Product.hub'));
			$disk_hub = array();
			foreach ($products as $item) {
				$hub = number_format(floatval(str_replace(',', '.', $item['Product']['hub'])), 1, '.', '');
				if (!empty($hub) && $hub != '') {
					$hub = str_replace('.0', '', $hub);
					$disk_hub[$hub] = $hub;
				}
			}
			natsort($disk_hub);
			unset($disk_hub[0]);

		}

        if (empty($disk_et)) {
            $temp_cond = $conditions;
            unset($temp_cond['Product.et']);

            //*********** Вывод в фильтре кроме .... при выборе auto => все ... сортируем по типу авто
            if($is_usual_cars):
                $temp_cond['AND'] = array('Product.auto !=' => $truck_cars);
            endif;
            if($is_truck_cars):
                $temp_cond['AND'] = array('Product.auto !=' => $usual_cars);
                $temp_cond['Product.auto'] = $auto_query;
            endif;
            //*********** Вывод в фильтре кроме .... при выборе auto => все ... сортируем по типу авто

            $products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.et', 'order' => 'Product.hub'));
            $disk_et = array();
            foreach ($products as $item) {
                $et = number_format(floatval(str_replace(',', '.', $item['Product']['et'])), 1, '.', '');
                if (!empty($et) && $et != '') {
                    $et = str_replace('.0', '', $et);
                    $disk_et[$et] = $et;
                }
            }
            natsort($disk_et);
            unset($disk_et[0]);

        }

		$temp_cond = $conditions;
		$temp_cond['Product.in_stock'] = 1;
		$in_stock = $this->Product->find('count', array('conditions' => $temp_cond));

		$temp_cond = $conditions;
		$temp_cond['Product.stock_count >= '] = 4;
		$in_stock4 = $this->Product->find('count', array('conditions' => $temp_cond));




		$materials = array();
		$temp_cond = $conditions;
		unset($temp_cond['BrandModel.material']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT BrandModel.material', 'order' => 'Product.material'));
		foreach ($products as $item) {
			$material = $item['BrandModel']['material'];
			if (!empty($material)) {
				$materials[$material] = __d('admin_disks', 'material_' . $material);
			}
		}

		unset($conditions['Product.brand_id']);
		$brands = $this->Product->find('all', array(
			'fields' => array('DISTINCT Product.brand_id'),
			'conditions' => $conditions,
			'recursive' => 1
		));
		$brand_ids = array();
		foreach ($brands as $item) {
			$brand_ids[] = $item['Product']['brand_id'];
		}
		$brand_ids = array_unique($brand_ids);
		$brand_conditions = array('Brand.category_id' => 2, 'Brand.is_active' => 1, 'Brand.active_products_count > 0');
		$brand_conditions['Brand.id'] = $brand_ids;
		$this->loadModel('Brand');
		$brands = $this->Brand->find('list', array('order' => array('Brand.title' => 'asc'), 'conditions' => $brand_conditions, 'fields' => array('Brand.id', 'Brand.title')));

//         GET AUTOS FOR FILTER
            $temp_cond = $conditions;
            foreach ($temp_cond as $i => $cond) {
                if (is_array($cond) && isset($cond['or']) && isset($cond['or'][0]['BrandModel.auto'])) {
                    unset($temp_cond[$i]);
                    break;
                }
            }

            $products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT(IF(BrandModel.auto IS NULL,Product.auto,BrandModel.auto)) AS auto', 'order' => 'Product.auto'));
            $auto = array();
            $truck_auto = array();
            $light_auto = array();
            foreach ($products as $item) {
                if (isset($this->Product->auto[$item[0]['auto']])) {
                    $auto[$item[0]['auto']] = $this->Product->auto[$item[0]['auto']];

                    if (in_array($item[0]['auto'], $truck_cars)) {
                        $truck_auto[$item[0]['auto']] = $this->Product->auto[$item[0]['auto']];
                    }
                    if (in_array($item[0]['auto'], $usual_cars)) {
                        $light_auto[$item[0]['auto']] = $this->Product->auto[$item[0]['auto']];
                    }
                }
            }
        //         GET AUTOS FOR FILTER

		if ($this->request->is('ajax')) {
			$result = array(
				'size1' => $disk_size1,
				'size2' => $disk_size2,
				'hub' => $disk_hub,
				'brand_id' => $brands,
				'in_stock' => $in_stock,
				'in_stock4' => $in_stock4,
				'material' => $materials
			);
			return $result;
		} else {
			
			$this->set('disk_size1', $disk_size1);
			$this->set('disk_size2', $disk_size2);
			$this->set('disk_hub', $disk_hub);
			$this->set('in_stock', $in_stock);
			$this->set('in_stock4', $in_stock4);
			$this->set('materials', $materials);
			$this->set('show_filter', 2);
			$this->set('filter_brands', $brands);
            $this->set('disk_et', $disk_et);
            $this->set('filter_truck_auto', $truck_auto);
		}
		
	}
	public function calculatePrice($price, $type = 'tyres') {
		$koef = floatval(CONST_TYRES_KOEF);
		if ($type == 'disks') {
			$koef = floatval(CONST_DISKS_KOEF);
		}
		elseif ($type == 'tubes') {
			$koef = floatval(CONST_TUBES_KOEF);
		}
		elseif ($type == 'akb') {
			$koef = floatval(CONST_AKB_KOEF);
		}
		elseif ($type == 'bolts') {
			$koef = floatval(CONST_BOLTS_KOEF);
		}
		return $price * $koef;
	}
	public function calculateCartPrice($price, $type = 'tyres') {
		$currencies = $this->currencies;
		$price = $this->calculatePrice($price, $type);
		$prices = array();
		foreach ($currencies as $item) {
			if ($item['Currency']['cart']) {
				$price = $this->_roundPrice($item['Currency'], $price);
				break;
			}
		}
		return $price;
	}
	private function _roundPrice($currency, $price, $calculate_rate = true) {
		if ($calculate_rate) {
			$rate_price = $currency['rate'] * $price;
		}
		else {
			$rate_price = $price;
		}
		if ($currency['round'] == 0) {
			$currency['round'] = 1;
		}
		if ($currency['round_down']) {
			$rate_price = floor($rate_price / $currency['round']) * $currency['round'];
		}
		else {
			$rate_price = ceil($rate_price / $currency['round']) * $currency['round'];
		}
		return number_format($rate_price, $currency['decimals'], ',', '');
	}
	public function getCartPrice($price, $type = 'tyres', $options = array()) {
		$currencies = $this->currencies;
		$options = array_merge(
			array(
				'delimiter' => ' / ',
				'after' => '',
				'before' => '',
				'between' => '&nbsp;'
			),
			$options
		);
		$replaces = array(
			array(
				'{after}', '{before}', '{between}', '{value}'
			),
			array(
				$options['after'], $options['before'], $options['between']
			)
		);
		$price = $this->calculatePrice($price, $type);
		$prices = array();
		foreach ($currencies as $item) {
			if ($item['Currency']['cart']) {
				$value = $this->_roundPrice($item['Currency'], $price);
				$value_replaces = $replaces;
				$value_replaces[1][] = $value;
				
				$prices[] = str_replace($value_replaces[0], $value_replaces[1], $item['Currency']['short_title']);
			}
		}
		return implode($options['delimiter'], $prices);
	}
	public function getStoragePrice($price, $options = array()) {
		$currencies = $this->currencies;
		$options = array_merge(
			array(
				'after' => '',
				'before' => '',
				'between' => '&nbsp;'
			),
			$options
		);
		$replaces = array(
			array(
				'{after}', '{before}', '{between}', '{value}'
			),
			array(
				$options['after'], $options['before'], $options['between']
			)
		);
		$price_str = array();
		foreach ($currencies as $item) {
			if ($item['Currency']['storage']) {
				$value = ceil($price);
				$value_replaces = $replaces;
				$value_replaces[1][] = $value;
				$price_str = str_replace($value_replaces[0], $value_replaces[1], $item['Currency']['short_title']);
			}
		}
		return $price_str;
	}
	public function getCartPriceOnly($price, $options = array()) {
		$currencies = $this->currencies;
		$options = array_merge(
			array(
				'delimiter' => ' / ',
				'after' => '',
				'before' => '',
				'between' => '&nbsp;'
			),
			$options
		);
		$replaces = array(
			array(
				'{after}', '{before}', '{between}', '{value}'
			),
			array(
				$options['after'], $options['before'], $options['between']
			)
		);
		$prices = array();
		foreach ($currencies as $item) {
			if ($item['Currency']['cart']) {
				$value = $this->_roundPrice($item['Currency'], $price, false);
				$value_replaces = $replaces;
				$value_replaces[1][] = $value;
				
				$prices[] = str_replace($value_replaces[0], $value_replaces[1], $item['Currency']['short_title']);
			}
		}
		return implode($options['delimiter'], $prices);
	}
	public function getCartCurrencyId() {
		$currencies = $this->currencies;
		foreach ($currencies as $item) {
			if ($item['Currency']['cart']) {
				return $item['Currency']['id'];
			}
		}
		return 1;
	}
	function setLastModels($model) {
		if (!empty($model['BrandModel']['category_id'])) {
			if (in_array($model['BrandModel']['category_id'], array(1, 2))) {
				$models = $this->Session->read('last_models');
				$add = true;
				if (!empty($models)) {
					foreach ($models as $last_model) {
						if ($model['BrandModel']['id'] == $last_model['BrandModel']['id']) {
							$add = false;
							break;
						}
					}
				}
				if ($add) {
					$model['BrandModel']['type'] = 'tyre';
					$models[] = $model;
					$this->Session->write('last_models', $models);
				}
			}
		}
	}
}