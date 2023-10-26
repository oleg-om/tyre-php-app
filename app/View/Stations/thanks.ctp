<h2 class="title"><?php echo h($page['Page']['title']); ?></h2>
<div class="stations-thanks">
	<p><strong>Спасибо!</strong></p>
	<p>Ваша бронь принята.</p>
	<p>Мы перезвоним вам для окончательного подтверждения заказа.</p>
	<div class="request">
		<h1>Бронь заказа на шиномонтаж в компании Шинный Центр "АВТОдом"</h1>
		<table cellspacing="0" cellpadding="10" border="0">
			<tr>
				<td valign="top">
					<h2>Бронь №<?php echo $request['Request']['id']; ?></h2>
					<table cellspacing="0" cellpadding="3" border="0">
						<tr>
							<td valign="top" class="label">Дата:</td>
							<td valign="top"><?php
								$time = strtotime($request['Request']['date']);
								echo date('d.m.Y', $time);
							?></td>
						</tr>
						<tr>
							<td valign="top" class="label">Время:</td>
							<td valign="top"><?php echo substr($request['Request']['time'], 0, 5); ?></td>
						</tr>      
						<tr>
							<td valign="top" class="label">Адрес:</td>
							<td valign="top"><?php echo h($request['Station']['title']); ?></td>
						</tr>
					</table>
					<h2>Для справок</h2>
					<table cellspacing="0" cellpadding="3" border="0">
						<tr>
							<td valign="top" class="label">Тел.: </td>
							<td valign="top">(06561) 5-63-43, (050) 655-15-08</td>
						</tr>
						<tr>
							<td valign="top" class="label">Email: </td>
							<td valign="top">mail@kerchshina.com.ua</td>
						</tr>
						<tr>
							<td valign="top" class="label">www:</td>
							<td valign="top"><a href="http://kerchshina.com.ua">kerchshina.com.ua</a></td>
						</tr>
					</table>
				</td>
				<td valign="top">
					<h2>Заказчик</h2>
					<table cellspacing="0" cellpadding="3" border="0">
						<tr>
							<td valign="top" class="label">Имя:</td>
							<td valign="top"><?php echo h($request['Request']['name']); ?></td>
						</tr>
						<tr>
							<td valign="top" class="label">Телефон:</td>
							<td valign="top"><?php echo h($request['Request']['phone']); ?></td>
						</tr>
						<tr>
							<td valign="top" class="label">E-mail:</td>
							<td valign="top"><?php echo h($request['Request']['email']); ?></td>
						</tr>
						<tr>
							<td valign="top" class="label">Автомобиль:</td>
							<td valign="top"><?php
								$auto = array();
								if (!empty($request['CarBrand']['title'])) {
									$auto[] = $request['CarBrand']['title'];
								}
								if (!empty($request['CarModel']['title'])) {
									$auto[] = $request['CarModel']['title'];
								}
								echo h(implode(' ', $auto));
								echo ' (' . $types[$request['Request']['type']] . ')';
							?></td>
						</tr>
						<tr>
							<td valign="top" class="label">ГОС-номер:</td>
							<td valign="top"><?php echo h($request['Request']['number']); ?></td>
						</tr>
						<tr>
							<td valign="top" class="label">Колеса:</td>
							<td valign="top">R<?php echo $request['Request']['radius']; ?></td>
						</tr>
						<tr>
							<td valign="top" class="label">Время создания:</td>
							<td valign="top"><?php echo $request['Request']['created']; ?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<p class="back-link">&larr; <a href="/stations/booking">назад</a></p>
</div>