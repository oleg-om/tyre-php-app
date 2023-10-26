<?php
class AdministratorsController extends AppController {
	public $layout = 'admin';
	public $paginate = array(
		'order' => array(
			'Administrator.username' => 'asc'
		)
	);
	public $filter_fields = array('Administrator.id' => 'int', 'Administrator.username' => 'text', 'Administrator.name' => 'text', 'Administrator.email' => 'text', 'Administrator.logged_from' => 'from', 'Administrator.logged_to' => 'to');
	public $model = 'Administrator';
	public function admin_login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			}
			else {
				$this->error($this->Auth->loginError);
			}
		}
		if ($this->Auth->isAuthorized()) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index', 'admin' => true));
		}
		$this->layout = 'login';
		$this->render('admin_login');
	}
	public function admin_logout() {
		$this->Session->delete('permissions');
		$this->redirect($this->Auth->logout());
	}
	public function admin_profile() {
		if (!empty($this->request->data)) {
			$this->{$this->model}->id = $this->Auth->user('id');
			if ($this->{$this->model}->save($this->request->data)) {
				if ($administrator = $this->{$this->model}->read(array('username', 'name', 'email'))) {
					$this->Session->write(AuthComponent::$sessionKey . '.username', $administrator[$this->model]['username']);
					$this->Session->write(AuthComponent::$sessionKey . '.name', $administrator[$this->model]['name']);
					$this->Session->write(AuthComponent::$sessionKey . '.email', $administrator[$this->model]['email']);
				}
				$this->info($this->t('message_profile_updated'));
				$this->redirect(array('controller' => 'administrators', 'action' => 'admin_profile'));
			}
			else {
				$this->error($this->t('error_update_profile'));
			}
		}
		else {
			$this->request->data[$this->model] = $this->Auth->user();
			$this->request->data[$this->model]['change_password'] = 0;
		}
		$this->set('section', $this->getSection($this->getSubmenu()));
		$this->set('submenu', $this->getSubmenu());
		$this->set('title_for_layout', $this->t('title_profile'));
		$this->render('admin_profile');
	}
}