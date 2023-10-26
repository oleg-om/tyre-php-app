<?php
$this->Paginator->options(array('url' => array('controller' => 'tubes', 'action' => 'index', '?' => $filter)));
?>
<div id="vmMainPage">
	<?php
		echo $this->element('pager');
	?>
	<table border="0" width="100%" cellspacing="0" cellpadding="0" class="sectiontableheader sectiontableentry1">
		<tr class="rowTint1">
			<th>Тип</th>
			<th>Размеры и описание</th>
			<?php if ($this->Frontend->canShowTubePrice(false)) { ?>
				<th width="50">Цена</th>
			<?php } ?>
			<th>Кол.</th>
			<th></th>
		</tr>
		<?php $i = 0; foreach ($products as $item) { ?>
		<tr height="22" class="rowTint<?php echo $i % 2 == 1 ? '1' : ''; ?>">
			<td align="left"><?php echo $types[$item['Product']['type']]; ?></td>
			<td align="left"><?php echo $this->Html->link($item['Product']['sku'], array('controller' => 'tubes', 'action' => 'view', 'id' => $item['Product']['id']), array('escape' => false)); ?></td>
			<?php if ($this->Frontend->canShowTubePrice(false)) { ?>
			<td width="70">
				<?php if ($this->Frontend->canShowTubePrice($item['Product']['not_show_price'])) { ?>
					<span class="productPrice"><?php echo $this->Frontend->getPrice($item['Product']['price'], 'tubes'); ?></span>
				<?php } ?>
			</td>
			<?php } ?>
			<td><?php echo $this->Frontend->getStockCount($item['Product']['stock_count']); ?></td>
			<td><?php echo $item['Product']['in_stock'] ? '.' : ''; ?></td>
		</tr>
		<?php $i ++; } ?>
	</table>
	<div class="clear"></div>
	<?php
		echo $this->element('pager', array('bottom' => true));
	?>
</div>