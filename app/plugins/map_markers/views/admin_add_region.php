<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
$lang = rtrim(LANG_ALIAS,'/');
?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		  			<strong><?php echo __("To add Region","map_markers"); ?></strong><br>
		  			<?php echo __("Select polytool","map_markers"); ?> 
		  			<span style="display: inline-block;"><div style="width: 16px; height: 16px; overflow: hidden; position: relative;"><img alt="" src="https://maps.gstatic.com/mapfiles/drawing.png" draggable="false" style="position: absolute; left: 0px; top: -64px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none; width: 16px; height: 192px;"></div></span> <?php echo __("on the map","map_markers"); ?>
		  			<ul>
		  				<li><?php echo __("Add poly points by clicking on the map","map_markers"); ?></li>
		  				<li><?php echo __("After poly area is completed a window will popup","map_markers"); ?></li>
		  				<li><?php echo __("Add Region name, description and color","map_markers"); ?></li>
		  				<li><?php echo __("Click save button","map_markers"); ?></li>
		  			</ul>
		  		</div>
		  		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		  			<strong><?php echo __("Edit Region","map_markers"); ?></strong><br>
		  			<?php echo __("Select handtool","map_markers"); ?> 
		  			<span style="display: inline-block;"><div style="width: 16px; height: 16px; overflow: hidden; position: relative;"><img alt="" src="https://maps.gstatic.com/mapfiles/drawing.png" draggable="false" style="position: absolute; left: 0px; top: -80px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none; width: 16px; height: 192px;"></div></span> <?php echo __("on the map","map_markers"); ?>
		  			<ul>
		  				<li><?php echo __("Click on the Region area","map_markers"); ?></li>
		  				<li><?php echo __("Edit Region name, description or color","map_markers"); ?></li>
		  				<li><?php echo __("Click save button","map_markers"); ?></li>
		  			</ul>
		  		</div>
		  		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		  			<strong><?php echo __("Delete Region","map_markers"); ?></strong><br>
		  			<?php echo __("Select any tool","map_markers"); ?> 
		  			<span style="display: inline-block;"><div style="width: 16px; height: 16px; overflow: hidden; position: relative;"><img alt="" src="https://maps.gstatic.com/mapfiles/drawing.png" draggable="false" style="position: absolute; left: 0px; top: -80px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none; width: 16px; height: 192px;"></div></span> 
		  			<span style="display: inline-block;"><div style="width: 16px; height: 16px; overflow: hidden; position: relative;"><img alt="" src="https://maps.gstatic.com/mapfiles/drawing.png" draggable="false" style="position: absolute; left: 0px; top: -64px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none; width: 16px; height: 192px;"></div></span> <?php echo __("on the map","map_markers"); ?>
		  			<ul>
		  				<li><?php echo __("Right click on the Region area","map_markers"); ?></li>
		  				<li><?php echo __("Click Remove button","map_markers"); ?></li>
		  			</ul>
		  		</div>
		  	</div>
		</div>
	</div>
</div>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div id="the_map" style="height: 700px" class="pos-rel"></div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hide">
					<div id="maps-region-info-box">
					<label><?php echo __("Region name","map_markers"); ?></label>
					<input type="" name="" id="rname-r-map" class="form-control"><br>
					<label><?php echo __("Region Description","map_markers"); ?></label>
					<textarea id="rdesc-r-map" class="form-control"></textarea>
					<div id="poly" class="hide"></div><br>
					<label><?php echo __("Color","map_markers"); ?></label>
					<select id="rcole-r-map" class="form-control">
						<option value=""><?php echo __("Select a color","map_markers"); ?></option>
						<?php echo $form->options($option_colors); ?>
					</select>
					<div class="text-center"><button id="save-region" class="btn btn-success"><?php echo __("Save","map_markers"); ?></button></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="https://apis.google.com/js/platform.js" async defer></script> 
<script type="text/javascript">
var loader = '<div class="loaderwrap absolute overlay"><div class="the-loader s2 load-center text-white"></div></div>';
var loader2 = '<div class="loaderwrap fixed overlay"><div class="the-loader s2 load-center text-white"></div></div>';
var marker = null;
var colors = <?php echo json_encode($region_colors) ?>;

