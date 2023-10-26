<?php
$this->Backend->setOptions(array(
	'model' => 'Currency',
	'controller' => 'currencies',
	'show_limits' => false,
	'show_paginator' => false,
	'show_selectors' => false
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_currencies', 'column_id'),
	'filterable' => false,
	'sortable' => false
));
$this->Backend->addColumn('title', array(
	'label' => __d('admin_currencies', 'column_title'),
	'editable' => true,
	'filterable' => false,
	'sortable' => false
));
$this->Backend->addColumn('rate', array(
	'label' => __d('admin_currencies', 'column_rate'),
	'filterable' => false,
	'sortable' => false
));
$this->Backend->addColumn('round', array(
	'label' => __d('admin_currencies', 'column_round'),
	'filterable' => false,
	'sortable' => false
));
$this->Backend->addColumn('decimals', array(
	'label' => __d('admin_currencies', 'column_decimals'),
	'filterable' => false,
	'sortable' => false
));
$this->Backend->addColumn('sort_order', array(
	'label' => __d('admin_currencies', 'column_sort_order', true),
	'width' => 85,
	'filterable' => false,
	'sortable' => false,
	'renderer' => 'sort_order'
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
	'title_enabled' => __d('admin_currencies', 'title_enabled'),
	'title_disabled' => __d('admin_currencies', 'title_disabled'),
	'prefix' => 'status'
));
$this->Backend->removeRowButton('delete');
$this->Backend->removeGridButton('delete');
$this->Backend->setGridButton('apply', array(
	'label' => __d('admin_common', 'button_grid_apply', true),
	'after' => '-'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();