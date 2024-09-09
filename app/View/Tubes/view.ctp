<div class="product__wrapper">
    <div class="prodBigImg"><?php
        $filename = null;

        $default_image = 'default-tube-preview.jpg';
        if ($product['Product']['type'] == 'flap') {
            $default_image = 'default-flap-preview.jpg';
        }

        if (!empty($filename)) {
            echo $this->Html->link($this->Html->image($this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $path, 'width' => 240, 'height' => 1000, 'crop' => false, 'folder' => false)), array('alt' => $sku)), $this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $path, 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false)), array('escape' => false, 'class' => 'lightbox', 'title' => $sku));
        }
        else {
            echo $this->Html->image($default_image, array('alt' => $product['Product']['sku']));
        }
        ?></div>
    <div class="infoProdBig">
        <div class="boxLeftInfo">
            <h2><?php echo h($product['Product']['sku']); ?></span></h2>
        </div>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="model_description model_image">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<th class="none_border">Тип:</th>
					<td class="none_border"><?php echo h($types[$product['Product']['type']]); ?></td>
				</tr>
				<tr class="tyre_descr_tr">
					<th>Размеры и описание:</th>
					<td><?php echo h($product['Product']['sku']); ?></td>
				</tr>
				<?php if ($this->Frontend->canShowTubePrice($product['Product']['not_show_price'])) { ?>
				<tr>
					<th>Цена:</th>
					<td><div style="font-weight: bold; font-size: 1.2em; color:#E21;"><?php echo $this->Frontend->getPrice($product['Product']['price'], 'tubes'); ?></div></td>
				</tr>
				<?php } ?>
			</table>
		</td>
	</tr>
</table>


    <div class="product__info-instock my-1">
        <?php
        $in_stock_mark =  '<img title="в наличии" alt="в наличии" src="/img/yes.png">';
        $in_stock_text = 'В наличии: ';
        if ($product['Product']['in_stock'] == 1)
            echo $this->element('stock_places', array('stock_places' => $product['Product'], 'text' => '<div class="namber tyres">'.$in_stock_text.$this->Frontend->getStockCount($product['Product']['stock_count']).' шт. '.$in_stock_mark.'</div>', 'position' => 'right'));
        ?>
        <?php
        $stock_out_of_stock_params = array('item' => $product['Product'], 'prefix' => ' | под заказ: ');
        if ($product['Product']['in_stock'] != 1) {
            $stock_out_of_stock_params['original_stock'] = true;
            $stock_out_of_stock_params['prefix'] = ' под заказ: ';
        }
        if ($product['Product']['stock_count'] < 4 || $product['Product']['in_stock'] == 0) {
            echo $this->element('stock_out_of_stock', $stock_out_of_stock_params); } ?>
    </div>
    <div class="boxRightInfo">
        <?php if ($this->Frontend->canShowTyrePrice($product['Product']['auto'], $product['Product']['not_show_price'])) { ?>
            <div class="boxPriceProd">
                <div class="boxPriceProd-price">
                    <em>цена:</em>
                    <span> <?php echo $this->Frontend->getPrice($product['Product']['price'], 'tyres', array('after' => '</strong>', 'between' => ' <strong>')); ?> </span>
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
        <div class="clear"></div>
    </div>
    </div>
    </div>