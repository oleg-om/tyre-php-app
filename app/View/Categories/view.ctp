<?php if (!empty($banners)) { ?>
<div class="br">
	<div id="slides">
		<div class="slides_container"><?php
			foreach ($banners as $banner) {
				echo $this->Html->link($this->Html->image('/img/promo/' . $banner['Banner']['id'] . '/' . $banner['Banner']['filename'], array('width' => 854, 'height' => 143)), $banner['Banner']['link'], array('escape' => false));
			}
		?></div>
	</div>
</div>
<?php } ?>
<div class="filter">
	<div class="filter-menu"><?php
		foreach ($categories as $item) {
			$class = '';
			if ($item['Category']['id'] == $category['Category']['id']) {
				$class = ' active';
			}
			$url = array('controller' => 'categories', 'action' => 'view', 'slug' => $item['Category']['slug']);
			$img_link = '';
			if (!empty($item['Category']['filename'])) {
				$img_link = $this->Html->link($this->Html->image('/img/animals/' . $item['Category']['filename'], array('width' => 79, 'height' => 76, 'alt' => $item['Category']['title'])), $url, array('escape' => false));
			}
			echo '<div class="button ' . $class . '"><span>' . $img_link . '</span><p>' . $this->Html->link($item['Category']['title'], $url, array('escape' => false)) . '</p></div>';
		}
	?></div>
	<?php
		$fields = array(1 => array(), 2 => array(), 3 => array());
		foreach ($category['Field'] as $item) {
			$fields[$item['group_id']][$item['id']] = $item['title'];
		}
	?>
	<div class="filter-radio"><?php
		foreach ($fields as $group_id => $group_fields) {
			echo '<ul><li class="title">' . $category['Category']['field_group' . $group_id] . ':</li>';
			echo '<li><input type="checkbox" name="type" value="1" id="group_' . $group_id . '" /> <label for="group_' . $group_id . '">Все подряд</label></li>';
			foreach ($group_fields as $key => $value) {
				echo '<li><input class="filter-' . $group_id . '" type="checkbox" name="type" value="' . $key . '" id="field_' . $key . '" /> <label for="field_' . $key . '">' . $value . '</label></li>';
			}
			echo '</ul>';
		}
	?></div>
</div>
<div class="clear"></div>
<div class="desk">
	<div class="top"></div>
	<div class="middle">
		<div class="products-list clearfix"><?php
			echo $this->element('category_products');
		?></div>
	</div>
	<div class="bottom"><p><span>Сбросить фильтры</span><a href="javascript:void(0);" onclick="clear_filter();"><em>Сбросить фильтры</em></a></p></div>
</div>
<script type="text/javascript">
<!--
$(function(){
	<?php if (!empty($banners)) { ?>
	$('#slides').slides({
		preload: true,
		preloadImage: '/img/loading.gif',
		play: 5000,
		pause: 2500,
		hoverPause: true
	});
	<?php } ?>
	$('.filter-1,.filter-2,.filter-3').click(reload_products);
	$('#group_1').click(function(){
		if ($(this).prop('checked')) {
			$('.filter-1').attr('disabled', 'disabled');
		}
		else {
			$('.filter-1').removeAttr('disabled');
		}
		reload_products();
	});
	$('#group_2').click(function(){
		if ($(this).prop('checked')) {
			$('.filter-2').attr('disabled', 'disabled');
		}
		else {
			$('.filter-2').removeAttr('disabled');
		}
		reload_products();
	});
	$('#group_3').click(function(){
		if ($(this).prop('checked')) {
			$('.filter-3').attr('disabled', 'disabled');
		}
		else {
			$('.filter-3').removeAttr('disabled');
		}
		reload_products();
	});
});
function clear_filter() {
	$('.filter-radio input').attr('checked', false);
	$('.filter-1,.filter-2,.filter-3').removeAttr('disabled');
	reload_products();
}
function reload_products() {
	$('.loader').show();
	var fields = {'group1': [], 'group2': [], 'group3': []};
	if (!$('#group_1').prop('checked')) {
		$('.filter-1').each(function(){
			if ($(this).prop('checked')) {
				fields['group1'][fields['group1'].length] = $(this).val();
			}
		});
	}
	if (!$('#group_2').prop('checked')) {
		$('.filter-2').each(function(){
			if ($(this).prop('checked')) {
				fields['group2'][fields['group2'].length] = $(this).val();
			}
		});
	}
	if (!$('#group_3').prop('checked')) {
		$('.filter-3').each(function(){
			if ($(this).prop('checked')) {
				fields['group3'][fields['group3'].length] = $(this).val();
			}
		});
	}
	$.ajax({
		url: '<?php echo $this->here; ?>',
		dataType: 'html',
		type: 'post',
		data: {'data[Product][fields]': fields},
		success: function(data) {
			$('.products-list').html(data);
		},
		failure: function() {
			$('.loader').hide();
		}
	})
}
//-->
</script>