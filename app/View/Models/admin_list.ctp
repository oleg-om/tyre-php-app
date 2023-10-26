<?php
$this->Backend->setOptions(array(
	'model' => 'BrandModel',
	'controller' => 'models'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_models', 'column_id')
));
$this->Backend->addColumn('photo', array(
	'label' => __d('admin_models', 'column_photo'),
	'filterable' => false,
	'sortable' => false,
	'width' => 170,
	'renderer' => 'model_photo'
));
$this->Backend->addColumn('category_id', array(
	'label' => __d('admin_models', 'column_category_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $categories
));
$this->Backend->addColumn('brand_id', array(
	'label' => __d('admin_models', 'column_brand_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $brands,
	'all_options' => $all_brands
));
$this->Backend->addColumn('title', array(
	'label' => __d('admin_models', 'column_title'),
	'editable' => true
));
$this->Backend->addColumn('products_in_stock', array(
	'label' => __d('admin_models', 'column_in_stock'),
	'type' => 'list',
	'sortable' => false,
	'options' => array(
		1 => __d('admin_common', 'yes'),
		0 => __d('admin_common', 'no')
	)
));
$this->Backend->addColumn('products_count', array(
	'label' => __d('admin_models', 'column_products_count'),
	'counter' => true
));
$this->Backend->addColumn('is_active', array(
	'width' => 40,
	'type' => 'switcher',
	'sortable' => false,
	'icon' => 'lightbulb',
	'deletable' => true,
	'deletable_value' => 1,
	'url_enabled' => 'enable',
	'url_disabled' => 'disable',
	'title_enabled' => __d('admin_models', 'title_enabled'),
	'title_disabled' => __d('admin_models', 'title_disabled'),
	'prefix' => 'status'
));
$this->Backend->setGridButton('merge', array(
	'label' => __d('admin_models', 'button_merge', true)
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();
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
			{category_id: category_id, any: 0},
			false,
			function(it) { 
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
		$('#BrandModelBrandId').addOption('','<?php echo __d('admin_common', 'list_all_items'); ?>');
	}
}
</script>