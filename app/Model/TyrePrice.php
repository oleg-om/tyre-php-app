<?php

class TyrePrice extends AppModel
{
    public $name = 'TyrePrice';
    public $validationDomain = 'admin_tyre_prices';
    public $validate = array(
        'size' => array(
            array(
                'rule' => 'notEmpty',
                'message' => 'error_size_empty'
            )
        ),
        'price' => array(
            array(
                'rule' => 'notEmpty',
                'message' => 'error_price_empty'
            )
        ),
        'auto' => array(
            array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'error_auto_empty'
            )
        ),
    );
    public $priceAuto = array();

    public function __construct()
    {
        parent::__construct();
        $this->virtualFields['is_deletable'] = 1;
        $this->priceAuto = array(
            'cars' => __d('admin_tyres', 'auto_cars'),
            'light_trucks' => __d('admin_tyres', 'auto_light_trucks'),
            'suv' => __d('admin_tyre_prices', 'auto_suv')
        );
    }
}