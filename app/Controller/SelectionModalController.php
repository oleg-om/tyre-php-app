<?php
class SelectionModalController extends AppController {
    public $layout = 'empty';
    public $paginate = array(
        'order' => array(
            'CarBrand.title' => 'asc'
        )
    );
    public $model = 'SelectionModal';
    public $submenu = 'selection_modal';

    public function car_brands() {

    }
    public function car_models($slug) {
        $this->loadModel('CarModel');
        $this->set('car_models', $this->CarModel->find('list', array( 'order' => array('CarModel.title' => 'asc'), 'conditions' => array('CarModel.is_active' => 1, 'CarModel.brand_id' => $slug))));
        $this->set('brand_id', $slug);
    }

    public function car_year($brand_slug, $model_slug) {
        $this->loadModel('Car');
        $this->Car->bindModel(
            array(
                'belongsTo' => array(
                    'CarModification' => array(
                        'foreignKey' => 'modification_id'
                    )
                )
            ),
            false
        );
        $all_cars = $this->Car->find('all', array('conditions' => array('Car.brand_id' => $brand_slug, 'Car.model_id' => $model_slug, 'Car.is_active' => 1, 'CarModification.is_active' => 1), 'order' => array('Car.year' => 'asc'), 'fields' => array('Car.year')));
        $used_years = array();
        $cars = array();
        foreach ($all_cars as $item) {
            if (!in_array($item['Car']['year'], $used_years)) {
                $cars[] = $item['Car']['year'];;
                $used_years[] = $item['Car']['year'];
            }
        }
        $this->set('cars', $cars);
        $this->set('$used_years', $used_years);
        $this->set('brand_id', $brand_slug);
        $this->set('model_id', $model_slug);
    }

    public function car_modifications($brand_slug, $model_slug, $year) {
        $data = array(array('0' => '...'));
        $brand_id = intval($brand_slug);
        $model_id = intval($model_slug);
        $year = intval($year);
        $this->loadModel('Car');
        $this->Car->bindModel(
            array(
                'belongsTo' => array(
                    'CarModification' => array(
                        'foreignKey' => 'modification_id'
                    )
                )
            ),
            false
        );

        if ($car_mods = $this->Car->find('all', array('fields' => array('CarModification.id', 'CarModification.title'), 'conditions' => array('Car.brand_id' => $brand_id, 'Car.model_id' => $model_id, 'Car.is_active' => 1, 'Car.year' => $year, 'CarModification.is_active' => 1), 'order' => array('CarModification.title' => 'asc')))) {
            foreach ($car_mods as $item) {
                $data[] = array('id' => $item['CarModification']['id'], 'name' => $item['CarModification']['title']);
            }
        }
        $this->set('modifications', $data);
        $this->set('brand_slug', $brand_slug);
        $this->set('model_slug', $model_slug);
        $this->set('year', $year);
    }
}