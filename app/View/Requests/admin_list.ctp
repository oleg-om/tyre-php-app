<?php
$this->Backend->setOptions(array(
	'model' => 'Request',
	'controller' => 'requests'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_requests', 'column_id')
));
$this->Backend->addColumn('station_id', array(
	'label' => __d('admin_requests', 'column_station_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $stations
));
$this->Backend->addColumn('date', array(
	'label' => __d('admin_requests', 'column_date'),
	'type' => 'date',
	'format' => 'Y-m-d',
	'width' => 95
));
$this->Backend->addColumn('time', array(
	'label' => __d('admin_requests', 'column_time')
));
$this->Backend->addColumn('phone', array(
	'label' => __d('admin_requests', 'column_phone')
));
$this->Backend->addColumn('created', array(
	'label' => __d('admin_requests', 'column_created'),
	'type' => 'date',
	'format' => 'H:i Y-m-d',
	'width' => 115
));
$this->Backend->removeRowButton('edit');
$this->Backend->setRowButton('view', array(
	'label' => __d('admin_requests', 'button_row_view', true),
	'after' => '-'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();