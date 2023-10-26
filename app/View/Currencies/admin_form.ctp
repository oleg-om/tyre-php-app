<?php
$this->Backend->setOptions(array(
	'model' => 'Currency',
	'controller' => 'currencies'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_currencies', 'label_is_active'),
	'acronym' => __d('admin_currencies', 'acronym_is_active')
));
$this->Backend->addCheckbox('default', array(
	'label' => __d('admin_currencies', 'label_default')
));
$this->Backend->addCheckbox('cart', array(
	'label' => __d('admin_currencies', 'label_cart')
));
$this->Backend->addCheckbox('storage', array(
	'label' => __d('admin_currencies', 'label_storage')
));
$this->Backend->addText('title', array(
	'label' => __d('admin_currencies', 'label_title'),
	'acronym' => __d('admin_currencies', 'acronym_title'),
	'required' => true
));
$this->Backend->addText('short_title', array(
	'label' => __d('admin_currencies', 'label_short_title'),
	'required' => true
));
$this->Backend->addText('rate', array(
	'label' => __d('admin_currencies', 'label_rate'),
	'required' => true
));
$this->Backend->addText('round', array(
	'label' => __d('admin_currencies', 'label_round'),
	'default' => '10.00'
));
$this->Backend->addCheckbox('round_down', array(
	'label' => __d('admin_currencies', 'label_round_down')
));
$this->Backend->addText('decimals', array(
	'label' => __d('admin_currencies', 'label_decimals'),
	'default' => 0
));
$this->Backend->addText('sort_order', array(
	'label' => __d('admin_currencies', 'label_sort_order')
));
$this->Backend->addHidden('id');
$this->Backend->addHidden('action', array(
	'type' => 'hidden',
	'value' => 'apply',
	'id' => 'frm_action'
));
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();