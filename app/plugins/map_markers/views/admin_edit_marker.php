<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
$lang = rtrim(LANG_ALIAS,'/');
if($has_data){
?>
<?php $form->create(); ?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div id="gasmap" style="height: 300px"></div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
		  		<div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
		  			<div class="featured_image">
		  				<?php if($station['station_data']['comp_image'] != '') { ?>
                        <a class="remove-comp-img text-danger" href="#"><i class="fa fa-window-close"></i></a>
		  				<img src="<?php echo get_protected_media($station['station_data']['comp_image']); ?>">
		  				<?php } else {?>
		  				<img src="<?php echo URL.default_image();?>">
		  				<?php } ?>
		  			</div>
		  			<?php $form->input('upload_doc',array('type'=>'file','label'=>'<i class="fa fa-upload" aria-hidden="true"></i> <span class="tupl">'.__('Company image','fuel_inventory').'</span> <small class="text-warning">(max 3mb)</small>')); ?>
				<input type="text" name="data[featured_image]" id="comp_image" class="hide" value="<?php echo $station['station_data']['comp_image'];?>">
				<div class="progress abs-progress hide">
					<div class="the-prog bg-danger"></div>
				</div>
		  		</div>
		  		<div class="col-lg-8 col-md-7 col-sm-6 col-xs-12">
		  			<div class="row">
						<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12">
							<select class="form-control" id="gas-station-icons" name="data[station]">
							<?php echo $form->options($icon_options, array('key' => $station['station'])) ?>
							</select>
						</div>
						<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12"><?php $form->input('dealer', array('placeholder' => __('Name','fuel_inventory'),'value'=> $station['station_data']['dealer'])) ?></div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><?php $form->input('address', array('placeholder' => __('Address','fuel_inventory'),'value'=> $station['station_data']['address'])) ?></div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><?php $form->textarea('description', array('placeholder' => __('Description','fuel_inventory'),'value'=> $station['station_data']['description'])) ?></div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><?php $form->input('latitude', array('placeholder' => __('Latitude','fuel_inventory'),'value'=> $station['latitude'])) ?></div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><?php $form->input('longitude', array('placeholder' => __('Longitude','fuel_inventory'),'value'=> $station['longitude'])) ?></div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row fuel-gallery">
							<?php if(!empty($station['station_data']['gallery'])){ ?>
							<?php foreach ($station['station_data']['gallery'] as $key => $value) {?>
						<div class="col-lg-3 col-md-4 col-sm-3 col-xs-4 done-here pos-rel">
							<img class="fuel-gallery-add" src="<?php echo get_protected_media($value) ?>"> 
							<input class="hide gall-image" type="checkbox" name="data[gallery_image][]" value="<?php echo $value?>" checked="">
							<a class="remove-gall text-danger" href="#"><i class="fa fa-window-close"></i></a>
						</div>
							<?php } ?>
							<?php } ?>
						<div class="col-lg-3 col-md-4 col-sm-3 col-xs-4 here-up">
							<input type="file" name="" id="map-gallery"><label class="btn btn-default upload-gallery"> <i class="fa fa-upload" aria-hidden="true"></i> Gallery</label>
						</div>
						</div>
						</div>
		  			</div>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<button href="#" class="btn btn-success add-gas-station pull-right"><i class="fa fa-save" aria-hidden="true"></i> <?php echo __('Save','fuel_inventory');?></button>
				</div>

		  		

			</div>
		</div>
	</div>
</div>
<?php $form->close(); ?>

	<?php // print_r($station);  ?>

<?php } else { ?>

<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><?php echo __('Sorry, we could not find any data', 'map_maker');  ?></div>
		  	</div>
		</div>
	</div>
</div>

<?php } ?>

<script type="text/javascript">
	var iconBase = '<?php echo admin_url('media/get-file/') ?>';
	var  marker;
	var icons = {
	<?php foreach ($map_icons as $key => $value) {
		echo $key .' : '. "'$value',"."\n";
	} ?>
}
function loadScript() {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://maps.googleapis.com/maps/api/js?key=<?php echo $map_api_key['value'] ?>&language=<?php echo $lang ?>&libraries=geometry,places,drawing&callback=init';
        document.body.appendChild(script);
    }


function init() {
	var b = new google.maps.LatLng(5.829666666666666,-55.14586111111111);
	var a = {zoom: 12, center: b, mapTypeId: google.maps.MapTypeId.ROADMAP,scaleControl: true,overviewMapControl: true,overviewMapControlOptions: { opened: true }};
    map = new google.maps.Map(document.getElementById("gasmap"), a);
    var latLng = new google.maps.LatLng(<?php echo $station['latitude'] ?>, <?php echo $station['longitude'] ?>);
    placeMarker(latLng, map);
    map.addListener('click', function(e) {
    	marker.setPosition(e.latLng);
   		add_latlng(e.latLng.lat(),e.latLng.lng());
	}); 
}

function placeMarker(position, map) {
	var i = $('#gas-station-icons option:selected').val();
    marker = new google.maps.Marker({
      position: position,
      map: map,
      icon: iconBase + icons[i],
      draggable: true
    });  
    map.panTo(position);
    drag_marker(marker);
    update_icon(marker);
}

