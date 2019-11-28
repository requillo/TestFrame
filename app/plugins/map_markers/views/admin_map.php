<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$lang = rtrim(LANG_ALIAS,'/');
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="pull-left">
				<select class="form-control-inline from-map">
					<option><?php echo __('From', 'map_maker') ?></option>
					<?php echo $form->options($dealer_options); ?>
				</select>
			</div>
			<div class="pull-left">
				<select class="form-control-inline to-map">
					<option><?php echo __('To', 'map_maker') ?></option>
					<?php echo $form->options($dealer_options); ?>
				</select>
			</div>
			<div class="pull-left inl-elm-gas">by</div>
			<div class="pull-left inl-elm-gas">
			<input type="radio" name="radio" id="r1" class="flat" value="1" checked=""> <label for="r1">Air</label>
			</div>
			<div class="pull-left inl-elm-gas">or</div>
			<div class="pull-left inl-elm-gas">
			<input type="radio" name="radio" id="r2" class="flat" value="2"> <label for="r2">Driving</label>
			</div>
			<div class="pull-left">
				<a href="" class="btn btn-success reset-map hide"><i class="fa fa-refresh" aria-hidden="true"></i> Reset map</a>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="load-map-distance"></div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div id="all_markers" style="height: <?php echo $map_height['value'] ?>px;"></div>
</div>
	<?php // print_r($stations) ;?>
<script type="text/javascript">
	// Set vars
var polyline,marker,i;
function loadScript() {
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = 'https://maps.googleapis.com/maps/api/js?key=<?php echo $map_api_key['value'] ?>&language=<?php echo $lang ?>&libraries=geometry,places,drawing&callback=init';
	document.body.appendChild(script);
}
function init() {
	// Set default vars
	var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;
	var markers = [];
	var path = [];
	var b = new google.maps.LatLng(5.508462212303641,-55.20884609206098);
	var a = {zoom: 10, center: b, mapTypeId: google.maps.MapTypeId.ROADMAP,scaleControl: true,overviewMapControl: true,overviewMapControlOptions: { opened: true }};
    var infowindow = new google.maps.InfoWindow();
    var line = [];
	var stations = [
<?php // PHP set js array for all stations
$as = count($stations) - 1;
for ($i = 0; $i <= $as; $i++) {
		if($i == $as) {
			echo "['". $stations[$i]['station_data']['dealer'] ."',". $stations[$i]['latitude']. ','. $stations[$i]['longitude']. ','. $stations[$i]['station']. ",'". $stations[$i]['map_info']."']"."\n";
		} else {
			echo "['". $stations[$i]['station_data']['dealer'] ."',". $stations[$i]['latitude']. ','. $stations[$i]['longitude']. ','. $stations[$i]['station']. ",'". $stations[$i]['map_info']."'],"."\n";
		}
} ?>
	];
	var iconBase = '<?php echo URL.'media/uploads/' ?>';
	var icons = {
<?php // PHP set js array for all map icons
foreach ($icons as $key => $value) {
			$value = str_replace('-', '/', $value);
			echo $key .' : '. "'$value',"."\n";
} ?>
	}
// initiate the map
map = new google.maps.Map(document.getElementById("all_markers"), a);
add_markers(stations,iconBase,icons,infowindow,map);
// Distance for select change;
$('.from-map, .to-map').on('change', function(){
	var from = $('.from-map option:selected').val();
	var to = $('.to-map option:selected').val();
	var a = $('.from-map option:selected').text();
	var b = $('.to-map option:selected').text();
	var fd = from.split(',');
	var td = to.split(',');
	var d = [{'lat':fd[0],'lng':fd[1]},{'lat':td[0],'lng':td[1]}];
	var m = $('.flat:checked').val();
	if(from.indexOf(",") > -1 && to.indexOf(",") > -1) {
		if($('.reset-map').hasClass('hide')){
			$('.reset-map').removeClass('hide');
		}
		if(m == 1) {
		directionsDisplay.setMap(null);
		directionsDisplay.setOptions( { suppressMarkers: true } );
		var g = new google.maps.LatLng(d[0].lat, d[0].lng);
        var f = new google.maps.LatLng(d[1].lat, d[1].lng);
        air_dist(g, f);
		} else {
		if(undefined !==polyline) {polyline.setMap(null);}
		directionsDisplay.setMap(map);
		directionsDisplay.setOptions( { suppressMarkers: true } );
		driving_dist(directionsService, directionsDisplay,from,to,a,b,icons);
		}
	}
});
// Distance for check change;
$('input.flat').on('ifChecked', function(){
	var from = $('.from-map option:selected').val();
	var to = $('.to-map option:selected').val();
	var a = $('.from-map option:selected').text();
	var b = $('.to-map option:selected').text();
	var fd = from.split(',');
	var td = to.split(',');
	var d = [{'lat':fd[0],'lng':fd[1]},{'lat':td[0],'lng':td[1]}];
	var m = $('.flat:checked').val();
	if(from.indexOf(",") > -1 && to.indexOf(",") > -1) {
		if($('.reset-map').hasClass('hide')){
			$('.reset-map').removeClass('hide');
		}
		if(m == 1) {
		directionsDisplay.setMap(null);
		directionsDisplay.setOptions( { suppressMarkers: true } );
		var g = new google.maps.LatLng(d[0].lat, d[0].lng);
        var f = new google.maps.LatLng(d[1].lat, d[1].lng);
        air_dist(g, f);
		} else {
		if(undefined !==polyline) {polyline.setMap(null);}
		directionsDisplay.setMap(map);
		directionsDisplay.setOptions( { suppressMarkers: true } );
		driving_dist(directionsService, directionsDisplay,from,to,a,b,icons);
		}
	}
});
// Reset the map
$('.reset-map').on('click', function(e){
	e.preventDefault();
	map = new google.maps.Map(document.getElementById("all_markers"), a);
	add_markers(stations,iconBase,icons,infowindow,map);
	$('select option').removeAttr('selected');
	$(this).addClass('hide');
	$('.load-map-distance').html('');
	// Regions
	<?php foreach ($Regions as $key => $value) { ?>
	var reg<?php echo $value['id'] ?>C = <?php echo $value['coordinates'] ?>

	var reg<?php echo $value['id'] ?> = new google.maps.Polygon({
		paths: reg<?php echo $value['id'] ?>C,
		strokeWeight: 0,
		fillColor: "<?php echo $value['color_code'] ?>",
		fillOpacity: 0.20});
	reg<?php echo $value['id'] ?>.setMap(map);

	google.maps.event.addListener(reg<?php echo $value['id'] ?>,"click",function(event) {
	var cont = '<div class="region_name text-success"><?php echo $value['region_data']['name'];?></div><div class="region_desc"><?php echo $value['region_data']['description'];?></div>';
	infowindow.setContent('<div class="map-info">'+cont+'</div>');
	infowindow.setPosition(event.latLng);
	infowindow.open(map);
	});

	<?php } ?>

});

// Regions
<?php foreach ($Regions as $key => $value) { ?>
var reg<?php echo $value['id'] ?>C = <?php echo $value['coordinates'] ?>

var reg<?php echo $value['id'] ?> = new google.maps.Polygon({
	paths: reg<?php echo $value['id'] ?>C,
	strokeWeight: 0,
	fillColor: "<?php echo $value['color_code'] ?>",
	fillOpacity: 0.20});
reg<?php echo $value['id'] ?>.setMap(map);

google.maps.event.addListener(reg<?php echo $value['id'] ?>,"click",function(event) {
var cont = '<div class="region_name text-success"><?php echo $value['region_data']['name'];?></div><div class="region_desc"><?php echo $value['region_data']['description'];?></div>';
infowindow.setContent('<div class="map-info">'+cont+'</div>');
infowindow.setPosition(event.latLng);
infowindow.open(map);
});

<?php } ?>

} // end init callback

