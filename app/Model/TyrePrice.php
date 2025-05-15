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
    );

    public function __construct()
    {
        parent::__construct();
        $this->virtualFields['is_deletable'] = 1;
    }
}