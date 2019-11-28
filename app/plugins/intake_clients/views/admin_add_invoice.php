<?php 
$form->create();
?>
<div class="container-fluid"> 
    <div class="row">
      <div class="col-lg-12 col-md-12 text-right">
       <?php $form->input('save',array('value' => __('Save','intake_clients'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>
       <?php // echo $html->admin_link(__('Cancel','clients'),'clients/view/'.$Client['id'].'/', array('class'=>'bclose btn btn-danger')) ?>
      </div>
    </div>  
</div>
<?php if($Intake_id != NULL): ?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  <div class="row">
		  	<pre>
				<?php print_r($Intakes); ?>
				</pre>
			<?php if(!empty($Intakes)): ?>	
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<?php 
				$form->input('intake_id',['value'=>$Intakes[0]['id'], 'type' => 'hidden', 'no-wrap' => true]); 
				?>
				<?php
				echo '<b>'.__('To','intake_clients') . '</b>: '.$Intakes[0]['client']['l_name'].' ';
				echo $Intakes[0]['client']['f_name'].'<br>';
				if($Intakes[0]['client']['company'] != ''):
						echo '<b>'.__('Company','intake_clients') . '</b>: '.$Intakes[0]['client']['company'].'<br>';
					endif;
				echo '<b>'.__('Telephone','intake_clients') . '</b>: '.$Intakes[0]['client']['telephone'].'<br>';
				echo '<b>'.__('Address','intake_clients') . '</b>: '.$Intakes[0]['client']['address'].'<br>';
					if($Intakes[0]['client']['email'] != ''):
						echo '<b>'.__('E-mail','intake_clients') . '</b>: '.$Intakes[0]['client']['email'].'<br>';
					endif;
				
				 ?>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<?php $form->input('intake_id',['label' => 'Ref #']); ?>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php 
				$form->textarea('w_assets',['type' => 'hidden', 'no-wrap' => true]);
				?>
			<div id="invoice-assets" class="hide">
				<div class="table-responsive">
				  	<table id="all-users" class="table table-striped bulk_action">				  
					  <thead>
					  	<tr>
					  	<th style="width: 1%; max-width: 80px !important" >
					  	</th>
					  	<th style="width: 1%; max-width: 550px !important" >
					  	<?php echo __('Amount','intake_clients') ?>
					  	</th>
					  	<th style="width: 100%; max-width: 550px !important" >
					  	<?php echo __('Description','intake_clients') ?>
					  	</th>
					  	<th style="width: 1%; max-width: 550px !important" >
					  	<?php echo __('Unit Price','intake_clients') ?>
					  	</th>
					  	<th style="width: 1%; max-width: 550px !important" >
					  	<?php echo __('Line Total','intake_clients') ?>
					  	</th>				  	
					  </tr>
					  </thead>
					  <tbody class="assets-data">
					  </tbody>
					</table>
				</div>
			</div>
			</div>
			<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
				<div class="form-group">
			    	<label for="amount">Aantal</label>
			    	<input type="number" class="form-control" id="amount" min="0">
			  	</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
				<div class="form-group">
			    	<label for="label">Label</label>
			    	<input type="text" class="form-control" id="label">
			  	</div>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
				<div class="form-group">
			    	<label for="desc">Description</label>
			    	<input type="text" class="form-control" id="desc">
			  	</div>
			
			</div>
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
				<div class="form-group">
			    	<label for="price">Price</label>
			    	<input type="number" class="form-control" id="price" min="0" step="0.01">
			  	</div>
			 
			</div>
			<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
				<div class="form-group">
			    	<label for="amount">Action</label>
			    	<a href="#" class="btn btn-success btn-block add-assets">Add</a>
			  	</div>
			
			</div>
			<?php 
				else:
					echo __('Could not find intake','intake_clients');
				endif;
			?>
		  </div>
		</div>
	</div>
</div>
<?php else : ?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<select class="form-control intakes">
				 <?php echo $form->options($Invoices);?>
				</select>
			</div>
		  </div>
		</div>
	</div>
</div>
<?php endif; ?>

<?php

$form->close(); ?>
<script type="text/javascript">
	var i = 0;
	$('.intakes').on('change', function(){
		var id = $(this).find('option:selected').val();
		if( id != 0){
			window.location.href = "<?php echo admin_url('intake-clients/add-invoice/'); ?>" + id + '/';
		}
	});
	$('.add-assets').on('click', function(e){
		e.preventDefault();
		var a = $('#amount').val();
		a = a.replace(/\s+/g, '');
		var l = $('#label').val();
		var d = $('#desc').val();
		var chd = d.replace(/\s+/g, '');
		var p = $('#price').val();
		var ia = $('#input-w_assets').val();
		if(a == ''){
			a = 0;
		}
		if(chd != ''){
			i = i + 1;
			if($('#invoice-assets').hasClass('hide')){
				$('#invoice-assets').removeClass('hide');
			}
			var ad = i + ',' + a + ',' + l + ',' + d + ',' + p + '=>';
			$('#input-w_assets').val(ia+ad);
			$('#amount').val('');
			$('#label').val('');
			$('#desc').val('');
			$('#price').val('');
			var td = '<tr class="row-assets">';
				td = td + '<td>';
				td = td + '<a class="btn btn-danger remove-this" data-add="'+ad+'" href="#">X</a>';
				td = td + '</td>';
				td = td + '<td>';
				if(a != 0) {
					td = td + a;
				}
				td = td + '</td>';
				td = td + '<td>';
				if(l != '') {
					td = td + l + '<br>';
				}
				td = td + d;
				td = td + '</td>';
				td = td + '<td>';
				if(a != 0 && p != '') {
					p = parseFloat(p).toFixed(2);
				}
				td = td + p;
				td = td + '</td>';
				td = td + '<td>';
				if(a == 0 && p != '') {
					tp = 1*p;
				} else if(p != '') {
					tp = a*p;
				} else {
					tp = '';
				}
				if(tp == 0){
					tp = '';
				} else {
					tp = parseFloat(tp).toFixed(2);
				}
				td = td + tp;
				td = td + '</td>';
				td = td + '</tr>';
			$('.assets-data').append(td);

		} else {
			$('#amount').val('');
			$('#label').val('');
			$('#desc').val('');
			$('#price').val('');
		}
	});
	$('#amount, #label, #desc, #price').on('keydown', function(e){
		if(e.keyCode == 13) {
			e.preventDefault();
			var a = $('#amount').val();
			a = a.replace(/\s+/g, '');
			var l = $('#label').val();
			var d = $('#desc').val();
			var chd = d.replace(/\s+/g, '');
			var p = $('#price').val();
			var ia = $('#input-w_assets').val();
			if(a == ''){
				a = 0;
			}
			if(chd != ''){
				i = i + 1;
				if($('#invoice-assets').hasClass('hide')){
					$('#invoice-assets').removeClass('hide');
				}
				var ad = i + ',' + a + ',' + l + ',' + d + ',' + p + '=>';
				$('#input-w_assets').val(ia+ad);
				$('#amount').val('');
				$('#label').val('');
				$('#desc').val('');
				$('#price').val('');
				var td = '<tr class="row-assets">';
					td = td + '<td>';
					td = td + '<a class="btn btn-danger remove-this" data-add="'+ad+'" href="#">X</a>';
					td = td + '</td>';
					td = td + '<td>';
					if(a != 0) {
						td = td + a;
					}
					td = td + '</td>';
					td = td + '<td>';
					if(l != '') {
						td = td + l + '<br>';
					}
					td = td + d;
					td = td + '</td>';
					td = td + '<td>';
					if(a != 0 && p != '') {
						p = parseFloat(p).toFixed(2);
					}
					td = td + p;
					td = td + '</td>';
					td = td + '<td>';
					if(a == 0 && p != '') {
						tp = 1*p;
					} else if(p != '') {
						tp = a*p;
					} else {
						tp = '';
					}
					if(tp == 0){
						tp = '';
					} else {
						tp = parseFloat(tp).toFixed(2);
					}
					td = td + tp;
					td = td + '</td>';
					td = td + '</tr>';
				$('.assets-data').append(td);

			} else {
				$('#amount').val('');
				$('#label').val('');
				$('#desc').val('');
				$('#price').val('');
			}

		}
	});
	$('body').on('click', '.remove-this', function(e){
		e.preventDefault();
		var ia = $('#input-w_assets').val();
		var d_id = $(this).data('add');
		ia = ia.replace(d_id,'');
		$('#input-w_assets').val(ia);
		$(this).closest('.row-assets').remove();
		if(ia == '') {
			$('#invoice-assets').addClass('hide');
		}
		// alert(d_id);
	});
</script>