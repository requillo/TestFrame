<div class="container-fluid fuel-settings-page">
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row fuel-menu-buttons">
		  		<?php foreach ($btns as $key => $value) { ?>
		  		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
		  			<a href="<?php echo admin_url('fuel-inventory/settings/'.$value['link'].'/'); ?>" class="btn btn-block <?php echo $value['class']; ?>">
		  				<h3><?php echo $value['name']; ?></h3>
		  			</a>
		  		</div>
		  		<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php if($page) { ?>
<?php if($page[0] == 'products') { ?>
<div class="container-fluid"> 
	<div class="panel panel-default fuel-settings-page">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4"><?php $form->input('id', array('placeholder' => __('Id','fuel_inventory'),'attribute' => 'min="1"')) ?></div>
		  		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php $form->input('products', array('placeholder' => __('Products','fuel_inventory'))) ?></div>
		  		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?php $form->input('alias', array('placeholder' => __('Alias','fuel_inventory'))) ?></div>
		  		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><a href="#" class="btn btn-block btn-success add-prod"><?php echo __('Add','fuel_inventory');?></a></div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<div id="products-table" class="pos-rel">
						<div class="table-responsive" id="table-products">
				  			<table id="all-products" class="table table-striped table-bordered table-hover">
				  				<thead>
								  	<tr>
									  	<th style="width: 70px"><?php echo __('Id','fuel_inventory');?></th>
									  	<th><?php echo __('Products','fuel_inventory');?></th>
									  	<th><?php echo __('Alias','fuel_inventory');?></th>
									  	<th style="width: 180px"><?php echo __('Action','fuel_inventory');?></th>
								  	</tr>
								  </thead>
								  <tbody>
								  	<?php foreach ($products as $key => $value) { ?>
								  		<tr>
								  			<td style="vertical-align: middle;">
								  				<span class="info"><?php echo $value['product_id'];?></span>
								  				<input type="" class="form-control product_id hide" value="<?php echo $value['product_id'];?>">
								  			</td>
								  			<td style="vertical-align: middle;">
								  				<a href="#" class="edit-data"><?php echo $value['product'];?></a>
								  				<input type="" class="form-control product hide" value="<?php echo $value['product'];?>">
								  			</td>
								  			<td style="vertical-align: middle;">
								  				<span class="info"><?php echo $value['product_alias'];?></span>
								  				<input type="" class="form-control product_alias hide" value="<?php echo $value['product_alias'];?>">
								  			</td>
								  			<td style="vertical-align: middle;">
								  				<a href="#" class="btn btn-danger btn-sm fa fa-close del-prod del-btn" data-id="<?php echo $value['id'];?>"> <?php echo __('Delete','fuel_inventory');?></a>
								  				<a href="#" class="btn btn-success btn-sm fa fa-save edit-prod the-edit hide" data-id="<?php echo $value['id'];?>"> <?php echo __('Save','fuel_inventory');?></a>
								  				<a href="#" class="btn btn-default btn-sm fa fa-close cancel-data hide"> <?php echo __('Cancel','fuel_inventory');?></a>
								  			</td>
								  		</tr>
								  	<?php } ?>
								  </tbody>
				  			</table>
				  		</div>
				  	</div>
		  		</div>
		  	</div>
		</div>
	</div>
</div>
<?php } else if($page[0] == 'gas-stations'){ ?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 style="text-align: bottom; vertical-align: middle;">
			<?php echo __('Add Gas Station','fuel_inventory');?> 
			
			</h3> 
		</div>
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-4 col-md-5 col-sm-5 col-xs-12">
		  			<div class="featured_image">
		  				<img src="<?php echo URL.default_image(); ?>">
		  			</div>
		  			<?php $form->input('upload_doc',array('type'=>'file','label'=>'<i class="fa fa-upload" aria-hidden="true"></i> <span class="tupl">'.__('Company image','fuel_inventory').'</span> <small class="text-warning">(max 3mb)</small>')); ?>
				<input type="text" name="data[featured_image]" id="comp_image" class="hide" value="">
				<div class="progress abs-progress hide">
					<div class="the-prog bg-danger"></div>
				</div>
		  		</div>
		  		<div class="col-lg-8 col-md-7 col-sm-7 col-xs-12 " id="station-wrapper-data-add">
		  			<div class="row">
		  				<?php if($map_markers && !empty($marker_option)) { ?>
		  				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  					<div class="form-group">
		  					<div class="alert alert-danger">
		  					<?php echo __('You can select a Marker from the Map','fuel_inventory') ?> 
		  				<select class="select-stations form-control-inline">
		  					<option value="0"><?php echo __('Select a Marker','fuel_inventory') ?></option>
		  					<?php echo $form->options($marker_option); ?>
		  					</select> <span class="text-danger">(<?php echo __('Optional','fuel_inventory') ?>)</span>
		  					</div>
							</div>
		  				</div>
		  				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
		  				<?php } ?>
						<div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
							<?php $form->input('site_id', array(
								'type' => 'number',
								'label' => __('Site Id','fuel_inventory'),
								'attribute' => 'min="1"'
								)) ?>
						</div>
				  		<div class="col-lg-8 col-md-7 col-sm-6 col-xs-12">
				  			<?php $form->input('dealer', array(
				  				'label' => __('Dealer','fuel_inventory'),
				  				'attribute'=>'autocomplete="off"'
				  				)) ?> 
				  		</div>
				  		<div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
				  			<?php $form->input('district', array(
				  				'label' => __('District / Area','fuel_inventory'),
				  				'attribute'=>'autocomplete="off"'
				  				)) ?> 
				  		</div>
				  		<div class="col-lg-8 col-md-7 col-sm-6 col-xs-12">
				  			<?php $form->input('address', array(
				  				'label' => __('Address','fuel_inventory'),
				  				'attribute'=>'autocomplete="off"'
				  				)) ?> 
				  		</div>
				  		<div class="col-lg-4 col-md-5 col-sm-6 col-xs-12"> 
				  			<?php $form->input('phone', array(
				  				'label' => __('Telephone','fuel_inventory'),
				  				'attribute'=>'autocomplete="off"'
				  				)) ?> 
				  		</div>
				  		<div class="col-lg-8 col-md-7 col-sm-6 col-xs-12">
				  			<?php $form->input('email', array(
				  				'label' => __('E-mail','fuel_inventory'),
				  				'attribute'=>'autocomplete="off"'
				  				)) ?> 
				  		</div>
		  			</div>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  		<a href="#" class="btn btn-success add-site pull-right"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php echo __('Add','fuel_inventory');?></a>
		  		</div>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<div id="sites-table" class="pos-rel">
						<div class="table-responsive" id="table-sites">
				  			<table id="all-sites" class="table table-striped table-bordered table-hover">
				  				<thead>
								  	<tr>
									  	<th style="width: 70px"><?php echo __('Id','fuel_inventory');?></th>
									  	<th><?php echo __('Dealer','fuel_inventory');?></th>
									  	<th><?php echo __('Address','fuel_inventory');?></th>
									  	<th><?php echo __('Place','fuel_inventory');?></th>
									  	<th><?php echo __('Phone','fuel_inventory');?></th>
									  	<th><?php echo __('Email','fuel_inventory');?></th>
									  	<th style="width: 180px"><?php echo __('Action','fuel_inventory');?></th>
								  	</tr>
								  </thead>
								  <tbody>
								  	<?php foreach ($sites as $key => $value) { ?>
								  		<tr>
								  			<td style="vertical-align: middle;">
								  				<span class="info"><?php echo $value['site_id'];?></span>
								  				<input type="" class="form-control site_id hide" value="<?php echo $value['site_id'];?>">
								  			</td>
								  			<td style="vertical-align: middle;">
								  				<a href="<?php echo admin_url('fuel-inventory/edit-gas-station/'.$value['site_id'].'/') ?>" class=""><?php echo $value['dealer'];?></a>
								  				<input type="" class="form-control dealer hide" value="<?php echo $value['dealer'];?>">
								  			</td>
								  			<td style="vertical-align: middle;">
								  				<span class="info"><?php echo $value['address'];?></span>
								  				<input type="" class="form-control address hide" value="<?php echo $value['address'];?>">
								  			</td>
								  			<td style="vertical-align: middle;">
								  				<span class="info"><?php echo $value['district'];?></span>
								  				<input type="" class="form-control district hide" value="<?php echo $value['district'];?>">
								  			</td>
								  			<td style="vertical-align: middle;">
								  				<span class="info"><?php echo $value['phone'];?></span>
								  				<input type="" class="form-control phone hide" value="<?php echo $value['phone'];?>">
								  			</td>
								  			<td style="vertical-align: middle;">
								  				<span class="info"><?php echo $value['email'];?></span>
								  				<input type="" class="form-control email hide" value="<?php echo $value['email'];?>">
								  			</td>
								  			<td style="vertical-align: middle;">
								  				<a href="#" class="btn btn-danger btn-sm fa fa-close del-site del-btn" data-id="<?php echo $value['id'];?>"> <?php echo __('Delete','fuel_inventory');?></a>
								  			</td>
								  		</tr>
								  	<?php } ?>
								  </tbody>
				  			</table>
				  		</div>
				  	</div>
		  		</div>
		  	</div>
		</div>
	</div>
</div>
<?php } else if($page[0] == 'tanks'){?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-1 col-md-2 col-sm-3 col-xs-4"><?php $form->input('tank_id', array('placeholder' => __('Id','fuel_inventory'))) ?></div>
		  		<div class="col-lg-4 col-md-6 col-sm-6 col-xs-4"><?php $form->input('tank', array('placeholder' => __('Tank','fuel_inventory'))) ?></div>
		  		<div class="col-lg-1 col-md-2 col-sm-3 col-xs-4"><a href="#" class="btn btn-success btn-block add-tank"><?php echo __('Add','fuel_inventory');?></a></div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<div id="tanks-table" class="pos-rel">
						<div class="table-responsive" id="table-tanks">
				  			<table id="all-tanks" class="table table-striped table-bordered table-hover">
				  				<thead>
								  	<tr>
									  	<th style="width: 70px"><?php echo __('Id','fuel_inventory');?></th>
									  	<th><?php echo __('Tanks','fuel_inventory');?></th>
									  	<th style="width: 180px"><?php echo __('Action','fuel_inventory');?></th>
								  	</tr>
								  </thead>
								  <tbody>
								  	<?php foreach ($tanks as $key => $value) { ?>
								  		<tr>
								  			<td style="vertical-align: middle;">
								  				<span class="info"><?php echo $value['tank_id'];?></span>
								  				<input type="" class="form-control tank_id hide" value="<?php echo $value['tank_id'];?>">
								  			</td>
								  			<td style="vertical-align: middle;">
								  				<a href="#" class="edit-data"><?php echo $value['tank'];?></a>
								  				<input type="" class="form-control tank hide" value="<?php echo $value['tank'];?>">
								  			</td>
								  			<td style="vertical-align: middle;">
								  				<a href="#" class="btn btn-danger btn-sm fa fa-close del-tank del-btn" data-id="<?php echo $value['id'];?>"> <?php echo __('Delete','fuel_inventory');?></a>
								  				<a href="#" class="btn btn-success btn-sm fa fa-save edit-tank the-edit hide" data-id="<?php echo $value['id'];?>"> <?php echo __('Save','fuel_inventory');?></a>
								  				<a href="#" class="btn btn-default btn-sm fa fa-close cancel-data hide"> <?php echo __('Cancel','fuel_inventory');?></a>
								  			</td>
								  		</tr>
								  	<?php } ?>
								  </tbody>
				  			</table>
				  		</div>
				  	</div>
		  		</div>
		  	</div>
		</div>
	</div>
</div>
<?php } else if($page[0] == 'relations'){?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">		  		
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  		</div>
		  		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		  			<div class="list-group">
		  			<?php foreach ($sites as $key => $value) { 
		  				if($page[1] == $value['site_id']) {
		  					$act = 'list-group-item-success';
		  				} else {
		  					$act = '';
		  				}
		  				?>
		  			<a class="list-group-item list-group-item-action <?php echo $act ?>" href="<?php echo admin_url('fuel-inventory/settings/relations/'.$value['site_id']) ;?>"><?php echo $value['dealer'];?></a>
		  			<?php } ?>
		  			</div>
		  		</div>
		  		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		  			<div class="row">
			  		<div class="col-lg-4 col-md-5 col-sm-5 col-xs-5">
			  			<input type="text" name="site" value="<?php echo $page[1] ?>" class="hide" id="site_relation">
			  			<select class="form-control" id="tank_relation">
			  				<?php echo $form->options($tank_options); ?>
			  			</select>
			  		</div>
			  		<div class="col-lg-4 col-md-5 col-sm-5 col-xs-5">
			  			<select class="form-control" id="product_relation">
			  				<?php echo $form->options($product_options); ?>
			  			</select>
			  		</div>
			  		<div class="col-lg-4 col-md-2 col-sm-2 col-xs-2"><a href="#" class="btn btn-success btn-block add-relation"><?php echo __('Add','fuel_inventory');?></a></div>
			  		</div>
		  			<div id="relations-table" class="pos-rel">
						<div class="table-responsive" id="table-relations">
				  			<table id="all-relations" class="table table-striped table-bordered table-hover">
				  				<thead>
								  	<tr>
									  	<th><?php echo __('Tank','fuel_inventory');?></th>
									  	<th><?php echo __('Product','fuel_inventory');?></th>
									  	<th style="width: 180px"><?php echo __('Action','fuel_inventory');?></th>
								  	</tr>
								  </thead>
								  <tbody>
								  	<?php foreach ($relations as $key => $value) { ?>
								  		<tr>
								  			<td style="vertical-align: middle;">
								  				<a href="#" class="edit-data"><?php echo $value['tank']['tank'];?></a>
								  				<select class="form-control tank-data hide">
									  				<?php echo $form->options($tank_options, array('key' => $value['tank_id'])); ?>
									  			</select>	
								  			</td>
								  			<td style="vertical-align: middle;">
								  				<span class="info the-prod"><?php echo $value['product']['product'];?></span>
								  				<select class="form-control product-data hide">
									  				<?php echo $form->options($product_options, array('key' => $value['product_id'])); ?>
									  			</select>
								  			</td>
								  			<td style="vertical-align: middle;">
								  				<a href="#" class="btn btn-danger btn-sm fa fa-close del-rel del-btn" data-id="<?php echo $value['id'];?>"> <?php echo __('Delete','fuel_inventory');?></a>
								  				<a href="#" class="btn btn-success btn-sm fa fa-save edit-rel the-edit hide" data-id="<?php echo $value['id'];?>"> <?php echo __('Save','fuel_inventory');?></a>
								  				<a href="#" class="btn btn-default btn-sm fa fa-close cancel-data hide"> <?php echo __('Cancel','fuel_inventory');?></a>
								  			</td>
								  		</tr>
								  	<?php } ?>
								  	<?php // print_r($relations) ?>
								  </tbody>
				  			</table>
				  		</div>
				  	</div>
		  		</div>
		  	</div>
		</div>
	</div>
</div>
<?php } else if($page[0] == 'colorset'){?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<div id="colors-table" class="pos-rel colors-table">
						<div class="table-responsive">
			  			<table id="all-colors" class="table table-striped table-bordered table-hover">
		  				<thead>
						  	<tr>
							  	<th><?php echo __('Main Colors','fuel_inventory');?></th>
							  	<th style="width: 180px"><?php echo __('Color','fuel_inventory');?></th>
						  	</tr>
						  </thead>
						  <tbody>
			  		<?php foreach ($colors as $key => $value) { ?>
			  		<tr>
			  			<td style="vertical-align: middle;"><?php echo $value['description'] ?></td> 
			  			<td style="vertical-align: middle;">
			  				<input class="jscolor color-input-box" value="<?php echo $value['value'] ?>">
			  				<a style="vertical-align: bottom;" href="#" class="btn btn-success btn-sm fa fa-save edit-col hide" data-id="<?php echo $value['id'] ?>"> <?php echo __('Save','fuel_inventory');?></a>
			  			</td>
			  		</tr>
					<?php } ?>
						</tbody>
						</table>
						</div>
					</div>
					<?php if(!empty($colorset_products)) { ?>
					<div id="colors-table" class="pos-rel colors-table">
						<div class="table-responsive">
			  			<table id="all-colors" class="table table-striped table-bordered table-hover">
		  				<thead>
						  	<tr>
							  	<th><?php echo __('Products colors','fuel_inventory');?></th>
							  	<th style="width: 180px"><?php echo __('Color','fuel_inventory');?></th>
						  	</tr>
						  </thead>
						  <tbody>
			  		<?php foreach ($colorset_products as $key => $value) { ?>
			  		<tr>
			  			<td style="vertical-align: middle;"><?php echo $value['description'] ?></td> 
			  			<td style="vertical-align: middle;">
			  				<input class="jscolor color-input-box" value="<?php echo $value['value'] ?>">
			  				<a style="vertical-align: bottom;" href="#" class="btn btn-success btn-sm fa fa-save edit-col hide" 
			  				data-id="<?php echo $value['id'] ?>" 
			  				data-meta="<?php echo $value['meta'] ?>" 
			  				data-re_order="<?php echo $value['re_order'] ?>" 
			  				data-description="<?php echo $value['description'] ?>" 
			  				data-input_type="<?php echo $value['input_type'] ?>"> <?php echo __('Save','fuel_inventory');?></a>
			  			</td>
			  		</tr>
					<?php } ?>
						</tbody>
						</table>
						</div>
					</div>

					<?php } ?>
				</div>
				<?php if($colors_array['value'] == 1) { $cca = '';} else {  $cca = 'checked';} ?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label><?php echo $colors_array['description'] ?></label>
					<input type="checkbox" class="js-switch use-color-array" value="<?php echo $colors_array['value'] ?>" data-id="<?php echo $colors_array['id'] ?>" <?php echo $cca; ?>> 
					<small class="text-danger">(<?php echo __('for products only') ?>)</small><span class="pload"></span>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } else if($page[0] == 'configurations'){?>

<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			  		<div id="settings-table" class="pos-rel settings-table">
						<div class="table-responsive">
				  			<table id="all-settings" class="table table-striped table-bordered table-hover">
			  				<thead>
							  	<tr>
								  	<th><?php echo __('Configurations','fuel_inventory');?></th>
								  	<th style="width: 150px"><?php echo __('Value','fuel_inventory');?></th>
								  	<th style="width: 90px"><?php echo __('Action','fuel_inventory');?></th>
							  	</tr>
							  </thead>
							  <tbody>
							<?php foreach ($thresholds as $key => $value) { ?>
						  		<tr>
							  		<td style="vertical-align: middle;"><?php echo ucwords(str_replace('-', ' ', $value['meta'])); ?> (<?php echo $value['description'] ?> <span class="thresholds-box text-danger"><?php echo $value['value'] ?></span> <span class="info">%</span>)</td>
							  		<td style="vertical-align: middle;"><div class="input-group">
								        <input type="number" name="" class="form-control settings-input" min="0" max="100" value="<?php echo $value['value'] ?>">
								        <span class="input-group-addon">%</span>
								      </div>
							  		</td>
							  		<td style="vertical-align: middle;"><a href="#" class="btn btn-success btn-block btn-sm fa fa-save edit-threshold the-edit" data-id="<?php echo $value['id'] ?>"> <?php echo __('Save','fuel_inventory');?></a></td>
						  		</tr>
							<?php } ?>
		  					<?php foreach ($configurations as $key => $value) { ?>
		  						<tr>
							  		<td style="vertical-align: middle;"><?php echo $value['description'] ?></td>
							  		<td style="vertical-align: middle;"><div class="input-group">
								        <input type="number" name="" min="0" class="form-control settings-input" value="<?php echo $value['value'] ?>">
								        <span class="input-group-addon">Minutes</span>
								      </div></td>
							  		<td style="vertical-align: middle;"><a href="#" class="btn btn-success btn-block btn-sm fa fa-save edit-threshold the-edit" data-id="<?php echo $value['id'] ?>"> <?php echo __('Save','fuel_inventory');?></a></td>
						  		</tr>
							<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="dashboard-chart-table">
					<div><label><?php echo $dashboard_chart[0]['description'];?></label></div>
					<?php foreach ($dashboard_chart_options as $value) { 
						if( $value == $dashboard_chart[0]['value']) {
							$checked = 'checked';
						} else {
							$checked = '';
						}
						?>
						<label for="dash-<?php echo $value ?>"><?php echo ucfirst($value) ?></label> 
						<input id="dash-<?php echo $value ?>" 
						name="dashboard-chart" 
						type="radio" 
						class="flat dashboard-chart" 
						data-id="<?php echo $dashboard_chart[0]['id'];?>" 
						value="<?php echo $value ?>" <?php echo $checked ?>>
						&nbsp; &nbsp;&nbsp; 
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php } ?>

<?php } ?>

<script type="text/javascript">
	var loader = '<div class="loaderwrap absolute overlay"><div class="the-loader s2 load-center text-white"></div></div>';
	var loader2 = '<div class="loaderwrap absolute overlay"><div class="the-loader load-center text-white"></div></div>';
	$('body').on('click', '.edit-data', function(e){
		e.preventDefault();
		var p = $(this).closest('tr, .tr');
		p.find('.hide').removeClass('hide');
		$(this).addClass('hide');
		p.find('.info, .del-btn').addClass('hide');
	});

	$('body').on('click', '.cancel-data', function(e){
		e.preventDefault();
		var p = $(this).closest('tr, .tr');
		$(this).addClass('hide');
		p.find('.hide').removeClass('hide');
		p.find('input, select, .the-edit, .cancel-data').addClass('hide');
	});

	$('body').on('change', '.jscolor', function(e){
		e.preventDefault();
		var p = $(this).closest('tr, .tr');
		$(this).addClass('hide');
		p.find('.hide').removeClass('hide');
	});
// Products
	$('body').on('click', '.del-prod', function(e){		
	e.preventDefault();
	$('body').find('.loaderwrap').remove();
	$('#products-table').append(loader);
	var p = $(this).closest('tr');
	var txt = 'This will delete product <b>'+p.find('.edit-data').text() +'</b><br>If you choose <b>ALL RELATIONS</b>, it will also delete it from Relations table';
	var i = $(this).attr('data-id');
	var pi = p.find('.product_id').val();
		$.confirm({
	    title: '<span class="text-danger">Warning <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>',
	    theme: 'modern',
	    content: txt,
	    autoClose: 'cancel|30000',
	    buttons: {
	        confirm: {
	            text: 'Delete',
	            btnClass: 'btn-warning',
	            keys: ['enter'],
	            action: function(){
	            	$.getJSON( Jsapi+'fuel-inventory/delete-product/', {'data[id]': i} ,function( data ) {
	            		if(data.add == 'success'){
	            			var pathtopage = window.location.href;
							$('#table-products').load(pathtopage + ' #all-products', function(){
								$('body').find('.loaderwrap').remove();
							});
							
	            		} else {
	            			$('body').find('.loaderwrap').remove();
	            		}
	            	});
	            }
	        },
	        other: {
	        	text:  'All relations',
	            btnClass: 'btn-warning',
	            action: function(){
	                $.getJSON( Jsapi+'fuel-inventory/delete-product/', { 'data[id]': i, 'data[prod]': pi }, function( data ) {
	            		if(data.add == 'success'){
	            			var pathtopage = window.location.href;
							$('#table-products').load(pathtopage + ' #all-products', function(){
								$('body').find('.loaderwrap').remove();
							});
							
	            		} else {
	            			$('body').find('.loaderwrap').remove();
	            		}
	            	});
	            }
	        },
	        cancel: {
	            text:  'Cancel',
	            btnClass: 'btn-success',
	            action: function(){
	                // $.alert('Not deleted');
	                $('body').find('.loaderwrap').remove();
	            }
	        }
	    }
		});
	});
	
$('body').on('click', '.add-prod', function(e){
	e.preventDefault();
	$('body').find('.loaderwrap').remove();
	$('.form-error').removeClass('form-error');
	var ee = true;
	var a = $('#input-id');
	var f = a.val();
	var b = $('#input-products');
	var g = b.val();
	var c = $('#input-alias');
	var h = c.val();
	if(f.replace(/\s+/g, '') == '') {
		a.val('');
		a.addClass('form-error');
		ee = false;
	}
	if(g.replace(/\s+/g, '') == '') {
		b.val('');
		b.addClass('form-error');
		ee = false;
	}
	if(h.replace(/\s+/g, '') == '') {
		c.val('');
		c.addClass('form-error');
		ee = false;
	}

	if(ee){
		$('#products-table').append(loader);
		var fdata = {
			'data[product_id]' : f,
			'data[product]' : g,
			'data[product_alias]' : h
		}
		$.getJSON( Jsapi+'fuel-inventory/add-product/', fdata , function( data ) {
			console.log(data);
		if(data.add == 'success'){
			var pathtopage = window.location.href;
			// alert(pathtopage);
			$('#table-products').load(pathtopage + ' #all-products', function(){
				$('body').find('.loaderwrap').remove();
			});
			a.val('');
			b.val('');
			c.val('');
		} else {
			$('body').find('.loaderwrap').remove();
		}
		
	    });
	}
});

$('body').on('click', '.edit-prod', function(e){
	e.preventDefault();
	$('body').find('.loaderwrap').remove();
	$('.form-error').removeClass('form-error');
	var p = $(this).closest('tr');
	var i = $(this).attr('data-id');
	var ee = true;
	var a = p.find('.product_id');
	var f = a.val();
	var b = p.find('.product');
	var g = b.val();
	var c = p.find('.product_alias');
	var h = c.val();
	if(f.replace(/\s+/g, '') == '') {
		a.val('');
		a.addClass('form-error');
		ee = false;
	}
	if(g.replace(/\s+/g, '') == '') {
		b.val('');
		b.addClass('form-error');
		ee = false;
	}
	if(h.replace(/\s+/g, '') == '') {
		c.val('');
		c.addClass('form-error');
		ee = false;
	}

	if(ee){
		$('#all-products').append(loader);
		var fdata = {
			'data[product_id]' : f,
			'data[product]' : g,
			'data[id]': i,
			'data[product_alias]' : h
		}
		$.getJSON( Jsapi+'fuel-inventory/edit-product/', fdata , function( data ) {
			console.log(data);
		if(data.add == 'success'){
			var pathtopage = window.location.href;
			// alert(pathtopage);
			$('#table-products').load(pathtopage + ' #all-products', function(){
				$('body').find('.loaderwrap').remove();
			});
		} else {
			$('body').find('.loaderwrap').remove();
		}
		
	    });
	}
});

// Sites / Dealers

var Dealers = $('#all-sites').DataTable({
	"destroy": true,
	 "language": {
            "decimal":        "",
            "emptyTable":     "<?php echo __('No data available in table'); ?>",
            "info":           "<?php echo __('Showing _START_ to _END_ of _TOTAL_ entries'); ?>",
            "infoEmpty":      "<?php echo __('Showing 0 to 0 of 0 entries'); ?>",
            "infoFiltered":   "<?php echo __('(filtered from _MAX_ total entries)'); ?>",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "<?php echo __('Show _MENU_ entries'); ?>",
            "loadingRecords": "<?php echo __('Loading...'); ?>",
            "processing":     "<?php echo __('Processing...'); ?>",
            "search":         "<?php echo __('Search:'); ?>",
            "zeroRecords":    "<?php echo __('No matching records found'); ?>",
            "paginate": {
                "first":      "<i class='fa fa-angle-double-left'></i>",
                "last":       "<i class='fa fa-angle-double-right'></i>",
                "next":       "<i class='fa fa-angle-right'></i>",
                "previous":   "<i class='fa fa-angle-left'></i>"
            },
        }
});

$('body').on('click', '.del-site', function(e){
	var Dealers = $('#all-sites').DataTable({
	"destroy": true,
	 "language": {
            "decimal":        "",
            "emptyTable":     "<?php echo __('No data available in table'); ?>",
            "info":           "<?php echo __('Showing _START_ to _END_ of _TOTAL_ entries'); ?>",
            "infoEmpty":      "<?php echo __('Showing 0 to 0 of 0 entries'); ?>",
            "infoFiltered":   "<?php echo __('(filtered from _MAX_ total entries)'); ?>",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "<?php echo __('Show _MENU_ entries'); ?>",
            "loadingRecords": "<?php echo __('Loading...'); ?>",
            "processing":     "<?php echo __('Processing...'); ?>",
            "search":         "<?php echo __('Search:'); ?>",
            "zeroRecords":    "<?php echo __('No matching records found'); ?>",
            "paginate": {
                "first":      "<i class='fa fa-angle-double-left'></i>",
                "last":       "<i class='fa fa-angle-double-right'></i>",
                "next":       "<i class='fa fa-angle-right'></i>",
                "previous":   "<i class='fa fa-angle-left'></i>"
            },
        }
});
	e.preventDefault();
	$('body').find('.loaderwrap').remove();
	$('#sites-table').append(loader);
	var p = $(this).closest('tr');
	var a = p.find('.site_id');
	var f = a.val();
	var txt = 'This will delete dealer <b>'+p.find('.edit-data').text() +'</b><br>If you choose <b>ALL RELATIONS</b>, it will also delete it from Relations table';
	var i = $(this).attr('data-id');
		$.confirm({
	    title: '<span class="text-danger">Warning <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>',
	    theme: 'modern',
	    content: txt,
	    autoClose: 'cancel|30000',
	    buttons: {
	        confirm: {
	            text: 'Confirm',
	            btnClass: 'btn-warning',
	            keys: ['enter','delete'],
	            action: function(){
	            	$.getJSON( Jsapi+'fuel-inventory/delete-site/', { 'data[id]': i}, function( data ) {
	            		if(data.do == 'success'){
	            			var pathtopage = window.location.href;
							// alert(pathtopage);
							$('#station-wrapper-data-add').load(pathtopage + ' #station-wrapper-data-add .row');
							$('#table-sites').load(pathtopage + ' #all-sites', function(){
								$('body').find('.loaderwrap').remove();
								$(this).find('#all-sites').DataTable({
									"destroy": true,
									 "language": {
								            "decimal":        "",
								            "emptyTable":     "<?php echo __('No data available in table'); ?>",
								            "info":           "<?php echo __('Showing _START_ to _END_ of _TOTAL_ entries'); ?>",
								            "infoEmpty":      "<?php echo __('Showing 0 to 0 of 0 entries'); ?>",
								            "infoFiltered":   "<?php echo __('(filtered from _MAX_ total entries)'); ?>",
								            "infoPostFix":    "",
								            "thousands":      ",",
								            "lengthMenu":     "<?php echo __('Show _MENU_ entries'); ?>",
								            "loadingRecords": "<?php echo __('Loading...'); ?>",
								            "processing":     "<?php echo __('Processing...'); ?>",
								            "search":         "<?php echo __('Search:'); ?>",
								            "zeroRecords":    "<?php echo __('No matching records found'); ?>",
								            "paginate": {
								                "first":      "<i class='fa fa-angle-double-left'></i>",
								                "last":       "<i class='fa fa-angle-double-right'></i>",
								                "next":       "<i class='fa fa-angle-right'></i>",
								                "previous":   "<i class='fa fa-angle-left'></i>"
								            },
								        }
								});
							});
	            		} else {
	            			$('body').find('.loaderwrap').remove();	
	            		}
	            		
	            	});
	            }
	        },
	        other: {
	        	text:  'All relations',
	            btnClass: 'btn-warning',
	            action: function(){
	                $.getJSON( Jsapi+'fuel-inventory/delete-site/', { 'data[id]': i, 'data[st]': f }, function( data ) {
	            		if(data.do == 'success'){
	            			var pathtopage = window.location.href;
	            			$('#station-wrapper-data-add').load(pathtopage + ' #station-wrapper-data-add .row');
							$('#table-sites').load(pathtopage + ' #all-sites', function(){
								$('body').find('.loaderwrap').remove();
								$(this).find('#all-sites').DataTable({
									"destroy": true,
									 "language": {
								            "decimal":        "",
								            "emptyTable":     "<?php echo __('No data available in table'); ?>",
								            "info":           "<?php echo __('Showing _START_ to _END_ of _TOTAL_ entries'); ?>",
								            "infoEmpty":      "<?php echo __('Showing 0 to 0 of 0 entries'); ?>",
								            "infoFiltered":   "<?php echo __('(filtered from _MAX_ total entries)'); ?>",
								            "infoPostFix":    "",
								            "thousands":      ",",
								            "lengthMenu":     "<?php echo __('Show _MENU_ entries'); ?>",
								            "loadingRecords": "<?php echo __('Loading...'); ?>",
								            "processing":     "<?php echo __('Processing...'); ?>",
								            "search":         "<?php echo __('Search:'); ?>",
								            "zeroRecords":    "<?php echo __('No matching records found'); ?>",
								            "paginate": {
								                "first":      "<i class='fa fa-angle-double-left'></i>",
								                "last":       "<i class='fa fa-angle-double-right'></i>",
								                "next":       "<i class='fa fa-angle-right'></i>",
								                "previous":   "<i class='fa fa-angle-left'></i>"
								            },
								        }
									});
							});
	            		} else {
	            			$('body').find('.loaderwrap').remove();
	            			$(this).find('#all-sites').DataTable({
							"destroy": true,
							 "language": {
						            "decimal":        "",
						            "emptyTable":     "<?php echo __('No data available in table'); ?>",
						            "info":           "<?php echo __('Showing _START_ to _END_ of _TOTAL_ entries'); ?>",
						            "infoEmpty":      "<?php echo __('Showing 0 to 0 of 0 entries'); ?>",
						            "infoFiltered":   "<?php echo __('(filtered from _MAX_ total entries)'); ?>",
						            "infoPostFix":    "",
						            "thousands":      ",",
						            "lengthMenu":     "<?php echo __('Show _MENU_ entries'); ?>",
						            "loadingRecords": "<?php echo __('Loading...'); ?>",
						            "processing":     "<?php echo __('Processing...'); ?>",
						            "search":         "<?php echo __('Search:'); ?>",
						            "zeroRecords":    "<?php echo __('No matching records found'); ?>",
						            "paginate": {
						                "first":      "<i class='fa fa-angle-double-left'></i>",
						                "last":       "<i class='fa fa-angle-double-right'></i>",
						                "next":       "<i class='fa fa-angle-right'></i>",
						                "previous":   "<i class='fa fa-angle-left'></i>"
						            },
						        }
});
	            		}
	            	});
	            }
	        },
	        cancel: {
	            text:  'Cancel',
	            btnClass: 'btn-success',
	            action: function(){
	                $('body').find('.loaderwrap').remove();
	            }
	        }
	    }
		});
	});

$('body').on('click', '.add-site', function(e){
	e.preventDefault();
	$('body').find('.loaderwrap').remove();
	$('.form-error').removeClass('form-error');
	var ee = true;
	var a = $('#input-site_id');
	var f = a.val();
	var b = $('#input-dealer');
	var g = b.val();
	var c = $('#input-address');
	var h = c.val();
	var j = $('#input-district');
	var k = j.val();
	var l = $('#input-phone');
	var m = l.val();
	var n = $('#input-email');
	var o = n.val();
	if($('.select-stations').length) {
		var q = $('.select-stations option:selected').val();
	} else {
		var q = 0;
	}
	
	var z = '';
	var x = $('#comp_image').val();
        $("input:checked").each(function() {
        	z = z + $(this).val() + ',';
        
        });
	if(f.replace(/\s+/g, '') == '') {
		a.val('');
		a.addClass('form-error');
		ee = false;
	}
	if(g.replace(/\s+/g, '') == '') {
		b.val('');
		b.addClass('form-error');
		ee = false;
	}
	if(h.replace(/\s+/g, '') == '') {
		c.val('');
		c.addClass('form-error');
		ee = false;
	}
	if(k.replace(/\s+/g, '') == '') {
		j.val('');
		j.addClass('form-error');
		ee = false;
	}

	if(ee){
		$('#sites-table').append(loader);
		
		var fdata = {
			'data[site_id]' : f,
			'data[dealer]' : g,
			'data[address]' : h,
			'data[district]' : k,
			'data[phone]' : m,
			'data[gallery_image]' : z,
			'data[featured_image]': x,
			'data[rel_id_map]' : q,
			'data[email]' : o
		}
		$.getJSON( Jsapi+'fuel-inventory/add-site/', fdata , function( data ) {
			console.log(data);
		if(data.add == 'success'){
			var pathtopage = window.location.href;
			// alert(pathtopage);
			$('#station-wrapper-data-add').load(pathtopage + ' #station-wrapper-data-add .row');
			$('#table-sites').load(pathtopage + ' #all-sites', function(){
				$('body').find('.loaderwrap').remove();
				$(this).find('#all-sites').DataTable({
					"destroy": true,
					 "language": {
				            "decimal":        "",
				            "emptyTable":     "<?php echo __('No data available in table'); ?>",
				            "info":           "<?php echo __('Showing _START_ to _END_ of _TOTAL_ entries'); ?>",
				            "infoEmpty":      "<?php echo __('Showing 0 to 0 of 0 entries'); ?>",
				            "infoFiltered":   "<?php echo __('(filtered from _MAX_ total entries)'); ?>",
				            "infoPostFix":    "",
				            "thousands":      ",",
				            "lengthMenu":     "<?php echo __('Show _MENU_ entries'); ?>",
				            "loadingRecords": "<?php echo __('Loading...'); ?>",
				            "processing":     "<?php echo __('Processing...'); ?>",
				            "search":         "<?php echo __('Search:'); ?>",
				            "zeroRecords":    "<?php echo __('No matching records found'); ?>",
				            "paginate": {
				                "first":      "<i class='fa fa-angle-double-left'></i>",
				                "last":       "<i class='fa fa-angle-double-right'></i>",
				                "next":       "<i class='fa fa-angle-right'></i>",
				                "previous":   "<i class='fa fa-angle-left'></i>"
				            },
				        }
				}).page('last').draw( false );
			});
			
			a.val('');
			b.val('');
			c.val('');
			j.val('');
			l.val('');
			n.val('');
			var di = '<?php echo URL.default_image(); ?>';
			$('body').find('.remove-comp-img').remove();
			$('.featured_image img').attr('src', di);
			$('#comp_image').val('');
		} else {
			$('body').find('.loaderwrap').remove();
			$(this).find('#all-sites').DataTable({
	"destroy": true,
	 "language": {
            "decimal":        "",
            "emptyTable":     "<?php echo __('No data available in table'); ?>",
            "info":           "<?php echo __('Showing _START_ to _END_ of _TOTAL_ entries'); ?>",
            "infoEmpty":      "<?php echo __('Showing 0 to 0 of 0 entries'); ?>",
            "infoFiltered":   "<?php echo __('(filtered from _MAX_ total entries)'); ?>",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "<?php echo __('Show _MENU_ entries'); ?>",
            "loadingRecords": "<?php echo __('Loading...'); ?>",
            "processing":     "<?php echo __('Processing...'); ?>",
            "search":         "<?php echo __('Search:'); ?>",
            "zeroRecords":    "<?php echo __('No matching records found'); ?>",
            "paginate": {
                "first":      "<i class='fa fa-angle-double-left'></i>",
                "last":       "<i class='fa fa-angle-double-right'></i>",
                "next":       "<i class='fa fa-angle-right'></i>",
                "previous":   "<i class='fa fa-angle-left'></i>"
            },
        }
}).page('last').draw( false );
		}
		
	    });
	}
});

$('body').on('click', '.edit-site', function(e){
	e.preventDefault();
	$('body').find('.loaderwrap').remove();
	$('.form-error').removeClass('form-error');
	var p = $(this).closest('tr');
	var i = $(this).attr('data-id');
	var ee = true;
	var a = p.find('.site_id');
	var f = a.val();
	var b = p.find('.dealer');
	var g = b.val();
	var c = p.find('.address');
	var h = c.val();
	var j = p.find('.district');
	var k = j.val();
	var l = p.find('.phone');
	var m = l.val();
	var n = p.find('.email');
	var o = n.val();
	if(f.replace(/\s+/g, '') == '') {
		a.val('');
		a.addClass('form-error');
		ee = false;
	}
	if(g.replace(/\s+/g, '') == '') {
		b.val('');
		b.addClass('form-error');
		ee = false;
	}
	if(h.replace(/\s+/g, '') == '') {
		c.val('');
		c.addClass('form-error');
		ee = false;
	}
	if(k.replace(/\s+/g, '') == '') {
		j.val('');
		j.addClass('form-error');
		ee = false;
	}

	if(ee){
		$('#sites-table').append(loader);
		var fdata = {
			'data[id]' : i,
			'data[site_id]' : f,
			'data[dealer]' : g,
			'data[address]' : h,
			'data[district]' : k,
			'data[phone]' : m,
			'data[email]' : o
		}
		$.getJSON( Jsapi+'fuel-inventory/edit-site/', fdata , function( data ) {
			console.log(data);
		if(data.add == 'success'){
			var pathtopage = window.location.href;
			// alert(pathtopage);
			$('#table-sites').load(pathtopage + ' #all-sites', function(){
				$('body').find('.loaderwrap').remove();
			});
		} else {
			$('body').find('.loaderwrap').remove();
		}
		
	    });
	}
});

function uploadData(formdata){
	var u = Jsapi+'fuel-inventory/file-upload/';
    $('.progress').removeClass('hide');
    $('.the-prog').removeClass('bg-success');
    $('.the-prog').addClass('bg-danger');
    $('.the-prog').css({'width' : 0 + '%'});

    $.ajax({
    	xhr: function() {
			    var xhr = new window.XMLHttpRequest();
			    xhr.upload.addEventListener("progress", function(evt) {
			      if (evt.lengthComputable) {
			        var percentComplete = evt.loaded / evt.total;
			        percentComplete = parseInt(percentComplete * 100);
			        $('.the-prog').css({'width' : percentComplete + '%'});
                    $('.the-prog').text('Uploading '+ percentComplete + '%');
			        console.log(percentComplete);
			        if (percentComplete === 100) {
			        	
			        }

			      }
			    }, false);

			    return xhr;
			  },
        url: u,
        type: 'post',
        data: formdata,
        contentType: false,
        processData: false,
        dataType: 'json',
        complete: function(xhr){
          console.log(xhr.responseText);
          $('#comp_image').val(xhr.responseText);
         
          
          $('.the-prog').removeClass('bg-danger');
			$('.the-prog').addClass('bg-success');
          $('.the-prog').text('File has been uploaded');
          $('.featured_image img').attr('src',AdminUrl+'media/get-file/'+xhr.responseText);
         if($('body').find('.remove-comp-img').length) {
			} else {
				$('.featured_image').append('<a class="remove-comp-img text-danger" href="#"><i class="fa fa-window-close"></i></a>')
			}
        }
    });
}

function uploadGalary(formdata){
    var u = Jsapi+'fuel-inventory/file-upload/';
    $('body').find('.here-in .the-prog').addClass('bg-danger');
    $('body').find('.here-in .the-prog').css({'width' : 0 + '%'});

    $.ajax({
        xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                  if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                    $('body').find('.here-in .the-prog').css({'width' : percentComplete + '%'});
                    $('body').find('.here-in .the-prog').text('Uploading '+ percentComplete + '%');
                    console.log(percentComplete);
                    if (percentComplete === 100) {
                        
                    }

                  }
                }, false);

                return xhr;
              },
        url: u,
        type: 'post',
        data: formdata,
        contentType: false,
        processData: false,
        dataType: 'json',
        complete: function(xhr){
        $('body').find('.here-in').addClass('done-here');
        $('body').find('.here-in img').attr('src',AdminUrl+'media/get-file/'+xhr.responseText);
        $('body').find('.here-in input').val(xhr.responseText);
        $('body').find('.here-in .the-prog').removeClass('bg-danger');
        $('body').find('.here-in .the-prog').addClass('bg-success');
        $('body').find('.here-in .the-prog').text('File uploaded');
        $('body').find('.here-in').removeClass('here-in');
        }
    });
}

