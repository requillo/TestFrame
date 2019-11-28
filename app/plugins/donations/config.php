<?php 
// $plugin['name'] = 'Intake';
$plugin['icon'] = 'glyphicons glyphicons-notes';
$plugin['author'] = 'Requillo';
$plugin['author_link'] = 'http://www.requillo.com';
$plugin['version'] = 3.4;
$plugin['desc'] = 'This is to register all donations';
// Add stylesheets files relative where the plugins is
$enqueue->style('assets/css/donations.css?ver=13');
$enqueue->script('assets/js/donations.js?ver=13','footer');

$nav->sub('index',__('All Donations','donations'));
$nav->sub('add-first',__('Add','donations'));
$nav->sub('donations-assets',__('Donations Assets','donations'));
$nav->sub('add-to-blacklist',__('Add to blacklist','donations'));
$nav->sub('blacklisted',__('All blacklisted','donations'));
$nav->sub('export',__('Data exports','donations'));
$nav->sub('settings',__('Settings','donations'));
// $nav->main('settings',__('Settings','donations'),'glyphicons glyphicons-notes');
// $nav->main('index',__('All Donations','donations'),'glyphicons glyphicons-notes');
// $nav->main('add-first',__('Add','donations'),'glyphicons glyphicons-notes');