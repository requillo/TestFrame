<?php
defined('IS_NOT_INSTALLED') OR exit('No direct script access allowed');
 ?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $ai['install-title'];?></title>
	<link rel="icon" type="image/png" href="<?php echo URL.'assets/images/eowyn-icon.png';?>">
	<link rel="stylesheet" type="text/css" href="<?php echo URL.'assets/app/css/install.css'; ?>">
	<script type="text/javascript" src="<?php echo URL.'assets/jquery/jquery.js'; ?>"></script>
</head>
<body>
<div class="mainWrapper">
	<header>
		<div class="contentWrapper"><?php echo $ai['install-header']; ?></div>		
	</header>
	<article>
		<div class="contentWrapper install-form">
			<form method="post" class="no-enter dbform">
				<div class="first">
					<div class="install-content"><?php echo $ai['install-content']; ?></div>
					<div class="inputGroup">
						<h2><?php echo $ai['add-db'];?></h2>
					</div>
					<div class="inputGroup">
						<label for="dbhost"><?php echo $ai['host'];?></label>
						<input type="text" name="dbhost" id="dbhost" placeholder="localhost">
					</div>
					<div class="inputGroup">
						<label for="dbtable"><?php echo $ai['table'];?></label>
						<input type="text" name="dbtable" id="dbtable" placeholder="test_table">
					</div>
					<div class="inputGroup">
						<label for="dbuser"><?php echo $ai['user'];?></label>
						<input type="text" name="dbuser" id="dbuser" placeholder="user_name45">
					</div>
					<div class="inputGroup">
						<label for="dbpass"><?php echo $ai['pass'];?></label>
						<input type="text" name="dbpass" id="dbpass" placeholder="P@$$WO12D">
					</div>
					<div class="inputGroup">
						<label for="dbhost"><?php echo $ai['db-type'];?></label>
						<select name="dbtype" id="dbtype">
							<option value="mysql">MySql</option>
							<option value="db2">DB2</option>
							<option value="postgre">Postgre</option>
						</select>
					</div>
					<div class="inputGroup">
						<label for="dbpre"><?php echo $ai['pre'];?></label>
						<input type="text" name="dbpre" id="dbpre" placeholder="preT34">
					</div>
				</div>
				<div class="sec hide">
					<div class="inputGroup">
						<h2><?php echo $ai['app-sec'];?></h2>
					</div>
					<div class="inputGroup">
						<label for="auth"><?php echo $ai['auth'];?></label>
						<input type="text" name="auth" id="auth">
						<input type="hidden" name="auth-get" id="auth-get" value="<?php echo $auth?>">
					</div>
					<div class="inputGroup">
						<label for="salt"><?php echo $ai['salt'];?></label>
						<input type="text" name="salt" id="salt">
						<input type="hidden" name="salt-get" id="salt-get" value="<?php echo $salt?>">
					</div>
					<div class="inputGroup">
						<label for="secure"><?php echo $ai['sec'];?></label>
						<input type="text" name="secure" id="secure">
						<input type="hidden" name="secure-get" id="secure-get" value="<?php echo $secure?>">
					</div>
				</div>
				<div class="inputGroup install-group">
				</div>
				<div class="inputGroup form-send">
					<a href="#" class="btn btn-check"><?php echo $ai['check'];?></a>
				</div>
			</form>	
		</div>
		<div class="contentWrapper installing hide">
			<div class="inputGroup">
				<h2><?php echo $ai['install-app'];?></h2>
				<?php echo $ai['write-config'];?>
			</div>
		</div>
		<div class="contentWrapper adding-user hide">
			<div class="inputGroup">
				<h2><?php echo $ai['user-app'];?></h2>
			</div>
			<form method="post" class="no-enter userform">
				<div class="inputGroup">
					<label for="appuser"><?php echo $ai['username'];?></label>
					<input type="text" name="appuser" id="appuser" placeholder="">
				</div>
				<div class="inputGroup">
					<label for="appuserpass"><?php echo $ai['password'];?></label>
					<input type="text" name="appuserpass" id="appuserpass" placeholder="">
				</div>
				<div class="inputGroup adding-user-db">
				</div>
				<div class="inputGroup">
					<button class="btn"><?php echo $ai['add-user'];?></button>
				</div>
			</form>
		</div>
		<div class="contentWrapper installing-user hide">
			<div class="inputGroup">
				<h2><?php echo $ai['user-app'];?></h2>
			</div>
			
		</div>
	</article>
	<div class="push"></div>
</div>
<footer>
	<div class="contentWrapper"><?php echo $ai['install-footer']; ?>
		<span style="float:right;"><?php echo date('Y'); ?></span>
	</div>
</footer>
<script type="text/javascript">
$('.no-enter input').on('keydown',function(e){
   var key = e.keyCode;
   if(e.keyCode == 13) {
      e.preventDefault();
      return false;
    }
});

