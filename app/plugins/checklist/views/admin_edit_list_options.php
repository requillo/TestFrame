<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body edit-list">
		  	<div class="row">
		  		<?php $form->create(); ?>
		  		<div class="col-lg-1 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->input('list_order',array('type'=>'number','label'=>__('Order','checklist'), 'attribute' => 'min="0"','value' => $options['list_order'])); ?>
		  		</div>
		  		<div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->input('name',array('type'=>'text','label'=>__('Option name','checklist'),'value' => 
		  			$options['name'])); ?>
		  		</div>
		  		<div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->input('info',array('type'=>'text','label'=>__('Option info','checklist'),'value' => 
		  			$options['info'])); ?>
		  		</div>
		  		<div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->input('graph_options',array('type'=>'text','label'=>__('Graph options','checklist').' <small class="text-info">'.__('Use 5=+5ml,-5=-5ml').'</small>','value' => $options['graph_options'])); ?>
		  		</div>		  		
		  	
		  		<div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->input('indu_cat',array('type'=>'text','label'=>__('Add group','checklist'),'value' => $options['indu_cat'])); ?>
		  		</div>
		  		<div class="col-lg-1 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->input('side_info',array('type'=>'text','label'=>__('Side info','checklist'),'value' => $options['side_info'])); ?>
		  		</div>
		  		<div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->select('type', array('label' => __('Option type','checklist'),'options' => $option_types,'selected' => $options['type'] ))?>
		  		</div>
		  		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6" id="type_options">
		  			<?php $form->input('type_options',array('type'=>'text','label'=>__('Select options','checklist').' <small class="text-info">'.__('Use 1=Yes,2=No or Yes,No').'</small>','value' => $options['type_options'])); ?>
		  		</div>
		  		<div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->select('link_type', array('label' => __('Link type','checklist'),'options' => $link_type,'selected'=>$options['link_type'] ))?>
		  		</div>
		  		<div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
		  			<?php $form->select('link_option', array('label' => __('Link to Option','checklist'),'options' => $link_option, 'selected' => $options['link_option']))?>
		  		</div>
		  		<div class="col-lg-2 col-md-4 col-sm-4 col-xs-6">
		  			<?php 
		  			if($options['is_required'] == 1) {
		  				$checked = 'checked';
		  			} else {
		  				$checked = '';
		  			}
		  			$form->input('is_required',array('type'=>'checkbox','label'=>__('Required','checklist'), 'class' =>'flat', 'attribute' => $checked)); ?>
		  		</div>
		  		<div class="col-lg-12"><button class="btn btn-success"><?php echo __('Save','checklist'); ?></button></div>
		  		<?php $form->close(); ?>
		  	</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#input-link_type').on('change', function(){
		var a = '<?php echo $options['category'];?>';
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
</script>