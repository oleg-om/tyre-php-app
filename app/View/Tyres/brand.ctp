<?php 
if (!isset($filter['in_stock4'])) {
	$filter['in_stock4'] = 0;
}
if (!isset($filter['in_stock'])) {
	$filter['in_stock'] = 0;
}
$this->Paginator->options(array('url' => array('controller' => 'tyres', 'action' => 'brand', 'slug' => $brand['Brand']['slug'], '?' => $filter)));
?>
<div class="center">
	<?php echo $this->element('breadcrumbs');?>
	<p style="text-align: center;"><img border="0" src="/img/<?php if ($current_auto == 'agricultural') { ?>5<?php } elseif ($current_auto == 'trucks') { ?>6<?php } else { ?>1<?php } ?>.png"></p>
	<div id="vmMainPage">
		<?php echo $this->element('pager'); ?>
		<table border="0" width="100%" cellspacing="0" cellpadding="0" class="sectiontableheader sectiontableentry1">
			<tr class="rowTint1">
				<th>&nbsp;</th>
				<th>Типоразмер</th>
				<th><?php echo $current_auto == 'trucks' ? 'Ось' : 'ИН/ИС'; ?></th>
				<th>Бренд</th>
				<th>Модель</th>
				<th><img src="/img/season-all.png" alt="Сезон" title="Сезон" /></th>
				<th><img src="/img/icons/studded.png" alt="Шипы" title="Шипы" /></th>
				<th>Тип</th>
				<th width="50">Цена</th>
				<th>Кол.</th>
				<th></th>
			</tr>
			<?php $i = 0; foreach ($products as $item) { ?>
			<tr height="22" class="rowTint<?php echo $i % 2 == 1 ? '1' : ''; ?>">
				<td><?php
					if ($item['Product']['auto'] == 'trucks') {
						$item['Product']['season'] = 'all';
					}
					$season = $item['Product']['season'];
					if (!empty($item['BrandModel']['season'])) {
						$season = $item['BrandModel']['season'];
					}
					if (!empty($item['BrandModel']['filename'])) {
						echo $this->Html->link($this->Html->image('camera.png', array('alt' => $brand['Brand']['title'] . ' ' . $item['BrandModel']['title'])), $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false, 'watermark' => 'wm.png')), array('escape' => false, 'class' => 'lightbox', 'title' => $brand['Brand']['title'] . ' ' . $item['BrandModel']['title']));
					}
				?></td>
				<td><?php echo $this->Html->link($item['Product']['size1'] . '/' . $item['Product']['size2'] . '&nbsp;R' . $item['Product']['size3'], array('controller' => 'tyres', 'action' => 'view', 'slug' => $brand['Brand']['slug'], 'id' => $item['Product']['id']), array('escape' => false)); ?></td>
				<td><?php echo $current_auto == 'trucks' ? h($item['Product']['axis']) : h($item['Product']['f1'] . $item['Product']['f2']); ?></td>
				<td><?php echo h($brand['Brand']['title']); ?></td>
				<td><?php echo h($models[$item['Product']['model_id']]); ?></td>
				<td><img src="/img/season-<?php echo $season; ?>.png" alt="<?php echo $seasons[$season]; ?>" title="<?php echo $seasons[$season]; ?>" /></td>
				<td><?php if ($item['Product']['stud'] == 1) { ?><img src="/img/icons/studded.png" alt="Шипованная" title="Шипованная" /><?php } ?></td>
				<td><img src="/img/auto-<?php echo $item['Product']['auto']; ?>.png" alt="<?php echo $auto[$item['Product']['auto']]; ?>" title="<?php echo $auto[$item['Product']['auto']]; ?>" /></td>
				<td>
					<span class="productPrice"><?php //echo $this->Frontend->getPrice($item['Product']['price']); ?></span>
				</td>
				<td><?php echo $this->Frontend->getStockCount($item['Product']['stock_count']); ?></td>
				<td><?php echo $item['Product']['in_stock'] ? '.' : ''; ?></td>
			</tr>
			<?php $i ++; } ?>
		</table>
		<?php if (isset($model_content)) { ?>
		<div class="infoBox"><?php echo $model_content; ?></div>
		<?php } ?>
		<br class="clr"><br>
		<?php echo $this->element('pager'); ?>
	</div>
	<?php
		if ($current_auto == 'trucks') {
			echo $this->element('seo_tyres_trucks');
		}
		else {
			echo $this->element('seo_tyres_cars');
		}
		if ($current_auto == 'agricultural' || $current_auto == 'trucks') {
			echo $this->element('contacts_link');
		}
		else {
			echo $this->element('bottom_banner');
		}
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