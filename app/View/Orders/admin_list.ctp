<?php
$this->Backend->setOptions(array(
	'model' => 'Order',
	'controller' => 'orders'
));
$this->Backend->addColumn('id', array(
	'width' => 55,
	'type' => 'number',
	'label' => __d('admin_orders', 'column_id'),
	'renderer' => 'order_id'
));
$this->Backend->addColumn('info', array(
	'label' => __d('admin_orders', 'column_info'),
	'renderer' => 'order_info'
));
$this->Backend->addColumn('status_id', array(
	'label' => __d('admin_orders', 'column_status_id'),
	'type' => 'list',
	'sortable' => false,
	'options' => $statuses
));
$this->Backend->addColumn('created', array(
	'label' => __d('admin_orders', 'column_created'),
	'type' => 'date',
	'format' => 'H:i Y-m-d',
	'width' => 115
));
$this->Backend->addColumn('total', array(
	'label' => __d('admin_orders', 'column_total'),
	'width' => 120,
	'renderer' => 'order_total',
	'filterable' => false
));
$this->Backend->removeRowButton('edit');
$this->Backend->setRowButton('view', array(
	'label' => __d('admin_orders', 'button_row_view', true),
	'after' => '-'
));
echo $this->Backend->getGridHeader();
echo $this->Backend->getGridContent();
echo $this->Backend->getGridFooter();
?>
<script type="text/javascript">
<!--
$(function(){
	$('#grid tbody tr').each(function(){
		if ($(this).find('td:eq(3)').html() == 'Новый') {
			$(this).addClass('yellow');
		}
	});
});
//-->
</script>
