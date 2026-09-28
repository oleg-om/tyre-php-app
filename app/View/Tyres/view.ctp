<?php echo $this->element('currency', array('class' => 'bpad')); ?>
<?php
$p = $product['Product'];
$full_title = $brand['Brand']['title'] . ' ' . $product['BrandModel']['title'];
$size_title = $p['size1'] . '/' . $p['size2'] . ' R' . $p['size3'] . (!empty($p['f1']) || !empty($p['f2']) ? ' ' . $p['f1'] . $p['f2'] : '');

$image_small = $this->Html->image('no-tyre-big.jpg', array('alt' => $full_title));
$image_big = '/img/tyre.jpg';
if (!empty($product['BrandModel']['filename'])) {
    $image_small = $this->Html->image($this->Backend->thumbnail(array('id' => $product['BrandModel']['id'], 'filename' => $product['BrandModel']['filename'], 'path' => 'models', 'width' => 400, 'height' => 1000, 'crop' => false, 'folder' => false)), array('alt' => $full_title . ' ' . $size_title));
    $image_big = $this->Backend->thumbnail(array('id' => $product['BrandModel']['id'], 'filename' => $product['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false, 'watermark' => 'wm.png'), array('alt' => $product['BrandModel']['title']));
}

$season = $p['season'];
if (!empty($product['BrandModel']['season'])) {
    $season = $product['BrandModel']['season'];
}
$car_auto = $p['auto'];
if (!empty($product['BrandModel']['auto'])) {
    $car_auto = $product['BrandModel']['auto'];
}
$show_price = $this->Frontend->canShowTyrePrice($p['auto'], $p['not_show_price']);
$model_url = '/tyres/' . $brand['Brand']['slug'] . '?model_id=' . $product['BrandModel']['id'];

$season_icons = array(
    'summer' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4.5"/><path d="M12 1.5v3M12 19.5v3M1.5 12h3M19.5 12h3M4.6 4.6l2.1 2.1M17.3 17.3l2.1 2.1M4.6 19.4l2.1-2.1M17.3 6.7l2.1-2.1"/></svg>',
    'winter' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2v20M3.3 7l17.4 10M3.3 17l17.4-10M9 3.5l3 2.5 3-2.5M9 20.5l3-2.5 3 2.5M3.5 10.5l3.8-.6-1.3-3.6M20.5 13.5l-3.8.6 1.3 3.6M3.5 13.5l3.8.6-1.3 3.6M20.5 10.5l-3.8-.6 1.3-3.6"/></svg>',
    'all' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="8" cy="8" r="3.5"/><path d="M8 1.5v1.5M8 13v1.5M1.5 8H3M13 8h1.5M3.4 3.4l1 1M11.6 11.6l1 1M3.4 12.6l1-1M11.6 4.4l1-1M17 11v11M12.2 13.8l9.6 5.4M12.2 19.2l9.6-5.4"/></svg>'
);
?>
<div class="tm tp">
    <div class="tm__hero">
        <div class="tm__media">
            <?php echo $this->element('tyre_icons', array('product' => $p, 'brandModel' => $product['BrandModel'])); ?>
            <?php echo $this->Html->link($image_small, $image_big, array('escape' => false, 'class' => 'lightbox tm__image', 'title' => $full_title)); ?>
        </div>
        <div class="tm__info">
            <h1 class="tm__title">
                <a href="<?php echo h($model_url); ?>" class="tm__brand"><?php echo h($full_title); ?></a>
                <?php echo h($size_title); ?>
            </h1>

            <div class="tm__meta">
                <?php if (!empty($season) && isset($seasons[$season])) { ?>
                    <span class="tm-badge tm-badge--<?php echo h($season); ?>">
                        <?php if (isset($season_icons[$season])) { echo $season_icons[$season]; } ?>
                        <?php echo h($seasons[$season]); ?>
                    </span>
                <?php } ?>
                <?php if ($p['stud']) { ?>
                    <span class="tm-badge"><img width="16" height="16" src="/img/icons/studded.png" alt="" /> Шипованная</span>
                <?php } ?>
                <?php if ($p['p5'] == 1) { ?><span class="tm-badge">Run Flat</span><?php } ?>
                <?php if ($p['p4'] == 1) { ?><span class="tm-badge">XL</span><?php } ?>
            </div>

            <div class="tp__grid">
                <div class="tp-buy">
                    <?php if ($show_price) { ?>
                        <div class="tp-buy__price">
                            <?php echo $this->Frontend->getPrice($p['price'], 'tyres'); ?>
                            <span class="tp-buy__unit">за 1 шт.</span>
                        </div>
                    <?php } ?>
                    <div class="tp-buy__stock">
                        <?php
                        if ($p['in_stock'] == 1) {
                            echo $this->element('stock_places', array('stock_places' => $p, 'text' => '<div class="namber tyres tm-stock tm-stock--yes">В наличии: ' . $this->Frontend->getStockCount($p['stock_count']) . ' шт.</div>', 'position' => 'right'));
                        }
                        $stock_out_of_stock_params = array('item' => $p, 'prefix' => 'под заказ: ');
                        if ($p['in_stock'] != 1) {
                            $stock_out_of_stock_params['original_stock'] = true;
                        }
                        if ($p['stock_count'] < 4 || $p['in_stock'] == 0) {
                            echo $this->element('stock_out_of_stock', $stock_out_of_stock_params);
                        }
                        ?>
                    </div>
                    <?php if ($show_price) { ?>
                        <div class="tp-buy__actions">
                            <div class="add-to-cart"><?php echo $this->element('add_to_cart'); ?></div>
                            <a href="javascript:void(0);" class="tm-btn tm-btn--primary tp-buy__btn" onclick="buy();">Купить</a>
                        </div>
                    <?php } ?>
                    <?php echo $this->element('tyre_benefit', array('product' => $p)); ?>
                    <div class="tp-buy__phone">
                        <span>Или закажите по телефону</span>
                        <a href="tel:<?php echo preg_replace('/[^\d+]/', '', CONST_STORAGE_CELLPHONE); ?>"><?php echo CONST_STORAGE_CELLPHONE; ?></a>
                    </div>
                </div>

                <div class="tp-specs">
                    <h2 class="tm__sizes-title">Характеристики</h2>
                    <table>
                        <tr>
                            <th>Типоразмер</th>
                            <td><?php echo h($p['size1']); ?>/<?php echo h($p['size2']); ?> R<?php echo h($p['size3']); ?></td>
                        </tr>
                        <?php if (!empty($p['f1']) || !empty($p['f2'])) { ?>
                        <tr>
                            <th>Индекс нагрузки / скорости</th>
                            <td><?php echo h($p['f1'] . $p['f2']); ?> <span class="tp-specs__muted"><?php echo $this->Frontend->getFF($p['f1'], $p['f2']); ?></span></td>
                        </tr>
                        <?php } ?>
                        <?php if (!empty($p['axis'])) { ?>
                        <tr>
                            <th>Ось</th>
                            <td><?php echo h($p['axis']); ?></td>
                        </tr>
                        <?php } ?>
                        <?php if (isset($auto[$car_auto])) { ?>
                        <tr>
                            <th>Тип автомобиля</th>
                            <td><?php echo h($auto[$car_auto]); ?></td>
                        </tr>
                        <?php } ?>
                        <?php if (isset($seasons[$season])) { ?>
                        <tr>
                            <th>Сезонность</th>
                            <td><?php echo h($seasons[$season]); ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th>Шипы</th>
                            <td><?php echo $p['stud'] ? 'Да' : 'Нет'; ?></td>
                        </tr>
                        <tr>
                            <th>Run Flat</th>
                            <td><?php echo $p['p5'] == 1 ? 'Да' : 'Нет'; ?></td>
                        </tr>
                        <tr>
                            <th>XL (Extra Load)</th>
                            <td><?php echo $p['p4'] == 1 ? 'Да' : 'Нет'; ?></td>
                        </tr>
                        <?php echo $this->element('tyre_icons_table', array('product' => $p, 'brandModel' => $product['BrandModel'])); ?>
                    </table>
                    <a href="<?php echo h($model_url); ?>" class="tp-specs__more">Все размеры <?php echo h($full_title); ?> →</a>
                </div>
            </div>
        </div>
    </div>

    <?php $content = trim(strip_tags($product['BrandModel']['content'])); ?>
    <?php if (!empty($content) || !empty($product['BrandModel']['video'])) { ?>
    <section class="tm__section tm__desc">
        <?php if (!empty($content)) { ?>
            <h2 class="tm__section-title">Описание</h2>
            <div class="tm__desc-body"><?php echo $product['BrandModel']['content']; ?></div>
        <?php } ?>
        <?php if (!empty($product['BrandModel']['video'])) { ?><div class="video"><?php echo $product['BrandModel']['video']; ?></div><?php } ?>
    </section>
    <?php } ?>
</div>
<?php echo $this->element('schema_product', array(
    'type' => 'tyres',
    'image' => !empty($product['BrandModel']['filename']) ? $image_big : null,
    'show_price' => $show_price
)); ?>
<?php echo $this->element('product_meta', array(
    'type' => 'tyres',
    'show_price' => $show_price
)); ?>
