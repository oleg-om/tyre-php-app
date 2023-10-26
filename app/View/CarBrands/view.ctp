<h2 class="title">Подбор по авто</h2>
<p>Выберите модель:</p>
<div class="selection">
	<?php foreach ($models as $item) { ?>
		<div class="item"><?php
			echo $this->Html->link($item['CarModel']['title'], array('controller' => 'car_models', 'action' => 'view', 'brand_slug' => $brand['CarBrand']['slug'], 'model_slug' => $item['CarModel']['slug']), array('escape' => false, 'title' => $brand['CarBrand']['title'] . ' ' . $item['CarModel']['title']));
		?></div>
	<?php } ?>
	<div class="clear"></div>
</div>