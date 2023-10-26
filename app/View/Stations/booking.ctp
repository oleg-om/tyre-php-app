<h2 class="title"><?php echo h($page['Page']['title']); ?></h2>
<p>Страница в разработке</p>
<?php if (false) { ?>
	<div class="dates">
		<p class="title-data"><img src="/img/calendar.gif" alt="Выберите дату" />Выберите дату:</p>
		<p class="group-data"><?php
			$weekdays = array(
				0 => '',
				1 => '',
				2 => '',
				3 => '',
				4 => '',
				5 => '',
				6 => ''
			);
			$from = time();
			$today = date('Y-m-d');
			$tomorrow = date('Y-m-d', $from + 86400);
			$day_after_tomorrow = date('Y-m-d', $from + 172800);
			$dates = array();
			for ($i = 0; $i < 14; $i ++) {
				$time = $from + $i * 86400;
				$date = date('Y-m-d', $time);
				$class = null;
				if ($date == $current_date) {
					$class = 'active';
					$cur_date = date('d.m.Y', $time);
				}
				$weekday = date('w', $time);
				$wd = $weekdays[$weekday];
				if ($date == $today) {
					$wd .= '';
				}
				elseif ($date == $tomorrow) {
					$wd .= '';
				}
				elseif ($date == $day_after_tomorrow) {
					$wd .= '';
				}
				$dates[] = $this->Html->link(date('d.m Y', $time) . ' ' . $wd . '', array('controller' => 'stations', 'action' => 'booking', '?' => array('date' => $date)), array('class' => $class));
			}
			echo implode('', $dates);
		?></p>
	</div>
	<div class="booking-table">
		<?php
			$parts = explode(':', trim(CONST_STATION_START));
			$time_start = $parts[0] * 60 + $parts[1];
			$parts = explode(':', trim(CONST_STATION_END));
			$time_end = $parts[0] * 60 + $parts[1];
			$range = intval(CONST_STATION_RANGE);
			$parts = explode(':', date('H:i'));
			$time_now = $parts[0] * 60 + $parts[1];
		?>
		<div class="tables"<?php echo $show_form ? ' style="display:none;"' : ''; ?>>
			<table cellspacing="1" class="grid" border="1">
				<tr>
					<td class="time"></td>
					<?php
						for ($i = $time_start; $i < $time_end; $i += $range) {
							$time = floor($i / 60) . ':' . str_pad($i % 60, 2, '0', STR_PAD_LEFT);
							echo '<td class="time">' . $time . '</td>';
						}
					?>
				</tr>
				<?php
					foreach ($stations as $item) {
						echo '<tr>';
						echo '<td width="450px" class="title-link"><p><img src="/img/point.gif" alt="Выберите дату" />' . $this->Html->link($item['Station']['title'], array('controller' => 'stations', 'action' => 'view', 'slug' => $item['Station']['slug'])) . '</p></td>';
						for ($i = $time_start; $i < $time_end; $i += $range) {
							$time = floor($i / 60) . ':' . str_pad($i % 60, 2, '0', STR_PAD_LEFT);
							$full_time = str_pad(floor($i / 60), 2, '0', STR_PAD_LEFT) . ':' . str_pad($i % 60, 2, '0', STR_PAD_LEFT) . ':00';
							$places = $item['Station']['places'];
							if ($today == $current_date && $i <= $time_now) {
								$places = 0;
							}
							foreach ($item['Request'] as $request) {
								if ($request['time'] == $full_time) {
									$places --;
								}
							}
							$action = '';
							$class = 'occupied';
							if ($places > 0) {
								$class = 'available';
								$action = ' onclick="request_form(\'' . h($item['Station']['title']) . '\', ' . $item['Station']['id'] . ', \'' . $time . '\');"';
							}
							echo '<td class="' . $class . '"><div' . $action . '>' . ($places > 0 ? $places : '') . '</div></td>';
						}
						echo '</tr>';
					}
				?>
			</table>
			<br />
			<table cellspacing="0" class="info-booking">
				<tr>
					<td class="available"><div>2</div></td>
					<td>&nbsp;</td>
					<td>&mdash; есть запись (цифра указывает количество свободных постов)</td>
					<td>&nbsp;</td>
					<td class="occupied"><div></div></td>
					<td>&nbsp;</td>
					<td>&mdash; занято или не работаем</td>
				</tr>
			</table>
		</div>
		<div class="form"<?php echo !$show_form ? ' style="display:none;"' : ''; ?>><?php
			echo $this->Form->create('Request');
			echo $this->Form->hidden('station_id');
			echo $this->Form->hidden('time');
			echo '<div class="input"><label>Адрес</label><p id="station_title">' . h($station_title) . '</p></div>';
			echo '<div class="input"><label>Дата</label><p>' . $cur_date . '</p></div>';
			echo '<div class="input"><label>Время</label><p id="request_time">' . h($request_time) . '</p></div>';
			echo $this->Form->input('number', array('label' => 'ГОС-номер *', 'required' => true));
			echo $this->Form->input('name', array('label' => 'Ваше имя'));
			echo $this->Form->input('phone', array('label' => 'Телефон *', 'required' => true));
			echo $this->Form->input('email', array('label' => 'E-mail'));
			echo $this->Form->input('type', array('label' => 'Тип авто', 'options' => $types, 'empty' => false, 'type' => 'select'));
			$models_select = $this->Form->input('model_id', array('label' => false, 'div' => false, 'type' => 'select', 'empty' => array('' => '...'), 'options' => $car_models));
			echo $this->Form->input('brand_id', array('label' => 'Автомобиль', 'type' => 'select', 'empty' => array('' => '...'), 'options' => $car_brands, 'after' => '<div class="models">' . $models_select . '</div>'));
			echo $this->Form->input('radius', array('label' => 'Диаметр дисков *', 'required' => true, 'between' => '<span>R</span>', 'type' => 'select', 'empty' => array('' => '...'), 'options' => $radiuses));
			echo '<div class="buttons"><input type="submit" value="Забронировать"> <input type="button" onclick="close_form();" value="Отмена"></div>';
			echo $this->Form->end();
		?></div>
	</div>
<script type="text/javascript">
<!--
function request_form(station, station_id, time) {
	$('.tables').hide();
	$('.form').show();
	$('#station_title').html(station);
	$('#request_time').html(time);
	$('#RequestStationId').val(station_id);
	$('#RequestTime').val(time);
}
function close_form() {
	$('.form').hide();
	$('.tables').show();
	$('.error-message').remove();
}
$(function(){
	$('#RequestBrandId').change(function() {
		$('#RequestModelId option').remove();
		if (parseInt($(this).val()) != 0) {
			$('#RequestModelId').ajaxAddOption('/car_models/get_models/' + $(this).val(), {}, false);
		}
	});
});
//-->
</script>
<?php } ?>