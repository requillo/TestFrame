<!DOCTYPE html>
<html lang="en">
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
  <body class="framed main-scrollable">
    <div class="wrapper">
      <nav class="navbar navbar-static-top header-navbar">
        <div class="header-navbar-mobile">
          <div class="header-navbar-mobile__menu">
            <button class="btn" type="button"><i class="fa fa-bars"></i></button>
          </div>
          <div class="header-navbar-mobile__title"><span><?php echo $appname; ?></span></div>
           <div class="header-navbar-mobile__settings dropdown"><a class="btn dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-power-off"></i></a>
            <ul class="dropdown-menu dropdown-menu-right">
              <li><a href="#">Log Out</a></li>
            </ul>
          </div>
        </div>
         <div class="navbar-header">
          <a class="navbar-brand" href="<?php echo admin_url();?>">
            <div class="logo text-nowrap">
               <?php if($applogo != ''): ?>
              <div class="logo__img">
                  <img src="<?php echo get_media($applogo);?>">
              </div>
              <?php else: ?>
                <span class="logo__text"><?php echo $appname; ?></span>
              <?php endif; ?>
            </div>
          </a>
        </div>
        <div class="topnavbar">
          <ul class="nav navbar-nav navbar-left">
            <?php if($applogo != ''): ?>
            <li class="active"><a href="<?php echo admin_url();?>"><span><?php echo $appname; ?></span></a></li>
            <?php else: ?>
            <li></li>
            <?php endif; ?>
          </ul>
          <ul class="userbar nav navbar-nav">
            <li class="active">
              <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span><?php echo __('Welcome,'); ?>
                <?php echo $this->user['fname'] . ' ' . $this->user['lname']; ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-right">
                <li><?php echo $html->admin_link('<i class="fa fa-user pull-right"></i>'.__('Profile'), 'profile');?></li>
              </ul>
            </li>
            <?php echo language_selector(array('style' => 'dropdown-in-list','icon'=>'<i class=" fa fa-angle-down"></i>')); ?>
            <li class="text-danger">
              <?php echo $html->admin_link('<i class="fa fa-power-off text-danger"></i>', 'logout', array('class' => 'userbar__settings'));?>
            </li>

          </ul>
        </div>
      </nav>
      <div class="dashboard">
        <div class="sidebar">
          <div class="quickmenu">
            
          </div>
          <div class="scrollable scrollbar-macosx">
            <div class="sidebar__cont" id="sidebar-menu">
              <div class="sidebar__menu menu_section">
                <?php admin_menu('nav side-menu'); ?>
              </div>
            </div>
          </div>
        </div>