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
    <title><?php echo $appname; ?> <?php if($title != '') echo '| ' . $title; ?></title>
    <!-- All other scripts like plugins -->
    <?php
    // $html->css($themepath.'/css/custom.css'); 
    $this->admin_header_scripts(array('jQuery' => false));
    ?>
</head>
<body>
	<header id="main-header" class="container-fluid pos-rel">
		<div class="app-logo pull-left">
			<div id="logo-wrap">
				<a href="<?php echo admin_url();?>" class="app-logo-a"><img src="<?php echo get_media($applogo);?>"></a>
			</div>
		</div>
		<div class="App-logo pull-right">
			<div class="header-right-menu">
				<ul class="left-nav list-menu">
					<li class="dropdown">
						<a class="dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    <?php echo $this->user['fname'] . ' ' . $this->user['lname']; ?>
						<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-menu-right animated flipInX" aria-labelledby="dropdownMenu2">
							<li><?php echo $html->admin_link('<i class="fa fa-user-o pull-right"></i>'.__('Profile','sol'), 'profile');?></i></a></li>
							<li><?php echo $html->admin_link('<i class="fa fa-power-off pull-right"></i>'.__('Log Out','sol'), 'logout');?></li>
						</ul>
					</li>
					<?php echo language_selector(array('style' => 'dropdown-in-list','icon'=>'<i class=" fa fa-angle-down"></i>', 'class' => 'dropdown-menu-right animated flipInX')); ?>
				</ul>
			</div>
		</div>
		<div class="mobile-menu animated flipInY">
			<div id="show-menu-mobile">
			  <span></span>
			  <span></span>
			  <span></span>
			  <span></span>
			  <span></span>
			  <span></span>
			</div>
		</div>
	</header>