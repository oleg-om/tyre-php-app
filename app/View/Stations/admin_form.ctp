<?php
$this->Backend->setOptions(array(
	'model' => 'Station',
	'controller' => 'stations'
));
echo $this->Backend->getFormHeader();
$this->Backend->addTab('main', __d('admin_stations', 'tab_main'));
$this->Backend->addCheckbox('is_active', array(
	'label' => __d('admin_stations', 'label_is_active'),
	'acronym' => __d('admin_stations', 'acronym_is_active'),
	'disabled' => !$is_deletable
), 'main');
$this->Backend->addText('title', array(
	'label' => __d('admin_stations', 'label_title'),
	'acronym' => __d('admin_stations', 'acronym_title'),
	'required' => true,
	'sluggable' => true
), 'main');
$this->Backend->addText('slug', array(
	'label' => __d('admin_stations', 'label_slug'),
	'acronym' => __d('admin_stations', 'acronym_slug'),
	'required' => true,
	'disabled' => !$is_deletable
), 'main');
$this->Backend->addText('phone', array(
	'label' => __d('admin_stations', 'label_phone'),
	'required' => true
), 'main');
$this->Backend->addText('places', array(
	'label' => __d('admin_stations', 'label_places'),
	'default' => 1,
	'required' => true
), 'main');
$this->Backend->addText('meta_title', array(
	'label' => __d('admin_stations', 'label_meta_title')
), 'main');
$this->Backend->addText('meta_keywords', array(
	'label' => __d('admin_stations', 'label_meta_keywords')
), 'main');
$this->Backend->addTextarea('meta_description', array(
	'label' => __d('admin_stations', 'label_meta_description')
), 'main');
$this->Backend->addTextarea('content', array(
	'label' => __d('admin_stations', 'label_content'),
	'editor' => true
), 'main');
$this->Backend->addTab('map', __d('admin_stations', 'tab_map'));
$this->Backend->addHtml('<div class="item_div"><label class="caption" for="StationMap"><acronym title="' . __d('admin_stations', 'label_map') . '">' . __d('admin_stations', 'label_map') . '</acronym></label><div id="map"></div></div>', 'map');
$this->Backend->addHidden('id');
$this->Backend->addHidden('latitude', array('default' => CONST_LATITUDE));
$this->Backend->addHidden('longitude', array('default' => CONST_LONGITUDE));
$this->Backend->addHidden('zoom', array('default' => CONST_ZOOM));
$this->Backend->addHidden('action', array(
	'type' => 'hidden',
	'value' => 'apply',
	'id' => 'frm_action'
));
echo $this->Backend->getFormContent();
echo $this->Backend->getFormFooter();
echo $this->Backend->getScript();
?>
<script type="text/javascript">
<!--
var map, marker;
$(function(){
	$('#tab_map').click(function(){
		if (map) {
			map.container.fitToViewport();
		}
	});
});
ymaps.ready(map_init);
function map_init() {
	var latitude = $('#StationLatitude').val(), longitude = $('#StationLongitude').val(), zoom = $('#StationZoom').val();
	map = new ymaps.Map($('#map')[0], {
		center: [latitude, longitude],
		zoom: zoom
	});
	marker = new ymaps.Placemark([latitude, longitude], { 
		balloonContent: 'Перетащите метку' 
	}, {
		draggable: true
	});
	map.events.add('boundschange', function (e) {
		$('#StationZoom').val(map.getZoom());
	});
	marker.events.add('dragend', function (e) {
		var coords = marker.geometry.getCoordinates()
		$('#StationLatitude').val(coords[0]);
		$('#StationLongitude').val(coords[1]);
	});
	map.geoObjects.add(marker);
	marker.events.add('dragend', function (e) {
		var coords = marker.geometry.getCoordinates()
		$('#StationLatitude').val(coords[0]);
		$('#StationLongitude').val(coords[1]);
	});
	map.controls.add(
		new ymaps.control.ZoomControl()
	);
}
//-->
</script>