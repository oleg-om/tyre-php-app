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
    $letter = mb_substr($option, 0, 1, "UTF-8");
    $output[] = array('label' => $option, 'value' => $index);
}
$query = '';
if (isset($this->request->query[$name])) {
    $query = $this->request->query[$name];
}
if ($this->Session->check('car_modification_slug')) {
    $modification_slug = $this->Session->read('car_modification_slug');
}
?>

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
        placeholder: <?php if ($query !== '') { echo json_encode($query); } else { echo json_encode($placeholder); } ?>,
        searchPlaceholderText: 'Поиск...',
        noSearchResultsText: 'Не найдено',
        allOptionsSelectedText: 'Все',
        optionsSelectedText: 'опций выбрано',
        optionSelectedText: 'опция выбрана',
        noOptionsText: 'Опций не найдено',
        hideClearButton: <?php echo json_encode($hideClearButton); ?>,
        selectedValue: <?php echo json_encode(explode(',', $query)); ?>
    });
</script>
<script type="text/javascript">
    $(function(){
        $('<?php echo '#'.$id; ?>').change(function(e) {
            var multiple = e.currentTarget.virtualSelect.multiple;

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
</script>
<script type="text/javascript">
    // get scroll position
    document.addEventListener("DOMContentLoaded", function(e) {
        // open select if multiple
        var multipleFilter = localStorage.getItem('ks-last-multiple-filter');
        if (multipleFilter) {
            document.querySelector(multipleFilter).open();
            localStorage.removeItem('ks-last-multiple-filter');
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
        console.log('modification', modification);
        if (modification) {
            switchTab('params');
        }
    }
</script>