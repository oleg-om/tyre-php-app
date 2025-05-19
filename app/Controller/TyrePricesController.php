<?php

class TyrePricesController extends AppController
{
    public $uses = array();
    public $layout = 'inner';
    public $paginate = array(
        'order' => array(
            'TyrePrice.size' => 'asc'
        )
    );
    public $filter_fields = array('TyrePrice.size' => 'int');
    public $model = 'TyrePrice';
    public $submenu = 'tyre_prices';
}