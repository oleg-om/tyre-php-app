<?php
if (!isset($popup)) {
	$popup = false;
}
foreach ($cart['items'] as $product_id => $count) {
	$product = $products[$product_id];
	$title = $product['Brand']['title'] . ' ' . $product['BrandModel']['title'];
	if ($product['Product']['category_id'] == 1) {
		$type = 'tyres';
		$title .= ' ' . $product['Product']['size1'] . '/' . $product['Product']['size2'] . ' R' . $product['Product']['size3'];
		$url = array('controller' => 'tyres', 'action' => 'view', 'slug' => $product['Brand']['slug'], 'id' => $product['Product']['id']);
		$image = $this->Html->image('no-tyre-little.jpg');
		if (!empty($product['BrandModel']['filename'])) {
			$image = $this->Html->image($this->Backend->thumbnail(array('id' => $product['BrandModel']['id'], 'filename' => $product['BrandModel']['filename'], 'path' => 'models', 'width' => 158, 'height' => 158, 'crop' => false, 'folder' => false, 'tyre' => true, 'empty' => '/img/no-tyre-little.jpg')), array('alt' => $product['BrandModel']['title']));
		}
	}
	elseif ($product['Product']['category_id'] == 2) {
		$type = 'disks';
		$title .= ' ' . $product['Product']['size2'] . ' R' . $product['Product']['size2'] . 'x' . $product['Product']['size3'];
		$url = array('controller' => 'disks', 'action' => 'view', 'slug' => $product['Brand']['slug'], 'id' => $product['Product']['id']);
		$image = $this->Html->image('no-disk-little.jpg');
		if (!empty($product['BrandModel']['filename'])) {
			$image = $this->Html->image($this->Backend->thumbnail(array('id' => $product['BrandModel']['id'], 'filename' => $product['BrandModel']['filename'], 'path' => 'models', 'width' => 158, 'height' => 158, 'crop' => false, 'folder' => false, 'empty' => '/img/no-disk-little.jpg')), array('alt' => $product['BrandModel']['title']));
		}
	}
	elseif ($product['Product']['category_id'] == 3) {
		$type = 'akb';
		$title .= ' ' . $product['Product']['ah'] . 'ач ' . $product['Product']['f1'];
		$url = array('controller' => 'akb', 'action' => 'view', 'slug' => $product['Brand']['slug'], 'id' => $product['Product']['id']);
		$image = $this->Html->image('no-akb-little.jpg');
		$filename = null;
		if (!empty($product['Product']['filename'])) {
			$filename = $product['Product']['filename'];
			$id = $product['Product']['id'];
			$path = 'akb';
		}
		elseif (!empty($product['BrandModel']['filename'])) {
			$filename = $product['BrandModel']['filename'];
			$id = $product['BrandModel']['id'];
			$path = 'models';
		}
		if (!empty($filename)) {
			$image = $this->Html->image($this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $path, 'width' => 158, 'height' => 158, 'crop' => false, 'folder' => false, 'empty' => '/img/no-akb-little.jpg')), array('alt' => $product['BrandModel']['title']));
		}
	}
	else {
		$type = 'bolts';
		$title = $bolt_types[$product['Product']['bolt_type']] . ' ' . $product['Product']['bolt'];
		$url = array('controller' => 'bolts', 'action' => 'view', 'id' => $product['Product']['id']);
		$image = $this->Html->image('no-bolts-little.jpg');
		$filename = null;
		if (!empty($product['Product']['filename'])) {
			$filename = $product['Product']['filename'];
			$id = $product['Product']['id'];
			$path = 'bolts';
		}
		if (!empty($filename)) {
			$image = $this->Html->image($this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $path, 'width' => 158, 'height' => 158, 'crop' => false, 'folder' => false, 'empty' => '/img/no-bolts-little.jpg')), array('alt' => $title));
		}
	}
    $product_count = $product['Product']['stock_count'];
    if (isset($product['Product']['count_out_of_stock']) && !empty($product['Product']['count_out_of_stock'])) {
        $product_count = $product['Product']['stock_count'] + $product['Product']['count_out_of_stock'];
    }
	echo '<div class="cart-prod" id="cart-item-' . $product['Product']['id'] . '"><input type="hidden" class="price" value="' . $this->Frontend->calculateCartPrice($product['Product']['price'], $type) . '"><input type="hidden" class="max_items" value="' . $product_count . '"><input type="hidden" class="product_id" value="' . $product['Product']['id'] . '"><a href="javascript:void(0);" onclick="delete_item(' . $product['Product']['id'] . ');" class="delete"></a><div class="img">' . $this->Html->link($image, $url, array('escape' => false)) . '</div><div class="desc"><h3>' . $this->Html->link($title, $url) . '</h3><table cellpadding="0" cellspacing="0"><tr><td class="price">' . $this->Frontend->getCartPrice($product['Product']['price'], $type) . '</td><td><div class="select-namber"><a href="javascript:void(0);" onclick="items_minus_cart(' . $product['Product']['id'] . ');">-</a> <span><input type="text" value="' . $count . '" id="count-' . $product['Product']['id'] . '"> шт.</span> <a href="javascript:void(0);" onclick="items_plus_cart(' . $product['Product']['id'] . ');">+</a></div></td><td class="total">' . $this->Frontend->getCartPrice($product['Product']['price'] * $count, $type) . '</td></tr></table></div><div class="clear"></div></div>';
}
$currency_template = '{value}';
foreach ($currencies as $item) {
	if ($item['Currency']['cart']) {
		$currency_template = $item['Currency']['short_title'];
		$currency = $item['Currency'];
		break;
	}
}
$currency_template = str_replace(array('{before}', '{after}', '{between}'), array('', '', ' '), $currency_template);

