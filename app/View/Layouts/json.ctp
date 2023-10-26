<?php
header('Content-type: application/json');
$options = array(
	'prefix' => '', 'postfix' => ''
);
if (isset($this->request->params['url']['callback'])) {
	$options['prefix'] = $this->request->params['url']['callback'] . '(';
	$options['postfix'] = ')';
}
echo $this->Js->object($data, $options);