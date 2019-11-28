<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$register->widget('dashboard',array(
'name' => __('Dashboard widget area','gents'),
'description' => __('Add all the widgets here to display on the dashboard','gents')
));

$register->widget('header-menu',array(
'name' => __('Header menu item','sol'),
'description' => __('Add all the widgets here to display as a menu item in the header','sol')
));