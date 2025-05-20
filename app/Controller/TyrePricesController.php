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

    public function _list()
    {
        parent::_list();
        $this->loadModel('TyrePrice');
        $this->set('priceAuto', $this->TyrePrice->priceAuto);
    }

    public function _edit($id)
    {
        $title = parent::_edit($id);
        $this->loadModel('TyrePrice');
        $this->set('priceAuto', $this->TyrePrice->priceAuto);
        return $title;
    }
}