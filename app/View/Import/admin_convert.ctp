<?php
$this->Backend->setOptions(array(
	'model' => 'Import',
	'controller' => 'import'
));
echo $this->Backend->getFormHeader();
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
if (isset($filename)) {
	$this->Backend->addHtml('<p class="messages"><a href="/xls/' . $filename . '" target="_blank" class="no-loader">' . __d('admin_import', 'link_download') . '</a></p>');
}
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();
if (isset($stat)) {
	$messages = array();
	$messages[] = __d('admin_import', 'stat_message_total_sheets_count', $stat['total_sheets_count']);
	$messages[] = __d('admin_import', 'stat_message_total_rows_count', $stat['total_rows_count']);
	$messages[] = __d('admin_import', 'stat_message_total_converted_rows', $stat['total_converted_rows']);
	$messages[] = __d('admin_import', 'stat_message_total_skipped_rows', $stat['total_skipped_rows']);
	$messages[] = __d('admin_import', 'stat_message_total_error_rows', $stat['total_error_rows']);
	$messages[] = __d('admin_import', 'stat_message_percent', number_format(($stat['total_converted_rows'] / ($stat['total_rows_count'] - $stat['total_skipped_rows'])) * 100, 1, '.', ''));
	$stat_message = implode('</li><li>', $messages);
	echo '<div class="sp-wrap"><div class="sp-head folded clickable">' . __d('admin_import', 'spoiler_stat') . '</div><div class="sp-body"><ul><li>' . $stat_message . '</li></ul></div></div>';
}
if (isset($errors) && !empty($errors)) {
	$error_message = implode('</li><li>', $errors);
	echo '<div class="sp-wrap"><div class="sp-head folded clickable">' . __d('admin_import', 'spoiler_errors') . ' (' . count($errors) . ')</div><div class="sp-body"><ul><li>' . $error_message . '</li></ul></div></div>';
}
?>
<script type="text/javascript">
<!--
$('.sp-head').click(function(){
	if ($(this).hasClass('unfolded')) {
		$(this).removeClass('unfolded');
		$(this).next().hide();
	}
	else {
		$(this).addClass('unfolded');
		$(this).next().show();
	}
});
//-->
</script>