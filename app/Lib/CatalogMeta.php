<?php

/**
 * Title и description страниц каталога шин, дисков и АКБ по фильтрам, бренду и странице пагинации,
 * чтобы у страниц с разными фильтрами не было одинаковых заголовков и описаний.
 */
class CatalogMeta
{
    private static $nouns = array('tyres' => 'шины', 'disks' => 'диски', 'akb' => 'аккумуляторы');

    private static $auto = array(
        'cars' => 'легковые', 'light_trucks' => 'легкогрузовые', 'trucks' => 'грузовые', 'agricultural' => 'сельскохозяйственные',
        'special' => 'индустриальные', 'loader' => 'для погрузчиков', 'moto' => 'мото'
    );

    private static $seasons = array('summer' => 'летние', 'winter' => 'зимние', 'all' => 'всесезонные');

    private static $materials = array('cast' => 'литые', 'steel' => 'штампованные', 'forged' => 'кованые');

    private static $footer = array(
        'tyres' => 'Шиномонтаж и сезонное хранение шин.',
        'disks' => 'Подбор дисков по автомобилю и шиномонтаж.',
        'akb' => 'Цена ниже при сдаче старого аккумулятора.'
    );

    /**
     * @param string $type 'tyres' | 'disks' | 'akb'
     * @param array $query фильтры, уже очищенные от служебных и пустых параметров (как в canonical)
     * @param array $names 'brands' => названия брендов, 'model' => название модели (для АКБ)
     * @param int|null $count сколько найдено, $count_of — 'models' | 'products'
     * @param int $page номер страницы
     * @return array('title' => ..., 'description' => ...)
     */
    public static function build($type, $query, $names, $count, $count_of, $page)
    {
        $q = $query + array_fill_keys(array('auto', 'season', 'material', 'stud', 'run_flat', 'axis'), '');
        $before = array();
        if (isset(self::$seasons[$q['season']])) {
            $before[] = self::$seasons[$q['season']];
        }
        if ($type == 'disks' && isset(self::$materials[$q['material']])) {
            $before[] = self::$materials[$q['material']];
        }
        $auto = isset(self::$auto[$q['auto']]) ? self::$auto[$q['auto']] : '';
        if ($auto !== '' && strpos($auto, 'для ') !== 0) {
            $before[] = $auto;
        }
        $phrase = implode(' ', array_merge($before, array(self::$nouns[$type])));
        if ($auto !== '' && strpos($auto, 'для ') === 0) {
            $phrase .= ' ' . $auto;
        }
        $phrase = self::ucfirst($phrase);

        $what = array();
        if (!empty($names['brands'])) {
            $what[] = implode(', ', $names['brands']);
        }
        if (!empty($names['model'])) {
            $what[] = $names['model'];
        }
        $what = array_merge($what, self::params($type, $query));
        if ($type == 'tyres') {
            if (!empty($q['stud'])) {
                $what[] = 'шипованные';
            }
            if (!empty($q['run_flat'])) {
                $what[] = 'RunFlat';
            }
            if ($q['axis'] !== '') {
                $what[] = 'ось: ' . $q['axis'];
            }
        }
        $subject = trim($phrase . ' ' . implode(' ', $what));

        $page_suffix = $page > 1 ? ' — страница ' . $page : '';
        if ($subject === self::ucfirst(self::$nouns[$type])) {
            // раздел без фильтров
            $title = 'Купить ' . self::$nouns[$type] . ' в Керчи — интернет-магазин КерчьШина' . $page_suffix;
        } else {
            $title = $subject . ' — купить в Керчи' . $page_suffix;
        }

        $description = $subject . ' в интернет-магазине КерчьШина';
        if ($count) {
            $description .= ': ' . $count . ' ' . ($count_of == 'models' ? self::plural($count, 'модель', 'модели', 'моделей') : self::plural($count, 'товар', 'товара', 'товаров')) . ' в наличии и под заказ';
        }
        $description .= '. ' . self::$footer[$type] . ($page > 1 ? ' Страница ' . $page . '.' : '');

        return array('title' => $title, 'description' => $description);
    }

