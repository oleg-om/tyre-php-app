<?php echo $this->element('currency', array('class' => 'bpad')); ?>
<div class="prodBigImg">
	<?php
		$image_small = $this->Html->image('no-disk-big.jpg');
		$image_big = '/img/tyre.jpg';
		if (!empty($product['BrandModel']['filename'])) {
			$image_small = $this->Html->image($this->Backend->thumbnail(array('id' => $product['BrandModel']['id'], 'filename' => $product['BrandModel']['filename'], 'path' => 'models', 'width' => 315, 'height' => 1000, 'crop' => false, 'folder' => false)), array('alt' => $product['BrandModel']['title']));
			$image_big = $this->Backend->thumbnail(array('id' => $product['BrandModel']['id'], 'filename' => $product['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 601, 'crop' => false, 'folder' => false), array('alt' => $product['BrandModel']['title']));

		}
		echo $this->Html->link($image_small, $image_big, array('escape' => false, 'class' => 'lightbox', 'title' => $brand['Brand']['title']. ' '. $product['BrandModel']['title']));
	?>
</div>
<div class="infoProdBig">
	<div class="boxLeftInfo">
		<h2><?php echo $brand['Brand']['title']. ' <span>'. $product['BrandModel']['title']; ?></span></h2>
		<div class="clear"></div>
		<div class="tableProd">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th>Размер</th>
					<td><?php echo $product['Product']['size1']; ?> <?php echo $product['Product']['size2']; ?></td>
				</tr>
				<tr>
					<th>Ширина</th>
					<td><?php echo $product['Product']['size3']; ?></td>
				</tr>
				<tr>
					<th>Вылет</th>
					<td><?php echo h($product['Product']['et']); ?></td>
				</tr>
				<tr>
					<th>Ступица</th>
					<td><?php echo $product['Product']['hub']; ?></td>
				</tr>
				<tr>
					<th>Цвет</th>
					<td><?php echo $product['Product']['color']; ?></td>
				</tr>
				<tr>
					<th>Тип</th>
					<td><?php echo !empty($product['BrandModel']['material']) ? $all_materials[$product['BrandModel']['material']] : ''; ?></td>
				</tr>
				<tr>
					<th>Количество</th>
					<td><?php echo $this->Frontend->getStockCount($product['Product']['stock_count']); ?></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="boxRightInfo">
		<?php if ($this->Frontend->canShowDiskPrice($product['Product']['not_show_price'])) { ?>
		<div class="boxPriceProd">
			<em>цена:</em>
			<span><?php echo $this->Frontend->getPrice($product['Product']['price'], 'disks', array('after' => '</strong>', 'between' => ' <strong>')); ?></span>
			<div class="clear"></div>
			<div class="add-to-cart"><?php echo $this->element('add_to_cart'); ?></div>
			<div class="buy-button">
				<a href="javascript:void(0);" class="btVer2" onclick="buy();">Купить</a>
			</div>
			<div class="clear"></div>
		</div>
		<?php } ?>
		<div class="orderCall">
			<h3>Заказать по телефону:</h3>
			<span>(06561) 5-63-43</span>
			<span>(050) 655-15-08</span> 
		</div>
	</div>
	<div class="clear"></div>
	<div class="textProd">
		<?php $content = trim(strip_tags($product['BrandModel']['content'])); ?>
		<?php if (!empty($content)) { ?>
		<h3>Описание:</h3>
		<?php echo $product['BrandModel']['content']; ?>
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