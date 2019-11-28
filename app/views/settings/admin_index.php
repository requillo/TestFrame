<?php 
if(isset($_GET['tab'])) {
	$tab = $_GET['tab'];
} else {
	$tab = '';
}

if(isset($_GET['sub'])) {
	$sub = $_GET['sub'];
} else {
	$sub = '';
}

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
		<?php $form->create(array('id'=>'settingsform','class'=>'form-horizontal form-label-left','file-upload' => true)); ?>
		<div class="" role="tabpanel" data-example-id="togglable-tabs">
			<ul id="myTab" class="nav nav-tabs bar_tabs tabs" role="tablist">
				<li role="presentation" class="<?php if($tab == '' || $tab == 'tab_content1') echo 'active';?> nav-item"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true" class="nav-link">
				<?php echo __('Main settings');?></a>
				</li>
				<li role="presentation" class="<?php if($tab == 'tab_content2') echo 'active';?> nav-item"><a href="#tab_content2" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false" class="nav-link">
				<?php echo __('Languages');?></a>
				</li>
			</ul>
			<div id="myTabContent" class="tab-content">
				<div role="tabpanel" class="tab-pane fade <?php if($tab == '' || $tab == 'tab_content1') echo 'active in';?>" id="tab_content1" aria-labelledby="home-tab">
				<p><?php echo __('You can edit all the main settings here');?></p>
				<?php if( $file_verion > $app_version) { ?>
				<div class="form-group">
					<label for="role" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-12 text-left"><?php echo __('Version');?></label>
					<div class="col-lg-10 col-md-9 col-sm-9 col-xs-12 has-update-application">
						<?php echo __('Your current verion is')?> <?php echo $app_version;?>
						<button id="update_app" class="btn btn-warning"><?php echo __('please update to')?> <?php echo $file_verion;?></button>
					</div>
				</div>
				<?php } else { ?>
				<div class="form-group">
					<label for="role" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-12 text-left"><?php echo __('Version');?></label>
					<div class="col-lg-10 col-md-9 col-sm-9 col-xs-12"><input class="no-input-style" type="text" value="<?php echo $app_version;?>" disabled></div>
				</div>
				<?php } ?>
				<div class="form-group">
			        <label for="role" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-12 text-left"><?php echo __('Application name');?></label>
			        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			        <?php $form->input('app_name',array('no-wrap' => true, 'value' => $appname));?>
			        <?php $form->input('string_logo',array('no-wrap' => true, 'value' => $applogo,'class' => 'hide'));?>
			        <?php $form->input('app_logo',array('label' => '<i class="fa fa-upload" aria-hidden="true"></i> '. __('Upload Application Logo') . ' <small class="text-warning">(max 5mb)</small>', 'type' => 'file'))?>
			        <?php
			        if($applogo != '') {
			        	echo '<img src="'.get_media($applogo).'" style="max-width:100%; height:auto;">';
			        }
			        ?>
			        <?php $form->input('string_app_icon',array('no-wrap' => true, 'value' => $appicon,'class' => 'hide'));?>
			        <?php $form->input('app_icon',array('label' => '<i class="fa fa-upload" aria-hidden="true"></i> '. __('Upload Application Icon') . ' <small class="text-warning">(png 192x192 or 128x128)</small>', 'type' => 'file'))?>
			        <?php
			        if($appicon != '') {
			        	echo '<img src="'.get_media($appicon).'" style="max-width:100%; height:auto;">';
			        }
			        ?>
			        </div>
		      	</div>
		      	<div class="form-group">
			        <label for="role" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-12 text-left"><?php echo __('Timezone');?></label>
			        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			        <select id="timezone_string" class="form-control" name="data[timezone]" aria-describedby="timezone-description">
			        <?php echo $timezone_options; ?>
			        </select>
			        </div>
		      	</div>
		      	<div class="form-group">
			        <label for="role" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-12 text-left"><?php echo __('Language');?></label>
			        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			        <select class="form-control" name="data[lang]" id="lang">
			         <?php echo $lang_options; ?>
			        </select>
			        </div>
		      	</div>
		      	<div class="form-group">
			        <label for="role" class="control-label col-lg-2 col-md-3 col-sm-3 col-xs-12 text-left"><?php echo __('Multilanguage');?></label>
			        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			         <?php 
			         if($multilang == 1) {
			         	$checked = 'checked';
			         } else {
			         	$checked = '';
			         }
			         $form->input('multilang',array('type'=>'checkbox','class'=>'js-switch', 'no-wrap' => true,'attribute'=>$checked)); 
			         ?>
			        </div>
		      	</div>
				</div>
				<div role="tabpanel" class="tab-pane fade <?php if($tab == 'tab_content2') echo 'active in';?>" id="tab_content2" aria-labelledby="profile-tab">
				<p><?php echo __('Add or edit languages, you can also enable or disable languages for multilanguage');?></p>
				</div>
			</div>
		</div>
		<?php 
		if($tab != '') {
			$tab = '#'.$tab;
		}

		if($sub != '') {
			$sub = '#'.$sub;
		}
		echo $form->input('tabs',array('type'=>'hidden', 'value' => $tab));
		echo $form->input('side-tabs',array('type'=>'hidden', 'value' => $sub)); 
		?>
			<?php $form->close('Update','btn-success'); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	var loader = '<div class="loaderwrap inline"><div class="the-loader text-success"></div></div>';
	$('#update_app').on('click',function(e){
		e.preventDefault();
		if( $(this).hasClass('stop-update') ) {
		} else {
		$('.has-update-application').append(loader);
		$(this).addClass('stop-update');
		$.getJSON( Jsapi+'settings/update-appliction/', {'data[update]':true} , function( data ) {
			console.log(data);
			if(data.message == 'success') {
				location.reload();
			}
		});
		}
		
	});
</script>

