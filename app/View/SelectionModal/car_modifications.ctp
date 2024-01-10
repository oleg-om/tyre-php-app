<div class="title">Выберите модификацию:<a href="javascript:void(0);" onclick="close_popup();" class="close">закрыть</a></div>
<a class="popup__back" href="javascript:void(0);" onclick="backToYear();">Назад</a>
<div class="popup__content">
    <div class="selection__modal">
            <div class="selection__modal__wrapper">
                <div class="selection__modal-list">
                    <?php foreach ($modifications as $i => $listItem) { ?>
                        <?php if ($i > 0 && $i % 4 == 0) { ?>
                        <?php } ?>
                        <a class="selection__modal-list-item selection__modal-list-item-single" href="/selection/view?brand_id=<?php echo $brand_slug; ?>&model_id=<?php echo $model_slug; ?>&year=<?php echo $year; ?>&mod=<?php echo $listItem['id']; ?>"><?php
                             echo $listItem['name']; ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function setModificationId(valueToSelect) {
                $("#CarModelId").val(valueToSelect).change();
                close_popup();
            }

            function backToYear() {
                close_popup();
                open_popup({
                    url: `/selection-modal/<?php echo $brand_slug;?>/<?php echo $model_slug;?>`,
                    type: 'post',
                    size: 'lg'
                });
            }
        </script>
    </div>
</div>