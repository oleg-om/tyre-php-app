<?php
class ShippingTypesController extends AppController {
	public $uses = array();
	public $layout = 'main';
	public $paginate = array(
		'order' => array(
			'ShippingType.sort_order' => 'asc'
		)
	);
	public $filter_fields = array('ShippingType.id' => 'int', 'ShippingType.title' => 'text');
	public $model = 'ShippingType';
	public $submenu = 'shipping_types';
	public function get_regions($shipping_type_id) {
		$this->layout = false;
		$data = array(array('' => '...'));
		$this->loadModel('Region');
		if ($regions = $this->Region->find('all', array('order' => array('Region.title' => 'asc'), 'conditions' => array('Region.is_active' => 1, 'Region.shipping_type_id' => $shipping_type_id), 'fields' => array('Region.id', 'Region.title')))) {
			foreach ($regions as $item) {
				$data[] = array($item['Region']['id'] => $item['Region']['title']);
			}
		}
		echo json_encode($data);
		$this->render(false);
	}
}