<?php 

?>
<div class="processing hide">
	<div class="load-overlay bg-dark"></div>
	<div class="load-processing bg-primary text-center"><i class="fa fa-cog fa-spin"></i> <?php echo __("Please wait while your data is being imported","donations") ?></div>
</div>
<div class="container-fluid"> 
    <div class="row">
		<div class="col-lg-6 col-md-12 text-right">
			<select name="data[companies]" class="form-control" id="get_company">
				<option> <?php echo __('Select a company','donations');?></option>
				 <?php echo $Company_options;?>
			</select>
			<input class="main_link hide" value="<?php echo url();?>">
			<input class="text-price hide" value="<?php echo __('Price','donations');?>">
			<input class="text-yes hide" value="<?php echo __('Yes','donations');?>">
			<input class="text-no hide" value="<?php echo __('No','donations');?>">
			<input class="text-sure-del hide" value="<?php echo __('Are you sure you want to delete this!','donations');?>">
		</div>
    </div>  
</div>
<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="" role="tabpanel" data-example-id="togglable-tabs">
					<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
						<?php 
						$i = 1;
						foreach ($Donation_types as $key => $value) {
							$key = trim($key);
							if($i == 2) {
								$active = 'active';
							} else {
								$active = '';
							}
						$i++;
						$crname = replace_spec_chars($value,"-");
						if($key > 1) {
						?>
						<li role="presentation" class="<?php echo $active;?>">
							<a href="#tabcontent-<?php echo $key;?>" id="<?php echo $crname;?>-tab" data-toggle="tab" aria-expanded="true">
								<?php echo $value;?>
							</a>
						</li>
						<?php }} ?>
					</ul>
					<div id="myTabContent" class="tab-content">
						<?php 
						$i = 1;
						foreach ($Donation_types as $key => $value) { 
							$key = trim($key);
							if($i == 2) {
								$active = 'active';
							} else {
								$active = '';
							}
						$i++;
						$crname = replace_spec_chars($value,"-");
						if($key > 1) {
						?>
						<div role="tabpanel" class="tab-pane fade <?php echo $active;?> in" id="tabcontent-<?php echo $key;?>" aria-labelledby="<?php echo $crname;?>-tab">
							<div class="type_id"><?php $form->input('donation_types',array('value'=>$key,'class'=>'type hide')); ?></div>
							<div class="results"><span><?php echo __('Please select a company to load ').strtolower($value);?></span>
								<table id="datatable-ass-<?php echo $key ?>" class="table table-striped table-bordered datatable-ass-">
									<thead><tr><th style="width: 160px">Product Id</th><th>Description</th><th>Unit</th><th style="width: 300px">Price</th></tr></thead>
									<tbody></tbody>
								</table>
							</div>
							<div class="addtoassets row">
								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									<?php $form->input('item_code',array('label'=>__('Item Code','donations')));?>
								</div>
								<div class="col-lg-5 col-md-4 col-sm-12 col-xs-12">
									<?php $form->input('desc',array('label'=>__('Description','donations')));?>
								</div>
								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									<?php $form->input('unit',array('label'=>__('Per unit','donations')));?>
								</div>
								<div class="col-lg-2 col-md-2 col-sm-9 col-xs-9">
									<?php $form->input('price',array('label' =>__('Price in SRD','donations')));?>
								</div>
								<div class="col-lg-1 col-md-1 col-sm-3 col-xs-3">
									<label style="display: block;">&nbsp;</label>
									<a class="btn btn-success addasset" href="#"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo __('Add','donations');?></a>
								</div>
							</div>
							<div class="import_csv_items row">
								<div class="loading hide">Loading, please wait ...</div>
								<?php $form->create(array('class' => 'add_items','file-upload' => true)); ?>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div><label><?php echo __('Data inputs for csv import') ?></label></div>
									<div class="csv-data-inputs">
										<span class="csv-data">Item Code</span>
										<span class="csv-data">Item description</span>
										<span class="csv-data">Per unit</span>
										<span class="csv-data">Price</span>
									</div>
									<?php $form->input('import_csv_'.$key,array('label'=>'<i class="fa fa-upload" aria-hidden="true"></i> '.__('Import CSV','donations'), 'type' => 'file'));?>
									
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<?php $form->submit('Import');?>
								</div>
								<?php $form->close(); ?>
							</div>
						</div>
						<?php }} ?>
					</div>
				</div>
				<?php 
				?>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('input[type=file]').on('change', function(e) {
		$('.ftl-error').remove();
		var f = $(this).val();
		var ext = f.split('.').pop().toLowerCase();
		// alert(ext);
        if(ext != 'csv') {
        	$(this).closest('.form-group').find('.uploadlabel').append('<span class="ftl-error text-danger"> Invalid file format</span>');
        } 
	});
</script>