// Add the stations on map, default view
function add_markers(stations,iconBase,icons,infowindow,map){
	for (i = 0; i < stations.length; i++) { 
		if(stations[i][3] in icons) {
			marker = new google.maps.Marker({
			position: new google.maps.LatLng(stations[i][1], stations[i][2]),
			icon: iconBase + icons[stations[i][3]],
			map: map,
			animation: google.maps.Animation.DROP,
		});
		} else {
			marker = new google.maps.Marker({
			position: new google.maps.LatLng(stations[i][1], stations[i][2]),
			animation: google.maps.Animation.DROP,
			map: map
		});
		}
		

		google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
				infowindow.setContent(stations[i][4]);
				infowindow.open(map, marker);
				var z = $('body').find('#slider'+i).length;
				 // initiate the slider for google maps
					$('body').find('#slider'+i).responsiveSlides({
						auto: true,
						pager: false,
						nav: true,
						speed: 500,
						maxwidth: 500,
						namespace: "centered-btns"
					});
				
			}
		})(marker, i));
	}
}
// Display driving route from 2 points en get distance
function driving_dist(directionsService, directionsDisplay,from,to,a,b) {
	directionsService.route({
		origin: from,
		destination: to,
		travelMode: 'DRIVING'
		}, function(response, status) {
		if (status === 'OK') {
			console.log(response);
			response.routes[0].legs[0].start_address = a;
			response.routes[0].legs[0].end_address = b;
			$('.load-map-distance').html('The driving distance is '+response.routes[0].legs[0].distance.text);
			directionsDisplay.setDirections(response);
		} else {
			window.alert('Directions request failed due to ' + status);
		}
	});
}
// Display air route from 2 points en get distance
function air_dist(from, to) {
	var a = [from, to];
	if(polyline !== undefined) {polyline.setMap(null);}
	polyline = new google.maps.Polyline({path: a, strokeColor: "#2a93fb", strokeOpacity: 0.5, geodesic: true, strokeWeight: 6});
	polyline.setMap(map);
	var b = new google.maps.LatLngBounds();
	b.extend(from);
	b.extend(to);
	map.fitBounds(b);
	dist = google.maps.geometry.spherical.computeDistanceBetween(from, to) / 1000;
	$('.load-map-distance').html('The Air distance is '+ dist.toFixed(1) + 'km');
}
// load google map script
window.onload = loadScript;
</script>