<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<?php // print_r($checklistnames) ?>

<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<?php $form->create(); ?>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
		  			<?php $form->input('name',array('type'=>'text','label'=>__('Department name','checklist'))); ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
		  			<div><label><?php echo __('Lists','checklist'); ?></label></div>
		  			<?php foreach ($checklistnames as $key => $value) { ?>
		  				<div class="checklist-wells">
		  				<input class="flat" type="checkbox" name="data[checklist_name_ids][]" value="<?php echo $value['id'] ?>" id="id-<?php echo $value['id'] ?>"> <label for="id-<?php echo $value['id'] ?>"><?php echo $value['name']; ?></label>
		  				<div class="checklist-div"><small class="text-info"><i class="fa fa-th-large"></i> <?php echo $value['category-name'];?></small></div>
		  			    </div>

		  			<?php } ?>
		  		</div>
		  		<div class="col-lg-4"> <label> &nbsp; </label>
		  			<button class="btn btn-success btn-block"><?php echo __('Save','checklist'); ?></button>
		  		</div>
		  		<?php $form->close(); ?>
		  	</div>
		</div>
	</div>
<?php if(!empty($departments)){ ?>
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 results">
					<table id="datatable-checklist" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th class="col-lg-4 col-md-5 col-sm-6 col-xs-6"><?php echo __('Department name','checklist') ?></th>
								<th class="col-lg-8 col-md-7 col-sm-6 col-xs-6"><?php echo __('Lists','checklist') ?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($departments as $key => $value) { ?>
							<tr>
								<td>
									<?php echo $html->admin_link('<i class="fa fa-edit"></i> '.$value['name'],'checklist/edit-department/'.$value['id'].'/') ; ?>
								</td>
								<td>
									<?php foreach (explode(',', $value['checklist_name_ids']) as $val) { 
										if(isset($checklistnamesoptions[ $val])) {
											echo '<span class="listswrap bg-info">'.$checklistnamesoptions[$val].'</span>';
									?>

									<?php } }; ?>
								</td>
							</tr>
						<?php }; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php }; ?>
</div>