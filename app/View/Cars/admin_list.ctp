<?php
$this->Backend->setOptions(array(
	'model' => 'Car',
	'controller' => 'cars'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_cars', 'column_id')
));
$this->Backend->addColumn('brand_id', array(
	'label' => __d('admin_cars', 'column_brand_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $brands
));
$this->Backend->addColumn('model_id', array(
	'label' => __d('admin_cars', 'column_model_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $models,
	'all_options' => $all_models
));
$this->Backend->addColumn('modification_id', array(
	'label' => __d('admin_cars', 'column_modification_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $modifications,
	'all_options' => $all_modifications
));
$this->Backend->addColumn('year', array(
	'label' => __d('admin_cars', 'column_year'),
	'editable' => true
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
	'title_enabled' => __d('admin_cars', 'title_enabled'),
	'title_disabled' => __d('admin_cars', 'title_disabled'),
	'prefix' => 'status'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();
?>
<script type="text/javascript">
$(function(){
	$('#CarBrandId').change(handler_brand_id);
	$('#CarModelId').change(handler_model_id);
	handler_brand_id();
	
});
function handler_brand_id() {
	var brand_id = parseInt($('#CarBrandId').val()), model_id = $('#CarModelId').val();
	if (isNaN(brand_id)) brand_id = 0;
	$('#CarModelId').removeOption(/.*/);
	if (brand_id != 0) {
		loader();
		$('#CarModelId').ajaxAddOption(
			'/admin/car_brands/models',
			{brand_id: brand_id, any: 0},
			false,
			function() {
				$('#CarModelId').val(model_id);
				delete_loader();
				handler_model_id();
			}
		);
	}
	else {
		$('#CarModelId').addOption('','<?php echo __d('admin_common', 'list_all_items'); ?>');
		handler_model_id();
	}
}
function handler_model_id() {
	var model_id = parseInt($('#CarModelId').val()), modification_id = $('#CarModificationId').val();
	if (isNaN(model_id)) model_id = 0;
	$('#CarModificationId').removeOption(/.*/);
	if (model_id != 0) {
		loader();
		$('#CarModificationId').ajaxAddOption(
			'/admin/car_models/modifications',
			{model_id: model_id, any: 0},
			false,
			function() {
				$('#CarModificationId').val(modification_id);
				delete_loader();
			}
		);
	}
	else {
		$('#CarModificationId').addOption('','<?php echo __d('admin_common', 'list_all_items'); ?>');
	}
}
</script>