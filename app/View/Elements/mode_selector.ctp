<?php
if (!isset($mode)) {
	$mode = 'block';
}
if (!isset($tyres_switch)) {
	$tyres_switch = false;
}
if (!isset($akb_switch)) {
    $akb_switch = false;
}
$modes = array(
	'block' => '<img src="/img/block.gif" alt="блоками" />',
	'list' => '<img src="/img/list.gif" alt="списком" />',
	'table' => '<img src="/img/table.gif" alt="таблицей" />'
);
if ($akb_switch == true) {
    $modes = array(
        'list' => '<span class="mode__brands">Бренды</span>',
        'block' => '<img src="/img/block.gif" alt="блоками" />',
        'table' => '<img src="/img/table.gif" alt="таблицей" />'
    );
}
$seasons = array(
	'summer' => 'Летние',
	'winter' => 'Зимние',
	'all' => 'Всесезонные'
);
$seasons_order = array(
	'summer' => CONST_SEASON_SUMMER_ORDER,
	'winter' => CONST_SEASON_WINTER_ORDER,
	'all' => CONST_SEASON_ALL_ORDER
);
asort($seasons_order);
$ordered_seasons = array();
foreach ($seasons_order as $key => $order) {
	$ordered_seasons[$key] = $seasons[$key];
}
$seasons = $ordered_seasons;
$active = key($seasons);
$s = array();
if (isset($available_seasons)) {
	foreach ($available_seasons as $season) {
		$s[$season] = $seasons[$season];
	}
	if (!isset($s[$active])) {
		$active = key($s);
	}
}
else {
	$s = $seasons;
}
$seasons = $s;
$ordered_seasons = array();
foreach ($seasons_order as $key => $order) {
	if (isset($seasons[$key])) {
		$ordered_seasons[$key] = $seasons[$key];
	}
}
$seasons = $ordered_seasons;
if (!isset($has_params)) {
	$has_params = true;
}
$show_available = false;
if (!empty($brand['Brand']['slug']) && !$has_params) {
	$show_available = true;
}
$has_trucks = false;
foreach ($models as $item) {
	if ((!empty($item['BrandModel']['auto']) && $item['BrandModel']['auto'] == 'trucks') || (isset($item['Product'][0]) && $item['Product'][0]['auto'] == 'trucks')) {
		$has_trucks = true;
		break;
	}
}
?>

 
	
	 
 

