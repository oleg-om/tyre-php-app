<?php
$this->Backend->setOptions(array(
    'model' => 'TyrePrice',
    'controller' => 'tyre_prices'
));
$this->Backend->addColumn('size', array(
    'width' => 100,
    'type' => 'number',
    'label' => __d('admin_tyre_prices', 'size'),
    'editable' => true,
    'filterable' => false,
));
$this->Backend->addColumn('price', array(
    'label' => __d('admin_tyre_prices', 'price'),
    'editable' => true,
    'filterable' => false,
));

$this->Backend->setGridButton('apply', array(
    'label' => __d('admin_common', 'button_grid_apply', true),
    'after' => '-'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();