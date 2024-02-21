<?php
class CarTyres extends AppModel {
    public $name = 'CarTyres';
    public $validationDomain = 'admin_car_tyres';
    public $validate = array(
        'factory_tyres' => array(
            'rule' => 'notEmpty',
            'message' => 'error_title_empty'
        ),
        'modification_slug' => array(
            'rule' => 'notEmpty',
            'message' => 'error_title_empty'
        ),
        'diameters' => array(
            'rule' => 'notEmpty',
            'message' => 'error_title_empty'
        ),
        'tuning_tyres' => array(
        )
    );
}