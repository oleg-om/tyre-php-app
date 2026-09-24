<?php
/**
 * Динамический sitemap: /sitemap.xml — индекс, /sitemap-{раздел}.xml — ссылки раздела.
 * Наследуется от Controller, а не AppController, чтобы не тянуть меню, корзину, авторизацию и т.п.
 * Готовый XML кешируется на час (товары пересоздаются при загрузке прайсов).
 */
class SitemapController extends Controller {
	public $uses = array();

	// раздел => category_id
	private $categories = array('tyres' => 1, 'disks' => 2, 'akb' => 3);

	public function index() {
		$xml = $this->_cached('index', function () {
			$items = array();
			foreach (array_merge(array('pages'), array_keys($this->categories)) as $section) {
				$items[] = array('loc' => Router::url(array('controller' => 'sitemap', 'action' => 'section', 'section' => $section), true));
			}
			return $this->_xml('sitemapindex', 'sitemap', $items);
		});
		return $this->_send($xml);
	}

	public function section($section) {
		if ($section !== 'pages' && !isset($this->categories[$section])) {
			throw new NotFoundException();
		}
		$xml = $this->_cached($section, function () use ($section) {
			$urls = $section === 'pages' ? $this->_pageUrls() : array_fill_keys($this->_categoryUrls($section), null);
			$items = array();
			foreach ($urls as $url => $lastmod) {
				$items[] = array('loc' => Router::url($url, true), 'lastmod' => $lastmod);
			}
			return $this->_xml('urlset', 'url', $items);
		});
		return $this->_send($xml);
	}

	/**
	 * Главная, разделы каталога, текстовые страницы и сервисные центры: ссылка => lastmod.
	 * Дата изменения есть только у текстовых страниц (Page.modified); у товаров её нет — они пересоздаются при загрузке прайсов.
	 */
	private function _pageUrls() {
		$urls = array_fill_keys(array('/', '/tyres', '/disks', '/akb', '/selection', '/calculator'), null);

		$Page = ClassRegistry::init('Page');
		$own_routes = array('home' => '/', 'sales' => '/sales', 'delivery' => '/delivery');
		foreach ($Page->find('all', array('conditions' => array('Page.is_active' => 1), 'fields' => array('Page.slug', 'Page.modified'), 'recursive' => -1)) as $page) {
			$slug = $page['Page']['slug'];
			// главная и акции показывают не только текст страницы — дата изменения текста для них не подходит
			$lastmod = !in_array($slug, array('home', 'sales')) && strtotime($page['Page']['modified']) > 0 ? date('c', strtotime($page['Page']['modified'])) : null;
			$urls[isset($own_routes[$slug]) ? $own_routes[$slug] : '/page-' . $slug] = $lastmod;
		}

		$Station = ClassRegistry::init('Station');
		$conditions = $Station->hasField('is_active') ? array('Station.is_active' => 1) : array();
		foreach ($Station->find('list', array('conditions' => $conditions, 'fields' => array('Station.id', 'Station.slug'))) as $slug) {
			$urls['/stations/' . $slug] = null;
		}
		return $urls;
	}

	/**
	 * Бренды, модели и товары раздела — только те, у которых есть товар в наличии с ценой
	 */
	private function _categoryUrls($controller) {
		$category_id = $this->categories[$controller];
		$Product = ClassRegistry::init('Product');
		$products = $Product->find('all', array(
			'conditions' => array('Product.category_id' => $category_id, 'Product.is_active' => 1, 'Product.price > ' => 0, 'Product.stock_count > ' => 0),
			'order' => array('Product.brand_id' => 'asc', 'Product.model_id' => 'asc', 'Product.price' => 'asc'),
			'recursive' => -1
		));
		$brands = ClassRegistry::init('Brand')->find('list', array(
			'conditions' => array('Brand.category_id' => $category_id, 'Brand.is_active' => 1),
			'fields' => array('Brand.id', 'Brand.slug')
		));
		$models = ClassRegistry::init('BrandModel')->find('list', array(
			'conditions' => array('BrandModel.category_id' => $category_id, 'BrandModel.is_active' => 1),
			'fields' => array('BrandModel.id', 'BrandModel.title')
		));
		// при SHOW_DISKS_IMG страница бренда дисков принимает model_id только у моделей с картинкой, иначе показывает бренд
		$model_pages = $models;
		if ($controller == 'disks') {
			$settings = ClassRegistry::init('Setting')->get();
			if (isset($settings['SHOW_DISKS_IMG']) && $settings['SHOW_DISKS_IMG'] == 1) {
				$model_pages = ClassRegistry::init('BrandModel')->find('list', array(
					'conditions' => array('BrandModel.category_id' => $category_id, 'BrandModel.is_active' => 1, 'BrandModel.filename !=' => ''),
					'fields' => array('BrandModel.id', 'BrandModel.id')
				));
			}
		}

		$urls = array();
		foreach ($products as $product) {
			$product = $product['Product'];
			if (!isset($brands[$product['brand_id']], $models[$product['model_id']])) {
				continue;
			}
			$brand_slug = $brands[$product['brand_id']];
			$brand_url = '/' . $controller . '/' . $brand_slug;
			$urls[$brand_url] = $brand_url;
			if (isset($model_pages[$product['model_id']])) {
				$model_url = $brand_url . '?model_id=' . $product['model_id'];
				$urls[$model_url] = $model_url;
			}
			// одинаковые товары разных поставщиков дают одну и ту же ссылку
			$product_url = Router::url(ProductUrl::url($controller, $product, $brand_slug, $models[$product['model_id']]));
			$urls[$product_url] = $product_url;
		}
		return array_values($urls);
	}

	private function _xml($root, $tag, $items) {
		$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
		$xml .= '<' . $root . ' xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
		foreach ($items as $item) {
			$xml .= '<' . $tag . '><loc>' . htmlspecialchars($item['loc'], ENT_XML1, 'UTF-8') . '</loc>';
			if (!empty($item['lastmod'])) {
				$xml .= '<lastmod>' . $item['lastmod'] . '</lastmod>';
			}
			$xml .= '</' . $tag . '>' . "\n";
		}
		return $xml . '</' . $root . '>' . "\n";
	}

	private function _cached($key, $build) {
		// ключ зависит от домена: ссылки в sitemap абсолютные
		$key = 'sitemap_' . md5(Router::fullBaseUrl()) . '_' . $key;
		$xml = Cache::read($key, 'very_long');
		if ($xml === false) {
			$xml = $build();
			Cache::write($key, $xml, 'very_long');
		}
		return $xml;
	}

	private function _send($xml) {
		$this->autoRender = false;
		$this->response->type('xml');
		$this->response->body($xml);
		return $this->response;
	}
}
