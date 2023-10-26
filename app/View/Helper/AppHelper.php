<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper {
	public $max_upload_size = 0;
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings = array());
		if (!$filesize = ini_get('upload_max_filesize')) {
			$filesize = '5M';
		}
		if ($postsize = ini_get('post_max_size')) {
			$this->max_upload_size = min($this->_get_real_size($filesize), $this->_get_real_size($postsize));
		}
		else {
			$this->max_upload_size = $this->_get_real_size($filesize);
		}
	}
	private function _get_real_size($size = 0) {
		if (!$size) {
			return 0;
		}
		$scan['gb'] = 1073741824;
		$scan['g'] = 1073741824;
		$scan['mb'] = 1048576;
		$scan['m'] = 1048576;
		$scan['kb'] = 1024;
		$scan['k'] = 1024;
		$scan['b'] = 1;
		foreach ($scan as $unit => $factor) {
			if (strlen($size) > strlen($unit) && strtolower(substr($size, strlen($size) - strlen($unit))) == $unit) {
				return substr($size, 0, strlen($size) - strlen($unit)) * $factor;
			}
		}
		return $size;
	}
}
