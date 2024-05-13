<div class="product__wrapper">
    <div class="prodBigImg"><?php
        $sku = $brand['Brand']['title'] . ' ' . $product['BrandModel']['title'] . ' ' . $product['Product']['ah'] . 'ач ' . $product['Product']['f1'];
        $filename = null;
        if (!empty($product['Product']['filename'])) {
            $filename = $product['Product']['filename'];
            $id = 'akb_images';
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
        ?></div>
    <div class="infoProdBig">
        <div class="boxLeftInfo">
        <h2><?php echo h($brand['Brand']['title']). ' <span>'. $product['BrandModel']['title']; ?></span></h2>
        </div>
<table border="0" width="100%">
	<tr>

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
					<td><?php echo $product['Product']['height'].' '.$product['Product']['f3']; ?></td>
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
                <tr>
                    <th>Технология изготовления</th>
                    <td><?php echo $product['Product']['color'] ? $product['Product']['color'] : '-'; ?> <?php echo $product['Product']['truck'] ? '<strong>'.$product['Product']['truck'].'</strong>' : ''; ?></td>
                </tr>
                <tr>
                    <th>Страна-производитель</th>
                    <td><?php echo $product['Product']['material'] ? $product['Product']['material'] : '-'; ?></td>
                </tr>
                <tr>
                    <th>Гарантия</th>
                    <td><?php echo $product['Product']['axis']; ?></td>
                </tr>
			</table>
		</td>
	</tr>
</table>
        <div class="product__info-instock my-1">
            <?php
            $in_stock_mark = $product['Product']['in_stock'] ? '<img title="в наличии" alt="в наличии" src="/img/yes.png">' : '';
            $in_stock_text = $product['Product']['in_stock'] ? 'В наличии: ' : 'Под заказ: ';
            echo $this->element('stock_places', array('stock_places' => $product['Product']['stock_places'], 'text' => '<div class="namber tyres">'.$in_stock_text.$this->Frontend->getStockCount($product['Product']['stock_count']).' шт. '.$in_stock_mark.'</div>', 'position' => 'right'));
            ?>
        </div>
        <div class="boxRightInfo">
<?php if ($this->Frontend->canShowAkbPrice($product['Product']['not_show_price'])) { ?>
<div class="boxPriceProd akb-price-box">
    <div class="boxPriceProd-price">
        <?php echo $this->element('akb_price', array('item' => $product)); ?>
	</div>
	<div class="add-to-cart"><?php echo $this->element('add_to_cart'); ?></div>
	<div class="buy-button">
		<a href="javascript:void(0);" class="btVer2" onclick="buy();">Купить</a>
	</div>
	<div class="clear"></div>

</div>
<?php } ?>
        <div class="orderCall">
            <h3>Либо заказать по телефону:</h3>
            <a href="tel:<?php echo CONST_STORAGE_CELLPHONE; ?>"><?php echo CONST_STORAGE_CELLPHONE; ?></a>
        </div>
        </div>
<?php if (!empty($product['BrandModel']['video'])) { ?><div class="video"><?php echo $product['BrandModel']['video']; ?></div><?php } ?>
<div class="infoBox"><?php echo $product['BrandModel']['content']; ?></div>
</div></div>
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