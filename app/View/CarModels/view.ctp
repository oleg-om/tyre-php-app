<h2 class="title">Подбор по авто: <?php echo $brand['CarBrand']['title'] . ' ' . $model['CarModel']['title']; ?></h2>
<p>Выберите поколение:</p>
<div class="selection">
	<?php foreach ($car_generations as $item) { ?>
		<div class="item"><?php
            $image = '';
            if (!empty($item['CarGeneration']['image_preview'])) {
                $image = $this->Html->image('car_generations/' . $item['CarGeneration']['image_preview'], array('alt' => $item['CarGeneration']['title']));
            }
            echo $this->Html->link('<span>' . $image . '</span><strong>' . $item['CarGeneration']['title'] . '</strong>', array('controller' => 'car_generations', 'action' => 'view', 'brand_slug' => $brand['CarBrand']['slug'], 'model_slug' => $model['CarModel']['slug'], 'generation_slug' => $item['CarGeneration']['slug']), array('escape' => false, 'class' => 'img-brand', 'title' => $item['CarBrand']['title']));
            ?>
        </div>
	<?php } ?>
	<div class="clear"></div>
</div>