    /**
     * Описание страницы модели шин или дисков: какие размеры есть в наличии
     */
    public static function modelDescription($type, $brand_title, $model_title, $products)
    {
        $sizes = array();
        foreach ($products as $item) {
            if ($type == 'tyres') {
                $size = $item['size1'] . '/' . $item['size2'] . ' R' . $item['size3'];
            } else {
                $size = 'R' . $item['size1'] . ' ' . $item['size3'] . 'J ' . $item['size2'];
            }
            $sizes[$size] = true;
        }
        $subject = self::ucfirst(self::$nouns[$type]) . ' ' . $brand_title . ' ' . $model_title;
        if (empty($sizes)) {
            return $subject . ' в интернет-магазине КерчьШина. ' . self::$footer[$type];
        }
        $sizes = array_keys($sizes);
        $count = count($sizes);
        $list = implode(', ', array_slice($sizes, 0, 4)) . ($count > 4 ? ' и ещё ' . ($count - 4) : '');
        return $subject . ' — купить в Керчи: ' . $count . ' ' . self::plural($count, 'размер', 'размера', 'размеров') . ' (' . $list . '). ' . self::$footer[$type];
    }

    /**
     * Размеры и характеристики из фильтров: 205/55 R16; R17 7J 5x114.3 ET45 DIA 60.1; 60–75 Ач 540 А
     */
    private static function params($type, $q)
    {
        $get = function ($key) use ($q) {
            return isset($q[$key]) ? $q[$key] : '';
        };
        $range = function ($from, $to, $unit) {
            if ($from !== '' && $to !== '') {
                return $from == $to ? $from . ' ' . $unit : $from . '–' . $to . ' ' . $unit;
            }
            if ($from !== '') {
                return 'от ' . $from . ' ' . $unit;
            }
            return $to !== '' ? 'до ' . $to . ' ' . $unit : '';
        };
        $params = array();
        if ($type == 'tyres') {
            $size = $get('size1') . ($get('size2') !== '' ? '/' . $get('size2') : '');
            $size .= $get('size3') !== '' ? ($size !== '' ? ' ' : '') . 'R' . $get('size3') : '';
            $params[] = $size;
        } elseif ($type == 'disks') {
            $params[] = $get('size1') !== '' ? 'R' . $get('size1') : '';
            $params[] = $get('size3') !== '' ? $get('size3') . 'J' : '';
            $params[] = $get('size2');
            $params[] = $range($get('et_from'), $get('et_to'), 'ET');
            $params[] = $get('hub') !== '' ? 'DIA ' . $get('hub') : $range($get('hub_from'), $get('hub_to'), 'DIA');
            $params[] = $range($get('width_from'), $get('width_to'), 'J');
        } elseif ($type == 'akb') {
            $params[] = $get('ah') !== '' ? $get('ah') . ' Ач' : $range($get('ah_from'), $get('ah_to'), 'Ач');
            $params[] = $get('current') !== '' ? $get('current') . ' А' : $range($get('current_from'), $get('current_to'), 'А');
            $params[] = $get('f1') !== '' ? 'тип ' . self::ucfirst($get('f1')) : '';
            $f2 = $get('f2');
            $params[] = $f2 == 'left' ? 'прямая полярность' : ($f2 == 'right' ? 'обратная полярность' : '');
            foreach (array('length' => 'длина', 'width' => 'ширина', 'height' => 'высота') as $key => $label) {
                $value = $get($key) !== '' ? $get($key) . ' мм' : $range($get($key . '_from'), $get($key . '_to'), 'мм');
                $params[] = $value !== '' ? $label . ' ' . $value : '';
            }
            foreach (array('agm' => 'AGM', 'efb' => 'EFB', 'start_stop' => 'Start-Stop') as $key => $label) {
                $params[] = $get($key) !== '' ? $label : '';
            }
        }
        return array_values(array_filter($params, 'strlen'));
    }

    public static function plural($n, $one, $few, $many)
    {
        $n = abs($n) % 100;
        if ($n > 10 && $n < 20) {
            return $many;
        }
        $n %= 10;
        return $n == 1 ? $one : ($n >= 2 && $n <= 4 ? $few : $many);
    }

    public static function ucfirst($string)
    {
        return mb_strtoupper(mb_substr($string, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($string, 1, null, 'UTF-8');
    }
}
