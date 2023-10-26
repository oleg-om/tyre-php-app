<?php echo $this->element('currency'); ?>
<?php if (!empty($new)) { ?>
<div class="boxHome boxHome-disk">
	<h2>Новинки</h2>
	<?php foreach ($new as $item) { 
	$results = Hash::extract($item, 'Product.{n}.price');
	$min_price = min($results);
	$max_price = max($results);
	$results = Hash::extract($item, 'Product.{n}.size1');//диаметр
	$min_d = min($results);
	$max_d = max($results);
		?>

	<div class="prodBox">
		<div class="prodImg">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<?php
							$image = $this->Html->image('no-disk-little.jpg', array('class' => 'no-img-disk'));

							if (!empty($item['BrandModel']['filename'])) {
								$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 182, 'height' => 143, 'crop' => false, 'folder' => false)), array('alt' => $item['BrandModel']['title']));
							}
							echo $this->Html->link($image, array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
						?>
					</td>
				</tr>
			</table>
		</div>
		<div class="linkProd">
			<?php
				echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
			?>
		</div>
		<div class="prodBoxPopup">
			<div class="prodBox">
				<div class="prodImg">
					<table cellpadding="0" cellspacing="0">
						<tr>
							<td>
								<?php
									$image = $this->Html->image('no-disk-little.jpg', array('class' => 'no-img-disk'));
									if (!empty($item['BrandModel']['filename'])) {
										$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 182, 'height' => 143, 'crop' => false, 'folder' => false)), array('alt' => $item['BrandModel']['title']));
									}
									echo $this->Html->link($image, array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
								?>
							</td>
						</tr>
					</table>
				</div>
				<div class="linkProd">
					<?php
						echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
					?>
				</div>
				<div class="priceProd">
					<?php if ($this->Frontend->canShowDiskPrice($item['Product'][0]['not_show_price'])) { ?>
					<span>Цена:</span>
					<strong><?php
						if ($min_price == $max_price) {
							echo $this->Frontend->getPrice($min_price, 'disks');
						}
						else {
							echo $this->Frontend->getPriceRange($min_price, $max_price, 'disks');
						}
					?></strong>
					<?php } ?>
				</div>
				<div class="infoProd">
					<?php if ($min_d == $max_d) {?>
						<span>Диаметр:</span> <?php echo $min_d; ?>"
						<?php } else { ?>
						<span>Диаметры:</span> от <?php echo $min_d; ?>" до <?php echo $max_d; ?>"
					<?php } ?>
				</div>
				<?php
					echo $this->Html->link('подробнее', array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false, 'class' => 'moreProd'));
				?>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="clear"></div>
</div>
<?php } ?>
<?php if (!empty($popular)) { ?>
<div class="boxHome boxHome-disk">
	<h2>Популярные модели дисков</h2>
	<?php foreach ($popular as $item) { 
	$results = Hash::extract($item, 'Product.{n}.price');
	$min_price = min($results);
	$max_price = max($results);
	$results = Hash::extract($item, 'Product.{n}.size1');//диаметр
	$min_d = min($results);
	$max_d = max($results);
		?>
	<div class="prodBox">
		<div class="prodImg">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<?php
							$image = $this->Html->image('no-disk-little.jpg', array('class' => 'no-img-disk'));
							if (!empty($item['BrandModel']['filename'])) {
								$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 182, 'height' => 143, 'crop' => false, 'folder' => false)), array('alt' => $item['BrandModel']['title']));
							}
							echo $this->Html->link($image, array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
						?>
					</td>
				</tr>
			</table>
		</div>
		<div class="linkProd">
			<?php
				echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
			?>
		</div>
		<div class="prodBoxPopup">
			<div class="prodBox">
				<div class="prodImg">
					<table cellpadding="0" cellspacing="0">
						<tr>
							<td>
								<?php
									$$image = $this->Html->image('no-disk-little.jpg', array('class' => 'no-img-disk'));
									if (!empty($item['BrandModel']['filename'])) {
										$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 182, 'height' => 143, 'crop' => false, 'folder' => false)), array('alt' => $item['BrandModel']['title']));
									}
									echo $this->Html->link($image, array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
								?>
							</td>
						</tr>
					</table>
				</div>
				<div class="linkProd">
					<?php
						echo $this->Html->link($item['Brand']['title']. ' '. $item['BrandModel']['title'], array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false));
					?>
				</div>
				<div class="priceProd">
					<?php if ($this->Frontend->canShowDiskPrice($item['Product'][0]['not_show_price'])) { ?>
					<span>Цена:</span>
					<strong><?php
						if ($min_price == $max_price) {
							echo $this->Frontend->getPrice($min_price, 'disks');
						}
						else {
							echo $this->Frontend->getPriceRange($min_price, $max_price, 'disks');
						}
					?></strong>
					<?php } ?>
				</div>
				<div class="infoProd">
					<?php if ($min_d == $max_d) {?>
						<span>Диаметр:</span> <?php echo $min_d; ?>"
						<?php } else { ?>
						<span>Диаметры:</span> от <?php echo $min_d; ?>" до <?php echo $max_d; ?>"
					<?php } ?>
				</div>
				<?php
					echo $this->Html->link('подробнее', array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('model_id' => $item['BrandModel']['id'])), array('escape' => false, 'class' => 'moreProd'));
				?>
			</div>
		</div>
	</div>
	<?php } ?>
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
<div class="clear"></div>