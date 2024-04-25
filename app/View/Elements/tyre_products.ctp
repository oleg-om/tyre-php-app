<?php if ($mode == 'block') { ?>
<div class="tyres-group">
	<?php foreach ($products as $item) { ?>
	<div class="item">
		<?php
			if ($item['Product']['auto'] == 'trucks') {
				$item['Product']['season'] = 'all';
			}
			$season = $item['Product']['season'];
			if (!empty($item['BrandModel']['season'])) {
				$season = $item['BrandModel']['season'];
			}
		?>
		<div class="image"><?php
			$image = $this->Html->image('no-tyre-little.jpg', array('class' => 'no-img-tyre', 'width' => 91, 'height' => 91));
			$image_big = false;
			if (!empty($item['BrandModel']['filename'])) {
				$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 91, 'height' => 91, 'crop' => false, 'folder' => false, 'tyre' => true)), array('alt' => $item['BrandModel']['title']));
				$image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false, 'watermark' => 'wm.png'), array('alt' => $item['BrandModel']['title']));
			}
			if ($image_big) {
				echo $this->Html->link($image, $image_big, array('escape' => false, 'data-lightbox' => 'gallery'));
			}
			else {
				echo $image;
			}
		?></div>
		<div class="desc">
			<div class="name"><?php echo $this->Html->link($item['Brand']['title'] . ' ' . $item['BrandModel']['title'], array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id']))); ?></div>
			<table cellpadding="0" cellspacing="0">
				<col width="80" />
				<col width="80" />
				<col width="30" />
				<col width="30" />
				<col width="30" />
				<col width="90" />
				<col width="70" />
				<col width="30" />
				<tr>
					<td class="radius"><?php echo $item['Product']['size1'] . '/' . $item['Product']['size2'] . '&nbsp;R' . $item['Product']['size3']; ?></td>
					<td><?php echo $current_auto == 'trucks' ? h($item['Product']['axis']) : h($item['Product']['f1'] . $item['Product']['f2']); ?></td>
					<td><img src="/img/season-<?php echo $season; ?>.png" alt="<?php echo $seasons[$season]; ?>" title="<?php echo $seasons[$season]; ?>" /></td>
					<td><?php if ($item['Product']['stud'] == 1) { ?><img src="/img/icons/studded.png" alt="Шипованная" title="Шипованная" /><?php } ?></td>
					<td><img src="/img/auto-<?php echo $item['Product']['auto']; ?>.png" alt="<?php echo $auto[$item['Product']['auto']]; ?>" title="<?php echo $auto[$item['Product']['auto']]; ?>" /></td>
					<td><strong class="nowrap"><?php 
						if ($this->Frontend->canShowTyrePrice($item['Product']['auto'], $item['Product']['not_show_price'])) {
							echo $this->Frontend->getPrice($item['Product']['price'], 'tyres');
						}
					?></strong></td>
					<td><?php echo $this->Frontend->getStockCount($item['Product']['stock_count']); ?> шт.</td>
					<td><?php echo $item['Product']['in_stock'] ? '<img title="в наличии" alt="в наличии" src="/img/yes.png">' : ''; ?></td>
				</tr>
			</table>
			<div class="all-more"><?php echo $this->Html->link('Подробнее', array('controller' => 'tyres', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product']['id']), array('escape' => false)); ?></div>
		</div>
		<div class="clear"></div>
	</div>
	<?php } ?>
</div>
<div class="clear"></div>
<?php } elseif ($mode == 'table') { ?>
<div id="vmMainPage">
	<table border="0" width="100%" cellspacing="0" cellpadding="0" class="sectiontableheader sectiontableentry1">
		<tr class="rowTint1">
			<th>&nbsp;</th>
			<th>Типоразмер</th>
			<th><?php echo $current_auto == 'trucks' ? 'Ось' : 'ИН/ИС'; ?></th>
			<th>Бренд</th>
			<th>Модель</th>
			<th><img src="/img/season-all.png" alt="Сезон" title="Сезон" /></th>
			<th><img src="/img/icons/studded.png" alt="Шипы" title="Шипы" /></th>
			<th>Тип</th>
			<th width="50">Цена</th>
			<th>Кол.</th>
			<th></th>
		</tr>
		<?php $i = 0; foreach ($products as $item) { ?>
		<tr height="22" class="rowTint<?php echo $i % 2 == 1 ? '1' : ''; ?>">
			<td><?php
				if ($item['Product']['auto'] == 'trucks') {
					$item['Product']['season'] = 'all';
				}
				if (!empty($item['BrandModel']['filename'])) {
					echo $this->Html->link($this->Html->image('camera.png', array('alt' => $item['Brand']['title'] . ' ' . $item['BrandModel']['title'])), $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false)), array('escape' => false, 'data-lightbox' => 'gallery', 'title' => $item['Brand']['title'] . ' ' . $item['BrandModel']['title']));
				}
			?></td>
			<td><?php echo $this->Html->link($item['Product']['size1'] . '/' . $item['Product']['size2'] . '&nbsp;R' . $item['Product']['size3'], array('controller' => 'tyres', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product']['id']), array('escape' => false)); ?></td>
			<td><?php echo $current_auto == 'trucks' ? h($item['Product']['axis']) : h($item['Product']['f1'] . $item['Product']['f2']); ?></td>
			<td><?php echo h($item['Brand']['title']); ?></td>
			<td><?php echo h($item['BrandModel']['title']); ?></td>
			<?php
				$season = $item['Product']['season'];
				if (!empty($item['BrandModel']['season'])) {
					$season = $item['BrandModel']['season'];
				}
			?>
			<td><img src="/img/season-<?php echo $season; ?>.png" alt="<?php echo $seasons[$season]; ?>" title="<?php echo $seasons[$season]; ?>" /></td>
			<td><?php if ($item['Product']['stud'] == 1) { ?><img src="/img/icons/studded.png" alt="Шипованная" title="Шипованная" /><?php } ?></td>
			<td><img src="/img/auto-<?php echo $item['Product']['auto']; ?>.png" alt="<?php echo $auto[$item['Product']['auto']]; ?>" title="<?php echo $auto[$item['Product']['auto']]; ?>" /></td>
			<td>
				<span class="productPrice"><?php
					if ($this->Frontend->canShowTyrePrice($item['Product']['auto'], $item['Product']['not_show_price'])) {
						echo $this->Frontend->getPrice($item['Product']['price'], 'tyres');
					}
				?></span>
			</td>
			<td><?php echo $this->Frontend->getStockCount($item['Product']['stock_count']); ?></td>
			<td><?php echo $item['Product']['in_stock'] ? '<div class="in-stock"></div>' : ''; ?></td>
		</tr>
		<?php $i ++; } ?>
	</table>
	<br class="clr"><br>
</div>
<?php } ?>