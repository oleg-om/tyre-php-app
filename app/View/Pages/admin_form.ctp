<?php
$this->Backend->setOptions(array(
	'model' => 'Page',
	'controller' => 'pages'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_pages', 'label_is_active'),
	'acronym' => __d('admin_pages', 'acronym_is_active'),
	'disabled' => !$is_deletable
));
$this->Backend->addCheckbox('gallery', array(
	'label' => __d('admin_pages', 'label_gallery')
));
$this->Backend->addText('title', array(
	'label' => __d('admin_pages', 'label_title'),
	'acronym' => __d('admin_pages', 'acronym_title'),
	'required' => true,
	'sluggable' => true
));
$this->Backend->addText('slug', array(
	'label' => __d('admin_pages', 'label_slug'),
	'acronym' => __d('admin_pages', 'acronym_slug'),
	'required' => true,
	'disabled' => !$is_deletable
));
$this->Backend->addText('meta_title', array(
	'label' => __d('admin_pages', 'label_meta_title')
));
$this->Backend->addText('meta_keywords', array(
	'label' => __d('admin_pages', 'label_meta_keywords')
));
$this->Backend->addTextarea('meta_description', array(
	'label' => __d('admin_pages', 'label_meta_description')
));
$this->Backend->addTextarea('content', array(
	'label' => __d('admin_pages', 'label_content'),
	'editor' => true
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