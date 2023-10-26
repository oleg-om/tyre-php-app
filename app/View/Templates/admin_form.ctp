<?php
$this->Backend->setOptions(array(
	'model' => 'Template',
	'controller' => 'templates'
));
echo $this->Backend->getFormHeader();
$this->Backend->addText('title', array(
	'label' => __d('admin_templates', 'label_title'),
	'required' => true
));
$this->Backend->addText('subject', array(
	'label' => __d('admin_templates', 'label_subject'),
	'required' => true
));
$this->Backend->addTextarea('body', array(
	'label' => __d('admin_templates', 'label_body'),
	'editor' => true
));
if (!empty($this->request->data['Template']['params'])) {
	$params = explode("\n", $this->data['Template']['params']);
	$this->Backend->addHtml('<p>' . __d('admin_templates', 'params_description') . '</p><ul>');
	foreach ($params as $param) {
		$param = trim($param);
		$this->Backend->addHtml('<li>{' . $param . '} &mdash; ' . __d('admin_templates', 'param_' . $param) . '</li>');
	}
	$this->Backend->addHtml('</ul>');
}
$this->Backend->addHidden('id');
$this->Backend->addHidden('action', array(
	'type' => 'hidden',
	'value' => 'apply',
	'id' => 'frm_action'
));
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();