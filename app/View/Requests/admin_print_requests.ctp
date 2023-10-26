<div class="erquest-print-box">
	<h1>Заявки на шиномонтаж</h1>
	<h2>СТО: <?php echo h($station); ?></h2>
	<h3>Дата: <?php echo h($this->request->data['Request']['date']); ?></h3>
	<table cellpadding="2" cellspacing="0" width="100%" border="1">
		<colgroup>
			<col width="50px"/>
			<col/>
		</colgroup>
		<thead>
			<tr>
				<th>Время</th>
				<th>Заявка</th>
			</tr>
		</thead>
		<tbody><?php
			foreach ($requests as $item) {
				echo '<tr>';
				echo '<td>' . substr($item['Request']['time'], 0, 5) . '</td>';
				echo '<td>';
				if (!empty($item['storage_request'])) {
					$request = $item['storage_request'];
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
					echo '<h2>' . __d('admin_requests', 'label_storage_request_id') . ' &mdash; ' . $request['StorageRequest']['request_id'] . '</h2>';
					echo '<h3>' . __d('admin_storage_requests', 'title_tyre_info') . '</h3>';
					echo '<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_tyre_info') . '</strong> &mdash; ' . h($tyre_info) . '</div>';
					echo '<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_treadwear') . '</strong> &mdash; ' . h($request['StorageRequest']['treadwear']) . '</div>';
					echo '<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_tyre_condition') . '</strong> &mdash; ' . h($request['StorageRequest']['tyre_condition']) . '</div>';
					echo '<h3>' . __d('admin_storage_requests', 'title_disk_info') . '</h3>';
					echo '<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_disk_info') . '</strong> &mdash; ' . h($disk_info) . '</div>';
					echo '<div class="item_div"><strong>' . __d('admin_storage_requests', 'label_disk_condition') . '</strong> &mdash; ' . h($request['StorageRequest']['disk_condition']) . '</div>';
					echo '<div class="second"></div>';
					echo '<h2>Заявка на шиномонтаж</h2>';
				}
				$request = $item;
				$time = strtotime($request['Request']['date']);
				echo '<div class="item_div"><strong>' . __d('admin_requests', 'label_date') . '</strong> &mdash; ' . date('d.m.Y', $time) . '</div>';
				echo '<div class="item_div"><strong>' . __d('admin_requests', 'label_time') . '</strong> &mdash; ' . substr($request['Request']['time'], 0, 5) . '</div>';
				echo '<div class="item_div"><strong>' . __d('admin_requests', 'label_name') . '</strong> &mdash; ' . h($request['Request']['name']) . '</div>';
				echo '<div class="item_div"><strong>' . __d('admin_requests', 'label_phone') . '</strong> &mdash; ' . h($request['Request']['phone']) . '</div>';
				echo '<div class="item_div"><strong>' . __d('admin_requests', 'label_email') . '</strong> &mdash; ' . h($request['Request']['email']) . '</div>';
				$auto = array();
				if (!empty($request['CarBrand']['title'])) {
					$auto[] = $request['CarBrand']['title'];
				}
				if (!empty($request['CarModel']['title'])) {
					$auto[] = $request['CarModel']['title'];
				}
				echo '<div class="item_div"><strong>' . __d('admin_requests', 'label_auto') . '</strong> &mdash; ' . h(implode(' ', $auto)) . ' (' . $types[$request['Request']['type']] . ')' . '</div>';
				echo '<div class="item_div"><strong>' . __d('admin_requests', 'label_number') . '</strong> &mdash; ' . h($request['Request']['number']) . '</div>';
				echo '<div class="item_div"><strong>' . __d('admin_requests', 'label_radius') . '</strong> &mdash; R' . h($request['Request']['radius']) . '</div>';

				echo '</td>';
				echo '</tr>';
			}
		?></tbody>
	</table>
</div>
