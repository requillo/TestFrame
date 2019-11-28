<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$lang = rtrim(LANG_ALIAS,'/');
//echo $type;
echo $add_inventory;
?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<?php $form->create(array('class' => 'no-enter')) ?>
		<div class="panel-body">
		  	<div class="row">
		  	<div id="all-cat-wrapper">
		  	<?php if(!empty($items)) {?>
		  	<table id="all-categories" class="table table-striped bulk_action">         
				<thead>
					<tr>
						<th><?php echo __('Name','inventory') ?></th>
						<th style="width: 120px"><?php echo __('Add','inventory') ?></th>
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
							<input min="0" type="number" class="form-control input-add" name="data[items][<?php echo $item['id'] ?>][add]">
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
							<input min="0" type="number" class="form-control input-add" name="data[items][<?php echo $item['id'] ?>][add]">
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
		<?php $form->close('add'); ?>
	</div>
</div>

<script type="text/javascript">
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