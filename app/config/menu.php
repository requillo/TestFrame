<?php 
/**
* 
*/
$menu['pages'] = array(
	'index' => __('All pages'),
	'new' => __('New page')
	);
$menu['forms'] = array(
	'index' => __('All forms'),
	'add' => __('Add form'),
	'settings' => __('Main settings')
	);
$menu['plugins'] = __('Plugins');
$menu['users'] = array(
	'index' => __('All users'),
	'new' => __('New user'),
	'companies' => __('Companies'),
	'user-roles' => __('User roles')
	);
$menu['profile'] = __('Profile');
$menu['appearance'] = array(
	'index' => __('Admin themes'),
	'admintheme-widgets' => __('Admin widgets'),
	);
$menu['settings'] = array(
	'index' => __('Main settings'),
	'page-roles' => __('Page roles'),
	);
$menu['web-settings'] = array(
	'index' => __('Main settings'),
	'menu' => __('Site menu'),
	);
$menu['logout'] = __('Logout');


$nav->icon('dashboard','fa fa-power-off');
$nav->icon('pages','fa fa-files-o');
$nav->icon('users' ,'fa fa-users');
$nav->icon('profile',array('m'=>'fa fa-user','f'=>'fa fa-user'));
$nav->icon('settings','fa fa-cogs');
$nav->icon('web-settings','fa fa-cogs');
$nav->icon('plugins','fa fa-plug');
$nav->icon('appearance','fa fa-paint-brush');
$nav->icon('forms','fa fa-list-alt');
$nav->icon('logout','fa fa-power-off');
$nav->default_icon('fa fa-puzzle-piece');