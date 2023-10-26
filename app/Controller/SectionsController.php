<?php
class SectionsController extends AppController {
	public $uses = array();
	public $layout = 'inner';
	public $paginate = array(
		'order' => array(
			'Section.lft' => 'asc'
		)
	);
	public $filter_fields = array('Section.id' => 'int', 'Section.title' => 'text', 'Section.type' => 'text');
	public $model = 'Section';
	public function _list() {
		parent::_list();
		$this->set('types', $this->Section->types);
		$this->set('sections', $this->Section->sections_list);
		$this->set('colors', $this->Section->colors);
	}
	public function _edit($id) {
		$title = parent::_edit($id);
		$this->loadModel('Page');
		$this->set('pages', $this->Page->find('list', array('order' => array('Page.title' => 'asc'), 'fields' => array('Page.id', 'Page.title'))));
		$this->set('parents', $this->Section->find('list', array('conditions' => array('Section.parent_id' => null), 'order' => array('Section.lft' => 'asc'), 'fields' => array('Section.id', 'Section.title'))));
		$this->set('types', $this->Section->types);
		$this->set('sections', $this->Section->sections_list);
		$this->set('colors', $this->Section->colors);
		return $title;
	}
	public function admin_up($id = 0) {
		$filter = $this->redirectFields($this->model, $id);
		$this->loadModel($this->model);
		if ($this->{$this->model}->moveUp($id)) {
			Cache::delete('sections', 'long');
			$this->info($this->t('message_item_moved_up'));
		}
		else {
			$this->error($this->t('error_item_moved_up'));
		}
		$url = array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list');
		$url = array_merge($url, $filter);
		$this->redirect($url);
	}
	public function admin_down($id = 0) {
		$filter = $this->redirectFields($this->model, $id);
		$this->loadModel($this->model);
		if ($this->{$this->model}->moveDown($id)) {
			Cache::delete('sections', 'long');
			$this->info($this->t('message_item_moved_down'));
		}
		else {
			$this->error($this->t('error_item_moved_down'));
		}
		$url = array('controller' => Inflector::underscore($this->name), 'action' => 'admin_list');
		$url = array_merge($url, $filter);
		$this->redirect($url);
	}
}