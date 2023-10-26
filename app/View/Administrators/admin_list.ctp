<?php
$this->Backend->setOptions(array(
	'model' => 'Administrator',
	'controller' => 'administrators'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_administrators', 'column_id')
));
$this->Backend->addColumn('username', array(
	'label' => __d('admin_administrators', 'column_username'),
	'editable' => true
));
$this->Backend->addColumn('email', array(
	'label' => __d('admin_administrators', 'column_email')
));
$this->Backend->addColumn('name', array(
	'label' => __d('admin_administrators', 'column_name')
));
$this->Backend->addColumn('logged', array(
	'label' => __d('admin_administrators', 'column_logged'),
	'type' => 'date',
	'format' => 'H:i d.m.Y',
	'width' => 135,
	'align' => 'a-center'
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
	'title_enabled' => __d('admin_administrators', 'title_enabled'),
	'title_disabled' => __d('admin_administrators', 'title_disabled'),
	'prefix' => 'status'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();