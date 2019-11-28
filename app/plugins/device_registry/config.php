<?php 
// $plugin['name'] = 'Intake';
$plugin['icon'] = 'glyphicons glyphicons-notes';
$plugin['author'] = 'Requillo';
$plugin['author_link'] = 'http://www.requillo.com';
$plugin['version'] = 1.00;
$plugin['desc'] = 'This is to register devices per company departments and users';
// Add stylesheets files relative where the plugins is
$enqueue->style('assets/css/style.css');
// $enqueue->script('assets/js/functions.js','footer');

$nav->sub('index',__('All Intakes','intake_clients'));
$nav->sub('new',__('Add','intake_clients'));
// $nav->sub('qr-scan',__('Scan QR Code','intake_clients'));
$nav->sub('settings',__('Settings','intake_clients'));