<div class="filter-prod<?php echo $tyres_switch ? ' filter-prod2' : ''; ?>">
	<div class="float-l">
		<?php if ($tyres_switch) { ?>
			
			<div id="switch"><?php
				foreach ($seasons as $key => $value) {
					$class = '';
					if ($key == $active) {
						$class = ' class="active"';
					}
					echo '<a' . $class . ' href="javascript:void(0);" id="tab-' . $key . '" onclick="show_season(\'' . $key . '\');">' . $value . '</a>';
				}
				if ($show_available) {
					if ($has_trucks) {
						echo '<a href="javascript:void(0);" id="tab-trucks" onclick="show_season(\'trucks\');">Грузовые</a>';
					}
					echo '<div class="available-box">';
					echo '<a href="javascript:void(0);" id="tab-yes" onclick="show_season(\'yes\');"><img src="/img/plus-tab.gif" alt="Есть в наличии" /></a>';
					echo '<a href="javascript:void(0);" id="tab-no" onclick="show_season(\'no\');"><img src="/img/minus-tab.gif" alt="Нет в наличии" /></a>';
					echo '</div>';
				}
			?></div>
			<div class="clear"></div>
		<?php } else { ?>
		<?php
            $sort_fields = array(
                'name' => 'по названию',
                'price_asc' => 'по цене',
//				'price_desc' => 'от дорогих к дешевым',
            );

            if ($popular_sort == true && CONST_ENABLE_POPULAR_SORT == '1') {
                $sort_fields = array(
                    'popular' => 'по популярности',
                    'price_asc' => 'по цене',
                    'name' => 'по названию',
                );
            }

			if (!isset($sort)) {
				$sort = 'price_asc';
			}
		?>
		<div class="sortblock">
			<strong>Сортировка:</strong>
			<div class="sort">
				<?php
					$sort_filter = $url['?'];
					$sort_filter['sort'] = $sort;
					$sort_url = $url;
					$sort_url['?'] = $sort_filter;
					echo $this->Html->link($sort_fields[$sort], $sort_url);
				?><em></em>
				<ul class="sub-sort"><?php
					foreach ($sort_fields as $key => $value) {
						if ($key != $sort) {
							$sort_filter = $url['?'];
							$sort_filter['sort'] = $key;
							$sort_url = $url;
							$sort_url['?'] = $sort_filter;
							echo '<li>' . $this->Html->link($value, $sort_url) . '</li>';
						}
					}
				?></ul>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="filter"><?php
		$page = null;
		if (isset($this->params['named']['page']) && $this->params['named']['page'] > 0) {
			$page = $this->params['named']['page'];
		}
		foreach ($modes as $key => $value) {
			$class = 'mode-switch';
			if ($mode == $key) {
				$class = 'mode-switch-activ';
			}
			$mode_filter = $url['?'];
			$mode_filter['mode'] = $key;
			$mode_url = $url;
			$mode_url['?'] = $mode_filter;
			if (!empty($page)) {
				$mode_url['page'] = $page;
			}
			echo $this->Html->link($value, $mode_url, array('class' => $key . ' ' . $class, 'escape' => false));
		}
	?></div>
	<div class="clear"></div>
</div>
<?php if ($tyres_switch) { ?>
<div class="modelsinfo">
	<div class="float-l">
		<div id="tyres-summer"<?php if ($active != 'summer') echo ' style="display:none;"'; ?> class="season-tab">
			<div title="Лето" class="productSeason">Лето</div>
			<span>Летние шины <strong><?php echo ($brand['Brand']['title']); ?></strong></span>
		</div>
		<div id="tyres-winter"<?php if ($active != 'winter') echo ' style="display:none;"'; ?> class="season-tab">
			<div title="Зима" class="productSeason2">Зима</div>
			<span>Зимние шины <strong><?php echo ($brand['Brand']['title']); ?></strong></span>
		</div>
		<div id="tyres-all"<?php if ($active != 'all') echo ' style="display:none;"'; ?> class="season-tab">
			<div title="Всесезонные" class="productSeason3">Всесезонные</div>
			<span>Всесезонные шины <strong><?php echo ($brand['Brand']['title']); ?></strong></span>
		</div>
		<div id="tyres-yes" style="display:none;" class="season-tab">
			<span><img src="/img/plus2.gif" alt="есть в наличии" /></span>
			<span>есть в наличии</span>
		</div>
		<div id="tyres-no" style="display:none;" class="season-tab">
			<span><img src="/img/minus2.gif" alt="нет в наличии" /></span>
			<span>нет в наличии</span>
		</div>
		<div id="tyres-trucks" style="display:none;" class="season-tab">
			<span><img src="/img/tyres-trucks.png" alt="грузовые шины" /></span>
			<span>грузовые шины</span>
		</div>
	</div>
	<div class="float-r">
		<?php
			$sort_fields = array(
				'name' => 'по названию',
				'price_asc' => 'по цене',
				'price_desc' => 'от дорогих к дешевым',
                'popular' => 'по популярности',
			);
			if (!isset($sort)) {
				$sort = 'price_asc';
			}
		?>
		<div class="sortblock">
			<strong>Сортировка:</strong>
			<div class="sort">
				<?php
					$sort_filter = $url['?'];
					$sort_filter['sort'] = $sort;
					$sort_url = $url;
					$sort_url['?'] = $sort_filter;
					echo $this->Html->link($sort_fields[$sort], $sort_url);
				?><em></em>
				<ul class="sub-sort"><?php
					foreach ($sort_fields as $key => $value) {
						if ($key != $sort) {
							$sort_filter = $url['?'];
							$sort_filter['sort'] = $key;
							$sort_url = $url;
							$sort_url['?'] = $sort_filter;
							echo '<li>' . $this->Html->link($value, $sort_url) . '</li>';
						}
					}
				?></ul>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<script type="text/javascript">
<!--
$(function(){
	//show_season('<?php //echo $active; ?>//');
    show_season('yes');
});
function show_season(s) {
	$('.season-tab').hide();
	$('#tyres-' + s).show();
	$('#switch a').removeClass('active');
	$('#tab-' + s).addClass('active');
	if (s == 'summer') {
		$('.season-winter').hide();
		$('.season-all').hide();
		$('.season-summer').show();
		$('.season-trucks').hide();
	}
	else if (s == 'winter') {
		$('.season-summer').hide();
		$('.season-all').hide();
		$('.season-winter').show();
		$('.season-trucks').hide();
	}
	else if (s == 'yes') {
		$('.season-no').hide();
		$('.season-yes').show();
	}
	else if (s == 'no') {
		$('.season-yes').hide();
		$('.season-no').show();
	}
	else if (s == 'trucks') {
		$('.season-cars').hide();
		$('.season-trucks').show();
	}
	else if (s == 'cars') {
		$('.season-trucks').hide();
		$('.season-cars').show();
	}
	else {
		$('.season-trucks').hide();
		$('.season-summer').hide();
		$('.season-winter').hide();
		$('.season-all').show();
	}
}
//-->
</script>
<?php } ?>