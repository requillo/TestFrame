<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$lang = rtrim(LANG_ALIAS,'/');
?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2 style="text-align: bottom; vertical-align: middle;">
			<?php echo __('Add Map Marker','map_markers');?> 
			</h2> 
		</div>
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div id="the_map" style="height: 300px"></div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
		  		<div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
		  			<div class="featured_image"><img src="<?php echo URL.default_image(); ?>"></div>
		  			<?php $form->input('upload_doc',array('type'=>'file','label'=>'<i class="fa fa-upload" aria-hidden="true"></i> <span class="tupl">'.__('Company image','map_markers').'</span> <small class="text-warning">(max 3mb)</small>')); ?>
				<input type="text" name="data[featured_image]" id="comp_image" class="hide">
				<div class="progress abs-progress hide">
					<div class="the-prog bg-danger"></div>
				</div>
		  		</div>
		  		<div class="col-lg-8 col-md-7 col-sm-6 col-xs-12">
		  			<div class="row">
		  				<?php if($fuel_inventory && !empty($marker_option)) { ?>
		  				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  					<div class="form-group">
		  					<div class="alert alert-danger">
		  					<?php echo __('You can select Gas Station from Fuel Inventory','map_markers') ?> 
		  				<select class="select-stations form-control-inline">
		  					<option value="0"><?php echo __('Select a Gas Station','map_markers') ?></option>
		  					<?php echo $form->options($marker_option); ?>
		  					</select> <span class="text-danger">(<?php echo __('Optional','map_markers') ?>)</span>
		  					</div>
							</div>
		  				</div>
		  				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
		  				<?php } ?>
						<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12">
							<select class="form-control" id="map-marker-icons">
							<?php echo $form->options($icons_options) ?>
							</select>
						</div>
						<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
							<?php $form->input('dealer', array('placeholder' => __('Name','map_markers'))) ?>
							<input type="" name="data[site_id]" class="hide" id="site_id">
							</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><?php $form->input('address', array('placeholder' => __('Address','map_markers'))) ?></div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><?php $form->textarea('description', array('placeholder' => __('Description','map_markers'))) ?></div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center text-danger">
							<div class="form-group">
							<?php echo __('Click on the map to get the codes','map_markers') ?>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><?php $form->input('latitude', array('placeholder' => __('Latitude','map_markers'))) ?></div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><?php $form->input('longitude', array('placeholder' => __('Longitude','map_markers'))) ?></div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row fuel-gallery">
						<div class="col-lg-3 col-md-4 col-sm-3 col-xs-4 here-up">
							<input type="file" name="" id="map-marker-gallery"><label class="btn btn-default upload-gallery"> <i class="fa fa-upload" aria-hidden="true"></i> Gallery</label>
						</div>
						</div>
						</div>
						
		  				
		  			</div>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<a href="#" class="btn btn-success add-map-marker pull-right"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php echo __('Add','map_markers');?></a>
				</div>

		  		

			</div>
		</div>
	</div>
</div>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2><?php echo __('All Gas Station','map_markers');?></h2> 
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div id="markers-table" class="pos-rel markers-table">
				<div class="table-responsive" id="table-markers">
		  			<table id="all-markers" class="table table-striped table-bordered table-hover">
	  				<thead>
					  	<tr>
						  	<th><?php echo __('Gas Station','map_markers');?></th>
						  	<th><?php echo __('Type','map_markers');?></th>
						  	<th style="width: 90px"><?php echo __('Action','map_markers');?></th>
					  	</tr>
					  </thead>
					  <tbody>
					  	<?php foreach ($stations as $key => $value) { ?>
					  	<tr>
						  	<td style="vertical-align: middle;"><a href="<?php echo admin_url('map-markers/edit-marker/'.$value['id'].'/') ?>" class="get-station" data-id="<?php echo $value['id'];?>"><?php echo $value['station_data']['dealer'];?></a></td>
						  	<td style="vertical-align: middle;"><?php echo $value['station_type'];?></td>
						  	<td style="vertical-align: middle;"><a href="#" data-id="<?php echo $value['id'];?>" class="fa fa-close btn btn-danger detele-map-marker"> <?php echo __('Delete','map_markers');?></a></td>
					  	</tr>
					  	<?php } ?>
					  </tbody>
					</table>
				</div>
			</div>
			</div>
			</div>
		</div>
	</div>
</div>

	<?php // print_r($stations) ;?>

