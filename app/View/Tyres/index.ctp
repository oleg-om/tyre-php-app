<?php
if (!isset($filter['in_stock4'])) {
    $filter['in_stock4'] = 0;
}
if (!isset($filter['in_stock'])) {
    $filter['in_stock'] = 0;
}
if (!isset($filter['auto'])) {
    $filter['auto'] = 0;
}
$url = array('controller' => 'tyres', 'action' => 'index', '?' => $filter);
if (!empty($brand['Brand']['slug'])) {
    $url = array('controller' => 'tyres', 'action' => 'brand', 'slug' => $brand['Brand']['slug'], '?' => $filter);
}
$this->Paginator->options(array('url' => $url));
?>
<?php if ($active_menu != 'truck-tyres') { ?>
<h1 class="title">Шины <?php if (!empty($brand['Brand']['slug']))
    echo $brand['Brand']['title'] ?>
    <?php if (!empty($car_brand['CarBrand']['slug']))
    echo ' на ' . $car_brand['CarBrand']['title'] . ' ' . $car_model['CarModel']['title'] . ' ' . $car_generation['CarGeneration']['title'] . ' ' . $car_modification['CarModification']['title'] ?>
</h1>
<?php } ?>
<?php if (empty($modification_slug) && $active_menu == 'tyres') { ?>
<a class="tyres-free-header" href="/tyres?auto=&axis=&size1=&season=&brand_id=&stud=0&in_stock4=0&in_stock=2&upr_all=1&p1=1">
<img src="/img/icons/free-tyremount.png" alt="При покупке 4 шин шиномонтаж бесплатно!" />При покупке 4 шин шиномонтаж бесплатно!
</a>
<?php } ?>

<?php if ($active_menu == 'truck-tyres') echo $this->element('truck_switch'); ?>


<?php echo $this->element('tyre_car', array('modification_slug' => $modification_slug, 'diameters' => $diameters, 'car_sizes' => $car_sizes, 'season' => $season, 'size3' => $size3, 'size1' => $size1, 'size2' => $size2, 'factory_sizes' => $factory_sizes, 'tuning_sizes' => $tuning_sizes))?>

<?php
$available_seasons = array();
foreach ($models as $item) {
    if ($mode == 'table' || count($item['Product']) == 1) {
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
    } else {
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
} else {
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
} else {
    echo $this->element('seo_tyres_cars');
}
?>
