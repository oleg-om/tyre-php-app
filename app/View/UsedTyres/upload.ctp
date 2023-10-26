<?php
header('Content-type: application/json');
if ($data['success']) {
	$data['src'] = $this->Backend->thumbnail(
		array(
			'filename' => $data['filename'],
			'id' => $data['id'],
			'path' => 'tyres',
			'width' => 60,
			'height' => 60,
			'crop' => true,
			'folder' => true,
			'quality' => 85
		)
	);
}
$options = array(
	'prefix' => '', 'postfix' => ''
);
if (isset($this->request->params['url']['callback'])) {
	$options['prefix'] = $this->request->params['url']['callback'] . '(';
	$options['postfix'] = ')';
}
echo $this->Js->object($data, $options);