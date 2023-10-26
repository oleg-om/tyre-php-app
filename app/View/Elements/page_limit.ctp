<?php
$limits = array(10, 20, 30, 50);
if (!isset($limit)) {
	$limit = 10;
}
echo '<div class="filter"><label>Выводить по:</label><select onchange="window.location=$(this).val();">';
foreach ($limits as $item) {
	$limit_url = $url;
	$limit_url['?']['limit'] = $item;
	$selected = '';
	if ($item == $limit) {
		$selected = ' selected';
	}
	echo '<option value="' . Router::url($limit_url) . '"' . $selected . '>' . $item . '</option>';
}
echo '</select></div>';