<?php
$this->Backend->setOptions(array(
	'model' => 'Supplier',
	'controller' => 'suppliers'
));
echo $this->Backend->getFormHeader();
$this->Backend->addText('title', array(
	'label' => __d('admin_suppliers', 'label_title'),
	'acronym' => __d('admin_suppliers', 'acronym_title'),
	'required' => true
));
$this->Backend->addText('delivery_time_from', array(
    'label' => __d('admin_suppliers', 'label_delivery_time_from'),
    'acronym' => __d('admin_suppliers', 'acronym_delivery_time_from'),
    'required' => false
));
$this->Backend->addText('delivery_time_to', array(
    'label' => __d('admin_suppliers', 'label_delivery_time_to'),
    'acronym' => __d('admin_suppliers', 'acronym_delivery_time_to'),
    'required' => false
));
$this->Backend->addText('prefix', array(
    'label' => __d('admin_suppliers', 'label_delivery_prefix'),
    'acronym' => __d('admin_suppliers', 'label_delivery_prefix'),
    'required' => false
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
