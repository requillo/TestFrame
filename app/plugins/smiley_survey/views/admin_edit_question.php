<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<div class="container-fluid"> 
	<div class="panel panel-default">
		<div class="panel-body">
		  	<div class="row">
		  		<?php $form->create('add-question'); ?>
		  		<div class="col-lg-7 col-md-8 col-sm-12 col-xs-12">
		  			<?php $form->input('question',array('type'=>'text','label'=>__('Question','smiley_survey'), 'value' => $question['question'])); ?>
		  		</div>
		  		<div class="col-lg-5 col-md-4 col-sm-12 col-xs-12">
		  			<label for="company_id_select"><?php echo __('Company','smiley_survey'); ?></label>
		  			<div><?php echo $question['company']['company']; ?></div>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<label><?php echo __('Terminal','smiley_survey'); ?></label>
		  			<ul class="terminalWrap ui-sortable sortable-flex">
		  				<?php foreach ($terminal_options as $key => $value) {
		  					if(in_array($key,$terminal_selected)) {
		  						$checked = 'checked';
		  					} else {
		  						$checked = '';
		  					}
		  				 ?>
		  					<li class="ui-state-default">
		  						<input class="flat" type="checkbox" name="data[terminal_id][]" id="terminal_<?php echo $key ?>" value="<?php echo $key ?>" <?php echo $checked;?>>
		  						<label for="terminal_<?php echo $key ?>"><?php echo $value; ?></label>
		  					</li>
		  				<?php } ?>
		  			</ul>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sidebar-check">
		  			<label for="company_id_select"><?php echo __('Answers','smiley_survey'); ?></label> <span class="text-message text-danger"></span>
		  			<ul id="sortable">
		  				<?php foreach ($question['answers'] as $value) { ?>
		  					<li class="ui-state-default">
		  						<div class="handle">
		  							<?php if(isset($value['icon'])) { ?>
		  							<img src="<?php echo get_media($value['icon']); ?>" class="small-ico"> 
		  							<?php } ?>
									<span class="desc-txt"><?php echo $value['description'] ?></span>
		  						</div>
		  						<input class="form-control hide" value="<?php echo $value['id'] ?>" name="data[answers][id][]">
		  						<input class="form-control the-answer" value="<?php echo $value['description'] ?>" name="data[answers][description][<?php echo $value['id'] ?>]">
		  						<?php if(isset($value['feedback'])) { ?>
		  						<h4 class="text-center"><?php echo __('Feedback','smiley_survey'); ?></h4>
		  							<?php foreach ($value['feedback'] as $val) { ?>
		  							<div class="feedback-holder">
		  							<div class="input-holder">
		  								<input class="form-control" value="<?php echo $val['feedback'] ?>" name="data[answers][feedback_<?php echo  $value['emoticons_id'] ?>][<?php echo  $val['id'] ?>]">
		  							</div>
		  							</div>
		  							<?php } ?>
		  						<?php } ?>
		  					</li>
		  				<?php } ?>
		  			</ul>
		  		</div>
		  		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		  			<button class="btn btn-success"><?php echo __('Save','smiley_survey'); ?></button>
		  		</div>
		  		<?php $form->close(); ?>
		  	</div>
		</div>
	</div>
</div>
<pre>
	<?php print_r($question) ?>
</pre>
<script type="text/javascript">
	$('body').find( "#sortable" ).sortable({handle: ".handle",});
	$('body').find( "#sortable" ).disableSelection();
	$('.the-answer').on('keyup', function(){
		var t = $(this).val();
		$(this).closest('li').find('.desc-txt').text(t);
	});
</script>
