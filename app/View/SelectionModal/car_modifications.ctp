<div class="title">Выберите модификацию:<a href="javascript:void(0);" onclick="close_popup();" class="close">закрыть</a></div>
<a class="popup__back" href="javascript:void(0);" onclick="backToYear();">Назад</a>
<div class="popup__content">
    <div class="selection__table">
            <div class="selection__table__wrapper">
                <table>
                    <thead>
                    <tr>
                        <th class="selection__secondary-td">Объем двигателя</th>
                        <th class="selection__secondary-td">Тип двигателя</th>
                        <th class="selection__secondary-td">Мощность двигателя</th>
                        <th class="selection__main-td">Комплектация</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($car_modifications as $i => $item) { ?>
                        <?php if ($i > 0 && $i % 4 == 0) { ?>
                        <?php } ?>
                        <tr onclick="setModification('<?php echo $item['CarModification']['title']; ?>','<?php echo $item['CarModification']['slug']; ?>');">
                            <td class="selection__secondary-td"><?php echo $item['CarModification']['engine_displacement']; ?></td>
                            <td class="selection__secondary-td"><?php echo $item['CarModification']['engine_type_text']; ?></td>
                            <td class="selection__secondary-td"><?php echo $item['CarModification']['hp_title']; ?></td>
                            <td class="selection__main-td"><?php if (!empty($item['CarModification']['equipment'])) {
                                echo $item['CarModification']['equipment'];
                                } else {
                                    echo '—';
                                }
                            ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script type="text/javascript">
            function goToGoods(category, slug) {
                const origin = window.location.origin;

              if (category === 1) {
                  // tyres
                  window.location = `${origin}/tyres?modification=${slug}`;
              }
            }
            function setModification(title, slug) {
                $("#CarModificationSlug").html(title);
                $("#CarModificationSlug").attr('value', slug);
                close_popup();
                goToGoods(<?php echo $path; ?>, slug)
            }

            function backToYear() {
                close_popup();
                open_popup({
                    url: `/selection-modal/<?php echo $path; ?>/<?php echo $brand_slug;?>/<?php echo $model_slug;?>`,
                    type: 'post',
                    size: 'lg'
                });
            }
        </script>
    </div>
</div>