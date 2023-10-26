<?php
$value = min(4, $product['Product']['stock_count']);
if ($product['Product']['category_id'] > 2) {
	$value = min(1, $product['Product']['stock_count']);
}
if ($value > 0) {
?>
<div class="select-namber">
	<a href="javascript:void(0);" onclick="items_minus();">-</a>
	<span><input type="text" id="items_count" name="items_count" value="<?php echo $value; ?>"> шт.</span>
	<a href="javascript:void(0);" onclick="items_plus();">+</a>
</div>
<?php } ?>
<script type="text/javascript">
<!--
var max_items = <?php echo $product['Product']['stock_count']; ?>;
function items_plus() {
	var items_count = parseInt($('#items_count').val().trim());
	if (isNaN(items_count)) {
		items_count = 0;
	}
	items_count ++;
	if (items_count > max_items) {
		items_count = max_items;
	}
	$('#items_count').val(items_count);
}
function items_minus() {
	var items_count = parseInt($('#items_count').val().trim());
	if (isNaN(items_count)) {
		items_count = 0;
	}
	items_count --;
	if (items_count < 1) {
		items_count = 1;
	}
	$('#items_count').val(items_count);
}
function buy() {
	var items_count = parseInt($('#items_count').val().trim());
	if (isNaN(items_count)) {
		items_count = 0;
	}
	open_popup({
		url: '/cart',
		type: 'post',
		data: {
			'data[Product][0][count]': items_count,
			'data[Product][0][product_id]': <?php echo $product['Product']['id']; ?>
		}
	});
}


//-->
</script>