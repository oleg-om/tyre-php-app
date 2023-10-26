<?php
$this->Backend->setOptions(array(
	'model' => 'Product',
	'controller' => 'bolts'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_bolts', 'label_is_active'),
	'acronym' => __d('admin_bolts', 'acronym_is_active')
));
$this->Backend->addCheckbox('in_stock', array(
	'label' => __d('admin_bolts', 'label_in_stock')
));
$this->Backend->addCheckbox('not_show_price', array(
	'label' => __d('admin_bolts', 'label_not_show_price')
));
$this->Backend->addSelect('bolt_type', array(
	'label' => __d('admin_bolts', 'label_bolt_type'),
	'options' => $bolt_types,
	'empty' => false
));
$this->Backend->addPhoto('filename', array(
	'path' => 'bolts',
	'width' => 121,
	'height' => 121,
	'crop' => false,
	'folder' => false,
	'remove' => true
));
$this->Backend->addFile('file', array(
	'label' => __d('admin_bolts', 'label_file')
));
$this->Backend->addHtml('<div class="bolt">');
$this->Backend->addText('size1', array(
	'label' => __d('admin_bolts', 'label_size1'),
	'required' => true,
	'div' => 'item_div third size1'
));
$this->Backend->addText('size2', array(
	'label' => __d('admin_bolts', 'label_size2'),
	'required' => true,
	'div' => 'item_div third size2'
));
$this->Backend->addHtml('<div class="ring">');
$this->Backend->addText('size3', array(
	'label' => __d('admin_bolts', 'label_size3'),
	'div' => 'item_div third'
));
$this->Backend->addHtml('</div>');
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addHtml('<div class="ring">');
$this->Backend->addText('f1', array(
	'label' => __d('admin_bolts', 'label_f1'),
	'div' => 'item_div third'
));
$this->Backend->addText('color', array(
	'label' => __d('admin_bolts', 'label_color'),
	'div' => 'item_div third'
));
$this->Backend->addText('material', array(
	'label' => __d('admin_bolts', 'label_material'),
	'div' => 'item_div third'
));
$this->Backend->addHtml('</div>');
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addHtml('</div>');
$this->Backend->addHtml('<div class="valve">');
$this->Backend->addText('sku', array(
	'label' => __d('admin_bolts', 'label_valve')
));
$this->Backend->addHtml('</div>');
$this->Backend->addText('price', array(
	'label' => __d('admin_bolts', 'label_price'),
	'required' => true,
	'div' => 'item_div half'
));
$this->Backend->addText('stock_count', array(
	'label' => __d('admin_bolts', 'label_stock_count'),
	'required' => true,
	'div' => 'item_div half'
));
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addHidden('id');
$this->Backend->addHidden('category_id', array('value' => 5));
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
<!--
$(function(){
	$('#ProductBoltType').change(handler_type);
	handler_type();
});
function handler_type() {
	var type = $('#ProductBoltType').val();
	if (type == 'ring') {
		$('.ring').hide();
		$('.valve').hide();
		$('.bolt').show();
		$('.size1 label').html('<acronym title="<?php echo __d('admin_bolts', 'label_size1_ring'); ?>"><?php echo __d('admin_bolts', 'label_size1_ring'); ?></acronym>');
		$('.size2 label').html('<acronym title="<?php echo __d('admin_bolts', 'label_size2_ring'); ?>"><?php echo __d('admin_bolts', 'label_size2_ring'); ?></acronym>');
	}
	else if (type == 'valve') {
		$('.ring').hide();
		$('.bolt').hide();
		$('.valve').show();
	}
	else {
		$('.ring').show();
		$('.valve').hide();
		$('.bolt').show();
		$('.size1 label').html('<acronym title="<?php echo __d('admin_bolts', 'label_size1'); ?>"><?php echo __d('admin_bolts', 'label_size1'); ?></acronym>');
		$('.size2 label').html('<acronym title="<?php echo __d('admin_bolts', 'label_size2'); ?>"><?php echo __d('admin_bolts', 'label_size2'); ?></acronym>');
	}
}
//-->
</script>