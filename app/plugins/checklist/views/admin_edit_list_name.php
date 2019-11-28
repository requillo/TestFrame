<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if($list_name['name_functions'] != '') { 
	$checked = 'checked'; 
	$no_options_class = 'hide';
	$function_options_class = '';
} else { 
	$checked = '';
	$no_options_class = '';
	$function_options_class = 'hide';
} 
?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<?php $form->create(); ?>
		  		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		  			<?php $form->input('name',array('type'=>'text','label'=>__('List name','checklist'), 'value' => $list_name['name'])); ?>
		  		</div>
		  		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		  			<label for="list-cat"><?php echo __('Option category','checklist'); ?></label>
		  			<select id="list-cat" name="data[category]" class="form-control no-option <?php echo $no_options_class; ?>">
		  				<?php echo $form->options($cat_options,array('key'=>$list_name['category'])); ?>
		  			</select>
		  			<select id="list-cat-radio" name="data[category-radio]" class="form-control function-option 
		  			<?php echo $function_options_class;?>">
		  				<?php echo $form->options($cat_options,array('key'=>$list_name['category'])); ?>
		  			</select>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-option <?php echo $no_options_class; ?>">
		  			<div>
		  				<label><?php echo __('Remove options from checklist','checklist') ?></label>
		  			</div>
		  			<div>
		  				<small class="text-warning"><?php echo __('Select options that you do NOT want to show in the checklist!','checklist') ?></small>
		  			</div>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-option <?php echo $no_options_class; ?> data-options">
		  			<?php foreach ($options as $key => $value) { 
		  				if(in_array($value['id'], $list_name['no_options'])) {
		  					$checked = ' checked';
		  				} else {
		  					$checked = '';
		  				}
		  				?>
		  				<span class="checklist-wells">
		  					<input class="flat" type="checkbox" name="data[no_options][]" id="inp-<?php echo $value['name'];?>" value="<?php echo $value['id'];?>" <?php echo $checked;?>> 
		  					<label for="inp-<?php echo $value['name'];?>">
		  						<?php echo $value['name'];?> <small><?php echo $value['info'];?></small>
		  					</label>
		  				</span>
		  			<?php } ?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<h3><?php echo __('Or choose list function','checklist') ?></h3>
		  			<small class="text-info"><?php echo __('These options are optional, you can make a list function by clicking on <b>"Make a list function"</b>. Choose a function type and an option that should correspond with the function. Click add function','checklist') ?></small><br><br>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php if($list_name['name_functions'] != '') { $checked = 'checked'; } else { $checked = 'checked';} ?>
		  			<input type="checkbox" name="data[function]" id="function" class="flat" <?php echo $checked; ?>> <label for="function"><?php echo __('Make a list function','checklist') ?></label>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 function-option <?php echo $function_options_class;?>">
		  			<div>
		  				<label class=""><?php echo __('Add option to functions','checklist') ?></label>
		  			</div>
		  			<div>
		  				<small class="text-info"><?php echo __('Select option that correspond with a function!','checklist') ?></small>
		  			</div>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 data-options-function function-option <?php echo $function_options_class;?>">
		  			<?php foreach ($options as $key => $value) { ?>
		  				<span class="checklist-wells">
		  					<input class="flat" type="radio" name="data[options]" id="inp-rad-<?php echo $value['name'];?>" value="<?php echo $value['id'];?>"> 
		  					<label for="inp-rad-<?php echo $value['name'];?>"><?php echo $value['name'];?> <small><?php echo $value['info'];?></small></label>
		  				</span>
		  			<?php } ?>
		  		</div>
		  		<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 function-option <?php echo $function_options_class;?>">
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
		  		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 function-option <?php echo $function_options_class;?>">
		  			<?php echo $form->input('name_functions', array('label'=>__('Functions', 'checklist'),'value' => $list_name['name_functions'])); ?>
		  		</div>
		  		<div class="col-lg-5 col-md-4 col-sm-12 col-xs-12 function-option <?php echo $function_options_class;?>">
		  			<label><?php echo __('Selections', 'checklist'); ?></label>
		  			<div class="input-group">
		  				<span class="input-group-addon">
					    	<a href="#" id="add-selection"><i class="glyphicon glyphicon-plus"></i></a>
					    </span>
					    <input type="" name="data[function_selection]" id="input-function_selection" class="form-control" value="<?php echo $list_name['function_selection']; ?>">
					</div>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<?php $form->textarea('custom_script',array('label'=>__('Custom script','checklist'),'attribute'=>'rows="12"', 'value' => $list_name['custom_script']));?>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<button class="btn btn-success"><?php echo __('Save','checklist'); ?></button>
		  		</div>
		  		<?php $form->close(); ?>
		  	</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$('#function').on('ifChanged', function(event) {
	$('body .no-option, body .function-option').toggleClass('hide');
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
</script>