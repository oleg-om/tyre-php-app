<?php
class BackendHelper extends AppHelper {
	public $helpers = array('Paginator', 'Html', 'Time', 'Number', 'Form', 'Session', 'Renderer');
	public $tabs = null;
	public $fields = array(
		'required' => array(),
		'sluggable' => null,
		'depend' => array()
	);
	public $script = null;
	public $ready_script = null;
	public $model = null;
	public $options = array(
		'show_title' => true,
		'show_submenu' => true,
		'show_selectors' => true,
		'show_paginator' => true,
		'show_limits' => true,
		'show_breadcrumbs' => true
	);
	public $gridColumns = array();
	public $gridButtons = array();
	public $formFields = array();
	public $slotsQueue = array();
	public $tabFields = array();
	public $rowButtons = array();
	public $formButtons = array();
	public $gridFooterCode = '';
	public function _defaultButtons() {
		$this->gridButtons = array(
			'delete' => array(
				'label' => __d('admin_common', 'button_grid_delete'),
				'deletable' => true
			)
		);
		$this->rowButtons = array(
			'edit' => array(
				'label' => __d('admin_common', 'button_row_edit'),
				'deletable' => false,
				'editable' => true
			),
			'delete' => array(
				'label' => __d('admin_common', 'button_row_delete_enabled'),
				'deletable' => true,
				'editable' => false,
				'label_disabled' => __d('admin_common', 'button_row_delete_disabled')
			)
		);
		$this->formButtons = array(
			'save' => array(
				'label' => __d('admin_common', 'button_save'),
				'type' => 'button',
				'class' => 'save-btn',
				'onclick' => 'save();'
			),
			'save_and_exit' => array(
				'label' => __d('admin_common', 'button_save_and_exit'),
				'type' => 'submit',
				'class' => 'save-btn'
			)
		);
	}
	public function sort($title, $key) {
		$sortKey = $this->Paginator->sortKey();
		$sortDir = $this->Paginator->sortDir();
		$defaultModel = $this->Paginator->defaultModel();
		if (strpos($sortKey, $defaultModel) !== false && strpos($key, $defaultModel) === false) {
			$isSorted = ($sortKey === $defaultModel . '.' . $key);
		}
		else {
			$isSorted = ($sortKey === $key);
		}
		if ($isSorted) {
			if ($sortDir == 'asc') {
				$asc = $this->Html->image('admin/ico/asc-on.png', array('alt' => '&#8593;'));
				$desc = $this->Paginator->sort($key, $this->Html->image('admin/ico/desc-off.png', array('alt' => '&#8595;')), array('escape' => false));
			}
			else {
				$asc = $this->Paginator->sort($key, $this->Html->image('admin/ico/asc-off.png', array('alt' => '&#8593;')), array('escape' => false));
				$desc = $this->Html->image('admin/ico/desc-on.png', array('alt' => '&#8595;'));
			}
		}
		else {
			$asc = $this->Paginator->link($this->Html->image('admin/ico/asc-off.png', array('alt' => '&#8593;')), array('sort' => $key, 'direction' => 'asc', 'order' => null), array('escape' => false));
			$desc = $this->Paginator->link($this->Html->image('admin/ico/desc-off.png', array('alt' => '&#8595;')), array('sort' => $key, 'direction' => 'desc', 'order' => null), array('escape' => false));
		}
		return $title . '&nbsp;' . $asc . '&nbsp;' . $desc;
	}
	public function ending($num, $w1, $w2, $w3) {
		$code = $num - floor($num/10)*10;
		$nums = ' '.$num;
		$nums = substr($nums, strlen($nums)-2, 2);
		$num = intval($nums);
		if (($num < 11) || ($num > 20)) {
			switch ($code) {
				case 0:
				case 5:
				case 6:
				case 7:
				case 8:
				case 9:
					return $w1;
					break;
				case 1:
					return $w2;
					break;
				case 2:
				case 3:
				case 4:
					return $w3;
					break;
			}
		}
		else {
			return $w1;
		}
	}
	public function addText($fieldName, $options = array(), $tabName = null) {
		$options = array_merge(
			array(
				'label' => '',
				'acronym' => '',
				'div' => 'item_div',
				'class' => 'w100',
				'required' => false,
				'required_text' => null,
				'disabled' => false,
				'sluggable' => false,
				'default' => ''
			),
			$options
		);
		if ($options['required']) {
			$options['class'] = 'large valid required';
			$this->fields['required'][] = $fieldName;
		}
		$input_options = array();
		if ($options['label'] != false) {
			$text = '<acronym title="' . ($options['acronym'] != '' ? h($options['acronym']) : h($options['label'])) . '">' . h($options['label']) . '</acronym>';
			if (!empty($options['required_text'])) {
				$text .= $options['required_text'];
			}
			$input_options['label'] = array(
				'text' => $text,
				'class' => 'caption'
			);
		}
		else {
			$input_options['label'] = false;
		}
		if ($options['disabled']) {
			$input_options['disabled'] = 'disabled';
		}
		if (isset($options['value'])) {
			$input_options['value'] = $options['value'];
		}
		if ($options['sluggable']) {
			$this->fields['sluggable'] = $fieldName;
		}
		$input_options['class'] = $options['class'];
		$input_options['div'] = $options['div'];
		$input_options['type'] = 'text';
		$input_options['default'] = $options['default'];
		if (is_null($tabName)) {
			$this->slotsQueue[] = array(
				'type' => 'field',
				'fieldName' => $fieldName
			);
			$this->formFields[$fieldName] = $this->Form->input($fieldName, $input_options);
		}
		else {
			$this->tabFields[$tabName][$fieldName] = $this->Form->input($fieldName, $input_options);
		}
	}
	public function addPassword($fieldName, $options = array(), $tabName = null) {
		$options = array_merge(
			array(
				'label' => '',
				'acronym' => '',
				'div' => 'item_div',
				'class' => 'w100',
				'required' => false,
				'required_text' => null,
				'disabled' => false,
				'sluggable' => false,
				'default' => ''
			),
			$options
		);
		if ($options['required']) {
			$options['class'] = 'large valid required';
			$this->fields['required'][] = $fieldName;
		}
		$input_options = array();
		if ($options['label'] != false) {
			$text = '<acronym title="' . ($options['acronym'] != '' ? h($options['acronym']) : h($options['label'])) . '">' . h($options['label']) . '</acronym>';
			if (!empty($options['required_text'])) {
				$text .= $options['required_text'];
			}
			$input_options['label'] = array(
				'text' => $text,
				'class' => 'caption'
			);
		}
		else {
			$input_options['label'] = false;
		}
		if ($options['disabled']) {
			$input_options['disabled'] = 'disabled';
		}
		if ($options['sluggable']) {
			$this->fields['sluggable'] = $fieldName;
		}
		$input_options['class'] = $options['class'];
		$input_options['div'] = $options['div'];
		$input_options['type'] = 'password';
		$input_options['default'] = $options['default'];
		if (is_null($tabName)) {
			$this->slotsQueue[] = array(
				'type' => 'field',
				'fieldName' => $fieldName
			);
			$this->formFields[$fieldName] = $this->Form->input($fieldName, $input_options);
		}
		else {
			$this->tabFields[$tabName][$fieldName] = $this->Form->input($fieldName, $input_options);
		}
	}
	public function addHtml($html, $tabName = null) {
		if (is_null($tabName)) {
			$this->slotsQueue[] = array(
				'type' => 'html',
				'html' => $html
			);
		}
		else {
			$key = 'html_1';
			$i = 2;
			while (isset($this->tabFields[$tabName][$key])) {
				$key = 'html_' . $i;
				$i ++;
			}
			$this->tabFields[$tabName][$key] = $html;
		}
	}
	public function addHidden($fieldName, $options = array(), $tabName = null) {
		$input_options = $options;
		$input_options['type'] = 'hidden';
		if (is_null($tabName)) {
			$this->slotsQueue[] = array(
				'type' => 'field',
				'fieldName' => $fieldName
			);
			$this->formFields[$fieldName] = $this->Form->input($fieldName, $input_options);
		}
		else {
			$this->tabFields[$tabName][$fieldName] = $this->Form->input($fieldName, $input_options);
		}
	}
	public function addFile($fieldName, $options = array(), $tabName = null) {
		$options = array_merge(
			array(
				'label' => '',
				'acronym' => '',
				'div' => 'item_div',
				'class' => 'w100',
				'filesize_message' => __d('admin_common', 'message_filesize', $this->Number->toReadableSize($this->max_upload_size))
			),
			$options
		);
		$input_options = array();
		if ($options['label'] != false) {
			$input_options['label'] = array(
				'text' => '<acronym title="' . ($options['acronym'] != '' ? h($options['acronym']) : h($options['label'])) . '">' . h($options['label']) . $options['filesize_message'] . '</acronym>',
				'class' => 'caption'
			);
		}
		else {
			$input_options['label'] = false;
		}
		$input_options['class'] = $options['class'];
		$input_options['div'] = $options['div'];
		$input_options['type'] = 'file';
		if (is_null($tabName)) {
			$this->slotsQueue[] = array(
				'type' => 'field',
				'fieldName' => $fieldName
			);
			$this->formFields[$fieldName] = $this->Form->input($fieldName, $input_options);
		}
		else {
			$this->tabFields[$tabName][$fieldName] = $this->Form->input($fieldName, $input_options);
		}
	}
	public function addPhoto($fieldName, $options = array(), $tabName = null) {
		$out = '';
		$options = array_merge(
			array(
				'path' => '',
				'width' => 125,
				'height' => 125,
				'folder' => false,
				'remove' => false,
				'crop' => false,
				'watermark' => null,
				'quality' => 85,
                'custom_id' => null
			),
			$options
		);
		if (isset($this->data[$this->options['model']][$fieldName]) && $this->data[$this->options['model']][$fieldName] != '') {
            if ($options['custom_id'] != null) {
                $id = $options['custom_id'];
            } else {
                $id = $this->data[$this->options['model']]['id'];
            }
			$out = $this->Html->div('item_div', $this->Html->image($this->thumbnail(array('filename' => $this->data[$this->options['model']][$fieldName], 'id' => $id, 'path' => $options['path'], 'width' => $options['width'], 'height' => $options['height'], 'folder' => $options['folder'], 'quality' => $options['quality'], 'watermark' => $options['watermark'], 'crop' => $options['crop']))));
			$out .= $this->Form->hidden($fieldName);
			if ($options['remove'] != false) {
				$unlink_options = array(
					'field' => 'delete_file',
					'label' => __d('admin_common', 'label_delete_file'),
					'acronym' => ''
				);
				if (is_array($options['remove'])) {
					$unlink_options = array_merge(
						$unlink_options,
						$options['remove']
					);
				}
				$text = '<acronym title="' . ($unlink_options['acronym'] != '' ? h($unlink_options['acronym']) : h($unlink_options['label'])) . '">' . h($unlink_options['label']) . '</acronym>';
				$out .= $this->Form->input($unlink_options['field'], array('label' => array('text' => $text, 'class' => 'caption-cb'), 'type'=>'checkbox', 'div' => 'item_div', 'between' => '&nbsp;'));
			}
		}
		if (is_null($tabName)) {
			$this->slotsQueue[] = array(
				'type' => 'field',
				'fieldName' => $fieldName
			);
			$this->formFields[$fieldName] = $out;
		}
		else {
			$this->tabFields[$tabName][$fieldName] = $out;
		}
	}
	public function addSelect($fieldName, $options = array(), $tabName = null) {
		$options = array_merge(
			array(
				'label' => '',
				'acronym' => '',
				'div' => 'item_div',
				'class' => 'w100',
				'required' => false,
				'required_text' => null,
				'disabled' => false,
				'options' => array(),
				'empty' => __d('admin_common', 'list_any_item'),
				'depend' => false,
				'multiple' => false,
				'size' => 0
			),
			$options
		);
		if ($options['required']) {
			$this->fields['required'][] = $fieldName;
		}
		$input_options = array();
		if ($options['depend'] != false) {
			$this->fields['depend'][$fieldName] = $options['depend'];
		}
		if ($options['label'] != false) {
			$text = '<acronym title="' . ($options['acronym'] != '' ? h($options['acronym']) : h($options['label'])) . '">' . h($options['label']) . '</acronym>';
			if (!empty($options['required_text'])) {
				$text .= $options['required_text'];
			}
			$input_options['label'] = array(
				'text' => $text,
				'class' => 'caption'
			);
		}
		else {
			$input_options['label'] = false;
		}
		if ($options['disabled']) {
			$input_options['disabled'] = 'disabled';
		}
		$input_options['class'] = $options['class'];
		$input_options['div'] = $options['div'];
		$input_options['options'] = $options['options'];
		$input_options['empty'] = $options['empty'];
		$input_options['multiple'] = $options['multiple'];
		if ($options['required'] == false) {
			$input_options['required'] = false;
		}
		if ($input_options['multiple'] && $options['size'] > 0) {
			$input_options['size'] = $options['size'];
		}
		$input_options['type'] = 'select';
		if (is_null($tabName)) {
			$this->slotsQueue[] = array(
				'type' => 'field',
				'fieldName' => $fieldName
			);
			$this->formFields[$fieldName] = $this->Form->input($fieldName, $input_options);
		}
		else {
			$this->tabFields[$tabName][$fieldName] = $this->Form->input($fieldName, $input_options);
		}
	}
	public function addDate($fieldName, $options = array(), $tabName = null) {
		$options = array_merge(
			array(
				'label' => '',
				'acronym' => '',
				'div' => 'item_div',
				'class' => null,
				'required' => false,
				'required_text' => null,
				'disabled' => false,
				'monthNames' => false,
				'empty' => false,
				'dateFormat' => 'DMY',
				'minYear' => null,
				'maxYear' => null
			),
			$options
		);
		if ($options['required']) {
			$this->fields['required'][] = $fieldName;
		}
		$input_options = array();
		if ($options['label'] != false) {
			$text = '<acronym title="' . ($options['acronym'] != '' ? h($options['acronym']) : h($options['label'])) . '">' . h($options['label']) . '</acronym>';
			if (!empty($options['required_text'])) {
				$text .= $options['required_text'];
			}
			$input_options['label'] = array(
				'text' => $text,
				'class' => 'caption'
			);
		}
		else {
			$input_options['label'] = false;
		}
		if ($options['disabled']) {
			$input_options['disabled'] = 'disabled';
		}
		$input_options['class'] = $options['class'];
		$input_options['div'] = $options['div'];
		$input_options['monthNames'] = $options['monthNames'];
		$input_options['dateFormat'] = $options['dateFormat'];
		if (!empty($options['minYear'])) {
			$input_options['minYear'] = $options['minYear'];
		}
		if (!empty($options['maxYear'])) {
			$input_options['maxYear'] = $options['maxYear'];
		}
		$input_options['empty'] = $options['empty'];
		$input_options['type'] = 'date';
		if (is_null($tabName)) {
			$this->slotsQueue[] = array(
				'type' => 'field',
				'fieldName' => $fieldName
			);
			$this->formFields[$fieldName] = $this->Form->input($fieldName, $input_options);
		}
		else {
			$this->tabFields[$tabName][$fieldName] = $this->Form->input($fieldName, $input_options);
		}
	}
	public function addDateTime($fieldName, $options = array(), $tabName = null) {
		$options = array_merge(
			array(
				'label' => '',
				'acronym' => '',
				'div' => 'item_div',
				'class' => null,
				'required' => false,
				'required_text' => null,
				'disabled' => false,
				'monthNames' => false,
				'dateFormat' => 'DMY',
				'timeFormat' => 24,
				'minYear' => null,
				'maxYear' => null
			),
			$options
		);
		if ($options['required']) {
			$this->fields['required'][] = $fieldName;
		}
		$input_options = array();
		if ($options['label'] != false) {
			$text = '<acronym title="' . ($options['acronym'] != '' ? h($options['acronym']) : h($options['label'])) . '">' . h($options['label']) . '</acronym>';
			if (!empty($options['required_text'])) {
				$text .= $options['required_text'];
			}
			$input_options['label'] = array(
				'text' => $text,
				'class' => 'caption'
			);
		}
		else {
			$input_options['label'] = false;
		}
		if ($options['disabled']) {
			$input_options['disabled'] = 'disabled';
		}
		$input_options['class'] = $options['class'];
		$input_options['div'] = $options['div'];
		$input_options['monthNames'] = $options['monthNames'];
		$input_options['dateFormat'] = $options['dateFormat'];
		$input_options['timeFormat'] = $options['timeFormat'];
		if (!empty($options['minYear'])) {
			$input_options['minYear'] = $options['minYear'];
		}
		if (!empty($options['maxYear'])) {
			$input_options['maxYear'] = $options['maxYear'];
		}
		$input_options['type'] = 'datetime';
		if (is_null($tabName)) {
			$this->slotsQueue[] = array(
				'type' => 'field',
				'fieldName' => $fieldName
			);
			$this->formFields[$fieldName] = $this->Form->input($fieldName, $input_options);
		}
		else {
			$this->tabFields[$tabName][$fieldName] = $this->Form->input($fieldName, $input_options);
		}
	}
	public function addCheckbox($fieldName, $options = array(), $tabName = null) {
		$options = array_merge(
			array(
				'label' => '',
				'acronym' => '',
				'div' => 'item_div',
				'disabled' => false,
				'after' => null
			),
			$options
		);
		$input_options = array();
		if ($options['label'] != false) {
			$input_options['label'] = array(
				'text' => '<acronym title="' . ($options['acronym'] != '' ? h($options['acronym']) : h($options['label'])) . '">' . h($options['label']) . '</acronym>',
				'class' => 'caption-cb'
			);
		}
		else {
			$input_options['label'] = false;
		}
		if ($options['disabled']) {
			$input_options['disabled'] = 'disabled';
		}
		$input_options['after'] = $options['after'];
		$input_options['div'] = $options['div'];
		$input_options['type'] = 'checkbox';
		$input_options['between'] = '&nbsp;';
		if (isset($options['checked'])) {
			$input_options['checked'] = $options['checked'];
		}
		if (is_null($tabName)) {
			$this->slotsQueue[] = array(
				'type' => 'field',
				'fieldName' => $fieldName
			);
			$this->formFields[$fieldName] = $this->Form->input($fieldName, $input_options);
		}
		else {
			$this->tabFields[$tabName][$fieldName] = $this->Form->input($fieldName, $input_options);
		}
	}
	public function addTextarea($fieldName, $options = array(), $tabName = null) {
		$options = array_merge(
			array(
				'label' => '',
				'acronym' => '',
				'div' => 'item_div',
				'class' => 'w100',
				'required_text' => null,
				'disabled' => false,
				'editor' => false,
				'simple_editor' => false,
				'letters_counter' => false
			),
			$options
		);
		$input_options = array();
		if ($options['label'] != false) {
			$text = '<acronym title="' . ($options['acronym'] != '' ? h($options['acronym']) : h($options['label'])) . '">' . h($options['label']) . '</acronym>';
			if (!empty($options['required_text'])) {
				$text .= $options['required_text'];
			}
			if ($options['letters_counter']) {
				$text .= '<span class="letters-counter"></span>';
			}
			$input_options['label'] = array(
				'text' => $text,
				'class' => 'caption'
			);
		}
		else {
			$input_options['label'] = false;
		}
		if ($options['disabled']) {
			$input_options['disabled'] = 'disabled';
		}
		if ($options['editor']) {
			$options['class'] .= ' mceEditor';
		}
		if ($options['simple_editor']) {
			$options['class'] .= ' mceSimpleEditor';
		}
		if (isset($options['value'])) {
			$input_options['value'] = $options['value'];
		}
		$input_options['class'] = $options['class'];
		$input_options['div'] = $options['div'];
		$input_options['type'] = 'textarea';
		if (is_null($tabName)) {
			$this->slotsQueue[] = array(
				'type' => 'field',
				'fieldName' => $fieldName
			);
			$this->formFields[$fieldName] = $this->Form->input($fieldName, $input_options);
		}
		else {
			$this->tabFields[$tabName][$fieldName] = $this->Form->input($fieldName, $input_options);
		}
	}
	public function addTab($key, $title = null) {
		if (empty($this->tabs)) {
			$this->slotsQueue[] = array(
				'type' => 'tabs'
			);
		}
		if (!isset($this->tabs[$key])) {
			$this->tabs[$key] = array(
				'title' => null,
				'fields' => array()
			);
		}
		$this->tabs[$key]['title'] = $title;
	}
	public function addTabField($key, $field = null) {
		$this->tabs[$key]['fields'][] = $field;
	}
	public function setReadyScript($script) {
		$this->ready_script = $script;
	}
	public function setScript($script) {
		$this->script = $script;
	}
	public function getScript() {
		if (!empty($this->fields['required']) || !empty($this->fields['sluggable']) || !empty($this->fields['depend']) || !empty($this->script) || !empty($this->ready_script)) {
			$script = '';
			if (!empty($this->fields['required']) || !empty($this->fields['sluggable']) || !empty($this->fields['depend']) || !empty($this->ready_script)) {
				$script .= '$(document).ready(function(){';
				foreach ($this->fields['required'] as $field) {
					$domId = $this->options['model'] . Inflector::camelize($field);
					$script .= '$(\'#' . $domId . '\').valid();';
				}
				$depend_count = 0;
				foreach ($this->fields['depend'] as $field => $params) {
					$fieldDomId = $this->options['model'] . Inflector::camelize($params['field']);
					$dependDomId = $this->options['model'] . Inflector::camelize($field);
					$script .= '$(\'#' . $fieldDomId . '\').change(handler_' . $params['field'] . ');';
					if ($depend_count == 0) {
						$script .= 'handler_' . $params['field'] . '();';
					}
					$depend_count ++;
				}
				if (!empty($this->fields['sluggable'])) {
					$sluggableDomId = $this->options['model'] . Inflector::camelize($this->fields['sluggable']);
					$slugDomId = $this->options['model'] . 'Slug';
					$script .= '$(\'#' . $sluggableDomId . '\').change(function() {if ($(\'#' . $this->options['model'] . 'Id\').val()==\'\'){$(\'#' . $slugDomId . '\').val(transliterate($(this).val()));$(\'#' . $slugDomId . '\').valid()}});';
				}
				$script .= $this->ready_script;
				$script .= '});';
				foreach ($this->fields['depend'] as $field => $params) {
					$fieldDomId = $this->options['model'] . Inflector::camelize($params['field']);
					$dependDomId = $this->options['model'] . Inflector::camelize($field);
					$script .= 'function handler_' . $params['field'] . '(){var d=parseInt($(\'#' . $fieldDomId . '\').val());if(isNaN(d))d=0;var c=$(\'#' . $dependDomId . '\').val();$(\'#' . $dependDomId . '\').removeOption(/.*/);if(d!=0){loader();$(\'#' . $dependDomId . '\').ajaxAddOption(\'' . $this->url($params['url']) . '/\'+d+\'/1\',{},false,function(){$(\'#' . $dependDomId . '\').val(c);$(\'#' . $dependDomId . '\').change();delete_loader()})}else{$(\'#' . $dependDomId . '\').addOption(\'\',\'' . __d('admin_common', 'list_any_item') . '\')}}';
				}
				$script .= $this->script;
			}
			return $this->Html->scriptBlock($script);
		}
	}
	public function setOptions($options = null) {
		if (!empty($options)) {
			$this->options = array_merge($this->options, $options);
			$this->_defaultButtons();
		}
		else {
			return $this->options;
		}
	}
	public function addColumn($fieldName, $options = null) {
		$this->gridColumns[$fieldName] = $options;
	}
	public function getGridHeader() {
		$out = '';
		if ($this->options['show_title']) {
			$sections = $this->_View->getVar('menu_sections');
			$section = $this->_View->getVar('section');
			$submenu = $this->_View->getVar('submenu');
			$title = $sections[$section]['menu_items'][$submenu]['title'];
			$link = $sections[$section]['menu_items'][$submenu]['link'];
			$subtitle = null;
			if (isset($sections[$section]['menu_items'][$submenu]['submenu'])) {
				foreach ($sections[$section]['menu_items'][$submenu]['submenu'] as $submenu) {
					if (isset($submenu['items'][0])) {
						if ($submenu['items'][0]['link']['controller'] == $this->options['controller']) {
							$subtitle = $submenu['title'];
						}
					}
				}
			}
			if (!empty($subtitle) && $subtitle != $title) {
				$out .= '<h1>' . $this->Html->link($title, $link) . ' &rarr; ' . h($subtitle) . '</h1>';
			}
			else {
				$out .= '<h1>' . h($title) . '</h1>';
			}
		}
		if ($this->options['show_submenu']) {
			$out .= $this->_View->element('admin_submenu');
		}
		$out .= $this->Session->flash('error');
		$out .= $this->Session->flash('info');
		$out .= $this->Form->create($this->options['model'], array('action' => 'admin_action', 'id' => 'frm-grid'));
		if (isset($this->_View->params['named']['page'])) {
			$page = $this->_View->params['named']['page'];
			$out .= $this->Form->hidden('page', array('value' => $page));
		}
		if (isset($this->_View->params['named']['sort'])) {
			$sort = $this->_View->params['named']['sort'];
			$out .= $this->Form->hidden('sort', array('value' => $sort));
		}
		if (isset($this->_View->params['named']['direction'])) {
			$direction = $this->_View->params['named']['direction'];
			$out .= $this->Form->hidden('direction', array('value' => $direction));
		}
		$default_field_options = array(
			'type' => 'text',
			'filterable' => true,
			'sortable' => true,
			'editable' => false,
			'counter' => false,
			'options' => array(),
			'empty' => __d('admin_common', 'list_all_items'),
			'align' => 'a-left',
			'renderer' => false,
			'format' => 'd.m.Y',
		);
		$has_filter = false;
		foreach ($this->gridColumns as $key => $column) {
			$column = array_merge($default_field_options, $column);
			if ($column['type'] == 'number' && !isset($this->gridColumns[$key]['align'])) {
				$column['align'] = 'a-center';
			}
			elseif ($column['counter'] && !isset($this->gridColumns[$key]['align'])) {
				$column['align'] = 'a-center';
			}
			if ($column['filterable']) {
				$has_filter = true;
			}
			if ($column['counter']) {
				if (!isset($column['label'])) $column['label'] = '';
				$column['label'] = $this->Html->image('admin/ico/counter.png', array('align' => 'absmiddle', 'title' => $column['label'], 'alt' => $column['label']));
				if ($column['sortable']) {
					$column['width'] = 50;
				}
				else {
					$column['width'] = 35;
				}
				$column['filterable'] = false;
			}
			else {
				if (!isset($column['label']) || empty($column['label'])) {
					$column['label'] = '&nbsp;';
				}
				else {
					$column['label'] = h($column['label']);
				}
			}
			$this->gridColumns[$key] = $column;
		}
		$has_row_buttons = count($this->rowButtons) > 0;
		$out .= '<table width="100%" cellpadding="2" cellspacing="2" id="grid">';
		if ($this->options['show_selectors']) {
			$out .= '<col width="25px" />';
		}
		foreach ($this->gridColumns as $key => $column) {
			if (isset($column['width'])) {
				$out .= '<col width="' . $column['width'] . 'px" />';
			}
			else {
				$out .= '<col />';
			}
		}
		if ($has_row_buttons) {
			if ($has_filter && count($this->rowButtons) == 1) {
				$width = 54;
			}
			else {
				$width = 14 + 20 * count($this->rowButtons);
			}
			$out .= '<col width="' . $width . 'px" />';
		}
		elseif ($has_filter) {
			$out .= '<col width="54px" />';
		}
		$out .= '<thead><tr class="admin_table_title">';
		if ($this->options['show_selectors']) {
			$out .= '<td>&nbsp;</td>';
		}
		foreach ($this->gridColumns as $key => $column) {
			$class = '';
			if ($column['counter']) {
				$class = ' class="a-center"';
			}
			if ($column['sortable']) {
				$out .= '<td' . $class . '>' . $this->sort($column['label'], $key) . '</td>';
			}
			else {
				$out .= '<td' . $class . '>' . $column['label'] . '</td>';
			}
		}
		if ($has_row_buttons || $has_filter) {
			$out .= '<td>&nbsp;</td>';
		}
		$out .= '</tr>';
		if ($has_filter || $this->options['show_selectors']) {
			$out .= '<tr class="admin_table_filter">';
			if ($this->options['show_selectors']) {
				$out .= '<td class="a-center"><input id="grid-selector" name="grid-selector" type="checkbox" /></td>';
			}
			foreach ($this->gridColumns as $key => $column) {
				if ($column['filterable']) {
					switch ($column['type']) {
						case 'text':
						case 'number':
							$out .= '<td class="empty"><div class="field-100">' . $this->Form->text($key, array('class' => 'input-text')) . '</div></td>';
							break;
						case 'list':
							$out .= '<td class="empty">' . $this->Form->select($key, $column['options'], array('class' => 'w100', 'empty' => $column['empty'], 'escape' => false)). '</td>';
							break;
						case 'date':
							$out .= '<td class="empty"><div class="date-100">' . $this->Form->text($key . '_from', array('class' => 'input-text')) .'</div><div class="date-100 ds">' . $this->Form->text($key . '_to', array('class' => 'input-text')) . '</div></td>';
							break;
						default:
							$out .= '<td class="empty">&mdash;</td>';
					}
				}
				else {
					$out .= '<td class="empty">&mdash;</td>';
				}
			}
			if ($has_filter) {
				$out .= '<td class="v-middle">' . $this->Html->link($this->Html->image('admin/ico/add-filter.png', array('alt' => __d('admin_common', 'button_filter_add'))), 'javascript:void(0);', array('title' => __d('admin_common', 'button_filter_add'), 'onclick' => 'filter();', 'class' => 'image-btn no-loader', 'escape' => false)) . $this->Html->link($this->Html->image('admin/ico/reset-filter.png', array('alt' => __d('admin_common', 'button_filter_reset'))), 'javascript:void(0);', array('title' => __d('admin_common', 'button_filter_reset'), 'onclick' => 'reset_filter();', 'class' => 'image-btn no-loader', 'escape' => false)) . '</td>';
			}
			$out .= '</tr>';
		}
		$out .= '</thead>';
		return $out;
	}
	public function getGridContent() {
		$out = '';
		$data = $this->_View->getVar('data');
		$named_params = $this->request->params['named'];
		$has_row_buttons = count($this->rowButtons) > 0;
		$has_filter = false;
		foreach ($this->gridColumns as $key => $column) {
			if ($column['filterable']) {
				$has_filter = true;
				break;
			}
		}
		$out .= '<tbody>';
		if (count($data) > 0) {
			$model = $this->options['model'];
			$controller = $this->options['controller'];
			$i = 0;
			foreach ($data as $item) {
				$out .= '<tr class="row_table' . ($i % 2 == 1 ? '_odd' : '') .'">';
				if (!isset($item[$model]['is_editable'])) {
					$item[$model]['is_editable'] = true;
				}
				if ($this->options['show_selectors']) {
					if (!isset($item[$model]['is_deletable'])) {
						$item[$model]['is_deletable'] = true;
					}
					if (!$item[$model]['is_editable']) {
						$item[$model]['is_deletable'] = false;
					}
					$disabled = array();
					if (!$item[$model]['is_deletable'] && count($this->gridButtons) == 1) {
						$disabled = array('disabled' => 'disabled');
					}
					$out .= '<td class="a-center">' . $this->Form->checkbox($model . '.' . $item[$model]['id'] . '.delete', $disabled) . '</td>';
				}
				foreach ($this->gridColumns as $key => $column) {
					if ($column['renderer'] !== false) {
						$out .= $this->Renderer->{$column['renderer']}($item[$model], $model);
					}
					else {
						$class = $column['align'];
						if ($column['editable']) {
							$class .= ' bold';
						}
						$value = null;
						switch ($column['type']) {
							case 'list':
								if (isset($column['all_options'])) {
									if (isset($column['all_options'][$item[$model][$key]])) {
										$value = $column['all_options'][$item[$model][$key]];
									}
								}
								else {
									if (isset($column['options'][$item[$model][$key]])) {
										$value = $column['options'][$item[$model][$key]];
									}
								}
								break;
							case 'date':
								if ($item[$model][$key] != '0000-00-00' && $item[$model][$key] != '0000-00-00 00:00:00') {
									$value = $this->Time->format($column['format'], $item[$model][$key]);
								}
								break;
							default:
								$value = $item[$model][$key];
						}
						if ($column['type'] == 'switcher') {
							$out .= $this->_View->element('switcher', array('id' => $item[$model]['id'], 'url' => '/admin/' . $controller . '/', 'icon' => $column['icon'], 'url_enabled' => $column['url_enabled'], 'url_disabled' => $column['url_disabled'], 'title_enabled' => $column['title_enabled'], 'title_disabled' => $column['title_disabled'], 'prefix' => $column['prefix'], 'status' => $item[$model][$key]));
						}
						else {
							if ($column['editable'] && isset($item[$model]['is_editable']) && $item[$model]['is_editable']) {
								$out .= '<td class="' . $class . '">' . $this->Html->link($value, array('controller' => $controller, 'action' => 'edit', $item[$model]['id']), array('escape' => false)) . '</td>';
							}
							else {
								if (!is_null($value)) {
									$out .= '<td class="' . $class . '">' . h($value) . '</td>';
								}
								else {
									$out .= '<td class="a-center">&mdash;</td>';
								}
							}
						}
					}
				}
				if ($has_row_buttons) {
					$buttons = array();
					foreach ($this->rowButtons as $key => $button) {
						if (isset($button['class'])) {
							$class = $button['class'];
						}
						if (isset($button['target'])) {
							$target = $button['target'];
						}
						else {
							$target = null;
						}
						if (!isset($button['editable'])) {
							$button['editable'] = false;
						}
						if (!isset($button['deletable'])) {
							$button['deletable'] = false;
						}
						if ($button['deletable']) {
							if ($item[$model]['is_deletable']) {
								if (isset($button['class'])) {
									$class = $button['class'];
								}
								else {
									$class = 'no-loader confirm';
								}
								$url = array('controller' => $controller, 'action' => $key, $item[$model]['id']) + $named_params;
								$buttons[] = $this->Html->link($this->Html->image('admin/ico/' . $key . '-on.png', array('alt' => $button['label'])), $url, array('title' => $button['label'], 'class' => $class, 'target' => $target, 'escape' => false));
							}
							else {
								$buttons[] = $this->Html->image('admin/ico/' . $key . '-off.png', array('alt' => $button['label_disabled']));
							}
						}
						elseif ($button['editable']) {
							if (isset($item[$model]['is_editable']) && $item[$model]['is_editable']) {
								if (isset($button['class'])) {
									$class = $button['class'];
								}
								else {
									$class = null;
								}
								$buttons[] = $this->Html->link($this->Html->image('admin/ico/' . $key . '-on.png', array('alt' => $button['label'])), array('controller' => $controller, 'action' => $key, $item[$model]['id']), array('title' => $button['label'], 'class' => $class, 'target' => $target, 'escape' => false));
							}
							else {
								$buttons[] = $this->Html->image('admin/ico/' . $key . '-off.png', array('alt' => $button['label_disabled']));
							}
						}
						else {
							if (isset($button['class'])) {
								$class = $button['class'];
							}
							else {
								$class = null;
							}
							$url = array('controller' => $controller, 'action' => $key, $item[$model]['id']) + $named_params;
							$buttons[] = $this->Html->link($this->Html->image('admin/ico/' . $key . '-on.png', array('alt' => $button['label'])), $url, array('title' => $button['label'], 'class' => $class, 'target' => $target, 'escape' => false));
						}
					}
					$out .= '<td class="a-center">' . implode('&nbsp;', $buttons) . '</td>';
				}
				elseif ($has_filter) {
					$out .= '<td class="a-center">&mdash;</td>';
				}
				$out .= '</tr>';
				$i ++;
			}
		}
		$out .= '</tbody></table>';
		return $out;
	}
	public function getGridFooter() {
		$out = '';
		$model = $this->options['model'];
		$controller = $this->options['controller'];
		$data = $this->_View->getVar('data');
		$limits = $this->_View->getVar('limits');
		$filter_fields = $this->_View->getVar('filter_fields');
		if (count($data) > 0) {
			if ($this->options['show_limits'] || count($this->gridButtons) > 0) {
				$out .= '<table class="light_table" width="100%" border="1" cellpadding="5" cellspacing="0"><col />';
				if ($this->options['show_limits']) {
					$out .= '<col width="67px" />';
				}
				$out .= '<tbody><tr>';
				if (count($this->gridButtons) > 0) {
					$buttons = array();
					foreach ($this->gridButtons as $key => $button) {
						$onclick_handler = null;
						if (isset($button['onclick'])) {
							$onclick_handler = $button['onclick'];
						}
						if ($button['deletable']) {
							if (empty($onclick_handler)) {
								$onclick_handler = 'set_action(\'/admin/' . $controller . '/' . $key . '\', 1, \'' . __d('admin_common', 'message_delete_confirm') . '\');';
							}
							$buttons[] = $this->Html->link($this->Html->image('admin/ico/' . $key . '-on.png', array('alt' => $button['label'])), 'javascript:void(0);', array('title' => $button['label'], 'onclick' => $onclick_handler, 'escape' => false));
							$buttons[] = $this->Html->link($button['label'], 'javascript:void(0);', array('title' => $button['label'], 'class' => 'admin_form_action_alert_link no-loader', 'onclick' => $onclick_handler));
						}
						else {
							if (empty($onclick_handler)) {
								$onclick_handler = 'set_action(\'/admin/' . $controller . '/' . $key . '\');';
							}
							$buttons[] = $this->Html->link($this->Html->image('admin/ico/' . $key . '-on.png', array('alt' => $button['label'])), 'javascript:void(0);', array('title' => $button['label'], 'onclick' => $onclick_handler, 'escape' => false));
							$buttons[] = $this->Html->link($button['label'], 'javascript:void(0);', array('title' => $button['label'], 'class' => 'admin_form_action_link no-loader', 'onclick' => $onclick_handler));
						}
					}
					$out .= '<td><div class="admin_form_action">' . implode('&nbsp;', $buttons) . '</div></td>';
				}
				else {
					$out .= '<td></td>';
				}
				if ($this->options['show_limits']) {
					$out .= '<td class="a-center">';
					$out .= $this->Form->select('limit', $limits, array('onchange' => 'limit(this.value);', 'empty' => false));
					$out .= '</td>';
				}
				$out .= '</tr></tbody></table>';
			}
			if ($this->options['show_paginator']) {
				$this->Paginator->options(array('url' => $this->_View->passedArgs));
				$out .= '<div class="clear">&nbsp;</div>';
				$out .= '<div class="pager">';
				$out .= $this->Paginator->numbers(array('class' => 'page_link', 'separator' => '', 'modulus' => 15, 'last' => __d('admin_common', 'page_last'), 'first' => __d('admin_common', 'page_first')));
				$out .= '</div>';
			}
		}
		else {
			$out .= '<p class="a-center bold">' . __d('admin_' . $this->options['controller'], 'message_items_not_found') . '</p>';
		}
		$out .= '<div class="clear"></div>';
		$out .= $this->gridFooterCode;
		$out .= $this->Form->end();
		foreach($filter_fields as $key => $value) {
			$filter_fields[$key] = '\'' . $value . '\'';
		}
		$script = 'var model=\'' . $model . '\',here=\'' . $this->_View->here . '\',filter_fields=[' . implode(',', $filter_fields) . '];';
		$script .= '$(document).ready(function(){';
		$script .= '$(\'.date-100 input\').datepicker({buttonImage:\'/img/admin/ico/calendar.png\',buttonImageOnly:true,showOn:\'both\',dateFormat:\'dd.mm.yy\'});';
		$depend_count = 0;
		foreach ($this->gridColumns as $key => $column) {
			if (isset($column['depend'])) {
				$params = $column['depend'];
				$fieldDomId = $model . Inflector::camelize($params['field']);
				$dependDomId = $model . Inflector::camelize($key);
				$script .= '$(\'#' . $fieldDomId . '\').change(handler_' . $params['field'] . ');';
				if ($depend_count == 0) {
					$script .= 'handler_' . $params['field'] . '();';
				}
				$depend_count ++;
			}
		}
		$script .= '});';
		foreach ($this->gridColumns as $key => $column) {
			if (isset($column['depend'])) {
				$params = $column['depend'];
				$fieldDomId = $model . Inflector::camelize($params['field']);
				$dependDomId = $model . Inflector::camelize($key);
				$script .= 'function handler_' . $params['field'] . '(){var d=parseInt($(\'#' . $fieldDomId . '\').val());if(isNaN(d))d=0;var c=$(\'#' . $dependDomId . '\').val();$(\'#' . $dependDomId . '\').removeOption(/.*/);if(d!=0){loader();$(\'#' . $dependDomId . '\').ajaxAddOption(\'' . $this->url($params['url']) . '/\'+d,{},false,function(){$(\'#' . $dependDomId . '\').val(c);$(\'#' . $dependDomId . '\').change();delete_loader()})}else{$(\'#' . $dependDomId . '\').addOption(\'\',\'' . __d('admin_common', 'list_all_items') . '\')}}';
			}
		}
		$out .= $this->Html->scriptBlock($script);
		return $out;
	}
	public function setGridButton($button, $options = array()) {
		$default_options = array(
			'deletable' => false
		);
		if (isset($this->gridButtons[$button])) {
			$this->gridButtons[$button] = array_merge($default_options, $this->gridButtons[$button], $options);
		}
		else {
			$this->gridButtons[$button] = array_merge($default_options, $options);;
		}
		if (isset($options['before'])) {
			$buttons = array();
			foreach ($this->gridButtons as $button_key => $button_options) {
				if ($button_key == $options['before']) {
					$buttons[$button] = $this->gridButtons[$button];
				}
				if ($button_key != $button) {
					$buttons[$button_key] = $button_options;
				}
			}
			$this->gridButtons = $buttons;
		}
		elseif (isset($options['after'])) {
			if ($options['after'] == '-') {
				$buttons = array();
				$buttons[$button] = $this->gridButtons[$button];
				foreach ($this->gridButtons as $button_key => $button_options) {
					if ($button_key != $button) {
						$buttons[$button_key] = $button_options;
					}
				}
				$this->gridButtons = $buttons;
			}
			else {
				$buttons = array();
				foreach ($this->gridButtons as $button_key => $button_options) {
					if ($button_key != $button) {
						$buttons[$button_key] = $button_options;
					}
					if ($button_key == $options['after']) {
						$buttons[$button] = $this->gridButtons[$button];
					}
				}
				$this->gridButtons = $buttons;
			}
		}
		return true;
	}
	public function setGridFooterCode($code) {
		$this->gridFooterCode .= $code;
		return true;
	}
	public function removeGridButton($button) {
		if (isset($this->gridButtons[$button])) {
			unset($this->gridButtons[$button]);
			true;
		}
		else {
			return false;
		}
	}
	public function setRowButton($button, $options = array()) {
		$default_options = array(
			'deletable' => false
		);
		if (isset($this->rowButtons[$button])) {
			$this->rowButtons[$button] = array_merge($default_options, $this->rowButtons[$button], $options);
		}
		else {
			$this->rowButtons[$button] = array_merge($default_options, $options);
		}
		if (isset($options['before'])) {
			$buttons = array();
			foreach ($this->rowButtons as $button_key => $button_options) {
				if ($button_key == $options['before']) {
					$buttons[$button] = $this->rowButtons[$button];
				}
				if ($button_key != $button) {
					$buttons[$button_key] = $button_options;
				}
			}
			$this->rowButtons = $buttons;
		}
		elseif (isset($options['after'])) {
			if ($options['after'] == '-') {
				$buttons = array();
				$buttons[$button] = $this->rowButtons[$button];
				foreach ($this->rowButtons as $button_key => $button_options) {
					if ($button_key != $button) {
						$buttons[$button_key] = $button_options;
					}
				}
				$this->rowButtons = $buttons;
			}
			else {
				$buttons = array();
				foreach ($this->rowButtons as $button_key => $button_options) {
					if ($button_key != $button) {
						$buttons[$button_key] = $button_options;
					}
					if ($button_key == $options['after']) {
						$buttons[$button] = $this->rowButtons[$button];
					}
				}
				$this->rowButtons = $buttons;
			}
		}
		return true;
	}
	public function removeRowButton($button) {
		if (isset($this->rowButtons[$button])) {
			unset($this->rowButtons[$button]);
			return true;
		}
		else {
			return false;
		}
	}

