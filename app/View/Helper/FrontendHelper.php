<?php

class FrontendHelper extends AppHelper
{
    public $helpers = array('Html', 'Time');
    public $monthes = array(
        1 => 'января',
        2 => 'февраля',
        3 => 'марта',
        4 => 'апреля',
        5 => 'мая',
        6 => 'июня',
        7 => 'июля',
        8 => 'августа',
        9 => 'сентября',
        10 => 'октября',
        11 => 'ноября',
        12 => 'декабря'
    );

    public function ending($num, $w1, $w2, $w3)
    {
        if (substr_count($num, '.') > 0) {
            list($part1, $part2) = explode('.', $num);
            if ($part2 != 0) {
                return $w3;
            }
        }
        $code = $num - floor($num / 10) * 10;
        $nums = ' ' . $num;
        $nums = substr($nums, strlen($nums) - 2, 2);
        $num = intval($nums);
        if (($num < 11) || ($num > 20)) {
            switch ($code) {
                case 0:
                case 5:
                case 6:
                case 7:
                case 8:
                case 9:
                    return $w1;
                    break;
                case 1:
                    return $w2;
                    break;
                case 2:
                case 3:
                case 4:
                    return $w3;
                    break;
            }
        } else {
            return $w1;
        }
    }

    public function thumbnail($params)
    {
        $filename = '';
        $path = '';
        $id = '';
        $width = 125;
        $height = 125;
        $quality = 85;
        $crop = false;
        $folder = false;
        extract($params);
        app::import('Vendor', 'phpthumb', array('file' => 'phpthumb' . DS . 'phpthumb.class.php'));
        $thumbnail = new phpthumb;
        if ($folder) {
            $folder = (floor($id / 5000) + 1);
            $thumbnail->src = IMAGES . $path . DS . $folder . DS . $id . DS . $filename;
        } else {
            $thumbnail->src = IMAGES . $path . DS . $id . DS . $filename;
        }
        $thumbnail->w = $width;
        $thumbnail->h = $height;
        $thumbnail->q = $quality;
        if ($crop) {
            $thumbnail->zc = true;
        }
        $thumbnail->config_imagemagick_path = IMAGEMAGICK . 'convert';
        $thumbnail->config_prefer_imagemagick = PREFER_IMAGEMAGICK;
        $thumbnail->config_output_format = substr($filename, -3);
        $thumbnail->config_error_die_on_error = false;
        $thumbnail->config_document_root = '';
        $thumbnail->config_temp_directory = TMP;
        if ($folder) {
            $thumbnail->config_cache_directory = IMAGES . $path . DS . $folder . DS . $id . DS;
        } else {
            $thumbnail->config_cache_directory = IMAGES . $path . DS . $id . DS;
        }
        $thumbnail->config_cache_disable_warning = true;
        $cacheFilename = $width . 'x' . $height . '_' . $filename;
        $thumbnail->cache_filename = $thumbnail->config_cache_directory . $cacheFilename;
        if (!is_file($thumbnail->cache_filename)) {
            if ($thumbnail->GenerateThumbnail()) {
                $thumbnail->RenderToFile($thumbnail->cache_filename);
                chmod($thumbnail->cache_filename, 0777);
            }
        }
        if (is_file($thumbnail->cache_filename)) {
            if ($folder) {
                return '/img/' . $path . '/' . $folder . '/' . $id . '/' . $cacheFilename;
            } else {
                return '/img/' . $path . '/' . $id . '/' . $cacheFilename;
            }
        }
        return '/img/spacer.gif';
    }

