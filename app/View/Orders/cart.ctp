<div class="title">Мой заказ<a href="javascript:void(0);" onclick="close_popup();" class="close">закрыть</a></div>
<?php echo $this->element('currency'); ?>
<?php
if (!empty($cart['items'])) {
	echo $this->element('cart_items', array('popup' => true));
?>
<div class="cart-prod total-cart">
	<div class="img">&nbsp;</div>
	<div class="desc">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td class="total-price">Итого к оплате:</td>
				<td class="total-all"><?php echo $this->Frontend->getCartPriceOnly($cart['total']); ?></td>
			</tr>
		</table>
	</div>
	<div class="clear"></div>
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
	<div class="checkout"><a href="/checkout" class="btVer1">Оформление заказа</a></div>
</div>