<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!empty($listname)) { 

?>

	<?php // print_r($listdata) ?>

<div class="hide">
	<a id="listdata" href="#" data-id="<?php echo $page[0];?>" data-date="<?php echo $page[1];?>"></a>
</div>	
<div class="container-fluid">
	<div class="panel panel-default print-landscape">
		<div class="panel-body">
		  	<div class="row">
		  		<div class='col-lg-3 col-md-4 col-sm-12 col-xs-12'>
			        <select id="select-name" class="form-control">
			        	<option value=""><?php echo __('Select a list name') ?></option>
			        	<?php echo $form->options($names_options,array('key'=>$page[0])); ?>
			        </select>
			    </div>
		  		<div class='col-lg-3 col-md-4 col-sm-12 col-xs-12'>
			        <div class="form-group">
			            <div class='input-group date'>
			                <input type='text' class="form-control" id='datetimepicker' value="" />
			                <span class="input-group-addon"><span class="fa fa-calendar"></span>
			                </span>
			            </div>
			        </div>
			    </div>
		  	</div>
		</div>
	</div>
<?php if(!empty($pasttimes) && !empty($listdata)){ ?>
	<div class="panel panel-default print-landscape">
		<div class="panel-body">
		  	<div class="row">
		  		
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="results">
					<div class="text-center"><h3><?php echo __('Checklist','checklist').' '. $listname['name']; ?></h3></div>
					<div class="text-center"><strong><?php echo __('Line','checklist').': '. $listname['line']; ?></strong></div>
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
								<?php if($list['added'] == 1 && $list['can_edit'] == 0) { ?>
								<tr>
									<td class="text-center">
										<?php if($list['manage_open']  == 0) {?>
										<a href="#" class="lock-open" data-id="<?php echo $list['id'] ?>">
										<i class="fa fa-lock text-warning no-print" ></i>
										<?php echo date('H:i', strtotime($list['data_time_array']));?>
										</a>
									<?php } else { ?>
										<a href="#" class="unlock-close" data-id="<?php echo $list['id'] ?>">
										<i class="fa fa-unlock text-success no-print" ></i>
										<?php echo date('H:i', strtotime($list['data_time_array']));?>
										</a>
									<?php } ?>
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
												<?php echo __('on','checklist'); ?> 
												<?php echo date('H:i', strtotime($list['data_time'])); ?>
											</small>
										</div>
										<?php } ?>
									</td>
								</tr>
								<?php } else { ?>
								<?php if(isset($list['locked']) && $list['locked'] == 1 ) { ?>	
								<tr class="bg-warning">
									<td class="text-center">
										<a href="#" class="add-open">
										<i class="fa fa-exclamation-triangle text-danger no-print"></i> 
										<?php echo date('H:i', strtotime($list['data_time_array'])) ?>
										</a>
									</td>
									
									<?php foreach ($options as $option) { ?>

										<td class="text-center">
											<span class="text-danger">x</span>
										</td>

									<?php } ?>
									<td class="text-center"><span class="text-danger">x</span></td>
								</tr>
								<?php } ?>
								<?php } ?>
							<?php } ?>
						</tbody>
					</table>
					</div>
				</div>
				</div>
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
    var a = $('#select-name option:selected').val();
    $('body').find('.results').append(loader);
    window.location.href = "<?php echo admin_url('checklist/manage-list/'); ?>"+a+'/'+start.format('YYYY-M-D')+'/';
});

$('#select-name').on('change',function(){
	var a = $('#select-name option:selected').val();
	var b = moment($('#datetimepicker').val());
	b = b.format("YYYY-MM-DD");
	if(a != ''){
	$('body').find('.results').append(loader);
	window.location.href = "<?php echo admin_url('checklist/manage-list/') ?>"+a+'/'+b+'/';	
	}
});

$('.lock-open').on('click', function(e){
	e.preventDefault();
	var id = $(this).attr('data-id');
	data = {
		'data[id]':id
	}
	$.getJSON( Jsapi+'checklist/manage-open-list-json/', data ,function( data ) {
		 $('body').find('.results').append(loader);
			location.reload(true);
			console.log(data);
	});
});

$('.add-open').on('click', function(e){
	e.preventDefault();
	var id = $('#listdata').attr('data-id');
	var d = $('#listdata').attr('data-date');
	var t = $(this).text();
	// alert(id + d);
	data = {
		'data[checklist_name_id]':id,
		'data[data_time_array]':t,
		'data[data_date]':d
	}
	$.getJSON( Jsapi+'checklist/manage-open-list-json/', data ,function( data ) {
		 $('body').find('.results').append(loader);
			location.reload(true);
			console.log(data);
	});
});

$('.unlock-close').on('click', function(e){
	e.preventDefault();
	var id = $(this).attr('data-id');
	// alert(id);
	data = {
		'data[id]':id
	}
	$.getJSON( Jsapi+'checklist/manage-close-list-json/', data ,function( data ) {
		$('body').find('.results').append(loader);
			location.reload(true);
			console.log(data);
	});
});
</script>
<?php } else { ?>
<div class="container-fluid">
<div class="panel panel-default print-landscape">
		<div class="panel-body">
		  	<div class="row">
		  		<div class='col-lg-3 col-md-4 col-sm-12 col-xs-12'>
			        <select id="select-name" class="form-control">
			        	<option value=""><?php echo __('Select a list name') ?></option>
			        	<?php echo $form->options($names_options); ?>
			        </select>
			    </div>
		  	</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#select-name').on('change',function(){
		var a = $('#select-name option:selected').val();
		if(a != ''){
		window.location.href = "<?php echo admin_url('checklist/manage-list/') ?>"+a+'/';	
		}
	});
</script>

<?php } ?>