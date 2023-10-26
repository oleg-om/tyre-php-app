<h2 class="title">Б/У шины</h2>
<?php
$this->Paginator->options(array('url' => array('controller' => 'used_tyres', 'action' => 'index', '?' => $filter)));
?>
<?php
	echo $this->element('pager');
?>
<table width="100%" cellspacing="0" cellpadding="0" id="sh_tires_list">
	<tr class="rowTint1">
		<th>&nbsp;</th>
		<th>Бренд / Модель</th>
		<th>Размер</th>
		<th><img src="/img/season-all.png" alt="Сезон" title="Сезон" /></th>
		<th>Остаток протект.</th>
		<th>Кол.</th>
		<?php if (CONST_SHOW_USED_TYRES == '1') { ?>
		<th>Цена за 1 шт.</th>
		<?php } ?>
	</tr>
	<?php $i = 0; foreach ($used_tyres as $item) { ?>
	<?php
		if (!empty($item['UsedTyre']['brand_id'])) {
			$brand = $item['Brand']['title'];
		}
		else {
			$brand = $item['UsedTyre']['brand'];
		}
		if (!empty($item['UsedTyre']['model_id'])) {
			$model = $item['BrandModel']['title'];
		}
		else {
			$model = $item['UsedTyre']['model'];
		}
	?>
	<tr height="32" class="rowTint<?php echo $i % 2 == 1 ? '1' : ''; ?>">
		<td><?php
			if (!empty($item['Photo']['filename'])) {
				echo $this->Html->link($this->Html->image('camera2.png', array('alt' => $brand . ' ' . $model)), $this->Backend->thumbnail(array('id' => $item['Photo']['id'], 'filename' => $item['Photo']['filename'], 'path' => 'tyres', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => true)), array('escape' => false, 'class' => 'lightbox', 'title' => $brand . ' ' . $model));
			}
		?></td>
		<td class="name"><?php echo $this->Html->link('<span class="upper">' . h($brand) . '</span> ' . h($model), array('controller' => 'used_tyres', 'action' => 'view', 'id' => $item['UsedTyre']['id']), array('escape' => false)); ?></td>
		<td><?php echo $item['UsedTyre']['size1'] . '/' . $item['UsedTyre']['size2'] . '&nbsp;R' . $item['UsedTyre']['size3']; ?></td>
		<td>
			<span class="productSeason<?php if ($item['UsedTyre']['season']=='winter') {echo '2';} elseif ($item['UsedTyre']['season']=='all') {echo '3';}?>" title="<?php echo $seasons[$item['UsedTyre']['season']];?>">
				<?php echo $seasons[$item['UsedTyre']['season']];?>
			</span>
		</td>
		<td><?php echo $item['UsedTyre']['protector_width']; ?> мм</td>
		<td><?php echo $item['UsedTyre']['count']; ?></td>
		<?php if (CONST_SHOW_USED_TYRES == '1') { ?>
		<td>
			<span class="productPrice"><?php
				if ($item['UsedTyre']['no_price']) {
					echo 'уточняйте';
				}
				else {
					echo $this->Frontend->getPrice($item['UsedTyre']['price'], 'used_tyres');
				}
			?></span>
		</td>
		<?php } ?>
	</tr>
	<?php $i ++; } ?>
</table>
<div class="clear"></div>
<?php
	echo $this->element('pager', array('bottom' => true));
?>
<?php
	echo $this->element('seo_disks');
	echo $this->element('contacts_link');
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