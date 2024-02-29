<?php
if (!isset($options)) {
    $options = array();
}
if (!isset($title)) {
    $title = '';
}
if (!isset($id)) {
    $id = 'id';
}
if (!isset($form_id)) {
    $form_id = 'filter-form';
}
$range = array_keys($options);

$json_range = json_encode($range);

$min_value = min($range);
$max_value = max($range);
?>

<div class="range-slider">
    <span class="range-title"><?php echo "$title" ?></span>
    <div class="range-inputs">
        <div class="inp"><?php
            echo $this->Form->input('ah_from', array('class' => 'filter-select sel-style1', 'id' => 'input-range-min-'.$id, 'type' => 'select', 'label' => false, 'options' => $options, 'empty' => array('' => 'Все'), 'div' => false));
            ?></div>
        <div class="inp"><?php
            echo $this->Form->input('ah_to', array('class' => 'filter-select sel-style1', 'id' => 'input-range-max-'.$id, 'type' => 'select', 'label' => false, 'options' => $options, 'empty' => array('' => 'Все'), 'div' => false));
            ?></div>
    </div>
    <div class="range-container">
        <div class="slider-track"></div>
        <input list="min-range" type="range" min=<?php echo "$min_value" ?> max=<?php echo "$max_value" ?> value=<?php echo "$min_value" ?> id="slider-1" oninput="slideOne()">
        <input type="range" min=<?php echo "$min_value" ?> max=<?php echo "$max_value" ?> value=<?php echo "$max_value" ?> id="slider-2" oninput="slideTwo()">
        <span class="range-tip" id="range-tip" onclick="showGoods();"></span>
    </div>

    <datalist id="min-range">
        <?php foreach ($range as $option) { ?>
            <option class="item" value="<?php echo $option; ?>">
        <?php } ?>
    </datalist>

</div>

<script type="text/javascript">
    window.onload = function(){
        slideOne(true);
        slideTwo(true);
    }
    let sliderOne = document.getElementById("slider-1");
    let sliderTwo = document.getElementById("slider-2");
    let minGap = 0;
    let sliderTrack = document.querySelector(".slider-track");
    let sliderMaxValue = document.getElementById("slider-1").max;
    //
    let mainInputOne = document.getElementById("<?php echo 'input-range-min-'.$id; ?>");
    let mainInputTwo = document.getElementById("<?php echo 'input-range-max-'.$id; ?>");

    var closest = (goal, arr) => {
        return arr.reduce(function(prev, curr) {
            return (Math.abs(curr - Number(goal)) < Math.abs(prev - Number(goal)) ? curr : prev);
        });
    }

    var getClosestIndex = (goal, arr) => {
        return arr.findIndex((item) => item === goal)
    }

    let tip = document.getElementById("range-tip");
    let showTip = false;

    let timer1;

    function toggleTip() {
        tip.classList.add("range-tip-show");

        clearTimeout(timer1);
        timer1 = setTimeout(() => {
            tip.classList.remove("range-tip-show");
        }, 6000);
    }

    function slideOne(noTooltip){
        if(parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap){
            sliderOne.value = parseInt(sliderTwo.value) - minGap;
        }
        const min_value = closest(sliderOne.value, <?php echo $json_range; ?>);
        mainInputOne.value = min_value;
        sliderOne.value = min_value;
        fillColor();
        if (!noTooltip) {
            toggleTip();
        }
    }
    function slideTwo(noTooltip){
        if(parseInt(sliderTwo.value) - parseInt(sliderOne.value) <= minGap){
            sliderTwo.value = closest(parseInt(sliderOne.value) + minGap, <?php echo $range; ?>);
        }

        const max_value = closest(sliderTwo.value, <?php echo $json_range; ?>);
        mainInputTwo.value = max_value;
        sliderTwo.value = max_value;

        fillColor();
        if (!noTooltip) {
            toggleTip();
        }
    }
    function fillColor(){
        percent1 = (sliderOne.value / sliderMaxValue) * 100;
        percent2 = (sliderTwo.value / sliderMaxValue) * 100;
        sliderTrack.style.background = `linear-gradient(to right, #dadae5 ${percent1}% , #589b2f ${percent1}% , #589b2f ${percent2}%, #dadae5 ${percent2}%)`;
    }
    function showGoods() {
        let form = document.getElementById("<?php echo $form_id; ?>");
        form.submit();
    }
</script>

<style>
    .range-title {
        color: #000000;
        font-size: 14px;
        padding-top: 7px;
    }
    .range-slider{
        position: relative;
        width: auto;
    }
    .range-inputs {
        display: flex;
        flex-direction: row;
        gap: 10px;
    }
    .range-inputs .inp {
        width: 100%;
    }
    .range-container{
        position: relative;
        width: 100%;
        height: 20px;
        margin-top: 10px;
        margin-bottom: 15px;
    }
    input[type="range"]{
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 100%;
        outline: none;
        position: absolute;
        margin: auto;
        top: 0;
        bottom: 0;
        background-color: transparent;
        pointer-events: none;
        border: none;
    }
    .slider-track{
        width: 100%;
        height: 5px;
        position: absolute;
        margin: auto;
        top: 0;
        bottom: 0;
        border-radius: 5px;
    }
    input[type="range"]::-webkit-slider-runnable-track{
        -webkit-appearance: none;
        height: 5px;
    }
    input[type="range"]::-moz-range-track{
        -moz-appearance: none;
        height: 5px;
    }
    input[type="range"]::-ms-track{
        appearance: none;
        height: 5px;
    }
    input[type="range"]::-webkit-slider-thumb{
        -webkit-appearance: none;
        height: 1.7em;
        width: 1.7em;
        background-color: #316b16;
        cursor: pointer;
        margin-top: -9px;
        pointer-events: auto;
        border-radius: 50%;
    }
    input[type="range"]::-moz-range-thumb{
        -webkit-appearance: none;
        height: 1.7em;
        width: 1.7em;
        cursor: pointer;
        border-radius: 50%;
        background-color: #316b16;
        pointer-events: auto;
    }
    input[type="range"]::-ms-thumb{
        appearance: none;
        height: 1.7em;
        width: 1.7em;
        cursor: pointer;
        border-radius: 50%;
        background-color: #316b16;
        pointer-events: auto;
    }
    input[type="range"]:active::-webkit-slider-thumb{
        background-color: #ffffff;
        border: 3px solid #316b16;
    }
    .range-tip-show:before{
        content: "Показать";
        position: absolute;
        top: -15px;
        right: -120px;
        background-color: #e35121;
        padding: 15px;
        color: #FFFFFF;
        z-index: 5;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
    }
    .range-tip-show:after {
        content: '';
        position: absolute;
        display: block;
        width: 0;
        right: -45px;
        top: 50%;
        border: 15px solid transparent;
        border-left: 0;
        border-right: 15px solid #e35121;
        transform: translate(calc(-100% - 5px), -50%);
    }
</style>