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
<h1 class="title">Шины <?php if (!empty($brand['Brand']['slug'])) echo $brand['Brand']['title'] ?>
    <?php if (!empty($car_brand['CarBrand']['slug'])) echo ' на '.$car_brand['CarBrand']['title'].' '.$car_model['CarModel']['title'].' '.$car_generation['CarGeneration']['title'].' '.$car_modification['CarModification']['title'] ?>
</h1>

<?php if (empty($car_sizes['CarTyres']['factory_tyres'])) echo '<h3 class="tyres-free-header">При покупке 4 шин шиномонтаж бесплатно!</h3>'; ?>


<div class="<?php if (empty($modification_slug)) { echo 'd-none'; } else { echo 'car__sizes car__sizes-tyres'; } ?>">
        <div class="car__sizes__wrap">
    <div class="car__sizes__info">
        <div class="car__sizes__diameters">
        <?php
        $diameters = explode('|', $car_sizes['CarTyres']['diameters']);
        foreach ($diameters as $diameter) { ?>

            <?php
            $diameter_filter = array('modification' => $modification_slug, 'diameter' => $diameter);
            $diameter_class = $diameter == 'R'.$size3 ? 'active-diameter' : '';

            echo $this->Html->link($diameter, array('controller' => 'tyres', 'action' => 'index', '?' => $diameter_filter), array('escape' => false, 'class' => $diameter_class));?>
        <?php } ?>
        </div>

<?php if (!empty($factory_sizes)) { ?>
    <div class="car__sizes__wrapper">
        <div class="car__sizes__title">Заводская комплектация</div>
            <ul class="car__sizes__list">
                <?php
                foreach (array_unique($factory_sizes) as $tyre) {
                    $size_filter = $this->Frontend->getTyreParams($tyre, $car_sizes['CarTyres']['modification_slug'], $size1, $size2, $size3); ?>
                    <li id="<?php echo 'size-R'.$size_filter['size3']; ?>" class="<?php echo 'size-R'.$size_filter['size3']; ?> <?php if ($size_filter['is_active'] == 1) { echo 'is_active'; }?>"><?php if ($size_filter['is_active'] == 1) { echo '• '; }?>Шины <?php echo $this->Html->link($tyre, array('controller' => 'tyres', 'action' => 'index', '?' => $size_filter), array('escape' => false));?></li>
                <?php } ?>
            </ul>

    </div>
<?php } ?>

        <?php if (!empty($tuning_sizes)) { ?>
            <div class="car__sizes__wrapper">
                <div class="car__sizes__title">Тюнинг</div>
                <ul class="car__sizes__list">
                    <?php
                    foreach (array_unique($tuning_sizes) as $tyre) {
                        $size_filter = $this->Frontend->getTyreParams($tyre, $car_sizes['CarTyres']['modification_slug'], $size1, $size2, $size3); ?>
                        <li id="<?php echo 'size-R'.$size_filter['size3']; ?>" class="<?php echo 'size-R'.$size_filter['size3']; ?> <?php if ($size_filter['is_active'] == 1) { echo 'is_active'; }?>"><?php if ($size_filter['is_active'] == 1) { echo '• '; }?>Шины <?php echo $this->Html->link($tyre, array('controller' => 'tyres', 'action' => 'index', '?' => $size_filter), array('escape' => false));?></li>
                    <?php } ?>
                </ul>

            </div>
        <?php } ?>
  </div>
    <?php
    $image = '';
    if (!empty($car_image)) {
        $image = $this->Html->image('car_generations/' . $car_image, array('alt' => $car_brand['CarBrand']['title']));
    }
    echo $image;
    ?>
        </div>
</div>



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

//if ($has_params) {
//    echo '<h2 class="title">Бренды</h2>';
//    echo '<div class="selection">';
//
//    foreach ($brands as $i => $item) {
//        echo '<div class="item">';
//        $image = '';
//        if (!empty($item['Brand']['filename'])) {
//            $image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['Brand']['id'], 'filename' => $item['Brand']['filename'], 'path' => 'brands', 'width' => 160, 'height' => 60, 'crop' => false, 'folder' => false)), array('alt' => $item['Brand']['title']));
//        }
//        echo $this->Html->link('<span class="brand__image">' . $image . '</span><strong>' . $item['Brand']['title'] . '</strong>', array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug']), array('escape' => false, 'class' => 'img-brand', 'title' => $item['Brand']['title']));
//        echo '</div>';
//    }
//    echo '</div>';
//
//}

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