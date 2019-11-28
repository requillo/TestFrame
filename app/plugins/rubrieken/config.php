<?php 
$plugin['name'] = 'Rubrieken';
$plugin['icon'] = 'glyphicon glyphicon-list-alt';
$plugin['author'] = 'Requillo';
$plugin['author_link'] = 'http://www.requillo.com';
$plugin['version'] = 1.20;
$plugin['desc'] = 'Rubrieken system is a plugin to add small advertisement into newspaper.';
// Add stylesheets files relative where the plugins is
$enqueue->style('assets/css/jquery-ui.css');
$enqueue->style('assets/css/jquery-ui.multidatespicker.css');
$enqueue->style('assets/css/style.css');
$enqueue->style('assets/css/rubrieken.css');
$enqueue->style('assets/css/jquery.contextMenu.css');
$enqueue->script('assets/js/rubrieken.js','footer');
$enqueue->script('assets/js/jquery-ui.min.js');
$enqueue->script('assets/js/jquery-ui.multidatespicker.js');
$enqueue->script('assets/js/jquery.contextMenu.js');
$enqueue->script('assets/js/jquery.ui.position.js');

$nav->sub('index',__('All Rubrieken','rubrieken'));
$nav->sub('new',__('Add Rubrieken','rubrieken'));
$nav->sub('settings',__('Settings','rubrieken'));