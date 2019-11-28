<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
// $plugin['name'] = 'Name the plugin';
// $plugin['icon'] = 'glyphicons glyphicons-charts';
$plugin['author'] = 'Requillo';
$plugin['author_link'] = 'http://www.requillo.com';
$plugin['version'] = 1.20;
$plugin['desc'] = 'This is for the description of the plugin and what is does.';
// Add stylesheets files relative where the plugins is
$enqueue->style('assets/css/clients.css');
$enqueue->script('assets/js/clients.js','footer');

$nav->sub('index',__('All Clients','clients'));
$nav->sub('new',__('Add Clients','clients'));
$nav->sub('check-visas',__('Check visas','clients'));
$nav->sub('check-passports',__('Check passports','clients'));
$nav->sub('settings',__('Settings','clients'));
