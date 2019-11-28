<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$plugin['name'] = 'Smiley Servey';
$plugin['icon'] = 'glyphicons glyphicons-map-marker';
$plugin['author'] = 'Requillo';
$plugin['author_link'] = 'http://www.requillo.com';
$plugin['version'] = 1.4;
$plugin['desc'] = 'Smiley styled survey for companies';
// Add stylesheets files relative where the plugins is
$enqueue->style('assets/css/admin.css?ver=13');
$enqueue->script('assets/js/admin.js?ver=1','footer');

$nav->main('index',__('Main','smiley_survey'),'glyphicons glyphicons-map');
$nav->main('add-companies',__('Survey Companies','smiley_survey'),'glyphicons glyphicons-map');
$nav->main('add-terminal',__('Survey Terminals','smiley_survey'),'glyphicons glyphicons-map');
$nav->main('add-question',__('Survey Questions','smiley_survey'),'glyphicons glyphicons-map');
$nav->main('emoticons',__('Survey Emoticons','smiley_survey'),'glyphicons glyphicons-map');

// $nav->main('index',__('All Donations','donations'),'glyphicons glyphicons-notes'); 
// $nav->main('add-first',__('Add','donations'),'glyphicons glyphicons-notes');