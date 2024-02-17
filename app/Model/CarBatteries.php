<?php
class CarBatteries extends AppModel {
    public $name = 'CarBatteries';
    public $validationDomain = 'admin_car_batteries';
    public $validate = array(
        'modification_slug' => array(
            'rule' => 'notEmpty',
            'message' => 'error_title_empty'
        ),
        'group_label' => array(
            'rule' => 'notEmpty',
            'message' => 'error_title_empty'
        ),
        'appointment' => array(
        ),
        'start_stop' => array(
        ),
        'is_factory' => array(
        ),
        'type_case' => array(
        ),
        'type_case_id' => array(
        ),
        'type_cleat' => array(
        ),
        'type_cleat_id' => array(
        ),
        'polarity' => array(
        ),
        'polarity_id' => array(
        ),
        'capacity_min' => array(
        ),
        'capacity_max' => array(
        ),
        'length_min' => array(
        ),
        'length_max' => array(
        ),
        'width_min' => array(
        ),
        'width_max' => array(
        ),
        'height_min' => array(
        ),
        'height_max' => array(
        ),
        'grouped_params' => array(
        )
    );
}