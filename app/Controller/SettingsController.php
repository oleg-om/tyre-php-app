<?php
class SettingsController extends AppController {
	public $layout = 'admin';
	public $uses = array();
	public function admin_index() {
		$this->loadModel('Setting');
		$data = $this->Setting->find('all', array('order' => array('Setting.id' => 'asc')));
		
		$Label['PRODUCTINSTOCK']="По умолчанию в фильтре, Шины";
		$Label['PRODUCTINSTOCK2']="По умолчанию в фильтре, Диски";
        $Label['POPULAR_SORT_SEASON']="При сортировки по популярности отображать в первую очередь";
		
		
		
		if (!empty($this->request->data)) {
			//print_r($this->request->data['Setting']);
			
			if(!empty($Label)):
				foreach($this->request->data['Setting'] as $key => $val):
					if(!empty($Label[$key])):
						unset($this->request->data['Setting'][$key]);
						$this->Setting->updateAll(array('value' => 0),array('variable' => $key));
						$this->request->data['Setting'][]=array('value' => 1,'id' => $val);
					endif;
				endforeach;
			endif;
			
			//print_r($this->request->data);
			
			if ($this->Setting->saveAll($this->request->data['Setting'])) {
				$this->info($this->t('message_item_saved'));
				$this->redirect(array('controller' => 'settings', 'action' => 'index'));
			}
			else {
				$this->error($this->t('error_item_not_saved'));
			}
		}
		
		$this->set('Label', $Label);
		$this->set(compact('data'));
		$this->set('section', $this->getSection($this->getSubmenu()));
		$this->set('submenu', $this->getSubmenu());
		$this->set('title_for_layout', $this->t('title_list'));
		$this->render('admin_index');
	}
}