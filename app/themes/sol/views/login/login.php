<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// $this->admin_part('header');
?>
<!DOCTYPE html>
<html>
<head>
	<base href="<?php echo URL; ?>">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="SHORTCUT ICON" href="<?php echo get_media($appicon);?>"/>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="icon" type="image/png" href="<?php echo get_media($appicon);?>">
    <link href="<?php echo get_media($appicon);?>" rel="apple-touch-icon" />
    <link href="<?php echo get_media($appicon);?>" rel="apple-touch-icon" sizes="152x152" />
    <link href="<?php echo get_media($appicon);?>" rel="apple-touch-icon" sizes="167x167" />
    <link href="<?php echo get_media($appicon);?>" rel="apple-touch-icon" sizes="180x180" />
    <link href="<?php echo get_media($appicon);?>" rel="icon" sizes="192x192" />
    <link href="<?php echo get_media($appicon);?>" rel="icon" sizes="128x128" />
    <meta name="apple-mobile-web-app-title" content="<?php echo $appname; ?>">
    <meta name="application-name" content="<?php echo $appname; ?>">
    <title><?php echo $appname; ?> | <?php echo __('Please login','sol'); ?></title>
    <link href="<?php echo URL; ?>assets/app/css/main.css?vers=1" rel="stylesheet">
    <link href="<?php echo URL; ?>assets/iCheck/skins/flat/blue.css" rel="stylesheet">
    <link href="<?php echo $themepath; ?>/vendors/animate/animate.css" rel="stylesheet">
	<link href="<?php echo $themepath; ?>/assets/css/login.css" rel="stylesheet">
	<script src="<?php echo URL; ?>assets/jquery/jquery.js"></script>
	<script src="<?php echo URL; ?>assets/iCheck/icheck.min.js"></script>
    <!-- All other scripts like plugins -->
</head>
<body>
<div id="container">
<?php $form->create(array('attribute' => 'autocomplete="off"','id'=>'login')); ?>
<?php Message::show_flash(); ?>
<div id="logincont">
<input name="data[user]" id="idname" class="clname" type="text" placeholder="<?php echo __('Your username'); ?>" autocomplete="off">
<input name="data[pass]" id="idpass" class="clpass" type="password" placeholder="<?php echo __('Your password'); ?>" autocomplete="off">

<?php $form->input('link', array('type'=>'hidden', 'value' => CURRENT_URL)); ?>
<input type="submit" id="send" name="send" value="Login">

</div>
<div class="keepme-in"><?php $form->input('keep',array('type' => 'checkbox', 'label' => __('Keep me logged in'), 'value' => 1,'class' => 'flat')); ?></div>
<?php $form->close(); ?>
<div class="disclamer">All products and company names are trademarks™ or registered® trademarks of their respective holders</div>
</div>
<script type="text/javascript">
	$('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
	$('body').on('click', '.alertmsg', function(){
		$(this).remove();

	});
</script>

</body>

</html>