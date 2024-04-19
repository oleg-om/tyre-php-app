<?php
if (empty($query)) {
    $query = 'name';
}
if (empty($value)) {
    $value = '';
}
?>
<?php if (!empty($label)) { ?>
    <span class="item-name"><?php echo $label; ?></span>
<?php } ?>
<div class="item-group">
    <?php foreach ($options as $index => $option) { ?>
        <?php
        if (!empty($index)) {
            if ($this->request->query[$index] === '1') {
                $option['checked'] = 'checked';
            }
        }
        ?>
        <div class="item-inner">
            <label class="checkbox__container checkbox__container-checkbox" for="<?php echo $index; ?>">
                <?php if (isset($option['icon'])) { ?>
                    <img src="<?php echo $option['icon']; ?>" class="checkbox__icon" />
                <?php } ?>
                <?php echo $option['label']; ?>

                <input type="checkbox" name="<?php echo $index; ?>" id="<?php echo $index; ?>" value="1" <?php echo $option['checked']; ?> />
                <span class="checkmark"></span>
            </label>
        </div>
        <script type="text/javascript">
            $(function(){
                $('<?php echo '#'.$index; ?>').change(function() {
                    window.onbeforeunload = function() {
                        // save scroll position
                        localStorage.setItem('ks-scroll-position', window.scrollY);
                    };
                    // set loading class
                    setLoading();
                    // submit form
                    return setTimeout(() => {
                        $('#filter-form').submit();
                    }, 100)
                });
            });
            function setLoading() {
                $('#product-section').addClass('is-loading');
            }
        </script>
    <?php } ?>
</div>
