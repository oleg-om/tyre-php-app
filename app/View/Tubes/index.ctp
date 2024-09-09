<?php if ($active_menu != 'truck-tubes') { ?><h2 class="title">Автокамеры и обводные ленты</h2><?php } ?>
<?php
$this->Paginator->options(array('url' => array('controller' => 'tubes', 'action' => 'index', '?' => $filter)));
?>
<?php if ($active_menu == 'truck-tubes') echo $this->element('truck_switch'); ?>
<?php
echo $this->element('mode_selector', array('url' => $url, 'hide_list' => true));
?>
<?php if ($mode == 'table') { ?>
<div id="vmMainPage">
	<table border="0" width="100%" cellspacing="0" cellpadding="0" class="sectiontableheader sectiontableentry1">
		<tr class="rowTint1">
			<th>Тип</th>
			<th>Размеры и описание</th>
			<?php if ($this->Frontend->canShowTubePrice(false)) { ?>
				<th width="50">Цена</th>
			<?php } ?>
			<th>Кол.</th>
			<th></th>
            <th>Диаметр</th>
		</tr>
		<?php $i = 0; foreach ($products as $item) { ?>
		<tr height="22" class="rowTint<?php echo $i % 2 == 1 ? '1' : ''; ?>">
			<td align="left"><?php echo $types[$item['Product']['type']]; ?></td>
			<td align="left"><?php echo $this->Html->link($item['Product']['sku'], array('controller' => 'tubes', 'action' => 'view', 'id' => $item['Product']['id']), array('escape' => false)); ?></td>
			<?php if ($this->Frontend->canShowTubePrice(false)) { ?>
			<td width="70">
				<?php if ($this->Frontend->canShowTubePrice($item['Product']['not_show_price'])) { ?>
					<span class="productPrice"><?php echo $this->Frontend->getPrice($item['Product']['price'], 'tubes'); ?></span>
				<?php } ?>
			</td>
			<?php } ?>
			<td><?php echo $this->Frontend->getStockCount($item['Product']['stock_count']); ?></td>
			<td><?php echo $item['Product']['in_stock'] ? '.' : ''; ?></td>
            <td><?php echo $item['Product']['size3']; ?></td>
		</tr>
		<?php $i ++; } ?>
	</table>
	<div class="clear"></div>
</div>
<?php } elseif ($mode == 'block') { ?>
<div class="border-b">
    <div class="width-disk" id="product-section">
        <?php $i = 0; foreach ($products as $item) { ?>
            <div class="boxList disks tubes">
                <div class="prodImg floatl prodImg-tubes">
                    <?php if ($item['BrandModel']['new']) { ?>
                        <div class="action-prod new"></div>
                    <?php } elseif ($item['BrandModel']['popular']) { ?>
                        <div class="action-prod hit"></div>
                    <?php } elseif ($item['Product'][0]['sale']) { ?>
                        <div class="action-prod action"></div>
                    <?php } ?>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <?php echo $this->element('tyre_icons', array('product' => $item['Product'], 'brandModel' => $item['BrandModel'])); ?>
                            <td>
                                <?php
                                $default_image = 'default-tube-preview.jpg';
                                if ($item['Product']['type'] == 'flap') {
                                    $default_image = 'default-flap-preview.jpg';
                                }
                                $image = $this->Html->image($default_image, array('class' => 'no-img-disk'));
                                $image_big = false;
                                if (!empty($item['BrandModel']['filename'])) {
                                    $image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 250, 'height' => 250, 'crop' => false, 'folder' => false)), array('alt' => $item['BrandModel']['title']));
                                    $image_big = $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 601, 'crop' => false, 'folder' => false), array('alt' => $item['BrandModel']['title']));
                                }
                                if ($image_big) {
                                    echo $this->Html->link($image, $image_big, array('escape' => false, 'class' => 'lightbox', 'id' => $item['BrandModel']['id']));
                                }
                                else {
                                    echo $image;
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="infoList">
                </div>
                <h3 class="title-tyres title-tubes">
                    <?php
                    echo $this->Html->link($item['Product']['sku'], array('controller' => 'tubes', 'action' => 'view', 'id' => $item['Product']['id']), array('escape' => false));
                    ?>
                </h3>
                <div class="priceMore__row">
                    <div class="priceMore disks">
                        <span><?php echo $this->Frontend->getPrice($item['Product']['price'], 'disks', array('between' => '&nbsp;<span>', 'after' => '</span>')); ?></span>

                        <?php
                        $in_stock_mark = $item['Product']['in_stock'] ? '<img title="в наличии" alt="в наличии" src="/img/yes.png">' : '';
                        echo $this->element('stock_places', array('stock_places' => $item['Product'], 'text' => '<div class="number disks">'.$this->Frontend->getStockCount($item['Product']['stock_count']).' шт. '.$in_stock_mark.'</div>', 'position' => 'center')); ?>

                    </div>
                    <div class="buy-button buy-button-tubes">
                        <a href="javascript:void(0);" class="btVer2" onclick="buy_tube(<?php echo $item['Product']['id']; ?>);">Купить</a>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        <?php $i ++; } ?>
    </div>
</div>
<?php } ?>
<?php
echo $this->element('pager', array('show_limits' => true, 'url' => $url, 'bottom' => true));
?>
<script type="text/javascript">
    function buy_tube(itemId) {
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