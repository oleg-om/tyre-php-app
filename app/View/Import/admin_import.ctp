<?php
$this->Backend->setOptions(array(
	'model' => 'Import',
	'controller' => 'import'
));
echo $this->Backend->getFormHeader();
if (isset($message_lines)) {
	$message = implode('<br />', $message_lines);
	$this->Backend->addHtml('<p class="messages">' . $message . '</p>');
}
$this->Backend->addCheckbox('in_stock', array(
	'label' => __d('admin_import', 'label_in_stock')
));
$this->Backend->addCheckbox('only_prices', array(
	'label' => __d('admin_import', 'label_only_prices')
));
$this->Backend->addCheckbox('ignore_prices', array(
	'label' => __d('admin_import', 'label_ignore_prices')
));
$this->Backend->addCheckbox('only_suppliers', array(
	'label' => __d('admin_import', 'label_only_suppliers')
));
$this->Backend->addSelect('supplier_id', array(
	'label' => __d('admin_import', 'label_supplier_id'),
	'options' => $suppliers
));
$this->Backend->addSelect('type', array(
	'label' => __d('admin_import', 'label_type'),
	'options' => $types,
	'empty' => false
));
$this->Backend->addSelect('currency_id', array(
	'label' => __d('admin_import', 'label_currency_id'),
	'options' => $currencies,
	'empty' => false
));
$this->Backend->addFile('file', array(
	'label' => __d('admin_import', 'label_file')
));
$this->Backend->addHidden('action', array(
	'type' => 'hidden',
	'value' => 'apply',
	'id' => 'frm_action'
));
$this->Backend->setFormButton(
	'import',
	array(
		'label' => __d('admin_import', 'button_import'),
		'type' => 'submit',
		'class' => 'save-btn'
	)
);
$this->Backend->removeFormButton('save');
$this->Backend->removeFormButton('save_and_exit');
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();
echo '<p><a href="/app/webroot/examples/manual.pdf" class="no-loader" target="_blank">' . __d('admin_import', 'link_manual') . '</a></p>';
$types_links = array();
foreach ($types as $i => $type) {
	$types_links[] = '<p>' . $type . ' &mdash; <a href="/app/webroot/examples/type_' . $i . '.xls" class="no-loader" target="_blank">' . __d('admin_import', 'link_download') . '</a></p>';
}
echo '<div class="examples"><h3>' . __d('admin_import', 'title_examples') . '</h3>' . implode('', $types_links) . '</div>';
echo '<div class="examples"><h3>' . __d('admin_import', 'title_columns') . '</h3>' . __d('admin_import', 'title_columns_info') . '</div>';