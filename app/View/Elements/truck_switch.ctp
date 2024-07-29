<?php
$menu_items = array();
$menu_items[] = array('href' => '/tyres'.CONST_DEFAULT_TRUCK_TYRES_PATH, 'title' => 'Шины', 'img' => '/img/truck/tyre.png', 'alt' => 'Грузовые шины', 'active' => $active_menu === 'truck-tyres');
//$menu_items[] = array('href' => '/disks', 'img' => '/img/truck/wheel.png', 'title' => 'Диски', 'alt' => 'Грузовые диски');
//$menu_items[] = array('href' => '/tubes', 'img' => '/img/truck/tube.png', 'title' => 'Камеры', 'alt' => 'Грузовые камеры');

$menu_types = array();
$menu_types['trucks'] = array('href' => '/tyres'.CONST_DEFAULT_TRUCK_TYRES_PATH, 'img' => '/img/truck/samosval.png', 'title' => 'Грузовые', 'alt' => 'Грузовые', 'value' => 'trucks', 'height' => '60px');
$menu_types['agricultural'] = array('href' => '/tyres?auto=agricultural&in_stock4=0&in_stock=2&upr_all=1', 'img' => '/img/truck/traktor.png', 'title' => 'Сельскохозяйственные', 'alt' => 'Сельскохозяйственные', 'value' => 'agricultural', 'height' => '80px');
$menu_types['loader'] = array('href' => '/tyres?auto=loader&in_stock4=0&in_stock=2&upr_all=1', 'img' => '/img/truck/loader.png', 'title' => 'Погрузчики', 'alt' => 'Погрузчики', 'value' => 'loader', 'height' => '75px');
$menu_types['special'] = array('href' => '/tyres?auto=special&in_stock4=0&in_stock=2&upr_all=1', 'img' => '/img/truck/carier.png', 'title' => 'Индустриальная', 'alt' => 'Индустриальная', 'value' => 'special', 'height' => '80px');

$order = array('trucks', 'agricultural', 'loader', 'special');

$filter_truck_auto_keys = array_keys($filter_truck_auto);
usort($filter_truck_auto_keys, function ($a, $b) use ($order) {
    $pos_a = array_search($a, $order);
    $pos_b = array_search($b, $order);
    return $pos_a - $pos_b;
});
?>

<div class="truck-switch">
    <div class="truck-switch__items" style="display: none;">
        <?php
        foreach ($menu_items as $i => $item) { ?>
            <a href="<?php echo $item['href']; ?>" class="truck-switch__item <?php if ($item['active']) echo 'active'; ?>">
                <img src="<?php echo $item['img']; ?>" alt="<?php echo $item['alt']; ?>" width="70px" height="70px"/>
                <span class="truck-switch__title"><?php echo $item['title']; ?></span>
            </a>
        <?php } ?>
    </div>
    <div class="truck-switch__types">
        <?php
        foreach ($filter_truck_auto_keys as $value) { ?>
            <a href="<?php echo $menu_types[$value]['href']; ?>" class="truck-switch__type <?php if ($menu_types[$value]['value'] === $this->request->query['auto']) echo 'active'; ?>">
                <img src="<?php echo $menu_types[$value]['img']; ?>" alt="<?php echo $menu_types[$value]['alt']; ?>" height="<?php echo $menu_types[$value]['height']; ?>"/>
                <span class="truck-switch__type-title"><?php echo $menu_types[$value]['title']; ?></span>
            </a>
        <?php } ?>
    </div>
</div>