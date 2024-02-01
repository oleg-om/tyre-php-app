<div class="title">Выберите поколение:<a href="javascript:void(0);" onclick="close_popup();" class="close">закрыть</a></div>
<a class="popup__back" href="javascript:void(0);" onclick="backToModelModal();">Назад</a>
<div class="popup__content">
    <div class="selection__modal__gen">
        <?php
        foreach ($car_generations as $i => $item) { ?>
            <?php if ($i > 0 && $i % 4 == 0) { ?>
            <?php } ?>
            <a class="selection__modal__gen-item" href="javascript:void(0);" onclick="setGeneration('<?php echo $item['CarGeneration']['slug']; ?>', '<?php echo $item['CarGeneration']['title']; ?>');">
                    <?php
                    $image = '';
                    if (!empty($item['CarGeneration']['image_preview'])) {
                        $image = $this->Html->image('car_generations/' . $item['CarGeneration']['image_preview'], array('alt' => $item['CarGeneration']['title']));
                    }
                     echo $image;
                    ?>
                    <span>
                        <?php
                        echo $item['CarGeneration']['title'];
                        ?>
                    </span>
            </a>
        <?php } ?>
        <script type="text/javascript">
            function setGeneration(slug, title) {
                $("#CarGenerationSlug").html(title);
                $("#CarGenerationSlug").attr('value', slug);
                close_popup();
                open_popup({
                    url: `/selection-modal/<?php echo $brand['CarBrand']['slug'];?>/<?php echo $model['CarModel']['slug'];?>/${slug}`,
                    type: 'post',
                    size: 'lg'
                });
            }

            function backToModelModal() {
                close_popup();
                open_popup({
                    url: `/selection-modal/<?php echo $brand_id;?>`,
                    type: 'post',
                    size: 'lg'
                });
            }
        </script>
    </div>
</div>