<?php
$modes = array('block' => 'блоками', 'table' => 'таблицей');
echo '<ul class="mode-selector">';
foreach ($modes as $key => $value) {
	$class = '';
	if ($key == $mode) {
		$class = ' class="active"';
	}
	$mode_url = $url;
	$mode_url['?']['mode'] = $key;
	echo '<li' . $class . '>' . $this->Html->link($value, $mode_url) . '</li>';
}
echo '</ul><div class="clear"></div>';
?>