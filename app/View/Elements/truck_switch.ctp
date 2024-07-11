


<?php
$menu_items = array();
$menu_items[] = array('href' => '/tyres'.CONST_DEFAULT_TRUCK_TYRES_PATH, 'title' => 'Шины', 'img' => '/img/truck/tyre.png', 'alt' => 'Грузовые шины', 'active' => $active_menu === 'truck-tyres');
$menu_items[] = array('href' => '/disks', 'img' => '/img/truck/wheel.png', 'title' => 'Диски', 'alt' => 'Грузовые диски');
$menu_items[] = array('href' => '/tubes', 'img' => '/img/truck/tube.png', 'title' => 'Камеры', 'alt' => 'Грузовые камеры');
?>

<div class="truck-switch">
    <div class="truck-switch__items">
        <?php
        foreach ($menu_items as $i => $item) { ?>
            <a href="<?php echo $item['href']; ?>" class="truck-switch__item <?php if ($item['active']) echo 'active'; ?>">
                <img src="<?php echo $item['img']; ?>" alt="<?php echo $item['alt']; ?>" width="70px" height="70px"/>
                <span class="truck-switch__title"><?php echo $item['title']; ?></span>
            </a>
        <?php } ?>
    </div>
</div>