<script src="https://apis.google.com/js/platform.js" async defer></script> 
<script type="text/javascript">
var All_markers = $('#all-markers').DataTable({
	"destroy": true,
	"pagingType": "simple_numbers",
	"language": {
				    "decimal":        "",
				    "emptyTable":     "<?php echo __('No data available in table'); ?>",
				    "info":           "<?php echo __('Showing _START_ to _END_ of _TOTAL_ entries'); ?>",
				    "infoEmpty":      "<?php echo __('Showing 0 to 0 of 0 entries'); ?>",
				    "infoFiltered":   "<?php echo __('(filtered from _MAX_ total entries)'); ?>",
				    "infoPostFix":    "",
				    "thousands":      ",",
				    "lengthMenu":     "<?php echo __('Show _MENU_ entries'); ?>",
				    "loadingRecords": "<?php echo __('Loading...'); ?>",
				    "processing":     "<?php echo __('Processing...'); ?>",
				    "search":         "<?php echo __('Search:'); ?>",
				    "zeroRecords":    "<?php echo __('No matching records found'); ?>",
				    "paginate": {
				        "first":      "<i class='fa fa-angle-double-left'></i>",
				        "last":       "<i class='fa fa-angle-double-right'></i>",
				        "next":       "<i class='fa fa-angle-right'></i>",
				        "previous":   "<i class='fa fa-angle-left'></i>"
				    },
				}
});
var loader = '<div class="loaderwrap absolute overlay"><div class="the-loader s2 load-center text-white"></div></div>';
var loader2 = '<div class="loaderwrap fixed overlay"><div class="the-loader s2 load-center text-white"></div></div>';
var marker = null;
var iconBase = '';
var icons = {
	<?php foreach ($icons as $key => $value) {
		echo $key .' : '. "'".  get_media($value). "'". ","."\n";
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
    map = new google.maps.Map(document.getElementById("the_map"), a);

    map.addListener('click', function(e) {
    	if(marker == null) {
    		placeMarker(e.latLng, map);
    	} else {
    		marker.setPosition(e.latLng);
    	}
    add_latlng(e.latLng.lat(),e.latLng.lng());
	}); 
}

function placeMarker(position, map) {
	var i = $('#map-marker-icons option:selected').val();
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
		$('#map-marker-icons').on('change', function(){
		marker.setIcon(iconBase + icons[$(this).val()]);
	});
	}
}
window.onload = loadScript;

$('.get-station-1').on('click', function(e){
	e.preventDefault();
	var u = Jsapi+'map-markers/file-upload/';
	var i = $(this).attr('data-id');
	$('body').append(loader2);
	$('body').append('<div class="load_content"></div>');
	$.getJSON( Jsapi+'map-markers/get-marker/'+i, function( data ) {
		console.log(data);
		if(data.ok == 'success'){
			$('body').find('.load_content').addClass('do-active');
			var a = ''
			$('body').find('.load_content').append(data.station);
		} else {
			$('body').find('.load_content').addClass('do-active');
			$('body').find('.load_content').append('Could not load content.');
		}
		
	    });
	
});

// Image uploads
function uploadMapGas(formdata){
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

function uploadGalaryMap(formdata){
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

    $('#input-upload_doc').on('change', function(){
        var fd = new FormData();
        var files = $('#input-upload_doc')[0].files[0];
        fd.append('upload-map-data',files);
        fd.append('data[comp]',1);
        uploadMapGas(fd);
    });

    $('body').on('change','#map-marker-gallery', function(){
        var fd = new FormData();
        var files = $('#map-marker-gallery')[0].files[0];
        fd.append('upload-map-data',files);
        fd.append('data[gall]',1);
        var btn = $('.here-up').html();
        btn = '<div class="col-lg-3 col-md-4 col-sm-3 col-xs-4 here-up">'+ btn + '</div>';
        var td = $('body').find('.the-file .text-danger').text();
        var d = '<img class="marker-gallery-add"> <input class="hide gall-image" type="checkbox" name="data[gallery_image][]" value="" checked><small class="text-danger">'+td+'</small>';
        var prog = '<div class="progress abs-progress"><div class="the-prog bg-danger"></div></div>';
        $('.here-up').addClass('here-in');
        $('.here-up').removeClass('here-up');
        $('body').find('.here-in').html(d+prog);
        $('.fuel-gallery').append(btn);
        $('body').find('.the-file').html('');
        uploadGalaryMap(fd);
    });

    $('body').on('click','.upload-gallery', function(){
        var a = $(this).parent().find('#map-marker-gallery');
        a.click();
    });

    var dil = '<?php echo URL.default_image();?>';
	 $('body').on('click','.remove-comp-img', function(e){
        e.preventDefault();
        $('#comp_image').val('');
        $('.featured_image img').attr('src',dil);
        $(this).remove();
    });
});

$('.add-map-marker').on('click', function(e){
e.preventDefault();
$('.form-error').removeClass('form-error');
var ee =  true;
var a = $('#input-dealer');
var b = $('#input-address');
var c = $('#input-description');
var d = $('#input-latitude');
var f = $('#input-longitude');
var g = $('#comp_image');
var h = $('#map-marker-icons').val();
var i = '';
var j = a.val();
var k = b.val();
var l = c.val();
var m = d.val();
var n = f.val();
var o = g.val();
var q = $('#site_id').val();
if(j.replace(/\s+/g, '') == '') {
		a.val('');
		a.addClass('form-error');
		ee = false;
}
if(m.replace(/\s+/g, '') == '') {
		d.val('');
		d.addClass('form-error');
		ee = false;
}
if(n.replace(/\s+/g, '') == '') {
		f.val('');
		f.addClass('form-error');
		ee = false;
}
$("input:checked").each(function() {
    i = i + $(this).val() + ',';
});

if(ee){
		$('#markers-table').append(loader);
		var fdata = {
			'data[station]' : h,
			'data[dealer]' : j,
			'data[address]' : k,
			'data[description]' : l,
			'data[latitude]' : m,
			'data[longitude]' : n,
			'data[comp_image]': o,
			'data[site_id]': q,
			'data[gallery]' : i
		}
		$.getJSON( Jsapi+'map-markers/add-marker/', fdata , function( data ) {
			console.log(data);
		if(data.ok == 'success'){
			location.reload();
		}
		
	    });
	}

});