$(document).ready(function(){

    $('#input-upload_doc').on('change', function(){
        var fd = new FormData();
        var files = $('#input-upload_doc')[0].files[0];
        fd.append('scanned_doc',files);
        fd.append('data[don]',1);

        uploadData(fd);
    });

    $('body').on('change','#station-gallery', function(){
        var fd = new FormData();
        var files = $('#station-gallery')[0].files[0];
        fd.append('scanned_doc',files);
        fd.append('data[pers]',1);
        var btn = $('.here-up').html();
        btn = '<div class="col-lg-3 col-md-4 col-sm-3 col-xs-4 here-up">'+ btn + '</div>';
        var td = $('body').find('.the-file .text-danger').text();
        var d = '<img class="fuel-gallery-add"> <input class="hide" type="checkbox" name="data[gallery_image][]" value="" checked><small class="text-danger">'+td+'</small>';
        var prog = '<div class="progress abs-progress"><div class="the-prog bg-danger"></div></div>';
        $('.here-up').addClass('here-in');
        $('.here-up').removeClass('here-up');
        $('body').find('.here-in').html(d+prog);
        $('.fuel-gallery').append(btn);
        $('body').find('.the-file').html('');
        uploadGalary(fd);
    });

    $('body').on('click','.upload-gallery', function(){
        var a = $(this).parent().find('#station-gallery');
        a.click();
    })
});

