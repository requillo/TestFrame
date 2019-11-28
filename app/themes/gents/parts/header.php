<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en" moznomarginboxes mozdisallowselectionprint>
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
    $this->admin_header_scripts(array('jQuery' => false));
    ?>
  </head>
    <body class="nav-md">
      <noscript>
        <div class="no-javascript"><div class="javascript-msg"><?php echo __('Javascript needs to be enabled','gents'); ?></div></div>
      </noscript>
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed no-print">
          <div class="left_col scroll-view">
          <?php if($applogo != ''): ?>
            <div class="app-logo">
              <a href="<?php echo admin_url();?>" class="app-logo-a"><img src="<?php echo get_media($applogo);?>"></a>
            </div>
           <?php endif; ?>
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo admin_url();?>" class="site_title"><span><?php echo $appname; ?></span></a>
            </div>
            <div class="clearfix"></div>
            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div>
                <span><?php echo __('Welcome,','gents'); ?></span><br>
                <span><?php echo $this->user['fname'] . ' ' . $this->user['lname']; ?></span>
              </div>
            </div>
            <!-- /menu profile quick info -->
            <br />
            <!-- End remove -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
              <?php admin_menu('nav side-menu'); ?>
              </div>
            </div>
            
          </div>
        </div>
        <!-- top navigation -->
        <div class="top_nav no-print">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle no-print">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <span class="app-sm-title"><?php echo $appname; ?></span>
              <div class="navbar-right lang-selector no-print">
                
              </div>
              <ul class="nav navbar-nav navbar-right no-print">

                <?php echo language_selector(array('style' => 'dropdown-in-list','icon'=>'<i class=" fa fa-angle-down"></i>')); ?>
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?php echo $this->user['fname'] ; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><?php echo $html->admin_link(__('Profile','gents'), 'profile');?></li>
                    <li><?php echo $html->admin_link('<i class="fa fa-sign-out pull-right"></i>'.__('Log Out','gents'), 'logout');?></li>
                  </ul>
                </li>
                <?php get_admin_widgets('header-menu'); ?>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->