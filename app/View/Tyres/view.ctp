<?php echo $this->element('currency', array('class' => 'bpad')); ?>
<div class="product__wrapper">
<div class="prodBigImg">
	<?php
		$image_small = $this->Html->image('no-tyre-big.jpg');
		$image_big = '/img/tyre.jpg';
		if (!empty($product['BrandModel']['filename'])) {
			$image_small = $this->Html->image($this->Backend->thumbnail(array('id' => $product['BrandModel']['id'], 'filename' => $product['BrandModel']['filename'], 'path' => 'models', 'width' => 400, 'height' => 1000, 'crop' => false, 'folder' => false)), array('alt' => $product['BrandModel']['title']));
			$image_big = $this->Backend->thumbnail(array('id' => $product['BrandModel']['id'], 'filename' => $product['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false, 'watermark' => 'wm.png'), array('alt' => $product['BrandModel']['title']));

		}
		echo $this->Html->link($image_small, $image_big, array('escape' => false, 'class' => 'lightbox', 'title' => $brand['Brand']['title']. ' '. $product['BrandModel']['title']));
	?>
</div>
<div class="infoProdBig">
	<div class="boxLeftInfo">
		<h2><?php echo $brand['Brand']['title']. ' <span>'. $product['BrandModel']['title']; ?></span></h2>
		<?php
			$season = $product['Product']['season'];
			if (!empty($product['BrandModel']['season'])) {
				$season = $product['BrandModel']['season'];
			}
			$car_auto = $product['Product']['auto'];
			if (!empty($product['BrandModel']['auto'])) {
				$car_auto = $product['BrandModel']['auto'];
			}
		?>
		<div class="productSeason<?php if ($season=='winter') {echo '2';} elseif ($season=='all') {echo '3';}?>" title="<?php echo $seasons[$season];?>"><?php echo $seasons[$season];?></div>
		<div class="stud"><?php echo $product['Product']['stud'] ? '<img src="/img/icons/studded.png" alt="шипованная" />' : ''; ?></div>
		<div class="clear"></div>
		<div class="tableProd">
			<table cellpadding="0" cellspacing="0">
				<col width="250">
				<col width="190">
				<tr>
					<th>Типоразмер</th>
					<td><?php echo $product['Product']['size1']; ?> / <?php echo $product['Product']['size2']; ?> R<?php echo $product['Product']['size3']; ?></td>
				</tr>
				<tr>
					<th>Индекс скорости / нагрузки</th>
					<td><?php echo h($product['Product']['f1'] . $product['Product']['f2']) . $this->Frontend->getFF($product['Product']['f1'], $product['Product']['f2']); ?></td>
				</tr>
				<tr>
					<th>Тип автомобиля</th>
					<td>
						<?php echo $auto[$car_auto]; ?>
					</td>
				</tr>
				<tr>
					<th>Сезонность</th>
					<td><?php echo $seasons[$season];?></td>
				</tr>
                <tr>
                    <th>RUN FLAT</th>
                    <td><?php if ($product['Product']['p5'] == 1) { echo 'Да'; } else { echo 'Нет'; } ?></td>
                </tr>
                <tr>
                    <th>XL (Extra Load)</th>
                    <td><?php if ($product['Product']['p4'] == 1) { echo 'Да'; } else { echo 'Нет'; } ?></td>
                </tr>
				<tr>
					<th>Наличие</th>
					<td><?php echo $this->Frontend->getStockCount($product['Product']['stock_count']); ?> шт.</td>
				</tr>
			</table>

		</div>
	</div>
    <div class="product__info-instock my-1">
        <?php
        $in_stock_mark = $product['Product']['in_stock'] ? '<img title="в наличии" alt="в наличии" src="/img/yes.png">' : '';
        $in_stock_text = $product['Product']['in_stock'] ? 'В наличии: ' : 'Под заказ: ';
        echo $this->element('stock_places', array('stock_places' => $product['Product'], 'text' => '<div class="namber tyres">'.$in_stock_text.$this->Frontend->getStockCount($product['Product']['stock_count']).' шт. '.$in_stock_mark.'</div>', 'position' => 'right'));
        ?>
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