$('body').on('change','.select-stations', function(){
	var i = $(this).val();
	var di = '<?php echo URL.default_image(); ?>';
	$.getJSON( Jsapi+'fuel-inventory/get-map-marker/', { 'data[id]': i }, function( data ) {
		console.log(data);
		if(data.do == 'success'){
			$('#input-dealer').val(data.marker.dealer);
			$('#input-address').val(data.marker.address);
			if(data.marker.comp_image != '') {
				$('.featured_image img').attr('src', AdminUrl + 'media/get-file/' + data.marker.comp_image);
				$('#comp_image').val(data.marker.comp_image);
				if($('body').find('.remove-comp-img').length) {
				} else {
					$('.featured_image').append('<a class="remove-comp-img text-danger" href="#"><i class="fa fa-window-close"></i></a>')
				}
			} else {
				$('body').find('.remove-comp-img').remove();
				$('.featured_image img').attr('src', di);
				$('#comp_image').val('');
			}
		} else {
			
		}
	});
});

$('body').on('click','.remove-comp-img', function(e){
	e.preventDefault();
	var di = '<?php echo URL.default_image(); ?>';
	$(this).remove();
	$('.featured_image img').attr('src', di);
	$('#comp_image').val('');
});

// Tanks
$('body').on('click', '.del-tank', function(e){
	e.preventDefault();
	$('body').find('.loaderwrap').remove();
	$('#tanks-table').append(loader);
	var p = $(this).closest('tr');
	var txt = 'This will delete <b>'+p.find('.edit-data').text() +'</b><br>If you choose <b>ALL RELATIONS</b>, it will also delete it from Relations table';
	var i = $(this).attr('data-id');
	var a = p.find('.tank_id');
	var f = a.val();
		$.confirm({
	    title: '<span class="text-danger">Warning <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>',
	    theme: 'modern',
	    content: txt,
	    autoClose: 'cancel|30000',
	    buttons: {
	        confirm: {
	            text: 'Confirm',
	            btnClass: 'btn-warning',
	            keys: ['enter','delete'],
	            action: function(){
	            	$.getJSON( Jsapi+'fuel-inventory/delete-tank/', { 'data[id]': i }, function( data ) {
	            		if(data.do == 'success'){
            				var pathtopage = window.location.href;
							// alert(pathtopage);
							$('#table-tanks').load(pathtopage + ' #all-tanks', function(){
								$('body').find('.loaderwrap').remove();
							});
	            		} else {
	            			$('body').find('.loaderwrap').remove();
	            		}
	            	});
	            }
	        },
	         other: {
	        	text:  'All relations',
	            btnClass: 'btn-warning',
	            action: function(){
	                $.getJSON( Jsapi+'fuel-inventory/delete-tank/', { 'data[id]': i, 'data[ti]': f }, function( data ) {
	            		if(data.do == 'success'){
	            			var pathtopage = window.location.href;
							$('#table-tanks').load(pathtopage + ' #all-tanks', function(){
								$('body').find('.loaderwrap').remove();
							});
	            		} else {
	            			$('body').find('.loaderwrap').remove();
	            		}
	            	});
	            }
	        },
	        cancel: {
	            text:  'Cancel',
	            btnClass: 'btn-success',
	            action: function(){
	               $('body').find('.loaderwrap').remove();
	            }
	        }
	    }
		});
	});

