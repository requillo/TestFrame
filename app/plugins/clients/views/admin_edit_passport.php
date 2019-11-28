<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$form->create(['file-upload' => true]); ?>
<div class="container-fluid"> 
    <div class="row">
      <div class="col-lg-12 col-md-12 text-right">
       <?php $form->submit(__('Update','clients'),'btn btn-success');?>
       <?php echo $html->admin_link(__('Cancel','clients'),'clients/view/'.$Client['id'].'/', array('class'=>'bclose btn btn-danger')) ?>
      </div>
    </div>  
</div>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-body">
	<div class="row">
		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<?php $form->input('passport_number',array('label' => __('Passport number','clients'), 'value' => $Passport['passport_number']))?>
		</div>
		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
			<label><?php echo __('Passport type','clients');?></label>
			<select name="data[passport_type]" class="form-control">
				<?php echo $form->options($Passport_type, array('key' => $Passport['passport_type']));?>
			</select>
			
			</div>
		</div>
		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<?php $form->input('start_date',array('label' => __('Date of issue','clients'), 'class' => 'date-picker1 form-control'))?>
		</div>
		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<?php $form->input('end_date',array('label' => __('Date of expiry','clients'), 'class' => 'date-picker2 form-control'))?>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?php $form->input('copy_document',array('label' => '<i class="fa fa-upload" aria-hidden="true"></i> '. __('Upload copy passport','clients') . ' <small class="text-warning">(max 5mb)</small>', 'type' => 'file'))?>
		</div>
	</div>
	</div>
	</div>
</div>
<?php $form->close(); ?>