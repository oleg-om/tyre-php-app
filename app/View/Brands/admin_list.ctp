<?php
$this->Backend->setOptions(array(
	'model' => 'Brand',
	'controller' => 'brands'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_brands', 'column_id')
));
$this->Backend->addColumn('photo', array(
	'label' => __d('admin_brands', 'column_photo'),
	'filterable' => false,
	'sortable' => false,
	'width' => 170,
	'renderer' => 'brand_photo'
));
$this->Backend->addColumn('category_id', array(
	'label' => __d('admin_brands', 'column_category_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $categories
));
$this->Backend->addColumn('title', array(
	'label' => __d('admin_brands', 'column_title'),
	'editable' => true
));
$this->Backend->addColumn('models_count', array(
	'label' => __d('admin_brands', 'column_models_count'),
	'counter' => true
));
$this->Backend->addColumn('products_count', array(
	'label' => __d('admin_brands', 'column_products_count'),
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
	'title_enabled' => __d('admin_brands', 'title_enabled'),
	'title_disabled' => __d('admin_brands', 'title_disabled'),
	'prefix' => 'status'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();