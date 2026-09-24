<?php
App::uses('View', 'View');
/**
 * YML-фид товаров (Яндекс Маркет / Яндекс Товары): /yml.xml
 * Шины, диски и АКБ в наличии с ценой; цена и её показ — как на сайте (FrontendHelper).
 * id предложения строится из ЧПУ, а не из Product.id, который меняется при загрузке прайсов.
 * Готовый XML кешируется на час.
 */
class YmlController extends AppController {
	public $uses = array('Product', 'Brand', 'BrandModel');

	private $categories = array('tyres' => 1, 'disks' => 2, 'akb' => 3);

	public function index() {
		$key = 'yml_' . md5(Router::fullBaseUrl());
		$xml = Cache::read($key, 'very_long');
		if ($xml === false) {
			$xml = $this->_build();
			Cache::write($key, $xml, 'very_long');
		}
		$this->autoRender = false;
		$this->response->type('xml');
		$this->response->body($xml);
		return $this->response;
	}

	private function _build() {
		$view = new View($this);
		$frontend = $view->loadHelper('Frontend');

		$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
		$xml .= '<yml_catalog date="' . date('Y-m-d\TH:i:sP') . '">' . "\n<shop>\n";
		$xml .= $this->_tag('name', 'КерчьШИНА');
		$xml .= $this->_tag('company', 'КерчьШИНА');
		$xml .= $this->_tag('url', Router::url('/', true));
		$xml .= "<currencies><currency id=\"RUR\" rate=\"1\"/></currencies>\n<categories>\n";
		foreach ($this->categories as $type => $category_id) {
			$xml .= '<category id="' . $category_id . '">' . $this->_escape(ProductInfo::$categories[$type]) . "</category>\n";
		}
		$xml .= "</categories>\n<offers>\n";
		foreach ($this->categories as $type => $category_id) {
			$xml .= $this->_offers($type, $category_id, $frontend);
		}
		return $xml . "</offers>\n</shop>\n</yml_catalog>\n";
	}

	private function _offers($type, $category_id, $frontend) {
		$brands = $this->Brand->find('list', array(
			'conditions' => array('Brand.category_id' => $category_id, 'Brand.is_active' => 1),
			'fields' => array('Brand.id', 'Brand.title'),
			'recursive' => -1
		));
		$brand_slugs = $this->Brand->find('list', array(
			'conditions' => array('Brand.category_id' => $category_id, 'Brand.is_active' => 1),
			'fields' => array('Brand.id', 'Brand.slug'),
			'recursive' => -1
		));
		$models = Hash::combine($this->BrandModel->find('all', array(
			'conditions' => array('BrandModel.category_id' => $category_id, 'BrandModel.is_active' => 1),
			'fields' => array('BrandModel.id', 'BrandModel.title', 'BrandModel.season', 'BrandModel.filename', 'BrandModel.meta_description', 'BrandModel.content'),
			'recursive' => -1
		)), '{n}.BrandModel.id', '{n}.BrandModel');
		// по цене по возрастанию: из одинаковых товаров разных поставщиков в фид попадает самый дешёвый, как и на сайте
		$products = $this->Product->find('all', array(
			'conditions' => array('Product.category_id' => $category_id, 'Product.is_active' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0),
			'order' => array('Product.price' => 'asc'),
			'recursive' => -1
		));

		$xml = '';
		$seen = array();
		foreach ($products as $product) {
			$item = $product['Product'];
			if (!isset($brands[$item['brand_id']], $models[$item['model_id']]) || !$frontend->canShowPrice($type, $item)) {
				continue;
			}
			$product['BrandModel'] = $models[$item['model_id']];
			$url = Router::url(ProductUrl::url($type, $item, $brand_slugs[$item['brand_id']], $product['BrandModel']['title']), true);
			if (isset($seen[$url])) {
				continue;
			}
			$seen[$url] = true;

			$xml .= '<offer id="' . substr(md5(parse_url($url, PHP_URL_PATH)), 0, 20) . '" available="' . ($item['in_stock'] ? 'true' : 'false') . '">' . "\n";
			$xml .= $this->_tag('url', $url);
			$xml .= $this->_tag('price', $frontend->cartPriceNumber($item['price'], $type));
			$xml .= $this->_tag('currencyId', 'RUR');
			$xml .= $this->_tag('categoryId', $category_id);
			if ($picture = $this->_picture($type, $product)) {
				$xml .= $this->_tag('picture', $picture);
			}
			$xml .= $this->_tag('pickup', 'true');
			$xml .= $this->_tag('name', ProductInfo::name($type, $product, $brands[$item['brand_id']]));
			$xml .= $this->_tag('vendor', $brands[$item['brand_id']]);
			$description = ProductInfo::description($product, 3000);
			if ($description !== '') {
				$xml .= $this->_tag('description', $description);
			}
			foreach (ProductInfo::properties($type, $product) as $name => $value) {
				$xml .= '<param name="' . $this->_escape($name) . '">' . $this->_escape($value) . "</param>\n";
			}
			$xml .= "</offer>\n";
		}
		return $xml;
	}

	/**
	 * Оригинал картинки (без водяного знака — Маркет их не принимает), только если файл есть на диске
	 */
	private function _picture($type, $product) {
		$path = null;
		if ($type == 'akb' && !empty($product['Product']['filename'])) {
			$path = 'files/akb/akb_images/' . $product['Product']['filename'];
		} elseif (!empty($product['BrandModel']['filename'])) {
			$path = 'files/models/' . $product['BrandModel']['id'] . '/' . $product['BrandModel']['filename'];
		}
		if ($path === null || !is_file(WWW_ROOT . $path)) {
			return null;
		}
		return Router::url('/' . $path, true);
	}

	private function _tag($name, $value) {
		return '<' . $name . '>' . $this->_escape($value) . '</' . $name . ">\n";
	}

	private function _escape($value) {
		// убираем управляющие символы, недопустимые в XML
		$value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', (string)$value);
		return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
	}
}
