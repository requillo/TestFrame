<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!empty($listname)) {
$listdata = array();
if($listname['category']['interval_type'] == 1) {
	foreach ($listname['pasttimes'] as $key => $value) {
		foreach ($checklists as $lists) {
			if($lists['data_interval'] == $value) {
				$listdata[$key] = $lists;
				$listdata[$key]['data_checklist'] = json_decode($lists['data_checklist'], true);
				$listdata[$key]['added'] = 1;
			}
		}
		if(!isset($listdata[$key])) {
			$listdata[$key]['data_interval'] = $value;
			$listdata[$key]['added'] = 0;
		}
	}
} else {
	$e = 1;
	for ($i = 0; $i < $listname['count']; $i++) {
		if(isset($checklists[$i])) {
			$listdata[$i] = $checklists[$i];
			$listdata[$i]['data_checklist'] = json_decode($checklists[$i]['data_checklist'], true);
			$listdata[$i]['data_interval'] = $e;
			$listdata[$i]['added'] = 1;
		} else {
			$listdata[$i]['data_interval'] = $e;
			$listdata[$i]['added'] = 0;
		}
		$e++;
	}
}
$doptions = array();
$e_options = array();
$get_header_types = array();
if($listname['category']['list_add_view'] == 2) {
$i = 0;
$e = 0;
	foreach ($options as $key => $value) {
		// header type is 8
		if($value['type'] == 8) {
			$get_header_types[$i] = $options[$key];
			$i++;
		} else if($value['link_option'] == 0) {
			$e_options[$e] =  $options[$key];
			$e++;
		}
	}
$n = 0;
$groupHeads = array();
$has_hGroup = false;
	foreach ($get_header_types as $key => $value) {
		$d = 0;

		if(is_numeric($value['indu_cat'])) {
			$has_hGroup = true;
		}
		
		if(!isset($groupHeads[$value['indu_cat']])) {
			$g = 1;
			$groupHeads[$value['indu_cat']][$g] = $value['indu_cat'];
		} else {
			$groupHeads[$value['indu_cat']][$g] = $value['indu_cat'];
			$g++;
		}
		$g++;
		$doptions[$n] = $get_header_types[$key];
		foreach ($options as $k => $val) {
			if($value['id'] == $val['link_option']) {
				$doptions[$n]['data'][$d] = $options[$k];
				$d++;
			}
		}
		$n++;
	}

}

?>
<div class="container-fluid">
	<pre>
		<?php // print_r($groupHeads); ?> 
		<?php // print_r($e_options); ?>
		<?php print_r($listname); ?>
	</pre>
		<?php // print_r($listname); ?>  
	<?php if(!empty($options) && empty($listname['notyet']) && !empty($listname['pasttimes'])){ ?>
	<div class="panel panel-default hidden-print">
		<div class="panel-body">
		  	<div class="row">
		  		<?php if($listname['category']['list_add_view'] == 2) { ///// Start VIEW list_add_view 2 
if(isset($doptions[0]['data'])) {
$tt = count($doptions[0]['data']);
} else if(isset($doptions[1]['data'])){
$tt = count($doptions[1]['data']);
} else if(isset($doptions[2]['data'])){
$tt = count($doptions[2]['data']);
} else if(isset($doptions[3]['data'])){
$tt = count($doptions[3]['data']);
} else {
$tt = 0;
}

		  		 ?>
		  			<?php $form->create(); ?>

		  			
<?php if(!empty($e_options)){
		$ett = count($e_options);
		if($ett > 4) {
		if($ett % 4 == 0) {
			$ett = 4;
		} else if($ett % 3 == 0) {
			$ett = 3;
		} else {
			$ett = 2;
		}
	}

	$cols = 12/$ett;

	?>

		<?php foreach ($e_options as $k => $val) { ?>
			<div class="col-lg-<?php echo $cols; ?> col-md-<?php echo $cols; ?> col-sm-12 col-xs-12">
			<?php if($val['type'] == 3 ) { ?>
  			<?php $cl = '<label for="id-'.$val['id'].'">'.$val['name'].'</label> <small>'.$val['info'].'</small>'; ?>
  				<div>
  			<?php } else { ?>
  				<?php $cl = ''; ?>
  			<label for="id-<?php echo $val['id'] ?>"><?php echo $val['name']; ?></label> <small><?php echo $val['info'];?></small>
  			<?php } ?>
			<?php 
			if($val['is_required'] == 1) {
				$required = 'required';
			} else {
				$required = '';
			}
			$class = 'form-control';
			if($val['type'] == 3) {
				$class = 'flat';
			}
			if($val['type'] == 2) {
				$step = 'step="any"';
			} else {
				$step = '';
			}

			if($val['type'] == 6) {
				$class = 'form-control datepicker';
			}  
			if($val['side_info'] != '') { ?>
			<div class="input-group">
				<?php if($val['type'] == 4 || $val['type'] == 5) { ?>
					<select name="data[data_checklist][<?php echo $val['id'] ?>]" class="<?php echo $class ?>">
						<?php echo $form->options($val['type_options']); ?>
					</select>
				<?php } else { ?>
					<input id="id-<?php echo $val['id'] ?>" type="<?php echo strtolower($option_types[$val['type']]) ?>" name="data[data_checklist][<?php echo $val['id'] ?>]" 
			class="<?php echo $class ?> <?php echo $required ?>" <?php echo $required ?> <?php echo $step ?>>
				<?php } ?>
			<span class="input-group-addon">
				<?php echo $val['side_info'] ?>
				</span>
			</div>
			<?php } else { ?>

			<?php if($val['type'] == 4 || $val['type'] == 5) { ?>
					<select name="data[data_checklist][<?php echo $val['id'] ?>]" class="<?php echo $class ?>">
						<?php echo $form->options($val['type_options']); ?>
					</select>
			<?php } else { ?>
					<input id="id-<?php echo $val['id'] ?>" type="<?php echo strtolower($option_types[$val['type']]) ?>" name="data[data_checklist][<?php echo $val['id'] ?>]" 
			class="<?php echo $class ?> <?php echo $required ?>" <?php echo $required ?> <?php echo $step ?>>
				<?php } ?>

			<?php } ?>
				<?php echo $cl; ?>
			</div>
		<?php } ?>

<?php } ?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<table id="checklist" class="table table-striped table-bordered table-hover">
		  				<thead>
  					<?php if($has_hGroup){ ?>
  						<tr>
  							<?php foreach ($groupHeads as $key => $value) { $vt = count($value);  ?>
  								<?php if(is_numeric($key)){ ?>
  									<th class="text-center" colspan="<?php echo $vt; ?>"></th>
  								<?php } else { ?>
  									<th class="text-center bg-info" colspan="<?php echo $vt; ?>"><span><?php echo $key; ?></span></th>
  								<?php } ?>
  							<?php } ?>
  						</tr>
  					<?php } ?>
		  					<tr>
		  			<?php foreach ($doptions as $key => $value) { ?>
		  				<th class="text-center text-middle">
		  					<div><?php echo $value['name']?></div>
		  					<small><?php echo $value['info']?></small>
		  				</th>
		  			<?php } ?>
		  					</tr>
		  				</thead>
		  				<tbody>
		  					<?php for ($x = 0; $x < $tt; $x++) { ?>
		  						<tr>
		  							<?php foreach ($doptions as $key => $value) { ?>
		  								<?php if(isset($value['data'][$x])){ ?>
		  									<td>
		  								<?php 
		  								if($value['data'][$x]['is_required'] == 1) {
											$required = 'required';
											} else {
												$required = '';
											}
											$class = 'form-control';
											if($value['data'][$x]['type'] == 3) {
												$class = 'flat';
											}
											if($value['data'][$x]['type'] == 2) {
												$step = 'step="any"';
											} else {
												$step = '';
											}

											if($value['data'][$x]['type'] == 6) {
												$class = 'form-control datepicker';
											}
		  									// echo $value['data'][$x]['id']; 
		  								?>
		  								<?php if($value['data'][$x]['type'] == 4 || $value['data'][$x]['type'] == 5) { ?>
											<select name="data[data_checklist][<?php echo $value['data'][$x]['id'] ?>]" class="<?php echo $class ?>">
												<?php echo $form->options($value['data'][$x]['type_options']); ?>
											</select>
										<?php } else { ?>
											<input type="<?php echo strtolower($option_types[$value['data'][$x]['type']]) ?>" name="data[data_checklist][<?php echo $value['data'][$x]['id'] ?>]" 
									class="<?php echo $class ?> <?php echo $required ?>" <?php echo $required ?> <?php echo $step ?>>
										<?php } ?>
		  								</td>
		  								<?php } else { ?>
		  									<td><?php echo $x+1; ?></td>
		  								<?php } ?>
		  							<?php } ?>
		  						</tr>
		  					<?php } ?>
		  				</tbody>
		  			</table>
		  			<button class="btn btn-success"><?php echo __('Save','checklist') ?></button>
		  		</div>
		  		<?php $form->close(); ?>
		  		<?php } else { ////////////////////////////////////////////////////////// END VIEW list_add_view 2 ?>
		  		
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  		<div class="table-responsive hide">
		  		<?php $form->create(); ?>
		  		<table id="checklist" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<?php foreach ($options as $option) { ?>
								<th class="text-center text-middle">
										<?php echo $option['name'];?>
									<div><small><?php echo $option['info'];?></small></div>
								</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<?php foreach ($options as $option) {

							 ?>
								<td class="text-center">
									<?php 
									if($option['is_required'] == 1) {
										$required = 'required';
									} else {
										$required = '';
									}
									$class = 'form-control';
									if($option['type'] == 3) {
										$class = 'flat';
									}

									if($option['type'] == 2) {
										$step = 'step="0.01"';
									} else {
										$step = '';
									}

									if($option['type'] == 6) {
										$class = 'form-control datepicker';
									}  
									if($option['side_info'] != '') { ?>
									<div class="input-group">
										<?php if($option['type'] == 4 || $option['type'] == 5) { ?>
											<select name="data[data_checklist][<?php echo $option['id'] ?>]" class="<?php echo $class ?>">
												<?php echo $form->options($option['type_options']); ?>
											</select>
										<?php } else if($option['type'] == 8) { ?>
											<div><label><?php echo $option['name'];?></label></div>
										<?php } else { ?>
											<input type="<?php echo strtolower($option_types[$option['type']]) ?>" name="data[data_checklist][<?php echo $option['id'] ?>]" 
									class="<?php echo $class ?> <?php echo $required ?>" <?php echo $required ?> <?php echo $step ?>>
										<?php } ?>
									<span class="input-group-addon">
										<?php echo $option['side_info'] ?>
										</span>
									</div>
									<?php } else { ?>

									<?php if($option['type'] == 4 || $option['type'] == 5) { ?>
											<select name="data[data_checklist][<?php echo $option['id'] ?>]" class="<?php echo $class ?>">
												<?php echo $form->options($option['type_options']); ?>
											</select>
										<?php } else if($option['type'] == 8) { ?>
											<div><label><?php echo $option['name'];?></label></div>
										<?php } else { ?>
											<input type="<?php echo strtolower($option_types[$option['type']]) ?>" name="data[data_checklist][<?php echo $option['id'] ?>]" 
									class="<?php echo $class ?> <?php echo $required ?>" <?php echo $required ?> <?php echo $step ?>>
										<?php } ?>

									<?php } ?>
								</td>
							<?php } ?>
						</tr>
					</tbody>
				</table>
				<button class="btn btn-success"><?php echo __('Save','checklist') ?></button>
		  		<?php $form->close(); ?>
		  		</div>
		  	</div>
		  	<?php } ?>
		  	<?php
		  	if(isset($groups['full'])) {
		  		$diff = array_diff_key($groups, array_flip((array) array('full')));
		  	} else {
		  		$diff = $groups;
		  	}
		  
			$t = count($diff);
			if($t > 4) {
				if($t % 4 == 0) {
					$t = 4;
				} else if($t % 3 == 0) {
					$t = 3;
				} else {
					$t = 2;
				}
			}

		  	?>
<?php $form->create(); ?>

	<?php // print_r($groups); ?>

	<pre>
	<?php // print_r($listname); ?>
</pre>

<div class="flex">
	
		  	<?php foreach ($groups as $key => $value) { ?>
		  		
		  		<?php if($key === 'full') {?>
		  		<div class="flex-full flexWrap">

		  		<?php } else { ?>
		  		<div class="flex-<?php echo $t; ?> flexWrap">
		  		<?php } ?>
		  		<?php if($key == 'full' || is_numeric($key) ) {?>

		  		<?php } else { ?>
		  			<h4><?php echo $key; ?></h4>
		  		<?php } ?>
		  		<?php foreach ($value as $val) { ?>
		  			<?php if($val['type'] == 3 ) { ?>
		  			<?php $cl = '<label for="id-'.$val['id'].'">'.$val['name'].'</label> <small>'.$val['info'].'</small>'; ?>
		  				<div>
		  			<?php } else { ?>
		  				<?php $cl = ''; ?>
		  			<label for="id-<?php echo $val['id'] ?>"><?php echo $val['name']; ?></label> <small><?php echo $val['info'];?></small>
		  			<?php } ?>
		  					<?php 
									if($val['is_required'] == 1) {
										$required = 'required';
									} else {
										$required = '';
									}
									$class = 'form-control';
									if($val['type'] == 3) {
										$class = 'flat';
									}
									if($val['type'] == 2) {
										$step = 'step="any"';
									} else {
										$step = '';
									}

									if($val['type'] == 6) {
										$class = 'form-control datepicker';
									}  
									if($val['side_info'] != '') { ?>
									<div class="input-group">
										<?php if($val['type'] == 4 || $val['type'] == 5) { ?>
											<select name="data[data_checklist][<?php echo $val['id'] ?>]" class="<?php echo $class ?>">
												<?php echo $form->options($val['type_options']); ?>
											</select>
										<?php } else { ?>
											<input id="id-<?php echo $val['id'] ?>" type="<?php echo strtolower($option_types[$val['type']]) ?>" name="data[data_checklist][<?php echo $val['id'] ?>]" 
									class="<?php echo $class ?> <?php echo $required ?>" <?php echo $required ?> <?php echo $step ?>>
										<?php } ?>
									<span class="input-group-addon">
										<?php echo $val['side_info'] ?>
										</span>
									</div>
									<?php } else { ?>

									<?php if($val['type'] == 4 || $val['type'] == 5) { ?>
											<select name="data[data_checklist][<?php echo $val['id'] ?>]" class="<?php echo $class ?>">
												<?php echo $form->options($val['type_options']); ?>
											</select>
									<?php } else { ?>
											<input id="id-<?php echo $val['id'] ?>" type="<?php echo strtolower($option_types[$val['type']]) ?>" name="data[data_checklist][<?php echo $val['id'] ?>]" 
									class="<?php echo $class ?> <?php echo $required ?>" <?php echo $required ?> <?php echo $step ?>>
										<?php } ?>

									<?php } ?>


			<?php if($val['type'] == 3 ) { ?>
				<?php echo $cl; ?>
					  				</div>
					  			<?php } ?>

		  		<?php } ?>
		  		</div>
		  	<?php } ?>
		  	</div>
		  	</div>
		  	<button class="btn btn-success"><?php echo __('Save','checklist') ?></button>
		  	<?php $form->close(); ?>
		</div>
	</div>
<?php } ?>	
<?php if(!empty($listname['pasttimes']) && !empty($listdata)){ 

if(isset($groups['full'])) {
		$diff = array_diff_key($groups, array_flip((array) array('full')));
	} else {
		$diff = $groups;
	}
$t = count($diff);
 // echo $t;
	?>
	<pre>
		<?php // print_r($listname); ?>
	</pre>
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="results">
					<div class="text-center"><h3><?php echo $listname['name']; ?></h3></div>
					<div class="text-center"><strong><?php echo date('d-m-Y'); ?></strong></div>
					<div class="table-responsive">
					<table id="datatable" class="table table-striped table-bordered table-hover">
						<thead>
							<?php if($t > 1){ ?>
							<tr class="bg-info">
								<th></th>
								<?php foreach ($groups as $key => $group) { 
									$vt = count($group); 
									if(is_numeric($key) || $key === 'full') {
										$gr = '';
									} else {
										$gr = $key;
									} ?>
									<th class="text-center" colspan="<?php echo $vt; ?>"><span><?php echo $gr; ?></span></th>
								<?php } ?>
								<th></th>
							</tr>
							<?php } ?>
							
							<tr>
								<th class="text-center"><?php echo __('Interval','checklist'); ?></th>
								<?php foreach ($options as $option) { ?>
								<th class="text-center">
									<span><?php echo $option['name'];?></span>
									<div><small><?php echo $option['info'];?></small></div>
								</th>
								<?php } ?>
								<th class="text-center"><?php echo __('Done by','checklist'); ?> </th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($listdata as $list) { ?>
								<?php if($list['added'] == 1) { ?>
								<tr>
									<td class="text-center"><?php echo $list['data_interval']; ?></td>
									<?php foreach ($options as $option) { ?>
										<td class="text-center">
											<?php if( isset($list['data_checklist'][$option['id']])) {
													if(isset($option['type_options'][$list['data_checklist'][$option['id']]])) {
														echo $option['type_options'][$list['data_checklist'][$option['id']]];
													} else if($list['data_checklist'][$option['id']] == 'on') {
															echo '<i class="text-success">&#10004;</i>';
													} else {
														echo $list['data_checklist'][$option['id']] . ' ' .$option['side_info'];
													}	
												}
											?>
											<?php // echo $option['name'];?>
										</td>
									<?php } ?>
									<td class="text-center">
									<?php if(isset($user[$list['created_user']]['fname'])) { ?>
										<small><?php echo $user[$list['created_user']]['fname']; ?> <?php echo $user[$list['created_user']]['lname']; ?></small>
										<div>
											<small>
												<?php echo __('at','checklist'); ?> 
												<?php echo date('H:i', strtotime($list['data_time'])); ?>
											</small>
										</div>
										<?php } else if(isset($user[$list['updated_user']]['fname'])) { ?>
										<small><?php echo $user[$list['updated_user']]['fname']; ?> <?php echo $user[$list['updated_user']]['lname']; ?></small>
										<div>
											<small>
												<?php echo __('on','checklist'); ?> 
												<?php echo date('d-m-Y H:i', strtotime($list['updated'])); ?>
											</small>
										</div>
										<?php } ?>
									</td>
								</tr>
								<?php } else { ?>
								<tr class="bg-danger">
									<td class="text-center"><?php echo $list['data_interval']; ?></td>
									<?php foreach ($options as $option) { ?>

										<td class="text-center">
											
										</td>

									<?php } ?>
									<td class="text-center"></td>
								</tr>
								<?php } ?>
							<?php } ?>
						</tbody>
					</table>
					</div>
				</div>
				</div>
		  	</div>
		</div>
	</div>
<?php } ?>
</div>
<script type="text/javascript">
	if($('#datatable-checklist').length) {
		$('#datatable-checklist').DataTable({"pageLength": 50});
	}
	var up = '<div class="progress abs-progress hide"><div class="the-prog bg-danger"></div></div>';
	$('.uploadfilewrapper').append(up);
</script>
<script>
    var doc = new jsPDF('l');
    // It can parse html:
   doc.autoTable({html: '#datatable'});    
  // doc.save('table.pdf');
</script>
<?php } else { ?>
<pre>
	<?php print_r($listnames); ?>
</pre>
<div class="container-fluid">
	<div class="panel panel-default" id="all-lists">
		<div class="panel-body">
		  	<div class="row">
		  		<?php //  print_r($pasttimes) ?>
		  		<?php foreach ($listnames as $key => $value) { ?>
		  			<div class="hide">
		  			<?php if(!empty($value['futuretimes'])) { 
						$now = new DateTime();
						$date = date('Y-m-d');
						$future_date = new DateTime($date.' '.$value['futuretimes'][0].':00');
						$interval = $future_date->diff($now);
						// print_r($interval);
						$remain = $interval->format("%h:%i:%s");
					} else {
						$remain = '0:0:00';
					} ?>
					<div id="time-<?php echo $value['id'];?>"><?php echo $remain; ?></div>
					</div>
		  			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		  				<div class="list-box" id="list-<?php echo $value['id'];?>">
		  				<h4 class="text-center">
		  					<?php echo $html->admin_link($value['name'],'checklist/view-list/'.$value['id'].'/');?>
		  				</h4>
		  				<?php if(empty($value['notyet']) && empty($value['pasttimes'])) { ?>
		  					<div class="btn btn-default wait-btn"><?php echo __('Wait','checklist');?> <span>...</span></div>
		  					<span class="next-time text-success">
		  						<i class="fa fa-arrow-right"></i> <?php echo __('Starts at','checklist');?>
		  						<i class="fa fa-clock-o"></i> <?php echo $value['futuretimes'][0];?>
		  					</span>

		  				<?php } else if(empty($value['notyet'])) { ?>
		  					<?php 
		  					if(isset($value['list-remain-count']) && isset($value['futuretimes'])) {
		  					echo $html->admin_link(__('Ready to add','checklist').' ('.$value['list-remain-count'].')'
		  					,'checklist/add-to-list/'.$value['id']
		  					, array('class' => 'btn btn-success'));
		  					} else if(isset($value['list-remain-count']) && !isset($value['futuretimes'])){ ?>
		  						<div class="btn btn-warning done-btn"><?php echo __('Done','checklist');?></div>
			  					<span class="no-time text-danger">
			  						<i class="fa fa-warning"></i> <?php echo __('Time\'s up','checklist');?></span>
		  			<?php } else {
		  					echo $html->admin_link(__('Ready to add','checklist')
		  					,'checklist/add-to-list/'.$value['id']
		  					, array('class' => 'btn btn-success')); 
		  					}
		  					?>
		  					<?php if(!empty($value['futuretimes'])) { ?> 
		  						<span class="remaining">...</span>
		  						<span><?php echo __('remaining','checklist');?></span>
		  					<?php } ?>
		  					<span class="pull-right"><?php echo date('d-m-Y'); ?></span>
		  				<?php } else { ?>
		  					<?php if(!empty($value['futuretimes']) && $value['interval_type'] == 1) { ?>
			  					<div class="btn btn-default wait-btn"><?php echo __('Wait','checklist');?> <span>...</span></div>
			  					<span class="next-time text-success">
			  						<i class="fa fa-arrow-right"></i> <?php echo __('Next at','checklist');?>
			  						 <i class="fa fa-clock-o"></i> <?php echo $value['futuretimes'][0];?>
			  					</span>
			  				<?php } else if(!empty($value['futuretimes']) && $value['interval_type'] == 2) { ?>
			  					<div class="btn btn-warning done-btn"><?php echo __('Done','checklist');?></div>
			  					<span class="no-time text-danger">
			  						<i class="fa fa-warning"></i> <?php echo __('No more lists to add','checklist');?></span>
			  				<?php } else {  ?>
			  					<div class="btn btn-warning done-btn"><?php echo __('Done','checklist');?></div>
			  					<span class="no-time text-danger">
			  						<i class="fa fa-warning"></i> <?php echo __('No more lists to add','checklist');?></span>
			  				<?php } ?>
		  					<span class="pull-right"><?php echo date('d-m-Y'); ?></span>
		  				<?php } ?>
		  				<table id="datatable" class="table table-striped table-bordered table-hover">
		  					<thead>
		  						<tr>
		  							<th class="col-lg-5"><?php echo __('Interval','checklist');?></th>
		  							<th class="col-lg-5"><?php echo __('Added','checklist');?></th>
		  							<th class="col-lg-2"><?php echo __('List','checklist');?></th>
		  						</tr>
		  					</thead>
		  					<tbody>
		  						
		  					</tbody>
		  					<?php 
		  					if(isset($value['listdata'])) {
		  					foreach ($value['listdata'] as $val) {
		  					$class = ''; 
		  						if($val['added'] == 0) { 
		  							$class = 'bg-danger'; 
		  						}
		  						?>
		  						<tr class="<?php echo $class;?>">
			  						<td><?php echo $val['data_interval'];?></td>
			  						<td><?php 
			  						if(isset($val['data_time'])) { ?>
			  							<?php echo date('H:i', strtotime($val['data_time']));?>
			  						<?php } else { ?>
			  							<i class="fa fa-times text-danger"></i>
			  						<?php } ?>
			  						</td>
			  						<td><?php 
			  						if($val['added'] == 1) { ?>
			  							<i class="text-success">&#10004;</i>
			  						<?php } else { ?>
			  							<i class="fa fa-times text-danger"></i>
			  						<?php } ?>
			  						</td>
		  						</tr>
		  					<?php } 
		  					}
		  					?>
		  				</table>
		  				</div> 
		  			</div>
		<?php if(!empty($value['futuretimes'])) { ?>
		<script type="text/javascript">
		function do_time_count_<?php echo $value['id'];?>() {
			var timer2 = $('body').find('#time-<?php echo $value['id'];?>').text();
			if(timer2 != '0:0:00') {
				var interval = setInterval(function() {
				var timer = timer2.split(':');
				//by parsing integer, I avoid all extra string processing
				var hours = parseInt(timer[0], 10);
				var minutes = parseInt(timer[1], 10);
				var seconds = parseInt(timer[2], 10);
				--seconds;
				
				if (hours < 0) clearInterval(interval);
				minutes = (seconds < 0) ? --minutes : minutes;
				if(hours > 0 && minutes < 0) {
					hours = --hours;
					minutes = 59;
				}
				if (minutes < 0) clearInterval(interval);
				seconds = (seconds < 0) ? 59 : seconds;
				seconds = (seconds < 10) ? '0' + seconds : seconds;
				//minutes = (minutes < 10) ?  minutes : minutes;
				if(timer2 != '0:0:00') {
				 	if(hours > 0) {
					$('body').find('#list-<?php echo $value['id'];?> .wait-btn span').html(hours+'h:'+minutes + 'm' + ':' + seconds+'s');
				  	$('body').find('#list-<?php echo $value['id'];?> .remaining').html(hours+'h:'+minutes  + 'm' + ':' + seconds+'s');
					} else {
					$('body').find('#list-<?php echo $value['id'];?> .wait-btn span').html(minutes + 'm' + ':' + seconds+'s');
				  	$('body').find('#list-<?php echo $value['id'];?> .remaining').html(minutes  + 'm' + ':' + seconds+'s');
					}
				} else {
				  	$('body').find('#list-<?php echo $value['id'];?> .wait-btn span').html('');
				  	$('body').find('#list-<?php echo $value['id'];?> .remaining').html('');
				}
				timer2 = hours + ':'+ minutes + ':' + seconds;
				if(timer2 == '0:0:00') {
				  	clearInterval(interval);
				  	// alert(1);
				  	setTimeout(function(){
				  		var pathtopage = window.location.href;
	      				$('#all-lists').load(pathtopage + ' #all-lists .panel-body', function(){
	      					do_time_count_<?php echo $value['id'];?>();
	      				});
				  	 }, 1500);
				  }
				}, 1000);
			}
		}
		do_time_count_<?php echo $value['id'];?>();

		</script>
	<?php } ?>
	<?php } ?>
		  	</div>

		</div>
	</div>
</div>


<?php } ?>

