<?php
class CitiesController extends AppController {
	public $uses = array();
	public $layout = 'main';
	public $paginate = array(
		'order' => array(
			'City.sort_order' => 'asc'
		)
	);
	public $filter_fields = array('City.id' => 'int', 'City.title' => 'text');
	public $model = 'City';
	public $submenu = 'cities';
	public function get_stores($city_id) {
		$this->layout = false;
		$data = array(array('' => '...'));
		$this->loadModel('Store');
		if ($stores = $this->Store->find('all', array('order' => array('Store.id' => 'asc'), 'conditions' => array('Store.is_active' => 1, 'Store.city_id' => $city_id), 'fields' => array('Store.id', 'Store.title')))) {
			foreach ($stores as $item) {
				$data[] = array($item['Store']['id'] => $item['Store']['title']);
			}
		}
		echo json_encode($data);
		$this->render(false);
	}
}