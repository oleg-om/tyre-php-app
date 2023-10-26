<h2 class="title"><?php echo h($page['Page']['title']); ?></h2>
<?php echo $page['Page']['content']; ?>
<?php if ($page['Page']['gallery']) { ?>
<script type="text/javascript">
$(function(){
	$('#myGallery').galleryView();
	$('#myGallery2').galleryView();
	$('ul.tabs li').css('cursor', 'pointer');
	$('ul.tabs.tabs1 li').click(function(){
		var thisClass = this.className.slice(0,2);
		$('div.t1').hide();
		$('div.t2').hide();
		$('div.' + thisClass).show();
		$('ul.tabs.tabs1 li').removeClass('tab-current');
		$(this).addClass('tab-current');
	});
	$('ul.tabs.tabs1 li:first').click();
});
</script>
<?php } ?>