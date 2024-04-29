<?php
    // https://flagicons.lipis.dev/
    $flag = '';
    if (isset($country)) {
        $country = mb_strtolower(trim($country));

        if ($country == 'беларусь') {
            $flag = '/img/flags/by.svg';
        }
        if ($country == 'германия') {
            $flag = '/img/flags/de.svg';
        }
        if ($country == 'индия') {
            $flag = '/img/flags/in.svg';
        }
        if ($country == 'кнр') {
            $flag = '/img/flags/cn.svg';
        }
        if ($country == 'китай') {
            $flag = '/img/flags/cn.svg';
        }
        if ($country == 'казахстан') {
            $flag = '/img/flags/kz.svg';
        }
        if ($country == 'корея') {
            $flag = '/img/flags/kr.svg';
        }
        if ($country == 'южная корея') {
            $flag = '/img/flags/kr.svg';
        }
        if ($country == 'россия') {
            $flag = '/img/flags/ru.svg';
        }
        if ($country == 'словения') {
            $flag = '/img/flags/si.svg';
        }
        if ($country == 'турция') {
            $flag = '/img/flags/tr.svg';
        }
        if ($country == 'япония') {
            $flag = '/img/flags/jp.svg';
        }
    }

    if (!empty($flag)) { ?>
        <div class="flag__icon">
            <img src="<?php echo $flag; ?>" alt="<?php echo 'Керчь - товары из '.$country; ?>"/>
        </div>
    <?php }
?>



