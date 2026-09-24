<?php
/**
 * Description страницы товара (и title для АКБ): у всех размеров модели было одно описание модели.
 * Параметры: $type ('tyres' | 'disks' | 'akb'), $product (Product + BrandModel), $brand, $show_price.
 */
$item = $product['Product'];
$name = ProductInfo::name($type, $product, $brand['Brand']['title']);
$parts = array($name . ' — купить в Керчи');
if ($show_price) {
	$parts[0] .= ' за ' . $this->Frontend->cartPriceNumber($item['price'], $type) . ' руб.';
}
$parts[] = $item['in_stock'] ? 'В наличии.' : 'Под заказ.';
// характеристики, которых нет в названии
$properties = array_diff_key(ProductInfo::properties($type, $product), array_flip(array('Ширина профиля', 'Высота профиля', 'Диаметр', 'Ёмкость, Ач', 'Пусковой ток, А', 'Тип', 'Полярность')));
$specs = array();
foreach ($properties as $property => $value) {
	$specs[] = $property . ': ' . $value;
}
if ($specs) {
	$parts[] = implode('; ', $specs) . '.';
}
$parts[] = 'Интернет-магазин КерчьШина.';
$this->set('meta_description', implode(' ', $parts));
if ($type == 'akb') {
	// в прежнем заголовке АКБ не было тока и полярности — у разных аккумуляторов он совпадал
	$this->set('meta_title', $name . ' — купить в Керчи');
}
