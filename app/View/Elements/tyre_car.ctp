<div class="<?php if (empty($modification_slug)) {
    echo 'd-none';
} else {
    echo 'car__sizes car__sizes-tyres';
} ?>">
    <div class="car__sizes__wrap">
        <div class="car__sizes__info">
            <div class="car__sizes__diameters">
                <?php
                $diameters = explode('|', $car_sizes['CarTyres']['diameters']);
                foreach ($diameters as $diameter) { ?>
                    <?php
                    $diameter_filter = array('modification' => $modification_slug, 'diameter' => $diameter, 'season' => $season, 'in_stock' => $this->request->query['in_stock']);
                    $diameter_class = $diameter == 'R' . $size3 ? 'active-diameter' : '';

                    echo $this->Html->link($diameter, array('controller' => 'tyres', 'action' => 'index', '?' => $diameter_filter), array('escape' => false, 'class' => $diameter_class)); ?>
                <?php } ?>
            </div>

            <?php if (!empty($factory_sizes)) { ?>
                <div class="car__sizes__wrapper">
                    <div class="car__sizes__title">Заводская комплектация</div>
                    <ul class="car__sizes__list">
                        <?php
                        foreach (array_unique($factory_sizes) as $tyre) {
                            $size_filter = $this->Frontend->getTyreParams($tyre, $car_sizes['CarTyres']['modification_slug'], $size1, $size2, $size3); ?>
                            <li id="<?php echo 'size-R' . $size_filter['size3']; ?>" class="<?php echo 'size-R' . $size_filter['size3']; ?> <?php if ($size_filter['is_active'] == 1) {
                                echo 'is_active';
                            } ?>">
                                <?php if ($size_filter['is_active'] == 1) {
                                    echo '• ';
                                } ?>Шины
                                <?php echo $this->Html->link($tyre, array('controller' => 'tyres', 'action' => 'index', '?' => $size_filter), array('escape' => false)); ?>
                            </li>
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
                            <li id="<?php echo 'size-R' . $size_filter['size3']; ?>" class="<?php echo 'size-R' . $size_filter['size3']; ?> <?php if ($size_filter['is_active'] == 1) {
                                echo 'is_active';
                            } ?>">
                                <?php if ($size_filter['is_active'] == 1) {
                                    echo '• ';
                                } ?>Шины
                                <?php echo $this->Html->link($tyre, array('controller' => 'tyres', 'action' => 'index', '?' => $size_filter), array('escape' => false)); ?>
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
            <button type="reset" class="filter-reset-car" id="filter-reset-car" onclick="resetTyres()">Сбросить авто<span>x</span>
                <script type="text/javascript">
                    function resetTyres() {
                        $.ajax({
                            url: '/api/remove_session/car_modification_slug',
                            success: function() {
                                window.location = '<?php echo CONST_DEFAULT_TYRES_PATH;?>';
                            }
                        });
                    }
                </script>
            </button>
        </div>
    </div>
</div>