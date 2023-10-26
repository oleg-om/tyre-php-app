<?php
if (!isset($filter['in_stock4'])) {
	$filter['in_stock4'] = 0;
}
if (!isset($filter['in_stock'])) {
	$filter['in_stock'] = 0;
}
$this->Paginator->options(array('url' => array('controller' => 'disks', 'action' => 'brand', 'slug' => $brand['Brand']['slug'], '?' => $filter)));
?>
<div class="center">
	<?php echo $this->element('breadcrumbs'); ?>
	<p style="text-align: center;"><img border="0" src="/img/3.png"></p>
	<div id="whitebox">
		<div id="vmMainPage">
			<?php echo $this->element('currency'); ?>
			<?php echo $this->element('pager'); ?>
			<div class="img-disk-list-container"><div class="disks-line">
				<?php
					$i = 0;
					foreach ($products as $item) {
						if ($i % 3 == 0 && $i > 0) {
							echo '</div><div class="disks-line">';
						}
						echo '<div class="disk-item">';
						$image = '';
						if (!empty($item['BrandModel']['filename'])) {
							echo $this->Html->link($this->Html->image($this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 121, 'height' => 121, 'crop' => false, 'folder' => false)), array('alt' => $item['Product']['sku'])), $this->Backend->thumbnail(array('id' => $item['BrandModel']['id'], 'filename' => $item['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false, 'watermark' => 'wm.png')), array('escape' => false, 'class' => 'lightbox borderImg', 'title' => $brand['Brand']['title'] . ' ' . $item['BrandModel']['title'] . ' ' . $item['Product']['size1'] . ' ' . $item['Product']['size2']));
						}
						else {
							echo $this->Html->link($this->Html->image('no-disk.jpg', array('alt' => $item['Product']['sku'])), '/img/disk.jpg', array('escape' => false, 'class' => 'lightbox borderImg', 'title' => $brand['Brand']['title'] . ' ' . $item['BrandModel']['title'] . ' ' . $item['Product']['size1'] . ' ' . $item['Product']['size2']));
						}
						$attributes = ' style="font-weight: bold; font-size: 1.2em; color:#E21;  margin-top:10px;"';
						if ($item['Product']['in_stock']) {
							$attributes = ' class="green" style="font-weight: bold; font-size: 1.2em;"';
						}
						echo $this->Html->link('<strong>' . $brand['Brand']['title'] . ' ' . $item['BrandModel']['title'] . '<br /><span>' . $item['Product']['size1'] . ' ' . $item['Product']['size2'] . '</span></strong><div' . $attributes . '>' . /*$this->Frontend->getPrice($item['Product']['price']) */. '</div>', array('controller' => 'disks', 'action' => 'view', 'slug' => $brand['Brand']['slug'], 'id' => $item['Product']['id']), array('title' => $item['Product']['sku'], 'escape' => false, 'class' => 'img-brand'));
						echo '</div>';
						$i ++;
					}
				?>
				</div>
				<div style="clear: both;"></div>
			</div>
			<?php echo $this->element('pager'); ?>
		</div>
	</div>
	<?php
		echo $this->element('seo_disks');
		echo $this->element('bottom_banner');
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