<?php if(!empty($Intake)): ?>
<?php $form->create(['class'=>'no-enter', 'attribute' => 'autocomplete="off"', 'file-upload' => true]); ?>
<div class="container-fluid"> 
    <div class="row">
      <div class="col-lg-12 col-md-12 text-right">
       <?php $form->input('save',array('value' => __('Save','intake_clients'),'type'=>'submit','class'=>'bsave btn btn-success','no-wrap' => true)) ?>
       <?php // echo $html->admin_link(__('Cancel','clients'),'clients/view/'.$Client['id'].'/', array('class'=>'bclose btn btn-danger')) ?>
      </div>
    </div>  
</div>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  <div class="row">
		  	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
		  		<?php $form->input('other-client',['label'=>__('Select different client to intake','intake_clients'),'value' => '1', 'class' => 'flat', 'type' => 'checkbox', 'label-pos' => 'after']); ?>
		  	</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="this-client">
				<?php // $form->input('client_id',['value'=>$Client['id'], 'type' => 'hidden', 'no-wrap' => true]); ?>
				<?php
				echo '<b>'.__('First name','intake_clients') . '</b>: '.$Client['f_name'].'<br>';
				echo '<b>'.__('Last name','intake_clients') . '</b>: '.$Client['l_name'].'<br>';
				echo '<b>'.__('Address','intake_clients') . '</b>: '.$Client['address'].'<br>';
				echo '<b>'.__('Telephone','intake_clients') . '</b>: '.$Client['telephone'].'<br>';
				if($Client['email'] != '') {
					echo '<b>'.__('E-mail','intake_clients') . '</b>: '.$Client['email'].'<br>';
				}
				
				 ?>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hide" id="other-client">
				<select class="form-control" name="data[new-client]">
					<?php echo $form->options($Clients_array, array('key' => $Intake['client_id']));?>
				</select>
			</div>
			
		  </div>
		</div>
	</div>
</div>

<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  <div class="row">
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('intake_type',['label'=>__('Product type','intake_clients'),'value' => $Intake['type']]); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('intake_brand',['label'=>__('Product brand','intake_clients'),'value' => $Intake['brand']]); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('intake_model',['label'=>__('Product model','intake_clients'),'value' => $Intake['intake_model']]); ?>
			</div>
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
				<?php $form->textarea('problem_text',['label'=>__('Problem device','intake_clients'),'value' => $Intake['problem_text']]); ?>
			</div>
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
				<?php $form->textarea('work_solving',['label'=>__('Checkup','intake_clients'),'value' => $Intake['work_solving']]); ?>
			</div>
			<?php if($Intake['intake_model_charger'] != '' || $Intake['intake_model_charger_doc'] != '' || $Intake['intake_model_extra_doc'] != ''): ?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('add_charger',['label'=>__('Add Product attachments','intake_clients'), 'type' => 'checkbox', 'class' => 'flat', 'label-pos' => 'after', 'attribute' => 'checked']);?>
			</div>
			<?php $chhide = '';?>
			<?php else: ?>
			<?php $chhide = 'hide';?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('add_charger',['label'=>__('Add Product attachments','intake_clients'), 'type' => 'checkbox', 'class' => 'flat', 'label-pos' => 'after']);?>
			</div>
			<?php endif; ?>

			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 charger-add <?php echo $chhide ?>">
				<?php $form->textarea('charger_text',['label'=>__('Attachments info','intake_clients'), 'value' => $Intake['intake_model_charger']]);?>
			</div>
			<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 charger-add <?php echo $chhide ?>">
				<?php $form->input('charger_photo',['label'=>__('Add Attachments','intake_clients'), 'type' => 'file']);?>
			</div>
			<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 extra-add <?php echo $chhide ?>">
				<?php $form->input('extra_photo',['label'=>__('Add Extra Attachments','intake_clients'), 'type' => 'file']);?>
			</div>
		  </div>
		</div>
	</div>
</div>
<?php $form->close(); ?>
<?php else: ?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
				<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
					<?php echo __('Nothing to edit','intake_clients');?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>
<script type="text/javascript">
	$('#input-add_charger').on('ifChecked', function () {
    	$('.charger-add, .extra-add').removeClass('hide');
	});
	$('#input-add_charger').on('ifUnchecked', function () {
    	$('.charger-add, .extra-add').addClass('hide');
	});

</script>


