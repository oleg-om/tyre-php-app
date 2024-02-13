<?php
if (!isset($filter['in_stock4'])) {
	$filter['in_stock4'] = 0;
}
if (!isset($filter['in_stock'])) {
	$filter['in_stock'] = 0;
}
$url = array('controller' => 'disks', 'action' => 'index', '?' => $filter);
if (!empty($brand['Brand']['slug'])) {
	$url = array('controller' => 'disks', 'action' => 'brand', 'slug' => $brand['Brand']['slug'], '?' => $filter);
}
$this->Paginator->options(array('url' => $url));
?>
<h2 class="title">Диски <?php if (!empty($brand['Brand']['slug'])) echo $brand['Brand']['title'] ?>
    <?php if (!empty($car_brand['CarBrand']['slug'])) echo ' на '.$car_brand['CarBrand']['title'].' '.$car_model['CarModel']['title'].' '.$car_generation['CarGeneration']['title'].' '.$car_modification['CarModification']['title'] ?></h2>

    <div class="<?php if (empty($modification_slug)) { echo 'd-none'; } else { echo 'car__sizes car__sizes-wheels'; } ?>">
        <div class="car__sizes__wrap">
            <div class="car__sizes__info">
                <?php if (!empty($car_factory_sizes)) { ?>
                    <div class="car__sizes__wrapper">
                        <div class="car__sizes__title">Заводская комплектация</div>
                        <ul class="car__sizes__list">
                            <?php
                            foreach ($car_factory_sizes as $size) {
                                $front_filter = $this->Frontend->getDiskParams($size)['front'];
                                $back_filter = $this->Frontend->getDiskParams($size)['back']; ?>
                                <li>
                                    <span class="<?php if ($front_filter['is_active'] == 1) { echo 'is_active'; }?>">
                                        <?php if ($front_filter['is_active'] == 1 || $back_filter['is_active'] == 1) { echo '• '; }?><?php if ($size['CarWheels']['kit'] == 1) { echo 'Передние'; } else echo 'Диски'; ?> <?php echo $this->Html->link($size['CarWheels']['front_axle_title'], array('controller' => 'disks', 'action' => 'index', '?' => $front_filter), array('escape' => false));?>
                                    </span>
                                    <?php if ($size['CarWheels']['kit'] == 1) { ?>, <span class="<?php if ($back_filter['back_is_active'] == 1) { echo 'is_active'; }?>">задние <?php echo $this->Html->link($size['CarWheels']['back_axle_title'], array('controller' => 'disks', 'action' => 'index', '?' => $back_filter), array('escape' => false));?></span><?php } ?>
                                </li>
                            <?php } ?>
                        </ul>

                    </div>
                <?php } ?>

                <?php if (!empty($car_tuning_sizes)) { ?>
                    <div class="car__sizes__wrapper">
                        <div class="car__sizes__title">Тюнинг</div>
                        <ul class="car__sizes__list">
                            <?php
                            foreach ($car_tuning_sizes as $size) {
                                $front_filter = $this->Frontend->getDiskParams($size)['front'];
                                $back_filter = $this->Frontend->getDiskParams($size)['back']; ?>
                                <li>
                                    <span class="<?php if ($front_filter['is_active'] == 1) { echo 'is_active'; }?>">
                                        <?php if ($front_filter['is_active'] == 1 || $back_filter['is_active'] == 1) { echo '• '; }?><?php if ($size['CarWheels']['kit'] == 1) { echo 'Передние'; } else echo 'Диски'; ?> <?php echo $this->Html->link($size['CarWheels']['front_axle_title'], array('controller' => 'disks', 'action' => 'index', '?' => $front_filter), array('escape' => false));?>
                                    </span>
                                    <?php if ($size['CarWheels']['kit'] == 1) { ?>, <span class="<?php if ($back_filter['back_is_active'] == 1) { echo 'is_active'; }?>">задние <?php echo $this->Html->link($size['CarWheels']['back_axle_title'], array('controller' => 'disks', 'action' => 'index', '?' => $back_filter), array('escape' => false));?></span><?php } ?>
                                </li>
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
echo $this->element('currency');
echo $this->element('mode_selector', array('url' => $url));
?>
<div class="clear"></div>
<?php
echo $this->element('index_disks');
echo $this->element('pager', array('show_limits' => true, 'url' => $url, 'bottom' => true));
if (!empty($brand['Brand']['h1_title'])) { 
	echo '<h1>' . h($brand['Brand']['h1_title']) . '</h1>';
	echo $brand['Brand']['content'];
}
echo $this->element('seo_disks');
?>