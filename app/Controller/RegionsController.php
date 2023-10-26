<?php
class RegionsController extends AppController {
	public $uses = array();
	public $layout = 'main';
	public $paginate = array(
		'order' => array(
			'Region.sort_order' => 'asc'
		)
	);
	public $filter_fields = array('Region.id' => 'int', 'Region.title' => 'text');
	public $model = 'Region';
	public $submenu = 'regions';
	public function get_cities($region_id) {
		$this->layout = false;
		$data = array(array('' => '...'));
		$this->loadModel('City');
		if ($cities = $this->City->find('all', array('order' => array('City.title' => 'asc'), 'conditions' => array('City.is_active' => 1, 'City.region_id' => $region_id), 'fields' => array('City.id', 'City.title')))) {
			foreach ($cities as $item) {
				$data[] = array($item['City']['id'] => $item['City']['title']);
			}
		}
		echo json_encode($data);
		$this->render(false);
	}
}