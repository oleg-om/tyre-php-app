<?php
$this->Backend->setOptions(array(
	'model' => 'Section',
	'controller' => 'sections'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_sections', 'column_id')
));
$this->Backend->addColumn('type', array(
	'label' => __d('admin_sections', 'column_type'),
	'type' => 'list',
	'sortable' => false,
	'options' => $types
));
$this->Backend->addColumn('title', array(
	'label' => __d('admin_sections', 'column_title'),
	'editable' => true,
	'renderer' => 'section_title'
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
	'title_enabled' => __d('admin_sections', 'title_enabled'),
	'title_disabled' => __d('admin_sections', 'title_disabled'),
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