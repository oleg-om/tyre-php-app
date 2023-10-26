<?php
$this->Backend->setOptions(array(
	'model' => 'Product',
	'controller' => 'tubes'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_tubes', 'label_is_active'),
	'acronym' => __d('admin_tubes', 'acronym_is_active')
));
$this->Backend->addCheckbox('in_stock', array(
	'label' => __d('admin_tubes', 'label_in_stock')
));
$this->Backend->addCheckbox('not_show_price', array(
	'label' => __d('admin_tubes', 'label_not_show_price')
));
$this->Backend->addSelect('type', array(
	'label' => __d('admin_tubes', 'label_type'),
	'options' => $types
));
$this->Backend->addText('sku', array(
	'label' => __d('admin_tubes', 'label_sku'),
	'acronym' => __d('admin_tubes', 'acronym_sku'),
	'required' => true
));
$this->Backend->addText('price', array(
	'label' => __d('admin_tubes', 'label_price'),
	'required' => true,
	'div' => 'item_div half'
));
$this->Backend->addText('stock_count', array(
	'label' => __d('admin_tubes', 'label_stock_count'),
	'required' => true,
	'div' => 'item_div half'
));
$this->Backend->addHtml('<div class="clear"></div>');
$this->Backend->addHidden('id');
$this->Backend->addHidden('category_id', array('value' => 4));
$this->Backend->addHidden('action', array(
	'type' => 'hidden',
	'value' => 'apply',
	'id' => 'frm_action'
));
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();