<?php
if (isset($product) && ($product['p1'] >= 1 || isset($product['p2']))) {
    $auto = 'cars';
    if (strpos(strtolower($product['sku']), ' suv') !== false) {
        $auto = 'suv';
    }

    $text_array = array();

    $tyre_value = 0;
    if (isset($product['p1']) && isset($tyre_price[$auto][$product['size3']])) {
        $tyre_value = $tyre_price[$auto][$product['size3']];

        if ($product['p1'] == 1) {
            $text_array[] = 'Шиномонтаж бесплатно' . ' (' . $tyre_value . ' р.)';
        }

        if ($product['p1'] == 2) {
            // 50%
            $tyre_value = intval($tyre_value / 2);
            $text_array[] = 'Шиномонтаж 50%' . ' (' . $tyre_value . ' р.)';
        }
    }
    // storage
    $storage_value = 0;
    if (isset($product['p2']) && $product['p2'] == 1 && isset($storage_price[$auto][$product['size3']])) {
        $auto = 'cars';
        $storage_value = floatval($storage_price[$auto][$product['size3']]);
        $text_array[] = 'Бесплатное хранение' . ' (' . $storage_value . ' р.)';
    }

    $value = intval($tyre_value) + intval($storage_value);
    $value = round($value / 5) * 5;
    $value = number_format($value, 0, '', ' ');

    $text = implode('<br/>', $text_array);
    if (count($text_array) == 1) {
        $text = preg_replace('/\([^)]*\)/', '', $text);
    }

    if ($value > 0) {
        ?>
        <div class="tyre__benefit">
            <svg class="tyre__benefit-gift" width="120" height="120" viewBox="0 0 120 120"
                 xmlns="http://www.w3.org/2000/svg">
                <!-- Коробка -->
                <rect x="20" y="40" width="80" height="60" fill="#ff6600" stroke="#C1443E" stroke-width="3" rx="5"/>
                <!-- Крышка -->
                <rect x="15" y="35" width="90" height="15" fill="#E94E3C" stroke="#C1443E" stroke-width="3" rx="4"/>
                <!-- Лента вертикальная -->
                <rect x="57" y="35" width="6" height="65" fill="#FFD700"/>
                <!-- Лента горизонтальная -->
                <rect x="15" y="65" width="90" height="6" fill="#FFD700"/>
                <!-- Бант -->
                <path d="M60 35 C70 10, 90 10, 85 35 S70 35, 60 35 Z" fill="#FFD700"/>
                <path d="M60 35 C50 10, 30 10, 35 35 S50 35, 60 35 Z" fill="#FFD700"/>
            </svg>
            <div class="tyre__benefit-wrapper">
                <span class="tyre__benefit-caption">При покупке 4 шин</span>
                <div class="tyre__benefit-text">
                    <span class="tyre__benefit-title">Ваша выгода:</span>
                    <span class="tyre__benefit-price"><?php echo $value . ' руб.'; ?></span>
                </div>
            </div>
            <span class="tyre__icon-tooltip"><?php echo $text; ?></span>
        </div>
        <?php
    }
}
?>