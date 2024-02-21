<?php
class CarGenerationsController extends AppController {
    public $uses = array();
    public $layout = 'inner';
    public $paginate = array(
        'order' => array(
            'CarModification.title' => 'asc'
        )
    );
    public $filter_fields = array('CarModification.id' => 'int', 'CarModification.generation_slug' => 'text', 'CarModification.title' => 'text');
    public $model = 'CarModification';
    public $submenu = 'cars';

    public function view($brand_slug, $model_slug, $generation_slug) {
        $this->category_id = 4;
        $this->loadModel('CarGeneration');
        $this->loadModel('CarBrand');
        $this->loadModel('CarModel');
        $this->loadModel('CarModification');

        if ( $car_modifications = $this->CarModification->find('all', array('conditions' => array('CarModification.is_active' => 1, 'CarModification.generation_slug' => $generation_slug), 'order' => array('CarModification.engine_displacement' => 'asc')))
        ) {
            $brand = $this->CarBrand->find('first', array('conditions' => array('CarBrand.slug' => $brand_slug)));
            $model = $this->CarModel->find('first', array('conditions' => array('CarModel.slug' => $model_slug)));
            $generation = $this->CarGeneration->find('first', array('conditions' => array('CarGeneration.slug' => $generation_slug)));

            $this->set('car_modifications', $car_modifications);

            $breadcrumbs = array();
            $breadcrumbs[] = array(
                'url' => array('controller' => 'car_brands', 'action' => 'index'),
                'title' => 'Подбор по авто'
            );
            $breadcrumbs[] = array(
                'url' => array('controller' => 'car_brands', 'action' => 'view', 'slug' => $brand['CarBrand']['slug']),
                'title' => $brand['CarBrand']['title']
            );
            $breadcrumbs[] = array(
                'url' => array('controller' => 'car_models', 'action' => 'view', 'brand_slug' => $brand['CarBrand']['slug'], 'model_slug' => $model['CarModel']['slug']),
                'title' => $model['CarModel']['title']
            );
            $breadcrumbs[] = array(
                'url' => null,
                'title' => $generation['CarGeneration']['title']
            );
            $this->set('breadcrumbs', $breadcrumbs);
            $this->setMeta('title', 'Подбор по авто ' . $brand['CarBrand']['title'] . ' ' . $model['CarModel']['title'] . ' ' . $generation['CarGeneration']['title']);
            $this->set('brand', $brand);
            $this->set('model', $model);
            $this->set('generation', $generation);
            $this->set('show_left_menu', false);
            $this->set('active_menu', 'selection');
            $this->set('show_filter', 4);
            $this->set('show_switch_params_and_auto', false);
        }
        else {
            $this->response->statusCode(404);
            $this->response->send();
            $this->render(false);
            return;
        }

    }

}