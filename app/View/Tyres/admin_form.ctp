<?php
$this->Backend->setOptions(array(
	'model' => 'Product',
	'controller' => 'tyres'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_tyres', 'label_is_active'),
	'acronym' => __d('admin_tyres', 'acronym_is_active')
));
$this->Backend->addCheckbox('not_show_price', array(
	'label' => __d('admin_tyres', 'label_not_show_price')
));
$this->Backend->addCheckbox('sale', array(
    'label' => __d('admin_tyres', 'label_sale')
));
$this->Backend->addCheckbox('p1', array(
    'label' => __d('admin_tyres', 'label_p1')
));
$this->Backend->addCheckbox('p2', array(
    'label' => __d('admin_tyres', 'label_p2')
));
$this->Backend->addCheckbox('p3', array(
    'label' => __d('admin_tyres', 'label_p3')
));
$this->Backend->addCheckbox('p4', array(
    'label' => __d('admin_tyres', 'label_p4')
));
$this->Backend->addCheckbox('p5', array(
    'label' => __d('admin_tyres', 'label_p5')
));
$this->Backend->addSelect('brand_id', array(
	'label' => __d('admin_tyres', 'label_brand_id'),
	'options' => $brands,
	'div' => 'item_div half'
));
$this->Backend->addSelect('model_id', array(
	'label' => __d('admin_tyres', 'label_model_id'),
	'options' => $models,
	'div' => 'item_div half'
));
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addText('sku', array(
	'label' => __d('admin_tyres', 'label_sku'),
	'acronym' => __d('admin_tyres', 'acronym_sku'),
	'required' => true
));
$this->Backend->addText('price', array(
	'label' => __d('admin_tyres', 'label_price'),
	'required' => true,
	'div' => 'item_div half'
));
$this->Backend->addText('stock_count', array(
	'label' => __d('admin_tyres', 'label_stock_count'),
	'required' => true,
	'div' => 'item_div half'
));
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addSelect('auto', array(
	'label' => __d('admin_tyres', 'label_auto'),
	'options' => $auto,
	'empty' => false,
	'div' => 'item_div third'
));
$this->Backend->addSelect('season', array(
	'label' => __d('admin_tyres', 'label_season'),
	'options' => $seasons,
	'empty' => false,
	'div' => 'item_div third'
));
$this->Backend->addSelect('stud', array(
	'label' => __d('admin_tyres', 'label_stud'),
	'options' => $stud,
	'empty' => false,
	'div' => 'item_div third'
));
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addHtml('<div id="axis-box">');
$this->Backend->addText('axis', array(
	'label' => __d('admin_tyres', 'label_axis')
));
$this->Backend->addHtml('</div>');
$this->Backend->addText('size1', array(
	'label' => __d('admin_tyres', 'label_size1'),
	'required' => true,
	'div' => 'item_div third'
));
$this->Backend->addText('size2', array(
	'label' => __d('admin_tyres', 'label_size2'),
	'required' => true,
	'div' => 'item_div third'
));
$this->Backend->addText('size3', array(
	'label' => __d('admin_tyres', 'label_size3'),
	'required' => true,
	'div' => 'item_div third'
));
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addText('f1', array(
	'label' => __d('admin_tyres', 'label_f1'),
	'div' => 'item_div half'
));
$this->Backend->addText('f2', array(
	'label' => __d('admin_tyres', 'label_f2'),
	'div' => 'item_div half'
));
$this->Backend->addHtml('<div class="clear"></div>');
/*
$this->Backend->addText('truck', array(
	'label' => __d('admin_tyres', 'label_truck')
));
*/
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addText('stock_places', array(
    'label' => __d('admin_akb', 'label_stock_places'),
    'div' => 'item_div'
));
$this->Backend->addHidden('id');
$this->Backend->addHidden('old_brand_id');
$this->Backend->addHidden('old_model_id');
$this->Backend->addHidden('category_id', array('value' => 1));
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
	$('#ProductBrandId').change(handler_brand_id);
	$('#ProductAuto').change(handler_auto);
	handler_brand_id();
	handler_auto();
});
function handler_auto() {
	var auto = $('#ProductAuto').val();
	if (auto == 'trucks') {
		$('#axis-box').show();
	}
	else {
		$('#axis-box').hide();
	}
}
function handler_brand_id() {
	var brand_id = parseInt($('#ProductBrandId').val()), model_id = $('#ProductModelId').val();
	if (isNaN(brand_id)) brand_id = 0;
	$('#ProductModelId').removeOption(/.*/);
	if (brand_id != 0) {
		loader();
		$('#ProductModelId').ajaxAddOption(
			'/admin/brands/models',
			{brand_id: brand_id, any: 1},
			false,
			function() {
				$('#ProductModelId').val(model_id);
				delete_loader();
			}
		);
	}
	else {
		$('#ProductModelId').addOption('','<?php echo __d('admin_common', 'list_any_item'); ?>');
	}
}
</script>