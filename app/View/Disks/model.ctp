<?php echo $this->element('currency', array('class' => 'bpad')); ?>
<?php
$full_title = $model['Brand']['title'] . ' ' . $model['BrandModel']['title'];
// 25.0 -> 25, 58.10 -> 58.1
$num = function ($v) {
    $v = str_replace(',', '.', (string)$v);
    return is_numeric($v) ? rtrim(rtrim(number_format((float)$v, 2, '.', ''), '0'), '.') : $v;
};

$image_small = $this->Html->image('no-disk-big.jpg', array('alt' => $full_title));
$image_big = '/img/disk.jpg';
if (!empty($model['BrandModel']['filename'])) {
    $image_small = $this->Html->image($this->Backend->thumbnail(array('id' => $model['BrandModel']['id'], 'filename' => $model['BrandModel']['filename'], 'path' => 'models', 'width' => 400, 'height' => 1000, 'crop' => false, 'folder' => false)), array('alt' => $full_title));
    $image_big = $this->Backend->thumbnail(array('id' => $model['BrandModel']['id'], 'filename' => $model['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 601, 'crop' => false, 'folder' => false, 'watermark' => 'wm.png'), array('alt' => $full_title));
}

// сводка по модели: диаметры, минимальная цена, наличие
$diameters = array();
$min_price = null;
$in_stock_count = 0;
foreach ($model['Product'] as $product) {
    $diameters[$product['size1']] = isset($diameters[$product['size1']]) ? $diameters[$product['size1']] + 1 : 1;
    if ($this->Frontend->canShowDiskPrice($product['not_show_price']) && $product['price'] > 0) {
        $min_price = $min_price === null ? $product['price'] : min($min_price, $product['price']);
    }
    if ($product['in_stock']) {
        $in_stock_count++;
    }
}
ksort($diameters, SORT_NUMERIC);
$sizes_count = count($model['Product']);
$material_title = null;
if (!empty($model['BrandModel']['material']) && !empty($all_materials[$model['BrandModel']['material']])) {
    $material_title = $all_materials[$model['BrandModel']['material']];
}
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
                <?php if ($material_title) { ?>
                    <span class="tm-badge"><?php echo h($material_title); ?></span>
                <?php } ?>
                <?php if ($min_price !== null) { ?>
                    <span class="tm__meta-price">от <?php echo $this->Frontend->getPrice($min_price, 'disks'); ?></span>
                <?php } ?>
                <?php if ($sizes_count > 0) { ?>
                    <span class="tm__meta-item"><?php echo $in_stock_count > 0 ? '<span class="tm__stock-yes">Есть в наличии</span>' : '<span class="tm__stock-order">Под заказ</span>'; ?></span>
                <?php } ?>
            </div>

            <?php if (!empty($model_autos) && count($model_autos) > 1) {
                $auto_titles = array('cars' => 'Легковые', 'trucks' => 'Грузовые', 'agricultural' => 'Сельскохозяйственные', 'loader' => 'Погрузчики', 'special' => 'Индустриальные');
                $car_icon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 17H3v-5l2-5h11l3 5h2v5h-2"/><path d="M9 17h6"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/><path d="M5 12h14"/></svg>';
                $truck_icon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h11v11H3z"/><path d="M14 10h4l3 3v4h-7"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>';
            ?>
            <div class="auto-switch tm__auto-switch">
                <?php foreach ($model_autos as $auto_value) {
                    $query = array_merge($this->request->query, array('auto' => $auto_value));
                    $title = isset($auto_titles[$auto_value]) ? $auto_titles[$auto_value] : $auto_value;
                    $icon = $auto_value === 'cars' ? $car_icon : $truck_icon;
                    echo $this->Html->link($icon . '<span>' . h($title) . '</span>', '?' . http_build_query($query), array('escape' => false, 'class' => 'auto-switch__item' . ($auto_value === $model_auto ? ' active' : '')));
                } ?>
            </div>
            <?php } ?>

            <?php if ($sizes_count > 0) { ?>
            <section class="tm__sizes" id="tm-sizes">
                <div class="tm__sizes-head">
                    <h2 class="tm__sizes-title">Размеры и цены <?php echo h($full_title); ?></h2>
                    <?php if (count($diameters) > 1) { ?>
                    <div class="tm-chips" role="group" aria-label="Диаметр">
                        <button type="button" class="tm-chip active" data-diameter="">Все <span><?php echo $sizes_count; ?></span></button>
                        <?php foreach ($diameters as $d => $count) { ?>
                            <button type="button" class="tm-chip" data-diameter="<?php echo h($d); ?>">R<?php echo h($num($d)); ?> <span><?php echo $count; ?></span></button>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>

                <table class="tm-table tm-table--disks">
                    <thead>
                        <tr>
                            <th>Размер</th>
                            <th>Сверловка</th>
                            <th>Вылет</th>
                            <th>Ступица</th>
                            <th>Цвет</th>
                            <th>Наличие</th>
                            <th class="tm-table__price-col">Цена</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($model['Product'] as $product) { ?>
                        <?php $url = Router::url(ProductUrl::url('disks', $product, $model['Brand']['slug'], $model['BrandModel']['title'])); ?>
                        <tr class="tm-row" data-diameter="<?php echo h($product['size1']); ?>">
                            <td class="tm-row__size">
                                <a href="<?php echo h($url); ?>"><?php echo h($num($product['size3'])); ?>×<?php echo h($num($product['size1'])); ?>"</a>
                            </td>
                            <td class="tm-row__param tm-row__pcd" data-label="Сверловка"><?php echo h($product['size2']); ?></td>
                            <td class="tm-row__param tm-row__et" data-label="Вылет">ET<?php echo h($num($product['et'])); ?></td>
                            <td class="tm-row__param tm-row__hub" data-label="Ступица"><?php echo h($num($product['hub'])); ?></td>
                            <td class="tm-row__param tm-row__color" data-label="Цвет"><?php echo h($product['color']); ?></td>
                            <td class="tm-row__stock">
                                <?php
                                $stock_text = $product['in_stock'] ? 'В наличии: ' : 'Под заказ: ';
                                $stock_class = $product['in_stock'] ? 'tm-stock tm-stock--yes' : '';
                                echo $this->element('stock_places', array('stock_places' => $product['stock_places'], 'text' => '<div class="namber tyres ' . $stock_class . '">' . $stock_text . $this->Frontend->getStockCount($product['stock_count']) . ' шт.</div>', 'position' => 'right'));
                                ?>
                            </td>
                            <td class="tm-row__price">
                                <?php
                                if ($this->Frontend->canShowDiskPrice($product['not_show_price'])) {
                                    echo $this->Frontend->getPrice($product['price'], 'disks');
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