$('body').on('click', '.add-tank', function(e){
	e.preventDefault();
	$('body').find('.loaderwrap').remove();
	$('.form-error').removeClass('form-error');
	var ee = true;
	var a = $('#input-tank_id');
	var f = a.val();
	var b = $('#input-tank');
	var g = b.val();
	if(f.replace(/\s+/g, '') == '') {
		a.val('');
		a.addClass('form-error');
		ee = false;
	}
	if(g.replace(/\s+/g, '') == '') {
		b.val('');
		b.addClass('form-error');
		ee = false;
	}
	if(ee){
		$('#tanks-table').append(loader);
		var fdata = {
			'data[tank_id]' : f,
			'data[tank]' : g
		}
		$.getJSON( Jsapi+'fuel-inventory/add-tank/', fdata , function( data ) {
			console.log(data);
		if(data.add == 'success'){
			var pathtopage = window.location.href;
			// alert(pathtopage);
			$('#table-tanks').load(pathtopage + ' #all-tanks', function(){
				$('body').find('.loaderwrap').remove();
			});
			a.val('');
			b.val('');
		} else {
			$('body').find('.loaderwrap').remove();
		}
		
	    });
	}
});

$('body').on('click', '.edit-tank', function(e){
	e.preventDefault();
	$('body').find('.loaderwrap').remove();
	$('.form-error').removeClass('form-error');
	var p = $(this).closest('tr');
	var i = $(this).attr('data-id');
	var ee = true;
	var a = p.find('.tank_id');
	var f = a.val();
	var b = p.find('.tank');
	var g = b.val();
	if(f.replace(/\s+/g, '') == '') {
		a.val('');
		a.addClass('form-error');
		ee = false;
	}
	if(g.replace(/\s+/g, '') == '') {
		b.val('');
		b.addClass('form-error');
		ee = false;
	}
	if(ee){
		$('#tanks-table').append(loader);
		var fdata = {
			'data[id]' : i,
			'data[tank_id]' : f,
			'data[tank]' : g
		}
		$.getJSON( Jsapi+'fuel-inventory/edit-tank/', fdata , function( data ) {
			console.log(data);
		if(data.add == 'success'){
			var pathtopage = window.location.href;
			// alert(pathtopage);
			$('#table-tanks').load(pathtopage + ' #all-tanks');
		}
		$('body').find('.loaderwrap').remove();	
	    });
	}
});

