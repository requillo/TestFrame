<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<pre>
	<?php // print_r($list_options); ?>
</pre>

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
		  			<?php $form->select('link_type', array('label' => __('Link type','checklist'),'options' => $link_type ))?>
		  		</div>
		  		<div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->select('link_option', array('label' => __('Link to Option','checklist')))?>
		  		</div>
		  		<div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
		  			<div>&nbsp;</div>
		  			<?php $form->input('is_required',array('type'=>'checkbox','label'=>__('Required','checklist'), 'class' =>'flat')); ?>
		  		</div>
		  		<div class="col-lg-12"><button class="btn btn-success"><?php echo __('Save','checklist'); ?></button></div>
		  		<?php $form->close(); ?>
		  	</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row controls">
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
	<pre>
		<?php // print_r($list_options); ?>
	</pre>
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
		  			<div class="form-inline">
			  			<div class="form-group">
						    <label for="exampleInputName2"><?php echo __('Copy selected','checklist'); ?></label>
						    <div class="input-group">
						      <input type="number" class="form-control" min="1" id="timestocopy" value="1">
						      <div class="input-group-addon"><?php echo __('Times','checklist'); ?></div>
						    </div>
						</div>
						<a href="#" class="btn btn-success copy-selected"><?php echo __('Copy','checklist'); ?></a>
					</div>
		  		</div>
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
								<th><?php echo __('Linking','checklist') ?></th>
								<th><?php echo __('Required','checklist') ?></th>
								<th><?php echo __('Action','checklist') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($list_options as $list_option) { ?>
							<tr>
								<td>
									<input type="checkbox" class="flat option-id" value="<?php echo $list_option['id'] ?>" 
									id="opt-<?php echo $list_option['id'] ?>">
									<label for="opt-<?php echo $list_option['id'] ?>" class="txt-data"><?php
									if($list_option['list_order'] < 10) {
										echo '00'. $list_option['list_order'];
									} else if($list_option['list_order'] < 100) {
										echo '0'. $list_option['list_order'];
									} else {
										echo $list_option['list_order'];
									}
									 ?>
									 </label>
								</td>
								<td>
									<div class="txt-data-title">
										<?php 
										echo $html->admin_link('<i class="fa fa-edit"></i> '.$list_option['name'],'checklist/edit-list-options/'.$list_option['id'].'/'); ?>
										</div>
								</td>
								<td>
									<div class="txt-data"><?php echo $list_option['info'];?></div>
								</td>
								<td>
									<div class="txt-data"><?php echo $list_option['graph_options'];?></div>
								</td>
								<td>
									<div class="txt-data"><?php echo $list_option['indu_cat'];?></div>
								</td>
								<td>
									<div class="txt-data"><?php echo $list_option['side_info'];?></div>
								</td>
								<td>
									
									<div class="txt-data">
										<?php echo $option_types[$list_option['type']];?>
										<?php if($list_option['type'] == 4) { ?>
											<button type="button" class="btn btn-primary btn-xs pull-right" data-container="body" data-toggle="popover" data-placement="top" data-content="<?php echo $list_option['type_options'];?>">
											  <i class="fa fa-list-ul" aria-hidden="true"></i>
											</button>
										<?php } ?>
									</div>
								</td>
								<td>
									<div class="txt-data"><?php 
									echo '<strong>'.$link_type[$list_option['link_type']].'</strong> '; 
									if(isset($options_arr[$list_option['link_option']])) {
										echo $options_arr[$list_option['link_option']];
									}
									// echo $options_arr[$list_option['link_option']] $list_option['type_options'];?></div>
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
		$('#datatable-checklist').DataTable({"pageLength": 100});
	}
	$('.show-edit').on('click', function(e){
		e.preventDefault();
		var p = $(this).closest('tr');
		p.find('.txt-data').toggleClass('hide');
		p.find('.edit').toggleClass('hide');
	});

	$('.copy-selected').on('click', function(e){
		e.preventDefault();
		var a = [];
		$('.option-id:checked').each(function() {
	       a.push($(this).val());
	     });
		var b = $('#timestocopy').val();
		var d = '<?php echo $id;?>';
		if(b>0 && a != ''){
			// alert(a+' - '+b);
			var data = {
				'data[ids]': a,
				'data[times]': b,
				'data[cat]': d
			}

			$.getJSON( Jsapi+'checklist/copy-selected-options-json/', data ,function( data ) {
				console.log(data);
				location.reload(true);
				$('#input-link_option').html(data.option);
			});

		}
	});

	$('#input-link_type').on('change', function(){
		var a = '<?php echo $id;?>';
		var b = $('#input-link_type option:selected').val();
		// alert(a);
		var data = {
			'data[cat]': a,
			'data[link_type]': b
		}
		// console.log(data);
		$.getJSON( Jsapi+'checklist/get-list-options-html/', data ,function( data ) {
			console.log(data);
			$('#input-link_option').html(data.option);
		});
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
		var f = p.find('.option-id').val();
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

	$('body').on('click', '.remove-opt', function(e){
		var p = $(this).closest('tr');
		var a = p.find('.txt-data-title').text();
		var i = p.find('.option-id').val();
		var txt = "<?php echo __('Are you sure you want to delete option','checklist'); ?> <strong>"+ a +"</strong>";
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
