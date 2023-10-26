<?php
class DashboardController extends AppController {
	public $name = 'Dashboard';
	public $uses = array();
	public $layout = 'admin';
	public function admin_index() {
		if (!empty($this->request->data)) {
			$this->loadModel('Administrator');
			$this->Administrator->id = $this->Auth->user('id');
			if ($this->Administrator->saveField('notes', $this->request->data['Administrator']['notes'])) {
				$this->Session->write(AuthComponent::$sessionKey . '.notes', $this->request->data['Administrator']['notes']);
				$this->info(__d('admin_administrators', 'message_notes_saved'));
				$this->redirect(array('controller' => 'dashboard', 'action' => 'admin_index'));
			}
			else {
				$this->error(__d('admin_administrators', 'error_cannot_save_notes'));
			}
		}
		else {
			$this->request->data['Administrator']['notes'] = $this->Auth->user('notes');
		}
		$this->set('title_for_layout', '');
		$this->render('admin_index');
	}
}