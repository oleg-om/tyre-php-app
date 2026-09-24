<?php

/**
 * ЧПУ товаров, не зависящие от Product.id.
 *
 * Товары при загрузке прайсов удаляются и создаются заново, поэтому id меняется.
 * Ссылка строится из бренда, модели и параметров товара:
 *   /tyres/kumho/crugen-hp71/235-60-r16-100v
 *   /disks/wheels-up/up112-bfp/7x18-5x112-et45-d57.1-bfp
 *   /akb/varta/blue-dynamic/60ah-540a-r-242x175x175
 */
class ProductUrl
{
    public static $controllers = array(
        1 => 'tyres',
        2 => 'disks',
        3 => 'akb'
    );

    private static $translit = array(
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya', 'і' => 'i', 'ї' => 'yi', 'є' => 'e', 'ґ' => 'g'
    );

    /**
     * Транслитерация и приведение строки к виду [a-z0-9.-]
     */
    public static function slug($string)
    {
        $string = mb_strtolower(trim((string)$string), 'UTF-8');
        $string = strtr($string, self::$translit);
        $string = str_replace(',', '.', $string);
        // точка остаётся только внутри чисел: 5x114.3, 10.00
        $string = preg_replace('/(?<![0-9])\.|\.(?![0-9])/', '-', $string);
        $string = preg_replace('/[^a-z0-9.]+/', '-', $string);
        return trim($string, '-.');
    }

    /**
     * Часть ссылки с моделью. Если в названии нет букв и цифр (например, модель «.»), слаг пустой — подставляем «model»
     */
    public static function modelSlug($model_title)
    {
        $slug = self::slug($model_title);
        return $slug === '' ? 'model' : $slug;
    }

    /**
     * Часть ссылки с параметрами товара (размеры и т.п.)
     */
    public static function paramsSlug($product, $category_id = null)
    {
        if (isset($product['Product'])) {
            $product = $product['Product'];
        }
        $product += array_fill_keys(array('category_id', 'size1', 'size2', 'size3', 'f1', 'f2', 'f3', 'stud', 'axis', 'et', 'hub', 'color', 'ah', 'current', 'width', 'length', 'height'), null);
        if ($category_id === null) {
            $category_id = $product['category_id'];
        }
        $parts = array();
        if ($category_id == 1) {
            $parts[] = $product['size1'];
            $parts[] = $product['size2'];
            $parts[] = self::filled($product['size3']) ? 'r' . $product['size3'] : '';
            $parts[] = $product['f1'] . $product['f2'];
            $parts[] = !empty($product['stud']) ? 'ship' : '';
            $parts[] = $product['axis'];
        } elseif ($category_id == 2) {
            $parts[] = $product['size3'] . 'x' . $product['size1'];
            $parts[] = $product['size2'];
            $parts[] = self::filled($product['et']) ? 'et' . self::number($product['et']) : '';
            $parts[] = self::filled($product['hub']) ? 'd' . self::number($product['hub']) : '';
            $parts[] = $product['color'];
        } elseif ($category_id == 3) {
            $parts[] = self::filled($product['ah']) ? $product['ah'] . 'ah' : '';
            $parts[] = self::filled($product['current']) ? $product['current'] . 'a' : '';
            $parts[] = $product['f1'];
            $parts[] = $product['f2'];
            $dimensions = array_filter(array($product['length'], $product['width'], $product['height']), array('ProductUrl', 'filled'));
            $parts[] = implode('x', $dimensions);
            $parts[] = $product['f3'];
        }
        $parts = array_map(array('ProductUrl', 'slug'), $parts);
        $slug = implode('-', array_filter($parts, 'strlen'));
        return $slug === '' ? 'item' : $slug;
    }

    /**
     * Массив для Router::url / HtmlHelper::link
     * ProductUrl::url('tyres', $item['Product'], $item['Brand']['slug'], $item['BrandModel']['title'])
     */
    public static function url($controller, $product, $brand_slug, $model_title, $query = null)
    {
        $url = array(
            'controller' => $controller,
            'action' => 'view',
            'slug' => $brand_slug,
            'model' => self::modelSlug($model_title),
            'params' => self::paramsSlug($product, array_search($controller, self::$controllers))
        );
        if (!empty($query)) {
            $url['?'] = $query;
        }
        return $url;
    }

    public static function filled($value)
    {
        return $value !== null && $value !== '' && $value !== false;
    }

    /**
     * 45.0 -> 45, 57.10 -> 57.1
     */
    private static function number($value)
    {
        $value = str_replace(',', '.', (string)$value);
        if (is_numeric($value)) {
            $value = rtrim(rtrim(number_format((float)$value, 2, '.', ''), '0'), '.');
        }
        return $value;
    }
}
