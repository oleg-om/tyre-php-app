<?php
/**
 * Микроразметка Schema.org Product (JSON-LD) для страницы товара.
 * Параметры: $type ('tyres' | 'disks' | 'akb'), $product (Product + BrandModel), $brand, $image (путь к картинке или null),
 * $show_price — выводится ли цена на странице (без цены блок offers не выводим).
 */
$item = $product['Product'];
$model = $product['BrandModel'];

$data = array(
	'@context' => 'https://schema.org',
	'@type' => 'Product',
	'name' => ProductInfo::name($type, $product, $brand['Brand']['title']),
	'brand' => array('@type' => 'Brand', 'name' => $brand['Brand']['title']),
	'model' => $model['title'],
	'category' => ProductInfo::$categories[$type]
);
if (!empty($image)) {
	$data['image'] = $this->Html->url($image, true);
}
$description = ProductInfo::description($product);
if ($description !== '') {
	$data['description'] = $description;
}
foreach (ProductInfo::properties($type, $product) as $property => $value) {
	$data['additionalProperty'][] = array('@type' => 'PropertyValue', 'name' => $property, 'value' => $value);
}
if ($show_price) {
	$data['offers'] = array(
		'@type' => 'Offer',
		'url' => $this->Html->url(ProductUrl::url($type, $item, $brand['Brand']['slug'], $model['title']), true),
		'price' => $this->Frontend->cartPriceNumber($item['price'], $type),
		'priceCurrency' => 'RUB',
		'availability' => $item['in_stock'] ? 'https://schema.org/InStock' : 'https://schema.org/BackOrder',
		'itemCondition' => 'https://schema.org/NewCondition'
	);
}
?>
<script type="application/ld+json"><?php echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG); ?></script>
