<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$plugin['name'] = 'Checklist';
$plugin['icon'] = 'glyphicon glyphicon-ok';
$plugin['author'] = 'Requillo';
$plugin['author_link'] = 'http://www.requillo.com';
$plugin['version'] = 1.4;
$plugin['desc'] = 'Checklist creation';
// Add stylesheets files relative where the plugins is
$enqueue->style('assets/css/admin.css?ver=14','footer');

$enqueue->app_script('assets/jspdf/js/jspdf.min.js');
$enqueue->app_script('assets/jspdf/js/jspdf.plugin.autotable.min.js');
$enqueue->script('assets/js/admin.js?ver=1','footer');

$nav->sub('add-to-list',__('Checklists','checklists'));
$nav->sub('manage-list',__('Manage Checklists','checklists'));
$nav->sub('create-list-category',__('Create list category','checklist'));
$nav->sub('create-list-options',__('Create list options','checklist'));
$nav->sub('create-list-name',__('Create list name','checklist'));
$nav->sub('create-department',__('Create Department','checklist'));
$nav->sub('department-users',__('Department users','checklists'));
$nav->sub('shifts-settings',__('Shifts Settings','checklists'));
$nav->sub('settings',__('Settings','checklists'));


// $nav->main('index',__('All Donations','donations'),'glyphicons glyphicons-notes'); 
// $nav->main('add-first',__('Add','donations'),'glyphicons glyphicons-notes');