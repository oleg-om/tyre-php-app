<div class="sel">
	<div class="sel__head">
		<?php if (isset($page)) { ?>
			<h2 class="sel__title">Подбор по авто</h2>
		<?php } else { ?>
			<h1 class="sel__title">Подбор по авто</h1>
		<?php } ?>
		<p class="sel__lead">Шины, диски и аккумуляторы, которые подходят вашему автомобилю. Выберите производителя.</p>
	</div>
	<?php echo $this->element('selection_steps', array('step' => 0)); ?>

	<div class="sel__toolbar">
		<input type="search" class="sel-search" placeholder="Найти марку" aria-label="Найти марку" data-target="#sel-brands">
	</div>

	<div class="sel-grid sel-grid--brands" id="sel-brands">
		<?php foreach ($all_brands as $item) { ?>
			<?php
			$image = '';
			if (!empty($item['CarBrand']['filename'])) {
				$image = $this->Html->image('/files/car_brands/' . $item['CarBrand']['filename'], array('alt' => $item['CarBrand']['title'], 'loading' => 'lazy'));
			}
			echo $this->Html->link(
				'<span class="sel-card__logo">' . $image . '</span><span class="sel-card__title">' . h($item['CarBrand']['title']) . '</span>',
				array('controller' => 'car_brands', 'action' => 'view', 'slug' => $item['CarBrand']['slug']),
				array('escape' => false, 'class' => 'sel-card sel-card--brand', 'title' => $item['CarBrand']['title'], 'data-title' => mb_strtolower($item['CarBrand']['title'], 'UTF-8'))
			);
			?>
		<?php } ?>
	</div>
	<p class="sel__empty" hidden>Ничего не найдено</p>

	<?php if (isset($page)) { ?>
		<div class="sel__seo">
			<h1><?php echo h($page['Page']['title']); ?></h1>
			<?php echo $page['Page']['content']; ?>
		</div>
	<?php } ?>
</div>
