<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<?php $form->create(array('class' => 'no-enter')); ?>
		  		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('name',array('type'=>'text','label'=>__('Shift name','checklist'))); ?>
		  		</div>
		  		<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('shift_start',array('type'=>'time','label'=>__('Shift start','checklist'))); ?>
		  		</div>
		  		<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->input('shift_end',array('type'=>'time','label'=>__('Shift end','checklist'))); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<button class="btn btn-success"><?php echo __('Save','checklist')?></button>
		  		</div>
		  		<?php $form->close(); ?>
		  	</div>
		</div>
	</div>
</div>