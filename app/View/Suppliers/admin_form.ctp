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
$this->Backend->addHidden('id');
$this->Backend->addHidden('action', array(
	'type' => 'hidden',
	'value' => 'apply',
	'id' => 'frm_action'
));
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();