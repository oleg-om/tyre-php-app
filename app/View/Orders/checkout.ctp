<div class="content">
	<?php if (!empty($cart['items'])) { ?>
	<div class="checkout-box">
		<div class="title-page">Оформление заказа</div>
		<?php echo $this->element('currency'); ?>
		<div class="form-order">
			<?php echo $this->Form->create('Order', array('url' => array('controller' => 'orders', 'action' => 'checkout'))); ?>
			<div class="item-option"><?php
				echo $this->Form->input('name', array('label' => array('text' => 'ФИО получателя <span class="red">*</span>:', 'class' => 'title'), 'class' => 'inp-style2', 'after' => '<div class="clear"></div>', 'div' => 'item'));
				echo $this->Form->input('phone', array('label' => array('text' => 'Телефон <span class="red">*</span>:', 'class' => 'title'), 'class' => 'inp-style2', 'after' => '<div class="clear"></div>', 'div' => 'item'));
				echo $this->Form->input('email', array('label' => array('text' => 'E-mail:', 'class' => 'title'), 'class' => 'inp-style2', 'after' => '<div class="clear"></div>', 'div' => 'item'));
			?></div>
			<div class="item-option"><?php
				echo $this->Form->hidden('shipping_method_id', array('value' => 2));
				//echo $this->Form->input('shipping_method_id', array('options' => $shipping_methods, 'empty' => false, 'class' => 'sel-style1 sel-style6', 'div' => 'item', 'label' => array('text' => 'Способ доставки:', 'class' => 'title'), 'after' => '<div class="clear"></div>'));
				//echo '<div id="payment-method-1" class="payment-method">';
				//echo $this->Form->input('shipping_type_id', array('options' => $shipping_types, 'empty' => false, 'class' => 'sel-style1 sel-style6', 'div' => 'item', 'label' => array('text' => 'Транспортная компания:', 'class' => 'title'), 'after' => '<div class="clear"></div>'));
				//echo $this->Form->input('region_id', array('options' => $regions, 'empty' => array('' => '...'), 'class' => 'sel-style1 sel-style6', 'div' => 'item place', 'label' => array('text' => 'Область:', 'class' => 'title'), 'after' => '<div class="clear"></div>'));
				//echo $this->Form->input('city_id', array('options' => $cities, 'empty' => array('' => '...'), 'class' => 'sel-style1 sel-style6', 'div' => 'item place', 'label' => array('text' => 'Город:', 'class' => 'title'), 'after' => '<div class="clear"></div>'));
				//echo $this->Form->input('store_id', array('options' => $stores, 'empty' => array('' => '...'), 'class' => 'sel-style1 sel-style6', 'div' => 'item place', 'label' => array('text' => 'Склад:', 'class' => 'title'), 'after' => '<div class="clear"></div>'));
				//echo '</div>';
				//echo '<div id="payment-method-2" class="payment-method">';
				echo $this->Form->input('city', array('label' => array('text' => 'Город:', 'class' => 'title'), 'class' => 'inp-style2', 'after' => '<div class="clear"></div>', 'div' => 'item', 'type' => 'text'));
				echo $this->Form->input('address', array('type' => 'textarea', 'empty' => false, 'class' => 'textarea-style1', 'div' => 'item', 'label' => array('text' => 'Адрес:', 'class' => 'title'), 'after' => '<div class="clear"></div>'));
				//echo '</div>';
			?></div>
			<div class="item-option" id="payment-info-block">
				<?php //echo $this->Form->input('payment_type_id', array('options' => $payment_types, 'empty' => false, 'class' => 'sel-style1 sel-style6', 'div' => 'item', 'label' => array('text' => 'Оплата:', 'class' => 'title'), 'after' => '<div class="clear"></div>')); ?>
				<?php echo $this->Form->hidden('payment_type_id', array('value' => 1)); ?>
				<div class="item"><label class="title">Оплата:</label><p>при получении</p><div class="clear"></div></div>
				<div class="item"><div class="info"><table cellspacing="0" cellpadding="0"><tr><td id="payment-info">Оплата наложенным платежом при получении на офисе транспортной компании "Интайм", "Новая Почта" и "САТ".<br />Пересылка оплачивается по тарифам транспортных компаний. Расходы по пересылке Вы можете уточнить на сайте соответствующей транспортной компании "Интайм", "Новая Почта" и "САТ".</td></tr></table></div></div>
			</div>
			<div class="item-option last">
				<?php echo $this->Form->input('comment', array('type' => 'textarea', 'empty' => false, 'class' => 'textarea-style1', 'div' => 'item', 'label' => array('text' => 'Комментарий к заказу:', 'class' => 'title'), 'after' => '<div class="clear"></div>')); ?>
				<div class="item">
					<label class="title"></label>
					<div class="box-right-form">
						<button class="btVer1">Оформить заказ</button>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="popup order-page">
			<div class="title">Мой заказ</div>
			<?php echo $this->element('cart_items'); ?>
			<div class="cart-prod total-cart">
				<div class="img">&nbsp;</div>
				<div class="desc">
					<table cellpadding="0" cellspacing="0">
						<tr>
							<td class="total-price">Стоимость доставки:</td>
							<td class="total-price" align="right">по тарифам перевозчика</td>
						</tr>
					</table>
				</div>
				<div class="clear"></div>
			</div>
			<div class="cart-prod total-cart">
				<div class="img">&nbsp;</div>
				<div class="desc">
					<table cellpadding="0" cellspacing="0">
						<tr>
							<td class="total-price"><strong>Итого к оплате:</strong></td>
							<td class="total-all"><?php echo $this->Frontend->getCartPriceOnly($cart['total']); ?></td>
						</tr>
					</table>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<?php } else { ?>
	<p>Корзина пуста</p>
	<?php } ?>
