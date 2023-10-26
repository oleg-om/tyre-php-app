<?php
$last_tyres = array();
$last_disks = array();
foreach ($last_models as $item) {
	if ($item['BrandModel']['category_id'] == 1) {
		$last_tyres[] = $item;
	}
	else {
		$last_disks[] = $item;
	}
}
?>
<div id="right">
	<h2 class="title-page">Просмотренные Вами модели</h2>
	<?php echo $this->element('currency'); ?>
	<?php if (!empty($last_tyres) && !empty($last_disks)) {?>
	<div id="switch">
		<a class="last_tyres active">Шины</a>
		<a class="last_disks">Диски</a>
	</div>
	<?php } ?>
	<?php if (!empty($last_tyres)) {?>
	<div id="last_tyres">
		<?php echo $this->element('index_tyres', array('models' => $last_tyres, 'filter' => array(), 'mode' => 'block')); ?>
	</div>
	<?php } ?>
	<?php if (!empty($last_disks)) { ?>
	<div id="last_disks"<?php if (!empty($last_tyres) && !empty($last_disks)) {?> style="display: none;"<?php } ?>>
		<?php echo $this->element('index_disks', array('models' => $last_disks, 'filter' => array(), 'mode' => 'block')); ?>
	</div>
	<?php } ?>
</div>
<script type="text/javascript">
<!--
$(function(){
	$('a.last_tyres').click(function () {
		$('#last_disks').hide();
		$('#last_tyres').show();
		$('#switch a').removeClass('active');
		$(this).addClass('active');
		return false;
	});
	$('a.last_disks').click(function () {
		$('#last_tyres').hide();
		$('#last_disks').show();
		$('#switch a').removeClass('active');
		$(this).addClass('active');
		return false;
	});
});
//-->
</script>