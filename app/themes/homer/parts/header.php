<!DOCTYPE html>
<html>
<head>
 <base href="<?php echo url(); ?>">
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
<body class="light-skin fixed-navbar sidebar-scroll">

<!-- Header -->
<div id="header">
    <div class="color-line">
    </div>
    <div id="logo" class="light-version">
        <span>
            <?php echo $appname; ?>
        </span>
    </div>
    <nav role="navigation">
        <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
        <div class="small-logo">
            <span class="text-primary"><?php echo $appname; ?></span>
        </div>
        <div class="navbar-form-custom">
            <div class="form-group">
                <div class="form-control" >
                    <?php echo __('Welcome,','gents'); ?> <?php echo $this->user['fname'] . ' ' . $this->user['lname']; ?>
                </div>
            </div>
        </div>
        <div class="mobile-menu">
            <button type="button" class="navbar-toggle mobile-menu-toggle" data-toggle="collapse" data-target="#mobile-collapse">
                <i class="fa fa-chevron-down"></i>
            </button>
            <div class="collapse mobile-navbar" id="mobile-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a class="" href="login.html">Login</a>
                    </li>
                    <li>
                        <a class="" href="login.html">Logout</a>
                    </li>
                    <li>
                        <a class="" href="profile.html">Profile</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders">
                <?php get_admin_widgets('header-menu'); ?>
                <?php echo language_selector(array('style' => 'dropdown-in-list','icon'=>'<i class=" fa fa-angle-down"></i>', 'class' => 'dropdown-menu-right animated flipInX')); ?>
                <li>
                     <?php echo $html->admin_link('<i class="pe-7s-note"></i>', 'profile');?>
                </li>
                <li class="dropdown">
                    <?php echo $html->admin_link('<i class="pe-7s-upload pe-rotate-90"></i>', 'logout');?>
                </li>
            </ul>
        </div>
    </nav>
</div>