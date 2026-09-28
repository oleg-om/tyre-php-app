<?php echo $this->element('currency', array('class' => 'bpad')); ?>
<?php
$is_truck = $active_menu == 'truck-tyres';
$full_title = $model['Brand']['title'] . ' ' . $model['BrandModel']['title'];

$image_small = $this->Html->image('no-tyre-big.jpg', array('alt' => $full_title));
$image_big = '/img/tyre.jpg';
if (!empty($model['BrandModel']['filename'])) {
    $image_small = $this->Html->image($this->Backend->thumbnail(array('id' => $model['BrandModel']['id'], 'filename' => $model['BrandModel']['filename'], 'path' => 'models', 'width' => 400, 'height' => 1000, 'crop' => false, 'folder' => false)), array('alt' => $full_title));
    $image_big = $this->Backend->thumbnail(array('id' => $model['BrandModel']['id'], 'filename' => $model['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false, 'watermark' => 'wm.png'), array('alt' => $full_title));
}

$season = null;
if (!empty($model['Product'][0])) {
    $season = $model['Product'][0]['season'];
}
if (!empty($model['BrandModel']['season'])) {
    $season = $model['BrandModel']['season'];
}

// сводка по модели: диаметры, минимальная цена, наличие
$diameters = array();
$min_price = null;
$in_stock_count = 0;
$has_stud = false;
foreach ($model['Product'] as $product) {
    $diameters[$product['size3']] = isset($diameters[$product['size3']]) ? $diameters[$product['size3']] + 1 : 1;
    if ($this->Frontend->canShowTyrePrice($product['auto'], $product['not_show_price']) && $product['price'] > 0) {
        $min_price = $min_price === null ? $product['price'] : min($min_price, $product['price']);
    }
    if ($product['in_stock'] == 1) {
        $in_stock_count++;
    }
    if ($product['stud']) {
        $has_stud = true;
    }
}
ksort($diameters, SORT_NUMERIC);
$sizes_count = count($model['Product']);

$season_icons = array(
    'summer' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4.5"/><path d="M12 1.5v3M12 19.5v3M1.5 12h3M19.5 12h3M4.6 4.6l2.1 2.1M17.3 17.3l2.1 2.1M4.6 19.4l2.1-2.1M17.3 6.7l2.1-2.1"/></svg>',
    'winter' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2v20M3.3 7l17.4 10M3.3 17l17.4-10M9 3.5l3 2.5 3-2.5M9 20.5l3-2.5 3 2.5M3.5 10.5l3.8-.6-1.3-3.6M20.5 13.5l-3.8.6 1.3 3.6M3.5 13.5l3.8.6-1.3 3.6M20.5 10.5l-3.8-.6 1.3-3.6"/></svg>',
    'all' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="8" cy="8" r="3.5"/><path d="M8 1.5v1.5M8 13v1.5M1.5 8H3M13 8h1.5M3.4 3.4l1 1M11.6 11.6l1 1M3.4 12.6l1-1M11.6 4.4l1-1M17 11v11M12.2 13.8l9.6 5.4M12.2 19.2l9.6-5.4"/></svg>'
);
?>
<div class="tm">
    <div class="tm__hero">
        <div class="tm__media">
            <?php echo $this->Html->link($image_small, $image_big, array('escape' => false, 'class' => 'lightbox tm__image', 'title' => $full_title)); ?>
        </div>
        <div class="tm__info">
            <div class="tm__brand"><?php echo h($model['Brand']['title']); ?></div>
            <h1 class="tm__title"><?php echo h($model['BrandModel']['title']); ?></h1>

            <div class="tm__meta">
                <?php if (!empty($season) && isset($seasons[$season])) { ?>
                    <span class="tm-badge tm-badge--<?php echo h($season); ?>">
                        <?php if (isset($season_icons[$season])) { echo $season_icons[$season]; } ?>
                        <?php echo h($seasons[$season]); ?>
                    </span>
                <?php } ?>
                <?php if ($has_stud) { ?>
                    <span class="tm-badge tm-badge--stud">
                        <img width="16" height="16" src="/img/icons/studded.png" alt="" />
                        Шипованная
                    </span>
                <?php } ?>
                <?php if ($min_price !== null) { ?>
                    <span class="tm__meta-price">от <?php echo $this->Frontend->getPrice($min_price, 'tyres'); ?></span>
                <?php } ?>
                <?php if ($sizes_count > 0) { ?>
                    <span class="tm__meta-item"><?php echo $in_stock_count > 0 ? '<span class="tm__stock-yes">Есть в наличии</span>' : '<span class="tm__stock-order">Под заказ</span>'; ?></span>
                <?php } ?>
            </div>

            <?php if ($sizes_count > 0) { ?>
            <section class="tm__sizes" id="tm-sizes">
                <div class="tm__sizes-head">
                    <h2 class="tm__sizes-title">Размеры и цены <?php echo h($full_title); ?></h2>
                    <?php if (count($diameters) > 1) { ?>
                    <div class="tm-chips" role="group" aria-label="Диаметр">
                        <button type="button" class="tm-chip active" data-diameter="">Все <span><?php echo $sizes_count; ?></span></button>
                        <?php foreach ($diameters as $d => $count) { ?>
                            <button type="button" class="tm-chip" data-diameter="<?php echo h($d); ?>">R<?php echo h($d); ?> <span><?php echo $count; ?></span></button>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>

                <table class="tm-table">
                    <thead>
                        <tr>
                            <th>Типоразмер</th>
                            <th>Индекс нагрузки / скорости</th>
                            <th class="tm-table__icons-col"></th>
                            <?php if ($is_truck) { ?><th>Ось</th><?php } ?>
                            <th>Наличие</th>
                            <th class="tm-table__price-col">Цена</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($model['Product'] as $product) { ?>
                        <?php $url = Router::url(ProductUrl::url('tyres', $product, $model['Brand']['slug'], $model['BrandModel']['title'])); ?>
                        <tr class="tm-row" data-diameter="<?php echo h($product['size3']); ?>">
                            <td class="tm-row__size">
                                <a href="<?php echo h($url); ?>"><?php echo h($product['size1']); ?>/<?php echo h($product['size2']); ?> R<?php echo h($product['size3']); ?></a>
                            </td>
                            <td class="tm-row__index">
                                <?php if (!empty($product['f1']) || !empty($product['f2'])) { ?>
                                    <strong><?php echo h($product['f1'] . $product['f2']); ?></strong>
                                    <span><?php echo $this->Frontend->getFF($product['f1'], $product['f2']); ?></span>
                                <?php } ?>
                            </td>
                            <td class="tm-row__icons">
                                <div class="desc-icons">
                                    <?php echo $product['stud'] ? '<img width="18" height="18" src="/img/icons/studded.png" alt="шипованная" title="шипованная" />' : ''; ?>
                                    <?php echo $this->element('tyre_icons', array('product' => $product)); ?>
                                </div>
                            </td>
                            <?php if ($is_truck) { ?>
                                <td class="tm-row__axis"><?php if (!empty($product['axis'])) { ?><span class="tm-row__label">Ось: </span><?php echo h($product['axis']); } ?></td>
                            <?php } ?>
                            <td class="tm-row__stock">
                                <?php
                                if ($product['in_stock'] == 1) {
                                    echo $this->element('stock_places', array('stock_places' => $product, 'text' => '<div class="namber tyres tm-stock tm-stock--yes">В наличии: ' . $this->Frontend->getStockCount($product['stock_count']) . ' шт.</div>', 'position' => 'right'));
                                }
                                $stock_out_of_stock_params = array('item' => $product, 'prefix' => 'под заказ: ');
                                if ($product['in_stock'] != 1) {
                                    $stock_out_of_stock_params['original_stock'] = true;
                                    $stock_out_of_stock_params['prefix'] = 'под заказ: ';
                                }
                                if ($product['stock_count'] < 4 || $product['in_stock'] == 0) {
                                    echo $this->element('stock_out_of_stock', $stock_out_of_stock_params);
                                }
                                ?>
                            </td>
                            <td class="tm-row__price">
                                <?php
                                if ($this->Frontend->canShowTyrePrice($product['auto'], $product['not_show_price'])) {
                                    echo $this->Frontend->getPrice($product['price'], 'tyres');
                                }
                                ?>
                            </td>
                            <td class="tm-row__action">
                                <a href="<?php echo h($url); ?>" class="tm-btn tm-btn--primary">Подробнее</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </section>
            <?php } ?>
        </div>
    </div>

    <?php $content = trim(strip_tags($model['BrandModel']['content'])); ?>
    <?php if (!empty($content) || !empty($model['BrandModel']['video'])) { ?>
    <section class="tm__section tm__desc">
        <?php if (!empty($content)) { ?>
            <h2 class="tm__section-title">Описание</h2>
            <div class="tm__desc-body"><?php echo $model['BrandModel']['content']; ?></div>
        <?php } ?>
        <?php if (!empty($model['BrandModel']['video'])) { ?><div class="video"><?php echo $model['BrandModel']['video']; ?></div><?php } ?>
    </section>
    <?php } ?>
</div>
<script>
$(function () {
    $('.tm-chip').on('click', function () {
        var d = String($(this).data('diameter'));
        $('.tm-chip').removeClass('active');
        $(this).addClass('active');
        $('.tm-row').each(function () {
            $(this).toggleClass('tm-row--hidden', d !== '' && String($(this).data('diameter')) !== d);
        });
    });
});
</script>
