<?php
$this->Backend->setOptions(array(
    'model' => 'Price',
    'controller' => 'prices'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
    'label' => __d('admin_prices', 'label_is_active'),
    'acronym' => __d('admin_prices', 'acronym_is_active')
));
$this->Backend->addSelect('type', array(
    'label' => __d('admin_prices', 'label_type'),
    'options' => $types,
    'empty' => false,
    'default' => 'cars'
));
$this->Backend->addText('title', array(
    'label' => __d('admin_prices', 'label_title'),
    'acronym' => __d('admin_prices', 'acronym_title'),
    'required' => true
));
//$this->Backend->addText('time', array(
//    'label' => __d('admin_prices', 'label_time'),
//    'required' => true
//));
//$this->Backend->addText('description', array(
//    'label' => __d('admin_prices', 'label_description')
//));
$this->Backend->addText('price', array(
    'label' => sprintf(__d('admin_prices', 'label_price'), $storage_currency),
    'default' => '0.00'
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