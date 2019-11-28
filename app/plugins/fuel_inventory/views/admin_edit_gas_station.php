<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>

<?php $form->create(); ?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<a href="<?php echo admin_url('fuel-inventory/settings/gas-stations/') ?>" class="btn btn-danger pull-right"><i class="fa fa-close" aria-hidden="true"></i> <?php echo __('Cancel','fuel_inventory');?></a>
					<button class="btn btn-success add-gas-station pull-right"><i class="fa fa-save" aria-hidden="true"></i> <?php echo __('Save','fuel_inventory');?></button>
					
				</div>
		  		<div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
		  			<div class="featured_image">
		  				<?php if($station['featured_image'] != '') { ?>
		  				<a class="remove-comp-img text-danger" href="#"><i class="fa fa-window-close"></i></a>
		  				<img src="<?php echo get_protected_media($station['featured_image']); ?>">
		  				<?php } else {?>
		  				<img src="<?php echo URL.default_image(); ?>">
		  				<?php } ?>
		  			</div>
		  			<?php $form->input('upload_doc',array('type'=>'file','label'=>'<i class="fa fa-upload" aria-hidden="true"></i> <span class="tupl">'.__('Company image','fuel_inventory').'</span> <small class="text-warning">(max 3mb)</small>')); ?>
				<input type="text" name="data[featured_image]" id="comp_image" class="hide" value="<?php echo $station['featured_image'];?>">
				<div class="progress abs-progress hide">
					<div class="the-prog bg-danger"></div>
				</div>
		  		</div>
		  		<div class="col-lg-8 col-md-7 col-sm-6 col-xs-12">
		  			<div class="row">
						<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12">
							<?php $form->input('site_id', array(
								'type' => 'number',
								'label' => __('Site Id','fuel_inventory'),
								'attribute' => 'min="1"',
								'value' => $station['site_id']
								)) ?>
						</div>
				  		<div class="col-lg-8 col-md-7 col-sm-8 col-xs-12">
				  			<?php $form->input('dealer', array(
				  				'label' => __('Dealer','fuel_inventory'),
				  				'value' => $station['dealer'],
				  				'attribute'=>'autocomplete="off"'
				  				)) ?> 
				  		</div>
				  		<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12">
				  			<?php $form->input('district', array(
				  				'label' => __('District / Area','fuel_inventory'),
				  				'value' => $station['district'],
				  				'attribute'=>'autocomplete="off"'
				  				)) ?> 
				  		</div>
				  		<div class="col-lg-8 col-md-7 col-sm-8 col-xs-12">
				  			<?php $form->input('address', array(
				  				'label' => __('Address','fuel_inventory'),
				  				'value' => $station['address'],
				  				'attribute'=>'autocomplete="off"'
				  				)) ?> 
				  		</div>
				  		<div class="col-lg-4 col-md-5 col-sm-4 col-xs-12"> 
				  			<?php $form->input('phone', array(
				  				'label' => __('Telephone','fuel_inventory'),
				  				'value' => $station['phone'],
				  				'attribute'=>'autocomplete="off"'
				  				)) ?> 
				  		</div>
				  		<div class="col-lg-8 col-md-7 col-sm-8 col-xs-12">
				  			<?php $form->input('email', array(
				  				'label' => __('E-mail','fuel_inventory'),
				  				'value' => $station['email'],
				  				'attribute'=>'autocomplete="off"'
				  				)) ?> 
				  		</div>
				  		<?php if(!empty($map_id) && $map_markers) { ?>
				  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="map_id_has">
				  			<a href="#" class="text-danger" id="remove-map-link" data-id="<?php echo $map_id['id']; ?>">
				  				<i class="fa fa-map-marker"></i>
				  				<?php echo __('Remove map link','fuel_inventory'); ?>
				  			</a>
				  			<?php $form->input('map_id', array(
				  				'type' => 'hidden',
				  				'value' => $map_id['id'],
				  				'attribute'=>'autocomplete="off"'
				  				)) ?>
				  		</div>
				  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hide" id="map_id_no">
				  			<div class="alert alert-success"><?php echo __('Map link has been removed','fuel_inventory') ?></div>
				  			<div class="alert alert-danger">
				  				<?php echo __('You can select a Marker from the Map','fuel_inventory') ?>
				  			<select id="select_map_marker" >
				  				<option value="0"><?php echo __('No link to map','fuel_inventory') ?></option>
				  				<?php if(!empty($map_data)) { ?>
				  				<option value="<?php echo $map_data['id'] ?>"><?php echo $map_data['dealer'] ?></option>
				  				<?php }  ?>
				  				<?php echo $form->options($marker_option); ?>
				  			</select>
				  			<span class="text-danger"><?php echo __('(Optional)','fuel_inventory');?></span>
				  			</div>
				  		</div>
				  		
				  		<?php } else if($map_markers) { ?>
				  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="map_id_no">
				  			<div class="alert alert-danger">
		  					<?php echo __('You can select a Marker from the Map','fuel_inventory') ?>
				  			<select name="data[map_id]" class="form-control-inline">
				  				<option value="0"><?php echo __('No link to map','fuel_inventory') ?></option>
				  				<?php echo $form->options($marker_option); ?>
				  			</select>
				  			<span class="text-danger"><?php echo __('(Optional)','fuel_inventory');?></span>
				  			</div>
				  		</div>
				  		<?php }  ?>
		  			</div>
		  		</div>
			</div>
		</div>
	</div>
</div>
<?php $form->close(); ?>

<script type="text/javascript">
	 var dil = '<?php echo URL.default_image();?>';
	 $('body').on('click','.remove-comp-img', function(e){
        e.preventDefault();
        $('#comp_image').val('');
        $('.featured_image img').attr('src',dil);
        $(this).remove();
    });
	function uploadData(formdata){
	var u = Jsapi+'fuel-inventory/file-upload/';
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

$('#input-upload_doc').on('change', function(){
        var fd = new FormData();
        var files = $('#input-upload_doc')[0].files[0];
        fd.append('scanned_doc',files);
        fd.append('data[don]',1);

        uploadData(fd);
    });
$('body').on('click','#remove-map-link',function(e){
	e.preventDefault();
	var i = $(this).attr('data-id');

	$.getJSON( Jsapi+'fuel-inventory/remove-map-link/', {'data[id]': i} ,function( data ) {
		if(data.do == 'success'){
			$('#map_id_has').addClass('hide');
			$('#input-map_id').val(0);
			$('#map_id_no').removeClass('hide');
		} else {
			
		}
	});
	
});
$('body').on('change','#select_map_marker',function(){
	var i = $(this).val();
	$('#input-map_id').val(i);
});
</script>

<?php // print_r($station);