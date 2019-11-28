<?php 
$plugin['name'] = 'Messages';
// $plugin['icon'] = 'glyphicons glyphicons-charts';
$plugin['author'] = 'Requillo';
$plugin['author_link'] = 'http://www.requillo.com';
$plugin['version'] = 1.00;
$plugin['desc'] = 'This messaging plugin is for users within this application. Beta version';
// Add stylesheets files relative where the plugins is
$enqueue->style('assets/css/messages.css?vers=8');
//$enqueue->script('assets/js/chat.js','footer');