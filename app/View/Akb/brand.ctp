<?php
$this->Paginator->options(array('url' => array('controller' => 'akb', 'action' => 'brand', 'slug' => $brand['Brand']['slug'], '?' => $filter)));
?>
<div id="vmMainPage">
	<div class="pager-filter"><?php
		echo $this->element('pager');
	?><div class="clear"></div></div>
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
					$path = 'akb';
				}
				elseif (!empty($item['BrandModel']['filename'])) {
					$filename = $item['BrandModel']['filename'];
					$id = $item['BrandModel']['id'];
					$path = 'models';
				}
				if (!empty($filename)) {
					echo $this->Html->link($this->Html->image('camera.png', array('alt' => $brand['Brand']['title'] . ' ' . $item['BrandModel']['title'])), $this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $path, 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false)), array('escape' => false, 'class' => 'lightbox', 'title' => $brand['Brand']['title'] . ' ' . $item['BrandModel']['title']));
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