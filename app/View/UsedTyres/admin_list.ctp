<?php
$this->Backend->setOptions(array(
	'model' => 'UsedTyre',
	'controller' => 'used_tyres'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_used_tyres', 'column_id')
));
$this->Backend->addColumn('photo', array(
	'label' => __d('admin_used_tyres', 'column_photo'),
	'filterable' => false,
	'sortable' => false,
	'width' => 170,
	'renderer' => 'used_tyre_photo'
));
$this->Backend->addColumn('brand_id', array(
	'label' => __d('admin_used_tyres', 'column_brand_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $brands,
	'renderer' => 'used_tyre_brand'
));
$this->Backend->addColumn('model_id', array(
	'label' => __d('admin_used_tyres', 'column_model_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $models,
	'all_options' => $all_models,
	'renderer' => 'used_tyre_model'
));
$this->Backend->addColumn('size', array(
	'label' => __d('admin_used_tyres', 'column_size'),
	'renderer' => 'tyre_size',
	'filterable' => false,
	'sortable' => false
));
$this->Backend->addColumn('created', array(
	'label' => __d('admin_used_tyres', 'column_created'),
	'type' => 'date',
	'format' => 'H:i d.m.Y',
	'width' => 115
));
$this->Backend->addColumn('price', array(
	'label' => __d('admin_used_tyres', 'column_price'),
	'renderer' => 'used_tyre_price',
	'filterable' => false
));
$this->Backend->addColumn('count', array(
	'label' => __d('admin_used_tyres', 'column_count'),
	'renderer' => 'used_tyre_count',
	'filterable' => false
));
$this->Backend->addColumn('is_active', array(
	'width' => 40,
	'type' => 'switcher',
	'sortable' => false,
	'icon' => 'lightbulb',
	'deletable' => true,
	'deletable_value' => 1,
	'url_enabled' => 'enable',
	'url_disabled' => 'disable',
	'title_enabled' => __d('admin_used_tyres', 'title_enabled'),
	'title_disabled' => __d('admin_used_tyres', 'title_disabled'),
	'prefix' => 'status'
));
$this->Backend->setGridButton('apply', array(
	'label' => __d('admin_common', 'button_grid_apply'),
	'after' => '-'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();
?>
<script type="text/javascript">
$(function(){
	$('#UsedTyreBrandId').change(handler_brand_id);
	handler_brand_id();
	
});
function handler_brand_id() {
	var brand_id = parseInt($('#UsedTyreBrandId').val()), model_id = $('#UsedTyreModelId').val();
	if (isNaN(brand_id)) brand_id = 0;
	$('#UsedTyreModelId').removeOption(/.*/);
	if (brand_id != 0) {
		loader();
		$('#UsedTyreModelId').ajaxAddOption(
			'/admin/brands/models',
			{brand_id: brand_id, any: 0},
			false,
			function() {
				$('#UsedTyreModelId').val(model_id);
				delete_loader();
			}
		);
	}
	else {
		$('#UsedTyreModelId').addOption('','<?php echo __d('admin_common', 'list_all_items'); ?>');
	}
}
</script>