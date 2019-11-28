<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$form->create(['file-upload' => true]); ?>
<div class="container-fluid"> 
    <div class="row">
      <div class="col-lg-12 col-md-12 text-right">
       <?php $form->submit(__('Add','clients'),'btn btn-success');?>
       <?php echo $html->admin_link(__('Cancel','clients'),'clients/view/'.$Client['id'].'/', array('class'=>'bclose btn btn-danger')) ?>
      </div>
    </div>  
</div>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-body">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?php $form->input('name',array('label' => __('Visa Name','clients')))?>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?php $form->input('start_date',array('label' => __('Date of issue','clients'), 'class' => 'date-picker1 form-control'))?>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?php $form->input('end_date',array('label' => __('Date of expiry','clients'), 'class' => 'date-picker2 form-control'))?>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?php $form->input('copy_document',array('label' => '<i class="fa fa-upload" aria-hidden="true"></i> '. __('Upload visa document','clients') . ' <small class="text-warning">(max 5mb)</small>', 'type' => 'file'))?>
		</div>
	</div>
</div>
</div>
</div>
<?php $form->close(); ?>