    public function getPriceRange($price_from, $price_to, $type = 'tyres', $options = array())
    {
        $currencies = $this->_View->getVar('currencies');
        $options = array_merge(
            array(
                'delimiter' => '<br />',
                'range_delimiter' => ' &ndash; ',
                'after' => '',
                'before' => '',
                'between' => '&nbsp;'
            ),
            $options
        );
        $replaces = array(
            array(
                '{after}', '{before}', '{between}', '{value}'
            ),
            array(
                $options['after'], $options['before'], $options['between']
            )
        );
        $price_from = $this->calculatePrice($price_from, $type);
        $price_to = $this->calculatePrice($price_to, $type);
        $price_ranges = array();
        foreach ($currencies as $item) {
            $value_from = $this->roundPrice($item['Currency'], $price_from);
            $value_from_replaces = $replaces;
            $value_from_replaces[1][] = $value_from;

            $value_to = $this->roundPrice($item['Currency'], $price_to);
            $value_to_replaces = $replaces;
            $value_to_replaces[1][] = $value_to;

            $price_ranges[] = str_replace($value_from_replaces[0], $value_from_replaces[1], $item['Currency']['short_title']) . $options['range_delimiter'] . str_replace($value_to_replaces[0], $value_to_replaces[1], $item['Currency']['short_title']);
        }
        return implode($options['delimiter'], $price_ranges);
    }

    public function roundPrice($currency, $price, $calculate_rate = true)
    {
        if ($calculate_rate) {
            $rate_price = $currency['rate'] * $price;
        } else {
            $rate_price = $price;
        }
        if ($currency['round'] == 0) {
            $currency['round'] = 1;
        }
        if ($currency['round_down']) {
            $rate_price = floor($rate_price / $currency['round']) * $currency['round'];
        } else {
            $rate_price = ceil($rate_price / $currency['round']) * $currency['round'];
        }
        return number_format($rate_price, $currency['decimals'], ',', ' ');
    }

    public function getPrice($price, $type = 'tyres', $options = array())
    {
        $currencies = $this->_View->getVar('currencies');
        $options = array_merge(
            array(
                'delimiter' => ' / ',
                'after' => '',
                'before' => '',
                'between' => '&nbsp;'
            ),
            $options
        );
        $replaces = array(
            array(
                '{after}', '{before}', '{between}', '{value}'
            ),
            array(
                $options['after'], $options['before'], $options['between']
            )
        );
        $price = $this->calculatePrice($price, $type);
        $prices = array();
        foreach ($currencies as $item) {
            $value = $this->roundPrice($item['Currency'], $price);
            $value_replaces = $replaces;
            $value_replaces[1][] = $value;

            $prices[] = str_replace($value_replaces[0], $value_replaces[1], $item['Currency']['short_title']);
        }
        return implode($options['delimiter'], $prices);
    }

    public function getCartPrice($price, $type = 'tyres', $options = array())
    {
        $currencies = $this->_View->getVar('currencies');
        $options = array_merge(
            array(
                'delimiter' => ' / ',
                'after' => '',
                'before' => '',
                'between' => '&nbsp;'
            ),
            $options
        );
        $replaces = array(
            array(
                '{after}', '{before}', '{between}', '{value}'
            ),
            array(
                $options['after'], $options['before'], $options['between']
            )
        );
        $price = $this->calculatePrice($price, $type);
        $prices = array();
        foreach ($currencies as $item) {
            if ($item['Currency']['cart']) {
                $value = $this->roundPrice($item['Currency'], $price);
                $value_replaces = $replaces;
                $value_replaces[1][] = $value;

                $prices[] = str_replace($value_replaces[0], $value_replaces[1], $item['Currency']['short_title']);
            }
        }
        return implode($options['delimiter'], $prices);
    }

    public function getCartPriceOnly($price, $type = 'tyres', $options = array())
    {
        $currencies = $this->_View->getVar('currencies');
        $options = array_merge(
            array(
                'delimiter' => ' / ',
                'after' => '',
                'before' => '',
                'between' => '&nbsp;'
            ),
            $options
        );
        $replaces = array(
            array(
                '{after}', '{before}', '{between}', '{value}'
            ),
            array(
                $options['after'], $options['before'], $options['between']
            )
        );
        $prices = array();
        foreach ($currencies as $item) {
            if ($item['Currency']['cart']) {
                $value = $this->roundPrice($item['Currency'], $price, false);
                $value_replaces = $replaces;
                $value_replaces[1][] = $value;

                $prices[] = str_replace($value_replaces[0], $value_replaces[1], $item['Currency']['short_title']);
            }
        }
        return implode($options['delimiter'], $prices);
    }

