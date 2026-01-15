<?php
class HomePhoto extends AppModel {
	public $name = 'HomePhoto';
	public $validationDomain = 'admin_home_photos';
	public $validate = array(
		'link' => array(
			'rule' => array('url', true),
			'allowEmpty' => true,
			'message' => 'error_link_empty'
		)
	);
	public $files_path = null;
	public $allowed_file_types = array('image/pjpeg', 'image/jpeg', 'image/gif', 'image/bmp', 'image/png', 'image/x-png');
	public $tmp_file = null;
	public $tmp_ext = null;
	public $tmp_name = null;
	public $tmp_data = null;
	public function __construct() {
		parent::__construct();
		$this->virtualFields['is_deletable'] = '1';
		$this->files_path = WWW_ROOT . 'files' . DS . 'slider';
	}
	public function beforeDelete($cascade = true) {
		if (parent::beforeDelete()) {
			$data = $this->read(array('is_deletable'));
			if (!$data[$this->name]['is_deletable']) return false;
			return true;
		}
		return false;
	}
	function _getFolderById() {
		$id = $this->id;
		$folder = $this->files_path . DS . $id . DS;
		if (!is_dir($folder)) {
			mkdir($folder);
			chmod($folder, 0777);
		}
		return $folder;
	}
	public function beforeSave($options = array()) {
		if (parent::beforeSave()) {
			$uploaded_image = false;
			$error_message = null;
			if (isset($this->data[$this->name]['delete_file']) && $this->data[$this->name]['delete_file']) {
				$this->data[$this->name]['filename'] = '';
			}
			if (isset($this->data[$this->name]['file']['tmp_name']) && $this->data[$this->name]['file']['tmp_name'] != '') {
				$this->tmp_file = md5(uniqid(rand(), true));
				$this->tmp_name = time();
				if (in_array($this->data[$this->name]['file']['type'], $this->allowed_file_types)) {
					if (copy($this->data[$this->name]['file']['tmp_name'], TMP . $this->tmp_file)) {
						if ($size = getimagesize(TMP . $this->tmp_file)) {
							$uploaded_image = true;
							switch ($size[2]) {
								case 1:
									$this->tmp_ext = 'gif';
									break;
								case 2:
									$this->tmp_ext = 'jpg';
									break;
								case 3:
									$this->tmp_ext = 'png';
									break;
								case 6:
									$this->tmp_ext = 'bmp';
									break;
								default:
									$error_message = 'error_file_type';
									$uploaded_image = false;
							}
						}
						else {
							$error_message = 'error_file_corrupted';
						}
					}
					else {
						$error_message = 'error_file_upload';
					}
				}
				else {
					$error_message = 'error_file_format';
				}
			}
			elseif (isset($this->data[$this->name]['file']['error']) && $this->data[$this->name]['file']['error'] > 0 && $this->data[$this->name]['file']['error'] != 4) {
				$error_message = 'error_file_size';
			}
			elseif (!$this->exists()) {
				$error_message = 'error_file_empty';
			}
			if ($uploaded_image) {
				$this->data[$this->name]['filename'] = $this->tmp_name . '.' . $this->tmp_ext;
				unset($this->data[$this->name]['file']);
			}
			elseif (!is_null($error_message)) {
				$this->invalidate('file', __d($this->validationDomain, $error_message));
				return false;
			}
			return true;
		}
		return false;
	}
	public function afterSave($created, $options = array()) {
		if ($this->tmp_file != null && !empty($this->id)) {
			$folder = $this->_getFolderById();
			$from = TMP . $this->tmp_file;
			$to = $folder . $this->tmp_name . '.' . $this->tmp_ext;
			if (is_dir($folder)) {
				if ($dh = opendir($folder)) {
					while ($file = readdir($dh)) {
						if ($file != '.' && $file != '..') {
							unlink($folder . $file);
						}
					}
					closedir($dh);
				}
			}
			if (file_exists($from)) {
				rename($from, $to);
				chmod($to, 0777);
			}
		}
		$this->tmp_file = null;
	}
	public function afterDelete() {
		$folder = $this->_getFolderById();
		if ($dh = opendir($folder)) {
			while ($file = readdir($dh)) {
				if ($file != '.' && $file != '..') {
					unlink($folder . $file);
				}
			}
			closedir($dh);
		}
		rmdir($folder);
		return true;
	}
}