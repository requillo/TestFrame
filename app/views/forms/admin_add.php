<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<?php $form->create(array('id' => 'edit-form'));?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<?php $form->input('name', array('label' => __('Form name'))) ?>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label><?php echo __('Form inputs');?></label>
					<?php foreach ($langs as $key => $value) {
						echo '<div class="build-wrap-'.$key.'"></div>';
						echo '<textarea name="data[form]['.$key.']" class="get_json_'.$key.' hide">'.'</textarea>';
					} ?>
					
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<button class="btn btn-success" id="build-field" type="button">Rebuild</button>
					<button class="btn btn-danger" id="remove-field" type="button">Remove all</button>
				</div>
				<?php $form->close();?>

			</div>
		</div>
	</div>
</div>
<pre>
	<?php print_r($langs); ?>
</pre>
<script type="text/javascript">
   jQuery(function($) {
<?php foreach ($langs as $key => $value) { ?>
    var options_<?php echo $key;?> = {
    	i18n: { locale: '<?php echo str_replace('_', '-', $deflang);?>' },
    	disabledActionButtons: ['data','clear','save'],
    	disabledAttrs: ["access","other","toggle"],
    	 typeUserAttrs: {
	      textarea : {
	        subtype: {
	            label: 'Type',
	            options: {
	              'textarea': '<?php echo __('Normal'); ?>',
	              'full-editor': '<?php echo __('Full Editor'); ?>',
	              'minimal-editor': '<?php echo __('Minimal Editor'); ?>'
	            }
	          }
	      },
	      text: {
	        subtype: {
	            label: 'Type',
	            options: {
	              'text': '<?php echo __('Normal text'); ?>',
	              'color': '<?php echo __('Color'); ?>',
	              'password': '<?php echo __('Password'); ?>',
	              'email': '<?php echo __('E-mail'); ?>'
	            }
	          }
	      }
	     },
	     typeUserDisabledAttrs: {
	      'textarea': [
	        'value',
	        'inline',
	        'toggle'
	      ],
	      'file': [
	        'subtype',
	        'toggle'
	      ],
	      'button': [
	      	'subtype',
	      	'name',
	      	'value'
	      ]
	    }
    }
<?php } ?>
<?php foreach ($langs as $key => $value) { ?>
	 var  formBuilder_<?php echo $key;?> = $('.build-wrap-<?php echo $key;?>').formBuilder(options_<?php echo $key;?>);
<?php } ?>

<?php foreach ($langs as $key => $value) { ?>
<?php } ?>
   

    $('#build-field').on('click', function(){

<?php foreach ($langs as $key => $value) { ?>
	$('.get_json_<?php echo $key;?>').val(formBuilder_<?php echo $key;?>.actions.getData('json', true));
<?php } ?>
	$('#edit-form').submit();     
    });
    $('#remove-field').on('click', function(){
    	<?php foreach ($langs as $key => $value) { ?>
    		$('.get_json_<?php echo $key;?>').val('');
	formBuilder_<?php echo $key;?>.actions.clearFields();
	<?php } ?>
    });
     document.addEventListener('fieldAdded', function(){
     // alert(123);
    });
  });
  </script>