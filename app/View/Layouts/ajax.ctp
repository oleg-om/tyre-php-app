<?php
if (!isset($script)) {
	$script = false;
}
if ($script) {
	echo '<script type="text/javascript">';
}
if (isset($link)) {
	echo 'window.location = \'' . $link . '\'';
}
else {
	$content_for_layout = str_replace(array("\r\n", "\n", "\r"), '\n', $content_for_layout);
	$content_for_layout = str_replace(array('"', "'"), array('\"', "\\'"), $content_for_layout);
	echo '$(\'.fancybox-inner\').html(\'' . $content_for_layout . '\');';
	echo '$(\'.fancybox-wrap\').show();';
	echo '$.fancybox.hideLoading();';
	echo '$.fancybox.update();';
}
if ($script) {
	echo '</script>';
}