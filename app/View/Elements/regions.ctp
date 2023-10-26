<?php
if (!isset($active_region)) {
	$active_region = null;
}
if (!isset($active_city)) {
	$active_city = null;
}
?>
<div id="left">
	<div class="leftNav">
		<div class="boxNav regions">
			<ul><?php
				foreach ($regions as $region) {
					$class = 'closed';
					if ($region['DeliveryRegion']['id'] == $active_region) {
						$class = 'opened';
					}
					echo '<li class="' . $class . '"><a href="javascript:void(0);" class="handler">' . h($region['DeliveryRegion']['title']) . '</a><ul>';
					foreach ($region['DeliveryCity'] as $city) {
						$class = null;
						if ($city['id'] == $active_city) {
							$class = 'activ';
						}
						echo '<li>' . $this->Html->link($city['title'], array('controller' => 'pages', 'action' => 'city', 'slug' => $city['slug']), array('class' => $class)) . '</li>';
					}
					echo '</ul></li>';
				}
			?></ul>
		</div>
	</div>
</div>
<script type="text/javascript">
<!--
$('.handler').click(function(){
	if ($(this).parent().hasClass('closed')) {
		$(this).parent().prop('class', 'opened');
	}
	else {
		$(this).parent().prop('class', 'closed');
	}
});
//-->
</script>