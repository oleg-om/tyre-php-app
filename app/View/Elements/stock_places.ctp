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
$place_list = array();
if (!empty($stock_places['count_place_0'])) {
    $place_list[0] = $stock_places['count_place_0'];
}
if (!empty($stock_places['count_place_1'])) {
    $place_list[1] = $stock_places['count_place_1'];
}
if (!empty($stock_places['count_place_2'])) {
    $place_list[2] = $stock_places['count_place_2'];
}
if (!empty($stock_places['count_place_3'])) {
    $place_list[3] = $stock_places['count_place_3'];
}
if (!empty($stock_places['count_place_4'])) {
    $place_list[4] = $stock_places['count_place_4'];
}
if (!empty($stock_places['count_place_5'])) {
    $place_list[5] = $stock_places['count_place_5'];
}
if (!empty($stock_places['count_place_6'])) {
    $place_list[6] = $stock_places['count_place_6'];
}
if (!empty($stock_places['count_place_7'])) {
    $place_list[7] = $stock_places['count_place_7'];
}
if (!empty($stock_places['count_place_8'])) {
    $place_list[8] = $stock_places['count_place_8'];
}
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