// Relations add-relation 

$('body').on('click', '.del-rel', function(e){
	e.preventDefault();
	$('body').find('.loaderwrap').remove();
	$('#relations-table').append(loader);
	var p = $(this).closest('tr'); 
	var txt = 'This will delete <b>'+p.find('.edit-data').text() +'</b> relation to product <b>'+ p.find('.the-prod').text() +'</b>';
	var i = $(this).attr('data-id');
		$.confirm({
	    title: '<span class="text-danger">Warning!</span>',
	    theme: 'modern',
	    content: txt,
	    autoClose: 'cancel|10000',
	    buttons: {
	        confirm: {
	            text: 'Confirm',
	            btnClass: 'btn-success',
	            keys: ['enter','delete'],
	            action: function(){
	            	$.getJSON( Jsapi+'fuel-inventory/delete-relation/'+i, function( data ) {
	            		if(data.add == 'success'){
	            			var pathtopage = window.location.href;
							// alert(pathtopage);
							$('#table-relations').load(pathtopage + ' #all-relations', function(){
								$('body').find('.loaderwrap').remove();
							});
							
	            		} else {
	            			$('body').find('.loaderwrap').remove();
	            		}
	            		
	            	});
	            }
	        },
	        cancel: {
	            text:  'Cancel',
	            btnClass: 'btn-warning',
	            action: function(){
	                $('body').find('.loaderwrap').remove();
	            }
	        }
	    }
		});
	});