    public function getStoragePrice($price, $options = array())
    {
        $currencies = $this->_View->getVar('currencies');
        $options = array_merge(
            array(
                'after' => '',
                'before' => '',
                'between' => '&nbsp;'
            ),
            $options
        );
        $replaces = array(
            array(
                '{after}', '{before}', '{between}', '{value}'
            ),
            array(
                $options['after'], $options['before'], $options['between']
            )
        );
        $price_str = '';
        foreach ($currencies as $item) {
            if ($item['Currency']['storage']) {
                $value = ceil($price);
                $value_replaces = $replaces;
                $value_replaces[1][] = $value;
                $price_str = str_replace($value_replaces[0], $value_replaces[1], $item['Currency']['short_title']);
            }
        }
        return $price_str;
    }

    public function getPriceOnly($price, $with_currency = true)
    {
        $price = ceil($price);
        /*
        $price = str_replace('.00', '', $price);
        if (substr_count($price, '.') > 0) {
            $price = rtrim($price, '0');
        }
        */
        if ($with_currency) {
            $price .= ' грн.';
        }
        return $price;
    }

    public function getDateWithMonth($date)
    {
        $timestamp = strtotime($date);
        list($day, $month, $year) = explode('-', date('j-n-Y', $timestamp));
        return $day . ' ' . $this->monthes[$month];
    }

    public function calculatePrice($price, $type = 'tyres')
    {
        $koef = floatval(CONST_TYRES_KOEF);
        if ($type == 'disks') {
            $koef = floatval(CONST_DISKS_KOEF);
        } elseif ($type == 'tubes') {
            $koef = floatval(CONST_TUBES_KOEF);
        } elseif ($type == 'akb') {
            $koef = floatval(CONST_AKB_KOEF);
        } elseif ($type == 'bolts') {
            $koef = floatval(CONST_BOLTS_KOEF);
        } elseif ($type == 'bolts') {
            $koef = floatval(CONST_BOLTS_KOEF);
        } elseif ($type == 'used_tyres') {
            $koef = floatval(CONST_USED_TYRES_KOEF);
        }
        return $price * $koef;
    }

    public function calculateCartPrice($price, $type = 'tyres')
    {
        $currencies = $this->_View->getVar('currencies');
        $price = $this->calculatePrice($price, $type);
        $prices = array();
        foreach ($currencies as $item) {
            if ($item['Currency']['cart']) {
                $price = $this->roundPrice($item['Currency'], $price);
                break;
            }
        }
        return $price;
    }

    public function getStockCount($count, $max = 12)
    {
        if ($count > $max) $count = $max;
        return $count;
    }

    public function getTyreParams($tyre, $modification_slug, $query_size1, $query_size2, $query_size3)
    {
        list($size12, $size3) = explode(' ', $tyre);
        list($size1, $size2) = explode('/', $size12);
        $size3 = str_replace('R', '', $size3);
        $filter = array('size1' => $size1, 'size2' => $size2, 'size3' => $size3, 'diameter' => 'R' . $size3, 'in_stock' => 2);
        if (!empty($this->request->query['season'])) {
            $filter['season'] = $this->request->query['season'];
        }
        if (isset($modification_slug)) {
            $filter['modification'] = $modification_slug;
        }
        if ($query_size1 == $filter['size1'] && $query_size2 == $filter['size2'] && $query_size3 == $filter['size3']) {
            $filter['is_active'] = 1;
        } else {
            $filter['is_active'] = 0;
        }
        if (strpos($tyre, ':') !== false) {
            $filter['double'] = 1;
        }
        return $filter;
    }