function loadScript() {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://maps.googleapis.com/maps/api/js?key=<?php echo $map_api_key['value'] ?>&language=<?php echo $lang ?>&libraries=geometry,places,drawing&callback=init';
        document.body.appendChild(script);
    }


function init() {
	var b = new google.maps.LatLng(5.829666666666666,-55.14586111111111);
	var a = {zoom: 12, center: b, mapTypeId: google.maps.MapTypeId.ROADMAP,scaleControl: true,overviewMapControl: true,overviewMapControlOptions: { opened: true }};
    map = new google.maps.Map(document.getElementById("the_map"), a);
    var infoWindow = new google.maps.InfoWindow();
    // Add drawing manager to map
    var drawingManager = new google.maps.drawing.DrawingManager({
    drawingMode: google.maps.drawing.OverlayType.POLYGON,
    drawingControl: true,
    drawingControlOptions: {
      position: google.maps.ControlPosition.TOP_CENTER,
      drawingModes: ['polygon']
    },
    polygonOptions: {
      fillColor: '#cccccc',
      fillOpacity: 0.7,
      strokeWeight: 2,
      clickable: true,
      editable: true,
      zIndex: 1
    }
  });
 drawingManager.setMap(map);
// When drawing is completed
google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
    var p ='[';
    if (event.type == google.maps.drawing.OverlayType.POLYGON) {
      console.log('polygon path array', event.overlay.getPath().getArray());
      $.each(event.overlay.getPath().getArray(), function(key, latlng){
        var lat = latlng.lat();
        var lon = latlng.lng();
        p += '{lat:' + lat +', lng:'+ lon +'},';
      });
    }
    p = p.substr(0,p.length-1) + '];';
    $('#poly').text(p);

	var cont = $('#maps-region-info-box').html();
    var vertices = event.overlay.getPath();
	var bounds = new google.maps.LatLngBounds();
    vertices.forEach(function(xy,i){
        bounds.extend(xy);
    });

    infoWindow.setContent(cont);
    infoWindow.setPosition(bounds.getCenter()); 
    drawingManager.setDrawingMode(null);
    infoWindow.open(map);

    var ns = event.overlay;
// Edit poly from region
    google.maps.event.addListener(ns.getPath(), 'set_at', function (index, obj) {
     	var np ='[';
        $.each(ns.getPath().getArray(), function(key, latlng){
        var lat = latlng.lat();
        var lon = latlng.lng();
        //console.log(lat, lon); 
        np += '{lat:' + lat +', lng:'+ lon +'},';
      });
        np = np.substr(0,np.length-1) + '];';
        $('#poly').text(np);
	    drawingManager.setDrawingMode(null);
	    infoWindow.open(null);

     });
// Add poly to region
    google.maps.event.addListener(ns.getPath(), 'insert_at', function (index, obj) {
     	var np ='[';
        $.each(ns.getPath().getArray(), function(key, latlng){
        var lat = latlng.lat();
        var lon = latlng.lng();
        //console.log(lat, lon); 
        np += '{lat:' + lat +', lng:'+ lon +'},';
      });
        np = np.substr(0,np.length-1) + '];';
        $('#poly').text(np);
	    drawingManager.setDrawingMode(null);
	    infoWindow.open(null);

     });
    google.maps.event.addListener(ns, 'rightclick', function (index, obj) {
    	// alert(1);
    	var nns = this;
    	// this.setMap(null);
    	infoWindow.setContent('<div><a class="btn btn-danger remove-overlay"><?php echo __("Remove","map_markers"); ?></a> <a class="btn btn-success remove-cancel"><?php echo __("Cancel","map_markers"); ?></a></div>');
	    infoWindow.setPosition(bounds.getCenter()); 
	    drawingManager.setDrawingMode(null);
	    infoWindow.open(map);
	    $('.remove-overlay').on('click', function(){
	    	// alert(2);
	    	nns.setMap(null);
	    	infoWindow.open(null);
	    });

	    $('.remove-cancel').on('click', function(){
	    	// alert(2);
	    	infoWindow.open(null);
	    });
	   
    });
// Click op the completed region
	google.maps.event.addListener(ns, 'click', function (index, obj) {
	 	var np ='[';
        $.each(ns.getPath().getArray(), function(key, latlng){
        var lat = latlng.lat();
        var lon = latlng.lng();
        //console.log(lat, lon); 
        np += '{lat:' + lat +', lng:'+ lon +'},';
      });
        np = np.substr(0,np.length-1) + '];';
        $('#poly').text(np);
        var ncont = $('#maps-region-info-box').html();
        infoWindow.setContent(ncont);
	    infoWindow.setPosition(bounds.getCenter()); 
	    drawingManager.setDrawingMode(null);
	    infoWindow.open(map);
    }); 
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
var cont = '<div id="maps-region-info-box">';
cont += '<label><?php echo __("Region name","map_markers"); ?></label><input type="" name="" id="rname-r-map" class="form-control" value="<?php echo $value['region_data']['name'];?>"><br>';
cont += '<label><?php echo __("Region Description","map_markers"); ?></label><textarea id="rdesc-r-map" class="form-control"><?php echo $value['region_data']['description'];?></textarea><br>';
cont += '<label><?php echo __("Color","map_markers"); ?></label>';
cont += '<select id="rcole-r-map" class="form-control"><option><?php echo __("Select a color","map_markers"); ?></option>';
<?php foreach ($option_colors as $k => $v) { ?>
	<?php if($k == $value['color'] ){ ?>
	cont += '<option value="<?php echo $k; ?>" selected><?php echo $v; ?></option>';
	<?php } else { ?>
	cont += '<option value="<?php echo $k; ?>"><?php echo $v; ?></option>';
	<?php } ?>
<?php } ?>
cont += '</select>';
cont += '<div class="text-center"><button data-id="<?php echo $value['id'] ?>" id="save-region" class="btn btn-success"><?php echo __("Save","map_markers"); ?></button></div></div>';
infoWindow.setContent(cont);
infoWindow.setPosition(event.latLng);
infoWindow.open(map);
});

