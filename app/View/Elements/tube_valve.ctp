<?php
$img = '';
// print_r($this->valve_images_list);
if (empty($valve)) {
    $first_valve = '';
} else {
    $first_valve = trim(explode('/', $valve)[0]);
    if (!empty($valve_images_list[$first_valve])) {
        if (!empty($valve_images_list[$first_valve]['img'])) {
            $img = $valve_images_list[$first_valve]['img'];
        }
    }
}

$valve_title = str_replace(' / ',', ', h($valve));

if (!empty($img)) { ?>
    <span class="tube__valve">
        <img src="/img/valve/<?php echo $img?>" alt="<?php echo $valve_title; ?>" title="<?php echo $valve_title; ?>" >
    </span>
<?php }
?>