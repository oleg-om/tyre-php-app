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