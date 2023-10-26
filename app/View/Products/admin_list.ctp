<?php
$this->Backend->setOptions(array(
	'model' => 'Product',
	'controller' => 'products'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_products', 'column_id')
));
$this->Backend->addColumn('photo', array(
	'label' => __d('admin_products', 'column_photo'),
	'filterable' => false,
	'sortable' => false,
	'width' => 129,
	'renderer' => 'product_photo'
));
$this->Backend->addColumn('title', array(
	'label' => __d('admin_products', 'column_title'),
	'editable' => true
));
$this->Backend->addColumn('category_id', array(
	'label' => __d('admin_products', 'column_category_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $categories
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
	'title_enabled' => __d('admin_products', 'title_enabled'),
	'title_disabled' => __d('admin_products', 'title_disabled'),
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