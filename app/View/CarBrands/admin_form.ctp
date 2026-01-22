<?php
$this->Backend->setOptions(array(
	'model' => 'CarBrand',
	'controller' => 'car_brands'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_car_brands', 'label_is_active'),
	'acronym' => __d('admin_car_brands', 'acronym_is_active')
));
$this->Backend->addText('title', array(
	'label' => __d('admin_car_brands', 'label_title'),
	'acronym' => __d('admin_car_brands', 'acronym_title'),
	'required' => true,
	'sluggable' => true
));
$this->Backend->addText('slug', array(
	'label' => __d('admin_car_brands', 'label_slug'),
	'acronym' => __d('admin_car_brands', 'acronym_slug'),
	'required' => true
));
if (!empty($this->data['CarBrand']['filename'])) {
	$this->Backend->addHtml('<div class="item_div">' . $this->Html->image('/files/car_brands/' . $this->data['CarBrand']['filename']) . '</div>');
}
$this->Backend->addFile('file', array(
	'label' => __d('admin_car_brands', 'label_file')
));
$this->Backend->addHidden('id');
$this->Backend->addHidden('filename');
$this->Backend->addHidden('action', array(
	'type' => 'hidden',
	'value' => 'apply',
	'id' => 'frm_action'
));
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();