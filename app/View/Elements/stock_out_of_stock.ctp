<?php
    $count_name = 'count_out_of_stock';
    $supplier_name = 'out_of_stock_supplier_id';

    if (!empty($original_stock)) {
        $count_name = 'stock_count';
        $supplier_name = 'supplier_id';
    }
?>

<?php if (!empty($item[$count_name])) { ?>
    <?php
        $text = $item[$count_name].' шт.';
        $supplier = $suppliers[$item[$supplier_name]];

        $last_digit = $supplier['delivery_time_from'] % 10;
        if (!empty($supplier['delivery_time_to'])) {
            $last_digit = $supplier['delivery_time_to'] % 10;
        }
        $days = ' дней';
        if ($last_digit == 1) {
            $days = ' день';
        }
        if ($last_digit == 2 || $last_digit == 3 || $last_digit == 4) {
            $days = ' дня';
        }

        $time = $supplier['delivery_time_from'].$days;

        if (!empty($supplier['delivery_time_to'])) {
            $time = $supplier['delivery_time_from'].' - '.$supplier['delivery_time_to'].$days;
        }
    ?>

<div class="tooltip-places tooltip-places-center tooltip-out-of-stock">
    <?php echo $prefix.$text; ?>
    <?php if ($hide_icon != true) { ?><img class="tooltip-out-of-stock-icon" title="Шины под заказ" alt="Шины под заказ" src="/img/delivery.png" width="22" height="16"><?php } ?>
        <div class="tooltiptext">
            <span class="tooltip-places-title">Время доставки: <?php echo $time; ?></span>
        </div>
</div>
<?php } ?>