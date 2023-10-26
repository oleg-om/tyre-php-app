<?php
$this->Backend->setOptions(array(
	'model' => 'ReturnRequest',
	'controller' => 'return_requests'
));
$this->Backend->addColumn('request_id', array(
	'width' => 95,
	'type' => 'number',
	'renderer' => 'return_request_id',
	'label' => __d('admin_return_requests', 'column_id')
));
$this->Backend->addColumn('date', array(
	'label' => __d('admin_return_requests', 'column_date'),
	'type' => 'date',
	'format' => 'Y-m-d',
	'width' => 95
));
$this->Backend->addColumn('time', array(
	'label' => __d('admin_return_requests', 'column_time')
));
$this->Backend->addColumn('name', array(
	'label' => __d('admin_return_requests', 'column_name')
));
$this->Backend->addColumn('phone', array(
	'label' => __d('admin_return_requests', 'column_phone')
));
$this->Backend->addColumn('email', array(
	'label' => __d('admin_return_requests', 'column_email')
));
$this->Backend->addColumn('created', array(
	'label' => __d('admin_return_requests', 'column_created'),
	'type' => 'date',
	'format' => 'H:i Y-m-d',
	'width' => 115
));
$this->Backend->removeRowButton('edit');
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();