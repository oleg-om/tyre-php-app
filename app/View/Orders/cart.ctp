<div class="cart-popup">
<div class="cart-popup__head">
	<div class="cart-popup__title">Мой заказ</div>
	<button type="button" onclick="close_popup();" class="cart-popup__close" aria-label="Закрыть">
		<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
	</button>
</div>
<?php echo $this->element('currency'); ?>
<?php
if (!empty($cart['items'])) {
?>
<div class="cart-popup__items">
<?php
	echo $this->element('cart_items', array('popup' => true));
?>
<div class="cart-prod total-cart">
	<div class="desc">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td class="total-price">Итого к оплате:</td>
				<td class="total-all"><?php echo $this->Frontend->getCartPriceOnly($cart['total']); ?></td>
			</tr>
		</table>
	</div>
</div>
</div>
<?php } else { ?>
<script type="text/javascript">
<!--
close_popup();
//-->
</script>
<?php } ?>
<div class="option-cart">
	<a href="javascript:void(0);" onclick="close_popup();" class="next-shop">Продолжить покупки</a>
	<div class="checkout"><a href="/checkout" class="btVer1">Оформить заказ</a></div>
</div>
</div>
