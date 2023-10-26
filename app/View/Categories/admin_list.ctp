<?php
$this->Backend->setOptions(array(
	'model' => 'Category',
	'controller' => 'categories'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_categories', 'column_id')
));
$this->Backend->addColumn('photo', array(
	'label' => __d('admin_categories', 'column_photo'),
	'filterable' => false,
	'sortable' => false,
	'width' => 89,
	'renderer' => 'category_photo'
));
$this->Backend->addColumn('title', array(
	'label' => __d('admin_categories', 'column_title'),
	'editable' => true
));
$this->Backend->addColumn('slug', array(
	'label' => __d('admin_categories', 'column_slug'),
	'renderer' => 'category_slug'
));
$this->Backend->addColumn('lft', array(
	'label' => __d('admin_categories', 'column_lft'),
	'filterable' => false,
	'width' => 90
));
$this->Backend->addColumn('products_count', array(
	'label' => __d('admin_categories', 'column_products_count'),
	'counter' => true
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
	'title_enabled' => __d('admin_categories', 'title_enabled'),
	'title_disabled' => __d('admin_categories', 'title_disabled'),
	'prefix' => 'status'
));
$this->Backend->setRowButton('up', array(
	'label' => __d('admin_common', 'button_row_up', true),
	'after' => '-'
));
$this->Backend->setRowButton('down', array(
	'label' => __d('admin_common', 'button_row_down', true),
	'after' => 'up'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();