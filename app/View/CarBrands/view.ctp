<div class="sel">
	<div class="sel__head">
		<h1 class="sel__title">Подбор по авто: <?php echo h($brand['CarBrand']['title']); ?></h1>
		<p class="sel__lead">Выберите модель.</p>
	</div>
	<?php echo $this->element('selection_steps', array('step' => 1)); ?>

	<?php if (count($models) > 12) { ?>
	<div class="sel__toolbar">
		<input type="search" class="sel-search" placeholder="Найти модель" aria-label="Найти модель" data-target="#sel-models">
	</div>
	<?php } ?>

	<div class="sel-grid sel-grid--text" id="sel-models">
		<?php foreach ($models as $item) {
			echo $this->Html->link(
				'<span class="sel-card__title">' . h($item['CarModel']['title']) . '</span>',
				array('controller' => 'car_models', 'action' => 'view', 'brand_slug' => $brand['CarBrand']['slug'], 'model_slug' => $item['CarModel']['slug']),
				array('escape' => false, 'class' => 'sel-card sel-card--text', 'title' => $brand['CarBrand']['title'] . ' ' . $item['CarModel']['title'], 'data-title' => mb_strtolower($item['CarModel']['title'], 'UTF-8'))
			);
		} ?>
	</div>
	<p class="sel__empty" hidden>Ничего не найдено</p>
</div>
