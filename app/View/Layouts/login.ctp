<?php echo $this->Html->docType('xhtml-trans'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
<title><?php echo __d('admin_common', 'title'); ?> - <?php echo __d('admin_administrators', 'title_login'); ?></title>
<?php
	echo $this->Html->meta('favicon.ico', '/favicon.ico',array('type' => 'icon'));
	echo $this->Html->charset();
	$css = array('admin/style');
	if (Configure::read('debug')) {
		$css[] = 'admin/debug';
	}
	echo $this->Html->css($css);
	echo $this->Html->script(array('http://code.jquery.com/jquery.min.js'));
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#AdministratorUsername').focus();
});
</script>
</head>
<body>
<?php
	echo $content_for_layout;
	echo $this->element('admin_footer');
	echo $this->element('sql_dump');
?>
</body>
</html>