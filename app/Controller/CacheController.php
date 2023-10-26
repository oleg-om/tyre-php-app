<?php
class CacheController extends AppController {
	public $uses = array();
	public $layout = 'debug';
	public function admin_clear() {
		$this->_clearFolder(CACHE);
		$this->info(__d('admin_common', 'message_cache_cleared'));
		$this->redirect($this->referer());
	}
	private function _clearFolder($dir) {
		if ($dh = opendir($dir)) {
			while ($file = readdir($dh)) {
				if ($file != '..' && $file != '.') {
					if (is_dir($dir . DS . $file)) {
						$this->_clearFolder($dir . DS . $file);
					}
					else {
						@unlink($dir . DS . $file);
					}
				}
			}
			closedir($dh);
		}
	}
}