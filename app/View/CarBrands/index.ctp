<h2 class="title">Подбор по авто</h2>
<p>Выберите производителя:</p>
<div class="selection">
	<?php foreach ($all_brands as $i => $item) { ?>
		<?php if ($i > 0 && $i % 4 == 0) { ?>
			<div class="clear"></div>
		<?php } ?>
		<div class="item"><?php
			$image = '';
			if (!empty($item['CarBrand']['filename'])) {
				$image = $this->Html->image('/files/car_brands/' . $item['CarBrand']['filename'], array('alt' => $item['CarBrand']['title']));
				$image = str_replace('<img ', '<img loading="lazy" ', $image);
			}
			echo $this->Html->link('<span>' . $image . '</span><strong>' . $item['CarBrand']['title'] . '</strong>', array('controller' => 'car_brands', 'action' => 'view', 'slug' => $item['CarBrand']['slug']), array('escape' => false, 'class' => 'img-brand', 'title' => $item['CarBrand']['title']));
		?></div>
	<?php } ?>
	<div class="clear"></div>
	<?php
		if (isset($page)) { 
			echo '<h1>' . h($page['Page']['title']) . '</h1>';
			echo $page['Page']['content'];
		}
	?>
</div>