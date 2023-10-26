<h2 class="title"><?php echo h($station['Station']['title']); ?></h2>
<p><strong>Телефон:</strong> <?php echo h($station['Station']['phone']); ?></p>
<div id="map"></div>
<?php echo $station['Station']['content']; ?>
<script type="text/javascript">
<!--
var map, marker;
ymaps.ready(map_init);
function map_init() {
	var latitude = '<?php echo $station['Station']['latitude']; ?>', longitude = '<?php echo $station['Station']['longitude']; ?>', zoom = '<?php echo $station['Station']['zoom']; ?>';
	map = new ymaps.Map($('#map')[0], {
		center: [latitude, longitude],
		zoom: zoom
	});
	marker = new ymaps.Placemark([latitude, longitude], { 
		balloonContent: '' 
	});
	map.geoObjects.add(marker);
	map.controls.add(
		new ymaps.control.ZoomControl()
	);
}
//-->
</script>