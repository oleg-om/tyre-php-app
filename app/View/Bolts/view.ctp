<h2 class="title"><?php echo h($bolt_types[$product['Product']['bolt_type']] . ' ' . $product['Product']['bolt']); ?></h1>
<table border="0" width="100%">
	<tr>
		<td width="240" class="model_image" valign="top"><?php
			$sku = $bolt_types[$product['Product']['bolt_type']] . ' ' . $product['Product']['bolt'];
			$filename = null;
			if (!empty($product['Product']['filename'])) {
				$filename = $product['Product']['filename'];
				$id = $product['Product']['id'];
				$path = 'bolts';
			}
			if (!empty($filename)) {
				echo $this->Html->link($this->Html->image($this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $path, 'width' => 240, 'height' => 1000, 'crop' => false, 'folder' => false)), array('alt' => $sku)), $this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $path, 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false)), array('escape' => false, 'class' => 'lightbox', 'title' => $sku));
			}
			else {
				echo $this->Html->image('no-bolt-240.jpg', array('alt' => $sku));
			}
		?></td>
		<td valign="top">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td class="model_description model_image">
						<table width="100%" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<th class="none_border">Тип:</th>
								<td class="none_border"><?php echo h($bolt_types[$product['Product']['bolt_type']]); ?></td>
							</tr>
							<tr class="tyre_descr_tr">
								<th>Описание:</th>
								<td><?php echo h($product['Product']['bolt']); ?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<?php if ($this->Frontend->canShowBoltPrice($product['Product']['not_show_price'])) { ?>
			<div class="boxPriceProd akb-price-box">
                <div class="boxPriceProd-price">
				<em>цена:</em>
				<span> <?php echo $this->Frontend->getPrice($product['Product']['price'], 'bolts', array('after' => '</strong>', 'between' => ' <strong>')); ?> </span>
                </div>
				<div class="add-to-cart"><?php echo $this->element('add_to_cart'); ?></div>
				<div class="buy-button">
					<a href="javascript:void(0);" class="btVer2" onclick="buy();">Купить</a>
				</div>
				<div class="clear"></div>
			</div>
			<?php } ?>
		</td>
	</tr>
</table>

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