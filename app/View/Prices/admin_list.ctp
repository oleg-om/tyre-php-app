<?php
$this->Backend->setOptions(array(
    'model' => 'Price',
    'controller' => 'prices'
));
$this->Backend->addColumn('id', array(
    'width' => 55,
    'type' => 'number',
    'label' => __d('admin_prices', 'column_id')
));
//$this->Backend->addColumn('type', array(
//	'label' => __d('admin_prices', 'column_type'),
//	'type' => 'list',
//	'sortable' => false,
//	'options' => $types
//));
$this->Backend->addColumn('title', array(
    'label' => __d('admin_prices', 'column_title'),
    'editable' => true
));
//$this->Backend->addColumn('time', array(
//	'label' => __d('admin_prices', 'column_time')
//));
$this->Backend->addColumn('price', array(
    'label' => sprintf(__d('admin_prices', 'column_price'), $storage_currency),
));
//$this->Backend->addColumn('sort_order', array(
//	'label' => __d('admin_prices', 'column_sort_order'),
//	'width' => 85,
//	'filterable' => false,
//	'renderer' => 'sort_order'
//));
$this->Backend->addColumn('is_active', array(
    'width' => 40,
    'type' => 'switcher',
    'sortable' => false,
    'icon' => 'lightbulb',
    'deletable' => true,
    'deletable_value' => 1,
    'url_enabled' => 'enable',
    'url_disabled' => 'disable',
    'title_enabled' => __d('admin_prices', 'title_enabled'),
    'title_disabled' => __d('admin_prices', 'title_disabled'),
    'prefix' => 'status'
));
$this->Backend->setGridButton('apply', array(
    'label' => __d('admin_common', 'button_grid_apply', true),
    'after' => '-'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();