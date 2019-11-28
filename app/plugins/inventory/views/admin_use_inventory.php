<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$lang = rtrim(LANG_ALIAS,'/');
//echo $type;
echo $use_inventory;
?>
<?php $form->create(array('class' => 'no-enter')) ?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-3 col-md-4 col-sm-6">
		            <div class="form-group">
		                <div class='input-group date' id='datetimepicker1'>
		                    <input type="text" name="data[inventory_date]" id="input-site_date" class="form-control" readonly="">
		                    <span class="input-group-addon">
		                        <label for="input-site_date"><span class="glyphicon glyphicon-calendar"></span></label>
		                    </span>
		                </div>
		            </div>
	            </div>
	            <?php if(!empty($latest_inventory_use)) { ?>
	            <div class="col-lg-12 col-md-12 col-sm-12">
	            	<ul class="list-group">
	            	<?php foreach ($latest_inventory_use as $inventory_use) { ?>
	            		<li class="list-group-item">
	            			<?php echo $html->admin_link(date('F d Y', strtotime($inventory_use['inventory_date'])), 'inventory/use-inventory-edit/'.$inventory_use['id'], array('class'=>'btn-block')); ?>
	            		</li>
	            	<?php } ?>
	            	</ul>
	            </div>
	        	<?php } ?>
		    </div>
		</div>
	</div>
</div>
<?php if($use_inventory) { ?>
<div class="container-fluid"> 
	<div class="panel panel-danger">
		<div class="panel-heading"><?php echo __('Warning, you\'ve already used inventory today', 'inventory') ?></div>
		<div class="panel-body">
			<ul class="list-group">
				<li class="list-group-item">
			<?php echo $html->admin_link(__('Click here to edit your used inventory for today'), 'inventory/use-inventory-edit/'.$use_inventory, array('class'=>'btn-block')); ?>
				</li>
			</ul>
		</div>
	</div>
</div>
<?php } else { ?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		
		<div class="panel-body">
		  	<div class="row">
		  	<div id="all-cat-wrapper">
		  	<?php if(!empty($items)) {?>
		  	<table id="all-categories" class="table table-striped bulk_action">         
				<thead>
					<tr>
						<th><?php echo __('Name','inventory') ?></th>
						<th style="width: 120px"><?php echo __('Use','inventory') ?></th>
						<th style="width: 120px"><?php echo __('Inventory ','inventory') ?></th>
						<th><?php echo __('Notes ','inventory') ?></th>
					</tr>
				</thead>
          		<tbody>
          			<?php foreach($items as $item){ ?>

          			<?php if($type != NULL &&  $type == $item['item_type'] ) { ?> 
          			<tr>
						<td>
							<label for=""><?php echo $item['name'] ?></label>	
						</td>
						<td>
							<input min="0" type="number" class="form-control input-add" name="data[items][<?php echo $item['id'] ?>][use]">
						</td>
						<td>
							<span class="item-inventory"><?php echo $inv_d[$item['id']]['inventory'] ?></span>
						</td>
						<td>
							<input type="text" class="form-control input-notes" name="data[items][<?php echo $item['id'] ?>][notes]">
						</td>
					</tr>
          			<?php  } else if($type == NULL) { ?>
          			<tr>
						<td>
							<label for=""><?php echo $item['name'] ?></label>	
						</td>
						<td>
							<input min="0" type="number" class="form-control input-add" name="data[items][<?php echo $item['id'] ?>][use]">
						</td>
						<td>
							<span class="item-inventory"><?php echo $inv_d[$item['id']]['inventory'] ?></span>
						</td>
						<td>
							<input type="text" class="form-control input-notes" name="data[items][<?php echo $item['id'] ?>][notes]">
						</td>
					</tr>
					<?php  }  ?>
					<?php } ?>
          		</tbody>
          	</table>
			<?php } ?>
			</div>
		  	</div>
		</div>
		<button class="btn btn-success">Save</button>
	</div>
</div>
<?php } ?>
<?php $form->close(); ?>
<script type="text/javascript">
	$('#input-site_date').daterangepicker({ 
		singleDatePicker: true,
		minDate: moment().subtract(5, 'week').startOf('day'),
        maxDate: '<?php echo date('m/d/Y') ?>', 
    });
	$('.input-add').on('keydown', function(e){
		var brw = navigator.userAgent;
		// I do this for EDGE stupid browser
		if(brw.toLowerCase().indexOf("edge") == -1) {
			if(e.keyCode == 40) {
			e.preventDefault();
			$(this).closest('tr').next().find('.input-add').focus();
			} else if(e.keyCode == 38) {
				e.preventDefault();
				$(this).closest('tr').prev().find('.input-add').focus();
			}
		}
		
	});
	$('.input-notes').on('keydown', function(e){
		var brw = navigator.userAgent;
		if(brw.toLowerCase().indexOf("edge") == -1) {
			if(e.keyCode == 40) {
				e.preventDefault();
				$(this).closest('tr').next().find('.input-notes').focus();
			} else if(e.keyCode == 38) {
				e.preventDefault();
				$(this).closest('tr').prev().find('.input-notes').focus();
			}
		}
	});
	$('input').on('focus', function(e){
		$('tr').removeClass('info');
		$(this).closest('tr').addClass('info');
	});
</script>

<pre>
	<?php print_r($items);?>
</pre>