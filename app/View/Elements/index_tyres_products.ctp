<?php if (!empty($models)) { ?>
	<?php if ($mode == 'block') { ?>
	<div class="border-b-tyres">
	<div class="width-disk">
	<?php } elseif ($mode == 'table') { ?>
	<div class="tab-prod">
		<table cellpadding="0" cellspacing="0">
			<col width="40">
			<col width="240">
			<col width="110">
			<col width="140">
			<col width="250">
			<col width="110">
			<col width="61">
			<col width="61">
			<col width="220">
			<col width="100">
			<tr>
				<th></th>
				<th>Типоразмер</th>
				<th>Ин.</th>
				<th>Бренд</th>
				<th>Модель</th>
				<th></th>
				<th></th>
				<th>Наличие</th>
				<th>Цена</th>
				<th></th>
			</tr>
	<?php } ?>
		<?php $line = 0;foreach ($models as $item) { ?>
			<?php if ($mode == 'block') { ?>
				<div class="boxList season-<?php echo $item['Product']['season']; ?>">
			<?php } elseif ($mode == 'list') { ?>
				<div class="boxList2 boxList2-new season-<?php echo $item['Product']['season']; ?>">
			<?php } else { ?>
			<?php } ?>
					<?php if ($mode == 'block') { ?>
						<div class="info-top">
							<h3>
								<?php
									echo $this->Html->link('<span class="brand">' . $item['Brand']['title']. '</span><span class="model">'. $item['BrandModel']['title'] . '</span>', array('controller' => 'tyres', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product']['id']), array('escape' => false));
									$url = array('controller' => 'tyres', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product']['id']);
								?>
								<span class="productSeason<?php if ($item['Product']['season']=='winter') {echo '2';} elseif ($item['Product']['season']=='all') {echo '3';}?>" title="<?php echo $seasons[$item['Product']['season']];?>">
									<?php echo $seasons[$item['Product']['season']];?>
								</span>
								<div class="stud"><?php echo $item['Product']['stud'] ? '<img src="/img/icons/studded.png" alt="шипованная" />' : ''; ?></div>
							</h3>
						</div>
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
											$image = $this->Html->image('no-tyre-little.jpg', array('class' => 'no-img-tyre'));
											$image_big = false;
											if (!empty($item['BrandModel']['filename'])) {
												$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 158, 'height' => 158, 'crop' => false, 'folder' => false, 'tyre' => true)), array('alt' => $item['BrandModel']['title']));
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
							<div class="detalProd tyres">
								<a href="<?php echo Router::url($url); ?>"><?php
									echo $item['Product']['size1']; ?> / <?php echo $item['Product']['size2']; ?> R<?php echo $item['Product']['size3']; ?> <?php echo h($item['Product']['f1'] . $item['Product']['f2']);
								?></a>
							</div>
						</div>
						<div class="priceMore tyres">
							<span><?php
								if ($this->Frontend->canShowTyrePrice($item['Product']['auto'], $item['Product']['not_show_price'])) {
									echo $this->Frontend->getPrice($item['Product']['price'], 'tyres', array('between' => '&nbsp;<span>', 'after' => '</span>'));
								}
								?></span>
							<div class="namber tyres">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->Frontend->getStockCount($item['Product']['stock_count']); ?> шт.</div>
						</div>
						<div class="clear"></div>
					<?php } elseif ($mode == 'list') { ?>
						<div class="prodImg2 floatl">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td>
										<?php
											$image = $this->Html->image('no-tyre-little.jpg', array('class' => 'no-img-tyre'));
											$image_big = false;
											if (!empty($item['BrandModel']['filename'])) {
												$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 117, 'height' => 113, 'crop' => false, 'folder' => false, 'tyre' => true)), array('alt' => $item['BrandModel']['title']));
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
							<?php
								$link_filter = array('model_id' => $item['BrandModel']['id']);
								echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter), array('escape' => false, 'class' => 'title-link'));
							?>
							<table cellpadding="0" cellspacing="0" class="table-box-list">
								<col width="180">
								<col width="50">
								<col width="231">
								<col width="16">
								<col width="61">
								<col width="171">
								<col width="121">
								<col width="132">
								<tr>
									<td><?php
										echo $item['Product']['size1']; ?> / <?php echo $item['Product']['size2']; ?> R<?php echo $item['Product']['size3'];
									?></td>
									<td><?php echo h($item['Product']['f1'] . $item['Product']['f2']); ?></td>
									<td><?php echo $this->Frontend->getFF($item['Product']['f1'], $item['Product']['f2']); ?></td>
									<td>
										<div class="productSeason<?php if ($item['Product']['season']=='winter') {echo '2';} elseif ($item['Product']['season']=='all') {echo '3';}?>" title="<?php echo $seasons[$item['Product']['season']];?>"><?php echo $seasons[$item['Product']['season']];?></div>
									</td>
									<td><?php echo $item['Product']['stud'] ? '<img src="/img/icons/studded.png" alt="шипованная" />' : ''; ?></td>
									<td><strong><?php
										if ($this->Frontend->canShowTyrePrice($item['Product']['auto'], $item['Product']['not_show_price'])) {
											echo $this->Frontend->getPrice($item['Product']['price'], 'tyres');
										}
									?></strong></td>
									<td><?php echo $this->Frontend->getStockCount($item['Product']['stock_count']); ?> шт.</td>
									<td align="right"><?php
										echo $this->Html->link('подробнее', array('controller' => 'tyres', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product']['id'], '?' => $filter), array('escape' => false, 'class' => 'btVer2'));
									?></td>
								</tr>
							</table>
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
						<tr class="no-more-info season-<?php echo $item['Product']['season']; ?> <?php echo $class; ?>">
							<td class="a-center"><?php
								$image = $this->Html->image('img-detal.jpg');
								if (!empty($item['BrandModel']['filename'])) {
									$image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false, 'watermark' => 'wm.png'), array('alt' => $item['BrandModel']['title']));
									echo $this->Html->link($image, $image_big, array('escape' => false, 'class' => 'lightbox', 'id' => $item['BrandModel']['id']));
								}
							?></td>
							<td><?php
								echo $item['Product']['size1'] . ' / ' . $item['Product']['size2'] . ' R' . $item['Product']['size3'];
							?></td>
							<td><?php echo h($item['Product']['f1'] . $item['Product']['f2']); ?></td>
							<td><?php echo $item['Brand']['title']; ?></td>
							<td><?php
								$link_filter = array('model_id' => $item['BrandModel']['id']);
								echo $this->Html->link($item['BrandModel']['title'], array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter), array('escape' => false));
							?></td>
							<td><div class="productSeason<?php if ($item['Product']['season']=='winter') {echo '2';} elseif ($item['Product']['season']=='all') {echo '3';}?>" title="<?php echo $seasons[$item['Product']['season']];?>"><?php echo $seasons[$item['Product']['season']];?></div></td>
							<td><?php echo $item['Product']['stud'] ? '<img src="/img/icons/studded.png" alt="шипованная" />' : ''; ?></td>
							<td><?php echo $this->Frontend->getStockCount($item['Product']['stock_count']); ?> шт.</td>
							<td class="price"><strong><?php
								if ($this->Frontend->canShowTyrePrice($item['Product']['auto'], $item['Product']['not_show_price'])) {
									echo $this->Frontend->getPrice($item['Product']['price'], 'tyres');
								}
							?></strong></td>
							<td><?php
								echo $this->Html->link('подробнее', array('controller' => 'tyres', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product']['id'], '?' => $filter), array('escape' => false, 'class' => 'btVer2'));
							?></td>
						</tr>
					<?php } ?>
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