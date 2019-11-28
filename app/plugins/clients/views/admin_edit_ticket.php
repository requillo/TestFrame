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
			<?php $form->input('ticket_number',array('label' => __('Ticket number','clients'), 'value' => $Ticket['ticket_number']))?>
			<?php $form->textarea('destination', array('label' => __('Destination','clients'), 'value' => $Ticket['destination'], 'class' => 'form-control destination-text'))?>
		</div>
		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
			<label><?php echo __('Travel type','clients');?></label>
			<select name="data[ticket_type]" class="form-control">
				<?php echo $form->options($Travel_type, array('key' =>  $Ticket['ticket_type']));?>
			</select>
			</div>
			<?php $form->input('start_date',array('label' => __('Departure','clients'), 'class' => 'date-picker1 form-control', 'value' => date('d-m-Y', strtotime($Ticket['start_date']))))?>
			<?php $form->input('end_date',array('label' => __('Return','clients'), 'class' => 'date-picker2 form-control', 'value' => date('d-m-Y', strtotime($Ticket['end_date']))))?>
			<div class="form-group">
			<label class="control-label" for="amount"><?php echo __('Price','clients');?></label>
			<div class="input-group">
      			<span class="input-group-addon">
      			<select name="data[currency]">
      			<?php echo $form->options($Currency);?>
      			</select></span>
      			<input type="text" name="data[amount]" class="form-control" id="amount" placeholder="">
    			</div>
			</div>
			<div class="form-group">
			<label><?php echo __('Status','clients');?></label>
			<select name="data[travel_status]" class="form-control">
				<?php echo $form->options($Status);?>
			</select>
			</div>
		</div>
	</div>
	</div>
	</div>
</div>
<?php $form->close(); ?>