    public function getDiskParams($disk, $material)
    {
        $item = $disk['CarWheels'];

        $front_filter = array('size1' => $item['front_axle_diameter'], 'size2' => $item['front_axle_pn'] . 'x' . $item['front_axle_pcd'], 'et_from' => $item['front_axle_et_min'], 'et_to' => $item['front_axle_et_max'], 'hub_from' => strval($item['front_axle_co_min']), 'hub_to' => strval($item['front_axle_co_max']), 'in_stock4' => 0, 'in_stock' => 2, 'width_from' => $item['front_axle_width_min'], 'width_to' => $item['front_axle_width_max'], 'modification' => $item['modification_slug'], 'diameter' => $item['front_axle_diameter'], 'material' => $material);
        $back_filter = array('size1' => $item['back_axle_diameter'], 'size2' => $item['back_axle_pn'] . 'x' . $item['back_axle_pcd'], 'et_from' => $item['back_axle_et_min'], 'et_to' => $item['back_axle_et_max'], 'hub_from' => strval($item['back_axle_co_min']), 'hub_to' => strval($item['back_axle_co_max']), 'in_stock4' => 0, 'in_stock' => 2, 'width_from' => $item['back_axle_width_min'], 'width_to' => $item['back_axle_width_max'], 'modification' => $item['modification_slug'], 'diameter' => $item['back_axle_diameter'], 'material' => $material);

        if ($this->request->query['size1'] === $item['front_axle_diameter'] &&
            $this->request->query['size2'] === $item['front_axle_pn'] . 'x' . $item['front_axle_pcd'] &&
            $this->request->query['et_from'] === $item['front_axle_et_min'] &&
            $this->request->query['et_to'] === $item['front_axle_et_max'] &&
            $this->request->query['hub_from'] === $item['front_axle_co_min'] &&
            $this->request->query['hub_to'] === $item['front_axle_co_max'] &&
            $this->request->query['width_from'] === $item['front_axle_width_min'] &&
            $this->request->query['width_to'] === $item['front_axle_width_max']
        ) {
            $front_filter['is_active'] = 1;
        } else {
            $front_filter['is_active'] = 0;
        }

        if ($this->request->query['size1'] === $item['back_axle_diameter'] &&
            $this->request->query['size2'] === $item['back_axle_pn'] . 'x' . $item['back_axle_pcd'] &&
            $this->request->query['et_from'] === $item['back_axle_et_min'] &&
            $this->request->query['et_to'] === $item['back_axle_et_max'] &&
            $this->request->query['hub_from'] === $item['back_axle_co_min'] &&
            $this->request->query['hub_to'] === $item['back_axle_co_max'] &&
            $this->request->query['width_from'] === $item['back_axle_width_min'] &&
            $this->request->query['width_to'] === $item['back_axle_width_max']
        ) {
            $back_filter['is_active'] = 1;
        } else {
            $back_filter['is_active'] = 0;
        }

        return array('front' => $front_filter, 'back' => $back_filter);
    }

    public function getAkbParams($akb)
    {
        $item = $akb['CarBatteries'];

        $filter = array('ah_from' => $item['capacity_min'], 'ah_to' => $item['capacity_max'], 'length_from' => $item['length_min'], 'length_to' => $item['length_max'], 'width_from' => $item['width_min'], 'width_to' => $item['width_max'], 'height_from' => $item['height_min'], 'height_to' => $item['height_max'], 'modification' => $item['modification_slug']);

        if ($item['type_case_id'] == 1) {
            $filter['f1'] = 'euro';
        }
        if ($item['type_case_id'] == 6) {
            $filter['f1'] = 'asia';
        }
        if ($item['type_case_id'] == 13) {
            $filter['short'] = 1;
        }

        if ($item['polarity_id'] == 2) {
            $filter['f2'] = 'right';
        }
        if ($item['polarity_id'] == 9) {
            $filter['f2'] = 'left';
        }

        if ($this->request->query['ah_from'] === $item['capacity_min'] &&
            $this->request->query['ah_to'] === $item['capacity_max'] &&
            $this->request->query['length_from'] === $item['length_min'] &&
            $this->request->query['length_to'] === $item['length_max'] &&
            $this->request->query['width_from'] === $item['width_min'] &&
            $this->request->query['width_to'] === $item['width_max'] &&
            $this->request->query['height_from'] === $item['height_min'] &&
            $this->request->query['height_to'] === $item['height_max']
        ) {
            $filter['is_active'] = 1;
        } else {
            $filter['is_active'] = 0;
        }

        return $filter;
    }

    public function getSize3($size3)
    {
        return trim(str_replace(array('J', 'j'), '', $size3));
    }

