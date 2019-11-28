<?php 
// $plugin['name'] = 'Intake';
$plugin['icon'] = 'glyphicon glyphicon-list-alt';
$plugin['author'] = 'Requillo';
$plugin['author_link'] = 'http://www.requillo.com';
$plugin['version'] = 1.53;
$plugin['desc'] = 'Intake form system is a plugin to add clients computers or laptop etc..';
// Add stylesheets files relative where the plugins is
$enqueue->style('assets/css/style.css');
$enqueue->script('assets/js/filereader.js','footer');
$enqueue->script('assets/js/qrcodelib.js','footer');
$enqueue->script('assets/js/webcodecamjquery.js','footer');
$enqueue->script('assets/js/mainjquery.js','footer');
$enqueue->script('assets/js/functions.js','footer');

$nav->sub('index',__('All Intakes','intake_clients'));
$nav->sub('new',__('Add Intake','intake_clients'));
$nav->sub('invoices',__('Invoices','intake_clients'));
$nav->sub('add-invoice',__('Add Invoice','intake_clients'));
// $nav->sub('qr-scan',__('Scan QR Code','intake_clients'));
$nav->sub('settings',__('Settings','intake_clients'));