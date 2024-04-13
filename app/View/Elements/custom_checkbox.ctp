<?php
if (empty($query)) {
    $query = 'name';
}
if (empty($value)) {
    $value = '';
}
print_r($this->request->query['start_stop_type']);
$values_array = array();
?>
<?php if (!empty($label)) { ?>
    <span class="item-name"><?php echo $label; ?></span>
<?php } ?>
<div class="item-group">
    <input type="text" class="d-none" name="<?php echo $query; ?>" id="<?php echo $query; ?>" value="<?php echo $this->request->query[$query]; ?>" />
    <?php foreach ($options as $index => $option) { ?>
        <?php
            $values_array[] = $index;
            if (!empty($query)) {
                if (strpos($this->request->query[$query], $index) !== false) {
                    $option['checked'] = 'checked';
                }
            }
        ?>
        <div class="item-inner">
            <label class="checkbox__container checkbox__container-checkbox" for="<?php echo $index; ?>">
                <?php echo $option['label']; ?>

                <input type="checkbox" name="<?php echo $query; ?>" id="<?php echo $index; ?>" value="<?php echo $index; ?>" <?php echo $option['checked']; ?> />
                <span class="checkmark"></span>
            </label>
        </div>
        <script type="text/javascript">
            $(function(){
                $('<?php echo '#'.$index; ?>').change(function(e) {
                    var values = <?php echo json_encode($values_array); ?>;
                    for (var element of values) {
                        $('#' + element).prop('disabled', true);
                    }
                    $('<?php echo '#'.$index; ?>').prop('disabled', true);
                    if (this.checked === true)
                    {
                        var val = <?php if (!empty($this->request->query[$query])) {
                                echo json_encode(explode(',', trim($this->request->query[$query])));
                            } else {
                                echo json_encode([]);
                            }
                            ?>;
                        if (val && val?.length) {
                            var x = val?.find((it) => it === this.value);
                            if (!x) {
                                val.push(this.value);
                            } else {
                                val = val.filter((it) => it !== this.value);
                            }
                            val = val.join(',');
                        } else {
                            val = this.value;
                        }
                        $('<?php echo '#'.$query; ?>').attr('value', val);
                    }
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
