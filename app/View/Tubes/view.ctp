<h2 class="title"><?php echo h($types[$product['Product']['type']] . ' ' . $product['Product']['sku']); ?></h1>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="model_description model_image">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<th class="none_border">Тип:</th>
					<td class="none_border"><?php echo h($types[$product['Product']['type']]); ?></td>
				</tr>
				<tr class="tyre_descr_tr">
					<th>Размеры и описание:</th>
					<td><?php echo h($product['Product']['sku']); ?></td>
				</tr>
				<?php if ($this->Frontend->canShowTubePrice($product['Product']['not_show_price'])) { ?>
				<tr>
					<th>Цена:</th>
					<td><div style="font-weight: bold; font-size: 1.2em; color:#E21;"><?php echo $this->Frontend->getPrice($product['Product']['price'], 'tubes'); ?></div></td>
				</tr>
				<?php } ?>
			</table>
		</td>
	</tr>
</table>