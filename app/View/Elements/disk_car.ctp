<div class="<?php if (empty($modification_slug)) { echo 'd-none'; } else { echo 'car__sizes car__sizes-wheels'; } ?>">
    <div class="car__sizes__wrap">
        <div class="car__sizes__info">
            <div class="car__sizes__diameters">
                <?php
                $diameters = array();
                if (!empty($car_diameters) && is_array($car_diameters)) {
                    $diameters = $car_diameters;
                    sort($diameters);
                }
                if (is_array($diameters) && !empty($diameters)) {
                foreach ($diameters as $diameter) { ?>
                    <?php
                    $diameter_filter = array('modification' => $modification_slug, 'diameter' => $diameter, 'material' => $material);
                    $diameter_class = $diameter == 'R'.$size1 ? 'active-diameter' : '';

                    echo $this->Html->link($diameter, array('controller' => 'disks', 'action' => 'index', '?' => $diameter_filter), array('escape' => false, 'class' => $diameter_class));?>
                <?php }} ?>
            </div>
            <?php if (!empty($car_factory_sizes)) { ?>
                <div class="car__sizes__wrapper">
                    <div class="car__sizes__title">Заводская комплектация</div>
                    <ul class="car__sizes__list">
                        <?php
                        if (is_array($car_factory_sizes) && !empty($car_factory_sizes)) {
                        foreach ($car_factory_sizes as $size) {
                            $front_filter = $this->Frontend->getDiskParams($size, $material)['front'];
                            $back_filter = $this->Frontend->getDiskParams($size, $material)['back'];
                            ?>
                            <li>
                                    <span class="<?php if ($front_filter['is_active'] == 1) { echo 'is_active'; }?>">
                                        <?php if ($front_filter['is_active'] == 1 || $back_filter['is_active'] == 1) { echo '• '; }?><?php if ($size['CarWheels']['kit'] == 1) { echo 'Передние'; } else echo 'Диски'; ?> <?php echo $this->Html->link($size['CarWheels']['front_axle_title'], array('controller' => 'disks', 'action' => 'index', '?' => $front_filter), array('escape' => false));?>
                                    </span>
                                <?php if ($size['CarWheels']['kit'] == 1) { ?>, <span class="<?php if ($back_filter['is_active'] == 1) { echo 'is_active'; }?>">задние <?php echo $this->Html->link($size['CarWheels']['back_axle_title'], array('controller' => 'disks', 'action' => 'index', '?' => $back_filter), array('escape' => false));?></span><?php } ?>
                            </li>
                        <?php }} ?>
                    </ul>

                </div>
            <?php } ?>

            <?php if (!empty($car_tuning_sizes)) { ?>
                <div class="car__sizes__wrapper">
                    <div class="car__sizes__title">Тюнинг</div>
                    <ul class="car__sizes__list">
                        <?php
                        foreach ($car_tuning_sizes as $size) {
                            $front_filter = $this->Frontend->getDiskParams($size, $material)['front'];
                            $back_filter = $this->Frontend->getDiskParams($size, $material)['back']; ?>
                            <li>
                                    <span class="<?php if ($front_filter['is_active'] == 1) { echo 'is_active'; }?>">
                                        <?php if ($front_filter['is_active'] == 1 || $back_filter['is_active'] == 1) { echo '• '; }?><?php if ($size['CarWheels']['kit'] == 1) { echo 'Передние'; } else echo 'Диски'; ?> <?php echo $this->Html->link($size['CarWheels']['front_axle_title'], array('controller' => 'disks', 'action' => 'index', '?' => $front_filter), array('escape' => false));?>
                                    </span>
                                <?php if ($size['CarWheels']['kit'] == 1) { ?>, <span class="<?php if ($back_filter['is_active'] == 1) { echo 'is_active'; }?>">задние <?php echo $this->Html->link($size['CarWheels']['back_axle_title'], array('controller' => 'disks', 'action' => 'index', '?' => $back_filter), array('escape' => false));?></span><?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

            <?php } ?>
        </div>
        <div class="car__sizes-right">
            <?php
            $image = '';
            if (!empty($car_image)) {
                $image = $this->Html->image('car_generations/' . $car_image, array('alt' => $car_brand['CarBrand']['title']));
            }
            echo $image;
            ?>
            <button type="reset" class="filter-reset-car" id="filter-reset-car" onclick="resetDisks()">Сбросить авто<span>x</span>
                <script type="text/javascript">
                    function resetDisks() {
                        $.ajax({
                            url: '/api/remove_session/car_modification_slug',
                            success: function() {
                                window.location = '<?php echo CONST_DEFAULT_DISKS_PATH;?>';
                            }
                        });
                    }
                </script>
            </button>
        </div>
    </div>
</div>