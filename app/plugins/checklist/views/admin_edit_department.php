<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$listnames =  explode(',', $departments['checklist_name_ids']);
?>
<pre>
	<?php // print_r($checklistnames); ?>
	<?php // print_r($checklistnamesoptions); ?>
</pre>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<?php $form->create(); ?>
		  		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
		  			<?php $form->input('name',array('type'=>'text','label'=>__('Department name','checklist'),'value' => $departments['name'])); ?>
		  		</div>
		  		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5"> <label> &nbsp; </label>
		  			<button class="btn btn-success btn-block"><?php echo __('Save','checklist'); ?></button>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<div><label><?php echo __('Lists','checklist'); ?></label></div>
		  			<?php foreach ($checklistnames as $key => $value) { ?>
		  				<div class="checklist-wells">
		  				<?php if(in_array($value['id'], $listnames)) {
		  					$checked = 'checked';
		  				} else {
		  					$checked = '';
		  				} ?>
		  				<input class="flat" type="checkbox" name="data[checklist_name_ids][]" value="<?php echo $value['id'] ?>" id="id-<?php echo $value['id'] ?>" <?php echo $checked ?>> <label for="id-<?php echo $value['id'] ?>"><?php echo $value['name']; ?></label>
		  				<div class="checklist-div"><small class="text-info"><i class="fa fa-th-large"></i> <?php echo $value['category-name'];?></small></div>
		  			    </div>

		  			<?php } ?>
		  		</div>
		  		
		  		<?php $form->close(); ?>
		  	</div>
		</div>
	</div>
</div>