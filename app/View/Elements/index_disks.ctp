<?php if (!empty($models)) { ?>
	<?php if ($mode == 'block') { ?>
	<div class="border-b">
	<div class="width-disk">
	<?php } elseif ($mode == 'table') { ?>
	<div class="tab-prod">
		<table cellpadding="0" cellspacing="0">
			<col width="40">
			<col width="160">
			<col width="100">
			<col width="100">
			<col width="100">
			<col />
			<col width="200">
			<col />
			<col width="140">
			<col width="210">
			<tr>
				<th></th>
				<th>Типоразмер</th>
				<th>Ширина</th>
				<th>ET</th>
				<th>Ступица</th>
				<th>Бренд</th>
				<th>Модель</th>
				<th></th>
				<th>Наличие</th>
				<th>Цена</th>

			</tr>
	<?php } ?>
		<?php $line = 0;foreach ($models as $item) { ?>
			<?php if ($mode == 'block') { ?>
				<div class="boxList disks">
			<?php } elseif ($mode == 'list') { ?>
				<div class="boxList2">
			<?php } else { ?>

			<?php } ?>
				<?php if ($mode == 'table' || count($item['Product']) == 1 ) { ?>
					<?php
						if ($mode == 'table') {
							$item['Product'][0] = $item['Product'];
						}
					?>
					<?php if ($mode == 'block') { ?>
						<h3 class="title-tyres">
							<?php
								$link_filter = array('model_id' => $item['BrandModel']['id']);
								$link_filter = array_merge($link_filter, $filter);
								unset($link_filter['mode']);
								$url = array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter);
								echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], $url, array('escape' => false));
								$url = array('controller' => 'disks', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product'][0]['id']);
							?>
						</h3>
						<div class="prodImg floatl">
							<?php if ($item['BrandModel']['new']) { ?>
							<div class="action-prod new"></div>
							<?php } elseif ($item['BrandModel']['popular']) { ?>
							<div class="action-prod hit"></div>
							<?php } elseif ($item['Product'][0]['sale']) { ?>
							<div class="action-prod action"></div>
							<?php } ?>
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td>
										<?php
											$image = $this->Html->image('no-disk-little.jpg', array('class' => 'no-img-disk'));
											$image_big = false;
											if (!empty($item['BrandModel']['filename'])) {
												$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 182, 'height' => 143, 'crop' => false, 'folder' => false)), array('alt' => $item['BrandModel']['title']));
												$image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 601, 'crop' => false, 'folder' => false), array('alt' => $item['BrandModel']['title']));
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
								<a href="<?php echo Router::url($url); ?>"><?php echo $item['Product'][0]['size1']; ?>" <?php echo $item['Product'][0]['size2']; ?>&nbsp;&nbsp;<?php echo $this->Frontend->getSize3($item['Product'][0]['size3']); ?>J&nbsp;&nbsp;ET<?php echo (int)$item['Product'][0]['et']; ?>&nbsp;DIA<?php echo $item['Product'][0]['hub']; ?></a>
							</div>
						</div>
						<div class="clear"></div>
						<div class="priceMore disks">
							<?php if ($this->Frontend->canShowDiskPrice($item['Product'][0]['not_show_price'])) { ?>
								<span><?php echo $this->Frontend->getPrice($item['Product'][0]['price'], 'disks', array('between' => '&nbsp;<span>', 'after' => '</span>')); ?></span>
							<?php } ?><div class="number disks">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->Frontend->getStockCount($item['Product'][0]['stock_count']); ?> шт.</div>
						</div>

						<div class="clear"></div>
					<?php } elseif ($mode == 'list') { ?>
						<div class="prodImg2 floatl">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td class="normal-img">
										<?php
											$image = $this->Html->image('no-disk-little.jpg', array('class' => 'no-img-disk'));
											$image_big = false;
											if (!empty($item['BrandModel']['filename'])) {
												$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 182, 'height' => 143, 'crop' => false, 'folder' => false)), array('alt' => $item['BrandModel']['title']));
												$image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 601, 'crop' => false, 'folder' => false), array('alt' => $item['BrandModel']['title']));
											}
											if ($item['BrandModel']['new']) {
												$image = '<div class="action-prod new"></div>' . $image;
											}
											elseif ($item['BrandModel']['popular']) {
												$image = '<div class="action-prod hit"></div>' . $image;
											}
											if ($image_big) {
												echo $this->Html->link($image, $image_big, array('escape' => false, 'class' => 'lightbox rel-box', 'id' => $item['BrandModel']['id']));
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
								$link_filter = array_merge($link_filter, $filter);
									echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter), array('escape' => false));
								?>
							</h3>
							<div class="detalProd">
								<?php echo $item['Product'][0]['size1']; ?>"&nbsp;<?php echo $item['Product'][0]['size2']; ?>&nbsp;&nbsp;<?php echo $this->Frontend->getSize3($item['Product'][0]['size3']); ?>J&nbsp;&nbsp;ET<?php echo (int)$item['Product'][0]['et']; ?>&nbsp;DIA<?php echo $item['Product'][0]['hub']; ?>
								<br />
								<strong><?php echo $this->Frontend->getStockCount($item['Product'][0]['stock_count']); ?> шт.</strong>
							</div>
						</div>
						<div class="priceMore2">
							<?php if ($this->Frontend->canShowDiskPrice($item['Product'][0]['not_show_price'])) { ?>
								<span><?php echo $this->Frontend->getPrice($item['Product'][0]['price'], 'disks', array('between' => '&nbsp;<span>', 'after' => '</span>')); ?></span>
							<?php
								}
								echo $this->Html->link('подробнее', array('controller' => 'disks', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product'][0]['id'], '?' => $filter), array('escape' => false, 'class' => 'btVer2'));
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
						<tr class="<?php echo $class; ?>" onclick="window.location='<?php echo Router::url(array('controller' => 'disks', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product'][0]['id'], '?' => $filter)); ?>';">
							<td class="a-center"><?php
								if (!empty($item['BrandModel']['filename'])) {
									$image = $this->Html->image('img-detal.jpg');
									$image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 601, 'crop' => false, 'folder' => false), array('alt' => $item['BrandModel']['title']));
									echo $this->Html->link($image, $image_big, array('escape' => false, 'class' => 'lightbox', 'id' => $item['BrandModel']['id']));
								}
							?></td>
							<td><?php
								echo $item['Product'][0]['size1'] . '"&nbsp;' . $item['Product'][0]['size2'];
							?></td>
							<td><?php echo $this->Frontend->getSize3($item['Product'][0]['size3']); ?>J</td>
							<td><?php echo (int)$item['Product'][0]['et']; ?></td>
							<td><?php echo $item['Product'][0]['hub']; ?></td>
							<td><?php echo $item['Brand']['title']; ?></td>
							<td class="model"><?php
								$link_filter = array('model_id' => $item['BrandModel']['id']);
								$link_filter = array_merge($link_filter, $filter);
								unset($link_filter['mode']);
								echo $this->Html->link($item['BrandModel']['title'], array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter), array('escape' => false));
							?></td>
							<td>
								<?php if ($item['Product'][0]['sale']) { ?>
									<div class="action-prod-list"><span>акция</span></div>
								<?php } elseif ($item['BrandModel']['new']) { ?>
									<div class="latest-prod-list"><span>новинка</span></div>
								<?php } elseif ($item['BrandModel']['popular']) { ?>
									<div class="hit-prod-list"><span>хит</span></div>
								<?php } ?>
							</td>
							<td><?php echo $this->Frontend->getStockCount($item['Product'][0]['stock_count']); ?> шт.</td>
							<td class="price"><strong><?php
								if ($this->Frontend->canShowDiskPrice($item['Product'][0]['not_show_price'])) {
									echo $this->Frontend->getPrice($item['Product'][0]['price'], 'disks');
								}
							?></strong></td>
						</tr>
					<?php } ?>
				<?php } else {
					
					
					$results = Hash::extract($item, 'Product.{n}.price');
					//if(empty($results)):
						
						$min_price = min($results);
						$max_price = max($results);
						
					$results = Hash::extract($item, 'Product.{n}.size1');//диаметр
						$min_d = min($results);
						$max_d = max($results);
						
				?>
					<?php if ($mode == 'block') { ?>
						<h3 class="title-tyres">
							<?php
							$link_filter = array('model_id' => $item['BrandModel']['id']);
							$link_filter = array_merge($link_filter, $filter);
								echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter), array('escape' => false));
							?>
						</h3>
						<div class="prodImg floatl">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td>
										<?php
											$image = $this->Html->image('no-disk-little.jpg', array('class' => 'no-img-disk'));
											$image_big = false;
											if (!empty($item['BrandModel']['filename'])) {
												$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 182, 'height' => 143, 'crop' => false, 'folder' => false)), array('alt' => $item['BrandModel']['title']));
												$image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 601, 'crop' => false, 'folder' => false), array('alt' => $item['BrandModel']['title']));
											}
											if ($image_big) {
												echo $this->Html->link($image, $image_big, array('escape' => false, 'class' => 'lightbox rel-box', 'id' => $item['BrandModel']['id']));
											}
											else {
												echo $image;
											}
										?>
									</td>
								</tr>
							</table>
							<?php if ($item['BrandModel']['new']) { ?>
							<div class="action-prod new"></div>
							<?php } elseif ($item['BrandModel']['popular']) { ?>
							<div class="action-prod hit"></div>
							<?php } ?>
						</div>
						<div class="infoList">
							<div class="detalProd disks">
								<?php if ($min_d == $max_d) {?>
								<span class="size15">Диаметр:</span> <?php echo $min_d; ?>"
								<?php } else { ?>
								<span class="size15">Диаметры:</span> от <?php echo $min_d; ?>" до <?php echo $max_d; ?>"
								<?php } ?>
							</div>
						</div>
						<div class="clear"></div>
						<div class="priceMore disks">
							<?php if ($this->Frontend->canShowDiskPrice($item['Product'][0]['not_show_price'])) { ?>
								<em>от</em> <span><?php echo $this->Frontend->getPrice($min_price, 'disks', array('between' => '&nbsp;<span>', 'after' => '</span>')); ?></span>
							<?php } ?>
						</div>
						<div class="clear"></div>
					<?php } elseif ($mode == 'list') { ?>
					<div class="disk-wrapper">
					<div class="disk-info">
						<div class="prodImg2 floatl">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td class="normal-img">
										<?php
											$image = $this->Html->image('no-disk-little.jpg', array('class' => 'no-img-disk'));
											$image_big = false;
											if (!empty($item['BrandModel']['filename'])) {
												$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 182, 'height' => 143, 'crop' => false, 'folder' => false)), array('alt' => $item['BrandModel']['title']));
												$image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 601, 'crop' => false, 'folder' => false), array('alt' => $item['BrandModel']['title']));
											}
											if ($item['BrandModel']['new']) {
												$image = '<div class="action-prod new"></div>' . $image;
											}
											elseif ($item['BrandModel']['popular']) {
												$image = '<div class="action-prod hit"></div>' . $image;
											}
											if ($image_big) {
												echo $this->Html->link($image, $image_big, array('escape' => false, 'class' => 'lightbox rel-box', 'id' => $item['BrandModel']['id']));
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
								$link_filter = array_merge($link_filter, $filter);
									echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter), array('escape' => false));
								?>
							</h3>
							<div class="detalProd">
								<?php if ($min_d == $max_d) {?>
								<span class="size15">Диаметр:</span> <?php echo $min_d; ?>"
								<?php } else { ?>
								<span class="size15">Диаметры:</span> от <?php echo $min_d; ?>" до <?php echo $max_d; ?>"
								<?php } ?>
							</div>
							<a href="#" class="moreProd" style="display: none;">скрыть все размеры<span class="picLink3"></span></a>
							<a href="#" class="moreProd">показать все размеры<span class="picLink1"></span></a>
						</div>
						<div class="priceMore2">
							<?php if ($this->Frontend->canShowDiskPrice($item['Product'][0]['not_show_price'])) { ?>
								<em>от</em> <span><?php echo $this->Frontend->getPrice($min_price, 'disks', array('between' => '&nbsp;<span>', 'after' => '</span>')); ?></span>
							<?php } 
								echo $this->Html->link('все размеры', array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter), array('class' => 'btVer3'));
							?>
						</div>
						</div>
						<div class="moreTable hidden">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<th>Размер</th>
									<th>Ширина</th>
									<th>Вылет</th>
									<th>Ступица</th>
									<th>Цвет</th>
									<th>Материал</th>
									<th>Количество</th>
									<th></th>
									<th>Цена</th>
								</tr>
								<?php foreach ($item['Product'] as $product) { ?>
								<tr onclick="window.location='<?php echo Router::url(array('controller' => 'disks', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $product['id'])); ?>';">
									<td><?php echo $product['size1']; ?> <?php echo $product['size2']; ?></td>
									<td><?php echo $this->Frontend->getSize3($product['size3']); ?>J</td>
									<td><?php echo $product['et']; ?></td>
									<td><?php echo $product['hub']; ?></td>
									<td><?php echo $product['color']; ?></td>
									<td><?php echo $product['material']; ?></td>
									<td><?php echo $this->Frontend->getStockCount($product['stock_count']); ?></td>
									<td><?php if ($product['sale']) { ?><div class="action-prod-list"><span>акция</span></div><?php } ?></td>
									<td><strong><?php
										if ($this->Frontend->canShowDiskPrice($product['not_show_price'])) {
											echo $this->Frontend->getPrice($product['price'], 'disks');
										}
									?></strong></td>
								</tr>
								<?php } ?>
							</table>
							<div class="clear"></div>
						</div>
						</div>
						<div class="clear"></div>
					<?php } else { ?>
						<?php foreach ($item['Product'] as $product) { ?>
						<?php
							if ($line % 2 == 0) {
								$class = 'tr-even';
							}
							else {
								$class = 'tr-odd';
							}
							$line ++;
						?>
						<tr class="<?php echo $class; ?>" onclick="window.location='<?php echo Router::url(array('controller' => 'disks', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $product['id'])); ?>';">
							<td class="a-center"><?php
								$image = $this->Html->image('img-detal.jpg');
								if (!empty($item['BrandModel']['filename'])) {
									$image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 601, 'crop' => false, 'folder' => false), array('alt' => $item['BrandModel']['title']));
									echo $this->Html->link($image, $image_big, array('escape' => false, 'class' => 'lightbox', 'id' => $item['BrandModel']['id']));
								}
							?></td>
							<td><?php
								echo $product['size1'] . '"&nbsp;&nbsp;' . $product['size2']
							?></td>
							<td><?php echo $this->Frontend->getSize3($product['size3']); ?>J</td>
							<td><?php echo (int)$product['et']; ?></td>
							<td><?php echo $product['hub']; ?></td>
							<td><?php echo $item['Brand']['title']; ?></td>
							<td><?php
								$link_filter = array('model_id' => $item['BrandModel']['id']);
								$link_filter = array_merge($link_filter, $filter);
								unset($link_filter['mode']);
								echo $this->Html->link($item['BrandModel']['title'], array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter), array('escape' => false));
							?></td>
							<td>
								<?php if ($product['sale']) { ?>
									<div class="action-prod-list"><span>акция</span></div>
								<?php } elseif ($item['BrandModel']['new']) { ?>
									<div class="latest-prod-list"><span>новинка</span></div>
								<?php } elseif ($item['BrandModel']['popular']) { ?>
									<div class="hit-prod-list"><span>хит</span></div>
								<?php } ?>
							</td>
							<td><?php echo $this->Frontend->getStockCount($product['stock_count']); ?> шт.</td>
							<td class="price"><strong><?php
								if ($this->Frontend->canShowDiskPrice($product['not_show_price'])) {
									echo $this->Frontend->getPrice($product['price'], 'disks');
								}
							?></strong></td>
						</tr>
						<?php } ?>
					<?php } ?>
				<?php 
				
				//else:
			//echo"нет результата!!!";
				//endif;
				
				} ?>
			<?php if ($mode == 'table') { ?>
				
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