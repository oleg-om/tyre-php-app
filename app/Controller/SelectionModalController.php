<?php
class SelectionModalController extends AppController
{
    public $layout = 'empty';
    public $paginate = array(
        'order' => array(
            'CarBrand.title' => 'asc'
        )
    );
    public $model = 'SelectionModal';
    public $submenu = 'selection_modal';

    public function car_brands($path)
    {
        $this->set('path', $path);
    }

    public function car_models($path, $brand_slug)
    {
        $this->loadModel('CarModel');
        $this->set('car_models', $this->CarModel->find('all', array('order' => array('CarModel.title' => 'asc'), 'conditions' => array('CarModel.is_active' => 1, 'CarModel.brand_slug' => $brand_slug))));
        $this->set('brand_slug', $brand_slug);
        $this->set('path', $path);
    }

    public function car_generation($path, $brand_slug, $model_slug)
    {
        $this->loadModel('CarGeneration');
        $this->loadModel('CarBrand');
        $this->loadModel('CarModel');

        if ($car_generations = $this->CarGeneration->find('all', array('order' => array('CarGeneration.release_year_start' => 'asc'), 'conditions' => array('CarGeneration.is_active' => 1, 'CarGeneration.model_slug' => $model_slug)))) {
            $brand = $this->CarBrand->find('first', array('conditions' => array('CarBrand.slug' => $brand_slug)));
            $model = $this->CarModel->find('first', array('conditions' => array('CarModel.slug' => $model_slug)));
            $this->set('car_generations', $car_generations);

            $this->set('brand', $brand);
            $this->set('model', $model);
            $this->set('path', $path);
        } else {
            $this->response->statusCode(404);
            $this->response->send();
            $this->render(false);
            return;
        }
    }

    public function car_modifications($path, $brand_slug, $model_slug, $generation_slug)
    {
        $this->loadModel('CarGeneration');
        $this->loadModel('CarBrand');
        $this->loadModel('CarModel');
        $this->loadModel('CarModification');

        if ($car_modifications = $this->CarModification->find('all', array('conditions' => array('CarModification.is_active' => 1, 'CarModification.generation_slug' => $generation_slug)))) {
            $brand = $this->CarBrand->find('first', array('conditions' => array('CarBrand.slug' => $brand_slug)));
            $model = $this->CarModel->find('first', array('conditions' => array('CarModel.slug' => $model_slug)));
            $this->set('car_modifications', $car_modifications);

            $this->set('brand', $brand);
            $this->set('model', $model);
            $this->set('path', $path);
        } else {
            $this->response->statusCode(404);
            $this->response->send();
            $this->render(false);
            return;
        }
    }

    function update_session($field, $slug) {
        $this->Session->write($field, $slug);
        print_r(json_encode($this->Session->read($field)));
        exit();
    }

    function remove_session($field) {
        $this->Session->delete($field);
        print_r('OK');
        exit();
    }
}