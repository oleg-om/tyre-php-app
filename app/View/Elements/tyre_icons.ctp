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
        <span class="tyre__icon tyre__icon-tyremount">
            <img src="/img/icons/free-tyremount.png" alt="Шиномонтаж бесплатно" />
            <span class="tyre__icon-tooltip">Шиномонтаж бесплатно</span>
        </span>
<?php } if ($product['p2']) { ?>
        <span class="tyre__icon">
            <img src="/img/icons/storage.svg" alt="Бесплатное хранение" />
            <span class="tyre__icon-tooltip">Бесплатное хранение</span>
        </span>
<?php } if ($product['p3']) { ?>
    <span class="tyre__icon">
            <img src="/img/icons/warranty.svg" alt="Расширенная гарантия" />
            <span class="tyre__icon-tooltip">Расширенная гарантия</span>
        </span>
<?php } ?>
</div>
