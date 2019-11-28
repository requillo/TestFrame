<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 

$sql->create('map_markers', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'site_id' => 'INT(14) NOT NULL',
	'station_data' => 'TEXT NOT NULL',
	'latitude' => 'FLOAT(10,6) NOT NULL',
	'longitude' => 'FLOAT(10,6) NOT NULL',
	'station' => 'INT(9) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL',
));

$sql->create('map_marker_regions', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'region_data' => 'TEXT NOT NULL',
	'color' => 'INT(9) NOT NULL',
	'coordinates' => 'TEXT NOT NULL',
	'status' => 'TINYINT(1) NOT NULL',
));

$sql->create('map_marker_settings', array(
	'id' => 'BIGINT(20) AUTO_INCREMENT PRIMARY KEY',
	'meta' => 'VARCHAR(350) NOT NULL',
	'value' => 'VARCHAR(350) NOT NULL',
	'description' => 'VARCHAR(350) NOT NULL',
	'reorder' => 'INT(4) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL',
));

$sql->insert('map_marker_settings',array(
	'meta' => 'google-map-api-key',
	'value' => '',
	'description' => 'Add google maps api key',
	'status' => 1
));

$sql->insert('map_marker_settings',array(
	'meta' => 'map-height',
	'value' => '500',
	'description' => 'Map height',
	'status' => 1
));