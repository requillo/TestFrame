<?php 
// $plugin['name'] = 'Intake';
$plugin['icon'] = 'glyphicons glyphicons-notes';
$plugin['author'] = 'Requillo';
$plugin['author_link'] = 'http://www.requillo.com';
$plugin['version'] = 1.0;
$plugin['desc'] = 'Next order number';
// Add stylesheets files relative where the plugins is
// $enqueue->style('assets/css/donations.css?ver=12');
// $enqueue->script('assets/js/donations.js?ver=12','footer');

$nav->sub('index',__('Next Number','donations'));
// $nav->sub('add-first',__('Add','donations'));