$('body').on('click', '.add-relation', function(e){
	e.preventDefault();
	$('body').find('.loaderwrap').remove();
	$('.form-error').removeClass('form-error');
	var ee = true;
	var a = $('#site_relation');
	var f = a.val();
	var b = $('#tank_relation option:selected');
	var g = b.val();
	var c = $('#product_relation option:selected');
	var h = c.val();
	if(ee){
		$('#relations-table').append(loader);
		var fdata = {
			'data[site_id]' : f,
			'data[tank_id]' : g,
			'data[product_id]' : h
		}
		$.getJSON( Jsapi+'fuel-inventory/add-relation/', fdata , function( data ) {
			console.log(data);
		if(data.add == 'success'){
			var pathtopage = window.location.href;
			// alert(pathtopage);
			$('#table-relations').load(pathtopage + ' #all-relations', function(){
				
				$('body').find('.loaderwrap').remove();
			});
			
		} else {
			$('body').find('.loaderwrap').remove();
		}
		
	    });
	}
});

$('body').on('click', '.edit-rel', function(e){
	e.preventDefault();
	$('body').find('.loaderwrap').remove();
	$('.form-error').removeClass('form-error');
	var p = $(this).closest('tr');
	var i = $(this).attr('data-id');
	var ee = true;
	var b = p.find('.tank-data option:selected');
	var g = b.val();
	var c = p.find('.product-data option:selected');
	var h = c.val();
	if(ee){
		$('#relations-table').append(loader);
		var fdata = {
			'data[id]' : i,
			'data[tank_id]' : g,
			'data[product_id]' : h
		}
		$.getJSON( Jsapi+'fuel-inventory/edit-relation/', fdata , function( data ) {
			console.log(data);
		if(data.add == 'success'){
			var pathtopage = window.location.href;
			// alert(pathtopage);
			$('#table-relations').load(pathtopage + ' #all-relations', function(){
				$('body').find('.loaderwrap').remove();
			});
		} else {
			$('body').find('.loaderwrap').remove();
		}
		
	    });
	}
});

