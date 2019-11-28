<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!empty($checklist)) {
$listdata = array();

?>
<div class="container-fluid">
	
		<?php // print_r($checklist); ?>
		<?php // print_r($options); ?>
		<?php // print_r($checklist); ?>
	<div class="panel panel-default hidden-print">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  		<div class="text-center"><h3><?php echo __('Checklist','checklist').' '. $name['name']; ?></h3></div>
				
				<div class="text-center"><strong><?php echo date('d-m-Y', strtotime($checklist['data_date'])); ?></strong></div>
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
								
								if(isset($checklist['data_checklist'][$option['id']])) {
									
									if($checklist['data_checklist'][$option['id']] == 'on') {
										$checked = ' checked';
										$val = '';
										$selected = '';
									} else if($checklist['data_checklist'][$option['id']] != '') {
										$checked = '';
										$val = 'value="'. $checklist['data_checklist'][$option['id']].'"';
										$selected =  $checklist['data_checklist'][$option['id']];
									} else {
										$val = '';
										$checked = '';
										$selected = '';
									}

								} else {
									$val = '';
									$checked = '';
								}
								
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

									if($option['type'] == 6) {
										$class = 'form-control datepicker';
									}  
									if($option['side_info'] != '') { ?>
									<div class="input-group">
										<?php if($option['type'] == 4 || $option['type'] == 5) { ?>
											<select name="data[data_checklist][<?php echo $option['id'] ?>]" class="<?php echo $class ?>">
												<?php echo $form->options($option['type_options'], array('key'=>$selected)); ?>
											</select>
										<?php } else { ?>
											<input type="<?php echo strtolower($option_types[$option['type']]) ?>" name="data[data_checklist][<?php echo $option['id'] ?>]" 
									class="<?php echo $class ?> <?php echo $required ?>" <?php echo $required ?> <?php echo $val ?> <?php echo $checked ?>>
										<?php } ?>
									<span class="input-group-addon">
										<?php echo $option['side_info'] ?>
										</span>
									</div>
									<?php } else { ?>

										<?php if($option['type'] == 4 || $option['type'] == 5) { ?>
											<select name="data[data_checklist][<?php echo $option['id'] ?>]" class="<?php echo $class ?>">
												<?php echo $form->options($option['type_options'],array('key'=>$selected)); ?>
											</select>
										<?php } else { ?>
											<input type="<?php echo strtolower($option_types[$option['type']]) ?>" name="data[data_checklist][<?php echo $option['id'] ?>]" 
									class="<?php echo $class ?> <?php echo $required ?>" <?php echo $required ?> <?php echo $val ?> <?php echo $checked ?>>
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

<div class="flex">
	
		  	<?php foreach ($groups as $key => $value) { 

		  		?>
		  		<?php if($key === 'full') {?>
		  		<div class="flex-full flexWrap">

		  		<?php } else { ?>
		  		<div class="flex-<?php echo $t; ?> flexWrap">
		  		<?php } ?>
		  		<?php if($key == 'full' || is_numeric($key) ) {?>

		  		<?php } else { ?>
		  			<h4><?php echo $key; ?></h4>
		  		<?php } ?>
		  		<?php foreach ($value as $vals) { 

						if(isset($checklist['data_checklist'][$vals['id']])) {
						
						if($checklist['data_checklist'][$vals['id']] == 'on') {
							$checked = ' checked';
							$val = '';
							$selected = '';
						} else if($checklist['data_checklist'][$vals['id']] != '') {
							$checked = '';
							$val = 'value="'. $checklist['data_checklist'][$vals['id']].'"';
							$selected =  $checklist['data_checklist'][$vals['id']];
						} else {
							$val = '';
							$checked = '';
							$selected = '';
						}

					} else {
						$val = '';
						$checked = '';
					}

		  			?>

		  			<?php if($vals['type'] == 3 ) { ?>
		  			<?php $cl = '<label for="id-'.$vals['id'].'">'.$vals['name'].'</label> <small>'.$vals['info'].'</small>'; ?>
		  				<div>
		  			<?php } else { ?>
		  				<?php $cl = ''; ?>
		  			<label for="id-<?php echo $vals['id'] ?>"><?php echo $vals['name']; ?></label> <small><?php echo $vals['info'];?></small>
		  			<?php } ?>
		  					<?php 
									if($vals['is_required'] == 1) {
										$required = 'required';
									} else {
										$required = '';
									}
									$class = 'form-control';
									if($vals['type'] == 3) {
										$class = 'flat';
									}
									if($vals['type'] == 2) {
										$step = 'step="any"';
									} else {
										$step = '';
									}

									if($vals['type'] == 6) {
										$class = 'form-control datepicker';
									}  
									if($vals['side_info'] != '') { ?>
									<div class="input-group">
										<?php if($vals['type'] == 4 || $vals['type'] == 5) { ?>
											<select name="data[data_checklist][<?php echo $vals['id'] ?>]" class="<?php echo $class ?>">
												<?php echo $form->options($vals['type_options'],array('key'=>$selected)); ?>
											</select>
										<?php } else { ?>
											<input id="id-<?php echo $vals['id'] ?>" type="<?php echo strtolower($option_types[$vals['type']]) ?>" name="data[data_checklist][<?php echo $vals['id'] ?>]" 
									class="<?php echo $class ?> <?php echo $required ?>" <?php echo $required ?> <?php echo $step ?> <?php echo $val ?> <?php echo $checked ?>>
										<?php } ?>
									<span class="input-group-addon">
										<?php echo $vals['side_info'] ?>
										</span>
									</div>
									<?php } else { ?>

									<?php if($vals['type'] == 4 || $vals['type'] == 5) { ?>
											<select name="data[data_checklist][<?php echo $vals['id'] ?>]" class="<?php echo $class ?>">
												<?php echo $form->options($vals['type_options'],array('key'=>$selected)); ?>
											</select>
									<?php } else { ?>
											<input id="id-<?php echo $vals['id'] ?>" type="<?php echo strtolower($option_types[$vals['type']]) ?>" name="data[data_checklist][<?php echo $vals['id'] ?>]" 
									class="<?php echo $class ?> <?php echo $required ?>" <?php echo $required ?> <?php echo $step ?> <?php echo $val ?> <?php echo $checked ?>>
										<?php } ?>

									<?php } ?>


			<?php if($vals['type'] == 3 ) { ?>
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
		</div>
	</div>
</div>
<?php } ?>

