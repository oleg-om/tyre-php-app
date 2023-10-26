<h2 class="title">Подбор по авто</h2>
<p>Выберите год выпуска:</p>
<div class="selection">
	<?php foreach ($cars as $item) { ?>
		<div class="item"><?php
			echo $this->Html->link($item['Car']['year'], array('controller' => 'car_modifications', 'action' => 'view', 'brand_slug' => $brand['CarBrand']['slug'], 'model_slug' => $model['CarModel']['slug'], 'year' => $item['Car']['year']), array('escape' => false, 'title' => $brand['CarBrand']['title'] . ' ' . $model['CarModel']['title'] . ' ' . $item['Car']['year']));
		?></div>
	<?php } ?>
	<div class="clear"></div>
</div>