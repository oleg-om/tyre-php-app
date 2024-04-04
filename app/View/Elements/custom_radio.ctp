<?php
if (empty($query)) {
    $query = 'name';
}
if (empty($label)) {
    $label = 'Лейбл';
}
if (empty($value)) {
    $value = '';
}
$query_value = $this->request->query[$query];
if (empty($checked)) {
    $checked = '';
}
if (!empty($checked) && $checked === true) {
    $checked = 'checked';
}
if (empty($checked) && !empty($query_value)) {
    if ($query_value == $value) {
        $checked = 'checked';
    }
}
?>

<div class="item-inner">
    <label class="checkbox__container" for="<?php echo $value; ?>">
        <?php echo $label; ?>

        <input type="radio" name="<?php echo $query; ?>" id="<?php echo $value; ?>" value="<?php echo $value; ?>" <?php echo $checked; ?> />
        <span class="checkmark"></span>
    </label>
</div>