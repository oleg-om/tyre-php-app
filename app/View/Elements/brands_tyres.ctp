<div class="boxNav">
	<h3>Производители шин</h3>
	<ul><?php $i=1;
		foreach ($brands_tyres as $item) {
			echo '<li>' . $this->Html->link($item['Brand']['title'], array('controller' => 'tyres', 'action' => 'brand', 'slug' => $item['Brand']['slug'], '?' => array('mode' => 'block')));
			echo '</li>';
		if ($i == 10) echo '</ul>' . '<ul class="hidden">';
		$i++;
		}
	?></ul>
	<a class="allLink moreBrands" href="#">показать все бренды</a>
	<a class="allLink moreBrands hidden" href="#">скрыть бренды</a>
</div>