</div>
<script type="text/javascript">
<!--
var payment_info = <?php echo $this->Js->object($payment_type_info); ?>;
$(function(){
	//payment_type_handler();
	//$('#OrderPaymentTypeId').change(payment_type_handler);
	payment_method_handler();
	$('#OrderShippingMethodId').change(payment_method_handler);
	$('#OrderShippingTypeId').change(function() {
		if ($(this).val() != '0') {
			$('.place select').attr('disabled', 'disabled').removeClass('changed');
			$(this).removeAttr('disabled').addClass('changed');
			$('#OrderRegionId option').remove();
			$('#OrderRegionId').ajaxAddOption('/shipping_types/get_regions/' + $(this).val(), {}, false, function() {
				$('.place select').removeAttr('disabled');
			});
		}
	});
	$('#OrderRegionId').change(function() {
		if ($(this).val() != '0') {
			$('.place select').attr('disabled', 'disabled').removeClass('changed');
			$(this).removeAttr('disabled').addClass('changed');
			$('#OrderCityId option').remove();
			$('#OrderCityId').ajaxAddOption('/regions/get_cities/' + $(this).val(), {}, false, function() {
				$('.place select').removeAttr('disabled');
			});
		}
	});
	$('#OrderCityId').change(function() {
		if ($(this).val() != '0') {
			$('.place select').attr('disabled', 'disabled').removeClass('changed');
			$(this).removeAttr('disabled').addClass('changed');
			$('#OrderStoreId option').remove();
			$('#OrderStoreId').ajaxAddOption('/cities/get_stores/' + $(this).val(), {}, false, function() {
				$('.place select').removeAttr('disabled');
			});
		}
	});
});
function payment_method_handler() {
	var method_id = $('#OrderShippingMethodId').val();
	if (method_id == 1) {
		$('#payment-info-block').show();
	}
	else {
		$('#payment-info-block').hide();
	}
	$('.payment-method').hide();
	$('#payment-method-' + method_id).show();
}
function payment_type_handler() {
	var payment_type = $('#OrderPaymentTypeId').val();
	$('#payment-info').html(payment_info[payment_type]);
}
//-->
</script>