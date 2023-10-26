<?php
$replaces = array(
	array(
		'{after}', '{before}', '{between}', '{value}'
	),
	array(
		'', '', '&nbsp;'
	)
);

$this->Backend->setOptions(array(
	'model' => 'OrderEvent',
	'controller' => 'orders'
));
$this->request->data['OrderEvent']['status_id'] = $order['Order']['status_id'];
echo $this->Backend->getFormHeader();
$this->Backend->addHtml('<h3>' . __d('admin_orders', 'title_ordered_products') . '</h3>');
$products_table = '';
$i = 0;
foreach ($order['OrderProduct'] as $order_product) {
	if (isset($products[$order_product['product_id']])) {
		$products_table .= '<tr class="row_table' . ($i % 2 == 1 ? '_odd' : '') . '">';
		$product = $products[$order_product['product_id']];
		$cost = $order_product['quantity'] * $order_product['price'];
		$title = $product['Brand']['title'] . ' ' . $product['BrandModel']['title'];
		if ($product['Product']['category_id'] == 1) {
			$title .= ' ' . $product['Product']['size1'] . '/' . $product['Product']['size2'] . ' R' . $product['Product']['size3'];
			$image = $this->Html->image('no-tyre-little.jpg');
			if (!empty($product['BrandModel']['filename'])) {
				$image = $this->Html->image($this->Backend->thumbnail(array('id' => $product['BrandModel']['id'], 'filename' => $product['BrandModel']['filename'], 'path' => 'models', 'width' => 158, 'height' => 158, 'crop' => false, 'folder' => false, 'tyre' => true, 'empty' => '/img/no-tyre-little.jpg')), array('alt' => $product['BrandModel']['title']));
			}
		}
		elseif ($product['Product']['category_id'] == 2) {
			$title .= ' ' . $product['Product']['size2'] . ' R' . $product['Product']['size2'] . 'x' . $product['Product']['size3'];
			$image = $this->Html->image('no-disk-little.jpg');
			if (!empty($product['BrandModel']['filename'])) {
				$image = $this->Html->image($this->Backend->thumbnail(array('id' => $product['BrandModel']['id'], 'filename' => $product['BrandModel']['filename'], 'path' => 'models', 'width' => 150, 'height' => 150, 'crop' => false, 'folder' => false, 'empty' => '/img/no-disk-little.jpg')), array('alt' => $product['BrandModel']['title']));
			}
		}
		elseif ($product['Product']['category_id'] == 3) {
			$title .= ' ' . $product['Product']['ah'] . 'ач ' . $product['Product']['f1'];
			$image = $this->Html->image('no-akb-little.jpg');
			$filename = null;
			if (!empty($product['Product']['filename'])) {
				$filename = $product['Product']['filename'];
				$id = $product['Product']['id'];
				$path = 'akb';
			}
			elseif (!empty($product['BrandModel']['filename'])) {
				$filename = $product['BrandModel']['filename'];
				$id = $product['BrandModel']['id'];
				$path = 'models';
			}
			if (!empty($filename)) {
				$image = $this->Html->image($this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $path, 'width' => 158, 'height' => 158, 'crop' => false, 'folder' => false, 'empty' => '/img/no-akb-little.jpg')), array('alt' => $product['BrandModel']['title']));
			}
		}
		else {
			$title = $bolt_types[$product['Product']['bolt_type']] . ' ' . $product['Product']['bolt'];
			$image = $this->Html->image('no-bolts-little.jpg');
			$filename = null;
			if (!empty($product['Product']['filename'])) {
				$filename = $product['Product']['filename'];
				$id = $product['Product']['id'];
				$path = 'bolts';
			}
			if (!empty($filename)) {
				$image = $this->Html->image($this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $path, 'width' => 158, 'height' => 158, 'crop' => false, 'folder' => false, 'empty' => '/img/no-bolts-little.jpg')), array('alt' => $title));
			}
		}
		$price_replaces = $replaces;
		$price_replaces[1][] = $this->Frontend->roundPrice($order['Order'], $order_product['price'], false);
		$price = str_replace($price_replaces[0], $price_replaces[1], $order['Order']['currency_template']);
		$cost_replaces = $replaces;
		$cost_replaces[1][] = $this->Frontend->roundPrice($order['Order'], $cost, false);
		$cost = str_replace($cost_replaces[0], $cost_replaces[1], $order['Order']['currency_template']);
		$products_table .= '<td class="a-center">' . $image . '</td>';
		$products_table .= '<td>' . $title . '</td>';
		$products_table .= '<td class="a-right">' . $price . '</td>';
		$products_table .= '<td class="a-center">' . $order_product['quantity'] . '</td>';
		$products_table .= '<td class="a-right">' . $cost . '</td>';
		$products_table .= '</tr>';
		$i ++;
	}
}
$total_replaces = $replaces;
$total_replaces[1][] = $this->Frontend->roundPrice($order['Order'], $order['Order']['total'], false);
$total = str_replace($total_replaces[0], $total_replaces[1], $order['Order']['currency_template']);
$this->Backend->addHtml('
<table width="100%" cellspacing="2" cellpadding="2" id="grid">
	<colgroup>
		<col width="158px">
		<col>
		<col>
		<col>
		<col>
	</colgroup>
	<thead>
		<tr class="admin_table_title">
			<td>' . __d('admin_orders', 'column_order_product_photo') . '</td>
			<td>' . __d('admin_orders', 'column_order_product_name') . '</td>
			<td>' . __d('admin_orders', 'column_order_product_cost') . '</td>
			<td>' . __d('admin_orders', 'column_order_product_quantity') . '</td>
			<td>' . __d('admin_orders', 'column_order_product_price') . '</td>
		</tr>
	</thead>
	<tbody>' . $products_table . '</tbody>
	<thead>
		<tr class="admin_table_title">
			<td colspan="4" class="a-right">' . __d('admin_orders', 'column_order_products_total') . '</td>
			<td class="a-right">' . $total . '</td>
		</tr>
	</thead>
</table>
');
$address = array();
$shipping = $order['ShippingMethod']['title'];
if ($order['Order']['shipping_method_id'] == 1) {
	if (!empty($order['Order']['region_id'])) {
		$address[] = $order['Region']['title'];
	}
	if (!empty($order['Order']['city_id'])) {
		$address[] = $order['City']['title'];
	}
	if (!empty($order['Order']['store_id'])) {
		$address[] = $order['Store']['title'];
	}
	$shipping .= ', ' . $order['ShippingType']['title'];
}
else {
	if (!empty($order['Order']['city'])) {
		$address[] = h($order['Order']['city']);
	}
	if (!empty($order['Order']['address'])) {
		$address[] = h($order['Order']['address']);
	}
}
$address_str = '';
if (!empty($address)) {
	$address_str = implode(', ', $address);
}
$this->Backend->addHtml('<br /><div class="item_div"><strong>' . __d('admin_orders', 'order_info_shipping') . '</strong> &mdash; ' . $shipping . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_orders', 'order_info_address') . '</strong> &mdash; ' . $address_str . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_orders', 'order_info_payment') . '</strong> &mdash; ' . $order['PaymentType']['title'] . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_orders', 'order_info_name') . '</strong> &mdash; ' . $order['Order']['name'] . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_orders', 'order_info_email') . '</strong> &mdash; ' . $order['Order']['email'] . '</div>');
$this->Backend->addHtml('<div class="item_div"><strong>' . __d('admin_orders', 'order_info_phone') . '</strong> &mdash; ' . h($order['Order']['phone']) . '</div>');
$this->Backend->addHtml('<h3>' . __d('admin_orders', 'title_order_history') . '</h3>');
$events_table = '';
$i = 0;
foreach ($order['OrderEvent'] as $event) {
	$events_table .= '<tr class="row_table' . ($i % 2 == 1 ? '_odd' : '') . '">';
	$events_table .= '<td>' . $statuses[$event['status_id']] . '</td>';
	$events_table .= '<td>' . $this->Time->format('H:i d.m.Y', $event['created']) . '</td>';
	$events_table .= '<td>' . h($event['comment']) . '</td>';
	$events_table .= '</tr>';
	$i ++;
}
$this->Backend->addHtml('
<table width="100%" cellspacing="2" cellpadding="2" id="grid">
	<colgroup>
		<col width="94px">
		<col>
		<col>
		<col>
		<col>
		<col>
	</colgroup>
	<thead>
		<tr class="admin_table_title">
			<td>' . __d('admin_orders', 'column_order_event_status') . '</td>
			<td>' . __d('admin_orders', 'column_order_event_created') . '</td>
			<td>' . __d('admin_orders', 'column_order_event_comment') . '</td>
		</tr>
	</thead>
	<tbody>' . $events_table . '</tbody>
</table>
');
$this->Backend->addHtml('<h3>' . __d('admin_orders', 'title_change_status') . '</h3>');
$this->Backend->addSelect('status_id', array(
	'label' => __d('admin_orders', 'label_status_id'),
	'options' => $statuses
));
$this->Backend->addTextarea('comment', array(
	'label' => __d('admin_orders', 'label_comment')
));
$this->Backend->addCheckbox('send', array(
	'label' => __d('admin_orders', 'label_send')
));
$this->Backend->addHidden('id');
$this->Backend->addHidden('action', array(
	'type' => 'hidden',
	'value' => 'apply',
	'id' => 'frm_action'
));
$this->Backend->removeFormButton('save_and_exit');
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();