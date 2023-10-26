<?php
$this->Backend->setOptions(array(
	'model' => 'Brand',
	'controller' => 'brands'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_brands', 'label_is_active'),
	'acronym' => __d('admin_brands', 'acronym_is_active')
));
$this->Backend->addSelect('category_id', array(
	'label' => __d('admin_brands', 'label_category_id'),
	'options' => $categories
));
$this->Backend->addText('title', array(
	'label' => __d('admin_brands', 'label_title'),
	'acronym' => __d('admin_brands', 'acronym_title'),
	'required' => true,
	'sluggable' => true
));
$this->Backend->addText('slug', array(
	'label' => __d('admin_brands', 'label_slug'),
	'acronym' => __d('admin_brands', 'acronym_slug'),
	'required' => true
));
$this->Backend->addText('h1_title', array(
	'label' => __d('admin_brands', 'label_h1_title'),
	'acronym' => __d('admin_brands', 'acronym_h1_title')
));

$this->Backend->addPhoto('filename', array(
	'path' => 'brands',
	'width' => 160,
	'height' => 60,
	'crop' => false,
	'folder' => false
));
$this->Backend->addFile('file', array(
	'label' => __d('admin_brands', 'label_file')
));
$this->Backend->addTextarea('content', array(
	'label' => __d('admin_brands', 'label_content'),
	'editor' => true
));
$this->Backend->addText('meta_title', array(
	'label' => __d('admin_brands', 'label_meta_title')
));
$this->Backend->addText('meta_keywords', array(
	'label' => __d('admin_brands', 'label_meta_keywords')
));
$this->Backend->addTextarea('meta_description', array(
	'label' => __d('admin_brands', 'label_meta_description')
));
$this->Backend->addTextarea('synonyms', array(
	'label' => __d('admin_brands', 'label_synonyms')
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