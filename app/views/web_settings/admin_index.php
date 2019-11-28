
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<?php $form->create(array('id'=>'settingsform','class'=>'form-horizontal form-label-left','file-upload' => true)); ?>
				<div class="form-group">
			        <label for="role" class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12 text-left"><?php echo __('Website name');?></label>
			        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			         <?php echo $form->input('web_name',array('value'=>$websitename)); ?>
			        </div>
		      	</div>
		      	<div class="form-group">
			        <label for="role" class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12 text-left"><?php echo __('Website description');?></label>
			        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			         <?php echo $form->textarea('web_description',array('value'=>$websitedesc)); ?>
			        </div>
		      	</div>
		      	<div class="form-group">
		      		<div for="role" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-left"></div>
		      		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		      		<?php $form->input('string_web_logo',array('no-wrap' => true, 'value' => $weblogo,'class' => 'hide'));?>
			        <?php $form->input('web_logo',array('label' => '<i class="fa fa-upload" aria-hidden="true"></i> '. __('Upload Website Logo') . ' <small class="text-warning">(max 5mb)</small>', 'type' => 'file'))?>
			        <?php
			        if($weblogo != '') {
			        	echo '<img src="'.get_media($weblogo).'" style="max-width:100%; height:auto;">';
			        }
			        ?>
		      		</div>

		      	</div>
		      	<div class="form-group">
		      		<div for="role" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-left"></div>
		      		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		      		<?php $form->input('string_favicon',array('no-wrap' => true, 'value' => $favicon,'class' => 'hide'));?>
			        <?php $form->input('favicon',array('label' => '<i class="fa fa-upload" aria-hidden="true"></i> '. __('Upload Favicon') . ' <small class="text-warning">(png 192x192 or 128x128)</small>', 'type' => 'file'))?>
			        <?php
			        if($favicon != '') {
			        	echo '<img src="'.get_media($favicon).'" style="max-width:100%; height:auto;">';
			        }
			        ?>	
		      		</div>
		      	</div>
		      	<div class="form-group">
			        <label for="role" class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12 text-left"><?php echo __('Home page');?></label>
			        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			        <?php if(!empty($pages)) { ?>
			        <select class="form-control" name="data[home]" id="lang">
			         <?php echo $form->options($pages,array('key'=>$homepage)); ?>
			        </select>
			        <?php } else { ?>
			        <?php echo __('No pages found to add as homepage, please make some pages');?>
			         <?php } ?>
			        </div>
		      	</div>
		      	<div class="form-group">
			        <label for="role" class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12 text-left"><?php echo __('Home page to blog');?></label>
			        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			         <?php 
			         if($homeblog == 1) {
			         	$checked = 'checked';
			         } else {
			         	$checked = '';
			         }
			         $form->input('home-blog',array('type'=>'checkbox','class'=>'js-switch', 'no-wrap' => true,'attribute'=>$checked)); 
			         ?>
			        </div>
		      	</div>		      	
		<?php $form->close('Update','btn-success'); ?>      	
</div>
</div>
</div>
