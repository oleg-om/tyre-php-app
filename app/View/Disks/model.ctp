<?php echo $this->element('currency', array('class' => 'bpad')); ?>
<div class="product__wrapper">
<div class="prodBigImg">
	<?php
		$image_small = $this->Html->image('no-disk-big.jpg');
		$image_big = '/img/disk.jpg';
		if (!empty($model['BrandModel']['filename'])) {
			$image_small = $this->Html->image($this->Backend->thumbnail(array('id' => $model['BrandModel']['id'], 'filename' => $model['BrandModel']['filename'], 'path' => 'models', 'width' => 315, 'height' => 1000, 'crop' => false, 'folder' => false)), array('alt' => $model['BrandModel']['title']));
			$image_big = $this->Backend->thumbnail(array('id' => $model['BrandModel']['id'], 'filename' => $model['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 601, 'crop' => false, 'folder' => false,'watermark' => 'wm.png'), array('alt' => $model['BrandModel']['title']));

		}
		echo $this->Html->link($image_small, $image_big, array('escape' => false, 'class' => 'lightbox', 'title' => $model['Brand']['title']. ' '. $model['BrandModel']['title']));
	?>
</div>

<div class="infoProdBig">
	<div class="boxLeftInfo">
		<h2><?php echo $model['Brand']['title']. ' <span>'. $model['BrandModel']['title']; ?></span></h2>
		<div class="clear"></div>
	</div>
	<?php echo $this->element('box_info'); ?>
	<div class="clear"></div>
	<div class="boxMod">
		<h3>Модификации и цена <?php echo $model['Brand']['title']. ' '. $model['BrandModel']['title']; ?>:</h3>
		<?php if (!empty($model_autos) && count($model_autos) > 1) {
			$auto_titles = array('cars' => 'Легковые', 'trucks' => 'Грузовые', 'agricultural' => 'Сельскохозяйственные', 'loader' => 'Погрузчики', 'special' => 'Индустриальные');
			$car_icon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 17H3v-5l2-5h11l3 5h2v5h-2"/><path d="M9 17h6"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/><path d="M5 12h14"/></svg>';
			$truck_icon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h11v11H3z"/><path d="M14 10h4l3 3v4h-7"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>';
		?>
		<div class="auto-switch">
			<?php foreach ($model_autos as $auto_value) {
				$query = array_merge($this->request->query, array('auto' => $auto_value));
				$title = isset($auto_titles[$auto_value]) ? $auto_titles[$auto_value] : $auto_value;
				$icon = $auto_value === 'cars' ? $car_icon : $truck_icon;
				echo $this->Html->link($icon . '<span>' . h($title) . '</span>', '?' . http_build_query($query), array('escape' => false, 'class' => 'auto-switch__item' . ($auto_value === $model_auto ? ' active' : '')));
			} ?>
		</div>
		<?php } ?>

		<table cellpadding="0" cellspacing="0">
			<tr>
				<th>Размер</th>
				<th>Ширина</th>
				<th>Вылет</th>
				<th>Ступица</th>
				<th>Цвет</th>
				<th>Кол-во</th>
				<th>Цена</th>
				<th></th>
			</tr>
			<?php foreach ($model['Product'] as $product) { ?>
			<tr>
				<td><?php echo $product['size1']; ?>" <?php echo $product['size2']; ?></td>
				<td><?php echo $product['size3']; ?></td>
				<td><?php echo $product['et']; ?></td>
				<td><?php echo $product['hub']; ?></td>
				<td><?php echo $product['color']; ?></td>
				<td>
                    <?php
                    $in_stock_mark = $product['in_stock'] ? '<img title="в наличии" alt="в наличии" src="/img/yes.png">' : '';
                    $in_stock_text = $product['in_stock'] ? 'В наличии: ' : 'Под заказ: ';
                    echo $this->element('stock_places', array('stock_places' => $product['stock_places'], 'text' => '<div class="namber tyres">'.$in_stock_text.$this->Frontend->getStockCount($product['stock_count']).' шт. '.$in_stock_mark.'</div>', 'position' => 'right'));
                    ?>
                </td>
				<td><strong><?php
					if ($this->Frontend->canShowDiskPrice($product['not_show_price'])) {
						echo $this->Frontend->getPrice($product['price'], 'disks');
					}
				?></strong></td>
				<td><?php
					echo $this->Html->link('Подробнее', ProductUrl::url('disks', $product, $model['Brand']['slug'], $model['BrandModel']['title']), array('escape' => false, 'class' => 'btVer2'));
				?>
				</td>
			</tr>
			<?php } ?>
		</table>
		<div class="clear"></div>
	</div>
	<div class="textProd">
		<?php $content = trim(strip_tags($model['BrandModel']['content'])); ?>
		<?php if (!empty($content)) { ?>
		<h3>Описание:</h3>
		<?php echo $model['BrandModel']['content']; ?>
		<?php } ?>
		<?php if (!empty($product['BrandModel']['video'])) { ?><div class="video"><?php echo $product['BrandModel']['video']; ?></div><?php } ?>
	</div>
</div>
</div>