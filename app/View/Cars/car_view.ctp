<?php
$car_title = '';
if (!empty($car_brand['CarBrand']['slug'])) {
    $car_title = $car_brand['CarBrand']['title'] . ' ' . $car_model['CarModel']['title'] . ' ' . $car_generation['CarGeneration']['title'] . ' ' . $car_modification['CarModification']['title'];
}

$has_tyres = (!empty($factory_tyres) && $factory_tyres[0] !== '') || (!empty($tuning_tyres) && $tuning_tyres[0] !== '');
$has_wheels = !empty($factory_wheels) || !empty($tuning_wheels);
$has_akb = !empty($factory_akb) || !empty($tuning_akb);

$akb_label = function ($size) {
    $b = $size['CarBatteries'];
    $label = $b['capacity_min'] . '–' . $b['capacity_max'] . ' Ач, ' . $b['polarity'] . ' полярность, ' . $b['length_min'] . '–' . $b['length_max'] . '×' . $b['width_min'] . '–' . $b['width_max'] . '×' . $b['height_min'] . '–' . $b['height_max'] . ' мм';
    if (!empty($b['current_min'])) {
        $label .= ', ' . $b['current_min'] . (!empty($b['current_max']) ? '–' . $b['current_max'] : '') . ' А';
    }
    return $label;
};

$icons = array(
    'tyres' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4"/><path d="M12 3v2M12 19v2M3 12h2M19 12h2M5.6 5.6l1.4 1.4M17 17l1.4 1.4M5.6 18.4L7 17M17 7l1.4-1.4"/></svg>',
    'disks' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="2"/><path d="M12 10V4M13.9 11.4l5.6-2M13.2 13.6l3.6 4.8M10.8 13.6l-3.6 4.8M10.1 11.4l-5.6-2"/></svg>',
    'akb' => '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M7 7V4h3v3M14 7V4h3v3M7 13.5h3M15.5 12v3M14 13.5h3"/></svg>',
);
?>
<div class="sel sel-car">
    <div class="sel-car__hero">
        <div class="sel-car__photo"><?php
            if (!empty($car_image)) {
                echo $this->Html->image('/files/car_generations/' . $car_image, array('alt' => $car_title, 'loading' => 'lazy'));
            }
        ?></div>
        <div class="sel-car__info">
            <div class="sel-car__eyebrow">Подбор для автомобиля</div>
            <h1 class="sel__title"><?php echo h($car_title); ?></h1>
            <?php echo $this->element('selection_steps', array('step' => 4, 'brand' => $car_brand, 'model' => $car_model, 'generation' => $car_generation, 'modification_title' => $car_modification['CarModification']['title'])); ?>
        </div>
    </div>

    <div class="sel-car__groups">
        <section class="sel-group">
            <h2 class="sel-group__title"><span class="sel-group__icon"><?php echo $icons['tyres']; ?></span>Шины</h2>
            <?php if ($has_tyres) { ?>
                <?php foreach (array('Заводская комплектация' => $factory_tyres, 'Тюнинг' => $tuning_tyres) as $group_title => $group) {
                    if (empty($group) || $group[0] === '') {
                        continue;
                    } ?>
                    <div class="sel-group__label"><?php echo $group_title; ?></div>
                    <ul class="sel-chips">
                        <?php foreach (array_unique(array_map(array($this->Frontend, 'normalizeTyreSize'), $group)) as $tyre) {
                            $filter = $this->Frontend->getTyreParams($tyre, $modification_slug, false, false, false); ?>
                            <li class="sel-chip">
                                <?php
                                if (!empty($filter['double'])) {
                                    list($tyre1, $tyre2) = explode(':', $tyre);
                                    $filter1 = $this->Frontend->getTyreParams($tyre1, $modification_slug, false, false, false);
                                    $filter2 = $this->Frontend->getTyreParams($tyre2, $modification_slug, false, false, false);
                                    echo 'Передние ' . $this->Html->link($tyre1, array('controller' => 'tyres', 'action' => 'index', '?' => $filter1)) . ', задние ' . $this->Html->link($tyre2, array('controller' => 'tyres', 'action' => 'index', '?' => $filter2));
                                } else {
                                    echo $this->Html->link($tyre, array('controller' => 'tyres', 'action' => 'index', '?' => $filter));
                                }
                                ?>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            <?php } else { ?>
                <p class="sel-group__empty">Нет данных о размерах шин</p>
            <?php } ?>
        </section>

        <section class="sel-group">
            <h2 class="sel-group__title"><span class="sel-group__icon"><?php echo $icons['disks']; ?></span>Диски</h2>
            <?php if ($has_wheels) { ?>
                <?php foreach (array('Заводская комплектация' => $factory_wheels, 'Тюнинг' => $tuning_wheels) as $group_title => $group) {
                    if (empty($group)) {
                        continue;
                    } ?>
                    <div class="sel-group__label"><?php echo $group_title; ?></div>
                    <ul class="sel-chips">
                        <?php foreach ($group as $size) {
                            $params = $this->Frontend->getDiskParams($size, false); ?>
                            <li class="sel-chip">
                                <?php
                                if ($size['CarWheels']['kit'] == 1) {
                                    echo 'Передние ' . $this->Html->link($size['CarWheels']['front_axle_title'], array('controller' => 'disks', 'action' => 'index', '?' => $params['front'])) . ', задние ' . $this->Html->link($size['CarWheels']['back_axle_title'], array('controller' => 'disks', 'action' => 'index', '?' => $params['back']));
                                } else {
                                    echo $this->Html->link($size['CarWheels']['front_axle_title'], array('controller' => 'disks', 'action' => 'index', '?' => $params['front']));
                                }
                                ?>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            <?php } else { ?>
                <p class="sel-group__empty">Нет данных о размерах дисков</p>
            <?php } ?>
        </section>

        <section class="sel-group">
            <h2 class="sel-group__title"><span class="sel-group__icon"><?php echo $icons['akb']; ?></span>Аккумуляторы</h2>
            <?php if ($has_akb) { ?>
                <?php foreach (array('Рекомендация автопроизводителя' => $factory_akb, 'Варианты замены' => $tuning_akb) as $group_title => $group) {
                    if (empty($group)) {
                        continue;
                    } ?>
                    <div class="sel-group__label"><?php echo $group_title; ?></div>
                    <ul class="sel-chips">
                        <?php foreach ($group as $size) { ?>
                            <li class="sel-chip sel-chip--wide">
                                <?php echo $this->Html->link($akb_label($size), array('controller' => 'akb', 'action' => 'index', '?' => $this->Frontend->getAkbParams($size))); ?>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            <?php } else { ?>
                <p class="sel-group__empty">Нет данных об аккумуляторах</p>
            <?php } ?>
        </section>
    </div>
</div>
