<?php echo $this->element('currency', array('class' => 'bpad')); ?>
<div class="product__wrapper">
<div class="prodBigImg">
	<?php
		$image_small = $this->Html->image('no-tyre-big.jpg');
		$image_big = '/img/tyre.jpg';
		if (!empty($model['BrandModel']['filename'])) {
			$image_small = $this->Html->image($this->Backend->thumbnail(array('id' => $model['BrandModel']['id'], 'filename' => $model['BrandModel']['filename'], 'path' => 'models', 'width' => 400, 'height' => 1000, 'crop' => false, 'folder' => false)), array('alt' => $model['BrandModel']['title']));
			$image_big = $this->Backend->thumbnail(array('id' => $model['BrandModel']['id'], 'filename' => $model['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false, 'watermark' => 'wm.png'), array('alt' => $model['BrandModel']['title']));

		}
		echo $this->Html->link($image_small, $image_big, array('escape' => false, 'class' => 'lightbox', 'title' => $model['Brand']['title']. ' '. $model['BrandModel']['title']));
	?>
</div>
<div class="infoProdBig">
	<div class="boxLeftInfo">
		<h2><?php echo $model['Brand']['title']. ' <span>'. $model['BrandModel']['title']; ?></span></h2>
		<?php
			$season = null;
			if (!empty($model['Product'][0])) {
				$season = $model['Product'][0]['season'];
			}
			if (!empty($model['BrandModel']['season'])) {
				$season = $model['BrandModel']['season'];
			}
		?>
		<?php if (!empty($season)) { ?>
		<div class="productSeason<?php if ($season=='winter') {echo '2';} elseif ($season=='all') {echo '3';}?>" title="<?php echo $seasons[$season];?>">
			<?php echo $seasons[$season];?>
		</div>
		<?php } ?>
		<?php if (!empty($model['Product'][0])) { ?>
		<div class="stud"><?php echo $model['Product'][0]['stud'] ? '<img src="/img/studded.png" alt="шипованная" />' : ''; ?></div>
		<?php } ?>
		<div class="clear"></div>
	</div>
	<?php echo $this->element('box_info'); ?>
	<div class="clear"></div>
	<?php if (!empty($model['Product'][0])) { ?>
	<div class="boxMod">
		<h3>Модификации и цена <?php echo $model['Brand']['title']. ' '. $model['BrandModel']['title']; ?>:</h3>
		<?php
			$results = Hash::extract($model, 'Product.{n}.size3');//диаметр
			$unique_d = array_unique($results);
			sort($unique_d);
		?>
		<ul class="filterMod">
			<li>Диаметр:</li>
			<?php foreach($unique_d as $item) { ?>
				<li>
					<a href="<?php echo $item; ?>" class="filter_link">R<?php echo $item; ?></a>
				</li>
			<?php } ?>
		</ul>
		<table cellpadding="0" cellspacing="0">
			<col width="100">
			<col width="170" class="desc-col">
			<col width="25" class="desc-col">
			<col width="80" class="desc-col">
			<col width="90">
			<col width="100">
			<thead>
				<tr>
					<th>Типоразмер</th>
					<th class="desc-table">Индекс скорости / нагрузки</th>
					<th class="desc-table"></th>
					<th class="desc-table">Количество</th>
					<th>Цена</th>
					<th></th>
				</tr>
			</thead>
			<?php $line = 0; foreach ($model['Product'] as $product) { ?>
			<?php
				if ($line % 2 == 0) {
					$class = 'tr-even';
				}
				else {
					$class = 'tr-odd';
				}
				$line ++;
			?>
			<tr class="body r<?php echo $product['size3']; ?> <?php echo $class; ?>">
				<td><?php echo $product['size1']; ?> / <?php echo $product['size2']; ?> R<?php echo $product['size3']; ?></td>
				<td class="desc-table"><?php echo h($product['f1'] . $product['f2']) . ' &ndash; ' .  $this->Frontend->getFF($product['f1'], $product['f2']); ?></td>
				<td class="desc-table">
                    <div class="desc-icons">
                        <?php echo $product['stud'] ? '<img src="/img/studded.png" alt="шипованная" />' : ''; ?>
                        <?php echo $this->element('tyre_icons', array('product' => $product)); ?>
                    </div>
                </td>
				<td class="desc-table"><?php
                    $in_stock_mark = $product['in_stock'] ? '<img title="в наличии" alt="в наличии" src="/img/yes.png">' : '';
                    $in_stock_text = $product['in_stock'] ? 'В наличии: ' : 'Под заказ: ';
                    echo $this->element('stock_places', array('stock_places' => $product['stock_places'], 'text' => '<div class="namber tyres">'.$in_stock_text.$this->Frontend->getStockCount($product['stock_count']).' шт. '.$in_stock_mark.'</div>', 'position' => 'right'));
                    ?></td>
				<td><strong><?php
					if ($this->Frontend->canShowTyrePrice($product['auto'], $product['not_show_price'])) {
						echo $this->Frontend->getPrice($product['price'], 'tyres');
					}
				?></strong></td>
				<td>
					<?php echo $this->Html->link('купить', array('controller' => 'tyres', 'action' => 'view', 'slug' => $model['Brand']['slug'], 'id' => $product['id']), array('escape' => false, 'class' => 'btVer2')); ?>
				</td>
			</tr>
			<?php } ?>
		</table>
		<div class="clear"></div>
	</div>
	<?php } ?>
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