<?php
$this->Backend->setOptions(array(
	'model' => 'StorageRequest',
	'controller' => 'storage_requests'
));
$this->Backend->addColumn('request_id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_storage_requests', 'column_id')
));
$this->Backend->addColumn('station_id', array(
	'label' => __d('admin_storage_requests', 'column_station_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $stations
));
$this->Backend->addColumn('date', array(
	'label' => __d('admin_storage_requests', 'column_date'),
	'type' => 'date',
	'format' => 'Y-m-d',
	'width' => 95
));
$this->Backend->addColumn('time', array(
	'label' => __d('admin_storage_requests', 'column_time')
));
$this->Backend->addColumn('phone', array(
	'label' => __d('admin_storage_requests', 'column_phone')
));
$this->Backend->addColumn('created', array(
	'label' => __d('admin_storage_requests', 'column_created'),
	'type' => 'date',
	'format' => 'H:i Y-m-d',
	'width' => 115
));
$this->Backend->setRowButton('view', array(
	'label' => __d('admin_storage_requests', 'button_row_view', true),
	'after' => 'edit'
));
$this->Backend->setRowButton('print', array(
	'label' => __d('admin_storage_requests', 'button_row_print', true),
	'after' => 'view',
	'class' => 'no-loader',
	'target' => '_blank'
));
$this->Backend->setRowButton('label', array(
	'label' => __d('admin_storage_requests', 'button_row_label', true),
	'after' => 'print',
	'class' => 'no-loader',
	'target' => '_blank'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();