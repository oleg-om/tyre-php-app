<?php
$this->Backend->setOptions(array(
	'model' => 'Administrator',
	'controller' => 'administrators'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_administrators', 'label_is_active')
));
$this->Backend->addText('username', array(
	'label' => __d('admin_administrators', 'label_login'),
	'required' => true
));
$this->Backend->addText('name', array(
	'label' => __d('admin_administrators', 'label_name'),
	'required' => true
));
$this->Backend->addText('email', array(
	'label' => __d('admin_administrators', 'label_email'),
	'required' => true
));
if (empty($this->data['Administrator']['id'])) {
	$this->Backend->addPassword('pswd', array(
		'label' => __d('admin_administrators', 'label_password'),
		'required' => true
	));
	$this->Backend->addPassword('password_repeat', array(
		'label' => __d('admin_administrators', 'label_password_repeat'),
		'required' => true
	));
}
else {
	$this->Backend->addCheckbox('change_password', array(
		'label' => __d('admin_administrators', 'label_change_password')
	));
	$this->Backend->addHtml('<div id="box-change-password">');
	$this->Backend->addPassword('pswd', array(
		'label' => __d('admin_administrators', 'label_password'),
		'required' => true
	));
	$this->Backend->addPassword('password_repeat', array(
		'label' => __d('admin_administrators', 'label_password_repeat'),
		'required' => true
	));
	$this->Backend->addHtml('</div>');
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
if (!empty($this->data['Administrator']['id'])) {
?>
<script type="text/javascript">
<!--
$(function(){
	$('#AdministratorChangePassword').click(handler_change_password);
	handler_change_password();
});
function handler_change_password() {
	if ($('#AdministratorChangePassword').attr('checked')) {
		$('#box-change-password').show();
	}
	else {
		$('#box-change-password').hide();
	}
}
//-->
</script>
<?php } ?>