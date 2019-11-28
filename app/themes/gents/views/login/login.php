<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $appname; ?></title>
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
    <!-- Bootstrap -->
    <link href="<?php echo $themepath; ?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo $themepath; ?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo $themepath; ?>/vendors/nprogress/nprogress.css" rel="stylesheet">
     <!-- iCheck -->
    <link href="<?php echo $themepath; ?>/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo $themepath; ?>/vendors/animate.css/animate.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo $themepath; ?>/css/custom.min.css?vers=1" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="forgot"></a>
      <a class="hiddenanchor" id="signin"></a>
     
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <?php $form->create('login');  ?>
              <h1><?php echo __('Please login','gents') ?></h1>
              <div><?php Message::show_flash(); ?></div>
              <div>
                <?php $form->input('user', array('placeholder'=>__('Your username','gents')));?>   
              </div>
              <div>
                <?php $form->input('pass', array('placeholder'=>__('Your password','gents'), 'type' => 'password'));?>  
              </div>
                <?php $form->input('keep',array('type' => 'checkbox', 'label' => __('Keep me logged in','gents'), 'value' => 1, 'no-wrap' => true,'class' => 'flat', 'label-pos' => 'after'));?>
                <?php $form->input('link', array('type'=>'hidden', 'class' => 'hide', 'value' => CURRENT_URL));?>
              <div class="clearfix"></div>

              <div class="separator">
                  <div>
                  <?php $form->submit(__('Log in'),'btn btn-default submit');?>
                  <!--<a class="reset_pass click" href="#forgot"><?php echo __('Lost your password?') ?></a>-->
                  </div>
                <div class="clearfix"></div>
                <br />
                <div>
                <?php if($applogo != ''): ?>
                  <img src="<?php echo get_media($applogo); ?>" style="max-width: 100%; height: auto;">
                <?php else: ?>
                   <h1><?php echo $appname; ?></h1>
                <?php endif; ?> 
                  <p>©<?php echo date('Y');?> <?php echo __('All Rights Reserved.','gents') ?></p>
                </div>
              </div>
           <?php $form->close();?>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <?php $form->create('forgot');  ?>
              <h1> <?php echo __('Forgot my password','gents')?></h1>
              <div>
                <?php $form->input('user_forgot', array('placeholder'=>__('Your username or e-mail address','gents')));?>
              </div>
              <div>
                 <?php $form->submit(__('Reset','gents'),'btn btn-default submit');?>
              </div>
              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">
                  <!--<a href="#signin" class="to_register click"> <?php echo __('Go back to login area');?></a>-->
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                 <h1><?php echo $appname; ?></h1>
                  <p>©<?php echo date('Y');?> <?php echo __('All Rights Reserved.','gents') ?></p>
                </div>
              </div>
             <?php $form->close();?>
          </section>
        </div>
      </div>
    </div>
     <script type="text/javascript" src="<?php echo $themepath; ?>/vendors/jquery/dist/jquery.min.js"></script>
     <script type="text/javascript" src="<?php echo $themepath; ?>/vendors/iCheck/icheck.min.js"></script>
     <script type="text/javascript">
       $('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
     </script>
  </body>
</html>
