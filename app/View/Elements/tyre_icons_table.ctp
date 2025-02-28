<?php $icon_brand_id = 1002; ?>

<?php if ($product['sale']) { ?>
    <tr>
        <th>Акция</th>
        <td>+</td>
    </tr>
<?php } if ($brandModel['new']) { ?>
    <tr>
            <th>Новинка</th>
            <td>+</td>
    </tr>
<?php } if ($brandModel['popular']) { ?>
    <tr>
            <th>Хит продаж</th>
            <td>+</td>
        </tr>
<?php } if ($product['p1']) { ?>
    <tr>
            <th>Шиномонтаж бесплатно</th>
            <td>+</td>
        </tr>
<?php } if ($product['p2']) { ?>
    <tr>
            <th>Бесплатное хранение</th>
            <td>+</td>
        </tr>
<?php } if ($product['p3']) { ?>
    <?php if ($product['brand_id'] != $icon_brand_id) { ?>
        <tr>
                <th>Расширенная гарантия</th>
                <td>+</td>
            </tr>
    <?php } ?>
    <?php if ($product['brand_id'] == $icon_brand_id && intval($product['p3']) === 1) { ?>
        <tr>
                    <th>Расширенная гарантия Ikon tyres</th>
                    <td>+</td>
                </tr>
    <?php } ?>
    <?php if ($product['brand_id'] == $icon_brand_id && intval($product['p3']) === 2) { ?>
        <tr>
                    <th>Бессрочная гарантия Ikon tyres</th>
                    <td>+</td>
                    </tr>
    <?php } ?>
<?php } ?>
