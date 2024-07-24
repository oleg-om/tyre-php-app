<?php
if (empty($query)) {
    $query = 'name';
}
if (empty($value)) {
    $value = '';
}
if (empty($size)) {
    $size = '';
}
?>
<?php if (!empty($label)) { ?>
<span class="item-name"><?php echo $label; ?></span>
<?php } ?>
<div class="item-group <?php if ($direction == 'vertical') { echo 'vertical'; } ?>">
<?php foreach ($options as $index => $option) { ?>
    <?php
    $original_index = $index;
    $id = str_replace('/', '', $index);
    $index = str_replace('/', '%2F', $index);
    if (!empty($option['query'])) {
        if (isset($this->request->query[$option['query']])) {
            if ($this->request->query[$option['query']] == $original_index) {
                $option['checked'] = 'checked';
            }
        } else {
            if (isset($default_value)) {
                if ($default_value == $original_index) {
                    $option['checked'] = 'checked';
                }
            }
        }
    }
    ?>
    <div class="item-inner">
        <label class="checkbox__container checkbox__container-radio <?php echo $size; ?>" for="<?php echo $id; ?>">
            <?php if (isset($option['icon'])) { ?>
                <img src="<?php echo $option['icon']; ?>" class="checkbox__icon" />
            <?php } ?>
            <?php echo $option['label']; ?>

            <?php
                if (empty($option['checked'])) {
                    $option['checked'] = FALSE;
                }
            ?>

            <input type="radio" name="<?php echo $option['query']; ?>" id="<?php echo $id; ?>" value="<?php echo $original_index; ?>" <?php echo $option['checked']; ?> />
            <span class="checkmark"></span>
        </label>
    </div>
    <script type="text/javascript">
        $(function(){
            $("<?php echo "#".$id; ?>").change(function() {
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
