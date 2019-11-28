<div class="container-fluid">
<div class="panel panel-default pos-rel" id="main-settings">
	<div class="panel-heading"><h2><?php echo __('Main Settings','map_makers');?></h2></div>
	<div class="panel-body">
	  	<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
				<label><?php echo __($map_api_key['description'],'map_makers');?></label>
		  		<div class="form-group">
				<input type="text" name="" class="form-control " id="input-api-key" value="<?php echo $map_api_key['value'];?>" placeholder="Google Maps API Key">
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-3 col-xs-8">
				<label><?php echo __($map_height['description'],'map_makers');?></label>
				<input type="number" name="" class="form-control " id="map-height" value="<?php echo $map_height['value'];?>" placeholder="500">
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
				<label>&nbsp;</label>
				<a href="#" class="btn btn-success btn-block add-map-settings"><i class="fa fa-save" aria-hidden="true"></i> <?php echo __('Save','map_makers');?></a>
			</div>
	  	</div>
	</div>
</div> 
	<div class="panel panel-default">
		<div class="panel-heading"><h2><?php echo __('Map icon types','map_makers');?></h2></div>
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-8 col-md-7 col-sm-6 col-xs-12"><?php $form->input('description', array('placeholder' => __('Description','map_makers'))) ?></div>
		  		<div class="col-lg-2 col-md-3 col-sm-4 col-xs-7">
		  			<?php $form->input('meta', array('placeholder' => __('Meta','map_makers'),'no-wrap' => true,'class'=>'hide', 'value'=>'gas-station-icon')) ?>
		  			<div id="map-upl-load"></div>
		  			<div id="the-map-icon"></div>
					<div class="input-group">
				        <?php $form->input('value', array('placeholder' => __('Value','map_makers'),'no-wrap' => true,'class'=>'hide'))?>
				        <a href="#" class="map-upl-btn"><i class="fa fa-upload" aria-hidden="true"></i> <?php echo __('Upload icon','map_makers');?></a>
				    </div>
				    <div class="hide">
				    	<input type="file" name="" id="upload-map-data">
				    </div>
		  		</div>
		  		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-5"><a href="#" class="btn btn-success btn-block add-icons"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo __('Add','map_makers');?></a></div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<div id="map-settings-table" class="pos-rel">
						<div class="table-responsive" id="table-map-settings">
				  			<table id="all-map-settings" class="table table-striped table-bordered table-hover">
				  				<thead>
								  	<tr>
									  	<th class="col-lg-8 col-md-7 col-sm-8 col-xs-4"><?php echo __('Description','map_makers');?></th>
									  	<th class="col-lg-2 col-md-3 col-sm-2 col-xs-4"><?php echo __('Icon','map_makers');?></th>
									  	<th class="col-lg-2 col-md-3 col-sm-2 col-xs-4"><?php echo __('Action','map_makers');?></th>
								  	</tr>
								  </thead>
								  <tbody>
								  	<?php foreach ($settings as $key => $value) { ?>
								  		<tr id="upload-icon-<?php echo  $key?>">
								  			<td style="vertical-align: middle;">
								  				<span class="info "><a class="edit-data" href="#"><i class="fa fa-pencil" aria-hidden="true"></i> <?php echo $value['description'];?></a></span>
								  				<input type="" class="form-control icon-description hide" value="<?php echo $value['description'];?>">
								  			</td>
								  			<td style="vertical-align: middle;">
								  				<?php 
								  				$all_ext = explode('.',  $value['value']);
								  				$ext = strtolower(end($all_ext));
								  				if(in_array($ext, array('jpg','png','gif'))) { ?>
								  				<div id="map-upl-load"></div>
								  				<span class="icon-wrap"><img src="<?php echo get_media($value['value']);?>" class="settins-img"></span>
								  				<input type="file" id="edit-upload-<?php echo  $key?>" class="edit-upload">
								  				<label for="edit-upload-<?php echo  $key?>" class="hide the-edit text-info">
								  					<i class="fa fa-upload" aria-hidden="true"></i> <span>Edit</span></label>
								  				<?php } else { ?>
								  				<a href="#" class="edit-data"><?php echo $value['value'];?></a>
								  				<?php } ?>
								  				<input type="" class="form-control input-edit-upload hide-4ever" value="<?php echo $value['value'];?>" id="input-edit-upload-<?php echo  $key?>">
								  			</td>
								  			<td style="vertical-align: middle;">
								  				<a href="#" class="btn btn-danger btn-sm fa fa-close del-icon del-btn" data-id="<?php echo $value['id'];?>"> <?php echo __('Delete','map_makers');?></a>
								  				<a href="#" class="btn btn-success btn-sm fa fa-save edit-icon the-edit hide" data-id="<?php echo $value['id'];?>"> <?php echo __('Save','map_makers');?></a>
								  				<a href="#" class="btn btn-default btn-sm fa fa-close cancel-data hide"> <?php echo __('Cancel','map_makers');?></a>
								  			</td>
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
	<div class="panel panel-default">
		<div class="panel-heading"><h2><?php echo __('Map region colors','map_makers');?></h2></div>
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-8 col-md-7 col-sm-8 col-xs-4"><?php $form->input('description', array('placeholder' => __('Color name','map_makers'))) ?></div>
		  		<div class="col-lg-2 col-md-3 col-sm-2 col-xs-4">
		  			<?php $form->input('meta', array('placeholder' => __('Meta','map_makers'),'no-wrap' => true,'class'=>'hide', 'value'=>'map-marker-region-color')) ?>
		  			<input class="jscolor color-input-box" id="input-value" value="F09000" autocomplete="off">
		  		</div>
		  		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4"><a href="#" class="btn btn-success btn-block add-color"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo __('Add','map_makers');?></a></div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<div id="map-color-table" class="pos-rel">
						<div class="table-responsive" id="table-map-color">
				  			<table id="all-map-color" class="table table-striped table-bordered table-hover">
				  				<thead>
								  	<tr>
									  	<th class="col-lg-8 col-md-7 col-sm-8 col-xs-7"><?php echo __('Region color name','map_makers');?></th>
									  	<th class="col-lg-2 col-md-3 col-sm-2 col-xs-3"><?php echo __('Color','map_makers');?></th>
									  	<th class="col-lg-2 col-md-3 col-sm-2 col-xs-3"><?php echo __('Action','map_makers');?></th>
								  	</tr>
								  </thead>
								  <tbody>
								  	<?php foreach ($region_colors as $key => $value) { ?>
								  		<tr id="upload-icon-<?php echo  $key?>">
								  			<td style="vertical-align: middle;">
								  				<span class="info "><a class="edit-data" href="#"><i class="fa fa-pencil" aria-hidden="true"></i> <?php echo $value['description'];?></a></span>
								  				<input type="" class="form-control icon-description hide" value="<?php echo $value['description'];?>">
								  			</td>
								  			<td style="vertical-align: middle;">
								  				<span class="info"><div style="background: #<?php echo $value['value'];?>">&nbsp;</div></span>
								  				<input class="jscolor color-input-box hide input-edit-upload" id="input-value" value="<?php echo $value['value'];?>" autocomplete="off">
								  			</td>
								  			<td style="vertical-align: middle;">
								  				<a href="#" class="btn btn-danger btn-sm fa fa-close del-icon del-btn" data-id="<?php echo $value['id'];?>"> <?php echo __('Delete','map_makers');?></a>
								  				<a href="#" class="btn btn-success btn-sm fa fa-save edit-icon the-edit hide" data-id="<?php echo $value['id'];?>"> <?php echo __('Save','map_makers');?></a>
								  				<a href="#" class="btn btn-default btn-sm fa fa-close cancel-data hide"> <?php echo __('Cancel','map_makers');?></a>
								  			</td>
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
<style type="text/css">
	tr .the-file { display: none; }
</style>
<script type="text/javascript">
	var loader = '<div class="loaderwrap absolute overlay"><div class="the-loader s2 load-center text-white"></div></div>';
	function uploadMap_data(formdata){
	var ff = AdminUrl +'media/get-file/';
	var nf = '<?php echo URL ?>media/uploads/';
    var u = Jsapi+'map_markers/file-upload/';
    $('#map-upl-load').addClass('bg-danger');
    $('#map-upl-load').css({'width' : 0 + '%'});
    $.ajax({
        xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                  if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                   	$('#map-upl-load').css({'width' : percentComplete + '%'});
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
        console.log(xhr);
        $('#map-upl-load').removeClass('bg-danger');
        $('#map-upl-load').addClass('bg-success');
        $('#input-value').val(xhr.responseText);
        $('#the-map-icon').html('<img src="'+nf+xhr.responseText.replace(/\-/g, "/")+'">');
        $('#input-value').attr('disabled','disabled');
        $('.map-upl-btn').removeClass('hide');
        }
    });
}

function edit_uploadGas_data(formdata,th){
	var ff = AdminUrl +'media/get-file/';
	var nf = '<?php echo URL ?>media/uploads/';
    var u = Jsapi+'map_markers/file-upload/';
    $('#'+th+' #map-upl-load').addClass('bg-danger');
    $('#'+th+' #map-upl-load').css({'width' : 0 + '%'});
    $.ajax({
        xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                  if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                   	$('#'+th+' #map-upl-load').css({'width' : percentComplete + '%'});
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
        console.log(xhr);
        $('#'+th+' #map-upl-load').removeClass('bg-danger');
        $('#'+th+' #map-upl-load').addClass('bg-success');
        $('#'+th+' img').attr('src',nf+xhr.responseText.replace(/\-/g, "/"));
        $('#'+th+' .input-edit-upload').val(xhr.responseText);
        }
    });
}

	$('.map-upl-btn').on('click', function(e){
		e.preventDefault();
		$('#upload-map-data').click();
	});

	$('body').on('change','#upload-map-data', function(){
		$('.map-upl-btn').addClass('hide');
        var fd = new FormData();
        var files = $('#upload-map-data')[0].files[0];
        fd.append('upload-map-data',files);
        fd.append('data[pers]',1);
        uploadMap_data(fd);
    });

    $('body').on('change','.edit-upload', function(){
		var p = $(this).closest('tr');
		var pi = p.attr('id');
		var i = $(this).attr('id');
        var fd = new FormData();
        var files = $('#'+i)[0].files[0];
        fd.append('upload-map-data',files);
        fd.append('data[icon]',1);
        edit_uploadGas_data(fd,pi);
    });

