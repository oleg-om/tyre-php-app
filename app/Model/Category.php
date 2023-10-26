<?php
class Category extends AppModel {
	public $name = 'Category';
	public $actsAs = array('Tree');
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'message' => 'title_empty'
		),
		'slug' => array(
			array(
				'rule' => 'notEmpty',
				'message' => 'slug_empty',
				'last' => true,
				'required' => true
			),
			array(
				'rule' => '/^[A-z0-9_-]+$/',
				'message' => 'slug_format',
				'last' => true,
				'required' => true
			)
		)
	);
	public $hasMany = array(
		'Field' => array(
			'order' => array(
				'Field.sort_order' => 'asc'
			),
			'dependent' => true
		)
	);
	public $files_path = null;
	public $allowed_file_types = array('image/pjpeg', 'image/jpeg', 'image/gif', 'image/bmp', 'image/png', 'image/x-png');
	public $tmp_file = null;
	public $tmp_ext = null;
	public $tmp_name = null;
	public function __construct() {
		parent::__construct();
		$this->virtualFields['is_deletable'] = 'Category.products_count=0';
		$this->files_path = IMAGES . 'animals';
	}
	public function invalidate($field, $value = true) {
		return parent::invalidate($field, __d('admin_categories', 'error_' . $value));
	}
	function _getFolderById() {
		$id = $this->id;
		$folder = $this->files_path . DS;
		return $folder;
	}
	public function afterSave($created, $options = array()) {
		if ($this->tmp_file != null) {
			$folder = $this->_getFolderById();
			$from = TMP . $this->tmp_file;
			$to = $folder . $this->tmp_name . '.' . $this->tmp_ext;
			unlink($to);
			rename($from, $to);
			chmod($to, 0777);
		}
		Cache::delete('sections', 'long');
	}
	public function beforeSave($options = array()) {
		if (parent::beforeSave()) {
			unset($this->data[$this->name]['is_deletable']);
			app::import('Vendor', 'RemoteTypograf', array('file' => 'remotetypograf' . DS . 'remotetypograf.php'));
			$remoteTypograf = new RemoteTypograf('UTF-8');
			$remoteTypograf->htmlEntities();
			$remoteTypograf->br(false);
			$remoteTypograf->p(true);
			$remoteTypograf->nobr(3);
			$remoteTypograf->quotA('laquo raquo');
			$remoteTypograf->quotB('bdquo ldquo');
			if (isset($this->data[$this->name]['content']) && !empty($this->data[$this->name]['content'])) {
				$this->data[$this->name]['content'] = $remoteTypograf->processText($this->data[$this->name]['content']);
			}
			$remoteTypograf->p(false);
			if (isset($this->data[$this->name]['title']) && !empty($this->data[$this->name]['title'])) {
				$this->data[$this->name]['title'] = $remoteTypograf->processText($this->data[$this->name]['title']);
			}
			$uploaded_image = false;
			$error_message = null;
			if (isset($this->data[$this->name]['file']['tmp_name']) && $this->data[$this->name]['file']['tmp_name'] != '') {
				$this->tmp_file = md5(uniqid(rand(), true));
				$this->tmp_name = $this->data[$this->name]['slug'];
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
									$error_message = 'file_type';
									$uploaded_image = false;
							}
						}
						else {
							$error_message = 'file_corrupted';
						}
					}
					else {
						$error_message = 'file_upload';
					}
				}
				else {
					$error_message = 'file_format';
				}
			}
			if ($uploaded_image) {
				$this->data[$this->name]['filename'] = $this->tmp_name . '.' . $this->tmp_ext;
				unset($this->data[$this->name]['file']);
			}
			elseif (!is_null($error_message)) {
				$this->invalidate('file', $error_message);
				return false;
			}
			return true;
		}
		return false;
	}
	public function beforeDelete($cascade = true) {
		if (parent::beforeDelete()) {
			$data = $this->read(array('is_deletable'));
			if (!$data[$this->name]['is_deletable']) return false;
			return true;
		}
		return false;
	}
	public function recountProducts($ids) {
		if (!is_array($ids)) $ids = array($ids);
		$this->Product = ClassRegistry::init('Product');
		foreach ($ids as $id) {
			$this->id = $id;
			if ($data = $this->read(array('id'))) {
				$products_count = $this->Product->find('count', array('conditions' => array('Product.category_id' => $id)));
				$this->saveField('products_count', $products_count);
			}
		}
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
		Cache::delete('sections', 'long');
		return true;
	}
}