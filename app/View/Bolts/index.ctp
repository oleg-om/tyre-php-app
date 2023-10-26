<?php
$this->Paginator->options(array('url' => array('controller' => 'bolts', 'action' => 'index', '?' => $filter)));
?>
<div id="vmMainPage">
	<?php
		echo $this->element('pager');
	?>
	<table border="0" width="100%" cellspacing="0" cellpadding="0" class="sectiontableheader sectiontableentry1">
		<tr class="rowTint1">
			<th>&nbsp;</th>
			<th>Тип</th>
			<th>Описание</th>
			<?php if ($this->Frontend->canShowBoltPrice(false)) { ?>
				<th width="50">Цена</th>
			<?php } ?>
			<th>Кол.</th>
			<th></th>
		</tr>
		<?php $i = 0; foreach ($products as $item) { ?>
		<tr height="22" class="rowTint<?php echo $i % 2 == 1 ? '1' : ''; ?>">
			<td><?php
				$filename = null;
				if (!empty($item['Product']['filename'])) {
					$filename = $item['Product']['filename'];
					$id = $item['Product']['id'];
					$path = 'bolts';
				}
				if (!empty($filename)) {
					echo $this->Html->link($this->Html->image('camera.png', array('alt' => $item['Product']['bolt'])), $this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $path, 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false)), array('escape' => false, 'class' => 'lightbox', 'title' => $item['Product']['bolt']));
				}
			?></td>
			<td align="left"><?php echo $bolt_types[$item['Product']['bolt_type']]; ?></td>
			<td align="left"><?php echo $this->Html->link($item['Product']['bolt'], array('controller' => 'bolts', 'action' => 'view', 'id' => $item['Product']['id']), array('escape' => false)); ?></td>
			<?php if ($this->Frontend->canShowBoltPrice(false)) { ?>
				<td width="70">
					<?php if ($this->Frontend->canShowBoltPrice($item['Product']['not_show_price'])) { ?>
						<span class="productPrice"><?php echo $this->Frontend->getPrice($item['Product']['price'], 'bolts'); ?></span>
					<?php } ?>
				</td>
			<?php } ?>
			<td><?php echo $this->Frontend->getStockCount($item['Product']['stock_count'], 100); ?></td>
			<td><?php echo $this->Html->link('купить', array('controller' => 'bolts', 'action' => 'view', 'id' => $item['Product']['id']), array('class' => 'btVer2')); ?></td>
		</tr>
		<?php $i ++; } ?>
	</table>
	<div class="clear"></div>
	<?php
		echo $this->element('pager', array('bottom' => true));
	?>
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