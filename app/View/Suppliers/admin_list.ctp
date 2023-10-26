<?php
$this->Backend->setOptions(array(
	'model' => 'Supplier',
	'controller' => 'suppliers'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_suppliers', 'column_id')
));
$this->Backend->addColumn('title', array(
	'label' => __d('admin_suppliers', 'column_title'),
	'editable' => true
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();