function add_latlng(lat,lng){
	$('#input-latitude').val(lat);
	$('#input-longitude').val(lng);
}

function drag_marker(marker){
	 google.maps.event.addListener(marker, 'dragend', function(e) {
   		add_latlng(e.latLng.lat(),e.latLng.lng());
  });
}

function update_icon(marker){
	if(marker != null){
		$('#gas-station-icons').on('change', function(){
		marker.setIcon(iconBase + icons[$(this).val()]);
	});
	}
}
window.onload = loadScript;

function uploadData(formdata){
	var u = Jsapi+'map-markers/file-upload/';
    $('.progress').removeClass('hide');
    $('.the-prog').removeClass('bg-success');
    $('.the-prog').addClass('bg-danger');
    $('.the-prog').css({'width' : 0 + '%'});

    $.ajax({
    	xhr: function() {
			    var xhr = new window.XMLHttpRequest();
			    xhr.upload.addEventListener("progress", function(evt) {
			      if (evt.lengthComputable) {
			        var percentComplete = evt.loaded / evt.total;
			        percentComplete = parseInt(percentComplete * 100);
			        $('.the-prog').css({'width' : percentComplete + '%'});
                    $('.the-prog').text('Uploading '+ percentComplete + '%');
			        console.log(percentComplete);
			        if (percentComplete === 100) {
			        	
			        }

			      }
			    }, false);

			    return xhr;
			  },
        url: u,
        type: 'post',
        data: formdata,
        contentType: false,
        processData: false,
        dataType: 'json',
        complete: function(xhr){
          console.log(xhr.responseText);
          $('#comp_image').val(xhr.responseText);
          $('.featured_image img').attr('src',AdminUrl+'media/get-file/'+xhr.responseText);
          if($('body').find('.remove-comp-img').length) {

          } else {
             $('.featured_image').append('<a class="remove-comp-img text-danger" href="#"><i class="fa fa-window-close"></i></a>');
          }
         
          $('.the-prog').removeClass('bg-danger');
			$('.the-prog').addClass('bg-success');
          $('.the-prog').text('File has been uploaded');
          alert
        }
    });
}

function uploadGalary(formdata){
    var u = Jsapi+'map-markers/file-upload/';
    $('body').find('.here-in .the-prog').addClass('bg-danger');
    $('body').find('.here-in .the-prog').css({'width' : 0 + '%'});

    $.ajax({
        xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                  if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                    $('body').find('.here-in .the-prog').css({'width' : percentComplete + '%'});
                    $('body').find('.here-in .the-prog').text('Uploading '+ percentComplete + '%');
                    console.log(percentComplete);
                    if (percentComplete === 100) {
                        
                    }

                  }
                }, false);

                return xhr;
              },
        url: u,
        type: 'post',
        data: formdata,
        contentType: false,
        processData: false,
        dataType: 'json',
        complete: function(xhr){
        $('body').find('.here-in').addClass('done-here');
        $('body').find('.here-in img').attr('src',AdminUrl+'media/get-file/'+xhr.responseText);
        $('body').find('.here-in input').val(xhr.responseText);
        $('body').find('.here-in .the-prog').removeClass('bg-danger');
        $('body').find('.here-in .the-prog').addClass('bg-success');
        $('body').find('.here-in .the-prog').text('File uploaded');
        $('body').find('.here-in').removeClass('here-in');
        }
    });
}

$(document).ready(function(){
    var dil = '<?php echo URL.default_image();?>';

    $('body').on('click','.remove-comp-img', function(e){
        e.preventDefault();
        $('#comp_image').val('');
        $('.featured_image img').attr('src',dil);
        $(this).remove();
    });

    $('#input-upload_doc').on('change', function(){
        var fd = new FormData();
        var files = $('#input-upload_doc')[0].files[0];
        fd.append('upload-map-data',files);
        fd.append('data[comp]',1);

        uploadData(fd);
    });

    $('body').on('change','#map-gallery', function(){
        var fd = new FormData();
        var files = $('#map-gallery')[0].files[0];
        fd.append('upload-map-data',files);
        fd.append('data[gall]',1);
        var btn = $('.here-up').html();
        btn = '<div class="col-lg-3 col-md-4 col-sm-3 col-xs-4 here-up">'+ btn + '</div>';
        var td = $('body').find('.the-file .text-danger').text();
        var d = '<img class="fuel-gallery-add"> <input class="hide" type="checkbox" name="data[gallery_image][]" value="" checked>';
        var prog = '<div class="progress abs-progress"><div class="the-prog bg-danger"></div></div><a class="remove-gall text-danger" href="#"><i class="fa fa-window-close"></i></a>';
        $('.here-up').addClass('here-in');
        $('.here-up').removeClass('here-up');
        $('body').find('.here-in').html(d+prog);
        $('.fuel-gallery').append(btn);
        $('body').find('.the-file').html('');
        uploadGalary(fd);
    });

    $('body').on('click','.upload-gallery', function(){
        var a = $(this).parent().find('#map-gallery');
        a.click();
    })
    $('body').on('click','.remove-gall', function(e){
    	e.preventDefault();
    	 var a = $(this).closest('.done-here').remove();
    });
});
</script>