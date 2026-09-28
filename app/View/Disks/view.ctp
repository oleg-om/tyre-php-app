<?php echo $this->element('currency', array('class' => 'bpad')); ?>
<?php
$p = $product['Product'];
// 25.0 -> 25, 58.10 -> 58.1
$num = function ($v) {
    $v = str_replace(',', '.', (string)$v);
    return is_numeric($v) ? rtrim(rtrim(number_format((float)$v, 2, '.', ''), '0'), '.') : $v;
};
$full_title = $brand['Brand']['title'] . ' ' . $product['BrandModel']['title'];
$size_title = $num($p['size3']) . '×' . $num($p['size1']) . '" ' . $p['size2'] . ' ET' . $num($p['et']) . (!empty($p['hub']) ? ' DIA ' . $num($p['hub']) : '');

$image_small = $this->Html->image('no-disk-big.jpg', array('alt' => $full_title));
$image_big = '/img/disk.jpg';
if (!empty($product['BrandModel']['filename'])) {
    $image_small = $this->Html->image($this->Backend->thumbnail(array('id' => $product['BrandModel']['id'], 'filename' => $product['BrandModel']['filename'], 'path' => 'models', 'width' => 400, 'height' => 1000, 'crop' => false, 'folder' => false)), array('alt' => $full_title . ' ' . $size_title));
    $image_big = $this->Backend->thumbnail(array('id' => $product['BrandModel']['id'], 'filename' => $product['BrandModel']['filename'], 'path' => 'models', 'width' => 800, 'height' => 601, 'crop' => false, 'folder' => false), array('alt' => $product['BrandModel']['title']));
}

$show_price = $this->Frontend->canShowDiskPrice($p['not_show_price']);
$model_url = Router::url(array('controller' => 'disks', 'action' => 'brand', 'slug' => $brand['Brand']['slug'], '?' => array('model_id' => $product['BrandModel']['id'])));
$material_title = !empty($product['BrandModel']['material']) && !empty($all_materials[$product['BrandModel']['material']]) ? $all_materials[$product['BrandModel']['material']] : null;
?>
<div class="tm tp">
    <div class="tm__hero">
        <div class="tm__media">
            <?php echo $this->Html->link($image_small, $image_big, array('escape' => false, 'class' => 'lightbox tm__image', 'title' => $full_title)); ?>
        </div>
        <div class="tm__info">
            <h1 class="tm__title">
                <a href="<?php echo h($model_url); ?>" class="tm__brand"><?php echo h($full_title); ?></a>
                <?php echo h($size_title); ?>
            </h1>

            <?php if ($material_title || !empty($p['color'])) { ?>
            <div class="tm__meta">
                <?php if ($material_title) { ?><span class="tm-badge"><?php echo h($material_title); ?></span><?php } ?>
                <?php if (!empty($p['color'])) { ?><span class="tm-badge"><?php echo h($p['color']); ?></span><?php } ?>
            </div>
            <?php } ?>

            <div class="tp__grid">
                <div class="tp-buy">
                    <?php if ($show_price) { ?>
                        <div class="tp-buy__price">
                            <?php echo $this->Frontend->getPrice($p['price'], 'disks'); ?>
                            <span class="tp-buy__unit">за 1 шт.</span>
                        </div>
                    <?php } ?>
                    <div class="tp-buy__stock">
                        <?php
                        $stock_text = $p['in_stock'] ? 'В наличии: ' : 'Под заказ: ';
                        $stock_class = $p['in_stock'] ? 'tm-stock tm-stock--yes' : '';
                        echo $this->element('stock_places', array('stock_places' => $p, 'text' => '<div class="namber tyres ' . $stock_class . '">' . $stock_text . $this->Frontend->getStockCount($p['stock_count']) . ' шт.</div>', 'position' => 'right'));
                        ?>
                    </div>
                    <?php if ($show_price) { ?>
                        <div class="tp-buy__actions">
                            <div class="add-to-cart"><?php echo $this->element('add_to_cart'); ?></div>
                            <a href="javascript:void(0);" class="tm-btn tm-btn--primary tp-buy__btn" onclick="buy();">Купить</a>
                        </div>
                    <?php } ?>
                    <div class="tp-buy__phone">
                        <span>Или закажите по телефону</span>
                        <a href="tel:<?php echo preg_replace('/[^\d+]/', '', CONST_STORAGE_CELLPHONE); ?>"><?php echo CONST_STORAGE_CELLPHONE; ?></a>
                    </div>
                </div>

                <div class="tp-specs">
                    <h2 class="tm__sizes-title">Характеристики</h2>
                    <table>
                        <tr>
                            <th>Диаметр</th>
                            <td><?php echo h($num($p['size1'])); ?>"</td>
                        </tr>
                        <tr>
                            <th>Ширина</th>
                            <td><?php echo h($num($p['size3'])); ?>"</td>
                        </tr>
                        <tr>
                            <th>Сверловка (PCD)</th>
                            <td><?php echo h($p['size2']); ?></td>
                        </tr>
                        <tr>
                            <th>Вылет (ET)</th>
                            <td><?php echo h($num($p['et'])); ?> мм</td>
                        </tr>
                        <?php if (!empty($p['hub'])) { ?>
                        <tr>
                            <th>Центральное отверстие (DIA)</th>
                            <td><?php echo h($num($p['hub'])); ?> мм</td>
                        </tr>
                        <?php } ?>
                        <?php if (!empty($p['color'])) { ?>
                        <tr>
                            <th>Цвет</th>
                            <td><?php echo h($p['color']); ?></td>
                        </tr>
                        <?php } ?>
                        <?php if ($material_title) { ?>
                        <tr>
                            <th>Тип</th>
                            <td><?php echo h($material_title); ?></td>
                        </tr>
                        <?php } ?>
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
    'type' => 'disks',
    'image' => !empty($product['BrandModel']['filename']) ? $image_big : null,
    'show_price' => $show_price
)); ?>
<?php echo $this->element('product_meta', array(
    'type' => 'disks',
    'show_price' => $show_price
)); ?>
