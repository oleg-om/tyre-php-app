<div class="print-box"><?php
	$this->Backend->setOptions(array(
		'model' => 'StorageRequest',
		'controller' => 'storage_requests',
		'show_title' => false,
		'show_submenu' => false
	));
	echo $this->Backend->getFormHeader();
	$this->Backend->addHtml('<h1>' . __d('admin_storage_requests', 'title_print', $request['StorageRequest']['request_id']) . '</h1>');
	echo $this->element('storage_request');
	echo $this->Backend->getFormContent();
	echo $this->Backend->getFormFooter();
	echo $this->Backend->getScript();
?></div>
<div class="print-box second"><?php
	echo $this->Backend->getFormHeader();
	echo $this->Backend->getFormContent();
	echo $this->Backend->getFormFooter();
	echo $this->Backend->getScript();
?></div>