<?php
$axis_name = '';

if (isset($axis) && !empty($axis)) {
    if ($axis === 'ведущая') {
        $axis_name = 'ved';
    }
    elseif ($axis === 'карьерная') {

    }
    elseif ($axis === 'прицеп') {
        $axis_name = 'pricep';
    }
    elseif ($axis === 'рулевая' || $axis === 'руль') {
        $axis_name = 'rul';
    }
    elseif ($axis === 'руль/прицеп') {
        $axis_name = 'rulpricep';
    }
    elseif ($axis === 'универсальная') {
        $axis_name = 'univ';
    }
}


if (isset($axis_name) && $axis_name != '') { ?>
    <span class="tyre__axis">
        <span class="tyre__axis-container">
        <img src="/img/truck/axes/<?php echo $axis_name?>.png" alt="<?php echo $axis; ?>" title="<?php echo $axis; ?>" >
            </span>
    </span>
<?php } ?>