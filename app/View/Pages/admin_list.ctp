<?php
$this->Backend->setOptions(array(
	'model' => 'Page',
	'controller' => 'pages'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_pages', 'column_id')
));
$this->Backend->addColumn('title', array(
	'label' => __d('admin_pages', 'column_title'),
	'editable' => true
));
$this->Backend->addColumn('slug', array(
	'label' => __d('admin_pages', 'column_slug'),
	'renderer' => 'page_slug'
));
$this->Backend->addColumn('is_active', array(
	'width' => 40,
	'type' => 'switcher',
	'sortable' => false,
	'icon' => 'lightbulb',
	'deletable' => true,
	'deletable_value' => 1,
	'url_enabled' => 'enable',
	'url_disabled' => 'disable',
	'title_enabled' => __d('admin_pages', 'title_enabled'),
	'title_disabled' => __d('admin_pages', 'title_disabled'),
	'prefix' => 'status'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();