    public function getFF($f1, $f2)
    {

        $f2_variants = array(
            'A1' => '5',
            'A2' => '10',
            'A3' => '15',
            'A4' => '20',
            'A5' => '25',
            'A6' => '30',
            'A7' => '35',
            'A8' => '40',
            'В' => '50',
            'С' => '60',
            'D' => '65',
            'E' => '70',
            'F' => '80',
            'G' => '90',
            'J' => '100',
            'K' => '110',
            'L' => '120',
            'M' => '130',
            'N' => '140',
            'P' => '150',
            'Q' => '160',
            'R' => '170',
            'S' => '180',
            'T' => '190',

            'U' => '200',

            'H' => '210',
            'V' => '240',
            'W' => '270',
            'Y' => '300',

            //'VR' => '>210',
            'VR' => '210-240',
            'Z' => '>240'
            //'ZR' => '>240',
            //'ZR(Y)' => '>300'
        );


        $f1_variants = array(
            '1' => '46,2',
            '2' => '47,5',
            '3' => '48,7',
            '4' => '50',
            '5' => '51,5',
            '6' => '53',
            '7' => '54,5',
            '8' => '56',
            '9' => '58',
            '10' => '60',
            '11' => '61,5',
            '12' => '63',
            '13' => '65',
            '14' => '67',
            '15' => '69',
            '16' => '71',
            '17' => '73',
            '18' => '75',
            '19' => '77,5',
            '20' => '80',
            '21' => '82,5',
            '22' => '86',
            '23' => '87,5',
            '24' => '90',
            '25' => '92,5',
            '26' => '95',
            '27' => '97,5',
            '28' => '100',
            '29' => '103',
            '30' => '106',
            '31' => '109',
            '32' => '112',
            '33' => '115',
            '34' => '118',
            '35' => '121',
            '36' => '125',
            '37' => '128',
            '38' => '132',
            '39' => '136',
            '41' => '145',
            '42' => '150',
            '43' => '155',
            '44' => '160',
            '45' => '165',
            '46' => '170',
            '47' => '175',
            '48' => '180',
            '49' => '185',
            '50' => '190',
            '51' => '195',
            '52' => '200',
            '53' => '206',
            '54' => '212',
            '55' => '218',
            '56' => '224',
            '57' => '230',
            '58' => '236',
            '59' => '243',
            '60' => '250',
            '61' => '257',
            '62' => '265',
            '63' => '272',
            '64' => '280',
            '65' => '290',
            '66' => '300',
            '67' => '307',
            '68' => '315',
            '69' => '325',
            '70' => '335',
            '71' => '345',
            '72' => '355',
            '73' => '365',
            '74' => '375',
            '75' => '387',
            '76' => '400',
            '77' => '412',
            '78' => '426',
            '79' => '437',
            '81' => '462',
            '82' => '475',
            '83' => '487',
            '84' => '500',
            '85' => '515',
            '86' => '530',
            '87' => '545',
            '88' => '560',
            '89' => '580',
            '90' => '600',
            '91' => '615',
            '92' => '630',
            '93' => '650',
            '94' => '670',
            '95' => '690',
            '96' => '710',
            '97' => '730',
            '98' => '750',
            '99' => '775',
            '100' => '800',
            '101' => '825',
            '102' => '850',
            '103' => '875',
            '104' => '900',
            '105' => '925',
            '106' => '950',
            '107' => '975',
            '108' => '1000',
            '109' => '1030',
            '110' => '1060',
            '111' => '1090',
            '112' => '1120',
            '113' => '1150',
            '114' => '1180',
            '115' => '1215',
            '116' => '1250',
            '117' => '1285',
            '118' => '1320',
            '119' => '1360',
            '121' => '1450',
            '122' => '1500',
            '123' => '1550',
            '124' => '1600',
            '125' => '1650',
            '126' => '1700',
            '127' => '1750',
            '128' => '1800',
            '129' => '1850',
            '130' => '1900',
            '131' => '1950',
            '132' => '2000',
            '133' => '2060',
            '134' => '2120',
            '135' => '2180',
            '136' => '2240',
            '137' => '2300',
            '138' => '2360',
            '139' => '2430',
            '140' => '2500',
            '141' => '2575',
            '142' => '2650',
            '143' => '2725',
            '144' => '2800',
            '145' => '2900',
            '146' => '3000',
            '147' => '3075',
            '148' => '3150',
            '149' => '3250',
            '150' => '3350',
            '151' => '3450',
            '152' => '3550',
            '153' => '3650',
            '154' => '3750',
            '155' => '3875',
            '156' => '4000',
            '157' => '4125',
            '158' => '4250',
            '159' => '4375',
            '161' => '4625',
            '162' => '4750',
            '163' => '4875',
            '164' => '5000',
            '165' => '5150',
            '166' => '5300',
            '167' => '5450',
            '168' => '5600',
            '169' => '5800',
            '170' => '6000',
            '171' => '6150',
            '172' => '6300',
            '173' => '6500',
            '174' => '6700',
            '175' => '6900',
            '176' => '7100',
            '177' => '7300',
            '178' => '7500',
            '179' => '7750',
            '180' => '8000',
            '181' => '8250',
            '182' => '8500',
            '183' => '8750',
            '184' => '9000',
            '185' => '9250',
            '186' => '9500',
            '187' => '9750',
            '188' => '10000',
            '189' => '10300',
            '190' => '10600',
            '191' => '10900',
            '192' => '11200',
            '193' => '11500',
            '194' => '11800',
            '195' => '12150',
            '196' => '12500',
            '197' => '12850',
            '198' => '13200',
            '199' => '13600',
            '201' => '14500',
            '202' => '15000',
            '203' => '15500',
            '204' => '16000',
            '205' => '16500',
            '206' => '17000',
            '207' => '17500',
            '208' => '18000',
            '209' => '18500',
            '210' => '19000',
            '211' => '19500',
            '212' => '20000',
            '213' => '20600',
            '214' => '21200',
            '215' => '21800',
            '216' => '22400',
            '217' => '23000',
            '218' => '23600',
            '219' => '24300',
            '220' => '25000',
            '221' => '25750',
            '222' => '26500',
            '223' => '27250',
            '224' => '28000',
            '225' => '29000',
            '226' => '30000',
            '227' => '30750',
            '228' => '31500',
            '229' => '32500',
            '230' => '33500',
            '231' => '34500',
            '232' => '35500',
            '233' => '36500',
            '234' => '37500',
            '235' => '38750',
            '236' => '40000',
            '237' => '41250',
            '238' => '42500',
            '239' => '43750',
            '241' => '46250',
            '242' => '47500',
            '243' => '48750',
            '244' => '50000',
            '245' => '51500',
            '246' => '53000',
            '247' => '54500',
            '248' => '56000',
            '249' => '58000',
            '250' => '60000',
            '251' => '61500',
            '252' => '63000',
            '253' => '65000',
            '254' => '67000',
            '255' => '69000',
            '256' => '71000',
            '257' => '73000',
            '258' => '75000',
            '259' => '77500',
            '260' => '80000',
            '261' => '82500',
            '262' => '85000',
            '263' => '87500',
            '264' => '90000',
            '265' => '92500',
            '266' => '97500',
            '267' => '97500',
            '268' => '100000',
            '269' => '103000',
            '270' => '106000',
            '271' => '109000',
            '272' => '112000',
            '273' => '115000',
            '274' => '118000',
            '275' => '121000',
            '276' => '125000',
            '277' => '128500',
            '278' => '132000',
            '279' => '136000'
        );
        $info = array();
        //print_r($f1);
        //print_r($f2);

        if (isset($f1_variants[$f1])) {
            $info[] = $f1_variants[$f1] . ' кг';
        } elseif (substr_count($f1, '/') == 1) {
            list($f1_1, $f1_2) = explode('/', $f1);
            if (isset($f1_variants[$f1_1]) && isset($f1_variants[$f1_2])) {
                $info[] = $f1_variants[$f1_1] . '/' . $f1_variants[$f1_2] . ' кг';
            } elseif (isset($f1_variants[$f1_1])) {
                $info[] = $f1_variants[$f1_1] . ' кг';
            } elseif (isset($f1_variants[$f1_2])) {
                $info[] = $f1_variants[$f1_2] . ' кг';
            }
        }
        if (isset($f2_variants[$f2])) {
            $info[] = $f2_variants[$f2] . ' км/ч';
        }
        if (!empty($info)) {
            return ' ' . implode(', ', $info) . '';
        }
        return '';
    }

