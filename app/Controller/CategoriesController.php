<?php
class CategoriesController extends AppController {
	public $uses = array();
	function admin_brands() {
		Configure::write('debug', 0);
		$category_id = $this->request->query['category_id'];
		$any = 0;
		if (isset($this->request->query['any'])) {
			$any = $this->request->query['any'];
		}
		$this->layout = 'json';
		if ($any) {
			$data = array('' => __d('admin_common', 'list_any_item'));
		}
		else {
			$data = array('' => __d('admin_common', 'list_all_items'));
		}
		$this->loadModel('Brand');
		if ($brands = $this->Brand->find('list', array('conditions' => array('Brand.category_id' => $category_id), 'order' => array('Brand.title' => 'asc'), 'fields' => array('Brand.id', 'Brand.title')))) {
			$data = $data + $brands;
		}
		$this->set(compact('data'));
		$this->render(false);
	}
}