<?php
if (empty($stock_places)) {
    $stock_places = '';
}
if (empty($text)) {
    $text = '';
}
if (empty($position)) {
    $position = 'center';
}
$place_list = explode('|', $stock_places);
?>

<div class="tooltip-places
<?php if ($position == 'left') { echo 'tooltip-places-left'; } ?>
<?php if ($position == 'center') { echo 'tooltip-places-center'; } ?>
<?php if (empty($stock_places)) { echo 'tooltip-places-empty'; } ?>
">
    <?php echo $text; ?>
    <?php if (!empty($stock_places)) { ?>
    <div class="tooltiptext">
        <span class="tooltip-places-title">Наличие по шинным центрам:</span>
        <table>
        <tbody>
        <?php
        foreach ($place_list as $i => $place_quantity) { ?>
            <?php
            if ($place_quantity != 0) {
                echo '<tr>';
                if ($i == 0) {
                    echo '<td>· ул. Мирошника 5, Автодом</td>';
                }
                if ($i == 1) {
                    echo '<td>· ул. Шевякова (район авторынка), Vianor Tip-top</td>';
                }
                if ($i == 2) {
                    echo '<td>· ул. Шевякова (район авторынка), Vianor Tip-top</td>';
                }
                if ($i == 3) {
                    echo '<td>· ул. Куль-обинское шоссе 1, MICHELIN</td>';
                }
                if ($i == 4) {
                    echo '<td>· АТП';
                }
                if ($i == 5) {
                    echo '<td>· ул. Вокзальное шоссе 36, шиномонтаж Таксо</td>';
                }
                if ($i == 6) {
                    echo '<td>· ул. Вокзальное шоссе 44, VIANOR</td>';
                }
                if ($i == 7) {
                    echo '<td>· ул. Чкалова 147А, VIANOR</td>';
                }
                if ($i == 8) {
                    echo '<td>· Таврида</td>';
                }
                if ($i == 9) {
                    echo '<td>· Грузовой склад</td>';
                }
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