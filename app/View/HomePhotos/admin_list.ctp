<?php
$this->Backend->setOptions(array(
	'model' => 'HomePhoto',
	'controller' => 'home_photos'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_home_photos', 'column_id')
));
$this->Backend->addColumn('photo', array(
	'label' => __d('admin_home_photos', 'column_photo'),
	'filterable' => false,
	'sortable' => false,
	'width' => 310,
	'renderer' => 'home_photo'
));
$this->Backend->addColumn('link', array(
	'label' => __d('admin_home_photos', 'column_link')
));
$this->Backend->addColumn('sort_order', array(
	'label' => __d('admin_home_photos', 'column_sort_order', true),
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
	'title_enabled' => __d('admin_home_photos', 'title_enabled'),
	'title_disabled' => __d('admin_home_photos', 'title_disabled'),
	'prefix' => 'status'
));
$this->Backend->setGridButton('apply', array(
	'label' => __d('admin_common', 'button_grid_apply', true),
	'after' => '-'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();