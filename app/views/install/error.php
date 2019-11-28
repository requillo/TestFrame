<?php
defined('IS_NOT_INSTALLED') OR exit('No direct script access allowed');
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Install the application</title>
	<link rel="stylesheet" type="text/css" href="<?php echo URL.'assets/app/css/install.css'; ?>">
	<script type="text/javascript" src="<?php echo URL.'assets/jquery/jquery.js'; ?>"></script>
</head>
<body>
<div class="mainWrapper">
	<header>
		<div class="contentWrapper">Header</div>
	</header>
	<article>
		<div class="contentWrapper">
			<div>Your application isn't installed, please install it.</div>
			<div>Install your application <a href="<?php echo URL ?>">HERE</a>.</div>
		</div>
	</article>
	<div class="push"></div>
</div>
<footer>
	<div class="contentWrapper">Footer</div>
</footer>
<script type="text/javascript">
	$('.no-enter input').on('keydown',function(e){
   var key = e.keyCode;
   if(e.keyCode == 13) {
      e.preventDefault();
      return false;
    }

})
</script>
</body>
</html>