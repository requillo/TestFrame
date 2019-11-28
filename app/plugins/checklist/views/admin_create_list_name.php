<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<?php $form->create(); ?>
		  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		  			<?php $form->input('name',array('type'=>'text','label'=>__('List name','checklist'))); ?>
		  		</div>
		  		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		  			<label for="list-cat"><?php echo __('Option category','checklist'); ?></label>
		  			<select id="list-cat" name="data[category]" class="form-control no-option">
		  				<?php echo $form->options($cat_options); ?>
		  			</select>
		  			<select id="list-cat-radio" name="data[category-radio]" class="form-control function-option hide">
		  				<?php echo $form->options($cat_options); ?>
		  			</select>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-option">
		  			<div>
		  				<label ><?php echo __('Remove options from checklist','checklist') ?></label>
		  			</div>
		  			<div>
		  				<small class="text-warning "><?php echo __('Select options that you do NOT want to show in the checklist!','checklist') ?></small>
		  			</div>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-options no-option">
		  			<?php foreach ($options as $key => $value) { ?>
		  				<span class="checklist-wells">
		  					<input class="flat" type="checkbox" name="data[no_options][]" id="inp-<?php echo $value['name'];?>" value="<?php echo $value['id'];?>"> 
		  					<label for="inp-<?php echo $value['name'];?>"><?php echo $value['name'];?> <small><?php echo $value['info'];?></small></label>
		  				</span>
		  			<?php } ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<h3><?php echo __('Or choose list function','checklist') ?></h3>
		  			<small class="text-info"><?php echo __('These options are optional, you can make a list function by clicking on <b>"Make a list function"</b>. Choose a function type and an option that should correspond with the function. Click add function','checklist') ?></small><br><br>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<input type="checkbox" name="data[function]" id="function" class="flat"> <label for="function"><?php echo __('Make a list function','checklist') ?></label>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 function-option hide">
		  			<div>
		  				<label class=""><?php echo __('Add option to functions','checklist') ?></label>
		  			</div>
		  			<div>
		  				<small class="text-info"><?php echo __('Select option that correspond with a function!','checklist') ?></small>
		  			</div>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-options-function function-option hide">
		  			<?php foreach ($options as $key => $value) { ?>
		  				<span class="checklist-wells">
		  					<input class="flat" type="radio" name="data[options]" id="inp-rad-<?php echo $value['name'];?>" value="<?php echo $value['id'];?>"> 
		  					<label for="inp-rad-<?php echo $value['name'];?>"><?php echo $value['name'];?> <small><?php echo $value['info'];?></small></label>
		  				</span>
		  			<?php } ?>
		  		</div>
		  		<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 function-option hide">
		  			<label><?php echo __('Function type','checklist');?></label>
		  			<div class="input-group">
					    <select class="form-control select-type">
					    	<?php echo $form->options($function_types);?>
					    </select>
					    <span class="input-group-addon">
					    	<a href="#" id="add-function"><i class="glyphicon glyphicon-plus"></i></a>
					    </span>
					</div>
		  		</div>
		  		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 function-option hide">
		  			<?php echo $form->input('name_functions', array('label'=>__('Functions', 'checklist'))); ?>
		  		</div>
		  		<div class="col-lg-5 col-md-4 col-sm-12 col-xs-12 function-option hide">
		  			<label><?php echo __('Selections', 'checklist'); ?></label>
		  			<div class="input-group">
		  				<span class="input-group-addon">
					    	<a href="#" id="add-selection"><i class="glyphicon glyphicon-plus"></i></a>
					    </span>
					    <input type="" name="data[function_selection]" id="input-function_selection" class="form-control">
					</div>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->textarea('custom_script',array('label'=>__('Custom script','checklist'),'attribute'=>'rows="12"'));?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><button class="btn btn-success"><?php echo __('Save','checklist'); ?></button></div>
		  		<?php $form->close();?>
		  		<script type="text/javascript">
		  			$('#function').on('ifChanged', function(event) {
					   $('body .no-option, body .function-option').toggleClass('hide');
					});
		  		</script>
		  	</div>
		</div>
	</div>
