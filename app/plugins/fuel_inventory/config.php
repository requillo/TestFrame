<?php 
// $plugin['name'] = 'Intake';
$plugin['icon'] = 'glyphicons glyphicons-gas-station';
$plugin['author'] = 'Requillo';
$plugin['author_link'] = 'http://www.requillo.com';
$plugin['version'] = 2.3;
$plugin['desc'] = 'Check Fuel Inventories for Gas Stations';

// Add stylesheets files relative where the plugins is
$enqueue->style('assets/css/fuel_inventory.css?ver=12');
//$enqueue->script('assets/js/functions.js');
//$enqueue->script('assets/js/highcharts-more.js');
//$enqueue->script('assets/js/exporting.js');
//$enqueue->script('assets/js/grouped-categories.js');
//$enqueue->app_script('assets/highcharts/highcharts.js');
//$enqueue->app_script('assets/highcharts/highcharts-more.js');
//$enqueue->app_script('assets/highcharts/exporting.js');
$enqueue->script('assets/js/fuel_inventory.js?ver=12','footer');

$nav->main('site',__('Fuel Inventory','fuel_inventory'),'glyphicons glyphicons-gas-station');
$nav->main('my-site',__('My Inventory','fuel_inventory'),'glyphicons glyphicons-charts');
$nav->main('settings',__('Fuel Settings','fuel_inventory'),'glyphicons glyphicons-adjust-alt');
$nav->main('link-users',__('Link users','fuel_inventory'),'glyphicons glyphicons-user-add');
//$nav->sub('index',__('Fuel Test','fuel_inventory'),'glyphicons glyphicons-adjust-alt');
//$nav->sub('what',__('Fuel what','fuel_inventory'),'glyphicons glyphicons-adjust-alt');