// Colorset 

$('body').on('click','span.switchery',function(){
	var a = $('.use-color-array').val();
	var b = $('.use-color-array').attr('data-id');
	$('.pload').html(loader2);
	if(a == 1){
		a++;
		$('.use-color-array').val(2);
	} else {
		a--;
		$('.use-color-array').val(1);
	}
	var fdata = {'data[id]' : b,'data[value]' : a, 'data[thres]': true }
	$.getJSON( Jsapi+'fuel-inventory/edit-settings/', fdata , function( data ) {
			console.log(data);
		$('body').find('.loaderwrap').remove();
	});
});

$('body').on('click', '.edit-col', function(e){
	e.preventDefault();
	$('body').find('.loaderwrap').remove();
	var t = $(this);
	var p = $(this).closest('tr');
	var i = $(this).attr('data-id');
	var ee = true;
	var b = p.find('.color-input-box');
	var g = b.val();
	if(ee){
		t.closest('.colors-table').append(loader);
		if(i > 0) {
			var fdata = {'data[id]' : i,'data[value]' : g }
		} else {
			var fdata = {
				'data[value]' : g,
				'data[meta]' : $(this).attr('data-meta'),
				'data[re_order]' : $(this).attr('data-re_order'),
				'data[description]' : $(this).attr('data-description'),
				'data[input_type]' : $(this).attr('data-input_type')
			}
		}
		
		$.getJSON( Jsapi+'fuel-inventory/edit-settings/', fdata , function( data ) {
			console.log(data);
		if(data.add == 'success'){
			t.addClass('hide');
		}
		$('body').find('.loaderwrap').remove();
	    });
	}
});

