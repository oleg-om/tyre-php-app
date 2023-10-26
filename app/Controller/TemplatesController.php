<?php
class TemplatesController extends AppController {
	public $name = 'Templates';
	public $uses = array();
	public $layout = 'frontend';
	public $paginate = array(
		'order' => array(
			'Template.title' => 'asc'
		),
		'maxLimit' => 1000
	);
	public $filter_fields = array('Template.id' => 'int', 'Template.title' => 'text', 'Template.subject' => 'text');
	public $model = 'Template';
}
?>