<div class="sel">
	<div class="sel__head">
		<h1 class="sel__title">Подбор по авто: <?php echo h($brand['CarBrand']['title'] . ' ' . $model['CarModel']['title'] . ' ' . $generation['CarGeneration']['title']); ?></h1>
		<p class="sel__lead">Выберите модификацию двигателя.</p>
	</div>
	<?php echo $this->element('selection_steps', array('step' => 3)); ?>

	<div class="sel-grid sel-grid--mods">
		<?php foreach ($car_modifications as $item) {
			$m = $item['CarModification'];
			$main = trim($m['engine_displacement'] . ' ' . $m['engine_type_text']);
			$sub = array();
			if (!empty($m['hp_title'])) {
				$sub[] = $m['hp_title'];
			}
			if (!empty($m['equipment'])) {
				$sub[] = $m['equipment'];
			}
			echo $this->Html->link(
				'<span class="sel-card__body"><span class="sel-card__title">' . h($main) . '</span>' . (!empty($sub) ? '<span class="sel-card__sub">' . h(implode(' · ', $sub)) . '</span>' : '') . '</span><span class="sel-card__arrow" aria-hidden="true">→</span>',
				array('controller' => 'cars', 'action' => 'car_view', 'brand_slug' => $brand['CarBrand']['slug'], 'model_slug' => $model['CarModel']['slug'], 'generation_slug' => $generation['CarGeneration']['slug'], 'modification_slug' => $m['slug']),
				array('escape' => false, 'class' => 'sel-card sel-card--mod', 'title' => $brand['CarBrand']['title'] . ' ' . $model['CarModel']['title'] . ' ' . $main)
			);
		} ?>
	</div>
</div>
