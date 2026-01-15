<h1 class="titlePage">Подбор для автомобиля <span class="title-cars"><?php if (!empty($car_brand['CarBrand']['slug'])) echo ' на '.$car_brand['CarBrand']['title'].' '.$car_model['CarModel']['title'].' '.$car_generation['CarGeneration']['title'].' '.$car_modification['CarModification']['title'] ?></span></h1>
<div class="selectionCarImg"><?php
$image = '';
if (!empty($car_image)) {
    $image = $this->Html->image('/files/car_generations/' . $car_image, array('alt' => $car_brand['CarBrand']['title']));
}
echo $image;
?></div>
<div class="tyresBox">
<h2 class="tyres">ШИНы</h2>

<?php if (!empty($factory_tyres) && isset($factory_tyres[0]) && $factory_tyres[0] !== "") { ?>
    <ul>
        <li>Заводская комплектация
            <ul>
                <?php foreach (array_unique($factory_tyres) as $tyre) {
                    $filter = $this->Frontend->getTyreParams($tyre, $modification_slug, FALSE, FALSE, FALSE); ?>
                    <li>Шины <?php echo $this->Html->link($tyre, array('controller' => 'tyres', 'action' => 'index', '?' => $filter), array('escape' => false));?></li>
                <?php } ?>
            </ul>
        </li>
    </ul>
<?php } ?>
<?php if (!empty($tuning_tyres) && isset($tuning_tyres[0]) && $tuning_tyres[0] !== "") { ?>
    <ul>
        <li>Тюнинг
            <ul>
                <?php foreach (array_unique($tuning_tyres) as $tyre) {
                    $filter = $this->Frontend->getTyreParams($tyre, $modification_slug, FALSE, FALSE, FALSE);?>
                    <li>Шины <?php echo $this->Html->link($tyre, array('controller' => 'tyres', 'action' => 'index', '?' => $filter), array('escape' => false));?></li>
                <?php } ?>
            </ul>
        </li>
    </ul>
<?php } ?>
</div>
            <div class="tyresBox">
            	<h2 class="disks">ДИСКИ</h2>

                <?php if (!empty($factory_wheels)) { ?>
                    <ul>
                        <li>Заводская комплектация
                            <ul>
                                <?php

                                foreach ($factory_wheels as $size) {
                                    $front_filter = $this->Frontend->getDiskParams($size, FALSE)['front'];
                                    $back_filter = $this->Frontend->getDiskParams($size, FALSE)['back'];
                                    ?>
                                    <li>
                                    <span class="<?php if ($front_filter['is_active'] == 1) { echo 'is_active'; }?>">
                                        <?php if ($front_filter['is_active'] == 1 || $back_filter['is_active'] == 1) { echo '• '; }?><?php if ($size['CarWheels']['kit'] == 1) { echo 'Передние'; } else echo 'Диски'; ?> <?php echo $this->Html->link($size['CarWheels']['front_axle_title'], array('controller' => 'disks', 'action' => 'index', '?' => $front_filter), array('escape' => false));?>
                                    </span>
                                        <?php if ($size['CarWheels']['kit'] == 1) { ?>, <span class="<?php if ($back_filter['is_active'] == 1) { echo 'is_active'; }?>">задние <?php echo $this->Html->link($size['CarWheels']['back_axle_title'], array('controller' => 'disks', 'action' => 'index', '?' => $back_filter), array('escape' => false));?></span><?php } ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                <?php } ?>
                <?php if (!empty($tuning_wheels)) { ?>
                    <ul>
                        <li>Тюнинг
                            <ul>
                                <?php
                                foreach ($tuning_wheels as $size) {
                                    $front_filter = $this->Frontend->getDiskParams($size, FALSE)['front'];
                                    $back_filter = $this->Frontend->getDiskParams($size, FALSE)['back']; ?>
                                    <li>
                                    <span class="<?php if ($front_filter['is_active'] == 1) { echo 'is_active'; }?>">
                                        <?php if ($front_filter['is_active'] == 1 || $back_filter['is_active'] == 1) { echo '• '; }?><?php if ($size['CarWheels']['kit'] == 1) { echo 'Передние'; } else echo 'Диски'; ?> <?php echo $this->Html->link($size['CarWheels']['front_axle_title'], array('controller' => 'disks', 'action' => 'index', '?' => $front_filter), array('escape' => false));?>
                                    </span>
                                        <?php if ($size['CarWheels']['kit'] == 1) { ?>, <span class="<?php if ($back_filter['is_active'] == 1) { echo 'is_active'; }?>">задние <?php echo $this->Html->link($size['CarWheels']['back_axle_title'], array('controller' => 'disks', 'action' => 'index', '?' => $back_filter), array('escape' => false));?></span><?php } ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                <?php } ?>

            </div>
            <div class="tyresBox akbBox">
            	<h2 class="akb">АКБ</h2>
                <?php if (!empty($factory_akb)) { ?>
                    <ul>
                        <li>Рекомендация автопроизводителя
                        <ul>
                            <?php
                            foreach ($factory_akb as $size) {
                                $filter = $this->Frontend->getAkbParams($size);
                                ?>
                                <li>
                                    <span class="<?php if ($filter['is_active'] == 1) { echo 'is_active'; }?>">
                                        <?php if ($filter['is_active'] == 1) { echo '• '; }?><?php echo $this->Html->link($size['CarBatteries']['capacity_min'].'-'.$size['CarBatteries']['capacity_max'].' Ач, '.$size['CarBatteries']['polarity'].' полярность, размер (ДхШхВ) '.$size['CarBatteries']['length_min'].'-'.$size['CarBatteries']['length_max'].'x'.$size['CarBatteries']['width_min'].'-'.$size['CarBatteries']['width_max'].'x'.$size['CarBatteries']['height_min'].'-'.$size['CarBatteries']['height_max'].' мм', array('controller' => 'akb', 'action' => 'index', '?' => $filter), array('escape' => false));?>
                                    </span>
                                </li>
                            <?php } ?>
                        </ul>
                        </li>
                    </ul>
                <?php } ?>
                <?php if (!empty($tuning_akb)) { ?>
                    <ul>
                        <li>Варианты замены
                        <ul>
                            <?php
                            foreach ($tuning_akb as $size) {
                                $filter = $this->Frontend->getAkbParams($size);
                                ?>
                                <li>
                                    <span class="<?php if ($filter['is_active'] == 1) { echo 'is_active'; }?>">
                                        <?php if ($filter['is_active'] == 1) { echo '• '; }?><?php echo $this->Html->link($size['CarBatteries']['capacity_min'].'-'.$size['CarBatteries']['capacity_max'].' Ач, '.$size['CarBatteries']['polarity'].' полярность, размер (ДхШхВ) '.$size['CarBatteries']['length_min'].'-'.$size['CarBatteries']['length_max'].'x'.$size['CarBatteries']['width_min'].'-'.$size['CarBatteries']['width_max'].'x'.$size['CarBatteries']['height_min'].'-'.$size['CarBatteries']['height_max'].' мм', array('controller' => 'akb', 'action' => 'index', '?' => $filter), array('escape' => false));?>
                                    </span>
                                </li>
                            <?php } ?>
                        </ul></li>
                    </ul>

                <?php } ?>
            </div>