    public function canShowTyrePrice($auto, $not_show_price)
    {
        if ($not_show_price) {
            return false;
        }
        if (CONST_SHOW_TYRES != '1') {
            return false;
        }
        $const = 'CONST_SHOW_TYRES_' . strtoupper($auto);
        if (defined($const) && constant($const) == '1') {
            return false;
        }
        return true;
    }

    public function canShowDiskPrice($not_show_price)
    {
        if ($not_show_price) {
            return false;
        }
        if (CONST_SHOW_DISKS != '1') {
            return false;
        }
        return true;
    }

    public function canShowAkbPrice($not_show_price)
    {
        if ($not_show_price) {
            return false;
        }
        if (CONST_SHOW_AKB != '1') {
            return false;
        }
        return true;
    }

    public function canShowTubePrice($not_show_price)
    {
        if ($not_show_price) {
            return false;
        }
        if (CONST_SHOW_TUBES != '1') {
            return false;
        }
        return true;
    }

    public function canShowBoltPrice($not_show_price)
    {
        if ($not_show_price) {
            return false;
        }
        if (CONST_SHOW_BOLTS != '1') {
            return false;
        }
        return true;
    }

    public function isNewYear()
    {
        $currentDate = new DateTime(); // Today

        $newYearDateBegin = new DateTime('2015-12-20');
        $newYearDateEnd = new DateTime('2016-01-30');

        $december_is_ok = $currentDate->format('m') == $newYearDateBegin->format('m') && $currentDate->format('d') >= $newYearDateBegin->format('d');
        $january_is_ok = $currentDate->format('m') == $newYearDateEnd->format('m') && $currentDate->format('d') <= $newYearDateEnd->format('d');

        if ($december_is_ok || $january_is_ok) {
            return true;
        }

        return false;
    }

