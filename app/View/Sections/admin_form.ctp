<?php
$this->Backend->setOptions(array(
	'model' => 'Section',
	'controller' => 'sections'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_sections', 'label_is_active')
));
$this->Backend->addSelect('parent_id', array(
	'label' => __d('admin_sections', 'label_parent_id'),
	'options' => $parents
));
$this->Backend->addSelect('type', array(
	'label' => __d('admin_sections', 'label_type'),
	'options' => $types,
	'empty' => false
));
$this->Backend->addHtml('<div class="section-selector">');
$this->Backend->addSelect('section', array(
	'label' => __d('admin_sections', 'label_section'),
	'options' => $sections
));
$this->Backend->addHtml('</div>');
$this->Backend->addHtml('<div class="page-selector">');
$this->Backend->addSelect('page_id', array(
	'label' => __d('admin_sections', 'label_page_id'),
	'options' => $pages
));
$this->Backend->addHtml('</div>');
$this->Backend->addText('title', array(
	'label' => __d('admin_sections', 'label_title'),
	'acronym' => __d('admin_sections', 'acronym_title'),
	'required' => true
));
$this->Backend->addText('page_title', array(
	'label' => __d('admin_sections', 'label_page_title')
));
$this->Backend->addSelect('color', array(
	'label' => __d('admin_sections', 'label_color'),
	'options' => $colors,
	'empty' => false
));
$this->Backend->addHtml('<div class="link-input">');
$this->Backend->addText('link', array(
	'label' => __d('admin_sections', 'label_link'),
	'required' => true
));
$this->Backend->addCheckbox('blank', array(
	'label' => __d('admin_sections', 'label_blank')
));
$this->Backend->addHtml('</div>');
$this->Backend->addHidden('id');
$this->Backend->addHidden('action', array(
	'type' => 'hidden',
	'value' => 'apply',
	'id' => 'frm_action'
));
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();
?>
<script type="text/javascript">
<!--
$(function(){
	type_handler();
	$('#SectionType').change(type_handler);
});
function type_handler() {
	var type = $('#SectionType').val();
	if (type == 'page') {
		$('.section-selector').hide();
		$('.link-input').hide();
		$('.page-selector').show();
	}
	else if (type == 'link') {
		$('.section-selector').hide();
		$('.page-selector').hide();
		$('.link-input').show();
	}
	else {
		$('.page-selector').hide();
		$('.link-input').hide();
		$('.section-selector').show();
	}
}
//-->
</script>