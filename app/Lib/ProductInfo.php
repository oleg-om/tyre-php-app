<?php

/**
 * Название и характеристики товара для микроразметки Schema.org и YML-фида.
 * $product — массив с Product и BrandModel, $brand_title — название бренда.
 */
class ProductInfo
{
    public static $categories = array('tyres' => 'Шины', 'disks' => 'Диски', 'akb' => 'Аккумуляторы');

    private static $seasons = array('summer' => 'Летние', 'winter' => 'Зимние', 'all' => 'Всесезонные');

    public static function name($type, $product, $brand_title)
    {
        $item = $product['Product'];
        $name = trim($item['sku']);
        if ($name !== '') {
            return $name;
        }
        // модель без букв и цифр (например «.») в название не берём
        $parts = array($brand_title, ProductUrl::slug($product['BrandModel']['title']) !== '' ? $product['BrandModel']['title'] : '');
        if ($type == 'akb') {
            $parts[] = ProductUrl::filled($item['ah']) ? $item['ah'] . ' Ач' : '';
            $parts[] = ProductUrl::filled($item['current']) ? $item['current'] . ' А' : '';
            $parts[] = $item['f1'];
            $parts[] = $item['f2'];
        }
        return implode(' ', array_filter(array_map('trim', $parts), 'strlen'));
    }

    /**
     * Характеристики: название => значение, пустые не возвращаются
     */
    public static function properties($type, $product)
    {
        $item = $product['Product'];
        $properties = array();
        if ($type == 'tyres') {
            $season = !empty($product['BrandModel']['season']) ? $product['BrandModel']['season'] : $item['season'];
            $properties = array(
                'Ширина профиля' => $item['size1'],
                'Высота профиля' => $item['size2'],
                'Диаметр' => ProductUrl::filled($item['size3']) ? 'R' . $item['size3'] : '',
                'Индекс нагрузки' => $item['f1'],
                'Индекс скорости' => $item['f2'],
                'Сезон' => isset(self::$seasons[$season]) ? self::$seasons[$season] : '',
                'Шипы' => !empty($item['stud']) ? 'Да' : '',
                'Ось' => $item['axis']
            );
        } elseif ($type == 'disks') {
            $properties = array(
                'Диаметр' => $item['size1'],
                'Ширина' => $item['size3'],
                'Сверловка (PCD)' => $item['size2'],
                'Вылет (ET)' => $item['et'],
                'Ступица (DIA)' => $item['hub'],
                'Цвет' => $item['color']
            );
        } elseif ($type == 'akb') {
            $dimensions = array_filter(array($item['length'], $item['width'], $item['height']), array('ProductUrl', 'filled'));
            $properties = array(
                'Ёмкость, Ач' => $item['ah'],
                'Пусковой ток, А' => $item['current'],
                'Тип' => $item['f1'],
                'Полярность' => $item['f2'],
                'Габариты, мм' => implode('x', $dimensions)
            );
        }
        return array_filter(array_map('strval', $properties), array('ProductUrl', 'filled'));
    }

    /**
     * Описание модели обычным текстом
     */
    public static function description($product, $length = 500)
    {
        $model = $product['BrandModel'];
        $description = !empty($model['meta_description']) ? $model['meta_description'] : $model['content'];
        $description = trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags((string)$description), ENT_QUOTES, 'UTF-8')));
        return mb_substr($description, 0, $length, 'UTF-8');
    }
}
