<noscript>
    <style type="text/css">
        .pagecontainer {display:none;}
    </style>
    <div class="noscriptmsg">
    	<?php echo __('Javascript is not enabled, you have to enable your javascript','donations'); ?>
    </div>
</noscript>
<?php
// print_r($Person);
$nogo = 0;
$fbl = '';
$pbl = '';
if(isset($Foundation['black_listed']) && $Foundation['black_listed'] == 1) {
	$nogo = 1;
	$fbl = __('(Blacklisted!)','donations');
}

if(isset($Person['black_listed']) && $Person['black_listed'] == 1) {
	$nogo = 1;
	$pbl = __('(Blacklisted!)','donations');
}

$form->create(array('id'=>'the_donations', 'attribute' => 'autocomplete="off"'));
?>
<div class="processing hide"></div>
<div class="container-fluid"> 
    <div class="row">
      <div class="col-lg-12 col-md-12 text-right">
       <?php if($nogo == 0) { $form->input('save',array('value' => __('Save','donations'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)); } ?>
       <?php // echo $html->admin_link(__('Cancel','clients'),'clients/view/'.$Client['id'].'/', array('class'=>'bclose btn btn-danger')) ?>
       <input class="main_link hide" value="<?php echo url();?>">
       <input class="max_amount hide" value="5000">
      </div>
    </div>  
</div>

<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3>
		<?php
		if(empty($Foundation)) {
			echo __('Applicant information','donations') ;
		} else {
			echo __('Applicant & Foundation information','donations') ;	
		}
		?>
			</h3>
		</div>
		<div class="panel-body">
		  <div class="row">
		<?php if(empty($Foundation)): ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div><i class="fa fa-user" aria-hidden="true"></i> <?php echo $Person['first_name'] . ' ' . $Person['last_name'];?> <span class="text-danger"><?php echo $pbl; ?></span></div>
				<div><i class="fa fa-id-card" aria-hidden="true"></i> <a target="blank" href="<?php echo get_protected_media($Person['scanned_doc']); ?>"><?php echo $Person['id_number'];?></a></div>
				<?php if($Person['person_telephone'] != ''){ ?>
				<div><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $Person['person_telephone'];?></div>
				<?php };?>
				<?php if($Person['person_email'] != ''){ ?>
				<div><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $Person['person_email'];?></div>
				<?php };?>
				<?php if($Person['person_address'] != ''){ ?>
				<div><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $Person['person_address'];?></div>
				<?php };?>
				<?php ;?>
			</div>
		<?php else: ?>
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
				<div><i class="fa fa-user" aria-hidden="true"></i> <?php echo $Person['first_name'] . ' ' . $Person['last_name'];?> <span class="text-danger"><?php echo $pbl; ?></span></div>
				<div><i class="fa fa-id-card" aria-hidden="true"></i> <a target="blank" href="<?php echo get_protected_media($Person['scanned_doc']); ?>"><?php echo $Person['id_number'];?></a></div>
				<?php if($Person['person_telephone'] != ''){ ?>
				<div><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $Person['person_telephone'];?></div>
				<?php };?>
				<?php if($Person['person_email'] != ''){ ?>
				<div><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $Person['person_email'];?></div>
				<?php };?>
				<?php if($Person['person_address'] != ''){ ?>
				<div><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $Person['person_address'];?></div>
		<?php };?>
			</div>
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
				<div><?php echo $Foundation['foundation_name'];?> <span class="text-danger"><?php echo $fbl; ?></span></div>
				<?php if($Foundation['foundation_address'] != ''){ ?>
				<div><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $Foundation['foundation_address'];?> </div>
				<?php };?>
				<?php if($Foundation['foundation_telephone'] != ''){ ?>
				<div><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $Foundation['foundation_telephone'];?></div>
				<?php };?>
				<?php if($Foundation['foundation_email'] != ''){ ?>
				<div><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $Foundation['foundation_email'];?></div>
				<?php };?>
				
			</div>
		<?php endif; ?>
		  </div>
		</div>
	</div>
</div>

<!--<pre>
	<?php // print_r($check_donations); ?>
	<?php // print_r($check_donations_months); ?>
</pre>-->
<?php if(!empty($Person))  {?>
<?php if((isset($Foundation['black_listed']) && $Foundation['black_listed'] == 1) || $Person['black_listed'] == 1)  {?>

<?php } else { ?>

<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3><?php echo __('Add Donation information'); ?></h3>
		</div>
		<div class="panel-body">
		  <div class="row">
		  	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  		<?php $form->input('title',array('label' => __('Title','donations').' <span class="text-danger">*</span>'));?>
		  	</div>
		  	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
		  		<?php $form->textarea('description',array('label' => __('Description','donations').' <span class="text-danger">*</span>'));?>
		  	</div>
		  	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 hide">
		  		<?php $form->textarea('extra_description',array('label' => 'Extra description'));?>
		  		<?php $form->textarea('added_description',array('label' => 'Added description'));?>
		  	</div>
		  	<?php if(widget_isset('donations','get_company_options')): ?>
		  	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 hide">
		  		<div class="form-group">
		  		<label><?php echo __('The Donating company','donations'); ?></label>
		  		<input id="donated_company" type="text" name="data[donated_company]" value="<?php echo $this->user['user_company'];?>">
		  		</div>	  		
		  	</div>
		  <?php endif; ?>
		  <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
		  		<?php $form->input('uploads',array('label' => '<i class="fa fa-upload" aria-hidden="true"></i> '. __('Upload Document','donations') . ' <small class="text-warning">(max 5mb)</small> <span class="text-danger">*</span> ', 'type' => 'file'))?>
		  		<input type="test" name="data[document]" id="scanned_doc" class="hide">
				<div class="progress abs-progress hide">
					<div class="the-prog bg-danger"></div>
				</div>
			       	
		  	</div>
		  	
		  	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  		<div class="" role="tabpanel" data-example-id="togglable-tabs">
		  			<label><?php echo __('Donation types','donations'); ?></label>

					<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
								<?php 
						$i = 1;
						foreach ($Donation_types as $key => $value) {
							$key = trim($key);
							if($i == 1) {
								$active = 'active';
							} else {
								$active = '';
							}
						$i++;
						$crname = replace_spec_chars($value,"-");
						?>
						<li role="presentation" class="<?php echo $active;?>">
							<a href="#tabcontent-<?php echo $key;?>" id="<?php echo $crname;?>-tab" data-toggle="tab" aria-expanded="true">
								<?php echo $value;?>
							</a>
						</li>
						<?php } ?>
					</ul>
					<div class="pull-left">
					<div class="ass-res"></div>
		  			<div class="ass-res-cash"></div>
		  			</div>

					<div class="table-responsive">
						<table class="table table-bordered bulk_action add-res-data">
							<thead>
								<tr class="headings">
								<th class="column-title" style="width: 15px;"><?php echo __('Quantity','donations'); ?></th>
								<th class="column-title"><?php echo __('Description','donations'); ?></th>
								<th class="column-title" style="width: 200px;"><?php echo __('Amount','donations'); ?></th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
							<tfoot>
								<tr class="res-cash hide">
								<td></td>
								<td></td>
								<td></td>
								</tr>
								<tr>
								<td></td>
								<td><h2><span><?php echo __('Total amount','donations');?></span></h2></td>
								<td><h2>SRD <span class="ass-tot-amount-dona"></span></h2></td>
								</tr>
							</tfoot>
						</table>
					</div>
		  			<input type="text" name="data[tot-amount]" id="input_tot-amount" class="hide"><!-- ////////////// -->
		  			<div class="clearfix"></div>
					<div id="myTabContent" class="tab-content">
						<?php 
						$i = 1;
						foreach ($Donation_types as $key => $value) { 
							$key = trim($key);
							if($i == 1) {
								$active = 'active';
							} else {
								$active = '';
							}
						$i++;
						$crname = replace_spec_chars($value,"-");
						?>
						<div role="tabpanel" class="tab-pane fade <?php echo $active;?> in" id="tabcontent-<?php echo $key;?>" aria-labelledby="<?php echo $crname;?>-tab">
							
								<?php if($key == 1): ?>
									<div class="form-group">
										<label><?php echo __('Cash description','donations') ?></label>
										<textarea name="data[cash_description]" class="form-control data-cash"></textarea>
									</div>
									<div class="form-group">
										<label><?php echo __('Cash Amount','donations') ?></label>
										<input type="number" min="0" name="data[cash_amount]" class="form-control data-cash-amount">
									</div>
								<?php else: ?>
								<div class="row add_this_item">
									<div class="col-lg-12 col-md-12 col-sm-12 col-sm-12 hide"><input class="ptype" type="test" name="prod_type" value="<?php echo $key; ?>"></div>
									<div class="col-lg-1 col-md-1 col-sm-6 col-sm-12"><input type="number" name="am_add" class="form-control pamm" placeholder="1"></div>
									<div class="col-lg-2 col-md-2 col-sm-6 col-sm-12"><input type="text" name="am_add" class="form-control pitemcode" placeholder="<?php echo __('Item Code','donations');?>"></div>
									<div class="col-lg-4 col-md-3 col-sm-6 col-sm-12"><input type="text" name="am_add" class="form-control pdesc" placeholder="<?php echo __('Description','donations');?>"></div>
									<div class="col-lg-2 col-md-2 col-sm-6 col-sm-12"><input type="text" name="am_add" class="form-control punit" placeholder="<?php echo __('Per unit','donations');?>"></div>
									<div class="col-lg-2 col-md-2 col-sm-6 col-sm-12"><input type="number" name="am_add" class="form-control pprice" placeholder="<?php echo __('Price','donations');?>"></div>
									<div class="col-lg-1 col-md-2 col-sm-6 col-sm-12">
										<a href="#" class="btn btn-success add-new-item">
										<?php echo __('Add','donations');?>
										</a>
									</div>
								</div>
								<div class="table-responsive">
					
								 <table class="table table-striped jambo_table bulk_action datatable-add-donation">
								 	<thead>
	                          			<tr class="headings">
	                            			<th class="column-title" style="width: 15px;"><?php echo __('Add','donations'); ?></th>
	                            			<th class="column-title" style="width: 35px !important;"><?php echo __('Quantity','donations'); ?></th>
	                            			<th class="column-title"><?php echo __('Description','donations'); ?></th>
	                            		</tr>
	                            	</thead>
	                            	<tbody>
								<?php 
								// print_r($Company_assets);

								foreach ($Company_assets as $value) {
									if($value['type'] == $key) { ?>
									<tr class="par-ass">
										<td class="a-center">
										<input type="checkbox" class="flat checkass" value="<?php echo $value['id'] ?>">
										</td>
										<td class="a-center">
											<input type="number" class="ass-amount"  min="0">
										</td>
										<td >
											<input type="text" class="ass-desc hide" value="<?php echo $value['description'] . ' ' . $value['unit'] ?>">
											<input type="text" class="ass-price hide" value="<?php echo $value['price'] ?>">
											<span class=""><?php echo $value['description'] . ' ' . $value['unit']?> 
										<b><?php echo __('Price: ','donations').' SRD'.$value['price'] ?></b></span>
										</td>
									</tr>
									<?php }
								} ?>
									</tbody>
								</table>
								</div>
							<?php endif; ?>
							
						</div>
						<?php } ?>
					</div>
				</div>		  		
		  	</div>
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 approval-check">
		<div><label><?php echo __('Approval','donations'); ?></label></div>
<?php $form->input('approval',array('type' => 'radio', 'class' => 'flat','label' => __('Yes','donations'),'id' => 'yes','label-pos' => 'after','value' => 1,'no-wrap' => true,'attribute' => 'checked'));?>
<?php $form->input('approval',array('type' => 'radio', 'class' => 'flat','label' => __('No','donations'),'id' => 'no','label-pos' => 'after','value' => 0,'no-wrap' => true));?>
	</div>
		  	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 approval-reason hide">
		  		<?php $form->textarea('reason',array('label' => 'Reason'));?>
		  	</div>
		  	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
		  	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div><label><?php echo __('Internal or external','donations'); ?></label></div>
<?php $form->input('donation_within',array('type' => 'radio', 'class' => 'flat','label' => __('Internal','donations'),'id' => 'internal','label-pos' => 'after','value' => 1,'no-wrap' => true,'attribute' => 'checked'));?>
<?php $form->input('donation_within',array('type' => 'radio', 'class' => 'flat','label' => __('External','donations'),'id' => 'external','label-pos' => 'after','value' => 0,'no-wrap' => true));?>
	</div>
<?php
// For above Hi-approval Level 
if($this->user['role_level'] >= 6): 
?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 recurringwrap">
		<label><?php echo __('Recurring','donations'); ?></label>
<?php $form->input('recurring',array('type' => 'checkbox', 'class' => 'flat','label' => __('Yes','donations'),'label-pos' => 'after','value' => 1,'id' => 'recurring_input_check'));?>		
	</div>
	<div class="col-lg-4 col-md-5 col-sm-6 col-xs-12 recurringwrap ifrecurring hide">
		<select name="data[recurring_type]" class="form-control" id="recurring_type">
			<?php echo $form->options(array(1=>__('Weeks','donations'),2=>__('Months','donations'),3=>__('Years','donations'))); ?>
		</select>
		<?php $form->input('recurring_amount',array('label' => 'Amount','type'=>'number'));?>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
<?php endif; ?>  	
		  </div>
		</div>
	</div>
</div>
<div class="container-fluid"> 
    <div class="row">
      <div class="col-lg-12 col-md-12">
       <?php $form->input('save',array('value' => __('Save','donations'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>
       <?php // echo $html->admin_link(__('Cancel','clients'),'clients/view/'.$Client['id'].'/', array('class'=>'bclose btn btn-danger')) ?>
      </div>
    </div>  
</div>

<?php 
}
}
$form->close();

?>
<div class="showpop"></div>
<script type="text/javascript">
	var baseurl = $('base').prop('href');
	
	$('.add-new-item').on('click', function(e){
		e.preventDefault();
		$('input,label,textarea').removeClass('form-error');
		var proces = $('.processing');
		var pr = '<?php echo __("Please wait while your item is being added","donations") ?>';
		var c = '<div class="load-overlay bg-dark"></div><div class="load-processing bg-primary text-center"><i class="fa fa-cog fa-spin"></i> '+pr+'</div>';		
		var cid = $('#donated_company').val();
		var mp = $(this).closest('.tab-pane');
		var table = mp.find('.table').DataTable({"destroy": true});
		var tb = mp.find('.table tbody');
		var p = $(this).closest('.add_this_item');
		var t = p.find('.ptype').val();
		var a = p.find('.pamm').val();
		if(a <= 0) {
			a = 1;
		}
		var d = p.find('.pdesc').val().trim();
		var ic = p.find('.pitemcode').val().trim();
		var pu = p.find('.punit').val().trim();
		var taa = $('body').find('.totam');
		var b = 0;
		var pr = p.find('.pprice').val();
		if(pr <= 0) {
			pr = '';
		}
		var res = $('.add-res-data');
		var add = $('#input-added_description').val();
		var add_x = $('#input-extra_description').val();
		if(taa.length){
			taa.each(function(){
				b = b + parseFloat($( this ).text());
			});
		}

		if(d.replace(/\s+/g, '') == '') {
			p.find('.pdesc').addClass('form-error');
		}

		if(pr.replace(/\s+/g, '') == '') {
			p.find('.pprice').addClass('form-error');
		}

		if(ic.replace(/\s+/g, '') == '') {
			p.find('.pitemcode').addClass('form-error');
		}


		if(t.replace(/\s+/g, '') != '' && d.replace(/\s+/g, '') != '' && pr.replace(/\s+/g, '') != '' && ic.replace(/\s+/g, '') != '') {
		proces.html(c);
		proces.removeClass('hide');
			var fdata = {
		'data[description]' : d,
		'data[price]' : pr,
		'data[item_number]' : ic,
		'data[unit]' : pu,
		'data[company_id]' : cid,
		'data[ch_product]' : 1,
		'data[type]' : t
		}
		$.ajax({
		url: baseurl+'api/json/donations/add-company-assets',
		type: "POST",
		data: fdata,
		dataType: "json",
		encode : true
		}).done(function( data ) {
    	console.log(data);
    	if(data.message == 'updated'){
			proces.addClass('hide');
			proces.html('');
    		///Do magic///
    		var gp = $('#input_tot-amount').val();
    		if(gp == '') {
    			gp = 0;
    		}
    		var vad = t + '-' + a + '-' + d + '-' + pr + ',';
    		add = add + vad;
    		var vaxd = data.id + '-' + a + '-' + pr + ',';
    		add_x = add_x + vaxd;
			var totp = parseFloat(pr)*parseFloat(a);
			totp = totp.toFixed(2);
			var ttp = parseFloat(gp) + parseFloat(totp);
			ttp = ttp.toFixed(2);
			var row = '<tr id="res-'+data.id+'"><td><span class="amount-d">'+a+'</span></td><td><span>'+ d + ' ' + pu + ' @ SRD '+ pr +'</span></td><td><span class="totam">'+ totp + '</span><span><input type="hidden" value="'+vaxd+'"></span></td></tr>';
			var tr = '<tr class="par-ass"><td class="a-center"><input type="checkbox" class="flat checkass" value="'+data.id+'" checked></td><td class="a-center"><input type="number" class="ass-amount"  min="0" value="'+a+'"></td><td><input type="text" class="ass-desc hide" value="'+d+'"><input type="text" class="ass-price hide" value="'+pr+'"><span class="">'+d+' '+ pu +'<b> Price:  SRD'+pr+'</b></span></td></tr>';
			$('#input-added_description').val(add);
			$('#input-extra_description').val(add_x);
			table.row.add($(tr)).draw();
			table.page('last').draw( false );
        	// table.order([0, 'asc']).draw();
				turn_on_icheck();
			p.find('.pamm, .pdesc, .pprice, .pitemcode, .punit').val('');
			res.append(row);
			$('.ass-tot-amount-dona').text(ttp);
			$('#input_tot-amount').val(ttp);
    	}
    	//p.find('#input-desc').val('');
    	//p.find('#input-price').val('');
	});


			
		} else {
			// alert(4543);
		}

	});
	$('#the_donations').on('submit',function(e){
		// e.preventDefault();
		$('input,label,textarea').removeClass('form-error');
		$('tfoot').removeClass('form-error');
		var t = $('#input-title');
		var tv = t.val();
		var desc = $('#input-description');
		var descv = desc.val();
		var ud = $('#input-uploads');
		var sud = $('#scanned_doc').val();
		var udv = ud.val();
		var tot = $('#input_tot-amount');
		var totv = tot.val();
		var error = false;
		var checked = $("#no").parent().hasClass("checked");
		var ap_r = $('.approval-reason textarea');
		var ap_r_v = ap_r.val();

		if(ap_r_v.replace(/\s+/g, '') == '' && checked == true) {
			error = true;
			ap_r.addClass('form-error');
			ap_r.val('');
		}

		if(tv.replace(/\s+/g, '') == '') {
			error = true;
			t.addClass('form-error');
			t.val('');
			// alert(tv);
		}
		if(descv.replace(/\s+/g, '') == '') {
			error = true;
			desc.addClass('form-error');
			desc.val('');
		}
		if(udv.replace(/\s+/g, '') == '') {
			error = true;
			ud.addClass('form-error');
			ud.parent().find('label').addClass('form-error');
			ud.val('');
		}

		if(sud.replace(/\s+/g, '') == '') {
			error = true;
			ud.addClass('form-error');
			ud.parent().find('label').addClass('form-error');
			ud.val('');
		}


		if(totv.replace(/\s+/g, '') == '' || totv.replace(/\s+/g, '') == 0) {
			error = true;
			$('tfoot').addClass('form-error');
		}
		if(error == true) {
			return false;
		} else {
		// Check loads
		var p = $('.processing');
		var pr = '<?php echo __("Please wait while your data is being processed","donations") ?>';
		var c = '<div class="load-overlay bg-dark"></div><div class="load-processing bg-primary text-center"><i class="fa fa-cog fa-spin"></i> '+pr+'</div>';
		p.html(c);
		p.removeClass('hide');

		}
		
		
	});
	var ach = 1;
	$('.approval-check input#no').on('ifChecked', function () {
	    $('.approval-reason').removeClass('hide');
	    $('.recurringwrap').addClass('hide');
	    $('#recurring_input_check').iCheck('uncheck');
	    $('#input-recurring_amount, #recurring_type').val('');
	    ach = 2;
	});
	$('.approval-check input#yes').on('ifChecked', function () {
	    $('.approval-reason').addClass('hide');
	    $('.recurringwrap').removeClass('hide');
	    ach = 1;
	});
	$('body').on('ifChecked','#recurring_input_check', function () {
		 $('.ifrecurring').removeClass('hide');
	});
	$('body').on('ifUnchecked','#recurring_input_check', function () {
		$('.ifrecurring').addClass('hide');
	});

	$('.bsave').on('click', function(e){
		e.preventDefault();
		$('.form-error').removeClass('form-error');
		var dr = $('#input-reason').val();
		var dre = $('#input-reason');
		var it = $('#input-title').val();
		var ite = $('#input-title');
		var des = $('#input-description').val();
		var dese = $('#input-description');
		var tb = $('.table-responsive').html();
		var dc = $('#input-uploads').val();
		var sdc = $('#scanned_doc').val();
		var dce = $('#input-uploads');
		var tot = $('#input_tot-amount');
		var totv = tot.val();
		var h = '<div class="poptitle"><?php echo __("Please check if the information is correct!", "donations");?></div>';
		var dinf = '<div class="text-bold"><?php echo __("Donation information", "donations");?></div>';
		var btn1 = '<a class="btn btn-success btn-go pull-right"><?php echo __("Yes information is correct", "donations");?></a>';
		var btn2 = '<a class="btn btn-danger btn-cancel pull-left"><?php echo __("I need to edit information", "donations");?></a>';
		var btns = '<div class="btn-holder">'+btn2+btn1+'</div>';

		if(ach == 2 && dr.replace(/\s+/g, '') == '') {
			dre.addClass('form-error');
		} else {
			ach = 1;
		}
		// alert(ach);
		if(it.replace(/\s+/g, '') != '') {
			it = '<div>'+'<?php echo __("Title", "donations");?>: '+it+'</div>';
		} else {
			it = '';
			ite.addClass('form-error');
		}
		if(des.replace(/\s+/g, '') != '') {
			des = '<div>'+'<?php echo __("Description", "donations");?>: '+des+'</div>';
		} else {
			des = '';
			dese.addClass('form-error');
		}
		if(dc.replace(/\s+/g, '') != '') {
			dc = '<div>'+'<?php echo __("Documeny", "donations");?>: '+dc+'</div>';
		} else {
			dc = '';
			dce.parent().find('label').addClass('form-error');
		}
		if(sdc.replace(/\s+/g, '') != '') {
			dc = '<div>'+'<?php echo __("Documeny", "donations");?>: '+dc+'</div>';
		} else {
			dc = '';
			dce.parent().find('label').addClass('form-error');
		}
		if(totv.replace(/\s+/g, '') == '' || totv.replace(/\s+/g, '') == 0) {
			$('tfoot').addClass('form-error');
			totv = '';
		}

		if(it != '' && des != '' && dc != '' && totv != '' && ach == 1) {
			$('.showpop').append('<div class="load-overlay bg-dark"></div><div class="popwrapper">'+h+dinf+it+des+tb+btns+'</div>');
		}
		
		
	});
	$('body').on('click','.btn-cancel',function(){
		$('.showpop').html('');

	});
	$('body').on('click','.btn-go',function(){
		$('.showpop').html('');
		$('#the_donations').submit();
	});

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

$('#input-uploads').on('change', function(e) {
		$('.progress').addClass('hide');
		$('.ftl-error').remove();
		$('#scanned_doc').val('');
		var fd = new FormData();
        var files = $('#input-uploads')[0].files[0];
        fd.append('scanned_doc',files);
        fd.append('data[don]',1);
        
		//this.files[0].size gets the size of your file.
		var target = e.target || e.srcElement;
		var fs = 0;
		if(target.value.length) {
			fs = this.files[0].size;
			fs = (fs/1048576).toFixed(2);
		}
        if(fs > 5) {
        	ffee = 1;
        	$('.uploadlabel').append('<span class="ftl-error text-danger"> The file is to large</span>');
        } else if( fs == 0) {
        	ffee = 1;
        	$('.uploadlabel').append('<span class="ftl-error text-danger"> No file selected</span>');
        } else {
        	ffee = 0;
        	uploadData(fd);
        }
	});

</script>