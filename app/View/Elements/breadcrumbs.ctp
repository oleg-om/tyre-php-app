<?php
if (isset($breadcrumbs)) {
	$breadcrumbs = array_merge(array(array('url' => array('controller' => 'pages', 'action' => 'home'), 'title' => 'Главная')), $breadcrumbs);
	$breadcrumbs_list = array();
	foreach ($breadcrumbs as $breadcrumb) {
		if ($breadcrumb['url'] != null) {
			$breadcrumbs_list[] = $this->Html->link($breadcrumb['title'], $breadcrumb['url']);
		}
		else {
			$breadcrumbs_list[] = h($breadcrumb['title']);
		}
	}
	echo '<div class="bre wrap">' . implode('  /  ', $breadcrumbs_list) . '</div>';
}