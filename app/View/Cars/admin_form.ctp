<?php
$this->Backend->setOptions(array(
	'model' => 'Car',
	'controller' => 'cars'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_cars', 'label_is_active'),
	'acronym' => __d('admin_cars', 'acronym_is_active')
));
$this->Backend->addSelect('brand_id', array(
	'label' => __d('admin_cars', 'label_brand_id'),
	'options' => $brands
));
$this->Backend->addSelect('model_id', array(
	'label' => __d('admin_cars', 'label_model_id'),
	'options' => $models
));
$this->Backend->addSelect('modification_id', array(
	'label' => __d('admin_cars', 'label_modification_id'),
	'options' => $modifications
));
$this->Backend->addText('year', array(
	'label' => __d('admin_cars', 'label_year'),
	'required' => true
));
$this->Backend->addTab('tyres', __d('admin_cars', 'tab_tyres'));
$this->Backend->addText('factory_tyres', array(
	'label' => __d('admin_cars', 'label_factory_tyres')
), 'tyres');
$this->Backend->addTextarea('replace_tyres', array(
	'label' => __d('admin_cars', 'label_replace_tyres')
), 'tyres');
$this->Backend->addTextarea('tuning_tyres', array(
	'label' => __d('admin_cars', 'label_tuning_tyres')
), 'tyres');
$this->Backend->addTab('disks', __d('admin_cars', 'tab_disks'));
$this->Backend->addText('pcd', array(
	'label' => __d('admin_cars', 'label_pcd'),
	'div' => 'item_div third'
), 'disks');
$this->Backend->addText('diameter', array(
	'label' => __d('admin_cars', 'label_diameter'),
	'div' => 'item_div third'
), 'disks');
$this->Backend->addText('nut', array(
	'label' => __d('admin_cars', 'label_nut'),
	'div' => 'item_div third'
), 'disks');
$this->Backend->addHtml('<div class="clear"></div>', 'disks');
$this->Backend->addText('factory_disks', array(
	'label' => __d('admin_cars', 'label_factory_disks')
), 'disks');
$this->Backend->addTextarea('replace_disks', array(
	'label' => __d('admin_cars', 'label_replace_disks')
), 'disks');
$this->Backend->addTextarea('tuning_disks', array(
	'label' => __d('admin_cars', 'label_tuning_disks')
), 'disks');
$this->Backend->addTab('akb', __d('admin_cars', 'tab_akb'));
$this->Backend->addText('width', array(
	'label' => __d('admin_cars', 'label_width'),
	'div' => 'item_div third'
), 'akb');
$this->Backend->addText('length', array(
	'label' => __d('admin_cars', 'label_length'),
	'div' => 'item_div third'
), 'akb');
$this->Backend->addText('height', array(
	'label' => __d('admin_cars', 'label_height'),
	'div' => 'item_div third'
), 'akb');
$this->Backend->addHtml('<div class="clear"></div>', 'akb');

$this->Backend->addText('ah_from', array(
	'label' => __d('admin_cars', 'label_ah_from'),
	'div' => 'item_div third'
), 'akb');
$this->Backend->addText('ah_to', array(
	'label' => __d('admin_cars', 'label_ah_to'),
	'div' => 'item_div third'
), 'akb');
$this->Backend->addText('current', array(
	'label' => __d('admin_cars', 'label_current'),
	'div' => 'item_div third'
), 'akb');
$this->Backend->addHtml('<div class="clear"></div>', 'akb');
$this->Backend->addText('f1', array(
	'label' => __d('admin_cars', 'label_f1'),
	'div' => 'item_div half'
), 'akb');
$this->Backend->addText('f2', array(
	'label' => __d('admin_cars', 'label_f2'),
	'div' => 'item_div half'
), 'akb');
$this->Backend->addHtml('<div class="clear"></div>', 'akb');
$this->Backend->addHidden('id');
$this->Backend->addHidden('old_brand_id');
$this->Backend->addHidden('old_model_id');
$this->Backend->addHidden('old_modification_id');
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
			{brand_id: brand_id, any: 1},
			false,
			function() {
				$('#CarModelId').val(model_id);
				delete_loader();
				handler_model_id();
			}
		);
	}
	else {
		$('#CarModelId').addOption('','<?php echo __d('admin_common', 'list_any_item'); ?>');
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
			{model_id: model_id, any: 1},
			false,
			function() {
				$('#CarModificationId').val(modification_id);
				delete_loader();
			}
		);
	}
	else {
		$('#CarModificationId').addOption('','<?php echo __d('admin_common', 'list_any_item'); ?>');
	}
}
</script>