<?php

$img = '';

if (empty($valve)) {
    $valve = '';
} else {
    $valve = explode(';', $valve)[0];

    if ($valve == 'ЛК-35-11,7') {
        $img = 'lk-35-11,7.png';
    }
    if ($valve == 'ЛК-35-16,5') {
        $img = 'lk-35-16,5.png';
    }
    if ($valve == 'ГК-50') {
        $img = 'gk-50.png';
    }
    if ($valve == 'ГК-95') {
        $img = 'gk-95.png';
    }
    if ($valve == 'ГК-105') {
        $img = 'gk-105.png';
    }
    if ($valve == 'ГК-115') {
        $img = 'gk-115.png';
    }
    if ($valve == 'ГК-135') {
        $img = 'gk-135.png';
    }
    if ($valve == 'ГК-145') {
        $img = 'gk-145.png';
    }
    if ($valve == 'ЕР-161') {
        $img = 'ep-161.png';
    }
    if ($valve == 'ЕР-161') {
        $img = 'ep-161.png';
    }
    if ($valve == 'ТК') {
        $img = 'tk.png';
    }
    if ($valve == 'TR-218A') {
        $img = 'tr-218.png';
    }
    if ($valve == 'V8-90') {
        $img = 'v8-90.png';
    }
}

if (!empty($img)) { ?>
    <span class="tube__valve">
        <img src="/img/valve/<?php echo $img?>" alt="<?php echo $valve; ?>" title="<?php echo $valve; ?>" >
    </span>
<?php }
?>