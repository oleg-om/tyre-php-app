<?php
class OrdersController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'Order.created' => 'desc'
		)
	);
	public $filter_fields = array('Order.id' => 'int', 'Order.status_id' => 'int', 'Order.info' => 'text', 'Order.created_from' => 'from', 'Order.created_to' => 'to');
	public $model = 'Order';
	public $submenu = 'orders';
	public function _list() {
		$this->Order->virtualFields['info'] = 'CONCAT(Order.name, \' \', Order.phone, \' \', Order.email)';
		parent::_list();
		$this->loadModel('OrderStatus');
		$this->set('statuses', $this->OrderStatus->find('list', array('order' => array('OrderStatus.sort_order' => 'asc'))));
	}
	public function api(){
		
		$this->loadModel('Order');
		$products = $this->Order->find('all');
		$products = json_encode($products, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		print_r($products);
		exit;
	}
	public function admin_view($id) {
		$this->loadModel('Order');
		$this->Order->bindModel(
			array(
				'belongsTo' => array(
					'PaymentType' => array(
						'foreignKey' => 'payment_type_id'
					),
					'ShippingType' => array(
						'foreignKey' => 'shipping_type_id'
					),
					'ShippingMethod' => array(
						'foreignKey' => 'shipping_method_id'
					),
					'City',
					'Region',
					'Store'
				)	
			)
		);
		$this->loadModel('OrderStatus');
		$statuses = $this->OrderStatus->find('list', array('order' => array('OrderStatus.sort_order' => 'asc')));
		if ($order = $this->Order->find('first', array('conditions' => array('Order.id' => $id)))) {
			$product_ids = array();
			foreach ($order['OrderProduct'] as $item) {
				$product_ids[] = $item['product_id'];
			}
			$this->loadModel('Product');
			$this->Product->virtualFields['bolt'] = 'IF(Product.bolt_type=\'ring\',CONCAT(Product.size1,\'x\',Product.size2),CONCAT(Product.size1,\'x\',Product.size2,\'x\',Product.size3,\'x\',Product.f1,\' \',Product.color,\' \',Product.material))';
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
			$cart_products = array();
			$ordered_products = array();
			if ($products = $this->Product->find('all', array('conditions' => array('Product.id' => $product_ids)))) {
				foreach ($products as $item) {
					$cart_products[$item['Product']['id']] = $item;
				}
			}
			foreach ($order['OrderProduct'] as $item) {
				$product = $cart_products[$item['product_id']];
				$title = $product['Brand']['title'] . ' ' . $product['BrandModel']['title'];
				if ($product['Product']['category_id'] == 1) {
					$title .= ' ' . $product['Product']['size1'] . '/' . $product['Product']['size2'] . ' R' . $product['Product']['size3'];
					$url = array('controller' => 'tyres', 'action' => 'view', 'slug' => $product['Brand']['slug'], 'id' => $product['Product']['id']);
					$type = 'tyres';
				}
				elseif ($product['Product']['category_id'] == 2) {
					$title .= ' ' . $product['Product']['size2'] . ' R' . $product['Product']['size2'] . 'x' . $product['Product']['size3'];
					$url = array('controller' => 'disks', 'action' => 'view', 'slug' => $product['Brand']['slug'], 'id' => $product['Product']['id']);
					$type = 'disks';
				}
				elseif ($product['Product']['category_id'] == 3) {
					$title .= ' ' . $product['Product']['ah'] . 'ач ' . $product['Product']['f1'];
					$url = array('controller' => 'akb', 'action' => 'view', 'slug' => $product['Brand']['slug'], 'id' => $product['Product']['id']);
					$type = 'akb';
				}
				else {
					$title = $this->Product->bolt_types[$product['Product']['bolt_type']] . ' ' . $product['Product']['bolt'];
					$url = array('controller' => 'bolts', 'action' => 'view', 'id' => $product['Product']['id']);
					$type = 'bolts';
				}
				$ordered_products[] = '<li><a href="' . Router::url($url, true) . '">' . $title . '</a>, ' . $item['quantity'] . ' шт. — ' . $this->getCartPrice(ceil($product['Product']['price']) * $item['quantity'], $type) . '</li>';
			}
			if (!empty($this->request->data)) {
				$this->loadModel('OrderEvent');
				$this->request->data['OrderEvent']['order_id'] = $id;
				$this->request->data['OrderEvent']['id'] = null;
				$this->OrderEvent->create();
				if ($this->OrderEvent->save($this->request->data)) {
					$this->Order->id = $id;
					$this->Order->saveField('status_id', $this->request->data['OrderEvent']['status_id']);
					if ($this->request->data['OrderEvent']['status_id'] != $order['Order']['status_id'] && $this->request->data['OrderEvent']['status_id'] == 2) { // оплачен
						if (!empty($order['Order']['email'])) {
							$address = array();
							$shipping = $order['ShippingMethod']['title'];
							if ($order['Order']['shipping_method_id'] == 1) {
								if (!empty($order['Order']['region_id'])) {
									$address[] = $order['Region']['title'];
								}
								if (!empty($order['Order']['city_id'])) {
									$address[] = $order['City']['title'];
								}
								if (!empty($order['Order']['store_id'])) {
									$address[] = $order['Store']['title'];
								}
								$shipping .= ', ' . $order['ShippingType']['title'];
							}
							else {
								if (!empty($order['Order']['city'])) {
									$address[] = h($order['Order']['city']);
								}
								if (!empty($order['Order']['address'])) {
									$address[] = h($order['Order']['address']);
								}
							}
							$address_str = '';
							if (!empty($address)) {
								$address_str = implode(', ', $address);
							}
							$this->Sender->sendEmail(
								$order['Order']['email'],
								'order_paid',
								array(
									'order_id' => $id,
									'name' => $order['Order']['name'],
									'shipping' => $shipping,
									'payment' => $order['PaymentType']['title'],
									'address' => $address_str,
									'products' => '<ol>' . implode(' ', $ordered_products) . '</ol>',
								)
							);
						}
					}
					if ($this->request->data['OrderEvent']['send']) {
						if (!empty($order['Order']['email'])) {
							$this->Sender->sendEmail(
								$order['Order']['email'],
								'order_updated_status',
								array(
									'order_id' => $id,
									'name' => $order['Order']['name'],
									'status' => $statuses[$this->request->data['OrderEvent']['status_id']],
									'comment' => $this->request->data['OrderEvent']['comment']
								)
							);
						}
					}
					$this->info($this->t('message_status_changed'));
					$this->redirect($this->referer());
				}
				else {
					$this->error($this->t('error_change_status'));
				}
			}
			$this->set('products', $cart_products);
			$this->set('order', $order);
			$this->set('statuses', $statuses);
			$this->set('id', $id);
			$this->request->data['OrderEvent']['id'] = $id;
		}
		else {
			$this->response->statusCode(404);
			$this->response->send();
			$this->render(false);
			return;
		}
		$this->set('bolt_types', $this->Product->bolt_types);
		$this->set('statuses', $statuses);
		$this->set('section', $this->getSection($this->getSubmenu()));
		$this->set('submenu', $this->getSubmenu());
		$this->set('title_for_layout', $this->t('title_view', $id));
		$this->layout = 'admin';
		$this->render('admin_view');
	}
	public function checkout() {
		if ($this->Session->check('cart')) {
			$cart = $this->Session->read('cart');
		}
		else {
			$cart = array('items' => array(), 'total' => 0);
		}
		list($cart, $products) = $this->_get_cart_items($cart);
		$this->_filter_params();
		$this->loadModel('PaymentType');
		$this->loadModel('ShippingMethod');
		$this->loadModel('ShippingType');
		$this->loadModel('Region');
		$this->loadModel('City');
		$this->loadModel('Store');
		$shipping_types = $this->ShippingType->find('list', array('conditions' => array('ShippingType.is_active' => 1), 'order' => array('ShippingType.sort_order' => 'asc')));
		$payment_types = $this->PaymentType->find('list', array('conditions' => array('PaymentType.is_active' => 1), 'order' => array('PaymentType.sort_order' => 'asc')));
		$payment_type_info = $this->PaymentType->find('list', array('conditions' => array('PaymentType.is_active' => 1), 'order' => array('PaymentType.sort_order' => 'asc'), 'fields' => array('PaymentType.id', 'PaymentType.content')));
		$shipping_methods = $this->ShippingMethod->find('list', array('conditions' => array('ShippingMethod.is_active' => 1), 'order' => array('ShippingMethod.sort_order' => 'asc')));
		$shipping_method_id = key($shipping_methods);
		if (isset($this->request->data['Order']['shipping_method_id'])) {
			$shipping_method_id = intval($this->request->data['Order']['shipping_method_id']);
		}
		$shipping_type_id = key($shipping_types);
		if (isset($this->request->data['Order']['shipping_type_id'])) {
			$shipping_type_id = intval($this->request->data['Order']['shipping_type_id']);
		}
		$region_id = 0;
		if (isset($this->request->data['Order']['region_id'])) {
			$region_id = intval($this->request->data['Order']['region_id']);
		}
		$city_id = 0;
		if (isset($this->request->data['Order']['city_id'])) {
			$city_id = intval($this->request->data['Order']['city_id']);
		}
		$regions = $this->Region->find('list', array('order' => array('Region.title' => 'asc'), 'fields' => array('Region.id', 'Region.title'), 'conditions' => array('Region.is_active' => 1, 'Region.shipping_type_id' => $shipping_type_id)));
		$cities = $this->City->find('list', array('order' => array('City.title' => 'asc'), 'fields' => array('City.id', 'City.title'), 'conditions' => array('City.is_active' => 1, 'City.shipping_type_id' => $shipping_type_id, 'City.region_id' => $region_id)));
		$stores = $this->Store->find('list', array('order' => array('Store.title' => 'asc'), 'fields' => array('Store.id', 'Store.title'), 'conditions' => array('Store.is_active' => 1, 'Store.shipping_type_id' => $shipping_type_id, 'Store.region_id' => $region_id, 'Store.city_id' => $city_id)));
		if (!empty($cart['items'])) {
			if (!empty($this->request->data['Order'])) {
				$this->loadModel('Order');
				$this->request->data['Order']['status_id'] = 1;
				$this->request->data['Order']['currency_id'] = $this->getCartCurrencyId();
				$this->request->data['Order']['total'] = $cart['total'];
				$this->Order->create();
				if ($this->Order->save($this->request->data)) {
					$ordered_products = array();
					$order_id = $this->Order->id;
					$this->loadModel('OrderProduct');
					foreach ($cart['items'] as $product_id => $count) {
						$product = $products[$product_id];
						$title = $product['Brand']['title'] . ' ' . $product['BrandModel']['title'];
						if ($product['Product']['category_id'] == 1) {
							$title .= ' ' . $product['Product']['size1'] . '/' . $product['Product']['size2'] . ' R' . $product['Product']['size3'];
							$url = array('controller' => 'tyres', 'action' => 'view', 'slug' => $product['Brand']['slug'], 'id' => $product['Product']['id']);
							$type = 'tyres';
						}
						elseif ($product['Product']['category_id'] == 2) {
							$title .= ' ' . $product['Product']['size2'] . ' R' . $product['Product']['size2'] . 'x' . $product['Product']['size3'];
							$url = array('controller' => 'disks', 'action' => 'view', 'slug' => $product['Brand']['slug'], 'id' => $product['Product']['id']);
							$type = 'disks';
						}
						elseif ($product['Product']['category_id'] == 3) {
							$title .= ' ' . $product['Product']['ah'] . 'ач ' . $product['Product']['f1'];
							$url = array('controller' => 'akb', 'action' => 'view', 'slug' => $product['Brand']['slug'], 'id' => $product['Product']['id']);
							$type = 'akb';
						}
						else {
							$title = $this->Product->bolt_types[$product['Product']['bolt_type']] . ' ' . $product['Product']['bolt'];
							$url = array('controller' => 'bolts', 'action' => 'view', 'id' => $product['Product']['id']);
							$type = 'bolts';
						}
						$save_data = array(
							'product_id' => $product_id,
							'quantity' => $count,
							'price' => $this->calculateCartPrice($product['Product']['price'], $type),
							'order_id' => $order_id
						);
						$ordered_products[] = '<li><a href="' . Router::url($url, true) . '">' . $title . '</a>, ' . $count . ' шт. — ' . $this->getCartPrice($product['Product']['price'] * $count, $type) . '</li>' . "\n";
						$this->OrderProduct->create();
						$this->OrderProduct->save($save_data);
					}
					$this->loadModel('OrderEvent');
					$save_data = array(
						'status_id' => $this->request->data['Order']['status_id'],
						'order_id' => $order_id,
						'comment' => $this->request->data['Order']['comment']
					);
					$this->OrderEvent->save($save_data);
					$emails = explode(',', CONST_ORDER_EMAIL);
					$address = array();
					$shipping = $shipping_methods[$this->request->data['Order']['shipping_method_id']];
					if ($this->request->data['Order']['shipping_method_id'] == 1) {
						if (!empty($this->request->data['Order']['region_id'])) {
							$address[] = $regions[$this->request->data['Order']['region_id']];
						}
						if (!empty($this->request->data['Order']['city_id'])) {
							$address[] = $cities[$this->request->data['Order']['city_id']];
						}
						if (!empty($this->request->data['Order']['store_id'])) {
							$address[] = $stores[$this->request->data['Order']['store_id']];
						}
						$shipping .= ', ' . $shipping_types[$this->request->data['Order']['shipping_type_id']];
					}
					else {
						if (!empty($this->request->data['Order']['city'])) {
							$address[] = h($this->request->data['Order']['city']);
						}
						if (!empty($this->request->data['Order']['address'])) {
							$address[] = h($this->request->data['Order']['address']);
						}
					}
					$address_str = '';
					if (!empty($address)) {
						$address_str = implode(', ', $address);
					}
					foreach ($emails as $email) {
						$this->Sender->sendEmail(
							$email,
							'order_created_admin',
							array(
								'order_id' => $order_id,
								'total' => $this->getCartPriceOnly($cart['total']),
								'created' => date('d/m/y, H:i'),
								'name' => $this->request->data['Order']['name'],
								'email' => $this->request->data['Order']['email'],
								'phone' => $this->request->data['Order']['phone'],
								'comment' => $this->request->data['Order']['comment'],
								'shipping' => $shipping,
								'payment' => $payment_types[$this->request->data['Order']['payment_type_id']],
								'address' => $address_str,
								'products' => '<ol>' . implode(' ', $ordered_products) . '</ol>' . "\n"
							)
						);
					}
					if (!empty($this->request->data['Order']['email'])) {
						$pay_link = '';
						if ($this->request->data['Order']['payment_type_id'] == 2 || $this->request->data['Order']['payment_type_id'] == 3) {
							$pay_link = '<a href="' . Router::url(array('controller' => 'orders', 'action' => 'thank', '?' => array('order_id' => $order_id)), true) . '">перейти к оплате</a>';
						}
						$this->Sender->sendEmail(
							$this->request->data['Order']['email'],
							'order_created_user',
							array(
								'order_id' => $order_id,
								'total' => $this->getCartPriceOnly($cart['total']),
								'name' => $this->request->data['Order']['name'],
								'email' => $this->request->data['Order']['email'],
								'phone' => $this->request->data['Order']['phone'],
								'comment' => $this->request->data['Order']['comment'],
								'shipping' => $shipping,
								'payment' => $payment_types[$this->request->data['Order']['payment_type_id']],
								'address' => $address_str,
								'products' => '<ol>' . implode(' ', $ordered_products) . '</ol>' . "\n",
								'pay_link' => $pay_link . "\n"
							)
						);
					}
					$this->Session->write('cart', array());
					$query = array();
					if ($this->request->data['Order']['payment_type_id'] == 2 || $this->request->data['Order']['payment_type_id'] == 3) {
						$query = array('order_id' => $order_id);
					}
					$this->redirect(array('controller' => 'orders', 'action' => 'thank', '?' => $query));
				}
				else {
					debug($this->Order->validationErrors);
				}
			}
		}
		$this->set('regions', $regions);
		$this->set('cities', $cities);
		$this->set('stores', $stores);
		$this->set('shipping_types', $shipping_types);
		$this->set('payment_types', $payment_types);
		$this->set('payment_type_info', $payment_type_info);
		$this->set('shipping_methods', $shipping_methods);
		$this->set('cart', $cart);
		$this->set('products', $products);
		$breadcrumbs = array();
		$breadcrumbs[] = array(
			'url' => null,
			'title' => 'Оформление заказа'
		);
		
		$this->set('breadcrumbs', $breadcrumbs);
		$this->set('show_left_menu', false);
		$this->set('show_right_menu', false);
	}
	public function thank() {
		$this->_filter_params();
		if (isset($this->request->query['order_id'])) {
			$this->loadModel('Order');
			if ($order = $this->Order->find('first', array('conditions' => array('Order.id' => $this->request->query['order_id'], 'Order.payment_type_id' => array(2, 3), 'Order.status_id' => 1)))) {
				$this->set('order', $order);
			}
		}
		$breadcrumbs = array();
		$breadcrumbs[] = array(
			'url' => null,
			'title' => 'Оформление заказа'
		);
		$this->set('breadcrumbs', $breadcrumbs);
	}
	public function cart() {
		if ($this->Session->check('cart')) {
			$cart = $this->Session->read('cart');
		}
		else {
			$cart = array('items' => array(), 'total' => 0);
		}
		$this->loadModel('Product');
		if (!empty($this->request->data['Product'])) {
			foreach ($this->request->data['Product'] as $item) {
				if ($product = $this->Product->find('first', array('conditions' => array('Product.id' => $item['product_id'], 'Product.is_active' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0), 'fields' => array('Product.id', 'Product.stock_count', 'Product.count_out_of_stock')))) {
					$cart['items'][$product['Product']['id']] = min($item['count'], $product['Product']['stock_count'] + $product['Product']['count_out_of_stock']);
				}
			}
		}
		list($cart, $products) = $this->_get_cart_items($cart);
		$this->set('cart', $cart);
		$this->set('products', $products);
		$this->layout = 'empty';
	}
	private function _get_cart_items($cart) {
		$this->loadModel('Product');
		$this->Product->virtualFields['bolt'] = 'IF(Product.bolt_type=\'ring\',CONCAT(Product.size1,\'x\',Product.size2),CONCAT(Product.size1,\'x\',Product.size2,\'x\',Product.size3,\'x\',Product.f1,\' \',Product.color,\' \',Product.material))';
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
		$cart['total'] = 0;
		$products = array();
		$cart_items = array();
		if (isset($cart['items'])) {
			foreach ($cart['items'] as $product_id => $count) {
				if ($product = $this->Product->find('first', array('conditions' => array('Product.id' => $product_id, 'Product.is_active' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0)))) {
					if ($product['Product']['category_id'] == 1) {
						$type = 'tyres';
					}
					elseif ($product['Product']['category_id'] == 2) {
						$type = 'disks';
					}
					elseif ($product['Product']['category_id'] == 3) {
						$type = 'akb';
					}
					else {
						$type = 'bolts';
					}
					$cart_items[$product['Product']['id']] = min($count, $product['Product']['stock_count'] + $product['Product']['count_out_of_stock']);
					$products[$product['Product']['id']] = $product;
					$cart['total'] += $this->calculateCartPrice($product['Product']['price'] * $cart_items[$product['Product']['id']], $type);
				}
			}
		}
		$this->set('bolt_types', $this->Product->bolt_types);
		$cart['items'] = $cart_items;
		$this->Session->write('cart', $cart);
		return array($cart, $products);
	}
	public function delete_from_cart($id) {
		if ($this->Session->check('cart')) {
			$cart = $this->Session->read('cart');
		}
		else {
			$cart = array('items' => array(), 'total' => 0);
		}
		if (isset($cart['items'][$id])) {
			unset($cart['items'][$id]);
		}
		$this->_get_cart_items($cart);
		$this->layout = false;
		$this->render(false);
	}
	public function privat_response() {
		file_put_contents(TMP . 'privat.log', print_r($_POST, true));
		if (isset($_POST['orderid'])) {
			list(, $order_id, ) = explode('-', $_POST['orderid']);
			$this->loadModel('Order');
			$this->Order->bindModel(
				array(
					'belongsTo' => array(
						'PaymentType' => array(
							'foreignKey' => 'payment_type_id'
						),
						'ShippingMethod' => array(
							'foreignKey' => 'shipping_method_id'
						),
						'ShippingType' => array(
							'foreignKey' => 'shipping_type_id'
						),
						'City',
						'Region',
						'Store'
					)	
				)
			);
			if ($order = $this->Order->find('first', array('conditions' => array('Order.id' => $order_id, 'Order.payment_type_id' => array(2, 3), 'Order.status_id' => 1)))) {
				$Password = CONST_PRIVAT_PASSWORD;
				$MerID = $_POST['merid'];
				$AcqID = $_POST['acqid'];
				$OrderID = $_POST['orderid'];
				$responsecode = $_POST['responsecode'];
				$reasoncode = $_POST['reasoncode'];
				$reasoncodedesc = $_POST['reasoncodedesc'];
				$rectoken = '';
				if (isset($_POST['rectoken'])) {
					$rectoken = $_POST['rectoken'];
				}
				$str = $Password . $MerID . $AcqID . $OrderID . $responsecode . $reasoncode . $reasoncodedesc . $rectoken;
				$Signature = sha1($str);
				$Signature = hexbin($Signature);
				$Signature = base64_encode($Signature);
				file_put_contents(TMP . 'Signature.log', $Signature);
				if ($Signature == $_POST['signature'] && $_POST['responsecode'] === '1' && $_POST['reasoncode'] === '1') {
					$product_ids = array();
					foreach ($order['OrderProduct'] as $item) {
						$product_ids[] = $item['product_id'];
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
					$cart_products = array();
					$ordered_products = array();
					if ($products = $this->Product->find('all', array('conditions' => array('Product.id' => $product_ids)))) {
						foreach ($products as $item) {
							$cart_products[$item['Product']['id']] = $item;
						}
					}
					foreach ($order['OrderProduct'] as $item) {
						$product = $cart_products[$item['product_id']];
						$title = $product['Brand']['title'] . ' ' . $product['BrandModel']['title'];
						if ($product['Product']['category_id'] == 1) {
							$title .= ' ' . $product['Product']['size1'] . '/' . $product['Product']['size2'] . ' R' . $product['Product']['size3'];
							$url = array('controller' => 'tyres', 'action' => 'view', 'slug' => $product['Brand']['slug'], 'id' => $product['Product']['id']);
							$type = 'tyres';
						}
						elseif ($product['Product']['category_id'] == 2) {
							$title .= ' ' . $product['Product']['size2'] . ' R' . $product['Product']['size2'] . 'x' . $product['Product']['size3'];
							$url = array('controller' => 'disks', 'action' => 'view', 'slug' => $product['Brand']['slug'], 'id' => $product['Product']['id']);
							$type = 'disks';
						}
						else {
							$title .= ' ' . $product['Product']['ah'] . 'ач ' . $product['Product']['f1'];
							$url = array('controller' => 'akb', 'action' => 'view', 'slug' => $product['Brand']['slug'], 'id' => $product['Product']['id']);
							$type = 'akb';
						}
						$ordered_products[] = '<li><a href="' . Router::url($url, true) . '">' . $title . '</a>, ' . $item['quantity'] . ' шт. — ' . $this->getCartPrice($product['Product']['price'] * $item['quantity'], $type) . '</li>';
					}
					$this->loadModel('OrderEvent');
					$save_data = array(
						'status_id' => 2,
						'order_id' => $order['Order']['id'],
						'comment' => 'Оплата картой ' . $_POST['paddedcardno']
					);
					if ($this->OrderEvent->save($save_data)) {
						$this->Order->id = $order['Order']['id'];
						$this->Order->saveField('status_id', 2);
						if (!empty($order['Order']['email'])) {
							$address = array();
							$shipping = $order['ShippingMethod']['title'];
							if ($order['Order']['shipping_method_id'] == 1) {
								if (!empty($order['Order']['region_id'])) {
									$address[] = $order['Region']['title'];
								}
								if (!empty($order['Order']['city_id'])) {
									$address[] = $order['City']['title'];
								}
								if (!empty($order['Order']['store_id'])) {
									$address[] = $order['Store']['title'];
								}
								$shipping .= ', ' . $order['ShippingType']['title'];
							}
							else {
								if (!empty($order['Order']['city'])) {
									$address[] = h($order['Order']['city']);
								}
								if (!empty($order['Order']['address'])) {
									$address[] = h($order['Order']['address']);
								}
							}
							$address_str = '';
							if (!empty($address)) {
								$address_str = implode(', ', $address);
							}							
							$this->Sender->sendEmail(
								$order['Order']['email'],
								'order_paid',
								array(
									'order_id' => $order['Order']['id'],
									'name' => $order['Order']['name'],
									'shipping' => $shipping,
									'payment' => $order['PaymentType']['title'],
									'address' => $address_str,
									'products' => '<ol>' . implode(' ', $ordered_products) . '</ol>',
								)
							);
						}
					}
				}
			}
		}
		$this->redirect(array('controller' => 'pages', 'action' => 'home'));
	}
}