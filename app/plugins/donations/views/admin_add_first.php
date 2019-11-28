<?php 
$form->create(array('id'=>'donations', 'attribute' => 'autocomplete="off"', 'class' => 'no-enter'));
?>
<div class="container-fluid"> 
    <div class="row">
      <div class="col-lg-12 col-md-12 text-right">
       <?php if($blacklist == 0) { $form->input('save',array('value' => __('Next','donations'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)); } ?>
       <?php // echo $html->admin_link(__('Cancel','clients'),'clients/view/'.$Client['id'].'/', array('class'=>'bclose btn btn-danger')) ?>
       <input class="main_link hide" value="<?php echo url();?>">
      </div>
    </div>  
</div>
<?php if(!empty($Person)): 
// print_r($Person);
if($Person['black_listed'] == 1) {
	$pbl = __('(Blacklisted!)','donations');
	$palert = 'text-danger';
} else {
	$pbl = '';
	$palert = '';
}
?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-heading"><h3><?php echo __('Applicant information','donations') ?> <small class="<?php echo $palert;?>"><?php echo $pbl;?></small></h3></div>
		<div class="panel-body">
		  <div class="row">
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('first_name',array('label'=>__('First name','donations'),'value' => $Person['first_name'], 'attribute' =>'disabled')); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('last_name',array('label'=>__('Last name','donations'),'value' => $Person['last_name'], 'attribute' =>'disabled')); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" name="data[id_number]" id="input-id_number" value="<?php echo $Person['id_number']?>">
				<?php $form->input('mock_id',array('label'=>'<span class="tnamet">'.$Person['the_id_type'].'</span>','value' => $Person['id_number'], 'attribute' =>'disabled')); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('person_telephone',array('label'=>__('Telephone','donations'),'value' => $Person['person_telephone'])); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('person_address',array('label'=>__('Address','donations'),'value' => $Person['person_address'])); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('person_email',array('label'=>__('E-mail','donations'),'value' => $Person['person_email'])); ?>
			</div>
		  </div>
		  <div class="overwrite hide alert alert-success">
		  	<h3><?php echo __('Check the box to add a new person!','donations') ?></h3>
		  		<?php
		  		$sametext = __('Not the same person as shown below!','donations'); 
		  		$form->input('notsame',array('value' => 1, 'type' => 'checkbox','class' => 'flat ','label'=>$sametext , 'label-pos' => 'after')); 
		  		?>
		  </div>
		  <?php if(!empty($Foundations)): ?>
		  <div class="similar-persons">
		  <h3 class="text-danger"><?php echo __('We found Company, Organization, School or Foundation associated with this person!') ?></h3>
		  </div>
		  <div class="row">
		  <div class="sim_results">
		  		<?php 
		  		$i = 1;
		  		foreach ($Foundations as $Foundation) { ?>
		  		<?php
		  		if($i == 1) {
		  			$checked = 'checked';
		  		} else {
		  			$checked = '';
		  		}
		  		if($Foundation['info']['black_listed'] == 1) {
		  			$alert = 'alert-danger';
		  			$fbl = __('(Blacklisted!)');
		  		} else {
		  			$alert = 'alert-success';
		  			$fbl = '';
		  		}
	  			$id = $Foundation['info']['id'];
	  			$name = $Foundation['info']['foundation_name'];
	  			$address = $Foundation['info']['foundation_address'];
	  			$email = $Foundation['info']['foundation_email'];
	  			$phone = $Foundation['info']['foundation_telephone'];
	  			if(empty($address)){
	  				$address = 'N/A';
	  			}
	  			if(empty($email)){
	  				$email = 'N/A';
	  			}
	  			if(empty($phone)){
	  				$phone = 'N/A';
	  			}
		  		?>
		  			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 spec">
		  				<div class="overwrite alert <?php echo  $alert;?>">
		  					<label for="found-<?php echo $Foundation['info']['id'];?>">
		  					<input type="checkbox" name="data[foundation_id]" id="found-<?php echo $id;?>" class="flat spec_check hasfd" value="<?php echo $id;?>" <?php // echo $checked; ?>>
		  					<span><?php echo  $name;?></span> <span><?php echo  $fbl;?></span>
		  					<hr>
		  					<div><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo  $address;?></div>
		  					<div><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo  $phone;?></div>
		  					<div><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo  $email;?></div>
		  					</label>
						</div>
						
		  			</div>
		  		<?php 
		  		$i++;
		  	} ?>
		  	</div>
		  </div>
		<?php endif;?>

		</div>
	</div>
</div>

<?php else: ?>

<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-heading"><h3><?php echo __('Applicant information','donations') ?></h3></div>
		<div class="panel-body">
		  <div class="row">
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('first_name',array('label'=>__('First name','donations').' <span class="text-danger">*</span>')); ?>
			</div>
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('last_name',array('label'=>__('Last name','donations').' <span class="text-danger">*</span>')); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
				<label style="display: block;">Identification type <span class="text-danger">*</span></label>
				<input type="radio" name="data[id_type]" value="1" id="id" class="flat tch" checked> <label for="id">ID</label>&nbsp;&nbsp;
				<input type="radio" name="data[id_type]" value="2" id="pp" class="flat tch"> <label for="pp">Passport</label>&nbsp;&nbsp;
				<input type="radio" name="data[id_type]" value="3" id="dl" class="flat tch"> <label for="dl">Other</label>
				</div>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('id_number',array('label'=>'<span class="tnamet">'.__('ID Number','donations').'</span> <span class="text-danger">*</span>')); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				
				<?php $form->input('upload_doc',array('type'=>'file','label'=>'<i class="fa fa-upload" aria-hidden="true"></i> <span class="tupl">'.__('Scanned ID card','donations').'</span> <small class="text-warning">(max 3mb)</small> <span class="text-danger">*</span>')); ?>
				<input type="test" name="data[scanned_doc]" id="scanned_doc" class="hide">
				<div class="progress abs-progress hide">
					<div class="the-prog bg-danger"></div>
				</div>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('person_telephone',array('label'=>__('Telephone','donations'))); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('person_address',array('label'=>__('Address','donations'))); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('person_email',array('label'=>__('E-mail','donations'))); ?>
			</div>
		  </div>
		  <div class="sim_id hide">
		  		<?php $form->input('same',array('label'=>__('Same persons','donations'))); ?>
		  		<?php $form->input('per_sim',array('label'=>__('Perfect similar','donations'))); ?>
		  		<?php $form->input('mix_name',array('label'=>__('Mix Names','donations'))); ?>
		  </div>
		  <div class="overwrite hide alert alert-success">
		  	<h3><?php echo __('Check the box to add a new person!','donations') ?></h3>
		  		<?php
		  		$sametext = __('Not the same person as shown below','donations'); 
		  		$form->input('notsame',array('value' => 1, 'type' => 'checkbox','class' => 'flat sp_checker','label'=>$sametext , 'label-pos' => 'after')); 
		  		?>
		  </div>
		  <div class="similar-persons hide">
		  	<h3 class="text-danger"><?php echo __('We found similar persons, please select a person below!') ?></h3>
		  	<div class="sim_results"></div>
		  </div>
		</div>
	</div>
</div>
<?php endif; ?>
<div class="container-fluid foundation-add"> 
	<div class="panel panel-default">
		<div class="panel-heading"><h3><?php echo __('Company, Organization, School or Foundation information','donations'); ?></h3></div>
		<div class="panel-body">
		  <div class="row">
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<?php 
			$c_name = __('Name (Company, Organization, School, Foundation etc.)'.' <span class="text-danger">*</span>','donations');
			$form->input('foundation_name',array('label'=>$c_name)); 
			?>
			</div>
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('foundation_telephone',array('label'=>__('Telephone','donations'))); ?>
			</div>
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('foundation_address',array('label'=>__('Address','donations'))); ?>
			</div>
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('foundation_email',array('label'=>__('E-mail','donations'))); ?>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="f_overwrite alert alert-success hide">
		  	<h3><?php echo __('Check the box to add a new Company, Organization etc.','donations') ?></h3>
	  		<?php
	  		// $form->input('same',['label'=>__('Same persons','donations')]);
	  		$form->input('fsame',array('class' => 'hide'));
	  		$form->input('fper_sim', array('class' => 'hide'));
	  		$sametext = __('Not the same Company, Organisation etc. as shown below!','donations'); 
	  		$form->input('f_notsame',array('value' => 1 , 'type' => 'checkbox','class' => 'flat spec_check owfs','label'=>$sametext , 'label-pos' => 'after')); 
	  		?>
		  	</div>
			</div>
			</div>
			<h3 class="text-danger found_sim_head hide"><?php echo __('We found similar results, please check','donations'); ?></h3>
			<div class="row">
			<div class="sim_foundation_results">
				
			</div>
		  </div>
		</div>
	</div>
</div>
<div class="showpop"></div>

<?php
$form->close();
?>
<div>
<form id="myForm" method="post">
 
</form>
</div>
<script type="text/javascript">
	$('body').on('ifChecked','input[type="checkbox"]', function() {
   		$('input.spec_check').not(this).iCheck('uncheck'); 
	});
	var rnm = '';
	$('body').on('ifChecked', 'input.res_found_check', function(event){
		rnm =  $(this).closest('.overwrite').find('label span').text();
	});

	$('body').on('ifUnchecked', 'input.res_found_check', function(event){
		 rnm = '';
	});

	$('body').on('ifChecked', 'input.spec_check', function(event){
		rnm =  $(this).closest('.overwrite').find('label span').text();
	});

	$('body').on('ifUnchecked', 'input.spec_check', function(event){
		rnm = '';
	});
	var ffee = 0;

	function uploadData(formdata){
	var u = Jsapi+'donations/file-upload/';
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
          $('#scanned_doc').val(xhr.responseText);
          $('.the-prog').removeClass('bg-danger');
			$('.the-prog').addClass('bg-success');
          $('.the-prog').text('File has been uploaded');
        }
    });
}


	$('#input-upload_doc').on('change', function(e) {
		$('.progress').addClass('hide');
		$('.ftl-error').remove();
		$('#scanned_doc').val('');
		var fd = new FormData();
        var files = $('#input-upload_doc')[0].files[0];
        fd.append('scanned_doc',files);
        fd.append('data[pers]',1);
        
		//this.files[0].size gets the size of your file.
		var target = e.target || e.srcElement;
		var fs = 0;
		if(target.value.length) {
			fs = this.files[0].size;
			fs = (fs/1048576).toFixed(2);
		}
        if(fs > 3) {
        	ffee = 1;
        	$('.uploadlabel').append('<span class="ftl-error text-danger"> The file is to large</span>');
        } else if( fs == 0) {
        	ffee = 2;
        	$('.uploadlabel').append('<span class="ftl-error text-danger"> No file selected</span>');
        } else {
        	ffee = 0;
        	uploadData(fd);
        }
	});

	$('#input-save').on('click', function(e){
		e.preventDefault();
		$('input, .uploadlabel').removeClass('form-error');
		$('.ftl-error').remove();
		$('.showpop').html('');
		var idT = 0;
		var go_id = 0;
		if($('input[name="data[id_type]"]').length) {
			var idT = $('input[name="data[id_type]"]:checked').val();
		}
		var idn = $('.tnamet').text();
		var nf = $('#input-first_name').val();
		var nfe = $('#input-first_name');
		var nl = $('#input-last_name').val();
		var nle = $('#input-last_name');
		var sid = $('#input-id_number').val();
		var side = $('#input-id_number');

		if ($('#input-upload_doc').length){
			var uid = $('#input-upload_doc').val();
			var uidee = $('#input-upload_doc');
			var uide = $('.uploadlabel');
			var esi = $('#scanned_doc').val();
			
		} else {
			var uid = sid;
			var uidee = side;
			var uide = side;
			var esi = sid;
		}
		
		var t = $('#input-person_telephone').val();
		var a = $('#input-person_address').val();
		var e = $('#input-person_email').val();
		var fnn = $('#input-foundation_name').val();
		var ft = $('#input-foundation_telephone').val();
		var fa = $('#input-foundation_address').val();
		var fe = $('#input-foundation_email').val();
		var h = '<div class="poptitle"><?php echo __("Please check if the information is correct!", "donations");?></div>';
		var dinf = '<div class="text-bold"><?php echo __("Applicant information", "donations");?></div>';
		var btn1 = '<a class="btn btn-success btn-go pull-right"><?php echo __("Yes information is correct", "donations");?></a>';
		var btn2 = '<a class="btn btn-danger btn-cancel pull-left"><?php echo __("I need to edit information", "donations");?></a>';
		var btns = '<div class="btn-holder">'+btn2+btn1+'</div>';

		if(nf.replace(/\s+/g, '') != '') {
			nf = '<div>'+'<?php echo __("First name", "donations");?>: '+nf+'</div>';
		} else {
			nf = '';
			nfe.addClass('form-error');
		}
		if(nl.replace(/\s+/g, '') != '') {
			nl = '<div>'+'<?php echo __("Last name", "donations");?>: '+nl+'</div>';
		} else {
			nl = '';
			nle.addClass('form-error');
		}
		if(sid.replace(/\s+/g, '') != '') {
			
			if(idT == 1){
				var idid = sid.replace(/\s+/g, '');
				idid = idid.replace(/_/g,'');
				if(idid.length < 9){
					go_id = 1;
					side.addClass('form-error');
				}
			}
			sid = '<div>'+idn+': '+sid+'</div>';
		} else {
			sid = '';
			side.addClass('form-error');
		}

		if(uid.replace(/\s+/g, '') != '') {
			uid = '<div>'+'<?php echo __("ID Number", "donations");?>: '+uid+'</div>';
		} else {
			uid = '';
			uide.addClass('form-error');
		}

		if(esi.replace(/\s+/g, '') != '') {
			
		} else {
			uid = '';
			uide.addClass('form-error');
		}

		if(ffee == 1) {
			uide.addClass('form-error');
			$('.uploadlabel').append(' <span class="ftl-error text-danger"> The file is to large</span>')
		}

		if(ffee == 2) {
			uide.addClass('form-error');
			$('.uploadlabel').append(' <span class="ftl-error text-danger"> No file selected</span>')
		}

		if(t.replace(/\s+/g, '') != '') {
			t = '<div>'+'<?php echo __("Telephone", "donations");?>: '+t+'</div>';
		} else {
			t = '';
		}
		if(a.replace(/\s+/g, '') != '') {
			a = '<div>'+'<?php echo __("Address", "donations");?>: '+a+'</div>';
		} else {
			a = '';
		}
		if(e.replace(/\s+/g, '') != '') {
			e = '<div>'+'<?php echo __("E-mail", "donations");?>: '+e+'</div>';
		} else {
			e = '';
		}
		if(fnn.replace(/\s+/g, '') != '' || rnm != '') {
			hfnn = '<div class="text-bold"><?php echo __("Company, Organisation, School, Foundation etc. information", "donations");?></div>';
			fnn = '<div>'+'<?php echo __("Name", "donations");?>: '+fnn+'</div>';
		} else {
			fnn = '';
			hfnn = '';
		}
		if(ft.replace(/\s+/g, '') != '') {
			ft = '<div>'+'<?php echo __("Telephone", "donations");?>: '+ft+'</div>';
		} else {
			ft = '';
		}
		if(fa.replace(/\s+/g, '') != '') {
			fa = '<div>'+'<?php echo __("Address", "donations");?>: '+fa+'</div>';
		} else {
			fa = '';
		}
		if(fe.replace(/\s+/g, '') != '') {
			fe = '<div>'+'<?php echo __("E-mail", "donations");?>: '+fe+'</div>';
		} else {
			fe = '';
		}

		if(rnm != '') {
			fnn = rnm;
			ft = '';
			fa = '';
			fe = '';
		}
			

		if(nf != '' && nl != '' && sid != '' && uid != '' && esi != '' && ffee == 0 && go_id == 0) {

			$('.showpop').append('<div class="load-overlay bg-dark"></div><div class="popwrapper">'+h+dinf+nf+nl+sid+t+a+e+hfnn+fnn+ft+fa+fe+btns+'</div>');
		}
	});
	$('body').on('click','.btn-cancel',function(){
		$('.showpop').html('');

	});
	$('body').on('click','.btn-go',function(){
		$('#donations').submit();
	});

	$('.tch').on('ifChanged', function(event){
	var t = 1;
      if ($(this).prop('checked')==true){
       t = $(this).val();

       if(t == 1) {
       	$('.tnamet').text('ID Number');
       	$('.tupl').text('Scanned ID card');
       	$('#input-id_number').val('');
       	$('#input-id_number').inputmask({
	     	mask: "aa 999999 *{1}",
			definitions: {
				'*': {
					validator: "[vVmM]",
					casing: "lower"
				}
	    	}
	    });
       }

       if(t == 2) {
       	$('.tnamet').text('Passport Number');
       	$('.tupl').text('Scanned Passport');
       	$('#input-id_number').val('');
       	$('#input-id_number').inputmask('remove');

       }

       if(t == 3) {
       	$('.tnamet').text('Other Identification');
       	$('.tupl').text('Scanned Other Identification');
       	$('#input-id_number').val('');
       	$('#input-id_number').inputmask('remove');
       }


       }
    });

     $('#input-id_number').inputmask({
     	mask: "aa 999999 *{1}",
		definitions: {
			'*': {
				validator: "[vVmM]",
				casing: "lower"
			}
    	}
     }); 
     
    $('#input-foundation_name').val('');
</script>