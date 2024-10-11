<?php
if (!empty($item)) {
    $free_tyremount = array();
    $free_storage = array();
    $extra_warranty = array();

    foreach ($item['Product'] as $i => $product) {
        if ($product['p1']) {
            $free_tyremount[$i] = $i;
        }
        if ($product['p2']) {
            $free_storage[$i] = $i;
        }
        if ($product['p3']) {
            $extra_warranty[$i] = $i;
        }
    }

    $products_count = count($item['Product']);

    $new_product = array('p1' => 0, 'p2' => 0, 'p3' => 0, 'brand_id' => $item['Product'][0]['brand_id']);

    if ($products_count == count($free_tyremount)) {
        $new_product['p1'] = 1;
    }
    if ($products_count == count($free_storage)) {
        $new_product['p2'] = 1;
    }
    if ($products_count == count($extra_warranty)) {
        $new_product['p3'] = 1;
    }

    echo $this->element('tyre_icons', array('product' => $new_product, 'brandModel' => $item['BrandModel']));

}
?>