<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$plugin['name'] = 'Inventories';
$plugin['icon'] = 'glyphicons glyphicons-map-marker';
$plugin['author'] = 'Requillo';
$plugin['author_link'] = 'http://www.requillo.com';
$plugin['version'] = 1.0;
$plugin['desc'] = 'Inventory plugin with notifications';
// Add stylesheets files relative where the plugins is
$enqueue->style('assets/css/inventory.css?ver=1');
$enqueue->script('assets/js/inventory.js?ver=1','footer');

$nav->main('index',__('All Inventories','inventory'),'glyphicons glyphicons-map');
$nav->main('use-inventory',__('Use Inventory','inventory'),'glyphicons glyphicons-notes');
$nav->main('add-inventory',__('Add Inventory','inventory'),'glyphicons glyphicons-notes');
$nav->main('categories',__('Inventory category','inventory'),'glyphicons glyphicons-notes');
$nav->main('inventory-items',__('Inventory items','inventory'),'glyphicons glyphicons-notes');
$nav->main('types',__('Item types','inventory'),'glyphicons glyphicons-notes');
//$nav->sub('settings',__('Settings','inventory'));
//$nav->sub('add-to-map',__('Add markers','inventory'));
//$nav->sub('add-region',__('Add region','inventory'));

// $nav->main('index',__('All Donations','donations'),'glyphicons glyphicons-notes'); 
// $nav->main('add-first',__('Add','donations'),'glyphicons glyphicons-notes');