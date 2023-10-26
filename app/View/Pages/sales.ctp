<?php
/*
$modes = array(
	'block' => 'блоками',
	'list' => 'списком',
	'table' => 'таблицей'
);
*/
$sale_tyres = array();
$sale_disks = array();
foreach ($data as $item) {
	if ($item['BrandModel']['category_id'] == 1) {
		$sale_tyres[] = $item;
	}
	else {
		$sale_disks[] = $item;
	}
}
?>
<div id="right">
	<div class="item-sales">
		<?php if (!empty($sale_tyres)) {?>
		<h2 class="title-page title-page-orang">Акционные шины</h2>
		<div id="sale_tyres">
			<?php echo $this->element('index_tyres_products', array('models' => $sale_tyres, 'filter' => array(), 'mode' => 'block')); ?>
		</div>
		<?php } ?>
	</div>
	<div class="item-sales">
		<?php if (!empty($sale_disks)) { ?>
		<h2 class="title-page title-page-orang">Акционные диски</h2>
		<div id="sale_disks">
			<?php echo $this->element('index_disks_products', array('models' => $sale_disks, 'filter' => array(), 'mode' => 'block')); ?>
		</div>
		<?php } ?>
		<div class="sales-content"><?php echo $page['Page']['content']; ?></div>
	</div>
</div>
<?php /*
<div id="right">
	<h2 class="title-page title-page-orang">Акционные предложения</h2>
	<div class="filter-prod filter-prod-sales">
		<?php if (!empty($sale_tyres) && !empty($sale_disks)) { ?>
			<div class="float-l">
				<div id="switch">
					<a class="sale_tyres<?php if ($tab == 'tyres') { ?> active<?php } ?>">Шины</a>
					<a class="sale_disks<?php if ($tab == 'disks') { ?> active<?php } ?>">Диски</a>
				</div>
			</div>
		<?php } ?>
		<div class="float-r">
			<?php if (!empty($sale_tyres)) { ?>
			<div class="show tyres"<?php if ($tab == 'disks' && !empty($sale_disks)) { ?> style="display:none;"<?php } ?>>
				<strong>Показать:</strong>
				<ul><?php
					foreach ($modes as $key => $value) {
						$class = null;
						if ($mode == $key) {
							$class = 'activ';
						}
						echo '<li>' . $this->Html->link($value, array('controller' => 'pages', 'action' => 'sales', '?' => array('mode' => $key, 'tab' => 'tyres')), array('class' => $class)) . '</li>';
					}
				?></ul>
			</div>
			<?php } ?>
			<?php if (!empty($sale_disks)) { ?>
			<div class="show disks"<?php if ($tab == 'tyres' && !empty($sale_tyres)) { ?> style="display:none;"<?php } ?>>
				<strong>Показать:</strong>
				<ul><?php
					foreach ($modes as $key => $value) {
						$class = null;
						if ($mode == $key) {
							$class = 'activ';
						}
						echo '<li>' . $this->Html->link($value, array('controller' => 'pages', 'action' => 'sales', '?' => array('mode' => $key, 'tab' => 'disks')), array('class' => $class)) . '</li>';
					}
				?></ul>
			</div>
			<?php } ?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<?php if (!empty($sale_tyres)) {?>
	<div id="sale_tyres"<?php if ($tab == 'disks' && !empty($sale_disks)) { ?> style="display:none;"<?php } ?>>
		<?php echo $this->element('index_tyres_products', array('models' => $sale_tyres, 'filter' => array(), 'mode' => $mode)); ?>
	</div>
	<?php } ?>
	<?php if (!empty($sale_disks)) { ?>
	<div id="sale_disks"<?php if ($tab == 'tyres' && !empty($sale_tyres)) { ?> style="display:none;"<?php } ?>>
		<?php echo $this->element('index_disks_products', array('models' => $sale_disks, 'filter' => array(), 'mode' => $mode)); ?>
	</div>
	<?php } ?>
	<div class="sales-content"><?php echo $page['Page']['content']; ?></div>
</div>
<script type="text/javascript">
<!--
$(function(){
	$('a.sale_tyres').click(function () {
		$('.show.disks').hide();
		$('.show.tyres').show();
		$('#sale_disks').hide();
		$('#sale_tyres').show();
		$('#switch a').removeClass('active');
		$(this).addClass('active');
		return false;
	});
	$('a.sale_disks').click(function () {
		$('.show.tyres').hide();
		$('.show.disks').show();
		$('#sale_tyres').hide();
		$('#sale_disks').show();
		$('#switch a').removeClass('active');
		$(this).addClass('active');
		return false;
	});
});
//-->
</script>
*/ ?>