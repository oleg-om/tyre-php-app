<?php echo $this->element('regions'); ?>
<div id="right">
<h1 class="contentheading">Доставка шин и дисков в <?php echo $city['DeliveryCity']['title']; ?>.</h1>

<p>В интернет-магазине kerchshina.com Вы можете приобрести шины и диски с доставкой в город <?php echo $city['DeliveryCity']['title']; ?>, <?php echo $city['DeliveryRegion']['title']; ?>.<br/>
Сроки доставки 7-10 дней в зависимости от отдалённости города и сроков оплаты.</p>

<p>Более точные сроки доставки в <?php echo $city['DeliveryCity']['title']; ?> уточняйте у менеджеров.</p>

<p>Пересылка оплачивается по тарифам транспортных компаний. Расходы по пересылке Вы можете уточнить на сайте соответствующей транспортной компании "Быстрая почта", "Delivery" и "ТАТ".</p>

<p>Отправляем шины и диски в <?php echo $city['DeliveryCity']['title']; ?> и по области транспортной компанией "Быстрая почта", "Delivery" и "ТАТ".</p>

<p>Адреса складов в городе <?php echo $city['DeliveryCity']['title']; ?>

<p><a href="http://fastpost.org/office/bystraya_pochta_kerch.aspx" target="_blank" rel="nofollow">Быстрая Почта</a></p>

<p><a href="http://www.delivery-auto.com/ru-RU/Representatives/RepresentativesList" target="_blank" rel="nofollow">Delivery</a></p>

<p><a href="http://www.tk-tat.ru/sip/contacts/khc_contacts.php" target="_blank" rel="nofollow">ТАТ</a></p>


<p>Сроки оплаты и способы доставки можно уточнить по телефону +7 (978) 090 44 48</p>
<?php if (false) { ?>
	<h1 class="contentheading">Шины <?php echo $city['DeliveryCity']['title']; ?>, купить диски <?php echo $city['DeliveryCity']['title']; ?></h1>
	<b>Продажа шин и дисков в <?php echo $city['DeliveryCity']['title']; ?>.</b>
	<br><br>В интернет-магазине shina.cc Вы можете приобрести шины и диски с доставкой в город <?php echo $city['DeliveryCity']['title']; ?>, АР Крым.
	<br>Сроки доставки 1-4 дня в зависимости от отдалённости города и сроков оплаты.
	<br><br>
	<b>Более точные сроки доставки в <?php echo $city['DeliveryCity']['title']; ?> уточняйте у менеджеров.</b>
	<br><br>
	<span class="red"><b>Пересылка оплачивается по тарифам транспортных компаний. Расходы по пересылке Вы можете уточнить на сайте соответствующей транспортной компании "Интайм", "Новая Почта" и "САТ".</b></span>
	<br><br>
	Оплата наложенным платежом при получении на офисе транспортной компании "Интайм", "Новая Почта" и "САТ".
	<br><br>
	Отправляем шины и диски в <b><?php echo $city['DeliveryCity']['title']; ?></b> и по области транспортной компанией <b>"Интайм"</b>, <b>"Новая Почта"</b> и <b>"САТ"</b>.
	<div class="titlegrey">Адреса складов в городе <span><?php echo $city['DeliveryCity']['title']; ?></span></div><br>
	<?php
		$type_1_count = 0;
		$type_2_count = 0;
		foreach ($city['DeliveryStore'] as $item) {
			if ($item['type'] == 1) {
				$type_1_count ++;
			}
			elseif ($item['type'] == 2) {
				$type_2_count ++;
			}
		}
		if ($type_2_count) {
	?>
	<b>Интайм</b><br><br>
	<table width="100%" cellpadding="5">
		<tr>
      		<td width="50%" valign="top"><ul><?php
				$per_column = ceil($type_2_count / 2);
				$shown = 0;
				foreach ($city['DeliveryStore'] as $item) {
					if ($item['type'] == 2) {
						echo '<li>' . $city['DeliveryCity']['title'] . ': ' . $item['title'] . '</li>';
						$shown ++;
					}
					if ($shown == $per_column) {
						echo '</ul></td><td width="50%" valign="top"><ul>';
					}
				}
			?></ul></td>
		</tr>
	</table>
	<?php } ?>
	<?php if ($type_1_count) { ?>
	<br><b>Новая Почта</b><br><br>
	<table width="100%" cellpadding="5">
		<tr>
      		<td width="50%" valign="top"><ul><?php
				$per_column = ceil($type_1_count / 2);
				$shown = 0;
				foreach ($city['DeliveryStore'] as $item) {
					if ($item['type'] == 1) {
						echo '<li>' . $city['DeliveryCity']['title'] . ': ' . $item['title'] . '</li>';
						$shown ++;
					}
					if ($shown == $per_column) {
						echo '</ul></td><td width="50%" valign="top"><ul>';
					}
				}
			?></ul></td>
		</tr>
	</table>
	<?php } ?>
<?php } ?>
</div>