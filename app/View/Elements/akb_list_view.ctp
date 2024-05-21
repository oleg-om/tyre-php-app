<div class="list-view__grid" id="product-section">
    <?php $i = 0; foreach ($products as $item) { ?>
        <div class="list-view__item akb">
            <div class="list-view__info-col">
                <table class="list-view__brand">
                    <tr>
                        <th>Бренд</th>
                        <td><h3>
                                <?php
                                $link_filter = array('model_id' => $item['BrandModel']['id']);
                                echo $this->Html->link('<span>'.$item['Brand']['title'].' '.$item['BrandModel']['title'].'</span>', array('controller' => 'akb', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product']['id']), array('escape' => false));
                                $url = array('controller' => 'akb', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product']['id']);
                                ?></h3></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Емкость</th>
                        <td><?php echo $item['Product']['ah'].' Ач'; ?></td>
                    </tr>
                    <tr>
                        <th>Тип корпуса</th>
                        <td><?php echo $item['Product']['f1']; ?></td>
                    </tr>
                    <tr>
                        <th>Полярность</th>
                        <td class="position-relative">
                            <?php
                            $polarity;
                            if ($item['Product']['f2'] == 'R+') {
                                $polarity = 'Обратная';
                            } else {
                                $polarity = 'Прямая';
                            }
                            echo $polarity;
                            ?>
                            <?php echo $this->element('akb_polarity', array('polarity' => $item['Product']['f2'])); ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Пусковой ток</th>
                        <td><?php echo $item['Product']['current'].' A (EN)'; ?></td>
                    </tr>
                    <tr>
                        <th>Габариты (ДхШхВ)</th>
                        <td><?php echo $item['Product']['length'].' x '.$item['Product']['width'].' x '.$item['Product']['height'].' '.$item['Product']['f3']; ?></td>
                    </tr>
                    <tr>
                        <th>Технология изготовления</th>
                        <td><?php echo $item['Product']['color'] ? $item['Product']['color'] : ''; ?> <?php echo $item['Product']['truck'] ? '<strong>'.$item['Product']['truck'].'</strong>' : ''; ?></td>
                    </tr>
                    <tr>
                        <th>Страна-производитель</th>
                        <td class="list-view__flag-cell"><?php echo $item['Product']['material'] ? $item['Product']['material'] : ''; ?> <?php echo $this->element('akb_flag', array('country' => $item['Product']['material'])); ?> </td>
                    </tr>
                </table>
                <span class="list-view__img-warranty">Гарантия:&nbsp;&nbsp;<strong><?php echo $item['Product']['axis']; ?></strong></span>
            </div>
            <div class="list-view__img-col">
                <div class="prodImg floatl">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <?php
                                $placeholder = $this->Html->image('no-tyre-little.jpg', array('class' => 'no-img-tyre'));
                                $filename = null;
                                if (!empty($item['Product']['filename'])) {
                                    $filename = $item['Product']['filename'];
                                    $id = 'akb_images';
                                    $pathAkb = 'akb';
                                }
                                elseif (!empty($item['BrandModel']['filename'])) {
                                    $filename = $item['BrandModel']['filename'];
                                    $id = $item['BrandModel']['id'];
                                    $pathAkb = 'models';
                                }
                                if (!empty($filename)) {
                                    $imgBig = $this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $pathAkb, 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false));
                                    $imgSmall = $this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $pathAkb, 'width' => 220, 'height' => 220, 'crop' => false, 'folder' => false));

                                    echo $this->Html->link($this->Html->image($imgSmall, array('alt' => $brand['Brand']['title'] . ' ' . $item['BrandModel']['title'])), $imgBig, array('escape' => false, 'class' => 'lightbox', 'title' => $brand['Brand']['title'] . ' ' . $item['BrandModel']['title']));
                                }
                                else {
                                    echo $placeholder;
                                }
                                ?>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="list-view__price-col">
                <div class="product__info-prices">
                    <?php echo $this->element('akb_price', array('item' => $item)); ?>
                </div>
                <div class="product__info__buy-group">
                    <div class="product__info-buy buy-button">
                        <a href="javascript:void(0);" class="btVer2" onclick="buyAkb(<?php echo $item['Product']['id']; ?>);">Купить</a>
                    </div>
                    <div class="product__info-instock">
                        <?php
                        $in_stock_mark = $item['Product']['in_stock'] ? '<img title="в наличии" alt="в наличии" src="/img/yes.png">' : '';
                        echo $this->element('stock_places', array('stock_places' => $item['Product'], 'text' => '<div class="namber tyres">В наличии : '.$this->Frontend->getStockCount($item['Product']['stock_count']).' шт. '.$in_stock_mark.'</div>'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php $i ++; } ?>
</div>