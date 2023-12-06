<table border="0" width="100%">
	<tr>
		<td width="240" class="model_image"><?php
			$sku = $brand['Brand']['title'] . ' ' . $product['BrandModel']['title'] . ' ' . $product['Product']['ah'] . 'ач ' . $product['Product']['f1'];
			$filename = null;
			if (!empty($product['Product']['filename'])) {
				$filename = $product['Product']['filename'];
				$id = $product['Product']['id'];
				$path = 'akb';
			}
			elseif (!empty($product['BrandModel']['filename'])) {
				$filename = $product['BrandModel']['filename'];
				$id = $product['BrandModel']['id'];
				$path = 'models';
			}
			if (!empty($filename)) {
				echo $this->Html->link($this->Html->image($this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $path, 'width' => 240, 'height' => 1000, 'crop' => false, 'folder' => false)), array('alt' => $sku)), $this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $path, 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false)), array('escape' => false, 'class' => 'lightbox', 'title' => $sku));
			}
			else {
				echo $this->Html->image('no-akb-240.jpg', array('alt' => $sku));
			}
		?></td>
		<td>
			<table class="brend" border="0" width="100%">
				<tr>
					<th>Бренд</th>
					<td><?php echo h($brand['Brand']['title']); ?></td>
				</tr>
				<tr>
					<th>Модель</th>
					<td><?php echo h($product['BrandModel']['title']); ?></td>
				</tr>
				<tr>
					<th>Ширина</th>
					<td><?php echo $product['Product']['width']; ?></td>
				</tr>
				<tr>
					<th>Длина</th>
					<td><?php echo $product['Product']['length']; ?></td>
				</tr>
				<tr>
					<th>Высота</th>
					<td><?php echo $product['Product']['height']; ?></td>
				</tr>
				<tr>
					<th>Тип</th>
					<td><?php echo h($product['Product']['f1']); ?></td>
				</tr>
				<tr>
					<th>Полярность</th>
					<td><?php echo h($product['Product']['f2']); ?></td>
				</tr>
				<tr>
					<th>Ah</th>
					<td><?php echo $product['Product']['ah']; ?>ач</td>
				</tr>
				<tr>
					<th>Ток</th>
					<td><?php echo $product['Product']['current']; ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php if ($this->Frontend->canShowAkbPrice($product['Product']['not_show_price'])) { ?>
<div class="boxPriceProd akb-price-box">
    <div class="boxPriceProd-price">
	<em>цена:</em>
	<span> <?php echo $this->Frontend->getPrice($product['Product']['price'], 'akb', array('after' => '</strong>', 'between' => ' <strong>')); ?> </span>
	</div>
	<div class="add-to-cart"><?php echo $this->element('add_to_cart'); ?></div>
	<div class="buy-button">
		<a href="javascript:void(0);" class="btVer2" onclick="buy();">Купить</a>
	</div>
	<div class="clear"></div>
</div>
<?php } ?>
<?php if (!empty($product['BrandModel']['video'])) { ?><div class="video"><?php echo $product['BrandModel']['video']; ?></div><?php } ?>
<div class="infoBox"><?php echo $product['BrandModel']['content']; ?></div>
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