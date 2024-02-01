<?php
$this->Backend->setOptions(array(
	'model' => 'CarModel',
	'controller' => 'car_models'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_car_models', 'column_id')
));
$this->Backend->addColumn('brand_slug', array(
	'label' => __d('admin_car_models', 'column_brand_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $brands
));
$this->Backend->addColumn('title', array(
	'label' => __d('admin_car_models', 'column_title'),
	'editable' => true
));
$this->Backend->addColumn('items_count', array(
	'label' => __d('admin_car_models', 'column_modifications_count'),
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
	'title_enabled' => __d('admin_car_models', 'title_enabled'),
	'title_disabled' => __d('admin_car_models', 'title_disabled'),
	'prefix' => 'status'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();