<?php
if (empty($stock_places)) {
    $stock_places = array();
}
if (empty($text)) {
    $text = '';
}
if (empty($position)) {
    $position = 'center';
}
$place_list = array(0 => $stock_places['count_place_0'], 1 => $stock_places['count_place_1'], 2 => $stock_places['count_place_2'], 3 => $stock_places['count_place_3'], 4 => $stock_places['count_place_4'], 5 => $stock_places['count_place_5'], 6 => $stock_places['count_place_6'], 7 => $stock_places['count_place_7'], 8 => $stock_places['count_place_8']);
$place_list_filtered = array_filter($place_list);
?>

<div class="tooltip-places
<?php if ($position == 'left') { echo 'tooltip-places-left '; } ?>
<?php if ($position == 'right') { echo 'tooltip-places-right '; } ?>
<?php if ($position == 'center') { echo 'tooltip-places-center '; } ?>
<?php if (empty($place_list_filtered)) { echo 'tooltip-places-empty '; } ?>
">
    <?php echo $text; ?>
    <?php if (!empty($place_list_filtered)) { ?>
    <div class="tooltiptext">
        <span class="tooltip-places-title">Наличие по шинным центрам:</span>
        <table>
        <tbody>
        <?php
        foreach ($place_list as $i => $place_quantity) { ?>
            <?php
            if ($place_quantity != 0) {
                echo '<tr>';
                echo '<td>· '.$filter_all_places_short[$i].'</td>';
                echo '<td class="tooltip-places-row-quantity">'.$place_quantity . ' шт.</td>';
                echo '</tr>';
            }
            ?>
        <?php } ?>
        </tbody>
        </table>
    </div>
    <?php } ?>
</div>