$('.add-icons').on('click', function(e){
	e.preventDefault();
	$('.form-error').removeClass('form-error');
	var ee = true;
	var p = $(this).closest('.row');
	var a = p.find('#input-meta');
	var b = p.find('#input-value');
	var c = p.find('#input-description');
	var d = a.val();
	var e = b.val();
	var f = c.val();
	if(d.replace(/\s+/g, '') == '') {
		a.val('');
		a.addClass('form-error');
		ee = false;
	}
	if(e.replace(/\s+/g, '') == '') {
		b.val('');
		b.addClass('form-error');
		ee = false;
	}
	if(f.replace(/\s+/g, '') == '') {
		c.val('');
		c.addClass('form-error');
		ee = false;
	}

	if(ee){
		$('#table-map-settings').append(loader);
		var fdata = {
			'data[meta]' : d,
			'data[value]' : e,
			'data[description]' : f
		}
		$.getJSON( Jsapi+'map_markers/settings/', fdata , function( data ) {
			console.log(data);
		if(data.ok == 'success'){
			var pathtopage = window.location.href;
			// alert(pathtopage);
			$('#table-map-settings').load(pathtopage + ' #all-map-settings', function(){
				$('body').find('.loaderwrap').remove();
			});
			b.val('');
			c.val('');
			$('#input-value').removeAttr('disabled');
			$('#map-upl-load').css({'width':0});
			$('#the-map-icon').html('');
			$('#upload-map-data').val('');
		} else {
			$('body').find('.loaderwrap').remove();
		}

	    });
	}
});
$('.add-map-settings').on('click', function(e){
	e.preventDefault();
	$('.form-error').removeClass('form-error');
	var ee = true;
	var p = $(this).closest('.row');
	var a = p.find('#input-api-key');
	var b = p.find('#map-height');
	var c = a.val();
	var d = b.val();
	if(c.replace(/\s+/g, '') == '') {
		a.val('');
		a.addClass('form-error');
		ee = false;
	}
	if(d.replace(/\s+/g, '') == '') {
		b.val('');
		b.addClass('form-error');
		ee = false;
	}
	if(ee){
		$('#main-settings').append(loader);
		var fdata = {
			'data[api]' : c,
			'data[map-height]' : d
		}
		$.getJSON( Jsapi+'map-markers/settings/', fdata , function( data ) {
			console.log(data);
		if(data.ok == 'success'){
			$('body').find('.loaderwrap').remove();
		} else {
			$('body').find('.loaderwrap').remove();
		}

	    });

	}
});

