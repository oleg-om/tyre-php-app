<?php
$this->Backend->setOptions(array(
	'model' => 'Product',
	'controller' => 'disks'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_disks', 'label_is_active'),
	'acronym' => __d('admin_disks', 'acronym_is_active')
));
$this->Backend->addCheckbox('in_stock', array(
	'label' => __d('admin_disks', 'label_in_stock')
));
$this->Backend->addCheckbox('sale', array(
	'label' => __d('admin_disks', 'label_sale')
));
$this->Backend->addCheckbox('not_show_price', array(
	'label' => __d('admin_disks', 'label_not_show_price')
));
$this->Backend->addSelect('brand_id', array(
	'label' => __d('admin_disks', 'label_brand_id'),
	'options' => $brands,
	'div' => 'item_div half'
));
$this->Backend->addSelect('model_id', array(
	'label' => __d('admin_disks', 'label_model_id'),
	'options' => $models,
	'div' => 'item_div half'
));
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addText('sku', array(
	'label' => __d('admin_disks', 'label_sku'),
	'acronym' => __d('admin_disks', 'acronym_sku'),
	'required' => true
));
$this->Backend->addText('price', array(
	'label' => __d('admin_disks', 'label_price'),
	'required' => true,
	'div' => 'item_div half'
));
$this->Backend->addText('stock_count', array(
	'label' => __d('admin_disks', 'label_stock_count'),
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
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addText('size1', array(
	'label' => __d('admin_disks', 'label_size1'),
	'required' => true,
	'div' => 'item_div third'
));
$this->Backend->addText('size2', array(
	'label' => __d('admin_disks', 'label_size2'),
	'required' => true,
	'div' => 'item_div third'
));
$this->Backend->addText('size3', array(
	'label' => __d('admin_disks', 'label_size3'),
	'required' => true,
	'div' => 'item_div third'
));
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addText('et', array(
	'label' => __d('admin_disks', 'label_et'),
	'required' => true,
	'div' => 'item_div half'
));
$this->Backend->addText('hub', array(
	'label' => __d('admin_disks', 'label_hub'),
	'required' => true,
	'div' => 'item_div half'
));
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addText('color', array(
	'label' => __d('admin_disks', 'label_color'),
	'div' => 'item_div half'
));
/*
$this->Backend->addText('material', array(
	'label' => __d('admin_disks', 'label_material'),
	'div' => 'item_div half'
));
*/
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addHidden('id');
$this->Backend->addHidden('old_brand_id');
$this->Backend->addHidden('old_model_id');
$this->Backend->addHidden('category_id', array('value' => 2));
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
	handler_brand_id();
	
});





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
				$('#ProductModelId').sortOptions(true);
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