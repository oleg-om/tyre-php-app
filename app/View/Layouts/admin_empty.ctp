<?php echo $this->Html->docType('xhtml-trans'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
<title><?php echo __d('admin_common', 'title'); ?><?php echo isset($title_for_layout) && $title_for_layout != '' ? ' - ' . $title_for_layout : ''; ?></title>
<?php
	echo $this->Html->charset();
	echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon'));
	$css = array('admin/style', 'admin/datepicker');
	if (Configure::read('debug')) {
		$css[] = 'admin/debug';
	}
	if (isset($additional_css)) {
		$css = array_merge($css, $additional_css);
	}
	echo $this->Html->css($css);
	echo $this->Html->css(array('admin/print'), null, array('media' => 'print'));
	echo $this->Html->scriptBlock('var m_state = ' . $m_state . ', s_state = new Array(' . implode(',', $s_state) . '), lang = \'ru\';');
	$js = array('http://code.jquery.com/jquery.min.js', 'admin/main', 'admin/i18n/locale-ru');
	if (isset($additional_js)) {
		$js = array_merge($js, $additional_js);
	}
	echo $this->Html->script($js);
?>
</head>
<body><?php echo $content_for_layout; ?></body>
</html>