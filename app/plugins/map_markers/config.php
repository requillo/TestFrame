<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$plugin['name'] = 'Map markers';
$plugin['icon'] = 'glyphicons glyphicons-map-marker';
$plugin['author'] = 'Requillo';
$plugin['author_link'] = 'http://www.requillo.com';
$plugin['version'] = 1.3;
$plugin['desc'] = 'Add markers to google map. This also extends the Fuel Inventory plugin';
// Add stylesheets files relative where the plugins is
$enqueue->style('assets/css/map-markers.css?ver=1');
$enqueue->script('assets/js/map-markers.js?ver=1','footer');

$nav->main('map',__('Map','map_markers'),'glyphicons glyphicons-map');
$nav->sub('settings',__('Settings','map_markers'));
$nav->sub('add-to-map',__('Add markers','map_markers'));
$nav->sub('add-region',__('Add region','map_markers'));

// $nav->main('index',__('All Donations','donations'),'glyphicons glyphicons-notes'); 
// $nav->main('add-first',__('Add','donations'),'glyphicons glyphicons-notes');