<?php if(!empty($list_names)){ ?>
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="results table-responsive">
					<table id="datatable-checklist" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th><?php echo __('Listname','checklist') ?></th>
								<th><?php echo __('Category','checklist') ?></th>
								<th><?php echo __('Options exceptions','checklist') ?></th>
								<th><?php echo __('Action','checklist') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($list_names as $list_name) { ?>
							<tr>
								<td>
									<div class="txt-data">
										<a href="<?php echo admin_url('checklist/edit-list-name/'. $list_name['id'].'/') ?>">
											<i class="fa fa-edit"></i> <?php echo $list_name['name'] ?></a>
									</div>
									<div class="id-data hide"><?php echo $list_name['id'] ?></div>
									<div class="input-group edit hide">
									<span class="input-group-addon"><a class="show-edit" href=""><i class="fa fa-arrow-up"></i></a></span>
									</div>
								</td>
								<td>
									<div class="txt-data"><?php echo $cat_options[$list_name['category']] ?></div>
								</td>
								<td>
									<div class="txt-data"><?php echo $list_name['no_options'] ?></div>
								</td>
								<td>
									<a href="#" class="remove-name btn btn-danger btn-block txt-data">
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
		$('#datatable-checklist').DataTable();
	}
	$('.show-edit').on('click', function(e){
		e.preventDefault();
		var p = $(this).closest('tr');
		p.find('.txt-data').toggleClass('hide');
		p.find('.edit').toggleClass('hide');
	});

	
	$('#add-function').on('click', function(e){
		e.preventDefault();
		name_functions = new AmsifySuggestags("#input-name_functions");
		name_functions._init();
		var a = $('body .data-options-function').find('.flat:checked');
		var b = a.val();
		var c = $('.select-type option:selected').val();
		var d = b+'='+c;
		
		if(b!= undefined) {
			a.removeAttr('checked');
			name_functions.addTag(d);
			add_icheck('.data-options-function .flat');
		}
	});

	$('#add-selection').on('click', function(e){
		e.preventDefault();
		function_selection = new AmsifySuggestags("#input-function_selection");
		function_selection._init();
		var a = $('body .data-options-function').find('.flat:checked');
		var b = a.val();
		
		if(b!= undefined) {
			a.removeAttr('checked');
			function_selection.addTag(b);
			add_icheck('.data-options-function .flat');
		}
	});
	$('#list-cat').on('change', function(){
		var b = $('#list-cat option:selected').val();
		// alert(b);
		var data = {
			'data[cat]': b
		}
		// console.log(data);
		$.getJSON( Jsapi+'checklist/get-list-options-array/', data ,function( data ) {
			console.log(data);
			$('.data-options').html(data.dt_c);
			add_icheck('.data-options .flat');
		});
	});

	$('#list-cat-radio').on('change', function(){
		var b = $('#list-cat-radio option:selected').val();
		// alert(b);
		var data = {
			'data[cat]': b
		}
		// console.log(data);
		$.getJSON( Jsapi+'checklist/get-list-options-array/', data ,function( data ) {
			console.log(data);
			$('.data-options-function').html(data.dt_r);
			add_icheck('.data-options-function .flat');
		});
	});

	$('body').on('click', 'a.edit-name', function(e){
		$('body').find('.results').append(loader);
		e.preventDefault();
		var p = $(this).closest('tr');
		var a = p.find('.cat-name').val(); 
		var b = p.find('.list-cat option:selected').val();
		var c = p.find('.cat-line').val();
		var f = p.find('.id-data').text();
		var data = {
			'data[name]': a,
			'data[line]': c,
			'data[category]': b
		};

		$.getJSON( Jsapi+'checklist/edit-name-json/'+f, data ,function( data ) {
			location.reload(true);
			console.log(data);
		});
	});

	$('.remove-name').on('click', function(e){
		var p = $(this).closest('tr');
		var a = p.find('.txt-data-s').text();
		var i = p.find('.id-data').text();
		var txt = "<?php echo __('Are you sure you want to delete list name','checklist'); ?> <strong>"+ a +"</strong>";
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
	            	$.getJSON( Jsapi+'checklist/delete-name-json/', {'data[id]': i} ,function( data ) {
	            	
	            	location.reload(true);
	            	console.log(data);
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
	

</script>