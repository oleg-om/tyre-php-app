<?php
/**
 * Шаги подбора по авто: Марка → Модель → Поколение → Модификация.
 * $step — текущий шаг (0..3), пройденные шаги ссылаются назад.
 * $brand, $model, $generation — выбранные значения (если есть).
 */
$steps = array(
    array('title' => 'Марка', 'value' => null, 'url' => array('controller' => 'car_brands', 'action' => 'index')),
    array('title' => 'Модель', 'value' => null, 'url' => null),
    array('title' => 'Поколение', 'value' => null, 'url' => null),
    array('title' => 'Модификация', 'value' => null, 'url' => null),
);
if (!empty($brand['CarBrand'])) {
    $steps[0]['value'] = $brand['CarBrand']['title'];
    $steps[1]['url'] = array('controller' => 'car_brands', 'action' => 'view', 'slug' => $brand['CarBrand']['slug']);
}
if (!empty($model['CarModel'])) {
    $steps[1]['value'] = $model['CarModel']['title'];
    $steps[2]['url'] = array('controller' => 'car_models', 'action' => 'view', 'brand_slug' => $brand['CarBrand']['slug'], 'model_slug' => $model['CarModel']['slug']);
}
if (!empty($generation['CarGeneration'])) {
    $steps[2]['value'] = $generation['CarGeneration']['title'];
    $steps[3]['url'] = array('controller' => 'car_generations', 'action' => 'view', 'brand_slug' => $brand['CarBrand']['slug'], 'model_slug' => $model['CarModel']['slug'], 'generation_slug' => $generation['CarGeneration']['slug']);
}
if (!empty($modification_title)) {
    $steps[3]['value'] = $modification_title;
}
?>
<ol class="sel-steps">
    <?php foreach ($steps as $i => $item) {
        $state = $i < $step ? 'done' : ($i == $step ? 'current' : 'todo');
        $inner = '<span class="sel-steps__num">' . ($i < $step ? '&#10003;' : ($i + 1)) . '</span>'
            . '<span class="sel-steps__text"><span class="sel-steps__title">' . h($item['title']) . '</span>'
            . ($i < $step && !empty($item['value']) ? '<span class="sel-steps__value">' . h($item['value']) . '</span>' : '')
            . '</span>';
        ?>
        <li class="sel-steps__item sel-steps__item--<?php echo $state; ?>">
            <?php
            if ($state == 'done' && !empty($item['url'])) {
                echo $this->Html->link($inner, $item['url'], array('escape' => false, 'class' => 'sel-steps__link'));
            } else {
                echo '<span class="sel-steps__link">' . $inner . '</span>';
            }
            ?>
        </li>
    <?php } ?>
</ol>
