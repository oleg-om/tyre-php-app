<?php
if (!isset($filter['in_stock4'])) {
	$filter['in_stock4'] = 0;
}
if (!isset($filter['in_stock'])) {
	$filter['in_stock'] = 0;
}
if (!isset ($filter['auto'])) {
	$filter['auto'] = 0;
}
$url = array('controller' => 'tyres', 'action' => 'index', '?' => $filter);
if (!empty($brand['Brand']['slug'])) { 
	$url = array('controller' => 'tyres', 'action' => 'brand', 'slug' => $brand['Brand']['slug'], '?' => $filter);
}
$this->Paginator->options(array('url' => $url));
?>
<h2 class="title">Шины</h2>
<h3 class="tyres-free-header">При покупке 4 шин шиномонтаж бесплатно!</h3>
<?php
$available_seasons = array();
foreach ($models as $item) {
	if ($mode == 'table' || count($item['Product']) == 1 ) {
		if ($mode == 'table') {
			$item['Product'][0] = $item['Product'];
		}
		$season = $item['Product'][0]['season'];
		if (!empty($item['BrandModel']['season'])) {
			$season = $item['BrandModel']['season'];
		}
		if (!in_array($season, $available_seasons)) {
			$available_seasons[] = $season;
		}
	}
	else {
		foreach ($item['Product'] as $product) {
			$season = $product['season'];
			if (!empty($item['BrandModel']['season'])) {
				$season = $item['BrandModel']['season'];
			}
			if (!in_array($season, $available_seasons)) {
				$available_seasons[] = $season;
			}
		}
	}
}
if (!empty($brand['Brand']['slug']) && !$has_params) {
	echo $this->element('mode_selector', array('url' => $url, 'tyres_switch' => true, 'popular_sort' => true, 'available_seasons' => $available_seasons));
}
else {
	echo $this->element('mode_selector', array('url' => $url, 'popular_sort' => true, 'available_seasons' => $available_seasons));
}
?>
<div class="clear"></div>
<?php
echo $this->element('index_tyres');
$params = array('show_limits' => true, 'url' => $url, 'bottom' => true);
if (!$has_params) {
	$params = array('bottom' => true);
}
echo $this->element('pager', $params);
if (!empty($brand['Brand']['h1_title'])) { 
	echo '<h1>' . h($brand['Brand']['h1_title']) . '</h1>';
	echo $brand['Brand']['content'];
}
if ($filter['auto'] == 'trucks') {
	echo $this->element('seo_tyres_trucks');
}
else {
	echo $this->element('seo_tyres_cars');
}
?>