$('body').on('click', '.detele-map-marker', function(e){
e.preventDefault();
$('.form-error').removeClass('form-error');
var ee =  true;
var p = $(this).closest('tr');
var i = $(this).attr('data-id');
var a = p.find('.get-station').text();
var txt = 'This will delete <b>'+a+'</b>';


if(ee){
		$('#markers-table').append(loader);
		var fdata = {
			'data[id]' : i
		}

	    $.confirm({
	    title: '<span class="text-danger">Warning <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>',
	    theme: 'modern',
	    content: txt,
	    autoClose: 'cancel|30000',
	    buttons: {
	        confirm: {
	            text: 'Delete',
	            btnClass: 'btn-warning',
	            keys: ['enter'],
	            action: function(){
	            	$.getJSON( Jsapi+'map-markers/delete-marker/', fdata , function( data ) {
						console.log(data);
					if(data.ok == 'success'){
						var pathtopage = window.location.href;
					// alert(pathtopage);
					$('#table-markers').load(pathtopage + ' #all-markers', function(){
						$('body').find('.loaderwrap').remove();
						$('#all-markers').DataTable({
						"destroy": true,
						"pagingType": "simple_numbers",
						"language": {
									    "decimal":        "",
									    "emptyTable":     "<?php echo __('No data available in table'); ?>",
									    "info":           "<?php echo __('Showing _START_ to _END_ of _TOTAL_ entries'); ?>",
									    "infoEmpty":      "<?php echo __('Showing 0 to 0 of 0 entries'); ?>",
									    "infoFiltered":   "<?php echo __('(filtered from _MAX_ total entries)'); ?>",
									    "infoPostFix":    "",
									    "thousands":      ",",
									    "lengthMenu":     "<?php echo __('Show _MENU_ entries'); ?>",
									    "loadingRecords": "<?php echo __('Loading...'); ?>",
									    "processing":     "<?php echo __('Processing...'); ?>",
									    "search":         "<?php echo __('Search:'); ?>",
									    "zeroRecords":    "<?php echo __('No matching records found'); ?>",
									    "paginate": {
									        "first":      "<i class='fa fa-angle-double-left'></i>",
									        "last":       "<i class='fa fa-angle-double-right'></i>",
									        "next":       "<i class='fa fa-angle-right'></i>",
									        "previous":   "<i class='fa fa-angle-left'></i>"
									    },
									}
					});
					});
					} else {
						$('body').find('.loaderwrap').remove();
					}

				    });
	            }
	        },
	        cancel: {
	            text:  'Cancel',
	            btnClass: 'btn-success',
	            action: function(){
	                // $.alert('Not deleted');
	                $('body').find('.loaderwrap').remove();
	            }
	        }
	    }
		});
	}

});

<?php if($fuel_inventory && !empty($marker_option)) { ?>
	$('.select-stations').on('change', function(){
		var i = $(this).val();
		var im = '<?php echo URL.default_image(); ?>'
		if(i > 0){
			$.getJSON( Jsapi+'map-markers/get-station/'+i, function( data ) {
						console.log(data);
					if(data.ok == 'success'){
						$('#input-dealer').val(data.station.dealer);
						$('#input-address').val(data.station.address);
						$('#site_id').val(data.station.site_id);
						if(data.station.featured_image != '') {
							$('.featured_image img').attr('src', AdminUrl+'media/get-file/'+data.station.featured_image);
							$('#comp_image').val(data.station.featured_image);
							if($('body').find('.remove-comp-img').length) {
					          } else {
					             $('.featured_image').append('<a class="remove-comp-img text-danger" href="#"><i class="fa fa-window-close"></i></a>');
					          }
						} else {
							$('body').find('.remove-comp-img').remove();
							$('.featured_image img').attr('src', im);
							$('#comp_image').val('');
						}
					} else {
						$('#input-dealer').val('');
						$('#input-address').val('');
						$('#comp_image').val('');
						$('.featured_image im').attr('src', im);
						$('#site_id').val(0);
					}

				    });
		} else {
			$('#input-dealer').val('');
			$('#input-address').val('');
			$('#comp_image').val('');
			$('.featured_image im').attr('src', im);
			$('#site_id').val(0);
			$('body').find('.remove-comp-img').remove();
			$('.featured_image img').attr('src', im);
		}
	});

<?php } ?>

</script>    