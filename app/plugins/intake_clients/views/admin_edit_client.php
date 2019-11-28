<?php if(!empty($Client)): ?>
<?php $form->create(); ?>
<div class="container-fluid">
<?php $form->submit('<i class="fa fa-save"></i> '.__('Save','intake_clients'),'btn-success pull-right'); ?>	
</div>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  <div class="row">
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('f_name',['label'=>__('First name','intake_clients'), 'value' => $Client['f_name']]); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('l_name',['label'=>__('Last name','intake_clients'), 'value' => $Client['l_name']]); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('telephone',['label'=>__('Telephone','intake_clients'), 'value' => $Client['telephone']]); ?>
			</div>
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('address',['label'=>__('Address','intake_clients'), 'value' => $Client['address']]); ?>
			</div>
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('email',['label'=>__('E-mail','intake_clients'), 'value' => $Client['email']]); ?>
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
					<?php echo __('Nothing to edit','intake_clients'); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>