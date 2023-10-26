<?php
if (!empty($used_tyre['UsedTyre']['brand_id'])) {
	$brand = $used_tyre['Brand']['title'];
}
else {
	$brand = $used_tyre['UsedTyre']['brand'];
}
if (!empty($used_tyre['UsedTyre']['model_id'])) {
	$model = $used_tyre['BrandModel']['title'];
}
else {
	$model = $used_tyre['UsedTyre']['model'];
}
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td width="240" class="model_image"><?php
			if (!empty($used_tyre['Photo']['filename'])) {
				echo $this->Html->link($this->Html->image($this->Backend->thumbnail(array('id' => $used_tyre['Photo']['id'], 'filename' => $used_tyre['Photo']['filename'], 'path' => 'tyres', 'width' => 240, 'height' => 1000, 'crop' => false, 'folder' => true)), array('alt' => $brand . ' ' . $model)), $this->Backend->thumbnail(array('id' => $used_tyre['Photo']['id'], 'filename' => $used_tyre['Photo']['filename'], 'path' => 'tyres', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => true)), array('escape' => false, 'rel' => 'gallery', 'class' => 'lightbox', 'title' => $brand . ' ' . $model));
			}
			else {
				echo $this->Html->image('no-tyre-240.jpg', array('alt' => $brand . ' ' . $model));
			}
		?></td>
		<td class="model_description">
			<table width="100%" height="200" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<th class="none_border">Бренд:</th>
					<td class="none_border"><?php echo h($brand); ?></td>
				</tr>
				<tr class="tyre_descr_tr">
					<th>Модель:</th>
					<td><?php echo h($model); ?></td>
				</tr>
				<tr>
					<th>Размер:</th>
					<td><?php echo $used_tyre['UsedTyre']['size1'] . '/' . $used_tyre['UsedTyre']['size2'] . '&nbsp;R' . $used_tyre['UsedTyre']['size3']; ?></td>
				</tr>
				<tr class="tyre_descr_tr">
					<th>Остаток протект.:</th>
					<td><?php echo h($used_tyre['UsedTyre']['protector_width']); ?> мм</td>
				</tr>
				<tr>
					<th>Сезон:</th>
					<td class="auto_type"><div class="productSeason<?php if ($used_tyre['UsedTyre']['season']=='winter') {echo '2';} elseif ($used_tyre['UsedTyre']['season']=='all') {echo '3';}?>" title="<?php echo $seasons[$used_tyre['UsedTyre']['season']];?>"><?php echo $seasons[$used_tyre['UsedTyre']['season']];?></div></td>
				</tr>
				<?php if (CONST_SHOW_USED_TYRES == '1') { ?>
				<tr class="tyre_descr_tr">
					<th>Цена:</th>
					<td><div style="font-weight: bold; font-size: 1.2em; color:#E21;"><?php
						if ($used_tyre['UsedTyre']['no_price']) {
							echo 'уточняйте';
						}
						else {
							echo $this->Frontend->getPrice($used_tyre['UsedTyre']['price'], 'used_tyres');
						}
					?></div></td>
				</tr>
				<?php } ?>
			</table>
		</td>
	</tr>
	<?php if (!empty($used_tyre['UsedTyrePhoto']) && count($used_tyre['UsedTyrePhoto']) > 1) { ?>
	<tr>
		<td>
			<div class="boxFotos"><?php
				foreach ($used_tyre['UsedTyrePhoto'] as $item) {
					if ($item['id'] != $used_tyre['UsedTyre']['photo_id']) {
						echo '<span>' . $this->Html->link($this->Html->image($this->Backend->thumbnail(array('id' => $item['id'], 'filename' => $item['filename'], 'path' => 'tyres', 'width' => 60, 'height' => 60, 'crop' => true, 'folder' => true)), array('alt' => $brand . ' ' . $model)), $this->Backend->thumbnail(array('id' => $item['id'], 'filename' => $item['filename'], 'path' => 'tyres', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => true)), array('escape' => false, 'rel' => 'gallery', 'class' => 'lightbox', 'title' => $brand . ' ' . $model)) . '</span>';
					}
				}
			?></div>
		</td>
		<td></td>
	</tr>
	<?php } ?>
</table>
<?php
	echo $used_tyre['UsedTyre']['content'];
	echo $this->element('contacts_link');
?>
<?php if (!empty($used_tyre['Photo']['filename'])) { ?>
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
<?php } ?>