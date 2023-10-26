<?php
$this->Backend->setOptions(array(
	'model' => 'Product',
	'controller' => 'akb'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_akb', 'label_is_active'),
	'acronym' => __d('admin_akb', 'acronym_is_active')
));
$this->Backend->addCheckbox('in_stock', array(
	'label' => __d('admin_akb', 'label_in_stock')
));
$this->Backend->addCheckbox('not_show_price', array(
	'label' => __d('admin_akb', 'label_not_show_price')
));
$this->Backend->addSelect('brand_id', array(
	'label' => __d('admin_akb', 'label_brand_id'),
	'options' => $brands,
	'div' => 'item_div half'
));
$this->Backend->addSelect('model_id', array(
	'label' => __d('admin_akb', 'label_model_id'),
	'options' => $models,
	'div' => 'item_div half'
));
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addPhoto('filename', array(
	'path' => 'akb',
	'width' => 121,
	'height' => 121,
	'crop' => false,
	'folder' => false,
	'remove' => true
));
$this->Backend->addFile('file', array(
	'label' => __d('admin_akb', 'label_file')
));
$this->Backend->addText('ah', array(
	'label' => __d('admin_akb', 'label_ah'),
	'acronym' => __d('admin_akb', 'acronym_ah'),
	'required' => true,
	'div' => 'item_div half'
));
$this->Backend->addText('current', array(
	'label' => __d('admin_akb', 'label_current'),
	'div' => 'item_div half'
));
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addText('price', array(
	'label' => __d('admin_akb', 'label_price'),
	'required' => true,
	'div' => 'item_div half'
));
$this->Backend->addText('stock_count', array(
	'label' => __d('admin_akb', 'label_stock_count'),
	'required' => true,
	'div' => 'item_div half'
));
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addText('width', array(
	'label' => __d('admin_akb', 'label_width'),
	'div' => 'item_div third'
));
$this->Backend->addText('length', array(
	'label' => __d('admin_akb', 'label_length'),
	'div' => 'item_div third'
));
$this->Backend->addText('height', array(
	'label' => __d('admin_akb', 'label_height'),
	'div' => 'item_div third'
));
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addText('f1', array(
	'label' => __d('admin_akb', 'label_f1'),
	'div' => 'item_div half'
));
$this->Backend->addText('f2', array(
	'label' => __d('admin_akb', 'label_f2'),
	'div' => 'item_div half'
));
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addHidden('id');
$this->Backend->addHidden('old_brand_id');
$this->Backend->addHidden('old_model_id');
$this->Backend->addHidden('category_id', array('value' => 3));
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