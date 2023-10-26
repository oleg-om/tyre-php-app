<?php
$this->Backend->setOptions(array(
	'model' => 'CarModification',
	'controller' => 'car_modifications'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_car_modifications', 'label_is_active'),
	'acronym' => __d('admin_car_modifications', 'acronym_is_active')
));
$this->Backend->addSelect('brand_id', array(
	'label' => __d('admin_car_modifications', 'label_brand_id'),
	'options' => $brands
));
$this->Backend->addSelect('model_id', array(
	'label' => __d('admin_car_modifications', 'label_model_id'),
	'options' => $models
));
$this->Backend->addText('title', array(
	'label' => __d('admin_car_modifications', 'label_title'),
	'acronym' => __d('admin_car_modifications', 'acronym_title'),
	'required' => true,
	'sluggable' => true
));
$this->Backend->addText('slug', array(
	'label' => __d('admin_car_modifications', 'label_slug'),
	'acronym' => __d('admin_car_modifications', 'acronym_slug'),
	'required' => true
));
$this->Backend->addHidden('id');
$this->Backend->addHidden('old_model_id');
$this->Backend->addHidden('action', array(
	'type' => 'hidden',
	'value' => 'apply',
	'id' => 'frm_action'
));
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();
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
			{brand_id: brand_id, any: 1},
			false,
			function() {
				$('#CarModificationModelId').val(model_id);
				delete_loader();
			}
		);
	}
	else {
		$('#CarModificationModelId').addOption('','<?php echo __d('admin_common', 'list_any_item'); ?>');
	}
}
</script>