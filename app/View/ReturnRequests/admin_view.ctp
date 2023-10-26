<?php
$this->Backend->setOptions(array(
	'model' => 'StorageRequest',
	'controller' => 'storage_requests'
));
echo $this->Backend->getFormHeader();
echo $this->element('storage_request');
$this->Backend->setFormButton('back', array(
	'label' => __d('admin_storage_requests', 'button_back'),
	'type' => 'button',
	'class' => 'save-btn',
	'onclick' => 'history.go(-1);'
));
$this->Backend->setFormButton('edit', array(
	'label' => __d('admin_storage_requests', 'button_edit'),
	'type' => 'button',
	'class' => 'save-btn',
	'onclick' => 'window.location=\'' . Router::url(array('controller' => 'storage_requests', 'action' => 'edit', $request['StorageRequest']['id'])) . '\';'
));
$this->Backend->setFormButton('print', array(
	'label' => __d('admin_storage_requests', 'button_print'),
	'type' => 'button',
	'class' => 'save-btn',
	'onclick' => 'window.open(\'' . Router::url(array('controller' => 'storage_requests', 'action' => 'print', $request['StorageRequest']['id'])) . '\');'
));
$this->Backend->setFormButton('label', array(
	'label' => __d('admin_storage_requests', 'button_label'),
	'type' => 'button',
	'class' => 'save-btn',
	'onclick' => 'window.open(\'' . Router::url(array('controller' => 'storage_requests', 'action' => 'label', $request['StorageRequest']['id'])) . '\');'
));
if ($request['StorageRequest']['status'] == 0) {
	$this->Backend->setFormButton('reject', array(
		'label' => __d('admin_storage_requests', 'button_reject'),
		'type' => 'button',
		'class' => 'save-btn',
		'onclick' => 'window.location=\'' . Router::url(array('controller' => 'storage_requests', 'action' => 'reject', $request['StorageRequest']['id'])) . '\';'
	));
	$this->Backend->setFormButton('storage', array(
		'label' => __d('admin_storage_requests', 'button_storage'),
		'type' => 'button',
		'class' => 'save-btn',
		'onclick' => 'window.location=\'' . Router::url(array('controller' => 'storage_requests', 'action' => 'storage', $request['StorageRequest']['id'])) . '\';'
	));
}
elseif ($request['StorageRequest']['status'] == 1) {
	$this->Backend->setFormButton('return', array(
		'label' => __d('admin_storage_requests', 'button_return'),
		'type' => 'button',
		'class' => 'save-btn',
		'onclick' => 'window.location=\'' . Router::url(array('controller' => 'storage_requests', 'action' => 'return', $request['StorageRequest']['id'])) . '\';'
	));
}
$this->Backend->setFormButton('delete', array(
	'label' => __d('admin_storage_requests', 'button_delete'),
	'type' => 'button',
	'class' => 'save-btn',
	'onclick' => '(function(){if (confirm(\'' . __d('admin_common', 'message_delete_confirm') . '\')) window.location=\'' . Router::url(array('controller' => 'storage_requests', 'action' => 'delete', $request['StorageRequest']['id'])) . '\';})();'
));
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();