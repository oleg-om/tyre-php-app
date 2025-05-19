<?php

class Supplier extends AppModel
{
    public $name = 'Supplier';
    public $validationDomain = 'admin_suppliers';
    public $validate = array(
        'title' => array(
            'rule' => 'notEmpty',
            'message' => 'error_title_empty'
        ),
        'delivery_time_from' => array(
            array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'error_station_id_empty'
            ),
        ),
        'delivery_time_to' => array(
            array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'error_station_id_empty'
            ),
        ),
        'prefix' => array()
    );

    public function __construct()
    {
        parent::__construct();
        $this->virtualFields['is_deletable'] = 1;
    }
}
