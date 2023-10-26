<?php
$this->Backend->setOptions(array(
	'model' => 'CarModification',
	'controller' => 'car_modifications'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_car_modifications', 'column_id')
));
$this->Backend->addColumn('brand_id', array(
	'label' => __d('admin_car_modifications', 'column_brand_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $brands
));
$this->Backend->addColumn('model_id', array(
	'label' => __d('admin_car_modifications', 'column_model_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $models,
	'all_options' => $all_models
));
$this->Backend->addColumn('title', array(
	'label' => __d('admin_car_modifications', 'column_title'),
	'editable' => true
));
$this->Backend->addColumn('cars_count', array(
	'label' => __d('admin_car_modifications', 'column_cars_count'),
	'counter' => true
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
	'title_enabled' => __d('admin_car_modifications', 'title_enabled'),
	'title_disabled' => __d('admin_car_modifications', 'title_disabled'),
	'prefix' => 'status'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();
?>
<script type="text/javascript">
$(function(){
	$('#CarModificationBrandId').change(handler_brand_id);
	handler_brand_id();
	
});
function handler_brand_id() {
	var brand_id = parseInt($('#CarModificationBrandId').val()), model_id = $('#CarModificationModelId').val();
	if (isNaN(brand_id)) brand_id = 0;
	$('#CarModificationModelId').removeOption(/.*/);
	if (brand_id != 0) {
		loader();
		$('#CarModificationModelId').ajaxAddOption(
			'/admin/car_brands/models',
			{brand_id: brand_id, any: 0},
			false,
			function() {
				$('#CarModificationModelId').val(model_id);
				delete_loader();
			}
		);
	}
	else {
		$('#CarModificationModelId').addOption('','<?php echo __d('admin_common', 'list_all_items'); ?>');
	}
}
</script>