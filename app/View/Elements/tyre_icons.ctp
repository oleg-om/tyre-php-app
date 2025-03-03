<?php $icon_brand_id = 1002; ?>
<div class="tyre__icons">
<?php if ($product['sale']) { ?>
        <span class="tyre__icon">
            <img src="/img/icons/promo.png" alt="Акция" />
            <span class="tyre__icon-tooltip">Акция</span>
        </span>
<?php } if ($brandModel['new']) { ?>
        <span class="tyre__icon">
            <img src="/img/icons/new.png" alt="Новинка" />
            <span class="tyre__icon-tooltip">Новинка</span>
        </span>
<?php } if ($brandModel['popular']) { ?>
        <span class="tyre__icon">
            <img src="/img/icons/popular.png" alt="Хит продаж" />
            <span class="tyre__icon-tooltip">Хит продаж</span>
        </span>
<?php } if ($product['p1']) { ?>
        <?php if ($product['p1'] == 1) { ?>
            <span class="tyre__icon tyre__icon-tyremount">
                <img src="/img/icons/free-tyremount.png" alt="Шиномонтаж бесплатно" />
                <span class="tyre__icon-tooltip">Шиномонтаж бесплатно</span>
            </span>
        <?php
        } else { ?>
        <span class="tyre__icon tyre__icon-tyremount">
                <img src="/img/icons/tyremount_50.png" alt="Скидка на шиномонтаж 50%" />
                <span class="tyre__icon-tooltip">Скидка на шиномонтаж 50%</span>
            </span>
        <?php } ?>
<?php } if ($product['p2']) { ?>
        <span class="tyre__icon">
            <img src="/img/icons/storage.svg" alt="Бесплатное хранение" />
            <span class="tyre__icon-tooltip">Бесплатное хранение</span>
        </span>
<?php } if ($product['p3']) { ?>
        <?php if ($product['brand_id'] != $icon_brand_id) { ?>
            <span class="tyre__icon">
                <img src="/img/icons/warranty.svg" alt="Расширенная гарантия" />
                <span class="tyre__icon-tooltip">Расширенная гарантия</span>
            </span>
        <?php } ?>
        <?php if ($product['brand_id'] == $icon_brand_id && intval($product['p3']) === 1) { ?>
            <span class="tyre__icon">
                    <img src="/img/icons/icon_warranty.png" alt="Расширенная гарантия Ikon tyres" />
                    <span class="tyre__icon-tooltip">Расширенная гарантия Ikon tyres</span>
                </span>
        <?php } ?>
        <?php if ($product['brand_id'] == $icon_brand_id && intval($product['p3']) === 2) { ?>
            <span class="tyre__icon">
                        <img src="/img/icons/icon_life_warranty.png" alt="Бессрочная гарантия Ikon tyres" />
                        <span class="tyre__icon-tooltip">Бессрочная гарантия Ikon tyres</span>
                    </span>
        <?php } ?>
<?php } ?>
</div>
