<?php
$time = strtotime($request['StorageRequest']['date']);
$size_parts = array();
$size_parts[] = $request['StorageRequest']['size1'] . '/' . $request['StorageRequest']['size2'] . ' R' . $request['StorageRequest']['size3'];
if (!empty($request['Brand']['title'])) {
	$size_parts[] = $request['Brand']['title'];
}
if (!empty($request['BrandModel']['title'])) {
	$size_parts[] = $request['BrandModel']['title'];
}
$price = $prices[$request['StorageRequestService'][0]['price_id']];
if ($price['Price']['disks']) {
	$size_parts[] = 'с дисками';
}
$user_parts = array();
if (!empty($request['StorageRequest']['phone'])) {
	$user_parts[] = $request['StorageRequest']['phone'];
}
if (!empty($request['StorageRequest']['name'])) {
	$user_parts[] = $request['StorageRequest']['name'];
}
?>
<div class="print-label">
	<table cellpadding="2" cellspacing="2" width="100%" border="1">
		<thead>
			<tr>
				<th>№</th>
				<th>Число / шт.</th>
				<th>Размер / Бренд / Модель</th>
				<th>Телефон / ФИО</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $request['StorageRequest']['request_id']; ?></td>
				<td>
					<?php echo date('d.m.Y', $time) ?><br />
					<?php echo $request['StorageRequestService'][0]['quantity']; ?> шт.
					<?php
						if (!empty($request['StorageRequest']['season'])) {
							echo '<br />' . $seasons[$request['StorageRequest']['season']];
						}
					?>
				</td>
				<td><?php echo implode('<br />', $size_parts); ?></td>
				<td><?php echo implode('<br />', $user_parts); ?></td>
			</tr>
		</tbody>
	</table>
</div>