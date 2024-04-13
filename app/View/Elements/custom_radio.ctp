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
    if (!empty($option['query'])) {
        if ($this->request->query[$option['query']] == $index) {
            $option['checked'] = 'checked';
        }
    }
    ?>
    <div class="item-inner">
        <label class="checkbox__container checkbox__container-radio" for="<?php echo $index; ?>">
            <?php echo $option['label']; ?>

            <input type="radio" name="<?php echo $option['query']; ?>" id="<?php echo $index; ?>" value="<?php echo $index; ?>" <?php echo $option['checked']; ?> />
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
