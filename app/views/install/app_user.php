<?php
defined('DB_ADMIN_USER_NOT_FOUND') OR exit('No direct script access allowed');
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
		<div class="contentWrapper adding-user">
			<form method="post" class="no-enter userform">
				<div class="inputGroup">
					<label for="appuser">Username</label>
					<input type="text" name="appuser" id="appuser" placeholder="">
				</div>
				<div class="inputGroup">
					<label for="appuserpass">Password</label>
					<input type="text" name="appuserpass" id="appuserpass" placeholder="">
				</div>
				<div class="inputGroup">
					<button>Add user</button>
				</div>
			</form>
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
});
</script>
</body>
</html>