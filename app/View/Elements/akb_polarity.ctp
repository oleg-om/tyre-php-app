<?php
if (!isset($polarity)) {
    $polarity = 'R+';
}
?>

<span class="akb-polarity">
    <?php
        if ($polarity == 'R+') { ?>
            <span class="akb-polarity-blue">
                -
            </span>
            <span class="akb-polarity-red">
                +
            </span>
        <?php } else { ?>
            <span class="akb-polarity-red">
                +
            </span>
            <span class="akb-polarity-blue">
                -
            </span>
        <?php }
    ?>
</span>

