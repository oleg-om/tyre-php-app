<?php
if (!isset($bottom)) {
	$bottom = false;
}
if (!isset($show_limits)) {
	$show_limits = false;
}
?>
<div class="pager-filter<?php echo $bottom ? ' bottom' : ''; ?>">
	<?php
		$params = $this->Paginator->params();
		if ($params['pageCount'] > 1) {
			echo '<div class="page">';
			echo $this->Paginator->prev('&laquo;', array('tag' => false, 'escape' => false, 'class' => 'prev'), null, array('tag' => 'span', 'escape' => false, 'class' => 'prev'));
			echo $this->Paginator->numbers(array('separator' => '', 'modulus' => 4, 'tag' => null, 'currentTag' => 'em'));
			echo $this->Paginator->next('&raquo;', array('tag' => false, 'escape' => false, 'class' => 'next'), null, array('tag' => 'span', 'escape' => false, 'class' => 'next'));
			echo '</div>';
		}
		if ($show_limits) {
			echo $this->element('page_limit', array('url' => $url));
		}
	?>
	<div class="clear"></div>
</div>
