<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="HandheldFriendly" content="true" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<base href="<?php echo URL; ?>" />
<link rel="icon" type="image/png" href="<?php favicon(); ?>">
	<title>Welkom bij Hoigri</title>
  <link rel="stylesheet" type="text/css" href="<?php echo $theme_url ?>/assets/css/template.css?v=6">
</head>
<body>
<header>
<div class="max-width">
	<div class="logo"><?php web_logo(); ?></div>
	<div class="ads-pos01"><img src="<?php echo $theme_url ?>/assets/img/leaderboard-min-1.jpg"></div>
	<div class="ads-pos02"><img src="<?php echo $theme_url ?>/assets/img/468-60-banner-min-1.jpg"></div>
	<div class="ads-pos03"><img src="<?php echo $theme_url ?>/assets/img/320-50-Mobile-leaderboard-min-1.jpg"></div>
</div>

<nav role="navigation" class="navigation">
	<div class="max-width">
  <div class="mobilemenu">
    <a href="#" class="menu-btn"><span></span></a>
  </div>
  <div class="menuWrap">
  	<?php site_navigation('Main menu'); ?>
	
  </div>
</div>
</nav>
</header>