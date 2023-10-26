<?php echo $this->Html->docType(); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Debug Layout</title>
<?php
	echo $this->Html->charset();
	echo $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon'));
	echo $this->Html->css(array('admin/style'));
?>
</head>
<body><?php
	echo $content_for_layout;
	echo $this->element('sql_dump');
?></body>
</html>