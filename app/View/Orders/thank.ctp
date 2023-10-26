<div id="center">
	<div class="thank">
		<div class="title">Спасибо, ваш заказ отправлен.<br/>
		Наши менеджеры свяжутся с Вами в кратчайшие сроки.</div>
		<div class="resp">С уважением, команда kerchshina.com</div>
		<?php
			if (isset($order)) {
				$order['Order']['total'] = 0.1;
				$amount = number_format($order['Order']['total'], 2, '.', '');
				$amount = $amount * 100;
				$Version = '1.0.0';
				$Password = CONST_PRIVAT_PASSWORD;
				$MerID = CONST_PRIVAT_MERID;
				$AcqID = '414963';
				$OrderID = 'kerchshina-' . $order['Order']['id'] . '-' . substr(md5(uniqid(rand(), true)), 0, 6);
				$PurchaseAmt = str_pad($amount, 12, '0', STR_PAD_LEFT);
				$PurchaseCurrency = '980';
				$PurchaseCurrencyExponent = '2';
				$OrderDescription = 'Оплата заказа №' . $order['Order']['id'] . ' на сайте kerchshina.com';
				$str = $Password . $MerID . $AcqID . $OrderID . $PurchaseAmt . $PurchaseCurrency . $OrderDescription;
				$Signature = sha1($str);
				$Signature = hexbin($Signature);
				$Signature = base64_encode($Signature);
			?>
				<br />
				<form method="post" action="https://ecommerce.liqpay.com/ecommerce/CheckOutPagen">
					<input name="version" value="<?php echo $Version; ?>" type="hidden" />
					<input name="orderid" value="<?php echo $OrderID; ?>" type="hidden" />
					<input name="merrespurl" value="<?php echo Router::url(array('controller' => 'orders', 'action' => 'privat_response'), true); ?>" type="hidden" />
					<input name="merid" value="<?php echo $MerID; ?>" type="hidden" />
					<input name="acqid" value="<?php echo $AcqID; ?>" type="hidden" />
					<input name="purchaseamt" value="<?php echo $PurchaseAmt; ?>" type="hidden" />
					<input name="purchasecurrencyexponent" value="<?php echo $PurchaseCurrencyExponent; ?>" type="hidden" />
					<input name="purchasecurrency" value="<?php echo $PurchaseCurrency; ?>" type="hidden" />
					<input name="orderdescription" value="<?php echo $OrderDescription; ?>" type="hidden" />
					<input name="signature" value="<?php echo $Signature; ?>" type="hidden" />
					<button type="submit" class="bt-ver2">Оплатить заказ</button>
				</form>
			<?php
			}
		?>
	</div>
</div>