	public function setFormButton($button, $options = array()) {
		$default_options = array(
			'class' => 'save-btn',
			'type' => 'button'
		);
		if (isset($this->formButtons[$button])) {
			$this->formButtons[$button] = array_merge($default_options, $this->formButtons[$button], $options);
		}
		else {
			$this->formButtons[$button] = array_merge($default_options, $options);
		}
		if (isset($options['before'])) {
			$buttons = array();
			foreach ($this->formButtons as $button_key => $button_options) {
				if ($button_key == $options['before']) {
					$buttons[$button] = $this->formButtons[$button];
				}
				if ($button_key != $button) {
					$buttons[$button_key] = $button_options;
				}
			}
			$this->formButtons = $buttons;
		}
		elseif (isset($options['after'])) {
			if ($options['after'] == '-') {
				$buttons = array();
				$buttons[$button] = $this->formButtons[$button];
				foreach ($this->formButtons as $button_key => $button_options) {
					if ($button_key != $button) {
						$buttons[$button_key] = $button_options;
					}
				}
				$this->formButtons = $buttons;
			}
			else {
				$buttons = array();
				foreach ($this->formButtons as $button_key => $button_options) {
					if ($button_key != $button) {
						$buttons[$button_key] = $button_options;
					}
					if ($button_key == $options['after']) {
						$buttons[$button] = $this->formButtons[$button];
					}
				}
				$this->formButtons = $buttons;
			}
		}
		return true;
	}
	public function removeFormButton($button) {
		if (isset($this->formButtons[$button])) {
			unset($this->formButtons[$button]);
			return true;
		}
		else {
			return false;
		}
	}
	public function thumbnail($params) {
		$filename = '';
		$path = '';
		$id = '';
		$width = 125;
		$height = 125;
		$quality = 85;
		$crop = false;
		$folder = false;
		$tyre = false;
		$watermark = null;
		extract($params);
		app::import('Vendor', 'phpthumb', array('file' => 'phpthumb' . DS . 'phpthumb.class.php'));
		$thumbnail = new phpthumb;
		if ($folder) {
			$folder = (floor($id / 5000) + 1);

			$thumbnail->src = IMAGES . $path . DS . $folder . DS . $id . DS . $filename;
		}
		else {
			$thumbnail->src = IMAGES . $path . DS . $id . DS . $filename;
		}
		$thumbnail->w = $width;
		$thumbnail->h = $height;
		$thumbnail->q = $quality;
		if ($crop) {
			$thumbnail->zc = 'C';
		}
		if ($folder) {
			$thumbnail->config_cache_directory = IMAGES . $path . DS . $folder . DS . $id . DS;
		}
		else {
			$thumbnail->config_cache_directory = IMAGES . $path . DS . $id . DS;
		}
		$cacheFilename = $width . 'x' . $height . '_' . $filename;
		if ($tyre && is_file($thumbnail->config_cache_directory . $cacheFilename)) {
			$tyre = false;
		}
		if ($tyre) {
			// first resize
			$thumbnail->zc = 'C';
			$thumbnail->w = 400;
			$thumbnail->h = 400;
			$thumbnail->config_imagemagick_path = IMAGEMAGICK . 'convert';
			$thumbnail->config_prefer_imagemagick = PREFER_IMAGEMAGICK;
			$thumbnail->config_output_format = substr($filename, -3);
			$thumbnail->config_error_die_on_error = false;
			$thumbnail->config_document_root = '';
			$thumbnail->config_temp_directory = TMP;
			$thumbnail->config_cache_directory = TMP;
			$thumbnail->config_cache_disable_warning = true;
			$cacheFilename = '400x400_' . $filename;
			$thumbnail->cache_filename = $thumbnail->config_cache_directory . $cacheFilename;  
			if ($thumbnail->GenerateThumbnail()) {
				$thumbnail->RenderToFile($thumbnail->cache_filename);
				chmod($thumbnail->cache_filename, 0777);
			}
			// second resize
			$thumbnail = new phpthumb;
			$thumbnail->w = 400;
			$thumbnail->h = 400;
			$thumbnail->zc = '0';
			$thumbnail->sx = 30;
			$thumbnail->sy = 0;
			$thumbnail->sw = 400;
			$thumbnail->sh = 320;
			$tyre_400 = TMP . $cacheFilename;
			$thumbnail->src = $tyre_400;
			$thumbnail->config_imagemagick_path = IMAGEMAGICK . 'convert';
			$thumbnail->config_prefer_imagemagick = PREFER_IMAGEMAGICK;
			$thumbnail->config_output_format = substr($filename, -3);
			$thumbnail->config_error_die_on_error = false;
			$thumbnail->config_document_root = '';
			$thumbnail->config_temp_directory = TMP;
			$thumbnail->config_cache_directory = TMP;
			$thumbnail->config_cache_disable_warning = true;
			$cacheFilename = '184x184_' . $filename;
			$thumbnail->cache_filename = $thumbnail->config_cache_directory . $cacheFilename;  
			if ($thumbnail->GenerateThumbnail()) {
				$thumbnail->RenderToFile($thumbnail->cache_filename);
				chmod($thumbnail->cache_filename, 0777);
			}
			// third resize
			$thumbnail = new phpthumb;
			$thumbnail->w = $width;
			$thumbnail->h = $height;
			$thumbnail->q = $quality;
			$tyre_original = TMP . $cacheFilename;
			$thumbnail->src = $tyre_original;

		}
		$thumbnail->config_imagemagick_path = IMAGEMAGICK . 'convert';
		$thumbnail->config_prefer_imagemagick = PREFER_IMAGEMAGICK;
		$thumbnail->config_output_format = substr($filename, -3);
		$thumbnail->config_error_die_on_error = false;
		$thumbnail->config_document_root = '';
		$thumbnail->config_temp_directory = TMP;
		if (!empty($watermark)) {
			// Always apply watermark if specified, check file existence first
			if (is_file($thumbnail->src)) {
				if ($size = getimagesize($thumbnail->src)) {
					if ($size[0] < 400) {
						$watermark = 'wm-small.png';
					}
				}
				$watermark_path = ROOT . DS . 'watermark' . DS . $watermark;
				if (is_file($watermark_path)) {
					$thumbnail->fltr[] = 'wmi|' . $watermark_path . '|B';
				}
			}
		}
		if ($folder) {
			$thumbnail->config_cache_directory = IMAGES . $path . DS . $folder . DS . $id . DS;
		}
		else {
			$thumbnail->config_cache_directory = IMAGES . $path . DS . $id . DS;
		}
		$thumbnail->config_cache_disable_warning = true;
		$cacheFilename = $width . 'x' . $height . '_' . $filename;
		// Include watermark in cache filename to ensure different cache for watermarked and non-watermarked versions
		if (!empty($watermark)) {
			$watermark_name = str_replace('.png', '', $watermark);
			$cacheFilename = $width . 'x' . $height . '_wm_' . $watermark_name . '_' . $filename;
		}
		$thumbnail->cache_filename = $thumbnail->config_cache_directory . $cacheFilename;  
		if (!is_file($thumbnail->cache_filename)) {
			if ($thumbnail->GenerateThumbnail()) {
				$thumbnail->RenderToFile($thumbnail->cache_filename);
				chmod($thumbnail->cache_filename, 0777);
			}
		}
		if ($tyre) {
			@unlink($tyre_original);
			@unlink($tyre_400);
		}
		if (is_file($thumbnail->cache_filename)) {
			if ($folder) {
				return '/files/' . $path . '/' . $folder . '/' . $id . '/' . $cacheFilename;
			}
			else {
				return '/files/' . $path . '/' . $id . '/' . $cacheFilename;
			}
		}
		return '/img/spacer.gif';
	}
	public function getFormHeader() {
		$action = $this->_View->getVar('action');
		$title_for_layout = $this->_View->getVar('title_for_layout');
		$html = '';
		if ($this->options['show_title']) {
			$sections = $this->_View->getVar('menu_sections');
			$section = $this->_View->getVar('section');
			$submenu = $this->_View->getVar('submenu');
			$title = $sections[$section]['menu_items'][$submenu]['title'];
			$link = $sections[$section]['menu_items'][$submenu]['link'];
			$subtitle = null;
			if (isset($sections[$section]['menu_items'][$submenu]['submenu'])) {
				foreach ($sections[$section]['menu_items'][$submenu]['submenu'] as $submenu) {
					if (isset($submenu['items'][0])) {
						if ($submenu['items'][0]['link']['controller'] == $this->options['controller']) {
							$subtitle = $submenu['title'];
						}
					}
				}
			}
			if (!empty($title_for_layout) && $title_for_layout != $title) {
				$html .= '<h1>' . $this->Html->link($title, $link) . ' &rarr; ' . $title_for_layout . '</h1>';
			}
			elseif (!empty($subtitle) && $subtitle != $title) {
				$html .= '<h1>' . $this->Html->link($title, $link) . ' &rarr; ' . $subtitle . '</h1>';
			}
			else {
				$html .= '<h1>' . $title . '</h1>';
			}
		}
		if ($this->options['show_submenu']) {
			$html .= $this->_View->element('admin_submenu');
		}
		$html .= $this->Session->flash('error');
		$html .= $this->Session->flash('info');
		if ($this->options['show_breadcrumbs']) {
			//$html .= '<p>' . $this->Html->link(__d('admin_' . $this->options['controller'], 'title_list'), array('controller' => $this->options['controller'], 'action' => 'admin_list', 'admin' => true)) . '</p>';
		}
		$html .= $this->Form->create($this->options['model'], array('url' => array('controller' => $this->options['controller'], 'action' => $action), 'id' => 'frm', 'type' => 'file'));
		return $html;
	}
	public function getFormFooter() {
		$html = '';
		$buttons = array();
		foreach ($this->formButtons as $key => $button) {
			$button_options = array();
			$type = 'button';
			$label = '';
			if (isset($button['label'])) {
				$label = $button['label'];
				unset($button['label']);
			}
			if (isset($button['type'])) {
				$type = $button['type'];
				unset($button['type']);
			}
			$button_options = array(
				'class' => 'save-btn'
			);
			$button_options = array_merge($button_options, $button);
			if ($type == 'button') {
				$buttons[] = $this->Form->button($label, $button_options);
			}
			else {
				$button_options['div'] = false;
				$buttons[] = $this->Form->submit($label, $button_options);
			}
		}
		if (!empty($buttons)) {
			$html .= $this->Html->div('control-elements', implode('&nbsp;', $buttons));
		}
		$html .= $this->Form->end();
		return $html;
	}
	public function getFormContent() {
		$html = '';
		foreach ($this->slotsQueue as $slot) {
			if ($slot['type'] == 'field') {
				$html .= $this->formFields[$slot['fieldName']];
			}
			elseif ($slot['type'] == 'tabs') {
				$html .= '<div id="tab"><img src="/img/admin/tab_top_fon_4_form_end.gif" class="tab-line" /><ul>';
				foreach ($this->tabs as $key => $params) {
					$html .= '<li id="tab_' . $key . '"><span>' . $params['title'] . '</span></li>';
				}
				$html .= '</ul></div><div class="clear"></div>';
				$i = 1;
				foreach ($this->tabFields as $key => $fields) {
					$html .= '<div id="tab_' . $key . '_body" class="tab-body">' . implode('', $fields) . '</div>';
					$i ++;
				}
			}
			elseif ($slot['type'] == 'html') {
				$html .= $slot['html'];
			}
		}
		return $html;
	}

    public function getExtraImages($extra_filenames, $brand_model_id, $brand_id) {
        if (!empty($extra_filenames) && !empty($brand_model_id) && !empty($brand_id)) {
            $this->addHtml('<label for="extra_filenames">Дополнительные изображения:</label><br/>');
            $extra_filenames = explode('|', $extra_filenames);

            foreach ($extra_filenames as $key => $filename) {
                list($params, $img) = explode(':', $filename);
                list($ah, $f2) = explode('-', $params);
                $this->addHtml('<a href="/admin/akb/list/Product.id:/Product.brand_id:'.$brand_id.'/Product.model_id:'.$brand_model_id.'/page:1">'.$ah.' ач. '.$f2.'</a><br/>');
            }
        }

    }
}
?>