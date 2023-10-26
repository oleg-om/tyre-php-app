<?php
$this->Backend->setOptions(array(
	'model' => 'HomePhoto',
	'controller' => 'home_photos'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_home_photos', 'label_is_active'),
	'acronym' => __d('admin_home_photos', 'acronym_is_active')
));
$this->Backend->addPhoto('filename', array(
	'path' => 'slider',
	'width' => 647,
	'height' => 312,
	'crop' => true,
	'folder' => false
));
$this->Backend->addFile('file', array(
	'label' => __d('admin_home_photos', 'label_file')
));
$this->Backend->addText('link', array(
	'label' => __d('admin_home_photos', 'label_link')
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