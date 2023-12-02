<h2 class="title">Аккумуляторы <?php
    echo $brand['Brand']['title'];
    ?></h2>
<?php
$this->Paginator->options(array('url' => array('controller' => 'akb', 'action' => 'brand', 'slug' => $brand['Brand']['slug'], '?' => $filter)));
?>
<div id="vmMainPage">
    <?php
    $url = array('controller' => 'akb', 'action' => 'brand', 'slug' => $brand['Brand']['slug'], '?' => $filter);
    echo $this->element('mode_selector', array('url' => $url, 'akb_switch' => true));
    ?>
    <?php if ($mode == 'table') { ?>
	<table border="0" width="100%" cellspacing="0" cellpadding="0" class="sectiontableheader sectiontableentry1">
		<tr class="rowTint1">
			<th>&nbsp;</th>
			<th>Бренд</th>
			<th>Модель</th>
			<th>Размер</th>
			<th>Емкость (Ah)</th>
			<th>Ток</th>
			<th>Тип</th>
			<th>П.</th>
			<?php if ($this->Frontend->canShowAkbPrice(false)) { ?>
				<th width="50">Цена</th>
			<?php } ?>
			<th>Кол.</th>
			<th></th>
		</tr>
		<?php $i = 0; foreach ($products as $item) { ?>
						<!-- <div class="boxList season-winter with-season season-yes season-cars">
				<div class="info-top">
					<h3>
					<?php echo $this->Html->link($brand['Brand']['title'], array('controller' => 'akb', 'action' => 'view', 'slug' => $brand['Brand']['slug'], 'id' => $item['Product']['id']), array('escape' => false)); ?>
						 <a href=""><?php echo h($brand['Brand']['title']); ?> <?php echo h($item['BrandModel']['title']); ?></a>  
					</h3>
				</div>
				<div class="prodImg floatl">
					<a href="" class="lightbox"></a>
				</div>
				<div class="infoList">
					<div class="detalProd tyres">
						<a href=""><?php echo $item['Product']['ah']; ?> ач <?php echo $item['Product']['current']; ?>А <?php echo h($item['Product']['f1']); ?> <?php echo h($item['Product']['f2']); ?></a>
						 
					</div>
					<div class="detalProd tyres">
						 
						<a href=""><?php echo $item['Product']['width'] . 'x' . $item['Product']['length'] . 'x' . $item['Product']['height']; ?></a>
					</div>
				</div>
				<div class="clear"></div>
				<div class="priceMore tyres">
				<?php if ($this->Frontend->canShowAkbPrice($item['Product']['not_show_price'])) { ?>
					<span><?php echo $this->Frontend->getPrice($item['Product']['price'], 'akb'); ?></span>
				<?php } ?>	 
				</div>
				<div class="number disks">
				<?php echo $this->Frontend->getStockCount($item['Product']['stock_count']); ?> шт.
				</div>
				<div class="clear"></div>
			</div> -->

			
		<tr height="22" class="rowTint<?php echo $i % 2 == 1 ? '1' : ''; ?>">
			<td><?php
				$filename = null;
				if (!empty($item['Product']['filename'])) {
					$filename = $item['Product']['filename'];
					$id = $item['Product']['id'];
					$pathAkb = 'akb';
				}
				elseif (!empty($item['BrandModel']['filename'])) {
					$filename = $item['BrandModel']['filename'];
					$id = $item['BrandModel']['id'];
                    $pathAkb = 'models';
				}
				if (!empty($filename)) {
					echo $this->Html->link($this->Html->image('camera.png', array('alt' => $brand['Brand']['title'] . ' ' . $item['BrandModel']['title'])), $this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $pathAkb, 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false)), array('escape' => false, 'class' => 'lightbox', 'title' => $brand['Brand']['title'] . ' ' . $item['BrandModel']['title']));
				}
			?></td>
			<td><?php echo $this->Html->link($brand['Brand']['title'], array('controller' => 'akb', 'action' => 'view', 'slug' => $brand['Brand']['slug'], 'id' => $item['Product']['id']), array('escape' => false)); ?></td>
			<td><?php echo h($item['BrandModel']['title']); ?></td>
			<td><?php echo $item['Product']['width'] . 'x' . $item['Product']['length'] . 'x' . $item['Product']['height']; ?></td>
			<td><?php echo $item['Product']['ah']; ?>ач</td>
			<td><?php echo $item['Product']['current']; ?></td>
			<td><?php echo h($item['Product']['f1']); ?></td>
			<td><?php echo h($item['Product']['f2']); ?></td>
			<?php if ($this->Frontend->canShowAkbPrice(false)) { ?>
			<td>
				<?php if ($this->Frontend->canShowAkbPrice($item['Product']['not_show_price'])) { ?>
					<span class="productPrice"><?php echo $this->Frontend->getPrice($item['Product']['price'], 'akb'); ?></span>
				<?php } ?>
			</td>
			<?php } ?>
			<td><?php echo $this->Frontend->getStockCount($item['Product']['stock_count']); ?></td>
			<td><?php echo $item['Product']['in_stock'] ? '.' : ''; ?></td>
		</tr>
		<?php $i ++; } ?>
	</table>
    <?php } ?>

    <?php if ($mode == 'block') { ?>
    <div class="border-b border-b-tyres">
        <div class="width-disk">
            <?php $i = 0; foreach ($products as $item) { ?>
                <div class="boxList season-winter with-season season-yes season-cars">
                    <div class="info-top">
                        <h3><?php
                            echo $this->Html->link('<span>'.$brand['Brand']['title'].' '.$item['BrandModel']['title'].'</span>', array('controller' => 'akb', 'action' => 'view', 'slug' => $brand['Brand']['slug'], 'id' => $item['Product']['id']), array('escape' => false));
                            $url = array('controller' => 'akb', 'action' => 'view', 'slug' => $brand['Brand']['slug'], 'id' => $item['Product']['id']);
                            ?></h3>
                    </div>
                    <div class="prodImg floatl">
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td>

                                    <?php
                                    $placeholder = $this->Html->image('no-tyre-little.jpg', array('class' => 'no-img-tyre'));
                                    $filename = null;
                                    if (!empty($item['Product']['filename'])) {
                                        $filename = $item['Product']['filename'];
                                        $id = $item['Product']['id'];
                                        $pathAkb = 'akb';
                                    }
                                    elseif (!empty($item['BrandModel']['filename'])) {
                                        $filename = $item['BrandModel']['filename'];
                                        $id = $item['BrandModel']['id'];
                                        $pathAkb = 'models';
                                    }
                                    if (!empty($filename)) {
                                        $imgBig = $this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $pathAkb, 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false));
                                        $imgSmall = $this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $pathAkb, 'width' => 150, 'height' => 150, 'crop' => false, 'folder' => false));
                                        echo $this->Html->link($this->Html->image($imgSmall, array('alt' => $brand['Brand']['title'] . ' ' . $item['BrandModel']['title'])), $imgBig, array('escape' => false, 'class' => 'lightbox', 'title' => $brand['Brand']['title'] . ' ' . $item['BrandModel']['title']));
                                    }
                                    else {
                                        echo $placeholder;
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="infoList">
                        <div class="detalProd tyres">
                            <a href="<?php echo Router::url($url); ?>"><?php echo $item['Product']['ah']; ?>ач <?php echo $item['Product']['current']; ?> <?php echo h($item['Product']['f1']); ?> <?php echo h($item['Product']['f2']); ?></a>
                        </div>
                    </div>
                    <div class="product__info">
                        <div class="priceMore tyres">
                            <?php if ($this->Frontend->canShowAkbPrice(false)) { ?>
                                    <?php if ($this->Frontend->canShowAkbPrice($item['Product']['not_show_price'])) { ?>
                                        <span><?php echo $this->Frontend->getPrice($item['Product']['price'], 'akb'); ?></span>
                                    <?php } ?>
                            <?php } ?>
                            <div class="namber tyres">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->Frontend->getStockCount($item['Product']['stock_count']); ?> шт. <?php echo $item['Product']['in_stock'] ? '<img title="в наличии" alt="в наличии" src="/img/yes.png">' : ''; ?></div>
                        </div>
                        <div class="buy-button">
                            <a href="javascript:void(0);" class="btVer2" onclick="buyAkb(<?php echo $item['Product']['id']; ?>);">Купить</a>
                        </div>
                    </div>
                    <td><?php echo $item['Product']['in_stock'] ? '.' : ''; ?></td>
                </div>
                <?php $i ++; } ?>
        </div></div>
    <?php } ?>
	<div class="clear"></div>
	<div class="pager-filter bottom">
		<?php
			echo $this->element('pager');
		?>
		<div class="clear"></div>
	</div>
</div>
<?php
	echo $this->element('seo_akb');
	//echo $this->element('bottom_banner');
?>
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
<script type="text/javascript">

    function buyAkb(itemId) {
        open_popup({
            url: '/cart',
            type: 'post',
            data: {
                'data[Product][0][count]': 1,
                'data[Product][0][product_id]': itemId
            },
        });
    }
</script>