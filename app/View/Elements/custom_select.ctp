<?php
if (empty($name)) {
    $name = 'name';
}
if (empty($id)) {
    $id = $name;
}
if (empty($multiple)) {
    $multiple = false;
}
if (empty($search)) {
    $search = false;
}
if (empty($placeholder)) {
    $placeholder = 'Все';
}
if (empty($options)) {
    $options = array();
}

foreach ($options as $index => $option) {
    $output[] = array('label' => $add_prefix.$option, 'value' => $index);
}
$query = '';

if (isset($this->request->query[$name])) {
    $query = $this->request->query[$name];
}
if (isset($query) && $query !== '' && isset($auto_add_options)) {
    if (!in_array(array('label' => $options_prefix.$query.$options_postfix, 'value' => intval($query)), $output)) {
        $output[] = array('label' => $add_prefix.$options_prefix.$query.$options_postfix, 'value' => $query);
        usort($output, function($a, $b) {
            return $a['value'] - $b['value'];
        });
    }
}
if ($this->Session->check('car_modification_slug')) {
    $modification_slug = $this->Session->read('car_modification_slug');
}

if ($query !== '') {
    $placeholder_name = $query;
} else {
    $placeholder_name = $placeholder;
}

?>
<?php if ($multiple == true) { ?>
<!--multi custom select-->
<div class="item-inner">
    <?php
     if (!empty($label)) { ?>
         <label class="name" for="<?php echo $id; ?>"><?php echo $label; ?>:</label>
     <?php }
    ?>
    <div id="<?php echo $id; ?>" name="<?php echo $name; ?>"></div>
</div>

<script type="text/javascript">
    VirtualSelect.init({
        ele: <?php echo json_encode('#'.$id); ?>,
        options: <?php echo json_encode($output); ?>,
        multiple: <?php echo json_encode($multiple); ?>,
        search: <?php echo json_encode($search); ?>,
        placeholder: <?php echo json_encode($placeholder_name); ?>,
        searchPlaceholderText: 'Поиск...',
        noSearchResultsText: 'Не найдено',
        allOptionsSelectedText: 'Все',
        optionsSelectedText: 'опций выбрано',
        optionSelectedText: 'опция выбрана',
        noOptionsText: 'Опций не найдено',
        selectAllText: 'Выбрать все',
        hideClearButton: <?php echo json_encode($hideClearButton); ?>,
        selectedValue: <?php echo json_encode(explode(',', $query)); ?>,
        disabled: !!'<?php if (!empty($disabled)) { echo true; } else { echo false; } ?>'
    });
</script>

<!--usual select-->
<?php } else { ?>
    <?php
        foreach ($output as $option) {
            $usual_options[$option['value']] = $option['label'];
        }
    ?>
    <div class="item-inner valve">
        <?php if (!empty($label)) { ?>
            <label class="name" for="<?php echo $id; ?>"><?php echo $label; ?>:</label>
        <?php } ?>
        <div class="inp">
            <?php
                echo $this->Form->input($name, array('type' => 'select', 'id' => $id, 'name' => $id, 'label' => false, 'options' => $usual_options, 'empty' => array('' => $placeholder), 'div' => false, 'class' => 'sel-style1 filter-select'));
            ?>
        </div>
    </div>
<?php } ?>


<script type="text/javascript">
    $(function(){
        $('<?php echo '#'.$id; ?>').change(function(e) {
            var multiple = e?.currentTarget?.virtualSelect?.multiple;

            window.onbeforeunload = function(e) {
                // save scroll position
                localStorage.setItem('ks-scroll-position', window.scrollY);
                // save chosen filter was multiple
                if (multiple) {
                    localStorage.setItem('ks-last-multiple-filter', <?php echo json_encode('#'.$id); ?>);
                }
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
    $('<?php echo '#'.$id; ?>').on('beforeClose', removeMultipleFilterFromLocalStorage);
    function removeMultipleFilterFromLocalStorage() {
        var multipleFilter = localStorage.getItem('ks-last-multiple-filter');
        if (multipleFilter) {
            localStorage.removeItem('ks-last-multiple-filter');
        }
    }
</script>

<script type="text/javascript">
    // get scroll position
    document.addEventListener("DOMContentLoaded", function(e) {
        // open select if multiple
        var multipleFilter = localStorage.getItem('ks-last-multiple-filter');
        if (multipleFilter) {
            localStorage.removeItem('ks-last-multiple-filter');
            setTimeout(()=> {
                document.querySelector(multipleFilter).open();
            }, 100)
        }
        // scroll to last position before reload
        var scrollPosition = localStorage.getItem('ks-scroll-position');
        if (scrollPosition) {
            window.scrollTo(0, scrollPosition);
            localStorage.removeItem('ks-scroll-position');
            // show reset filter
            $('#filter-reset').show();
            checkFormIsChanged();
        }
    });

    // choose filter type (params/auto) after choosing select
    function checkFormIsChanged() {
        var modification = '<?php echo $modification_slug; ?>';

        if (modification) {
            switchTab('params');
        }
    }
</script>