<?php
if (!isset($has_params)) {
	$has_params = true;
	
}
if (!isset($show_size)) {
	$show_size = true;
}
$show_available = false;
if (!empty($brand['Brand']['slug']) && !$has_params) {
	$show_available = true;
}
$has_no_trucks = false;
foreach ($models as $item) {
	$is_trucks = false;
	if ((!empty($item['BrandModel']['auto']) && $item['BrandModel']['auto'] == 'trucks') || (isset($item['Product'][0]) && $item['Product'][0]['auto'] == 'trucks')) {
		$is_trucks = true;
	}
	if (!$is_trucks) {
		$has_no_trucks = true;
		break;
	}
}
?>
<?php if (!empty($models)) { ?>
	<?php if ($mode == 'block') { ?>
	<div class="border-b border-b-tyres">
	<div class="width-disk" id="product-section">
	<?php } elseif ($mode == 'table') { ?>
	<div class="tab-prod">
		<table cellpadding="0" cellspacing="0">
			<col width="40">
			<col width="240">
			<col width="110">
			<col width="140">
			<col width="250">
			<col />
			<col width="110">
			<col width="61">
			<col width="61">
			<col width="220">
			<tr>
				<th></th>
				<th>Типоразмер</th>
				<th>Ин.</th>
				<th>Бренд</th>
				<th>Модель</th>
				<th></th>
				<th></th>
				<th></th>
				<th>Наличие</th>
				<th>Цена</th>

			</tr>
	<?php } ?>
		<?php $line = 0;foreach ($models as $item) { ?>
			<?php
				$is_trucks = false;
				if ($show_available && ((!empty($item['BrandModel']['auto']) && $item['BrandModel']['auto'] == 'trucks') || (isset($item['Product'][0]) && $item['Product'][0]['auto'] == 'trucks'))) {
					$is_trucks = true;
				}
			?>
			<?php if ($mode == 'block') { ?>
				<?php
					$season = 'summer';
					if (isset($item['Product'][0])) {
						$season = $item['Product'][0]['season'];
					}
					if (!empty($item['BrandModel']['season'])) {
						$season = $item['BrandModel']['season'];
					}
				?>
				<div class="boxList season-<?php echo $season; ?><?php if ($has_params) { ?> with-season<?php } ?> season-<?php echo isset($item['Product'][0]) ? 'yes' : 'no'; ?> season-<?php echo $is_trucks ? 'trucks' : 'cars'; ?>"<?php echo $is_trucks && $has_no_trucks ? ' style="display:none;"' : ''; ?>>
			<?php } elseif ($mode == 'list') { ?>
				<?php
					$season = 'summer';
					if (isset($item['Product'][0])) {
						$season = $item['Product'][0]['season'];
					}
					if (!empty($item['BrandModel']['season'])) {
						$season = $item['BrandModel']['season'];
					}
				?>
				<div class="boxList2 boxList2-new season-<?php echo $season; ?> season-<?php echo isset($item['Product'][0]) ? 'yes' : 'no'; ?> season-<?php echo $is_trucks ? 'trucks' : 'cars'; ?>"<?php echo $is_trucks && $has_no_trucks ? ' style="display:none;"' : ''; ?>>
			<?php } else { ?>
			<?php } ?>
				<?php if ($mode == 'table' || count($item['Product']) == 1 ) { ?>
					<?php
						if ($mode == 'table') {
							$item['Product'][0] = $item['Product'];
						}
					?>
					<?php if ($mode == 'block') { ?>
						<div class="prodImg floatl prodImg-tyres">
							<?php if ($item['BrandModel']['new']) { ?>
							<?php } elseif ($item['BrandModel']['popular']) { ?>
							<div class="action-prod hit"></div>
							<?php } ?>
							<table cellpadding="0" cellspacing="0">
								<tr>
								<?php echo $this->element('tyre_icons', array('product' => $item['Product'][0], 'brandModel' => $item['BrandModel'])); ?>
                                <?php echo $this->element('tyre_season', array('seasons' => $seasons, 'season' => $season, 'item' => $item)); ?>
                                    <?php echo $this->element('truck_axis', array('axis' => $item['Product'][0]['axis'])); ?>
									<td>
										<?php
											$image = $this->Html->image('no-tyre-little.jpg', array('class' => 'no-img-tyre'));
											$image_big = false;
											if (!empty($item['BrandModel']['filename'])) {
												$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 280, 'height' => 320, 'tyre' => true, 'crop' => false, 'folder' => false)), array('alt' => $item['BrandModel']['title']));
												$image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false, 'watermark' => 'wm.png'), array('alt' => $item['BrandModel']['title']));
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
                        <div class="box-info">
                        <?php if ($has_params) { ?>
                            <div class="info-top">
                                <h3>
                                    <?php
                                    $link_filter = array('model_id' => $item['BrandModel']['id']);

                                    echo $this->Html->link('<span class="brand">' . $item['Brand']['title']. '</span><span class="model">'. $item['BrandModel']['title'] . '</span>', array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter), array('escape' => false));
                                    $url = array('controller' => 'tyres', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product'][0]['id']);
                                    ?>
                                </h3>
                                <?php
                                    if ($item['Product'][0]['stock_count'] < 4) {
                                        echo $this->element('stock_out_of_stock', array('item' => $item['Product'][0]));
                                    }
                                ?>
                            </div>
                        <?php } ?>
                            <div class="tyre-block__sizes">
						<div class="infoList">
							<?php if ($show_available) { ?>
								<p class="available"><?php
									if (isset($item['Product'][0])) {
										echo '<img src="/img/plus2.gif" alt="есть в наличии" />';
									}
									else {
										echo '<img src="/img/minus2.gif" alt="нет в наличии" />';
									}
								?></p>
							<?php } ?>
							<?php if (!$has_params) { ?>
								<h3><?php
									$link_filter = array('model_id' => $item['BrandModel']['id']);
									//$link_filter = array_merge($link_filter, $filter);
									echo $this->Html->link('<span class="brand">' . $item['Brand']['title']. '</span><span class="model">'. $item['BrandModel']['title'] . '</span>', array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter), array('escape' => false));
									$url = array('controller' => 'tyres', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product'][0]['id']);
								?></h3>
								<div class="productSeason<?php if ($season=='winter') {echo '2';} elseif ($season=='all') {echo '3';}?>" title="<?php echo $seasons[$season];?>">
									<?php echo $seasons[$season];?>
								</div>
							<?php } ?>
							<?php if ($show_size || $has_params) { ?>
							<div class="detalProd tyres">
								<a href="<?php echo Router::url($url); ?>"><?php
									echo $item['Product'][0]['size1']; ?> / <?php echo $item['Product'][0]['size2']; ?> R<?php echo $item['Product'][0]['size3']; ?> <?php echo h($item['Product'][0]['f1'] . $item['Product'][0]['f2']);
								?></a>
							</div>
							<?php } ?>
						</div>
                                <?php
                                $in_stock_mark = $item['Product'][0]['in_stock'] ? '<img title="в наличии" alt="в наличии" src="/img/yes.png">' : '';
                                if ($item['Product'][0]['in_stock'] == 1) {
                                    echo $this->element('stock_places', array('stock_places' => $item['Product'][0], 'text' => '<div class="namber tyres">' . $this->Frontend->getStockCount($item['Product'][0]['stock_count']) . ' шт. ' . $in_stock_mark . '</div>', 'position' => 'left'));
                                } else {
                                    echo $this->element('stock_out_of_stock', array('item' => $item['Product'][0], 'original_stock' => true, 'hide_icon' => true));
                                }
                                ?>
                        </div>
                        <div class="product__info">
						<div class="priceMore tyres">
							<?php if ($this->Frontend->canShowTyrePrice($item['Product'][0]['auto'], $item['Product'][0]['not_show_price']) && ($show_size || $has_params)) { ?>
							<span><?php echo $this->Frontend->getPrice($item['Product'][0]['price'], 'tyres', array('between' => '&nbsp;<span>', 'after' => '</span>')); ?></span>

							<?php } ?>
						</div>
                            <div class="buy-button">
                                <a href="javascript:void(0);" class="btVer2" onclick="buy_tyre(<?php echo $item['Product'][0]['id']; ?>);">Купить</a>
                            </div>
                        </div>
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
							<?php
								$link_filter = array('model_id' => $item['BrandModel']['id']);
								//$link_filter = array_merge($link_filter, $filter);
								echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter), array('escape' => false, 'class' => 'title-link'));
							?>
							<table cellpadding="0" cellspacing="0" class="table-box-list">
								<col width="180">
								<col width="50">
								<col width="231" class="desc-col">
								<col width="16">
								<col width="61" class="desc-col">
								<col width="171">
								<col class="desc-col" />
								<col width="121" class="desc-col">
								<col width="30">
								<tr onclick="window.location='<?php echo Router::url(array('controller' => 'tyres', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product'][0]['id'], '?' => $filter)); ?>';">
									<td><?php
										echo $item['Product'][0]['size1']; ?> / <?php echo $item['Product'][0]['size2']; ?> R<?php echo $item['Product'][0]['size3'];
									?></td>
									<td><?php echo h($item['Product'][0]['f1'] . $item['Product'][0]['f2']); ?></td>
									<td class="desc-table"><?php echo $this->Frontend->getFF($item['Product'][0]['f1'], $item['Product'][0]['f2']); ?></td>
									<td>
										<div class="productSeason<?php if ($season=='winter') {echo '2';} elseif ($season=='all') {echo '3';}?>" title="<?php echo $seasons[$season];?>"><?php echo $seasons[$season];?></div>
									</td>
									<td class="desc-table"><?php echo $item['Product'][0]['stud'] ? '<img src="/img/icons/studded.png" alt="шипованная" width="18" height="18" />' : ''; ?></td>
									<td><strong><?php
										if ($this->Frontend->canShowTyrePrice($item['Product'][0]['auto'], $item['Product'][0]['not_show_price'])) {
											echo $this->Frontend->getPrice($item['Product'][0]['price'], 'tyres', array('delimiter' => '<br />'));
										}
									?></strong></td>
									<td class="desc-table"><?php if ($item['Product'][0]['sale']) { ?><div class="action-prod-list"><span>акция</span></div><?php } ?></td>
									<td class="desc-table"><?php echo $this->Frontend->getStockCount($item['Product'][0]['stock_count']); ?> шт.</td>
									<td><?php echo $item['Product'][0]['in_stock'] ? '<img title="в наличии" alt="в наличии" src="/img/yes.png">' : ''; ?></td>
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
						<?php
							$season = $item['Product'][0]['season'];
							if (!empty($item['BrandModel']['season'])) {
								$season = $item['BrandModel']['season'];
							}
						?>
						<tr class="no-more-info season-<?php echo $season; ?> <?php echo $class; ?> season-<?php echo isset($item['Product'][0]) ? 'yes' : 'no'; ?> season-<?php echo $is_trucks ? 'trucks' : 'cars'; ?>" onclick="window.location='<?php echo Router::url(array('controller' => 'tyres', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product'][0]['id'], '?' => $filter)); ?>';"<?php echo $is_trucks && $has_no_trucks ? ' style="display:none;"' : ''; ?>>
							<td class="a-center"><?php
								$image = $this->Html->image('img-detal.jpg');
								if (!empty($item['BrandModel']['filename'])) {
									$image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false, 'watermark' => 'wm.png'), array('alt' => $item['BrandModel']['title']));
									echo $this->Html->link($image, $image_big, array('escape' => false, 'class' => 'lightbox rel-box', 'id' => $item['BrandModel']['id']));
								}
							?></td>
							<td><?php
								echo $item['Product'][0]['size1'] . ' / ' . $item['Product'][0]['size2'] . ' R' . $item['Product'][0]['size3'];
							?></td>
							<td><?php echo h($item['Product'][0]['f1'] . $item['Product'][0]['f2']); ?></td>
							<td><?php echo $item['Brand']['title']; ?></td>
							<td><?php
								$link_filter = array('model_id' => $item['BrandModel']['id']);
								echo $this->Html->link($item['BrandModel']['title'], array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter), array('escape' => false));
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
							<td><div class="productSeason<?php if ($season=='winter') {echo '2';} elseif ($season=='all') {echo '3';}?>" title="<?php echo $seasons[$season];?>"><?php echo $seasons[$season];?></div></td>
							<td><?php echo $item['Product'][0]['stud'] ? '<img src="/img/icons/studded.png" alt="шипованная" width="15" height="15" />' : ''; ?></td>
							<td><?php echo $this->Frontend->getStockCount($item['Product'][0]['stock_count']); ?> шт.</td>
							<td class="price"><strong><?php
								if ($this->Frontend->canShowTyrePrice($item['Product'][0]['auto'], $item['Product'][0]['not_show_price'])) {
									echo $this->Frontend->getPrice($item['Product'][0]['price'], 'tyres');
								}
							?></strong></td>
						</tr>
					<?php } ?>
				<?php } else {
					if (isset($item['Product'][0])) {
						$results = Hash::extract($item, 'Product.{n}.price');
						$min_price = min($results);
						$max_price = max($results);
						$results = Hash::extract($item, 'Product.{n}.size3');//диаметр
						$min_d = min($results);
						$max_d = max($results);
					}
					else {
						$min_price = 0;
						$max_price = 0;
						$min_d = 0;
						$max_d = 0;
					}
					?>
					<?php if ($mode == 'block') { ?>
						<div class="prodImg floatl prodImg-tyres">
                            <?php if ($item['BrandModel']['new']) { ?>
                            <?php } elseif ($item['BrandModel']['popular']) { ?>
                            <?php } ?>
							<table cellpadding="0" cellspacing="0">
								<tr>
                                    <?php echo $this->element('tyre_model_icons', array('item' => $item)); ?>
                                    <?php echo $this->element('tyre_season', array('seasons' => $seasons, 'season' => $season, 'item' => $item)); ?>
                                    <?php echo $this->element('truck_axis', array('axis' => $item['Product'][0]['axis'])); ?>
									<td>
										<?php
											$image = $this->Html->image('no-tyre-little.jpg', array('class' => 'no-img-tyre'));
											$image_big = false;
											if (!empty($item['BrandModel']['filename'])) {
												$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 280, 'height' => 320, 'tyre' => true, 'crop' => false, 'folder' => false)), array('alt' => $item['BrandModel']['title']));
												$image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false, 'watermark' => 'wm.png'), array('alt' => $item['BrandModel']['title']));
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
                        <div class="box-info">
                        <?php if ($has_params) { ?>
                            <div class="info-top">
                                <h3>
                                    <?php
                                    $link_filter = array('model_id' => $item['BrandModel']['id']);
                                    //$link_filter = array_merge($link_filter, $filter);
                                    echo $this->Html->link('<span class="brand">' . $item['Brand']['title']. '</span><span class="model">'. $item['BrandModel']['title'] . '</span>', array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter), array('escape' => false));
                                    ?>
                                </h3>
                            </div>
                        <?php } ?>
						<div class="infoList">
							<?php if ($show_available) { ?>
								<p class="available"><?php
									if (isset($item['Product'][0])) {
										echo '<img src="/img/plus2.gif" alt="есть в наличии" />';
									}
									else {
										echo '<img src="/img/minus2.gif" alt="нет в наличии" />';
									}
								?></p>
							<?php } ?>
							<?php if (!$has_params) { ?>
								<h3><?php
									$link_filter = array('model_id' => $item['BrandModel']['id']);
									//$link_filter = array_merge($link_filter, $filter);
									echo $this->Html->link('<span class="brand">' . $item['Brand']['title']. '</span><span class="model">'. $item['BrandModel']['title'] . '</span>', array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter), array('escape' => false));
								?></h3>
								<div class="productSeason<?php if ($season=='winter') {echo '2';} elseif ($season=='all') {echo '3';}?>" title="<?php echo $seasons[$season];?>"><?php echo $seasons[$season];?></div>
								<?php if (isset($item['Product'][0])) { ?>
									<div class="stud"><?php echo $item['Product'][0]['stud'] ? '<img src="/img/icons/studded.png" alt="шипованная" />' : ''; ?></div>
								<?php } ?>
							<?php } ?>
							<?php if ($has_params) { ?>
							<div class="detalProd">
								<?php if ($min_d == $max_d) {?>
								<span class="size15">Диаметр:</span> <?php echo $min_d; ?>"
								<?php } else { ?>
								<span class="size15">Диаметры:</span> от <?php echo $min_d; ?>" до <?php echo $max_d; ?>"
								<?php } ?>
							</div>
							<?php } ?>
						</div>
						<div class="priceMore priceMore-range">
							<?php if ($this->Frontend->canShowTyrePrice($item['Product'][0]['auto'], $item['Product'][0]['not_show_price']) && ($show_size || $has_params)) { ?>
							<em>от</em> <span><?php echo $this->Frontend->getPrice($min_price, 'tyres', array('between' => '&nbsp;<span>', 'after' => '</span>')); ?></span>
							<?php } ?>
							
						</div>
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
							<?php
								$link_filter = array('model_id' => $item['BrandModel']['id']);
								//$link_filter = array_merge($link_filter, $filter);
								echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => $link_filter), array('escape' => false, 'class' => 'title-link'));
							?>
							<?php if (empty($item['Product'])) { ?>
								Нет в наличии
							<?php } ?>
							<table cellpadding="0" cellspacing="0" class="table-box-list">
								<col width="180">
								<col width="50">
								<col width="231" class="desc-col">
								<col width="16">
								<col width="61" class="desc-col">
								<col width="171">
								<col class="desc-col" />
								<col width="121" class="desc-col">
								<col width="30">
								<?php foreach ($item['Product'] as $product) { ?>
									<?php
										$season = $product['season'];
										if (!empty($item['BrandModel']['season'])) {
											$season = $item['BrandModel']['season'];
										}
									?>
								<tr onclick="window.location='<?php echo Router::url(array('controller' => 'tyres', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $product['id'])); ?>'">
									<td><?php echo $product['size1']; ?> / <?php echo $product['size2']; ?> R<?php echo $product['size3']; ?></td>
									<td><?php echo h($product['f1'] . $product['f2']); ?></td>
									<td class="desc-table"><?php echo $this->Frontend->getFF($product['f1'], $product['f2']); ?></td>
									<td>
										<div class="productSeason<?php if ($season=='winter') {echo '2';} elseif ($season=='all') {echo '3';}?>" title="<?php echo $seasons[$season];?>"><?php echo $seasons[$season];?></div>
									</td>
									<td class="desc-table"><?php echo $product['stud'] ? '<img src="/img/icons/studded.png" alt="шиповання" />' : ''; ?></td>
									<td><strong><?php
										if ($this->Frontend->canShowTyrePrice($product['auto'], $product['not_show_price'])) {
											echo $this->Frontend->getPrice($product['price'], 'tyres', array('delimiter' => '<br />'));
										}
									?></strong></td>
									<td class="desc-table">
										<?php if ($product['sale']) { ?>
											<div class="action-prod-list"><span>акция</span></div>
										<?php } ?>
									</td>
									<td class="desc-table"><?php echo $this->Frontend->getStockCount($product['stock_count']); ?> шт.</td>
									<td><?php echo $product['in_stock'] ? '<img title="в наличии" alt="в наличии" src="/img/yes.png">' : ''; ?></td>
								</tr>
								<?php } ?>
							</table>
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
							<?php
								$season = $product['season'];
								if (!empty($item['BrandModel']['season'])) {
									$season = $item['BrandModel']['season'];
								}
							?>
							<tr class="no-more-info season-<?php echo $season; ?> <?php echo $class; ?> season-<?php echo isset($item['Product'][0]) ? 'yes' : 'no'; ?> season-<?php echo $is_trucks ? 'trucks' : 'cars'; ?>" onclick="window.location='<?php echo Router::url(array('controller' => 'tyres', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $product['id'], '?' => $filter)); ?>'"<?php echo $is_trucks && $has_no_trucks ? ' style="display:none;"' : ''; ?>>
								<td class="a-center"><?php
									if (!empty($item['BrandModel']['filename'])) {
										$image = $this->Html->image('img-detal.jpg');
										$image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false, 'watermark' => 'wm.png'), array('alt' => $item['BrandModel']['title']));
										echo $this->Html->link($image, $image_big, array('escape' => false, 'class' => 'lightbox rel-box', 'id' => $item['BrandModel']['id']));
									}
								?></td>
								<td><?php
									echo $product['size1'] . ' / ' . $product['size2'] . ' R' . $product['size3'];
								?></td>
								<td><?php echo h($product['f1'] . $product['f2']); ?></td>
								<td><?php echo $item['Brand']['title']; ?></td>
								<td><?php
									$model_filter = $filter;
									unset($model_filter['mode']);
									echo $this->Html->link($item['BrandModel']['title'], array('controller' => 'tyres', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $product['id'], '?' => $model_filter), array('escape' => false));
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
								<td><div class="productSeason<?php if ($season=='winter') {echo '2';} elseif ($season=='all') {echo '3';}?>" title="<?php echo $seasons[$season];?>"><?php echo $seasons[$season];?></div></td>
								<td><?php echo $product['stud'] ? '<img src="/img/icons/studded.png" alt="шиповання" />' : ''; ?></td>
								<td><?php echo $this->Frontend->getStockCount($product['stock_count']); ?> шт.</td>
								<td class="price"><strong><?php
									if ($this->Frontend->canShowTyrePrice($product['auto'], $product['not_show_price'])) {
										echo $this->Frontend->getPrice($product['price'], 'tyres');
									}
								?></strong></td>
							</tr>
						<?php } ?>
					<?php } ?>
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


<script type="text/javascript">
 function buy_tyre(itemId) {
  open_popup({
		url: '/cart',
		type: 'post',
		data: {
			'data[Product][0][count]': 4,
			'data[Product][0][product_id]': itemId
		},
	});
} 
</script>