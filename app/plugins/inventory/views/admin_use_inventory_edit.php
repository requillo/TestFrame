<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$lang = rtrim(LANG_ALIAS,'/');

if($id) {

?>
<pre>
	<?php print_r($inventory_before); ?> 
	after
	<?php print_r($inventory_after); ?>
</pre>
<?php $form->create(array('class' => 'no-enter')) ?>

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
          			<?php  } else if($type == NULL && isset($inv_u[$item['id']]['use'])) { ?>
          			<tr>
						<td>
							<label for=""><?php echo $item['name'] ?></label>	
						</td>
						<td>
							<input min="0" type="number" class="form-control input-add" name="data[items][<?php echo $item['id'] ?>][use]" value="<?php echo $inv_u[$item['id']]['use'] ;?>">
						</td>
						<td>
							<span class="item-inventory"><?php echo $inv_d[$item['id']]['inventory'] ?></span>
						</td>
						<td>
							<input type="text" class="form-control input-notes" name="data[items][<?php echo $item['id'] ?>][notes]" value="<?php echo $inv_u[$item['id']]['notes'] ;?>">
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
<?php } ?>