<?php
class UsedTyresController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'UsedTyre.created' => 'desc'
		)
	);
	public $filter_fields = array('UsedTyre.id' => 'int', 'UsedTyre.brand_id' => 'int', 'UsedTyre.model_id' => 'int', 'UsedTyre.sku' => 'text', 'UsedTyre.created_from' => 'from', 'UsedTyre.created_to' => 'to');
	public $model = 'UsedTyre';
	public $submenu = 'used_tyres';
	public $conditions = array();
	public function _list() {
		parent::_list();
		$this->loadModel('Brand');
		$this->loadModel('BrandModel');
		$this->set('brands', $this->Brand->find('list', array('fields' => array('Brand.id', 'Brand.title'), 'order' => array('Brand.title' => 'asc'), 'conditions' => array('Brand.category_id' => 1))));
		if (isset($this->request->data['UsedTyre']['brand_id'])) {
			$this->set('models', $this->BrandModel->find('list', array('fields' => array('BrandModel.id', 'BrandModel.title'), 'conditions' => array('BrandModel.brand_id' => $this->request->data['UsedTyre']['brand_id']), 'order' => array('BrandModel.title' => 'asc'))));
		}
		else {
			$this->set('models', array('' => __d('admin_common', 'list_all_items')));
		}
		$this->set('all_models', $this->BrandModel->find('list', array('fields' => array('BrandModel.id', 'BrandModel.title'), 'order' => array('BrandModel.title' => 'asc'), 'conditions' => array('BrandModel.category_id' => 1))));
	}
	public function _edit($id) {
		$id = intval($id);
		$this->loadModel($this->model);
		$this->{$this->model}->bindModel(
			array(
				'hasMany' => array(
					'UsedTyrePhoto' => array(
						'order' => array(
							'UsedTyrePhoto.id' => 'asc'
						)
					)
				)
			)
		);
		$this->{$this->model}->id = $id;
		$data = $this->{$this->model}->read();
		if (empty($this->request->data)) {
			if ($id != 0) {
				$this->request->data = $data;
			}
			else {
				$data['UsedTyrePhoto'] = array();
				$this->request->data[$this->model]['is_active'] = 1;
				$this->request->data[$this->model]['is_deletable'] = 1;
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
			if (isset($this->request->data['UsedTyre']['photo_ids']) && !empty($this->request->data['UsedTyre']['photo_ids'])) {
				$photo_ids = explode(',', $this->request->data['UsedTyre']['photo_ids']);
				$this->loadModel('UsedTyrePhoto');
				if ($photos = $this->UsedTyrePhoto->find('all', array('conditions' => array('UsedTyrePhoto.id' => $photo_ids)))) {
					foreach ($photos as $photo) {
						$data['UsedTyrePhoto'][] = $photo['UsedTyrePhoto'];
					}
				}
			}
			if (isset($data['UsedTyrePhoto'])) {
				$this->loadModel('UsedTyrePhoto');
				foreach ($data['UsedTyrePhoto'] as $i => $item) {
					if (!isset($this->request->data['UsedTyrePhoto']['file'][$item['id']])) {
						$this->UsedTyrePhoto->delete($item['id']);
						unset($data['UsedTyrePhoto'][$i]);
					}
				}
			}
			if ($this->{$this->model}->save($this->request->data)) {
				$used_tyre_id = $this->{$this->model}->id;
				$this->loadModel('UsedTyrePhoto');
				if (isset($data['UsedTyrePhoto'])) {
					foreach ($data['UsedTyrePhoto'] as $i => $item) {
						if (isset($this->request->data['UsedTyrePhoto']['file'][$item['id']])) {
							$save_data = array(
								'used_tyre_id' => $used_tyre_id,
								'file' => $this->request->data['UsedTyrePhoto']['file'][$item['id']]
							);
							$this->UsedTyrePhoto->id = $item['id'];
							$this->UsedTyrePhoto->tmp_file = null;
							$this->UsedTyrePhoto->save($save_data);
						}
					}
				}
				$this->{$this->model}->setDefaultPhoto($this->{$this->model}->id);
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
		$this->loadModel('Brand');
		$this->loadModel('BrandModel');
		$this->set('brands', $this->Brand->find('list', array('fields' => array('Brand.id', 'Brand.title'), 'order' => array('Brand.title' => 'asc'), 'conditions' => array('Brand.category_id' => 1))));
		if (isset($this->request->data['UsedTyre']['brand_id'])) {
			$this->set('models', $this->BrandModel->find('list', array('fields' => array('BrandModel.id', 'BrandModel.title'), 'conditions' => array('BrandModel.brand_id' => $this->request->data['UsedTyre']['brand_id']), 'order' => array('BrandModel.title' => 'asc'))));
		}
		else {
			$this->set('models', array('' => __d('admin_common', 'list_any_items')));
		}
		$this->set('seasons', $this->{$this->model}->seasons);
		$this->set('additional_js', array('swfupload/swfupload', 'swfupload/swfupload.queue', 'swfupload/fileprogress', 'swfupload/photo_handlers'));
		$this->set('additional_css', array('admin/swfupload'));
		$this->set('data', $data);
		return $title;
	}
	public function admin_apply() {
		$filter = $this->redirectFields($this->model, null);
		$this->loadModel($this->model);
		if (!empty($this->request->data) && isset($this->request->data[$this->model])) {
			foreach ($this->request->data[$this->model] as $id => $item) {
				if (isset($item['price'])) {
					$save_data = array(
						'price' => $item['price'],
						'count' => $item['count']
					);
					$this->{$this->model}->id = $id;
					$this->{$this->model}->save($save_data, false);
				}
			}
			$this->info($this->t('message_data_saved'));
		}
		$url = array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list');
		$url = array_merge($url, $filter);
		$this->redirect($url);
	}
	public function index() {
		$this->_filter_used_params();
		$this->UsedTyre->bindModel(
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
		$conditions = array('UsedTyre.is_active' => 1, 'UsedTyre.price > ' => 0);
		if (isset($this->request->query['size1']) && !empty($this->request->query['size1'])) {
			$conditions['UsedTyre.size1'] = $this->request->query['size1'];
		}
		if (isset($this->request->query['size2']) && !empty($this->request->query['size2'])) {
			$conditions['UsedTyre.size2'] = $this->request->query['size2'];
		}
		if (isset($this->request->query['size3']) && !empty($this->request->query['size3'])) {
			$conditions['UsedTyre.size3'] = $this->request->query['size3'];
		}
		$this->request->data['UsedTyre'] = $this->request->query;
		$this->set('filter', $this->request->query);
		$this->paginate['limit'] = 30;
		$this->paginate['order'] = array('UsedTyre.price' => 'asc');
		$used_tyres = $this->paginate('UsedTyre', $conditions);
		$this->set('used_tyres', $used_tyres);
		$title = 'Б/У шины';
		$breadcrumbs = array();
		$breadcrumbs[] = array(
			'url' => null,
			'title' => $title
		);
		$meta_title = 'Купить б/у шины Керчь, Феодосия, шинный центр Авто Дом';
		$meta_keywords = 'Купить, б/у шины, Керчь, Феодосия, шинный центр Авто Дом';
		$meta_description = 'Шинный центр Авто Дом предлагает купить б/у шины отличного качества в Керчи и Феодосии по самым лучшим ценам';
		$this->set('breadcrumbs', $breadcrumbs);
		$this->set('seasons', $this->UsedTyre->seasons);
		$this->setMeta('title', $meta_title);
		$this->setMeta('keywords', $meta_keywords);
		$this->setMeta('description', $meta_description);
		$this->set('additional_js', array('lightbox'));
		$this->set('additional_css', array('lightbox'));
	}
	public function view($id) {
		$this->_filter_used_params();
		$this->loadModel('UsedTyre');
		$this->UsedTyre->bindModel(
			array(
				'belongsTo' => array(
					'Brand',
					'BrandModel' => array(
						'foreignKey' => 'model_id'
					)
				),
				'hasMany' => array(
					'UsedTyrePhoto'
				)
			),
			false
		);
		if ($used_tyre = $this->UsedTyre->find('first', array('conditions' => array('UsedTyre.id' => $id, 'UsedTyre.is_active' => 1)))) {
			if (!empty($used_tyre['UsedTyre']['brand_id'])) {
				$brand = $used_tyre['Brand']['title'];
			}
			else {
				$brand = $used_tyre['UsedTyre']['brand'];
			}
			if (!empty($used_tyre['UsedTyre']['model_id'])) {
				$model = $used_tyre['BrandModel']['title'];
			}
			else {
				$model = $used_tyre['UsedTyre']['model'];
			}
			$this->set('seasons', $this->UsedTyre->seasons);
			$title = 'Б/У шины';
			$breadcrumbs = array();
			$breadcrumbs[] = array(
				'url' => array('controller' => 'used_tyres', 'action' => 'index'),
				'title' => $title
			);
			$breadcrumbs[] = array(
				'url' => null,
				'title' => $brand . ' ' . $model
			);
			$this->set('breadcrumbs', $breadcrumbs);
			$this->set('used_tyre', $used_tyre);
			$this->set('additional_js', array('lightbox'));
			$this->set('additional_css', array('lightbox'));
			$this->setMeta('title', $brand . ' ' . $model);
		}
		else {
			$this->response->statusCode(404);
			$this->response->send();
			$this->render(false);
			return;
		}
	}
	private function _filter_used_params() {
		$this->loadModel('UsedTyre');
		$tyre_size1 = Cache::read('used_tyre_size1', 'long');
		if (empty($tyre_size1)) {
			$used_tyres = $this->UsedTyre->query('SELECT DISTINCT(size1) FROM used_tyres WHERE is_active=1 ORDER BY size1');
			$tyre_size1 = array();
			foreach ($used_tyres as $item) {
				$size = number_format(str_replace(',', '.', $item['used_tyres']['size1']), 2, '.', '');
				$size = str_replace('.00', '', $size);
				$tyre_size1[$size] = $size;
			}
			natsort($tyre_size1);
			Cache::write('used_tyre_size1', $tyre_size1, 'long');
		}
		$this->set('used_tyre_size1', $tyre_size1);
		$tyre_size2 = Cache::read('used_tyre_size2', 'long');
		if (empty($tyre_size2)) {
			$used_tyres = $this->UsedTyre->query('SELECT DISTINCT(size2) FROM used_tyres WHERE is_active=1 ORDER BY size2');
			$tyre_size2 = array();
			foreach ($used_tyres as $item) {
				$size = number_format(str_replace(',', '.', $item['used_tyres']['size2']), 1, '.', '');
				if (!empty($size) && $size != '') {
					$size = str_replace('.0', '', $size);
					$tyre_size2[$size] = $size;
				}
			}
			natsort($tyre_size2);
			Cache::write('used_tyre_size2', $tyre_size2, 'long');
		}
		$this->set('used_tyre_size2', $tyre_size2);
		$tyre_size3 = Cache::read('used_tyre_size3', 'long');
		if (empty($tyre_size3)) {
			$used_tyres = $this->UsedTyre->query('SELECT DISTINCT(size3) FROM used_tyres WHERE is_active=1 ORDER BY size3');
			$tyre_size3 = array();
			foreach ($used_tyres as $item) {
				$size = trim($item['used_tyres']['size3']);
				if (!empty($size) && $size != '') {
					$tyre_size3[$size] = $size;
				}
			}
			natsort($tyre_size3);
			Cache::write('used_tyre_size3', $tyre_size3, 'long');
		}
		$this->set('used_tyre_size3', $tyre_size3);
		$this->set('show_filter', 5);
	}
	function upload() {
		$data = array(
			'success' => false
		);
		$used_tyre_id = isset($this->request->data['UsedTyre']['id']) ? $this->request->data['UsedTyre']['id'] : 0;
		if (isset($this->request->data['UsedTyrePhoto']['file']['tmp_name']) && $this->request->data['UsedTyrePhoto']['file']['tmp_name'] != '') {
			$this->loadModel('UsedTyrePhoto');
			$this->request->data['UsedTyrePhoto']['file']['type'] = 'image/jpeg';
			$save_data = array(
				'used_tyre_id' => $used_tyre_id,
				'file' => $this->request->data['UsedTyrePhoto']['file']
			);
			$this->UsedTyrePhoto->create();
			if ($this->UsedTyrePhoto->save($save_data)) {
				$data['success'] = true;
				$data['id'] = $this->UsedTyrePhoto->id;
				$data['filename'] = $this->UsedTyrePhoto->filename;
			}
			else {
				$data['error'] = 'Не удаётся скопировать файл';
			}
		}
		else {
			$data['error'] = 'Не удаётся загрузить файл';
		}
		$this->set('data', $data);
		$this->layout = 'empty';
	}
}