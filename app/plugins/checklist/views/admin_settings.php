
<?php if(empty($checklist_settings)) { ?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<?php $form->create(array('class' => 'no-enter')); ?>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('email_address',array('type'=>'text','label'=>__('E-mail from','checklist').'<br><small>'.__('This email address will be used to sent mails from','checklist').'</small>')); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('email_pass',array('type'=>'text','label'=>__('E-mail Password','checklist'))); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('email_smtp',array('type'=>'text','label'=>__('Mail SMTP','checklist'))); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('email_security',array('type'=>'text','label'=>__('Mail Security','checklist') .'<br><small>'.__('Use tls, ssl, none','checklist').'</small>')); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('email_port',array('type'=>'number','label'=>__('SMTP Port','checklist'))); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('email_sent_to',array('type'=>'text','label'=>__('E-mail address to sent mails to','checklist').'<br><small>'.__('Add multiple email addresses with , separation','checklist').'</small>')); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('time_array',array('type'=>'text','label'=>__('Time array','checklist'))); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('dashboard_limit',array('type'=>'number','label'=>__('Show checklist limit','checklist').'<br><small>'.__('Max limit on lists to show on main page','checklist').'</small>')); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('time_to_edit',array('type'=>'number','label'=>__('Time to edit','checklist').'<br><small>'.__('Max limit in minutes to edit after the list is added','checklist').'</small>')); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('shifts',array('type'=>'text','label'=>__('Time to edit','checklist').'<br><small>'.__('Add shifts like "Shifts 1=08:00-16:00,Shift 2=16:00-00:00"','checklist').'</small>')); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<button class="btn btn-success"><?php echo __('Save','checklist')?></button>
		  		</div>
		  		<?php $form->close(); ?>
		  	</div>
		</div>
	</div>
</div>
<?php } else { ?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<?php $form->create(array('class' => 'no-enter')); ?>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('email_address',array('type'=>'text','label'=>__('E-mail from','checklist').'<br><small>'.__('This email address will be used to sent mails from','checklist').'</small>', 'value' => $checklist_settings['email_address'])); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('email_pass',array('type'=>'text','label'=>__('E-mail Password','checklist'), 'value' => $checklist_settings['email_pass'])); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('email_smtp',array('type'=>'text','label'=>__('Mail SMTP','checklist'), 'value' => $checklist_settings['email_smtp'])); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('email_security',array('type'=>'text','label'=>__('Mail Security','checklist') .'<br><small>'.__('Use tls, ssl, none','checklist').'</small>', 'value' => $checklist_settings['email_security'])); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('email_port',array('type'=>'number','label'=>__('SMTP Port','checklist'), 'value' => $checklist_settings['email_port'])); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('email_sent_to',array('type'=>'text','label'=>__('E-mail address to sent mails to','checklist').'<br><small>'.__('Add multiple email addresses with , separation','checklist').'</small>', 'value' => $checklist_settings['email_sent_to'])); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('time_array',array('type'=>'text','label'=>__('Time array','checklist'), 'value' => $checklist_settings['time_array'])); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('dashboard_limit',array('type'=>'number','label'=>__('Show checklist limit','checklist').'<br><small>'.__('Max limit on lists to show on main page','checklist').'</small>', 'value' => $checklist_settings['dashboard_limit'])); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('time_to_edit',array('type'=>'number','label'=>__('Time to edit','checklist').'<br><small>'.__('Max limit in minutes to edit after the list is added','checklist').'</small>', 'value' => $checklist_settings['time_to_edit'])); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('shifts',array('type'=>'text','label'=>__('Time to edit','checklist').'<br><small>'.__('Add shifts like "Shifts 1=08:00-16:00,Shift 2=16:00-00:00"','checklist').'</small>', 'value' => $checklist_settings['shifts'])); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<button class="btn btn-success"><?php echo __('Save','checklist')?></button>
		  		</div>
		  		<?php $form->close(); ?>
		  	</div>
		</div>
	</div>
</div>
<?php } ?>
<script type="text/javascript">
$('input[name="data[email_sent_to]"]').amsifySuggestags({defaultLabel:'Add E-mail addresses', defaultTagClass: 'bg-success'});
$('input[name="data[shifts]"]').amsifySuggestags({defaultLabel:'Add Shifts', defaultTagClass: 'bg-success'});
$('input[name="data[time_array]"]').amsifySuggestags({
  type : 'bootstrap',
  suggestions: ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00','20:30','21:00','21:30','22:00','22:30','23:00','23:30','24:00'],
  defaultLabel:'Add time here', defaultTagClass: 'bg-success',
});
</script>