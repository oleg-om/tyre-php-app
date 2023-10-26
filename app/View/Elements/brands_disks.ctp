<div class="boxNav">
	<h3>Бренды дисков</h3>
	<ul><?php $i=1;
		foreach ($brands_disks as $item) {
			echo '<li>' . $this->Html->link($item['Brand']['title'], array('controller' => 'disks', 'action' => 'brand', 'slug' => $item['Brand']['slug']));
			echo '</li>';
		if ($i == 10) echo '</ul>' . '<ul class="hidden">';
		$i++;
		}
	?></ul>
	<a class="allLink moreBrands" href="#">показать все бренды</a>
	<a class="allLink moreBrands hidden" href="#">скрыть бренды</a>
</div>