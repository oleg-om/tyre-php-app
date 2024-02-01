<?php
class CarGeneration extends AppModel {
    public $name = 'CarGeneration';
    public $validationDomain = 'admin_car_generations';
    public $validate = array(
        'title' => array(
            'rule' => 'notEmpty',
            'message' => 'error_title_empty'
        ),
        'model_slug' => array(
            'rule' => 'notEmpty',
            'message' => 'error_title_empty'
        ),
        'slug' => array(
            'rule' => 'notEmpty',
            'message' => 'error_title_empty'
        )
    );
}