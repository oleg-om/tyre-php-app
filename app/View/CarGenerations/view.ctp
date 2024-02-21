<h2 class="title">Подбор по авто: <?php echo $brand['CarBrand']['title'] . ' ' . $model['CarModel']['title'] . ' ' . $generation['CarGeneration']['title']; ?></h2>
<p>Выберите модификацию:</p>
<div class="selection">
    <?php foreach ($car_modifications as $item) { ?>
        <div class="item"><?php
            echo $this->Html->link($item['CarModification']['engine_displacement'] . ' ' . $item['CarModification']['engine_type_text'] . ' (' . $item['CarModification']['hp_title'] . ')' . ' ' . $item['CarModification']['equipment'], array('controller' => 'cars', 'action' => 'car_view', 'brand_slug' => $brand['CarBrand']['slug'], 'model_slug' => $model['CarModel']['slug'], 'generation_slug' => $generation['CarGeneration']['slug'], 'modification_slug' => $item['CarModification']['slug']), array('escape' => false, 'class' => 'img-brand', 'title' => $item['CarBrand']['title']));
            ?>
        </div>
    <?php } ?>
    <div class="clear"></div>
</div>