// Threshold

$('body').on('click', '.edit-threshold', function(e){
	e.preventDefault();
	$('body').find('.loaderwrap').remove();
	var t = $(this);
	var p = $(this).closest('tr');
	var i = $(this).attr('data-id');
	var ee = true;
	var b = p.find('.settings-input');
	var g = b.val();
	p.append(loader);
	if(ee){
		$('#settings-table').append(loader);
		var fdata = {
			'data[id]' : i,
			'data[value]' : g,
			'data[thres]': true
		}
		$.getJSON( Jsapi+'fuel-inventory/edit-settings/', fdata , function( data ) {
			console.log(data);
		if(data.add == 'success'){ // 
			p.find('.thresholds-box').text(g);
		}
		$('body').find('.loaderwrap').remove();
	    });
	}
});

$('input[type=radio][name=dashboard-chart]').on('ifChecked',function(){
	var ee = true;
	var i = $(this).attr('data-id');
	var a = $(this).val();
	if(ee){
		$('#dashboard-chart-table').append(loader);
		var fdata = {
			'data[id]' : i,
			'data[value]' : a,
			'data[thres]': true
		}
		$.getJSON( Jsapi+'fuel-inventory/edit-settings/', fdata , function( data ) {
			console.log(data);
		if(data.add == 'success'){ // 
			
		}
		$('body').find('.loaderwrap').remove();
	    });
	}
})

</script>