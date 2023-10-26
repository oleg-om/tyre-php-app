<?php
class BoltsController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'Product.bolt' => 'asc'
		)
	);
	public $filter_fields = array('Product.id' => 'int', 'Product.bolt' => 'text', 'Product.bolt_type' => 'text');
	public $model = 'Product';
	public $submenu = 'products';
	public $conditions = array('Product.category_id' => 5);
	public function _list() {
		$this->loadModel('Product');
		$this->Product->virtualFields['bolt'] = 'IF(Product.bolt_type=\'ring\',CONCAT(Product.size1,\'x\',Product.size2),IF(Product.bolt_type=\'valve\',Product.sku,CONCAT(Product.size1,\'x\',Product.size2,\'x\',Product.size3,\'x\',Product.f1,\' \',Product.color,\' \',Product.material)))';
		parent::_list();
		$this->set('bolt_types', $this->Product->bolt_types);
	}
	public function _edit($id) {
		$this->loadModel('Product');
		$this->Product->virtualFields['bolt'] = 'IF(Product.bolt_type=\'ring\',CONCAT(Product.size1,\'x\',Product.size2),IF(Product.bolt_type=\'valve\',Product.sku,CONCAT(Product.size1,\'x\',Product.size2,\'x\',Product.size3,\'x\',Product.f1,\' \',Product.color,\' \',Product.material)))';
		$title = parent::_edit($id);
		$this->set('bolt_types', $this->Product->bolt_types);
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
						'stock_count' => $item['stock_count']
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
	public function admin_stockon($id = 0) {
		$this->_stock($id, 1);
	}
	public function admin_stockoff($id = 0) {
		$this->_stock($id, 0);
	}
	private function _stock($id, $state) {
		Configure::write('debug', 2);
		$this->layout = 'switcher';
		$this->set('id', $id);
		$this->set('url', '/admin/' . Inflector::underscore($this->name) . '/');
		$this->set('icon', 'stock');
		$this->set('url_enabled', 'stockon');
		$this->set('url_disabled', 'stockoff');
		$this->set('title_enabled', $this->t('title_stockon'));
		$this->set('title_disabled', $this->t('title_stockoff'));
		$this->set('prefix', 'stock');
		$this->loadModel($this->model);
		$this->{$this->model}->id = $id;
		if ($this->{$this->model}->saveField('in_stock', $state, false)) {
			$this->set('status', $state);
		}
		else {
			$this->set('status', abs($state - 1));
		}
		$this->render(false);
	}
	public function admin_clear() {
		$this->loadModel($this->model);
		$this->{$this->model}->deleteAll($this->conditions, true, true);
		$this->info($this->t('message_data_cleared'));
		$url = array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list');
		$this->redirect($url);
	}
	public function index() {
		/*
		$this->loadModel('Product');
		$types = array('ring', 'bolt', 'nut', 'valve');
		$nut_colors = array('открытая', 'закрытая');
		$bolt_colors = array('сфера', 'конус');
		$materials = array('хромированный', 'оцинкованный');
		for ($i = 0; $i < 100; $i ++) {
			$type = $types[mt_rand(0, 3)];
			$save_data = array(
				'category_id' => 5,
				'is_active' => 1,
				'bolt_type' => $type,
				'price' => mt_rand(1, 999),
				'stock_count' => mt_rand(1, 999)
			);
			if ($type == 'ring') {
				$size1 = mt_rand(10, 999) / 10;
				$size2 = mt_rand(intval($size1) * 10, 999) / 10;
				$save_data['size1'] = number_format($size1, 1, '.', '');
				$save_data['size2'] = number_format($size2, 1, '.', '');
			}
			elseif ($type == 'valve') {
				$save_data['sku'] = $bolt_colors[mt_rand(0, 1)];
			}
			else {
				$size2 = mt_rand(1, 99) / 10;
				$save_data['size1'] = mt_rand(4, 50);
				$save_data['size2'] = number_format($size2, 1, '.', '');
				$save_data['size3'] = ceil(mt_rand(10, 99) / 10) * 10;
				$save_data['f1'] = ceil(mt_rand(10, 99) / 10) * 10;
				$save_data['material'] = $materials[mt_rand(0, 1)];
				if ($type == 'bolt') {
					$save_data['color'] = $bolt_colors[mt_rand(0, 1)];
				}
				else {
					$save_data['color'] = $nut_colors[mt_rand(0, 1)];
				}
			}
			$this->Product->create();
			$this->Product->save($save_data);
		}
		exit();
		*/
		$this->category_id = 5;
		$conditions = array('Product.is_active' => 1, 'Product.category_id' => 5, 'Product.price > ' => 0, 'Product.stock_count > ' => 0);
		if (CONST_DISABLE_FILTERS == '0') {
			$filter_conditions = $this->get_conditions($conditions);
		}
		else {
			$filter_conditions = $conditions;
		}
		$this->_filter_bolts_params($filter_conditions);
		if (isset($this->request->query['bolt_type']) && !empty($this->request->query['bolt_type'])) {
			$conditions['Product.bolt_type'] = $this->request->query['bolt_type'];
		}
		if (isset($this->request->query['size1']) && !empty($this->request->query['size1'])) {
			$conditions['Product.size1'] = $this->request->query['size1'];
		}
		if (isset($this->request->query['size2']) && !empty($this->request->query['size2'])) {
			$conditions['Product.size2'] = $this->request->query['size2'];
		}
		if (isset($this->request->query['size3']) && !empty($this->request->query['size3'])) {
			$conditions['Product.size3'] = $this->request->query['size3'];
		}
		if (isset($this->request->query['f1']) && !empty($this->request->query['f1'])) {
			$conditions['Product.f1'] = $this->request->query['f1'];
		}
		if (isset($this->request->query['color']) && !empty($this->request->query['color'])) {
			$conditions['Product.color'] = $this->request->query['color'];
		}
		if (isset($this->request->query['sku']) && !empty($this->request->query['sku'])) {
			$conditions['Product.sku'] = $this->request->query['sku'];
		}
		if (isset($this->request->query['material']) && !empty($this->request->query['material'])) {
			$conditions['Product.material'] = $this->request->query['material'];
		}
		$this->request->data['Product'] = $this->request->query;
		$this->set('filter', $this->request->query);
		$this->paginate['limit'] = 100;
		$this->paginate['order'] = array('Product.price' => 'asc');
		$products = $this->paginate('Product', $conditions);
		$this->set('products', $products);
		$breadcrumbs = array();
		$breadcrumbs[] = array(
			'url' => null,
			'title' => 'Крепеж'
		);
		$meta_title = 'Крепеж';
		$meta_keywords = 'Купить, болты и гайки, Керчь, Феодосия, Шинный центр Авто Дом';
		$meta_description = 'Шинный центр Авто Дом предлагает купить болты и гайки в Керчи и Феодосии по лучшим ценам, у нас бесплатная доставка и сервисное обслуживание.';
		$this->set('breadcrumbs', $breadcrumbs);
		$this->setMeta('title', $meta_title);
		$this->setMeta('keywords', $meta_keywords);
		$this->setMeta('description', $meta_description);
		$this->set('additional_js', array('lightbox'));
		$this->set('additional_css', array('lightbox'));
		$this->set('active_menu', 'bolts');
	}
	public function view($id) {
		$this->loadModel('Product');
		$this->Product->virtualFields['bolt'] = 'IF(Product.bolt_type=\'ring\',CONCAT(Product.size1,\'x\',Product.size2),IF(Product.bolt_type=\'valve\',Product.sku,CONCAT(Product.size1,\'x\',Product.size2,\'x\',Product.size3,\'x\',Product.f1,\' \',Product.color,\' \',Product.material)))';
		if ($product = $this->Product->find('first', array('conditions' => array('Product.id' => $id, 'Product.category_id' => 5, 'Product.is_active' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0)))) {
			$this->request->data['Product']['bolt_type'] = $product['Product']['bolt_type'];
			$this->category_id = 5;
			$conditions = array('Product.is_active' => 1, 'Product.category_id' => 5, 'Product.price > ' => 0, 'Product.stock_count > ' => 0, 'Product.bolt_type' => $product['Product']['bolt_type']);
			$this->_filter_bolts_params($conditions);

			$title = 'Крепеж';
			$breadcrumbs = array();
			$breadcrumbs[] = array(
				'url' => array('controller' => 'bolts', 'action' => 'index'),
				'title' => $title
			);
			$breadcrumbs[] = array(
				'url' => null,
				'title' => $this->Product->bolt_types[$product['Product']['bolt_type']] . ' ' . $product['Product']['bolt']
			);
			$this->set('breadcrumbs', $breadcrumbs);
			$this->setMeta('title', $this->Product->bolt_types[$product['Product']['bolt_type']] . ' ' . $product['Product']['bolt']);
			$this->set('product', $product);
			$this->set('additional_js', array('lightbox'));
			$this->set('additional_css', array('lightbox'));
		}
		else {
			$this->response->statusCode(404);
			$this->response->send();
			$this->render(false);
			return;
		}
	}
	public function set_filter() {
		$conditions = array(
			'Product.is_active' => 1,
			'Product.category_id' => 5,
			'Product.price > ' => 0,
			'Product.stock_count > ' => 0
		);
		if (CONST_DISABLE_FILTERS == '0') {
			$conditions = $this->get_conditions($conditions);
		}
		$result = $this->_filter_bolts_params($conditions);
		echo json_encode($result);
		$this->layout = false;
		$this->render(false);
	}
	private function get_conditions($conditions) {
		if (isset($this->request->query['bolt_type']) && !empty($this->request->query['bolt_type'])) {
			$conditions['Product.bolt_type'] = $this->request->query['bolt_type'];
		}
		if (isset($this->request->query['size1']) && !empty($this->request->query['size1'])) {
			$conditions['Product.size1'] = $this->request->query['size1'];
		}
		if (isset($this->request->query['size2']) && !empty($this->request->query['size2'])) {
			$conditions['Product.size2'] = $this->request->query['size2'];
		}
		if (isset($this->request->query['size3']) && !empty($this->request->query['size3'])) {
			$conditions['Product.size3'] = $this->request->query['size3'];
		}
		if (isset($this->request->query['f1']) && !empty($this->request->query['f1'])) {
			$conditions['Product.f1'] = $this->request->query['f1'];
		}
		if (isset($this->request->query['color']) && !empty($this->request->query['color'])) {
			$conditions['Product.color'] = $this->request->query['color'];
		}
		if (isset($this->request->query['sku']) && !empty($this->request->query['sku'])) {
			$conditions['Product.sku'] = $this->request->query['sku'];
		}
		if (isset($this->request->query['material']) && !empty($this->request->query['material'])) {
			$conditions['Product.material'] = $this->request->query['material'];
		}
		return $conditions;
	}
	private function _filter_bolts_params($conditions = array()) {
		$this->loadModel('Product');
		$this->Product->virtualFields['bolt'] = 'IF(Product.bolt_type=\'ring\',CONCAT(Product.size1,\'x\',Product.size2),IF(Product.bolt_type=\'valve\',Product.sku,CONCAT(Product.size1,\'x\',Product.size2,\'x\',Product.size3,\'x\',Product.f1,\' \',Product.color,\' \',Product.material)))';
		$temp_cond = $conditions;
		unset($temp_cond['Product.size1']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.size1', 'order' => 'Product.size1'));
		$bolts_size1 = array();
		foreach ($products as $item) {
			$size = number_format(floatval(str_replace(',', '.', $item['Product']['size1'])), 1, '.', '');
			if (!empty($size) && $size != '') {
				$size = str_replace('.0', '', $size);
				$bolts_size1[$size] = $size;
			}
		}
		natsort($bolts_size1);
		//unset($bolts_size1[0]);

		$temp_cond = $conditions;
		unset($temp_cond['Product.size2']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.size2', 'order' => 'Product.size2'));
		$bolts_size2 = array();
		foreach ($products as $item) {
			$size = number_format(floatval(str_replace(',', '.', $item['Product']['size2'])), 2, '.', '');
			if (!empty($size) && $size != '') {
				$size = str_replace('.00', '', $size);
				$size = preg_replace('/\.([1-9])0/', '.$1', $size);
				$bolts_size2[$size] = $size;
			}
		}
		asort($bolts_size2, SORT_NUMERIC);

		$temp_cond = $conditions;
		unset($temp_cond['Product.size3']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.size3', 'order' => 'Product.size3'));
		$bolts_size3 = array();
		foreach ($products as $item) {
			$size = number_format(floatval(str_replace(',', '.', $item['Product']['size3'])), 1, '.', '');
			if (!empty($size) && $size != '') {
				$size = str_replace('.0', '', $size);
				$bolts_size3[$size] = $size;
			}
		}
		natsort($bolts_size3);

		$temp_cond = $conditions;
		unset($temp_cond['Product.f1']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.f1', 'order' => 'Product.f1'));
		$bolts_f1 = array();
		foreach ($products as $item) {
			$size = number_format(floatval(str_replace(',', '.', $item['Product']['f1'])), 1, '.', '');
			if (!empty($size) && $size != '') {
				$size = str_replace('.0', '', $size);
				$bolts_f1[$size] = $size;
			}
		}
		natsort($bolts_f1);


		$bolts_color = array();
		$temp_cond = $conditions;
		unset($temp_cond['Product.color']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.color', 'order' => 'Product.color'));
		foreach ($products as $item) {
			$color = trim($item['Product']['color']);
			if (!empty($color) && $color != '') {
				$bolts_color[$item['Product']['color']] = $item['Product']['color'];
			}
		}

		$bolts_sku = array();
		$temp_cond = $conditions;
		unset($temp_cond['Product.sku']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.sku', 'order' => 'Product.sku'));
		foreach ($products as $item) {
			$sku = trim($item['Product']['sku']);
			if (!empty($sku) && $sku != '') {
				$bolts_sku[$item['Product']['sku']] = $item['Product']['sku'];
			}
		}


		$bolts_material = array();
		$temp_cond = $conditions;
		unset($temp_cond['Product.material']);
		$products = $this->Product->find('all', array('conditions' => $temp_cond, 'fields' => 'DISTINCT Product.material', 'order' => 'Product.material'));
		foreach ($products as $item) {
			$material = trim($item['Product']['material']);
			if (!empty($material) && $material != '') {
				$bolts_material[$item['Product']['material']] = $item['Product']['material'];
			}
		}

		$temp_cond = $conditions;
		$temp_cond['Product.in_stock'] = 1;
		$in_stock = $this->Product->find('count', array('conditions' => $temp_cond));

		if ($this->request->is('ajax')) {
			$result = array(
				'size1' => $bolts_size1,
				'size2' => $bolts_size2,
				'size3' => $bolts_size3,
				'sku' => $bolts_sku,
				'f1' => $bolts_f1,
				'color' => $bolts_color,
				'material' => $bolts_material,
				'bolt_type' => $this->Product->bolt_types,
				'in_stock' => $in_stock
			);
			return $result;
		}
		else {
			$this->set('bolts_size1', $bolts_size1);
			$this->set('bolts_size2', $bolts_size2);
			$this->set('bolts_size3', $bolts_size3);
			$this->set('bolts_sku', $bolts_sku);
			$this->set('bolts_f1', $bolts_f1);
			$this->set('bolts_color', $bolts_color);
			$this->set('bolts_material', $bolts_material);
			$this->set('bolt_types', $this->Product->bolt_types);
			$this->set('in_stock', $in_stock);
			$this->set('show_filter', 7);
		}
	}
}