<?php
defined('BASEPATH') OR exit('No direct script access allowed');
# Application main urls
// When the application is not installed, it will use this link to do the installation.
$app['install-url'] = 'install';
// Main application login
$app['login-url'] = 'login';
// Front user login for website
$app['user-login'] = 'user-login';
// For the admin area if website is enabled
$app['admin-url'] = 'admin';
// This is for the action to logout from the backend
$app['logout-url'] = 'logout';
// This is for when $app['admin-splash'] is true in Application configurations
$app['dashboard-url'] = 'dashboard'; 
// This is for rest api
$app['api-url'] = 'api'; 
// This is for cron jobs
$app['cron-url'] = 'cron'; 

# Application rest urls
// For json url
$app['json'] = 'json';
// xml url
$app['xml'] = 'xml';

# Application configurations
// Set true or false to enable installing application from browser. 
// When the application is installed set it to false to prevent installing when database is not connected.
// As long as a database is connected to the Application it will NEVER install the application.
// The application will try to install when no database is connected to the application.
$app['install-the-app'] = false;
// Enable or disable the front page or website. This will disable the login link
$app['show-website'] = false;
// This is for display errors 
// If the application is live, please set this to false
$app['app-debug'] = true;
// Protect the login form with numpad 
$app['login-protect'] = false;

# Application directories
// If you change these paths, be sure to change the folder names as well
$app['app-path'] = BASEPATH.'app/';
$app['assets-path'] = BASEPATH.'assets/';
$app['controllers-path'] = $app['app-path'].'controllers/';
$app['models-path'] =  $app['app-path'].'models/';
$app['views-path'] =  $app['app-path'].'views/';
$app['plugins-path'] =  $app['app-path'].'plugins/';
$app['helpers-path'] =  $app['app-path'].'helpers/';
$app['routes-path'] =  $app['app-path'].'routes/';
$app['themes-path'] =  $app['app-path'].'themes/';
$app['webthemes-path'] =  BASEPATH.'themes/';
$app['language-path'] =  $app['app-path'].'lang/';
$app['globals-path'] =  $app['app-path'].'globals/';
// For media folder that is outside application the root
// $app['media-protect'] = BASEPATH.'../__protect_media/';
$app['media-protect'] = BASEPATH.'__protect_media/';

### Important, do not edit form here on below ###
# Reserved names, you can add more
// This will help when you try to install a plugin with the same name as existing controllers
$app['reserved-names'] = array(
	$app['install-url'],
	$app['login-url'],
	$app['user-login'],
	$app['admin-url'],
	$app['logout-url'],
	$app['dashboard-url'],
	$app['cron-url'],
	$app['api-url'],
	'pages',
	'users',
	'plugins',
	'profile',
	'settings'
	);
# Default controller methods
$app['defaultmethods'] = array('__construct','set','loadmodel','error','admin_redirect','is_plugin','is_plugin_active','required_data','get_page_forms');
# Application domain
// HTTP.'://'.$_SERVER['HTTP_HOST'] .'/'
// if application is in folder e.g: www.domain.com/app/
// use HTTP.'://'.$_SERVER['HTTP_HOST'].'/app/
$app['domain'] = HTTP.'://'.$_SERVER['HTTP_HOST'] .'/newapp/';
# Security hash
$app['auth'] = '6lXvPqx5JLag>jmJPfnE(5>Ux?fp&(Dg4#7ocUeXXk5-5w*tNUUUxebJx16tSl8';
$app['salt'] = ')Rq(wJ1I)JqZaowcIEfb*Q6wh5GDgM7Q?5g(AulAz5YABIgeY#!3tg0hDT46W!O';
$app['secure'] = 'kW--InG<(RHQ)Edv!XVrberEIT$X%5BZWGvBI9xDG1Lwto63lAqbLr!b9SpJhcf';