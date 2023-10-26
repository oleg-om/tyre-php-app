<div class="block-home">
	<?php echo $this->element('currency'); ?>
	<?php if (!empty($new)) { ?>
	<div class="boxHome">
		<h2>Новинки</h2>
		<?php foreach ($new as $item) { 
			$results = Hash::extract($item, 'Product.{n}.price');
			if(!empty($results)):
			$min_price = min($results);
			$max_price = max($results);
			$results = Hash::extract($item, 'Product.{n}.size3');//диаметр
			$min_d = min($results);
			$max_d = max($results);
			?>
		<div class="prodBox">
			<div class="prodImg">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<?php
								$image = '';
								if (!empty($item['BrandModel']['filename'])) {
									$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 158, 'height' => 158, 'crop' => false, 'folder' => false, 'tyre' => true)), array('alt' => $item['BrandModel']['title']));
								}
								echo $this->Html->link($image, array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
							?>
						</td>
					</tr>
				</table>
			</div>
			<div class="linkProd"><?php
				echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
			?></div>
			<div class="prodBoxPopup">
				<div class="prodBox">
					<div class="prodImg">
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<?php
										$image = '';
										if (!empty($item['BrandModel']['filename'])) {
											$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 158, 'height' => 158, 'crop' => false, 'folder' => false, 'tyre' => true)), array('alt' => $item['BrandModel']['title']));
										}
										echo $this->Html->link($image, array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
									?>
								</td>
							</tr>
						</table>
					</div>
					<div class="linkProd"><?php
						echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
					?></div>
					<?php
						$season = $item['Product'][0]['season'];
						if (!empty($item['BrandModel']['season'])) {
							$season = $item['BrandModel']['season'];
						}
					?>
					<div class="productSeason<?php if ($season=='winter') {echo '2';} elseif ($season=='all') {echo '3';}?>" title="<?php echo $seasons[$season];?>">
						<?php echo $seasons[$season];?>
					</div>
					<?php if ($this->Frontend->canShowTyrePrice($item['Product'][0]['auto'], $item['Product'][0]['not_show_price'])) { ?>
					<div class="priceProd">
						<span>Цена:</span>
						<strong><?php
							echo $this->Frontend->getPriceRange($min_price, $max_price, 'tyres');
						?></strong>
					</div>
					<?php } ?>
					<div class="infoProd">
						<span>Диаметры:</span>
						<span>от <?php echo $min_d; ?>" до <?php echo $max_d; ?>"</span>
					</div>
					<?php
						echo $this->Html->link('подробнее', array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false, 'class' => 'moreProd'));
					?>
				</div>
			</div>
		</div>
		<?php 
		//else:
			//echo"нет результата!!!";
		endif;
		
		} ?>
		<div class="clear"></div>
	</div>
	<?php 
	
	
	} ?>
	<?php if (!empty($popular)) { ?>
	<div class="boxHome">
		<h2>Популярные модели шин</h2>
		<?php foreach ($popular as $item) {
		$results = Hash::extract($item, 'Product.{n}.price');
		//print_r($results);
		if(!empty($results)):
		$min_price = min($results);
		$max_price = max($results);
		$results = Hash::extract($item, 'Product.{n}.size3');//диаметр
		$min_d = min($results);
		$max_d = max($results);
		?>
		<div class="prodBox">
			<div class="prodImg">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<?php
								$image = '';
								if (!empty($item['BrandModel']['filename'])) {
									$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 158, 'height' => 158, 'crop' => false, 'folder' => false, 'tyre' => true)), array('alt' => $item['BrandModel']['title']));
								}
								echo $this->Html->link($image, array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
							?>
						</td>
					</tr>
				</table>
			</div>
			<div class="linkProd">
				<?php
					echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
				?>
			</div>
			<div class="prodBoxPopup">
				<div class="prodBox">
					<div class="prodImg">
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<?php
										$image = '';
										if (!empty($item['BrandModel']['filename'])) {
											$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 158, 'height' => 158, 'crop' => false, 'folder' => false, 'tyre' => true)), array('alt' => $item['BrandModel']['title']));
										}
										echo $this->Html->link($image, array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
									?>
								</td>
							</tr>
						</table>
					</div>
					<div class="linkProd">
						<?php
							echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
						?>
					</div>
					<?php
						$season = $item['Product'][0]['season'];
						if (!empty($item['BrandModel']['season'])) {
							$season = $item['BrandModel']['season'];
						}
					?>
					<div class="productSeason<?php if ($season=='winter') {echo '2';} elseif ($season=='all') {echo '3';}?>" title="<?php echo $seasons[$season];?>">
						<?php echo $seasons[$season];?>
					</div>
					<?php if ($this->Frontend->canShowTyrePrice($item['Product'][0]['auto'], $item['Product'][0]['not_show_price'])) { ?>
					<div class="priceProd">
						<span>Цена:</span>
						<strong><?php
							if ($min_price == $max_price) {
								echo $this->Frontend->getPrice($min_price, 'tyres');
							}
							else {
								echo $this->Frontend->getPriceRange($min_price, $max_price, 'tyres');
							}
						?></strong>
					</div>
					<?php } ?>
					<div class="infoProd">
						<span>Диаметры:</span>
						<span>от <?php echo $min_d; ?>" до <?php echo $max_d; ?>"</span>
					</div>
					<?php
						echo $this->Html->link('подробнее', array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false, 'class' => 'moreProd'));
					?>
				</div>
			</div>
		</div>
		<?php 
		//else:
			//echo"нет результата!!!";
		endif;

		
		} ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<?php
		if (isset($page)) { 
			echo '<div class="pageText">';
			echo '<h1>' . h($page['Page']['title']) . '</h1>';
			echo $page['Page']['content'];
			echo '</div>';
		}
	?>
</div>
<div class="clear"></div>