<?php
$p = $product['Product'];
$full_title = $brand['Brand']['title'] . ' ' . $product['BrandModel']['title'];
$sku = $full_title . ' ' . $p['ah'] . 'ач ' . $p['f1'];
$filename = null;
if (!empty($p['filename'])) {
    $filename = $p['filename'];
    $id = 'akb_images';
    $path = 'akb';
}
elseif (!empty($product['BrandModel']['filename'])) {
    $filename = $product['BrandModel']['filename'];
    $id = $product['BrandModel']['id'];
    $path = 'models';
}
$image_big = !empty($filename) ? $this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $path, 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false)) : null;
$show_price = $this->Frontend->canShowAkbPrice($p['not_show_price']);
$has_exchange = !empty($p['price_with_exchange']) && $p['price_with_exchange'] != 0;
$model_url = Router::url(array('controller' => 'akb', 'action' => 'brand', 'slug' => $brand['Brand']['slug'], '?' => array('model_id' => $p['model_id'])));

$title_parts = array();
if (!empty($p['ah'])) { $title_parts[] = $p['ah'] . ' Ач'; }
if (!empty($p['current'])) { $title_parts[] = $p['current'] . ' А'; }
if (!empty($p['f1'])) { $title_parts[] = $p['f1']; }
if (!empty($p['f2'])) { $title_parts[] = $p['f2']; }

$dimensions = array_filter(array($p['length'], $p['width'], $p['height']));
?>
<div class="tm tp">
    <div class="tm__hero">
        <div class="tm__media">
            <?php
            if (!empty($filename)) {
                echo $this->Html->link($this->Html->image($this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $path, 'width' => 400, 'height' => 1000, 'crop' => false, 'folder' => false)), array('alt' => $sku)), $image_big, array('escape' => false, 'class' => 'lightbox tm__image', 'title' => $sku));
            } else {
                echo '<span class="tm__image">' . $this->Html->image('no-akb-240.jpg', array('alt' => $sku)) . '</span>';
            }
            ?>
        </div>
        <div class="tm__info">
            <h1 class="tm__title">
                <a href="<?php echo h($model_url); ?>" class="tm__brand"><?php echo h($full_title); ?></a>
                <?php echo h(implode(' · ', $title_parts)); ?>
            </h1>

            <div class="tp__grid">
                <div class="tp-buy">
                    <?php if ($show_price) { ?>
                        <?php if ($has_exchange) { ?>
                            <div>
                                <div class="tp-buy__price"><?php echo $this->Frontend->getPrice($p['price_with_exchange'], 'akb'); ?></div>
                                <div class="tp-buy__note">
                                    <img src="/img/recycle-symbol.png" alt="" width="16" height="16" />
                                    при сдаче старого аккумулятора
                                </div>
                            </div>
                            <div class="tp-buy__alt">
                                Без обмена: <strong><?php echo $this->Frontend->getPrice($p['price'], 'akb'); ?></strong>
                            </div>
                        <?php } else { ?>
                            <div class="tp-buy__price"><?php echo $this->Frontend->getPrice($p['price'], 'akb'); ?></div>
                        <?php } ?>
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
                        <?php if (!empty($p['ah'])) { ?>
                        <tr>
                            <th>Ёмкость</th>
                            <td><?php echo h($p['ah']); ?> Ач</td>
                        </tr>
                        <?php } ?>
                        <?php if (!empty($p['current'])) { ?>
                        <tr>
                            <th>Пусковой ток</th>
                            <td><?php echo h($p['current']); ?> А <span class="tp-specs__muted">(<?php echo h(!empty($p['current_type']) ? $p['current_type'] : 'EN'); ?>)</span></td>
                        </tr>
                        <?php } ?>
                        <?php if (!empty($p['f2'])) { ?>
                        <tr>
                            <th>Полярность</th>
                            <td><?php echo h($p['f2']); ?></td>
                        </tr>
                        <?php } ?>
                        <?php if (!empty($p['f1'])) { ?>
                        <tr>
                            <th>Тип корпуса</th>
                            <td><?php echo h($p['f1']); ?></td>
                        </tr>
                        <?php } ?>
                        <?php if (!empty($dimensions)) { ?>
                        <tr>
                            <th>Размеры (Д × Ш × В)</th>
                            <td><?php echo h($p['length'] . ' × ' . $p['width'] . ' × ' . $p['height']); ?> мм<?php if (!empty($p['f3'])) { ?> <span class="tp-specs__muted"><?php echo h($p['f3']); ?></span><?php } ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th>Технология</th>
                            <td><?php echo $p['color'] ? h($p['color']) : '—'; ?><?php if ($p['truck']) { ?> <span class="tm-badge"><?php echo h($p['truck']); ?></span><?php } ?></td>
                        </tr>
                        <?php if (!empty($p['material'])) { ?>
                        <tr>
                            <th>Страна-производитель</th>
                            <td><?php echo h(mb_convert_case($p['material'], MB_CASE_TITLE, 'UTF-8')); ?></td>
                        </tr>
                        <?php } ?>
                        <?php if (!empty($p['axis'])) { ?>
                        <tr>
                            <th>Гарантия</th>
                            <td><?php echo h($p['axis']); ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th>Бренд</th>
                            <td><?php echo h($brand['Brand']['title']); ?></td>
                        </tr>
                    </table>
                    <a href="<?php echo h($model_url); ?>" class="tp-specs__more">Все аккумуляторы <?php echo h($full_title); ?> →</a>
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
    'type' => 'akb',
    'image' => $image_big,
    'show_price' => $show_price
)); ?>
<?php echo $this->element('product_meta', array(
    'type' => 'akb',
    'show_price' => $show_price
)); ?>
