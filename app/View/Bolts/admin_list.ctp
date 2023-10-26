<?php
$this->Backend->setOptions(array(
	'model' => 'Product',
	'controller' => 'bolts'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_bolts', 'column_id')
));
$this->Backend->addColumn('bolt_type', array(
	'label' => __d('admin_bolts', 'column_bolt_type'),
	'type' => 'list',
	'sortable' => false,
	'options' => $bolt_types
));
$this->Backend->addColumn('bolt', array(
	'label' => __d('admin_bolts', 'column_bolt'),
	'editable' => true
));
$this->Backend->addColumn('price', array(
	'label' => __d('admin_bolts', 'column_price'),
	'renderer' => 'product_price',
	'filterable' => false
));
$this->Backend->addColumn('stock_count', array(
	'label' => __d('admin_bolts', 'column_stock_count'),
	'renderer' => 'product_stock_count',
	'filterable' => false
));
$this->Backend->addColumn('in_stock', array(
	'width' => 40,
	'type' => 'switcher',
	'sortable' => false,
	'icon' => 'stock',
	'deletable' => true,
	'deletable_value' => 1,
	'url_enabled' => 'stockon',
	'url_disabled' => 'stockoff',
	'title_enabled' => __d('admin_bolts', 'title_stockon'),
	'title_disabled' => __d('admin_bolts', 'title_stockoff'),
	'prefix' => 'stock'
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
	'title_enabled' => __d('admin_bolts', 'title_enabled'),
	'title_disabled' => __d('admin_bolts', 'title_disabled'),
	'prefix' => 'status'
));
$this->Backend->setGridButton('apply', array(
	'label' => __d('admin_common', 'button_grid_apply'),
	'after' => '-'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();