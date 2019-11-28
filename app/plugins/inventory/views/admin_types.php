<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$lang = rtrim(LANG_ALIAS,'/');
?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-10">
		  			<?php $form->input('name',array('type'=>'text','label'=>__('Item type name','inventory'))); ?>
		  		</div>
		  		<div class="col-lg-2"><label>&nbsp;</label>
		  			<a href="#" class="btn btn-success btn-block add-cat"><?php echo __('Add','inventory');?></a>
		  		</div>
		  	<div id="all-cat-wrapper">
		  	<?php if(!empty($types)) {?>
		  	<table id="all-categories" class="table table-striped bulk_action">          
				<thead>
					<tr>
						<th style="width:35px"><input id="userselect" class="userselect check flat" type="checkbox" name="data[selectall]"></th>
						<th><?php echo __('Name','inventory') ?></th>
						<th><?php echo __('Added','inventory') ?></th>
					</tr>
				</thead>
          		<tbody>
          			<?php foreach($types as $type){ ?>
          			<tr>
						<td><input class="check flat" type="checkbox" name="data[user_id]" value="<?php echo $User['id']; ?>"></td>
						<td>
							<a href="#" class="edit-cat-name"><i class="fa fa-pencil" aria-hidden="true"></i> <?php echo $type['name'] ?></a>
							<div class="info-cat hide">
								<input class="form-control input-name" type="text" value="<?php echo $type['name'] ?>">
								<input class="input-id" type="hidden" value="<?php echo $type['id'] ?>">
							</div>	
						</td>
						<td>
							<?php echo $type['created'] ?>
							<div class="info-cat hide">
								<a href="" class="btn btn-success edit-cat"><?php echo __('Update','inventory') ?></a>
								<a href="" class="btn btn-danger delete-cat"><?php echo __('Delete','inventory') ?></a>
							</div>
						</td>
					</tr>
					<?php } ?>
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
	$('.edit-cat-name').on('click', function(e){
		e.preventDefault();
		var p = $(this).closest('tr');
		p.find('.info-cat').toggleClass('hide');
	});
	$('.add-cat').on('click', function(e){
		e.preventDefault();
		$('.form-error').removeClass('form-error');
		var ee =  true;
		var a = $('#input-name');
		var b = a.val();
		if(b.replace(/\s+/g, '') == '') {
		a.val('');
		a.addClass('form-error');
		ee = false;
		}
		if(ee){
			$('#all-cat-wrapper').append(loader);
			var fdata = {'data[name]' : b };
			$.getJSON( Jsapi+'inventory/add-item-types/', fdata , function( data ) {
			console.log(data);
				if(data.message == 'success'){
					location.reload();
				} else {
					$('body').find('.loaderwrap').remove();
				}
		    });
		}
	});

	$('.edit-cat').on('click', function(e){
		e.preventDefault();
		$('.form-error').removeClass('form-error');
		var p = $(this).closest('tr');
		var ee =  true;
		var a = p.find('.input-name');
		var b = a.val();
		var c = p.find('.input-id').val();
		if(b.replace(/\s+/g, '') == '') {
		a.val('');
		a.addClass('form-error');
		ee = false;
		}
		if(ee){
			$('#all-cat-wrapper').append(loader);
			var fdata = {'data[name]' : b, 'data[id]' : c};
			$.getJSON( Jsapi+'inventory/edit-item-types/', fdata , function( data ) {
			console.log(data);
				if(data.message == 'success'){
					location.reload();
				} else {
					$('body').find('.loaderwrap').remove();
				}
		    });
		}
	});

	$('.delete-cat').on('click', function(e){
		e.preventDefault();
		$('.form-error').removeClass('form-error');
		var p = $(this).closest('tr');
		var ee =  true;
		var c = p.find('.input-id').val();
		var a = p.find('.edit-cat-name').text();
		a = '<?php echo __('This will delete Category','inventory') ?> <b>' +  a +'</b>';
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
	            	$.getJSON( Jsapi+'inventory/delete-item-types/', {'data[id]': c} ,function( data ) {
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