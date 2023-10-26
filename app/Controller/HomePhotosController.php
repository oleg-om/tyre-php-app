<?php
class HomePhotosController extends AppController {
	public $uses = array();
	public $layout = 'main';
	public $paginate = array(
		'order' => array(
			'HomePhoto.sort_order' => 'asc'
		)
	);
	public $filter_fields = array('HomePhoto.id' => 'int', 'HomePhoto.link' => 'text');
	public $model = 'HomePhoto';
	public $submenu = 'home_photos';
	function all() {
		$this->loadModel('HomePhoto');
		return $this->HomePhoto->find('all', array('order' => array('HomePhoto.sort_order' => 'asc'), 'conditions' => array('HomePhoto.is_active' => 1), 'fields' => array('HomePhoto.id', 'HomePhoto.filename', 'HomePhoto.link')));
	}
}