<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$lang = rtrim(LANG_ALIAS,'/');
$check_items = array();
foreach ($types_options as $key => $value) {
    foreach($items as $item){

    }
}

?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-4">
		  			<?php $form->input('name',array('type'=>'text','label'=>__('Item name','inventory'))); ?>
		  		</div>
		  		<div  class="col-lg-4">
		  			<div class="form-group ">
		  			<label for="inventory-type-input"><?php echo __('Item type','inventory'); ?></label>
		  			<select class="form-control" id="inventory-type-input" name="data[type]">
							<?php echo $form->options($types_options); ?>
					</select>
					</div>
		  		</div>
		  		<div  class="col-lg-4">
		  			<div class="form-group ">
		  			<label for="inventory-cat-input"><?php echo __('Category','inventory'); ?></label>
		  			<select class="form-control" id="inventory-cat-input" name="data[category]">
							<?php echo $form->options($cats_options); ?>
					</select>
				</div>
		  		</div>
		  		<div class="col-lg-4">
		  			<?php $form->input('inventory_min',array('type'=>'number','label'=>__('Minimum stock','inventory'),'attribute' =>'min="0"')); ?>
		  		</div>
		  		<div class="col-lg-4">
		  			<?php $form->input('inventory_min_message',array('type'=>'text','label'=>__('Minimum stock message','inventory'))); ?>
		  		</div>
		  		<div class="col-lg-4"><label>&nbsp;</label>
		  			<a href="#" class="btn btn-success btn-block add-item"><?php echo __('add','inventory');?></a>
		  		</div>
		  	<div id="all-cat-wrapper">
		  	<?php if(!empty($items)) {?>
		  	<table id="all-categories" class="table table-striped bulk_action">          
				<thead>
					<tr>
						<th class="col-lg-3"><?php echo __('Name','inventory') ?></th>
						<th class="col-lg-3"><?php echo __('Item type','inventory') ?></th>
						<th class="col-lg-3"><?php echo __('Category','inventory') ?></th>
						<th class="col-lg-1"><?php echo __('Min','inventory') ?></th>
						<th class="col-lg-4 text-right"><?php echo __('Message','inventory') ?></th>
					</tr>
				</thead>
          		<tbody>
          			<?php 
          			foreach($items as $item){ 

          				?>
          			<tr>
						<td>
							<a href="#" class="edit-item-name"><i class="fa fa-pencil" aria-hidden="true"></i> <?php echo $item['name'] ?></a>
							<div class="info-item hide">
								<input class="form-control input-name" type="text" value="<?php echo $item['name'] ?>">
								<input class="input-id" type="hidden" value="<?php echo $item['id'] ?>">
								<a href="" class="btn btn-success edit-item"><?php echo __('Update','inventory') ?></a>
								<a href="" class="btn btn-danger delete-item"><?php echo __('Delete','inventory') ?></a>
							</div>	
						</td>
						<td><?php echo $types_options[$item['item_type']] ?>
							<div class="info-item hide">
								<select class="form-control item_type" name="item_type">
										<?php echo $form->options($types_options, array('key' => $item['item_type'])) ?>
								</select>
							</div>
						</td>
						<td><?php echo $cats_options[$item['category']] ?>
							<div class="info-item hide">
								<select class="form-control category" name="category">
										<?php echo $form->options($cats_options, array('key' => $item['category'])) ?>
								</select>
							</div>
						</td>
						<td class="">
							<?php echo $item['inventory_min'] ?>
							<div class="info-item hide">
								<input class="form-control inventory_min" type="number" value="<?php echo $item['inventory_min'] ?>">
							</div>
						</td>
						<td class="text-right">
							&nbsp;<?php echo $item['inventory_min_message'] ?>
							<div class="info-item hide">
								<input class="form-control inventory_min_message" type="text" value="<?php echo $item['inventory_min_message'] ?>">
							</div>
						</td>
					</tr>
					<?php 
				}

					 ?>
          		</tbody>
          	</table>
			<?php } ?>
			</div>
		  	</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var loader = '<div class="loaderwrap absolute overlay"><div class="the-loader s2 load-center text-white"></div></div>';
	$('.edit-item-name').on('click', function(e){
		e.preventDefault();
		var p = $(this).closest('tr');
		p.find('.info-item').toggleClass('hide');
	});
	$('.add-item').on('click', function(e){
		e.preventDefault();
		$('.form-error').removeClass('form-error');
		var ee =  true;
		var a = $('#input-name');
		var b = a.val();
		var c = $('#inventory-cat-input option:selected').val();
		var d = $('#inventory-type-input option:selected').val();
		var f = $('#input-inventory_min').val();
		var g = $('#input-inventory_min_message').val();
		
		if(b.replace(/\s+/g, '') == '') {
		a.val('');
		a.addClass('form-error');
		ee = false;
		}
		if(ee){
			$('#all-cat-wrapper').append(loader);
			var fdata = {'data[name]' : b, 'data[category]' : c, 'data[item_type]' : d, 'data[inventory_min]': f, 'data[inventory_min_message]':g };
			$.getJSON( Jsapi+'inventory/add-item/', fdata , function( data ) {
			console.log(data);
				if(data.message == 'success'){
					location.reload();
				} else {
					$('body').find('.loaderwrap').remove();
				}
		    });
		}
	});

	$('.edit-item').on('click', function(e){
		e.preventDefault();
		$('.form-error').removeClass('form-error');
		var p = $(this).closest('tr');
		var ee =  true;
		var a = p.find('.input-name');
		var b = a.val();
		var c = p.find('.input-id').val();
		var f = p.find('.category option:selected').val();
		var d = p.find('.item_type option:selected').val();
		var g = p.find('.inventory_min').val();
		var h = p.find('.inventory_min_message').val();
		if(b.replace(/\s+/g, '') == '') {
		a.val('');
		a.addClass('form-error');
		ee = false;
		}
		if(ee){
			$('#all-cat-wrapper').append(loader);
			var fdata = {'data[name]' : b, 'data[id]' : c, 'data[category]' : f, 'data[item_type]' : d, 'data[inventory_min]': g, 'data[inventory_min_message]':h};
			$.getJSON( Jsapi+'inventory/edit-item/', fdata , function( data ) {
			console.log(data);
				if(data.message == 'success'){
					location.reload();
				} else {
					$('body').find('.loaderwrap').remove();
				}
		    });
		}
	});

	$('.delete-item').on('click', function(e){
		e.preventDefault();
		$('.form-error').removeClass('form-error');
		var p = $(this).closest('tr');
		var ee =  true;
		var c = p.find('.input-id').val();
		var a = p.find('.edit-cat-name').text();
		a = '<?php echo __('This will delete Item','inventory') ?> <b>' +  a +'</b>';
		$.confirm({
	    title: '<span class="text-danger"><?php echo __('Warning','inventory') ?> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>',
	    theme: 'modern',
	    content: a,
	    autoClose: 'cancel|30000',
	    buttons: {
	        confirm: {
	            text: 'Delete',
	            btnClass: 'btn-warning',
	            keys: ['enter'],
	            action: function(){
	            	$('#all-cat-wrapper').append(loader);
	            	$.getJSON( Jsapi+'inventory/delete-item/', {'data[id]': c} ,function( data ) {
	            		if(data.message == 'success'){
	            			location.reload();							
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

</script>