    public function is8march()
    {
        $currentDate = new DateTime(); // Today

        $month_is_ok = $currentDate->format('m') == '03';
        $is_6 = $month_is_ok && $currentDate->format('d') == '06';
        $is_7 = $month_is_ok && $currentDate->format('d') == '07';
        $is_8 = $month_is_ok && $currentDate->format('d') == '08';
        $is_9 = $month_is_ok && $currentDate->format('d') == '09';

        if ($is_6) {
            return 6;
        }
        if ($is_7) {
            return 7;
        }
        if ($is_8) {
            return 8;
        }
        if ($is_9) {
            return 9;
        }

        return false;
    }

    public function is1April()
    {
        $currentDate = new DateTime(); // Today

        $dateBegin = new DateTime('2015-04-01');
        $dateEnd = new DateTime('2016-04-01');

        $first_is_ok = $currentDate->format('m') == $dateBegin->format('m') && $currentDate->format('d') >= $dateBegin->format('d');
        $second_is_ok = $currentDate->format('m') == $dateEnd->format('m') && $currentDate->format('d') <= $dateEnd->format('d');

        if ($first_is_ok && $second_is_ok) {
            return true;
        }

        return false;
    }

    public function mergedTyreProduct($item)
    {
        if (!empty($item)) {
            $free_tyremount = array();
            $free_storage = array();
            $extra_warranty = array();

            foreach ($item['Product'] as $i => $product) {
                if ($product['p1']) {
                    $free_tyremount[$i] = $i;
                }
                if ($product['p2']) {
                    $free_storage[$i] = $i;
                }
                if ($product['p3']) {
                    $extra_warranty[$i] = $i;
                }
            }

            $products_count = count($item['Product']);

            $new_product = array('p1' => 0, 'p2' => 0, 'p3' => 0, 'brand_id' => $item['Product'][0]['brand_id'], 'size3' => $item['Product'][0]['size3']);

            if ($products_count == count($free_tyremount)) {
                $new_product['p1'] = 1;
            }
            if ($products_count == count($free_storage)) {
                $new_product['p2'] = 1;
            }
            if ($products_count == count($extra_warranty)) {
                $new_product['p3'] = 1;
            }

            return $new_product;
        } else {
            return false;
        }
    }
}
