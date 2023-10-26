<?php
$this->Backend->setOptions(array(
	'model' => 'CarBrand',
	'controller' => 'car_brands'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_car_brands', 'column_id')
));
$this->Backend->addColumn('photo', array(
	'label' => __d('admin_car_brands', 'column_photo'),
	'filterable' => false,
	'sortable' => false,
	'width' => 170,
	'renderer' => 'car_brand_photo'
));
$this->Backend->addColumn('title', array(
	'label' => __d('admin_car_brands', 'column_title'),
	'editable' => true
));
$this->Backend->addColumn('models_count', array(
	'label' => __d('admin_car_brands', 'column_models_count'),
	'counter' => true
));
$this->Backend->addColumn('cars_count', array(
	'label' => __d('admin_car_brands', 'column_cars_count'),
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
	'title_enabled' => __d('admin_car_brands', 'title_enabled'),
	'title_disabled' => __d('admin_car_brands', 'title_disabled'),
	'prefix' => 'status'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();