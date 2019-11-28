<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

if($has_options) {
	$btn_options = '<a href="#" id="theme-options" class="pull-right text-white"><i class="fa fa-cogs"></i> <span>'.__('Options').'</span></a>';
} else {
	$btn_options = '';
}
?>
<div class="container-fluid appearance-page">
  <div class="flex-box">
<?php foreach ($files as $key => $value) { 

	if(isset($value['theme']['build_uri'])){
		$sa = '<a href="'.$value['theme']['build_uri'].'" target="_blank">';
		$ea = '</a>';
	} else {
		$sa = '';
		$ea = '';
	}

?>
  	<div class="flexwrap fl-col-3 <?php echo $value['theme']['class'] ?> theme-blocks">
  		<div class="flex-heading">
  			<?php if(isset($value['theme']['name'])) { ?>
  			<h3><?php echo __($value['theme']['name'],$value['dir']);?></h3>
  			<?php } else { ?>
  			<h3><?php echo ucwords(str_replace(array('-','_'), ' ', $value['dir']));?></h3>
  			<?php } ?>
  		</div>
		<div class="flex-body">
			<div class="row">
			<div class="theme-preview col-lg-5 col-md-5 col-sm-5 col-xs-5"><img src="<?php echo $value['theme']['image'];?>"></div>
			<?php if(isset($value['theme']['description'])) { ?>
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7"><?php echo __($value['theme']['description'],$value['dir']);?></div>
			<?php } ?>
			<?php if(isset($value['theme']['build'])) { ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><?php echo __('Build') ?>: <?php echo $sa. $value['theme']['build'] . $ea; ?></div>
			<?php } ?>
			<?php if(isset($value['theme']['created'])) { ?>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><?php echo __('Created') ?>: <?php echo $value['theme']['created']; ?></div>
			<?php } ?>
			<?php if(isset($value['theme']['updated'])) { ?>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><?php echo __('Updated') ?>: <?php echo $value['theme']['updated']; ?></div>
			<?php } ?>
			</div>
		</div>
		<?php if($value['theme']['class'] != 'active') { ?>
		<div class="flex-footer text-right activate-theme">
			<?php echo __('Activate')?> <input type="checkbox" class="cl-plugin js-switch" value="<?php echo $value['dir'] ?>">
		</div>
		<?php } else { ?>
		<div class="flex-footer this-theme-active bg-primary">
			<?php echo __('Active theme') . ' ' . $btn_options;?>
		</div>
		<?php if(isset($theme_options)) { ?>
		<div class="theme-options">
			<input value="default" type="radio" name="style-css" class="flat choose-style" id="style-default" <?php echo $default ;?>> 
			<label for="style-default" class="btn default-theme-style"><?php echo __('Default') ?></label> 
			<?php foreach ($theme_options as $key => $value) { 
				if($value['file'] === $ts) {
					$checked = 'checked';
				} else {
					$checked = '';
				}
				?>
				<input value="<?php echo $value['file'] ?>" data-css="<?php echo $theme_assets_uri.'css/'.$value['file'].'.css' ?>" type="radio" name="style-css" class="flat choose-style" id="style-<?php echo $value['file'] ?>" <?php echo $checked ;?>> 
				<label class="btn <?php echo $value['btn-class'] ?>" for="style-<?php echo $value['file'] ?>"><?php echo $key ?></label> 
			<?php } ?>
			<div class="update-btn-area">
				<a href="#" class="btn btn-success btn-sm update-style pull-right"><?php echo __('Update') ?></a>
			</div>
		</div>
		<?php } ?>
		<?php } ?>
  	</div>
  <?php } ?>
  </div>
</div>

<script type="text/javascript">
	
	if(!document.getElementById('add-css')) {
	    var link = document.createElement('link');
	    link.id = 'add-css';
	    link.rel = 'stylesheet';
	    link.href = '#';
	    document.head.appendChild(link);
	}
	$('.theme-preview img').on('click', function(){
		$('body').find('.pop-theme-img').remove();
		var a = $(this).attr('src');
		var b = '<div class="pop-theme-overlay"></div><div class="pop-theme-img"><img src="'+a+'"><span class="pop-close">X</span><div>';
		$('body').append(b);
	})
	$('body').on('click','.pop-close, .pop-theme-overlay',function(){
		$('body').find('.pop-theme-img, .pop-theme-overlay').remove();
	});
	$('.activate-theme').on('click','span.switchery',function(){
		var i = $(this).parent().find('input').val();
		if($(this).hasClass('wait')) {
			
			// Do Nothing
		} else {
			$('span.switchery').addClass('wait');
			
			fdata = { 'data[theme]' : i};
			$.getJSON( Jsapi+'appearance/activate-theme/',fdata, function( data ) {
				console.log(data);
	            		if(data.ok == 'success'){
	            			location.reload();
	            		}	
	        });
		}
		// alert(i);
	});
	$('.choose-style').on('ifChanged',function(e){
		e.preventDefault();
		if($(this).val() != 'default') {
			$('html').find('#add-css').attr('href',$(this).attr('data-css')+'?vers'+e.timeStamp);
		} else {
			$('html').find('#add-css').attr('href','#');
		}
		
	});
	$('#theme-options').on('click', function(e){
		e.preventDefault();
		$('.theme-options').toggleClass('show');
	});
	$('.update-btn-area .btn').on('click', function(e){
		e.preventDefault();
		var a = $('.theme-options input:checked').val();
		if(a == 'default') {
			a = '';
		}
		fdata = { 'data[style]' : a};
		$.getJSON( Jsapi+'appearance/activate-theme-style/',fdata, function( data ) {
			console.log(data);
            		if(data.ok == 'success'){
            			location.reload();
            		}	
        });
	});
</script>