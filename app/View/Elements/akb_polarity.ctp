<?php
if (!isset($polarity)) {
    $polarity = 'R+';
}
?>

<span class="akb-polarity">
    <?php
        if ($polarity == 'R+') { ?>
            <img class="akb-polarity-icon akb-polarity-icon-blue" src="/img/icons/minus.png" alt="Минус" />
            <img class="akb-polarity-icon" src="/img/icons/plus.png" alt="Плюс" />
        <?php } else { ?>
            <img class="akb-polarity-icon" src="/img/icons/plus.png" alt="Плюс" />
            <img class="akb-polarity-icon akb-polarity-icon-blue" src="/img/icons/minus.png" alt="Минус" />
        <?php }
    ?>
</span>

