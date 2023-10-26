<?php
$this->Backend->setOptions(array(
	'model' => 'StorageRequest',
	'controller' => 'storage_requests'
));
echo $this->Backend->getFormHeader();

$this->Backend->addHtml('<h3>' . __d('admin_storage_requests', 'title_ordered_services') . '</h3>');
$services_table = '';
$i = 0;
foreach ($request['StorageRequestService'] as $request_service) {
	if (isset($prices[$request_service['price_id']])) {
		$services_table .= '<tr class="row_table' . ($i % 2 == 1 ? '_odd' : '') . '">';
		$price = $prices[$request_service['price_id']];
		$cost = $request_service['quantity'] * $request_service['price'];
		$title = $price['Price']['title'] . ' (' . $types[$price['Price']['type']] . ')';
		$services_table .= '<td>' . $title . '</td>';
		$services_table .= '<td class="a-right">' . $this->Frontend->getStoragePrice($request_service['price']) . '</td>';
		$services_table .= '<td class="a-center">' . $request_service['quantity'] . '</td>';
		$services_table .= '<td class="a-right">' . $this->Frontend->getStoragePrice($cost) . '</td>';
		$services_table .= '</tr>';
		$i ++;
	}
}
$total = $this->Frontend->getStoragePrice($request['StorageRequest']['total_price']);
$this->Backend->addHtml('
<table width="100%" cellspacing="2" cellpadding="2" id="grid">
	<colgroup>
		<col>
		<col>
		<col>
		<col>
	</colgroup>
	<thead>
		<tr class="admin_table_title">
			<td>' . __d('admin_storage_requests', 'column_service_name') . '</td>
			<td>' . __d('admin_storage_requests', 'column_service_cost') . '</td>
			<td>' . __d('admin_storage_requests', 'column_service_quantity') . '</td>
			<td>' . __d('admin_storage_requests', 'column_service_price') . '</td>
		</tr>
	</thead>
	<tbody>' . $services_table . '</tbody>
	<thead>
		<tr class="admin_table_title">
			<td colspan="3" class="a-right">' . __d('admin_storage_requests', 'column_services_total') . '</td>
			<td class="a-right">' . $total . '</td>
		</tr>
	</thead>
</table>
');

$this->Backend->addHtml('<h3>' . __d('admin_storage_requests', 'title_request_info') . '</h3>');

$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_id') . '</strong> &mdash; ' . $request['StorageRequest']['request_id'] . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_created') . '</strong> &mdash; ' . $request['StorageRequest']['created'] . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_station') . '</strong> &mdash; ' . h($request['Station']['title']) . '</div>');
$time = strtotime($request['StorageRequest']['date']);
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_date') . '</strong> &mdash; ' . date('d.m.Y', $time) . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_time') . '</strong> &mdash; ' . substr($request['StorageRequest']['time'], 0, 5) . '</div>');



$brand_name = $model_name = '';
if (!empty($request['Brand']['title'])) {
	$brand_name = $request['Brand']['title'];
}
if (!empty($request['BrandModel']['title'])) {
	$model_name = $request['BrandModel']['title'];
}
$tyre_info = $disk_info = '';
$tyre_info = $brand_name . ' ' . $model_name;

$tyre_info .= ' ' . $request['StorageRequest']['size1'] . '/' . $request['StorageRequest']['size2'] . ' R' . $request['StorageRequest']['size3'];
if (!empty($request['StorageRequest']['season'])) {
	$tyre_info .= ' (' . $seasons[$request['StorageRequest']['season']] . ')';
}
if (!empty($request['StorageRequest']['radius'])) {
	$disk_info = 'R' . $request['StorageRequest']['radius'];
}
if (!empty($request['StorageRequest']['material'])) {
	$disk_info .= ' ' . $materials[$request['StorageRequest']['material']];
}
$this->Backend->addHtml('<h3>' . __d('admin_storage_requests', 'title_tyre_info') . '</h3>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_tyre_info') . '</strong> &mdash; ' . h($tyre_info) . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_treadwear') . '</strong> &mdash; ' . h($request['StorageRequest']['treadwear']) . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_tyre_condition') . '</strong> &mdash; ' . h($request['StorageRequest']['tyre_condition']) . '</div>');
$this->Backend->addHtml('<h3>' . __d('admin_storage_requests', 'title_disk_info') . '</h3>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_disk_info') . '</strong> &mdash; ' . h($disk_info) . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_disk_condition') . '</strong> &mdash; ' . h($request['StorageRequest']['disk_condition']) . '</div>');


$this->Backend->addHtml('<h3>' . __d('admin_storage_requests', 'title_car_info') . '</h3>');
$auto = array();
if (!empty($request['CarBrand']['title'])) {
	$auto[] = $request['CarBrand']['title'];
}
if (!empty($request['CarModel']['title'])) {
	$auto[] = $request['CarModel']['title'];
}
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_auto') . '</strong> &mdash; ' . h(implode(' ', $auto)) . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_number') . '</strong> &mdash; ' . h($request['StorageRequest']['number']) . '</div>');
$this->Backend->addHtml('<h3>' . __d('admin_storage_requests', 'title_contact_info') . '</h3>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_name') . '</strong> &mdash; ' . h($request['StorageRequest']['name']) . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_phone') . '</strong> &mdash; ' . h($request['StorageRequest']['phone']) . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_email') . '</strong> &mdash; ' . h($request['StorageRequest']['email']) . '</div>');


$this->Backend->removeFormButton('save_and_exit');
$this->Backend->removeFormButton('save');
$this->Backend->setFormButton('back', array(
	'label' => __d('admin_storage_requests', 'button_back'),
	'type' => 'button',
	'class' => 'save-btn',
	'onclick' => 'history.go(-1);'
));
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();