<?php
$this->Backend->setOptions(array(
	'model' => 'Station',
	'controller' => 'stations'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_stations', 'column_id')
));
$this->Backend->addColumn('title', array(
	'label' => __d('admin_stations', 'column_title'),
	'editable' => true
));
$this->Backend->addColumn('phone', array(
	'label' => __d('admin_stations', 'column_phone')
));
$this->Backend->addColumn('sort_order', array(
	'label' => __d('admin_stations', 'column_sort_order'),
	'width' => 85,
	'filterable' => false,
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
	'title_enabled' => __d('admin_stations', 'title_enabled'),
	'title_disabled' => __d('admin_stations', 'title_disabled'),
	'prefix' => 'status'
));
$this->Backend->setGridButton('apply', array(
	'label' => __d('admin_common', 'button_grid_apply', true),
	'after' => '-'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();