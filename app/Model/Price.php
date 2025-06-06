<?php

class Price extends AppModel
{
    public $name = 'Price';
    public $validationDomain = 'admin_prices';
    public $validate = array(
        'title' => array(
            'rule' => 'notEmpty',
            'message' => 'error_title_empty'
        ),
        'price' => array(
            array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'error_price_empty',
                'last' => true
            ),
            array(
                'rule' => array('comparison', '>', 0),
                'required' => true,
                'message' => 'error_price_numeric'
            )
        ),
        'type' => array(
            array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'error_type_empty'
            )
        ),
        "time" => array(
            array(
                'required' => false,
            )
        ),
        "description" => array(
            array(
                'required' => false,
            )
        )
    );
    public $types = array();

    public function __construct()
    {
        parent::__construct();
        $this->virtualFields['is_deletable'] = 1;
        $this->types = array(
            'cars' => __d('admin_prices', 'type_car'),
        );
    }
}