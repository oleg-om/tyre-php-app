<div class="title">Выберите модель:<a href="javascript:void(0);" onclick="close_popup();" class="close">закрыть</a></div>
<a class="popup__back" href="javascript:void(0);" onclick="backToBrand();">Назад</a>
<div class="popup__content">
    <div class="selection__modal">
        <?php
        // group data
        $output = [];
        foreach ($car_models as $index => $item) {
            $letter = mb_substr($item['CarModel']['title'], 0, 1, "UTF-8"); // get first char
            $output[$letter]['letter'] = $letter;
            $output[$letter]['list'][] = $item['CarModel'];     // group
        }

        foreach ($output as $i => $item) { ?>
            <?php if ($i > 0 && $i % 4 == 0) { ?>
            <?php } ?>
            <div class="selection__modal__wrapper">
                <div class="selection__modal-letter"><?php
                    echo $item['letter']; ?>
                </div>
                <div class="selection__modal-list">
                    <?php foreach ($item['list'] as $i => $listItem) { ?>
                        <?php if ($i > 0 && $i % 4 == 0) { ?>
                        <?php } ?>
                        <a class="selection__modal-list-item" href="javascript:void(0);" onclick="setActiveModal('<?php echo $listItem['slug']; ?>', '<?php echo $listItem['title']; ?>');"><?php
                            echo $listItem['title']; ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <script type="text/javascript">
            function setActiveModal(slug, title) {
                $("#CarModelSlug").html(title);
                $("#CarModelSlug").attr('value', slug);
                close_popup();
                open_popup({
                    url: `/selection-modal/<?php echo $path; ?>/<?php echo $brand_slug; ?>/${slug}`,
                    type: 'post',
                    size: 'lg'
                });
            }

            function backToBrand() {
                close_popup();
                open_popup({
                    url: `/selection-modal<?php echo $path; ?>/`,
                    type: 'post',
                    size: 'lg'
                });
            }
        </script>
    </div>
</div>