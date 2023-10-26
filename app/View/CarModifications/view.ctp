<h2 class="title">Подбор по авто</h2>
<p>Выберите модификацию:</p>
<div class="selection">
	<?php foreach ($modifications as $item) { ?>
		<div class="item"><?php
			echo $this->Html->link($item['CarModification']['title'], array('controller' => 'cars', 'action' => 'car_view', 'brand_slug' => $brand['CarBrand']['slug'], 'model_slug' => $model['CarModel']['slug'], 'year' => $year, 'modification_slug' => $item['CarModification']['slug']), array('escape' => false, 'title' => $brand['CarBrand']['title'] . ' ' . $model['CarModel']['title'] . ' ' . $year . ' ' . $item['CarModification']['title']));
		?></div>
	<?php } ?>
	<div class="clear"></div>
</div>