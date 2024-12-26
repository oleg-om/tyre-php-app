<?php
$submenus = array();
if (isset($menu_sections[$section]['menu_items'][$submenu]['submenu'])) {
	$submenus = $menu_sections[$section]['menu_items'][$submenu]['submenu'];
}
if (count($submenus) > 0) {
?>
<ul class="dropdown">
<?php foreach ($submenus as $i => $submenu) { ?>
	<li>
		<span><?php echo $submenu['title'];  print_r(json_encode()); ?></span>
		<div class="shadowed"><div class="tl"></div><div class="tr"></div><div class="bl"></div><div class="br"></div><div class="t"><div class="b"><div class="l"><div class="r"><div class="bg">
			<ul><?php
				foreach ($submenu['items'] as $item) {
                    $link = $item['link'];
                    str_replace('.0', '', $size);

                    if ($item['id']) {
                        $exploded_url = explode("/", $this->request->url);
                        $queries = array();

                        foreach ($exploded_url as $key => $value) {
                            list($query_name, $query_value) = explode(":", $value);
                            $queries[$query_name] = $query_value;
                        }

                        $link['?'] = array($item['id'] => $queries[$item['id']]);
                    }
					echo '<li>' . $this->Html->image('admin/sections/' . $item['icon'] . '.png', array('alt' => $item['title'], 'class' => 'v-middle')) . $this->Html->link($item['title'], $link, null, null, false) . '</li>';
				}
			?></ul>
		</div></div></div></div></div></div>
	</li>
<?php } ?>
<?php
}
?>
</ul>
<div class="clear"></div>