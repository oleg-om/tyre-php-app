<?php
$this->Backend->setOptions(array(
	'model' => 'Product',
	'controller' => 'tyres'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_tyres', 'column_id')
));
$this->Backend->addColumn('brand_id', array(
	'label' => __d('admin_tyres', 'column_brand_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $brands
));
$this->Backend->addColumn('model_id', array(
	'label' => __d('admin_tyres', 'column_model_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $models,
	'all_options' => $all_models
));
$this->Backend->addColumn('supplier_id', array(
	'label' => __d('admin_tyres', 'column_supplier_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $suppliers
));
$this->Backend->addColumn('sku', array(
	'label' => __d('admin_tyres', 'column_sku'),
	'editable' => true
));
$this->Backend->addColumn('size', array(
	'label' => __d('admin_tyres', 'column_size'),
	'renderer' => 'tyre_size',
	'filterable' => false,
	'sortable' => false
));
$this->Backend->addColumn('f', array(
	'label' => __d('admin_tyres', 'column_f'),
	'renderer' => 'tyre_f',
	'filterable' => false,
	'sortable' => false
));
$this->Backend->addColumn('price', array(
	'label' => __d('admin_tyres', 'column_price'),
	'renderer' => 'product_price',
	'filterable' => false
));
$this->Backend->addColumn('stock_count', array(
	'label' => __d('admin_tyres', 'column_stock_count'),
	'renderer' => 'product_stock_count',
	'filterable' => false
));
$this->Backend->addColumn('in_stock', array(
	'width' => 40,
	'type' => 'switcher',
	'sortable' => false,
	'icon' => 'stock',
	'deletable' => true,
	'deletable_value' => 1,
	'url_enabled' => 'stockon',
	'url_disabled' => 'stockoff',
	'title_enabled' => __d('admin_tyres', 'title_stockon'),
	'title_disabled' => __d('admin_tyres', 'title_stockoff'),
	'prefix' => 'stock'
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
	'title_enabled' => __d('admin_tyres', 'title_enabled'),
	'title_disabled' => __d('admin_tyres', 'title_disabled'),
	'prefix' => 'status'
));
$this->Backend->setGridButton('apply', array(
	'label' => __d('admin_common', 'button_grid_apply'),
	'after' => '-'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();
?>
<script type="text/javascript">
$(function(){
	$('#ProductBrandId').change(handler_brand_id);
	handler_brand_id();
	
});
function handler_brand_id() {
	var brand_id = parseInt($('#ProductBrandId').val()), model_id = $('#ProductModelId').val();
	if (isNaN(brand_id)) brand_id = 0;
	$('#ProductModelId').removeOption(/.*/);
	if (brand_id != 0) {
		loader();
		$('#ProductModelId').ajaxAddOption(
			'/admin/brands/models',
			{brand_id: brand_id, any: 0},
			false,
			function() {
				$('#ProductModelId').val(model_id);
				delete_loader();
			}
		);
	}
	else {
		$('#ProductModelId').addOption('','<?php echo __d('admin_common', 'list_all_items'); ?>');
	}
}
</script>