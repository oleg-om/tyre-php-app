<?php
usort($car_generations, function ($a, $b) {
    return $a['CarGeneration']['release_year_start'] - $b['CarGeneration']['release_year_start'];
});
?>
<div class="sel">
	<div class="sel__head">
		<h1 class="sel__title">Подбор по авто: <?php echo h($brand['CarBrand']['title'] . ' ' . $model['CarModel']['title']); ?></h1>
		<p class="sel__lead">Выберите поколение.</p>
	</div>
	<?php echo $this->element('selection_steps', array('step' => 2)); ?>

	<div class="sel-grid sel-grid--cars">
		<?php foreach ($car_generations as $item) {
			// «Sedan/2012-2023» → кузов и годы отдельно
			$parts = explode('/', $item['CarGeneration']['title'], 2);
			$body = trim($parts[0]);
			$years = isset($parts[1]) ? str_replace('-', '–', trim($parts[1])) : '';
			$image = '<span class="sel-card__placeholder"></span>';
			if (!empty($item['CarGeneration']['image_preview'])) {
				$image = $this->Html->image('/files/car_generations/' . $item['CarGeneration']['image_preview'], array('alt' => $brand['CarBrand']['title'] . ' ' . $model['CarModel']['title'] . ' ' . $item['CarGeneration']['title'], 'loading' => 'lazy'));
			}
			echo $this->Html->link(
				'<span class="sel-card__photo">' . $image . '</span><span class="sel-card__body"><span class="sel-card__title">' . h($body) . '</span>' . ($years ? '<span class="sel-card__sub">' . h($years) . '</span>' : '') . '</span>',
				array('controller' => 'car_generations', 'action' => 'view', 'brand_slug' => $brand['CarBrand']['slug'], 'model_slug' => $model['CarModel']['slug'], 'generation_slug' => $item['CarGeneration']['slug']),
				array('escape' => false, 'class' => 'sel-card sel-card--car', 'title' => $brand['CarBrand']['title'] . ' ' . $model['CarModel']['title'] . ' ' . $item['CarGeneration']['title'])
			);
		} ?>
	</div>
</div>
