<div class="<?php if (empty($modification_slug)) { echo 'd-none'; } else { echo 'car__sizes car__sizes-wheels'; } ?>">
    <div class="car__sizes__wrap">
        <div class="car__sizes__info">
            <?php if (!empty($start_stop) && $start_stop == 1) { ?>
                <div class="car__sizes__extra__text">
                    <?php echo 'На ваш автомобиль предусмотрена установка аккумуляторов с технологией Start-Stop' ;?>
                </div>
            <?php } ?>

            <?php if (!empty($car_factory_sizes)) { ?>
                <div class="car__sizes__wrapper">
                    <div class="car__sizes__title">Рекомендация автопроизводителя</div>
                    <ul class="car__sizes__list">
                        <?php
                        foreach ($car_factory_sizes as $size) {
                            $filter = $this->Frontend->getAkbParams($size);
                            ?>
                            <li>
                                    <span class="<?php if ($filter['is_active'] == 1) { echo 'is_active'; }?>">
                                        <?php if ($filter['is_active'] == 1) { echo '• '; }?><?php echo $this->Html->link($size['CarBatteries']['capacity_min'].'-'.$size['CarBatteries']['capacity_max'].' Ач, '.$size['CarBatteries']['polarity'].' полярность, '.$size['CarBatteries']['type_case'].', размер (ДхШхВ) '.$size['CarBatteries']['length_min'].'-'.$size['CarBatteries']['length_max'].'x'.$size['CarBatteries']['width_min'].'-'.$size['CarBatteries']['width_max'].'x'.$size['CarBatteries']['height_min'].'-'.$size['CarBatteries']['height_max'].' мм', array('controller' => 'akb', 'action' => 'index', '?' => $filter), array('escape' => false));?>
                                    </span>
                            </li>
                        <?php } ?>
                    </ul>

                </div>
            <?php } ?>

            <?php if (!empty($car_tuning_sizes)) { ?>
                <div class="car__sizes__wrapper">
                    <div class="car__sizes__title">Варианты замены</div>
                    <ul class="car__sizes__list">
                        <?php
                        foreach ($car_tuning_sizes as $size) {
                            $filter = $this->Frontend->getAkbParams($size);
                            ?>
                            <li>
                                    <span class="<?php if ($filter['is_active'] == 1) { echo 'is_active'; }?>">
                                        <?php if ($filter['is_active'] == 1) { echo '• '; }?><?php echo $this->Html->link($size['CarBatteries']['capacity_min'].'-'.$size['CarBatteries']['capacity_max'].' Ач, '.$size['CarBatteries']['polarity'].' полярность, '.$size['CarBatteries']['type_case'].', размер (ДхШхВ) '.$size['CarBatteries']['length_min'].'-'.$size['CarBatteries']['length_max'].'x'.$size['CarBatteries']['width_min'].'-'.$size['CarBatteries']['width_max'].'x'.$size['CarBatteries']['height_min'].'-'.$size['CarBatteries']['height_max'].' мм', array('controller' => 'akb', 'action' => 'index', '?' => $filter), array('escape' => false));?>
                                    </span>
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
                $image = $this->Html->image('/files/car_generations/' . $car_image, array('alt' => $car_brand['CarBrand']['title']));
            }
            echo $image;
            ?>
            <button type="reset" class="filter-reset-car" id="filter-reset-car" onclick="resetAkb()">Сбросить авто<span>x</span>
                <script type="text/javascript">
                    function resetAkb() {
                        $.ajax({
                            url: '/api/remove_session/car_modification_slug',
                            success: function() {
                                window.location = '<?php echo CONST_DEFAULT_AKB_PATH;?>';
                            }
                        });
                    }
                </script>
            </button>
        </div>
    </div>
</div>