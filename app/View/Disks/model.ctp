<?php echo $this->element('currency', array('class' => 'bpad')); ?>
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

		<table cellpadding="0" cellspacing="0">
			<tr>
				<th>Размер</th>
				<th>Ширина</th>
				<th>Вылет</th>
				<th>Ступица</th>
				<th>Цвет</th>
				<th>Кол.</th>
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
				<td><?php echo $this->Frontend->getStockCount($product['stock_count']); ?></td>
				<td><strong><?php
					if ($this->Frontend->canShowDiskPrice($product['not_show_price'])) {
						echo $this->Frontend->getPrice($product['price'], 'disks');
					}
				?></strong></td>
				<td><?php
					echo $this->Html->link('купить', array('controller' => 'disks', 'action' => 'view', 'slug' => $model['Brand']['slug'], 'id' => $product['id']), array('escape' => false, 'class' => 'btVer2'));
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
<script type="text/javascript">
<!--
$(function(){
	$('.lightbox').lightBox({
		imageLoading: '/img/lightbox-ico-loading.gif',
		imageBtnPrev: '/img/lightbox-btn-prev.gif',
		imageBtnNext: '/img/lightbox-btn-next.gif',
		imageBtnClose: '/img/lightbox-btn-close.gif',
		imageBlank: '/img/lightbox-blank.gif'
	});
});
//-->
</script>