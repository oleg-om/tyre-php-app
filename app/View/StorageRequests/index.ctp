<h2 class="title"><?php echo h($page['Page']['title']); ?></h2>
<p>Страница в разработке</p>
<?php if (false) { ?>
<?php echo $this->Form->create('StorageRequest', array('id' => 'request-frm')); ?>
<div class="storage">
	<?php
		echo $this->Session->flash('error');
		echo $this->Session->flash('info');
	?>
	<h3>Сдать шины на хранение</h3>
	<div class="storage-tabs">
		<ul>
			<li>Тип авто</li>
			<li class="tab-link active" id="tab-link-car" onclick="tab('car');">Легковой автомобиль</li>
			<li class="tab-link" id="tab-link-suv" onclick="tab('suv');">Внедорожник, SUV</li>
		</ul>
	</div>
	<div class="tab" id="tab-car">
		<table width="100%">
			<thead>
				<tr>
					<th></th>
					<th>Наименование услуг</th>
					<th align="right">Стоимость</th>
					<th align="center">Кол-во </th>
					<th align="right">Сумма</th>
				</tr>
			</thead>
			<tbody><?php
				foreach ($prices as $item) {
					if ($item['Price']['type'] == 'car') {
						$title = h($item['Price']['title']);
						if (!empty($item['Price']['description'])) {
							$title = '<strong>' . $title . '</strong>';
						}
						//$title .= ' <span class="time">' . $item['Price']['time'] . ' мин.</span>';
						$title = '<p>' . $title . '</p>';
						if (!empty($item['Price']['description'])) {
							$title .= '<p>(' . h($item['Price']['description']) . ')</p>';
						}
						$title .= $this->Form->hidden('price_' . $item['Price']['id'], array('value' => $item['Price']['price'], 'class' => 'price'));
						echo '<tr>';
						echo '<td align="center" valign="top">' . $this->Form->checkbox('price_id_' . $item['Price']['id']) . '</td>';
						echo '<td class="name"><label for="StorageRequestPriceId' . $item['Price']['id'] . '">' . $title . '</label></td>';
						echo '<td class="total">' . $this->Frontend->getStoragePrice($item['Price']['price']) . '</td>';
						echo '<td><button class="small-btn minus" type="button">-</button>' . $this->Form->text('quantity_' . $item['Price']['id'], array('value' => 0, 'class' => 'qty')) . '<button class="small-btn plus" type="button">+</button></td>';
						echo '<td class="total">&mdash;</td>';
						echo '</tr>';
					}
				}
			?></tbody>
		</table>
	</div>
	<div class="tab" id="tab-suv" style="display:none;">
		<table width="100%">
			<thead>
				<tr>
					<th></th>
					<th>Наименование услуг</th>
					<th align="right">Стоимость</th>
					<th align="center">Кол-во </th>
					<th align="right">Сумма</th>
				</tr>
			</thead>
			<tbody><?php
				foreach ($prices as $item) {
					if ($item['Price']['type'] == 'suv') {
						$title = h($item['Price']['title']);
						if (!empty($item['Price']['description'])) {
							$title = '<strong>' . $title . '</strong>';
						}
						$title .= ' <span class="time">' . $item['Price']['time'] . ' мин.</span>';
						$title = '<p>' . $title . '</p>';
						if (!empty($item['Price']['description'])) {
							$title .= '<p>(' . h($item['Price']['description']) . ')</p>';
						}
						$title .= $this->Form->hidden('price_' . $item['Price']['id'], array('value' => $item['Price']['price'], 'class' => 'price'));
						echo '<tr>';
						echo '<td align="center" valign="top">' . $this->Form->checkbox('price_id_' . $item['Price']['id']) . '</td>';
						echo '<td class="name"><label for="StorageRequestPriceId' . $item['Price']['id'] . '">' . $title . '</label></td>';
						echo '<td class="total">' . $this->Frontend->getStoragePrice($item['Price']['price']) . '</td>';
						echo '<td><button class="small-btn minus" type="button">-</button>' . $this->Form->text('quantity_' . $item['Price']['id'], array('value' => 0, 'class' => 'qty')) . '<button class="small-btn plus" type="button">+</button></td>';
						echo '<td class="total">&mdash;</td>';
						echo '</tr>';
					}
				}
			?></tbody>
		</table>
	</div>
	<div class="total">Итого: <span id="total"><?php echo $this->Frontend->getStoragePrice(0); ?></span></div>
	<h3>Данные шин</h3>
	<div class="r-cols">
		<div class="col-left"><?php
			echo $this->Form->input('brand_id', array('type' => 'select', 'label' => 'Производитель', 'options' => $tyre_brands, 'empty' => array(0 => '...'), 'class' => 'tyre-select select_brand_id'));
			echo $this->Form->input('model_id', array('type' => 'select', 'label' => 'Модель', 'options' => array(), 'empty' => array(0 => '...'), 'class' => 'tyre-select select_model_id'));
			echo $this->Form->input('treadwear', array('type' => 'text', 'label' => 'Износ', 'class' => 'half'));
		?></div>
		<div class="col-right"><?php
			$size2 = $this->Form->select('size2', $tyre_size2, array('class' => 'tyre-select select_size2', 'empty' => array(0 => '...')));
			$size3 = $this->Form->select('size3', $tyre_size3, array('class' => 'tyre-select select_size3', 'empty' => array(0 => '...')));
			echo $this->Form->input('size1', array('type' => 'select', 'label' => 'Размер', 'options' => $tyre_size1, 'empty' => array(0 => '...'), 'class' => 'tyre-select select_size1', 'between' => '<div class="size-box">', 'after' => '</div><div class="size-box">' . $size2 . '</div><div class="size-box">' . $size3 . '</div>'));
			echo $this->Form->input('season', array('type' => 'select', 'label' => 'Сезон', 'options' => $tyre_seasons, 'empty' => array(0 => '...'), 'class' => 'tyre-select select_season'));
			echo $this->Form->input('tyre_condition', array('type' => 'text', 'label' => 'Состояние'));
		?></div>
		<div class="clear"></div>
	</div>
	<h3>Данные дисков</h3>
	<div class="r-cols">
		<div class="col-left"><?php
			echo $this->Form->input('radius', array('type' => 'select', 'label' => 'Диаметр', 'options' => $disk_size1, 'empty' => array(0 => '...')));
			echo $this->Form->input('material', array('type' => 'select', 'label' => 'Тип', 'options' => $materials, 'empty' => array(0 => '...')));
		?></div>
		<div class="col-right pad-top"><?php
			echo $this->Form->input('disk_condition', array('type' => 'text', 'label' => 'Состояние'));
		?></div>
		<div class="clear"></div>
	</div>
	<h3>Выберите СТО</h3>
	<div class="stations-list">
		<ul><?php
			$stations_list = array();
			foreach ($stations as $item) {
				$stations_list[$item['Station']['id']] = $item['Station']['title'] . ' (' . $this->Html->link('на карте', array('controller' => 'stations', 'action' => 'view', 'slug' => $item['Station']['slug']), array('target' => '_blank')) . ')';
			}
			echo '<li>' . $this->Form->radio('station_id', $stations_list, array('separator' => '</li><li>', 'fieldset' => false, 'legend' => false, 'required' => true)) . '</li>';
		?></ul>
	</div>
	<div class="data-group">
		<h3>Дата и время</h3>
		<div class="datetime"><?php
			echo $this->Form->text('date', array('class' => 'date', 'required' => true));
			echo $this->Form->text('time', array('class' => 'time', 'required' => true));
		?></div>
	</div>
	<h3>Данные автомобиля</h3>
	<div class="auto"><?php
		echo $this->Form->input('car_brand_slug', array('type' => 'select', 'label' => 'Производитель', 'options' => $car_brands, 'empty' => array(0 => '...')));
		echo $this->Form->input('car_model_id', array('type' => 'select', 'label' => 'Модель', 'options' => $car_models, 'empty' => array(0 => '...')));
		echo $this->Form->input('number', array('label' => 'ГОС-номер', 'type' => 'text'));
	?></div>
	<h3>Контактные данные</h3>
	<div class="auto"><?php
		echo $this->Form->input('name', array('label' => 'Имя <span class="red">*</span>', 'type' => 'text', 'required' => true));
		echo $this->Form->input('phone', array('label' => 'Номер телефона <span class="red">*</span>', 'type' => 'text', 'required' => true));
		echo $this->Form->input('email', array('label' => 'E-mail', 'type' => 'email'));
	?></div>
	<div class="button">
		<button type="submit">Отправить заявку</button>
	</div>
</div>
<?php
$currency_template = array();
foreach ($currencies as $item) {
	if ($item['Currency']['storage']) {
		$currency_template = $item['Currency']['short_title'];
		break;
	}
}
$currency_template = str_replace(array('{before}', '{after}', '{between}'), array('', '', '&nbsp;'), $currency_template);
?>
<?php echo $this->Form->end(); ?>
<script type="text/javascript">
<!--
var currency_template = '<?php echo $currency_template; ?>';
$(function() {
	$.fn.datepicker.dates['ru'] = {
		days: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'],
		daysShort: ['Вск', 'Пнд', 'Втр', 'Срд', 'Чтв', 'Птн', 'Суб', 'Вск'],
		daysMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
		months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
		monthsShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек']
	};
	$('.datetime .time').timepicker({
		'timeFormat': 'H:i',
		'step': 30,
		'maxTime': '9:00pm',
		'minTime': '9:00am'
	});
	$('.datetime .date').datepicker({
		'format': 'dd.mm.yyyy',
		'autoclose': true,
		'language': 'ru'
	});
	recount();
	$('.tab input[type=checkbox]').click(recount);
	$('.tab .plus').click(function(){
		var qty = parseInt($(this).parent().find('input').val());
		if (isNaN(qty)) {
			qty = 1;
		}
		else {
			qty ++;
		}
		$(this).parent().find('input').val(qty);
		recount();
	});
	$('.tab .minus').click(function(){
		var qty = parseInt($(this).parent().find('input').val());
		if (isNaN(qty)) {
			qty = 1;
		}
		else {
			qty --;
		}
		if (qty <= 0) {
			qty = 1;
		}
		$(this).parent().find('input').val(qty);
		recount();
	});
	$('.tab .qty').keyup(function(){
		var qty = parseInt($(this).parent().find('input').val());
		if (isNaN(qty)) {
			qty = 1;
		}
		if (qty <= 0) {
			qty = 1;
		}
		$(this).parent().find('input').val(qty);
		recount();
	});
	$('#StorageRequestCarBrandId').change(function() {
		$('#StorageRequestCarModelId option').remove();
		if (parseInt($(this).val()) != 0) {
			$('#StorageRequestCarModelId').ajaxAddOption('/car_models/get_models/' + $(this).val(), {}, false);
		}
	});
	$('#StorageRequestBrandId').change(function() {
		$('#StorageRequestModelId option').remove();
		if (parseInt($(this).val()) != 0) {
			$('#StorageRequestModelId').ajaxAddOption('/models/get_models/' + $(this).val(), {}, false);
		}
	});
});
function recount() {
	var total = 0;
	$('.tab tbody tr').each(function(){
		var cb = $(this).find('input[type=checkbox]');
		if (cb.prop('checked')) {
			$(this).find('.minus').removeAttr('disabled');
			$(this).find('.plus').removeAttr('disabled');
			var qty = parseInt($(this).find('.qty').val());
			if (isNaN(qty)) {
				qty = 1;
			}
			if (qty <= 0) {
				qty = 1;
			}
			$(this).find('.qty').val(qty).removeAttr('disabled');
			var price = parseFloat($(this).find('.price').val());
			total += price * qty;
			$(this).find('.total').html(format_price(qty * price));
		}
		else {
			$(this).find('.minus').attr('disabled', 'disabled');
			$(this).find('.plus').attr('disabled', 'disabled');
			$(this).find('.qty').val('0').attr('disabled', 'disabled');
			$(this).find('.total').html('&mdash;');
		}
	});
	$('#total').html(format_price(total));
}
function tab(t) {
	$('.tab-link').removeClass('active');
	$('#tab-link-' + t).addClass('active');
	$('.tab').hide();
	$('#tab-' + t).show();
}
function format_price(price) {
	price = Math.ceil(price);
	return currency_template.replace(/{value}/, price);
}
//-->
</script>
<?php } ?>