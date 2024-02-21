<?php
class CarWheels extends AppModel {
    public $name = 'CarWheels';
    public $validationDomain = 'admin_car_wheels';
    public $validate = array(
        'modification_slug' => array(
            'rule' => 'notEmpty',
            'message' => 'error_title_empty'
        ),
        'group_label' => array(
            'rule' => 'notEmpty',
            'message' => 'error_title_empty'
        ),
        'kit' => array(
        ),
        'factory' => array(
        ),
        'front_axle_title' => array(
        ),
        'front_axle_diameter' => array(
        ),
        'front_axle_pn' => array(
        ),
        'front_axle_pcd' => array(
        ),
        'front_axle_width_min' => array(
        ),
        'front_axle_width_max' => array(
        ),
        'front_axle_et_min' => array(
        ),
        'front_axle_et_max' => array(
        ),
        'front_axle_co_min' => array(
        ),
        'front_axle_co_max' => array(
        ),
        'back_axle_title' => array(
        ),
        'back_axle_diameter' => array(
        ),
        'back_axle_pn' => array(
        ),
        'back_axle_pcd' => array(
        ),
        'back_axle_width_min' => array(
        ),
        'back_axle_width_max' => array(
        ),
        'back_axle_et_min' => array(
        ),
        'back_axle_et_max' => array(
        ),
        'back_axle_co_min' => array(
        ),
        'back_axle_co_max' => array(
        )
    );
}