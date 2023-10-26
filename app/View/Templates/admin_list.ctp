<?php
$this->Backend->setOptions(array(
	'model' => 'Template',
	'controller' => 'templates'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_templates', 'column_id')
));
$this->Backend->addColumn('title', array(
	'label' => __d('admin_templates', 'column_title'),
	'editable' => true
));
$this->Backend->addColumn('subject', array(
	'label' => __d('admin_templates', 'column_subject')
));
$this->Backend->removeRowButton('delete');
$this->Backend->removeGridButton('delete');
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();