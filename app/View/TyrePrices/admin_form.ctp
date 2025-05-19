<?php
$this->Backend->setOptions(array(
    'model' => 'TyrePrice',
    'controller' => 'tyre_prices'
));
echo $this->Backend->getFormHeader();
$this->Backend->addText('size', array(
    'label' => __d('admin_tyre_prices', 'label_size'),
    'acronym' => __d('admin_tyre_prices', 'label_size'),
    'required' => true
));
$this->Backend->addText('price', array(
    'label' => __d('admin_tyre_prices', 'label_price'),
    'default' => '0.00',
    'required' => true
));
$this->Backend->addSelect('auto', array(
    'label' => __d('admin_tyre_prices', 'label_auto'),
    'options' => $priceAuto,
    'empty' => false
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