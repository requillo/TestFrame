<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<?php $form->create(); ?>
		  		<div class="col-lg-6">
		  			<?php $form->input('terminal',array('type'=>'text','label'=>__('Terminal name','smiley_survey'))); ?>
		  		</div>
		  		<div class="col-lg-6">
		  			<label for="company_id_select"><?php echo __('Company','smiley_survey'); ?></label>
		  			<select name="data[company_id]" class="form-control" id="company_id_select">
		  				 <?php echo $form->options($company_options) ?>
		  			</select>
		  		</div>
		  		<div class="col-lg-12"><button class="btn btn-success"><?php echo __('Save','smiley_survey'); ?></button></div>
		  		<?php $form->close(); ?>
		  	</div>
		</div>
	</div>
<?php if(!empty($terminals)){ ?>
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-12">
				<div class="results">
					<table id="datatable-terminals" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th><?php echo __('Company','smiley_survey') ?></th>
								<th><?php echo __('Terminal','smiley_survey') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($terminals as $terminal) { ?>
							<tr>
								<td><?php echo $company_options[$terminal['company_id']];?></td>
								<td><?php echo $terminal['terminal'];?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				</div>
		  	</div>
		</div>
	</div>
<?php } ?>
</div>
<script type="text/javascript">
	if($('#datatable-terminals').length) {
		$('#datatable-terminals').DataTable();
	}
</script>
