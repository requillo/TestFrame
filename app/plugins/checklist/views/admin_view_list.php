<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!empty($listname)) { 
$listdata = array();
if($listname['category']['interval_type'] == 1) {
	foreach ($pasttimes as $key => $value) {
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
	$i = 1;
	foreach ($checklists as $key => $lists) {
		$listdata[$key] = $lists;
		$listdata[$key]['data_interval'] = $i;
		$listdata[$key]['data_checklist'] = json_decode($lists['data_checklist'], true);
		$listdata[$key]['added'] = 1;
		$i++;
	}
}

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

}
?>
<pre>
	<?php //  print_r($listdata) ?>
</pre>
<div class="container-fluid">
<?php if(!empty($listdata)){ ?>
	<div class="panel panel-default print-landscape">
		<div class="panel-body">
		  	<div class="row">
		  		<div class='col-lg-3 col-md-4 col-sm-12 col-xs-12'>
			        <div class="form-group">
			            <div class='input-group date'>
			                <input type='text' class="form-control" id='datetimepicker' value="" />
			                <span class="input-group-addon"><span class="fa fa-calendar"></span>
			                </span>
			            </div>
			        </div>
			    </div>
<?php if($listname['category']['list_view'] == 2) { ?>
			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			    	<?php foreach ($listdata as $list) { ?>
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
			    	<?php foreach ($get_header_types as $key => $value) { ?>
			    		<th class="text-center text-middle">
		  					<div><?php echo $value['name']?></div>
		  					<small><?php echo $value['info']?></small>
		  				</th>
			    	<?php } ?>
			    	</thead>
			    	<tbody>
			    		<?php for ($x = 0; $x < $tt; $x++) { ?>
			    		<tr>
			    		<?php if($list['added'] == 1) { ?>
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
											
									<?php if(isset($list['data_checklist'][$value['data'][$x]['id']])) {
										 echo $list['data_checklist'][$value['data'][$x]['id']];
									} ?>
									<?php  ?>
										<?php } ?>
		  								</td>
		  								<?php } else { ?>
		  									<td><?php echo $x+1; ?></td>
		  								<?php } ?>
		  							<?php } ?>
			    		<?php } else { ?>
			    		<?php foreach ($doptions as $key => $value) { ?>
			    		<td><?php // echo $x+1; ?></td>
			    		<?php } ?>
			    		<?php } ?>
			    		</tr>
			    		<?php } ?>
			    	</tbody>
			    	</table>
			    	<?php } ?>
			    </div>
<?php } else { ?>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="results">
					<div class="text-center"><h3><?php echo __('Checklist','checklist').' '. $listname['name']; ?></h3></div>
					<div class="text-center"><strong><?php echo date('d-m-Y'); ?></strong></div>
					<div class="table-responsive">
					<table id="datatable" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center"><?php echo __('Time','checklist'); ?></th>
								<?php foreach ($options as $option) { ?>
								<th class="text-center">
									<?php echo $option['name'];?>
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
									<td class="text-center">
										<?php
										if($list['can_edit'] > 0 || $list['manage_open'] > 0 ) { 
											echo $html->admin_link('<i class="fa fa-edit no-print"></i> '. $list['data_interval'],'checklist/edit-list/'.$list['id']);
										 } else {
										echo '<i class="fa fa-lock text-warning no-print" ></i> '. $list['data_interval']; 
										} ?>
									</td>
									<?php foreach ($options as $option) { ?>

										<td class="text-center">
											<?php if( isset($list['data_checklist'][$option['id']])) {
													if(isset($option['type_options'][$list['data_checklist'][$option['id']]])) {
														echo $option['type_options'][$list['data_checklist'][$option['id']]];
													} else if($list['data_checklist'][$option['id']] == 'on') {
														echo '<i class="text-success">&#10004;</i>';
													} else {
														echo $list['data_checklist'][$option['id']] . ' ';
														if($list['data_checklist'][$option['id']] != '') {
															echo $option['side_info'];
														}
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
								<tr class="bg-warning">
									<td class="text-center"><i class="fa fa-exclamation-triangle text-danger no-print"></i> <?php echo date('H:i', strtotime($list['data_interval'])) ?></td>
									<?php foreach ($options as $option) { ?>

										<td class="text-center">
											<span class="text-danger">x</span>
										</td>
									<?php } ?>
									<td class="text-center"><span class="text-danger">x</span></td>
								</tr>
								<?php } ?>
							<?php } ?>
						</tbody>
					</table>
					</div>
				</div>
				</div>
<?php }  ?>
				<?php if(!empty($category)){ ?>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"><?php echo nl2br($category['info_01']) ?></div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"><?php echo nl2br($category['info_02']) ?></div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"><?php echo nl2br($category['info_03']) ?></div>
				<?php } ?>
		  	</div>
		</div>
	</div>
<?php } ?>
</div>
<script type="text/javascript">
var loader = '<div class="loaderwrap absolute overlay"><div class="the-loader s2 load-center text-white"></div></div>';
$('#datetimepicker').daterangepicker({
	singleDatePicker: true,
    startDate: moment('<?php echo $page[1] ; ?>'),
    maxDate: moment('<?php echo date('Y-m-d') ; ?>')
}, function(start, end, label){
    // alert(start.format('YYYY-M-D'));
    $('body').find('.results').append(loader);
    window.location.href = "<?php echo admin_url('checklist/view-list/'.$page[0].'/') ?>"+start.format('YYYY-MM-DD')+'/';
});
</script>

<?php } else { ?>

<?php } ?>