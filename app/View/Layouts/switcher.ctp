<?php
$data = array();
if (isset($deny_access) && $deny_access) {
	$data['deny'] = true;
	$data['return_html'] = '';
}
else {
	$data['deny'] = false;
	$data['return_html'] = $this->element('switcher', array('id' => $id, 'url' => $url, 'icon' => $icon, 'url_enabled' => $url_enabled, 'url_disabled' => $url_disabled, 'title_enabled' => $title_enabled, 'title_disabled' => $title_disabled, 'prefix' => $prefix, 'status' => $status, 'td' => false));
}
echo $this->Js->object($data);