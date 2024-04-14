<?php
?>
<?php if (!empty($label)) { ?>
    <span class="item-name"><?php echo $label; ?></span>
<?php } ?>
<div class="item-group">
    <?php
        if ($this->request->query['f2'] == 'right') {
            $is_right = 'checked';
        }
        if ($this->request->query['f2'] == 'left') {
            $is_left = 'checked';
        }
    ?>
    <div class="item-inner">
        <label class="checkbox__container checkbox__container-radio" for="left">
            Прямая
            <input type="radio" name="f2" id="left" value="left" <?php echo $is_left; ?> />
            <span class="checkmark checkmark__akb"></span>
        </label>
    </div>

    <script type="text/javascript">
        $(function(){
            $('#left').change(function() {
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

    <div class="item-inner">
        <label class="checkbox__container checkbox__container-radio checkbox__container-reverse" for="right">
            Обратная
            <input type="radio" name="f2" id="right" value="right" <?php echo $is_right; ?> />
            <span class="checkmark checkmark__akb"></span>
        </label>
    </div>

    <script type="text/javascript">
        $(function(){
            $('#right').change(function() {
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
</div>