google.maps.event.addListener(reg<?php echo $value['id'] ?>,"rightclick",function(event) {
	var nn<?php echo $value['id'] ?> = this;
infoWindow.setContent('<div><a class="btn btn-danger remove-overlay"><?php echo __("Remove","map_markers"); ?></a> <a class="btn btn-success remove-cancel"><?php echo __("Cancel","map_markers"); ?></a></div>');
infoWindow.setPosition(event.latLng);
infoWindow.open(map);
$('body').on('click', '.remove-overlay', function(){
// alert(2);
	$('#the_map').append(loader);
	nn<?php echo $value['id'] ?>.setMap(null);
	infoWindow.open(null);
	$.getJSON( Jsapi+"map-markers/remove-region/<?php echo $value['id'] ?>" , function( data ) {
			console.log(data);
			if(data.ok == 'success'){
				// location.reload();
				$('body').find('.loaderwrap').remove();
			}	
		});
	});

$('body').on('click', '.remove-overlay', function(){
	// alert(2);
	infoWindow.open(null);
	});

$('body').on('click', '.remove-cancel', function(){
	// alert(2);
	infoWindow.open(null);
	});

});

<?php } ?>
// End Regions
}



window.onload = loadScript;


$('body').on('click','#save-region', function(e){
e.preventDefault();
$('.form-error').removeClass('form-error');
var ee =  true;
var p = $(this).parent().parent().parent().parent().parent();
var a = $('#rname-r-map');
var b = $('#rdesc-r-map');
var c = $('#rcole-r-map');
var d = $('#poly').text();
var i = $(this).attr('data-id');
var j = a.val();
var k = b.val();
var l = $('#rcole-r-map option:selected').val();
if(i == undefined) {
	i = 0;
}
if(j.replace(/\s+/g, '') == '') {
		a.val('');
		a.addClass('form-error');
		ee = false;
}

if(l.replace(/\s+/g, '') == '') {
		c.addClass('form-error');
		ee = false;
}

if(ee){
		$('#regions-table').append(loader);
		p.remove();
		var fdata = {
			'data[name]' : j,
			'data[id]' : i,
			'data[description]' : k,
			'data[color]' : l,
			'data[coordinates]' : d
		}
		$.getJSON( Jsapi+'map-markers/add-region/', fdata , function( data ) {
			console.log(data);
		if(data.ok == 'success'){
			location.reload();

			$('body').find('.loaderwrap').remove();
		}
		
	    });
	}

});

</script>    