<?php if ($this->Frontend->canShowAkbPrice(false)) { ?>
    <?php if ($this->Frontend->canShowAkbPrice($item['Product']['not_show_price'])) { ?>
        <?php if (!empty($item['Product']['price_with_exchange']) && $item['Product']['price_with_exchange'] != 0)  { ?>
            <span class="product__info-price">
                                                    <span class="product__info-number product__info-number-red"><?php echo $this->Frontend->getPrice($item['Product']['price_with_exchange'], 'akb'); ?></span>
                                            <img alt="обмен" class="product__info-recycle" src="/img/recycle-symbol.png"/>
                                            <span class="product__info-title">
                                                        Цена с обменом
                                                    </span>
                                        </span>
        <?php } ?>
        <span class="product__info-price">
                                                    <span class="product__info-number"><?php echo $this->Frontend->getPrice($item['Product']['price'], 'akb'); ?></span>
                                                    <span class="product__info-title">
                                                        <?php if (!empty($item['Product']['price_with_exchange']) && $item['Product']['price_with_exchange'] != 0) { echo 'Цена без обмена'; } else { echo 'Цена'; } ?>
                                                    </span>
                                        </span>
    <?php } ?>
<?php } ?>