?>
<script type="text/javascript">
<!--
var currency_template = '<?php echo $currency_template; ?>', round = <?php echo $currency['round']; ?>, round_down = <?php echo intval($currency['round_down']); ?>, decimals = <?php echo intval($currency['decimals']); ?>;
function items_plus_cart(id) {
	var items_count = parseInt($('#count-' + id).val().trim()), max_items = parseInt($('#cart-item-' + id + ' .max_items').val()), price = parseFloat($('#cart-item-' + id + ' .price').val().replace(/,/, '.').replace(' ', ''));
	if (isNaN(items_count)) {
		items_count = 0;
	}
	items_count ++;
	if (items_count > max_items) {
		items_count = max_items;
	}
	$('#count-' + id).val(items_count);
	$('#cart-item-' + id + ' .total').html(format_price(price * items_count));
	recount_total();
}
function items_minus_cart(id) {
	var items_count = parseInt($('#count-' + id).val().trim()), max_items = parseInt($('#cart-item-' + id + ' .max_items').val()), price = parseFloat($('#cart-item-' + id + ' .price').val().replace(/,/, '.').replace(' ', ''));
	if (isNaN(items_count)) {
		items_count = 0;
	}
	items_count --;
	if (items_count < 1) {
		items_count = 1;
	}
	$('#count-' + id).val(items_count);
	$('#cart-item-' + id + ' .total').html(format_price(price * items_count));
	recount_total();
}
function delete_item(id) {
	$('#cart-item-' + id).remove();
	$.ajax({url: '/cart/delete/' + id});
	<?php if ($popup) { ?>
	if ($('.cart-prod').length == 1) {
		close_popup();
	}
	<?php } else { ?>
	if ($('.cart-prod').length == 2) {
		$('.checkout-box').remove();
		$('.content').append('<p>Корзина пуста</p>');
	}
	<?php } ?>
	recount_total();
}
function recount_total() {
	var total = 0, params = {}, i = 0;
	$('.cart-prod input.price').each(function(){
		var price = parseFloat($(this).val().replace(/,/, '.').replace(' ', '')), items_count = parseInt($(this).parent().find('input[type=text]').val().trim()), product_id = parseInt($(this).parent().find('.product_id').val());
		total += round_price(price * items_count);
		params['data[Product][' + i + '][product_id]'] = product_id;
		params['data[Product][' + i + '][count]'] = items_count;
		i ++;

	});
	$('.cart-prod .total-all').html(format_price(total));
	$.ajax({
		url: '/cart',
		type: 'post',
		data: params
	});
}
function format_price(price) {
	price = round_price(price);
	return currency_template.replace(/{value}/, number_format(price, decimals, ',', ''));
}
function round_price(price) {
	if (round_down == 1) {
		return Math.floor(price / round) * round;
	}
	else {
		return Math.ceil(price / round) * round;
	}
}
function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + '')
    .replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
    .split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '')
    .length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1)
      .join('0');
  }
  return s.join(dec);
}
//-->
</script>