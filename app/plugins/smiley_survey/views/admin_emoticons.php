<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<?php $form->create(); ?>
		  		<div class="col-lg-3">
		  			<?php $form->input('emoticons',array('type'=>'text','label'=>__('Name','smiley_survey'),'attribute' => 'maxlength="50"')); ?>
		  		</div>
		  		<div class="col-lg-9">
		  			<?php $form->input('logo_doc',array('type'=>'file','label'=>__('Icon','smiley_survey'))); ?>
		  			<?php $form->input('image_svg',array('type'=>'hidden','no-wrap'=> true)); ?>
		  		</div>
		  		<div class="col-lg-12"><button class="btn btn-success"><?php echo __('Save','smiley_survey'); ?></button></div>
		  		<?php $form->close(); ?>
		  	</div>
		</div>
	</div>
<?php if(!empty($emoticons)){ ?>
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-12">
				<div class="results">
					<table id="datatable-companies" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th style="width: 50px"><?php echo __('Emoticon','smiley_survey') ?></th>
								<th><?php echo __('Name','smiley_survey') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($emoticons as $emoticon) { ?>
							<tr>
								<td><?php if($emoticon['image_svg'] !='') {?>
									<img src="<?php echo get_media($emoticon['image_svg']) ?>" class="table-img">
									<?php }?></td>
								<td>
									<?php echo $emoticon['emoticons'] ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				</div>
		  	</div>
		</div>
	</div>
<?php } ?>
</div>
<script type="text/javascript">
	if($('#datatable-companies').length) {
		$('#datatable-companies').DataTable();
	}
	
	var up = '<div class="progress abs-progress hide"><div class="the-prog bg-danger"></div></div>';
	$('.uploadfilewrapper').append(up);
function uploadData(formdata, elem){
	var u = Jsapi+'smiley-survey/file-upload/';
    elem.find('.progress').removeClass('hide');
    elem.find('.the-prog').removeClass('bg-success');
    elem.find('.the-prog').addClass('bg-danger');
    elem.find('.the-prog').css({'width' : 0 + '%'});

    $.ajax({
    	xhr: function() {
			    var xhr = new window.XMLHttpRequest();
			    xhr.upload.addEventListener("progress", function(evt) {
			      if (evt.lengthComputable) {
			        var percentComplete = evt.loaded / evt.total;
			        percentComplete = parseInt(percentComplete * 100);
			        elem.find('.the-prog').css({'width' : percentComplete + '%'});
                    elem.find('.the-prog').text('Uploading '+ percentComplete + '%');
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
	        elem.find('input[type=hidden]').val(xhr.responseText);
	        elem.find('.the-prog').removeClass('bg-danger');
			elem.find('.the-prog').addClass('bg-success');
	        elem.find('.the-prog').text('File has been uploaded');
        }
    });
}


	$('#input-logo_doc').on('change', function(e) {
		var p = $(this).parent().parent();
		var tf = $(this);
		p.find('.progress').addClass('hide');
		p.find('.ftl-error').remove();
		var fd = new FormData();
        var files = p.find('input')[0].files[0];
        fd.append('image_emoticons',files);
        fd.append('data[image_emoticons]',1);
		//this.files[0].size gets the size of your file.
		var target = e.target || e.srcElement;
		var fs = 0;
		if(target.value.length) {
			fs = this.files[0].size;
			fs = (fs/1048576).toFixed(4);
		}
        if(fs > 3) {
        	ffee = 1;
        	p.find('.uploadlabel').append('<span class="ftl-error text-danger"> The file is to large</span>');
        } else if( fs == 0) {
        	ffee = 2;
        	p.find('.uploadlabel').append('<span class="ftl-error text-danger"> No file selected</span>');
        } else {
        	ffee = 0;
        	uploadData(fd,p,tf);
        }
	});

</script>