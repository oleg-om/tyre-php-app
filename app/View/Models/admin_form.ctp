<?php
$this->Backend->setOptions(array(
	'model' => 'BrandModel',
	'controller' => 'models'
));
echo $this->Backend->getFormHeader();
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_models', 'label_is_active'),
	'acronym' => __d('admin_models', 'acronym_is_active')
));
$this->Backend->addCheckbox('in_stock', array(
	'label' => __d('admin_models', 'label_in_stock')
));
$this->Backend->addCheckbox('new', array(
	'label' => __d('admin_models', 'label_new')
));
$this->Backend->addCheckbox('popular', array(
	'label' => __d('admin_models', 'label_popular')
));
$this->Backend->addSelect('category_id', array(
	'label' => __d('admin_models', 'label_category_id'),
	'options' => $categories
));
$this->Backend->addSelect('brand_id', array(
	'label' => __d('admin_models', 'label_brand_id'),
	'options' => $brands
));
$this->Backend->addText('title', array(
	'label' => __d('admin_models', 'label_title'),
	'acronym' => __d('admin_models', 'acronym_title'),
	'required' => true
));
$this->Backend->addSelect('auto', array(
	'label' => __d('admin_models', 'label_auto'),
	'options' => $auto
));
$this->Backend->addSelect('season', array(
	'label' => __d('admin_models', 'label_season'),
	'options' => $seasons
));
$this->Backend->addSelect('material', array(
	'label' => __d('admin_models', 'label_material'),
	'options' => $materials
));
$this->Backend->addPhoto('filename', array(
	'path' => 'models',
	'width' => 121,
	'height' => 121,
	'crop' => false,
	'folder' => false,
	'remove' => true
));
$this->Backend->addFile('file', array(
	'label' => __d('admin_models', 'label_file')
));
$this->Backend->addTextarea('video', array(
	'label' => __d('admin_models', 'label_video')
));
$this->Backend->addTextarea('content', array(
	'label' => __d('admin_models', 'label_content'),
	'editor' => true
));
$this->Backend->addText('meta_title', array(
	'label' => __d('admin_models', 'label_meta_title')
));
$this->Backend->addText('meta_keywords', array(
	'label' => __d('admin_models', 'label_meta_keywords')
));
$this->Backend->addTextarea('meta_description', array(
	'label' => __d('admin_models', 'label_meta_description')
));
$this->Backend->addTextarea('synonyms', array(
	'label' => __d('admin_models', 'label_synonyms')
));
$this->Backend->addHidden('id');
$this->Backend->addHidden('old_brand_id');
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
$(function(){
	$('#BrandModelCategoryId').change(handler_category_id);
	handler_category_id();
	
});
function handler_category_id() {  
	var category_id = parseInt($('#BrandModelCategoryId').val()), brand_id = $('#BrandModelBrandId').val();
	if (isNaN(category_id)) category_id = 0;
	$('#BrandModelBrandId').removeOption(/.*/);
	if (category_id != 0) {
		loader();
		$('#BrandModelBrandId').ajaxAddOption(
			'/admin/categories/brands',
			{category_id: category_id, any: 1},
			false,
			function() {
				$('#BrandModelBrandId').val(brand_id); 
				const sell = document.getElementById('BrandModelBrandId')
				const optionNodes = Array.from(sell.children);  
				const comparator = new Intl.Collator(lang.slice(0, 2)).compare;

				// optionNodes.sort((a, b) => comparator(a.textContent, b.textContent)).sort((a) => a.textContent === "Все");
				optionNodes.sort((a, b) => comparator(a.textContent, b.textContent));
				optionNodes.forEach((option) => sell.appendChild(option));
				delete_loader();
			}
		);
	}
	else {
		$('#BrandModelBrandId').addOption('','<?php echo __d('admin_common', 'list_any_item'); ?>');
	}
}
</script>