$('body').on('click','.edit-icon', function(e){
	e.preventDefault();
	var ee = true;
	var p = $(this).closest('tr');
	var dd = p.closest('.pos-rel');
	var md = dd.find('.table-responsive').attr('id');
	var td = dd.find('table').attr('id');
	var i = $(this).attr('data-id');
	var ic = p.find('.input-edit-upload').val();
	var id = p.find('.icon-description').val();
	if(ee){
		dd.append(loader);
		var fdata = {
			'data[id]' : i,
			'data[value]' : ic,
			'data[description]' : id
		}
		$.getJSON( Jsapi+'map_markers/settings/', fdata , function( data ) {
			console.log(data);
		if(data.ok == 'success'){
			var pathtopage = window.location.href;
			// alert(pathtopage);
			$('#'+md).load(pathtopage + ' #'+td, function(){
				$('body').find('.loaderwrap').remove();
				jscolor.installByClassName("jscolor");
			});
		} else {
			$('body').find('.loaderwrap').remove();
		}

	    });

	}

});

$('body').on('click','.del-icon', function(e){
	e.preventDefault();
	var ee = true;
	var p = $(this).closest('tr');
	var dd = p.closest('.pos-rel');
	var md = dd.find('.table-responsive').attr('id');
	var td = dd.find('table').attr('id');
	var a = p.find('.edit-data');
	var b = p.find('.icon-wrap');
	var c = a.text();
	var d = b.html();
	var e = $(this).attr('data-id');
	var txt = 'This will delete <b>'+c+'</b>';
	if(ee){
		dd.append(loader);
		var fdata = {
			'data[id]' : e,
			'data[delet-icon]' : 1
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
	            	$.getJSON( Jsapi+'map_markers/settings/', fdata , function( data ) {
						console.log(data);
					if(data.ok == 'success'){
						var pathtopage = window.location.href;
					// alert(pathtopage);
					$('#'+md).load(pathtopage + ' #'+td, function(){
						$('body').find('.loaderwrap').remove();
						jscolor.installByClassName("jscolor");
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


$('.add-color').on('click', function(e){
	// alert(1);
	e.preventDefault();
	$('.form-error').removeClass('form-error');
	var ee = true;
	var p = $(this).closest('.row');
	var a = p.find('#input-meta');
	var b = p.find('#input-value');
	var c = p.find('#input-description');
	var d = a.val();
	var e = b.val();
	var f = c.val();
	if(d.replace(/\s+/g, '') == '') {
		a.val('');
		a.addClass('form-error');
		ee = false;
	}
	if(e.replace(/\s+/g, '') == '') {
		b.val('');
		b.addClass('form-error');
		ee = false;
	}
	if(f.replace(/\s+/g, '') == '') {
		c.val('');
		c.addClass('form-error');
		ee = false;
	}

	if(ee){
		$('#table-map-color').append(loader);
		var fdata = {
			'data[meta]' : d,
			'data[value]' : e,
			'data[description]' : f
		}
		$.getJSON( Jsapi+'map_markers/settings/', fdata , function( data ) {
			console.log(data);
		if(data.ok == 'success'){
			var pathtopage = window.location.href;
			// alert(pathtopage);
			$('#table-map-color').load(pathtopage + ' #all-map-color', function(){
				$('body').find('.loaderwrap').remove();
				jscolor.installByClassName("jscolor");
			});
			c.val('');
		} else {
			$('body').find('.loaderwrap').remove();
		}

	    });
	}
});

</script>