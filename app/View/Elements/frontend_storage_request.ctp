<?php
	echo $this->Form->hidden('phone');
	echo $this->Form->hidden('request_id');
	echo $this->Form->hidden('return_form', array('value' => 1));
	$time = strtotime($request['StorageRequest']['date']);
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
	$auto = array();
	if (!empty($request['CarBrand']['title'])) {
		$auto[] = $request['CarBrand']['title'];
	}
	if (!empty($request['CarModel']['title'])) {
		$auto[] = $request['CarModel']['title'];
	}
?>
<h3>Данные квитанции</h3>
<div class="item_div"><strong>Номер квитанции</strong> &mdash; <?php echo h($request['StorageRequest']['request_id']); ?></div>
<div class="item_div"><strong>Время создания</strong> &mdash; <?php echo $this->Time->format('H:i d.m.Y', $request['StorageRequest']['created']); ?></div>
<div class="item_div"><strong>Адрес</strong> &mdash; <?php echo h($request['Station']['title']); ?></div>
<div class="item_div"><strong>Дата</strong> &mdash; <?php echo date('d.m.Y', $time); ?></div>
<div class="item_div"><strong>Время</strong> &mdash; <?php echo substr($request['StorageRequest']['time'], 0, 5); ?></div>
<h3>Данные шин</h3>
<div class="item_div"><strong>Шины</strong> &mdash; <?php echo h($tyre_info); ?></div>
<div class="item_div"><strong>Износ</strong> &mdash; <?php echo h($request['StorageRequest']['treadwear']); ?></div>
<div class="item_div"><strong>Состояние</strong> &mdash; <?php echo h($request['StorageRequest']['tyre_condition']); ?></div>
<h3>Данные дисков</h3>
<div class="item_div"><strong>Диски</strong> &mdash; <?php echo h($disk_info); ?></div>
<div class="item_div"><strong>Состояние</strong> &mdash; <?php echo h($request['StorageRequest']['disk_condition']); ?></div>
<h3>Данные автомобиля</h3>
<div class="item_div"><strong>Автомобиль</strong> &mdash; <?php echo h(implode(' ', $auto)); ?></div>
<div class="item_div"><strong>ГОС-номер</strong> &mdash; <?php echo h($request['StorageRequest']['number']); ?></div>
<h3>Контактные данные</h3>
<div class="item_div"><strong>Имя</strong> &mdash; <?php echo h($request['StorageRequest']['name']); ?></div>
<div class="item_div"><strong>Номер телефона</strong> &mdash; <?php echo h($request['StorageRequest']['phone']); ?></div>
<div class="item_div"><strong>E-mail</strong> &mdash; <?php echo h($request['StorageRequest']['email']); ?></div>