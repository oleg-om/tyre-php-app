<?php
$this->Backend->setOptions(array(
	'model' => 'CarModel',
	'controller' => 'car_models'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_car_models', 'label_is_active'),
	'acronym' => __d('admin_car_models', 'acronym_is_active')
));
$this->Backend->addSelect('brand_id', array(
	'label' => __d('admin_car_models', 'label_brand_id'),
	'options' => $brands
));
$this->Backend->addText('title', array(
	'label' => __d('admin_car_models', 'label_title'),
	'acronym' => __d('admin_car_models', 'acronym_title'),
	'required' => true,
	'sluggable' => true
));
$this->Backend->addText('slug', array(
	'label' => __d('admin_car_models', 'label_slug'),
	'acronym' => __d('admin_car_models', 'acronym_slug'),
	'required' => true
));
$this->Backend->addHidden('id');
$this->Backend->addHidden('old_brand_id');
$this->Backend->addHidden('action', array(
	'type' => 'hidden',
	'value' => 'apply',
	'id' => 'frm_action'
));
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();