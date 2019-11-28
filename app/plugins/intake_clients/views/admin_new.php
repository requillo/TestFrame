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
<?php if(!empty($Client)): ?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('client_id',['value'=>$Client['id'], 'type' => 'hidden', 'no-wrap' => true]); ?>
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
		  </div>
		</div>
	</div>
</div>
<?php else : ?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  <div class="row">
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('f_name',['label'=>__('First name','intake_clients')]); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('l_name',['label'=>__('Last name','intake_clients')]); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('company',['label'=>__('Company','intake_clients')]); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('telephone',['label'=>__('Telephone','intake_clients')]); ?>
			</div>
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('address',['label'=>__('Address','intake_clients')]); ?>
			</div>
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('email',['label'=>__('E-mail','intake_clients')]); ?>
			</div>
		  </div>
		</div>
	</div>
</div>
<?php endif; ?>

<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  <div class="row">
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('intake_type',['label'=>__('Product type','intake_clients')]); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('intake_brand',['label'=>__('Product brand','intake_clients')]); ?>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<?php $form->input('intake_model',['label'=>__('Product model','intake_clients')]); ?>
			</div>
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
				<?php $form->textarea('problem_text',['label'=>__('Problem device','intake_clients')]); ?>
			</div>
			<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
				<?php $form->textarea('work_solving',['label'=>__('Checkup','intake_clients')]); ?>
			</div>
		  </div>
		</div>
	</div>
</div>

<?php

$form->close();