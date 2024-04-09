<h2 class="title"> Аккумуляторы <?php if (!empty($brand['Brand']['slug'])) echo $brand['Brand']['title'] ?>
    <?php if (!empty($car_brand['CarBrand']['slug'])) echo ' на '.$car_brand['CarBrand']['title'].' '.$car_model['CarModel']['title'].' '.$car_generation['CarGeneration']['title'].' '.$car_modification['CarModification']['title'] ?></h2>
<?php if ($mode == 'brand')
    $view = 'brands'
?>
<?php if ($mode == 'brands')
echo '<p class="akb__promo"><img src="http://kerchshina.com/files/1/akb4.jpg" alt="" width="870" height="218" /></p>'
?>
<?php echo json_encode($this->Session->read('car_modification_slug')); ?>

<div class="<?php if (empty($modification_slug)) { echo 'd-none'; } else { echo 'car__sizes car__sizes-wheels'; } ?>">

    <div class="car__sizes__wrap">
        <div class="car__sizes__info">

                 <?php if (!empty($start_stop) && $start_stop == 1) { ?>
            <div class="car__sizes__extra__text">
                <?php echo 'На ваш автомобиль предусмотрена установка аккумуляторов с технологией Start-Stop' ;?>
            </div>
                 <?php } ?>

            <?php if (!empty($car_factory_sizes)) { ?>
                <div class="car__sizes__wrapper">
                    <div class="car__sizes__title">Рекомендация автопроизводителя</div>
                    <ul class="car__sizes__list">
                        <?php
                        foreach ($car_factory_sizes as $size) {
                            $filter = $this->Frontend->getAkbParams($size);
                            ?>
                            <li>
                                    <span class="<?php if ($filter['is_active'] == 1) { echo 'is_active'; }?>">
                                        <?php if ($filter['is_active'] == 1) { echo '• '; }?><?php echo $this->Html->link($size['CarBatteries']['capacity_min'].'-'.$size['CarBatteries']['capacity_max'].' Ач, '.$size['CarBatteries']['polarity'].' полярность, '.$size['CarBatteries']['type_case'].', размер (ДхШхВ) '.$size['CarBatteries']['length_min'].'-'.$size['CarBatteries']['length_max'].'x'.$size['CarBatteries']['width_min'].'-'.$size['CarBatteries']['width_max'].'x'.$size['CarBatteries']['height_min'].'-'.$size['CarBatteries']['height_max'].' мм', array('controller' => 'akb', 'action' => 'index', '?' => $filter), array('escape' => false));?>
                                    </span>
                            </li>
                        <?php } ?>
                    </ul>

                </div>
            <?php } ?>

            <?php if (!empty($car_tuning_sizes)) { ?>
                <div class="car__sizes__wrapper">
                    <div class="car__sizes__title">Варианты замены</div>
                    <ul class="car__sizes__list">
                        <?php
                        foreach ($car_tuning_sizes as $size) {
                            $filter = $this->Frontend->getAkbParams($size);
                            ?>
                            <li>
                                    <span class="<?php if ($filter['is_active'] == 1) { echo 'is_active'; }?>">
                                        <?php if ($filter['is_active'] == 1) { echo '• '; }?><?php echo $this->Html->link($size['CarBatteries']['capacity_min'].'-'.$size['CarBatteries']['capacity_max'].' Ач, '.$size['CarBatteries']['polarity'].' полярность, '.$size['CarBatteries']['type_case'].', размер (ДхШхВ) '.$size['CarBatteries']['length_min'].'-'.$size['CarBatteries']['length_max'].'x'.$size['CarBatteries']['width_min'].'-'.$size['CarBatteries']['width_max'].'x'.$size['CarBatteries']['height_min'].'-'.$size['CarBatteries']['height_max'].' мм', array('controller' => 'akb', 'action' => 'index', '?' => $filter), array('escape' => false));?>
                                    </span>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

            <?php } ?>
        </div>
        <?php
        $image = '';
        if (!empty($car_image)) {
            $image = $this->Html->image('car_generations/' . $car_image, array('alt' => $car_brand['CarBrand']['title']));
        }
        echo $image;
        ?>
        <button type="reset" class="filter-reset" id="filter-reset" onclick="resetAkb()">Сбросить все<span>x</span>
            <script type="text/javascript">
                function resetAkb() {
                    window.location = '/akb'
                }
            </script>
        </button>
    </div>
</div>


<?php
$url = array('controller' => 'akb', 'action' => 'index', '?' => $filter);
echo $this->element('currency');

?>
<?php if ($view == 'models')
    echo $this->element('mode_selector', array('url' => $url));
    ?>

<?php if ($view == 'brands') { ?>
<div class="selection">
	<?php

		foreach ($all_brands as $i => $item) {
			if ($i > 0 && $i % 4 == 0) {
				echo '<div class="clear"></div>';
			}
			echo '<div class="item">';
			$image = '';
			if (!empty($item['Brand']['filename'])) {
				$image = $this->Html->image($this->Backend->thumbnail(array('id' => $item['Brand']['id'], 'filename' => $item['Brand']['filename'], 'path' => 'brands', 'width' => 160, 'height' => 60, 'crop' => false, 'folder' => false)), array('alt' => $item['Brand']['title']));
			}
			echo $this->Html->link('<span>' . $image . '</span><strong>' . $item['Brand']['title'] . '</strong>', array('controller' => 'akb', 'action' => 'brand', 'slug' => $item['Brand']['slug']), array('escape' => false, 'class' => 'img-brand', 'title' => $item['Brand']['title']));
			echo '</div>';
		}
	?>
	<div class="clear"></div>
</div>
<?php } else { ?>
	<?php
	$this->Paginator->options(array('url' => array('controller' => 'akb', 'action' => 'index', '?' => $filter)));;
	?>
	<div id="vmMainPage">
        <?php if ($mode == 'table') { ?>
		<table border="0" width="100%" cellspacing="0" cellpadding="0" class="sectiontableheader sectiontableentry1">
			<tr class="rowTint1">
				<th>&nbsp;</th>
				<th>Бренд</th>
				<th>Модель</th>
				<th>Размер</th>
				<th>Емкость (Ah)</th>
				<th>Ток</th>
				<th>Тип</th>
				<th>П.</th>
				<?php if ($this->Frontend->canShowAkbPrice(false)) { ?>
				<th width="50">Цена</th>
				<?php } ?>
				<th>Кол.</th>
				<th></th>
			</tr>

			<?php $i = 0; foreach ($products as $item) { ?>

			<tr height="22" class="rowTint<?php echo $i % 2 == 1 ? '1' : ''; ?>">
				<td><?php
					$filename = null;
					if (!empty($item['Product']['filename'])) {
						$filename = $item['Product']['filename'];
						$id = $item['Product']['id'];
                        $pathAkb = 'akb';
					}
					elseif (!empty($item['BrandModel']['filename'])) {
						$filename = $item['BrandModel']['filename'];
						$id = $item['BrandModel']['id'];
                        $pathAkb = 'models';
					}
					if (!empty($filename)) {
						echo $this->Html->link($this->Html->image('camera.png', array('alt' => $item['Brand']['title'] . ' ' . $item['BrandModel']['title'])), $this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $pathAkb, 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false)), array('escape' => false, 'class' => 'lightbox', 'title' => $item['Brand']['title'] . ' ' . $item['BrandModel']['title']));
					}
				?></td>
				<td><?php echo $this->Html->link($item['Brand']['title'], array('controller' => 'akb', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product']['id']), array('escape' => false)); ?></td>
				<td><?php echo h($item['BrandModel']['title']); ?></td>
				<td><?php echo $item['Product']['width'] . 'x' . $item['Product']['length'] . 'x' . $item['Product']['height']; ?></td>
				<td><?php echo $item['Product']['ah']; ?>ач</td>
				<td><?php echo $item['Product']['current']; ?></td>
				<td><?php echo h($item['Product']['f1']); ?></td>
				<td><?php echo h($item['Product']['f2']); ?></td>
				<?php if ($this->Frontend->canShowAkbPrice(false)) { ?>
				<td>
					<?php if ($this->Frontend->canShowAkbPrice($item['Product']['not_show_price'])) { ?>
						<span class="productPrice"><?php echo $this->Frontend->getPrice($item['Product']['price'], 'akb'); ?></span>
					<?php } ?>
				</td>
				<?php } ?>
				<td><?php echo $this->Frontend->getStockCount($item['Product']['stock_count']); ?></td>
				<td><?php echo $item['Product']['in_stock'] ? '.' : ''; ?></td>
			</tr>
			<?php $i ++; } ?>
            <?php if (empty($products)) { echo 'По Вашему запросу ничего не найдено'; } ?>
		</table>
        <?php } ?>
        <?php if ($mode == 'block') { ?>
            <div class="border-b border-b-tyres">
                <div class="width-disk">
                    <?php $i = 0; foreach ($products as $item) { ?>
                        <div class="boxList season-winter with-season season-yes season-cars">
                            <div class="info-top">
                                <h3>
                                <?php
                                $link_filter = array('model_id' => $item['BrandModel']['id']);
                                //$link_filter = array_merge($link_filter, $filter);
                                echo $this->Html->link('<span>'.$item['Brand']['title'].' '.$item['BrandModel']['title'].'</span>', array('controller' => 'akb', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product']['id']), array('escape' => false));
                                $url = array('controller' => 'akb', 'action' => 'view', 'slug' => $item['Brand']['slug'], 'id' => $item['Product']['id']);
                                ?></h3>
                            </div>
                            <div class="prodImg floatl">
                                <table cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>

                                            <?php
                                            $placeholder = $this->Html->image('no-tyre-little.jpg', array('class' => 'no-img-tyre'));
                                            $filename = null;
                                            if (!empty($item['Product']['filename'])) {
                                                $filename = $item['Product']['filename'];
                                                $id = $item['Product']['id'];
                                                $pathAkb = 'akb';
                                            }
                                            elseif (!empty($item['BrandModel']['filename'])) {
                                                $filename = $item['BrandModel']['filename'];
                                                $id = $item['BrandModel']['id'];
                                                $pathAkb = 'models';
                                            }
                                            if (!empty($filename)) {
                                                $imgBig = $this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $pathAkb, 'width' => 800, 'height' => 600, 'crop' => false, 'folder' => false));
                                                $imgSmall = $this->Backend->thumbnail(array('id' => $id, 'filename' => $filename, 'path' => $pathAkb, 'width' => 150, 'height' => 150, 'crop' => false, 'folder' => false));
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
                            <div class="infoList">
                                <div class="detalProd tyres">
                                    <a href="<?php echo Router::url($url); ?>"><?php echo $item['Product']['ah']; ?>ач <?php echo $item['Product']['current']; ?> <?php echo h($item['Product']['f1']); ?> <?php echo h($item['Product']['f2']); ?></a>
                                </div>
                            </div>
                            <div class="product__info">
                                <div class="priceMore tyres">
                                    <?php if ($this->Frontend->canShowAkbPrice(false)) { ?>
                                        <?php if ($this->Frontend->canShowAkbPrice($item['Product']['not_show_price'])) { ?>
                                            <span><?php echo $this->Frontend->getPrice($item['Product']['price'], 'akb'); ?></span>
                                        <?php } ?>
                                    <?php } ?>
                                    <div class="namber tyres">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->Frontend->getStockCount($item['Product']['stock_count']); ?> шт. <?php echo $item['Product']['in_stock'] ? '<img title="в наличии" alt="в наличии" src="/img/yes.png">' : ''; ?></div>
                                </div>
                                <div class="buy-button">
                                    <a href="javascript:void(0);" class="btVer2" onclick="buyAkb(<?php echo $item['Product']['id']; ?>);">Купить</a>
                                </div>
                            </div>
                            <td><?php echo $item['Product']['in_stock'] ? '.' : ''; ?></td>
                        </div>
                        <?php $i ++; } ?>
                </div>
            </div>
            <?php if (empty($products)) { echo 'По Вашему запросу ничего не найдено'; } ?>
        <?php } ?>
        <!--LIST MODE START-->
        <?php if ($mode == 'list') { ?>
            <?php echo $this->element('akb_list_view'); ?>
        <?php } ?>
        <!--LIST MODE END-->
		<?php
			echo $this->element('pager', array('bottom' => true));
		?>
	</div>
<?php } ?>

<?php
	echo $this->element('seo_akb');
	//echo $this->element('bottom_banner');
?>
<script type="text/javascript">
<!--
$(function(){
	$('.lightbox').lightBox({
		imageLoading: '/img/lightbox-ico-loading.gif',
		imageBtnPrev: '/img/lightbox-btn-prev.gif',
		imageBtnNext: '/img/lightbox-btn-next.gif',
		imageBtnClose: '/img/lightbox-btn-close.gif',
		imageBlank: '/img/lightbox-blank.gif'
	});
});
//-->
</script>
<script type="text/javascript">

    function buyAkb(itemId) {
        open_popup({
            url: '/cart',
            type: 'post',
            data: {
                'data[Product][0][count]': 1,
                'data[Product][0][product_id]': itemId
            },
        });
    }
</script>