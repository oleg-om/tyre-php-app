<?php if (!empty($models)) { ?>
	<?php if ($mode == 'block') { ?>
	<div class="border-b-disks">
	<div class="width-disk">
	<?php } elseif ($mode == 'table') { ?>
	<div class="tab-prod">
		<table cellpadding="0" cellspacing="0">
			<col width="40">
			<col width="160">
			<col width="100">
			<col width="100">
			<col width="100">
			<col width="200">
			<col width="140">
			<col width="210">
			<col width="100">
			<tr>
				<th></th>
				<th>Типоразмер</th>
				<th>Ширина</th>
				<th>ET</th>
				<th>Бренд</th>
				<th>Модель</th>
				<th>Наличие</th>
				<th>Цена</th>
				<th></th>
			</tr>
	<?php } ?>
		<?php $line = 0;foreach ($models as $item) { ?>
			<?php if ($mode == 'block') { ?>
				<div class="boxList disks">
			<?php } elseif ($mode == 'list') { ?>
				<div class="boxList2">
			<?php } else { ?>
				<tr>
			<?php } ?>
				<?php if ($mode == 'block') { ?>
					<h3 class="title-tyres">
						<?php
							$url = array('controller' => 'disks', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product']['id']);
							echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], $url, array('escape' => false));
						?>
					</h3>
					<div class="prodImg floatl">
						<?php if ($item['BrandModel']['new']) { ?>
						<div class="action-prod new"></div>
						<?php } elseif ($item['BrandModel']['popular']) { ?>
						<div class="action-prod hit"></div>
						<?php } elseif ($item['Product']['sale']) { ?>
						<div class="action-prod action"></div>
						<?php } ?>
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<?php
										$image = $this->Html->image('no-disk-little.jpg', array('class' => 'no-img-disk'));
										$image = str_replace('<img ', '<img loading="lazy" ', $image);
										$image_big = false;
										if (!empty($item['BrandModel']['filename'])) {
											$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 182, 'height' => 143, 'crop' => false, 'folder' => false)), array('alt' => $item['BrandModel']['title']));
											$image = str_replace('<img ', '<img loading="lazy" ', $image);
											$image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false, 'watermark' => 'wm.png'), array('alt' => $item['BrandModel']['title']));
										}
										if ($image_big) {
											echo $this->Html->link($image, $image_big, array('escape' => false, 'class' => 'lightbox', 'id' => $item['BrandModel']['id']));
										}
										else {
											echo $image;
										}
									?>
								</td>
							</tr>
						</table>
					</div>
					<div class="infoList">
						<div class="detalProd disks">
							<a href="<?php echo Router::url($url); ?>"><?php echo $item['Product']['size1']; ?>" <?php echo $item['Product']['size2']; ?>&nbsp;&nbsp;<?php echo $this->Frontend->getSize3($item['Product']['size3']); ?>J&nbsp;&nbsp;ET<?php echo (int)$item['Product']['et']; ?></a>
						</div>
					</div>
					<div class="clear"></div>
					<?php if ($this->Frontend->canShowDiskPrice($item['Product']['not_show_price'])) { ?>
						<div class="priceMore disks">
							<span><?php echo $this->Frontend->getPrice($item['Product']['price'], 'disks', array('after' => '</span>', 'between' => '&nbsp;<span>')); ?></span>
						</div>
					<?php } ?>
					<div class="number disks">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->Frontend->getStockCount($item['Product']['stock_count']); ?> шт.</div>
					<div class="clear"></div>
				<?php } elseif ($mode == 'list') { ?>
					<div class="prodImg2 floatl">
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td class="normal-img">
									<?php
										$image = $this->Html->image('no-disk-little.jpg', array('class' => 'no-img-disk'));
										$image = str_replace('<img ', '<img loading="lazy" ', $image);
										$image_big = false;
										if (!empty($item['BrandModel']['filename'])) {
											$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 182, 'height' => 143, 'crop' => false, 'folder' => false)), array('alt' => $item['BrandModel']['title']));
											$image = str_replace('<img ', '<img loading="lazy" ', $image);
											$image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false, 'watermark' => 'wm.png'), array('alt' => $item['BrandModel']['title']));
										}
										if ($image_big) {
											echo $this->Html->link($image, $image_big, array('escape' => false, 'class' => 'lightbox', 'id' => $item['BrandModel']['id']));
										}
										else {
											echo $image;
										}
									?>
								</td>
							</tr>
						</table>
					</div>
					<div class="infoList2">
						<h3>
							<?php
								$link_filter = array('model_id' => $item['BrandModel']['id']);
								echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter), array('escape' => false));
							?>
						</h3>
						<div class="detalProd">
							<?php echo $item['Product']['size1']; ?>"&nbsp;<?php echo $item['Product']['size2']; ?>&nbsp;&nbsp;<?php echo $this->Frontend->getSize3($item['Product']['size3']); ?>J&nbsp;&nbsp;ET<?php echo (int)$item['Product']['et']; ?>
							<br />
							<strong><?php echo $this->Frontend->getStockCount($item['Product']['stock_count']); ?> шт.</strong>
						</div>
					</div>
					<div class="priceMore2">
						<?php if ($this->Frontend->canShowDiskPrice($item['Product']['not_show_price'])) { ?>
							<span><?php echo $this->Frontend->getPrice($item['Product']['price'], 'disks', array('after' => '</span>', 'between' => '&nbsp;<span>')); ?></span>
						<?php } ?>
						<?php
							echo $this->Html->link('подробнее', array('controller' => 'disks', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product']['id'], '?' => $filter), array('escape' => false, 'class' => 'btVer2'));
						?>
					</div>
					<div class="clear"></div>
				<?php } else { ?>
					<?php
						if ($line % 2 == 0) {
							$class = 'tr-even';
						}
						else {
							$class = 'tr-odd';
						}
						$line ++;
					?>
					<tr class="<?php echo $class; ?>">
						<td class="a-center"><?php
							if (!empty($item['BrandModel']['filename'])) {
								$image = $this->Html->image('img-detal.jpg');
								$image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false, 'watermark' => 'wm.png'), array('alt' => $item['BrandModel']['title']));
								echo $this->Html->link($image, $image_big, array('escape' => false, 'class' => 'lightbox', 'id' => $item['BrandModel']['id']));
							}
						?></td>
						<td><?php
							echo $item['Product']['size1'] . '"&nbsp;' . $item['Product']['size2'];
						?></td>
						<td><?php echo $this->Frontend->getSize3($item['Product']['size3']); ?>J</td>
						<td><?php echo (int)$item['Product']['et']; ?></td>
						<td><?php echo $item['Brand']['title']; ?></td>
						<td><?php
							$link_filter = array('model_id' => $item['BrandModel']['id']);
							$link_filter = array_merge($link_filter, $filter);
							unset($link_filter['mode']);
							echo $this->Html->link($item['BrandModel']['title'], array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter), array('escape' => false));
						?></td>
						<td><?php echo $this->Frontend->getStockCount($item['Product']['stock_count']); ?> шт.</td>
						<td class="price"><strong><?php
							if ($this->Frontend->canShowDiskPrice($item['Product']['not_show_price'])) {
								echo $this->Frontend->getPrice($item['Product']['price'], 'disks');
							}
							?></strong></td>
						<td><?php
							echo $this->Html->link('подробнее', array('controller' => 'disks', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product']['id'], '?' => $filter), array('escape' => false, 'class' => 'btVer2'));
						?></td>
					</tr>
				<?php } ?>
			<?php if ($mode == 'table') { ?>
				</tr>
			<?php } else { ?>
				</div>
			<?php } ?>
			<?php } ?>
	<?php if ($mode == 'block') { ?>
		<div class="clear"></div>
	</div>
	</div>
	<?php } elseif ($mode == 'table') { ?>
		</table>
	</div>
	<?php } else { ?>
	<div class="clear"></div>
	<?php } ?>
<?php } else { ?>
	<p>По Вашему запросу ничего не найдено</p>
<?php } ?>
<?php if ($mode == 'list') { ?>
<script type="text/javascript">
<!--
$(function(){
	$('a.moreProd').click(function () {
		$(this).hide();
		$(this).siblings('a').show();
		$(this).parents('.boxList2').find('div.moreTable').toggle();
		return false;
	});
});
//-->
</script>
<?php } ?>