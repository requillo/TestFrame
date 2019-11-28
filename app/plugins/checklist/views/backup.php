<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php if(isset($cat_options[$id])) { ?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<?php $form->create(); ?>
		  		<div class="col-lg-1 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->input('list_order',array('type'=>'number','label'=>__('Order','checklist'), 'attribute' => 'min="0"')); ?>
		  		</div>
		  		<div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->input('name',array('type'=>'text','label'=>__('Option name','checklist'))); ?>
		  		</div>
		  		<div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->input('info',array('type'=>'text','label'=>__('Option info','checklist'))); ?>
		  		</div>
		  		<div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->input('graph_options',array('type'=>'text','label'=>__('Graph options','checklist').' <small class="text-info">'.__('Use 5=+5ml,-5=-5ml').'</small>')); ?>
		  		</div>		  		
		  	
		  		<div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->input('indu_cat',array('type'=>'text','label'=>__('Add group','checklist'))); ?>
		  		</div>
		  		<div class="col-lg-1 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->input('side_info',array('type'=>'text','label'=>__('Side info','checklist'))); ?>
		  		</div>
		  		<div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->select('type', array('label' => __('Option type','checklist'),'options' => $option_types ))?>
		  		</div>
		  		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 hide" id="type_options">
		  			<?php $form->input('type_options',array('type'=>'text','label'=>__('Select options','checklist').' <small class="text-info">'.__('Use 1=Yes,2=No or Yes,No').'</small>')); ?>
		  		</div>
		  		<div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->input('is_required',array('type'=>'checkbox','label'=>__('Required','checklist'), 'class' =>'flat')); ?>
		  		</div>
		  		<div class="col-lg-12"><button class="btn btn-success"><?php echo __('Save','checklist'); ?></button></div>
		  		<?php $form->close(); ?>
		  	</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php echo __('Copy options from category','checklist'); ?> 
			  			<select class="cat-select checklist-sel">
			  				<?php echo $form->options($cat_options); ?>
			  			</select>
		  			<a href="#" class="btn btn-success copy-options"><?php echo __('Copy','checklist'); ?></a>
		  		</div>
		  	</div>
		</div>
	</div>
	<script type="text/javascript">
		$('.copy-options').on('click', function(e){
			// $('body').find('.results').append(loader);
			e.preventDefault();
			var a = $('.cat-select option:selected').val(); 
			var b = '<?php echo $id;?>';
			var data = {
				'data[copy-cat]': a,
				'data[cat]': b
			};
			alert(a);
			$.getJSON( Jsapi+'checklist/copy-options-json/', data ,function( data ) {
				location.reload(true);
				console.log(data);
			});
		});
	</script>
<?php if(!empty($list_options)){ ?>
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-12 table-responsive">
				<div class="results">
					<table id="datatable-checklist" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th><?php echo __('Order','checklist') ?></th>
								<th><?php echo __('Option name','checklist') ?></th>
								<th><?php echo __('Info','checklist') ?></th>
								<th><?php echo __('Graph options','checklist') ?></th>
								<th><?php echo __('Group','checklist') ?></th>
								<th><?php echo __('Side info','checklist') ?></th>
								<th><?php echo __('Option Type','checklist') ?></th>
								<th><?php echo __('Select options','checklist') ?></th>
								<th><?php echo __('Required','checklist') ?></th>
								<th><?php echo __('Action','checklist') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($list_options as $list_option) { ?>
							<tr>
								<td>
									<input type="text" class="cat-category hide" value="<?php echo $list_option['category']; ?>">
									<div class="txt-data"><?php
									if($list_option['list_order'] < 10) {
										echo '00'. $list_option['list_order'];
									} else if($list_option['list_order'] < 100) {
										echo '0'. $list_option['list_order'];
									} else {
										echo $list_option['list_order'];
									}
									 
									 ?></div>
									<div class="id-data hide"><?php echo $list_option['id'] ?></div>
									<input type="text" class="cat-list_order hide edit form-control form-block" value="<?php echo $list_option['list_order']; ?>">
								</td>
								<td>
									<div class="txt-data"><a class="show-edit" href=""><i class="fa fa-edit"></i> <?php echo $list_option['name'];?></a></div>
									<div class="input-group edit hide">
									<span class="input-group-addon"><a class="show-edit" href=""><i class="fa fa-arrow-up"></i></a></span>
									<input type="text" class="cat-name form-control form-block" value="<?php echo $list_option['name']; ?>">
									</div>
								</td>
								<td>
									<div class="txt-data"><?php echo $list_option['info'];?></div>
									<input type="text" class="cat-info hide edit form-control form-block" value="<?php echo $list_option['info']; ?>">
								</td>
								<td>
									<div class="txt-data"><?php echo $list_option['graph_options'];?></div>
									<input type="text" class="cat-graph_options hide edit form-control form-block" value="<?php echo $list_option['graph_options']; ?>">
								</td>
								<td>
									<div class="txt-data"><?php echo $list_option['indu_cat'];?></div>
									<input type="text" class="cat-indu_cat edit hide form-control form-block" value="<?php echo $list_option['indu_cat']; ?>">
								</td>
								<td>
									<div class="txt-data"><?php echo $list_option['side_info'];?></div>
									<input type="text" class="cat-side_info edit hide form-control form-block" value="<?php echo $list_option['side_info']; ?>">
								</td>
								<td>
									<div class="txt-data"><?php echo $option_types[$list_option['type']];?></div>
									<select class="cat-type edit hide form-control form-block">
										<?php echo $form->options($option_types, array('key' => $list_option['type'])) ?>
									</select>
								</td>
								<td>
									<div class="txt-data"><?php echo $list_option['type_options'];?></div>
									<input type="text" class="cat-type_options edit hide form-control form-block" value="<?php echo $list_option['type_options']; ?>">
								</td>
								<td><?php
								if($list_option['is_required'] == 1) { ?>
									<i class="text-success edit">&#10004;</i>
									<div class="edit hide">
									<input type="checkbox" class="cat-is_required flat" value="1" checked>
									</div>
							 	<?php } else { ?>
							 		<i class="text-danger edit">x</i>
							 		<div class="edit hide">
							 		<input type="checkbox" class="cat-is_required edit hide flat" value="1">
							 		</div>
							 	<?php } ?>
							 	
							 	</td>
								
								<td><a href="#" class="edit-opt edit hide btn btn-success btn-block">
										<?php echo __('Edit','checklist'); ?>
									</a>
									<a href="#" class="remove-opt btn btn-danger btn-block txt-data">
										<?php echo __('Remove','checklist'); ?>
									</a>
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
<?php } ?>
</div>
<script type="text/javascript">
	var loader = '<div class="loaderwrap absolute overlay"><div class="the-loader s2 load-center text-white"></div></div>';
	if($('#datatable-checklist').length) {
		// $('#datatable-checklist').DataTable({"pageLength": 50});
	}
	$('.show-edit').on('click', function(e){
		e.preventDefault();
		var p = $(this).closest('tr');
		p.find('.txt-data').toggleClass('hide');
		p.find('.edit').toggleClass('hide');
	});

	$('body').on('click', 'a.edit-opt', function(e){
		$('body').find('.results').append(loader);
		e.preventDefault();
		var p = $(this).closest('tr');
		var a = p.find('.cat-list_order').val(); 
		var b = p.find('.cat-name').val();
		var c = p.find('.cat-info').val();
		var d = p.find('.cat-type option:selected').val();
		var g = p.find('.cat-category').val();
		var h = p.find('.cat-indu_cat').val();
		var i = p.find('.cat-side_info').val();
		var j = p.find('.cat-is_required:checked').val();
		if(j == undefined) {
			j = 0;
		}
		var k = p.find('.cat-graph_options').val();
		var l = p.find('.cat-type_options').val();
		var f = p.find('.id-data').text();
		var data = {
			'data[list_order]': a,
			'data[name]': b,
			'data[info]': c,
			'data[type]': d,
			'data[category]': g,
			'data[indu_cat]': h,
			'data[side_info]': i,
			'data[is_required]': j,
			'data[graph_options]': k,
			'data[type_options]': l
		};
		// alert(j);
		$.getJSON( Jsapi+'checklist/edit-option-json/'+f, data ,function( data ) {
			location.reload(true);
			console.log(data);
		});
	});

	$('.remove-opt').on('click', function(e){
		var p = $(this).closest('tr');
		var a = p.find('.txt-data-s').text();
		var i = p.find('.id-data').text();
		var txt = "<?php echo __('Are you sure you want to delete category','checklist'); ?> <strong>"+ a +"</strong>";
		e.preventDefault();
		$('body').find('.results').append(loader);
		$.confirm({
	    title: '<span class="text-danger"><?php echo __('Warning','checklist'); ?> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>',
	    theme: 'modern',
	    content: txt,
	    autoClose: 'cancel|30000',
	    buttons: {
	        confirm: {
	            text: '<?php echo __('Remove','checklist'); ?>',
	            btnClass: 'btn-warning',
	            keys: ['enter'],
	            action: function(){
	            	$.getJSON( Jsapi+'checklist/delete-option-json/', {'data[id]': i} ,function( data ) {
	            	console.log(data);
	            	location.reload(true);
	            	});
	            }
	        },
	        cancel: {
	            text:  '<?php echo __('Cancel','checklist'); ?>',
	            btnClass: 'btn-success',
	            action: function(){
	                // $.alert('Not deleted');
	                $('body').find('.loaderwrap').remove();
	            }
	        }
	    }
		});
	});
	$('#input-type').on('change', function(){
		var a = $('#input-type option:selected').val();
		if(a == 4) {
			$('#type_options').removeClass('hide');
		} else {
			$('#type_options').addClass('hide');
		}
	})
</script>

<?php } else { ?>
<div class="panel panel-default">
	<div class="panel-body">
	  	<div class="row">
	  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	  			<?php foreach ($cat_options as $key => $value) {
	  				echo $html->admin_link($value,'checklist/create-list-options/'.$key,array('class'=>'btn btn-success'));
	  			} ?>
	  		</div>
	  	</div>
	</div>
</div>
<?php } ?>