$('.btn-check').on('click',function(e){
	e.preventDefault();
	$('.install-group').append('<div class="ap-check"><?php echo $ai['checking'];?></div>');
	$('.ap').remove();
	var u = '<?php echo $actual_link ?>';
	if($('#dbhost').val() == '') {
		dbhost = 1;
	} else {
		dbhost = $('#dbhost').val();
	}
	var fdata = {
		'check_db': '1',
		'dbhost' : dbhost,
		'dbtable' : $('#dbtable').val(),
		'dbuser' : $('#dbuser').val(),
		'dbpass' : $('#dbpass').val(),
		'dbtype' : $('#dbtype option:selected').val(),
		'dbpre' : $('#dbpre').val(),
	}
	$.ajax({
      type    : 'POST', // define the type of HTTP verb we want to use (POST for our form)
      url     : u, // the url where we want to POST
      data    : fdata, // our data object
      dataType  : 'json', // what type of data do we expect back from the server
      encode    : true
    }).done(function(data) {
    	$('.ap-check').remove();
    	if(data.class == 'success') {
    		$('#dbpre').val(data.pre);
    		$('.btn-check').remove();
    		$('.sec').removeClass('hide');
    		$('.first input, .first select').prop('disabled', true);
    		$('.first input, .first select').addClass('locked');
    		$('.install-group').append('<div class="ap '+data.class+'">'+data.message+'</div>');
    		$('.form-send').append('<button class="btn btn-install"><?php echo $ai['install-btn'];?></button>');
    	} else {
    		$('.install-group').append('<div class="ap '+data.class+'">'+data.message+'</div>');
    	}

    })
});
$('.dbform').on('submit',function(e){
	e.preventDefault();
	$('.install-form').addClass('hide');
	$('.installing').removeClass('hide');
	var u = '<?php echo $actual_link ?>';
	if($('#dbhost').val() == '') {
		dbhost = 1;
	} else {
		dbhost = $('#dbhost').val();
	}
	var fdata = {
		'dbhost' : dbhost,
		'dbtable' : $('#dbtable').val(),
		'dbuser' : $('#dbuser').val(),
		'dbpass' : $('#dbpass').val(),
		'dbtype' : $('#dbtype option:selected').val(),
		'dbpre' : $('#dbpre').val(),
		'auth' : $('#auth').val(),
		'auth-get' : $('#auth-get').val(),
		'salt' : $('#salt').val(),
		'salt-get' : $('#salt-get').val(),
		'secure' : $('#secure').val(),
		'secure-get' : $('#secure-get').val()
	}
	$.ajax({
      type    : 'POST', 
      url     : u, 
      data    : fdata, 
      dataType  : 'json', 
      encode    : true
    }).done(function(data) {
    	if(data.class == 'success') {
    		$('.installing').append('<div class="ap '+data.class+'">'+data.message+'</div>');
    		$('.installing').delay( 2000 ).append('<div class="bd"><?php echo $ai['add-2-db'];?></div>');
    		$.getJSON(u, function( data ) {
  				if(data.class == 'success') {
  					$('.installing').append('<div class="ap '+data.class+'">'+data.message+'</div>');
  					$('.adding-user').removeClass('hide');
  				}
			});
    	} else {
    		$('.installing').append('<div class="ap '+data.class+'">'+data.message+'</div>');
    	}

    })
});
$('.userform').on('submit',function(e){
	e.preventDefault();
	var applogin = '<?php echo $ai['applogin'];?>';
	$('.adding-user-db').append('<?php echo $ai['adding-admin-user'];?>');
	var u = '<?php echo $actual_link ?>';
	var fdata = {
		'appuser' : $('#appuser').val(),
		'appuserpass' : $('#appuserpass').val()
	}
	$.ajax({
      type    : 'POST', 
      url     : u, 
      data    : fdata, 
      dataType  : 'json', 
      encode    : true
    }).done(function(data) {
    	console.log();
    	if(data.class == 'success') {
    		$('.adding-user').addClass('hide');
    		$('.installing-user').removeClass('hide');
    		$('.installing-user').append('<div><?php echo $ai['adding-admin-user'];?></div><div class="ap '+data.class+'">'+data.message+'</div>');
    		$('.installing-user').append('<div>'+applogin+'<span id="timer">15</span> <span><?php echo $ai['seconds'];?></span></div>');
    		setTimeout(function() {
    			location.reload();
			}, 15000);
    		var counter = setInterval(timer, 1000);
    	} else {
    		$('.installing-user').append('<div class="ap '+data.class+'">'+data.message+'</div>');
    	}

    }).fail(function(){
    	console.log();
    })
 });

function timer() {
var count = parseInt($('#timer').text());
// alert(count);
  count=count-1;
  if (count <= 0)
  {
     clearInterval(counter);
     return;
  }
 $("#timer").text(count);
}

</script>
</body>
</html>
