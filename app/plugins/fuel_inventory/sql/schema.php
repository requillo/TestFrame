<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$sql->create('fuel_inventory', array(
	'id' => 'BIGINT(20) AUTO_INCREMENT PRIMARY KEY',
	'site_id' => 'INT(14) NOT NULL',
	'site_date' => 'DATE NOT NULL',
	'site_time' => 'TIME NOT NULL',
	'tank_number' => 'INT(4) NOT NULL',
	'product_code' => 'INT(5) NOT NULL',
	'tank_status_bits' => 'VARCHAR(25) NOT NULL',
	'tank_volume' => 'DECIMAL(10,3) NOT NULL',
	'tank_tc_volume' => 'DECIMAL(10,3) NOT NULL',
	'tank_ullage' => 'DECIMAL(10,3) NOT NULL',
	'tank_height' => 'DECIMAL(10,3) NOT NULL',
	'tank_water' => 'DECIMAL(10,3) NOT NULL',
	'tank_temperature' => 'DECIMAL(10,3) NOT NULL',
	'tank_water_volume' => 'DECIMAL(10,3) NOT NULL'
));

$sql->create('fuel_products', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'product_id' => 'INT(5) NOT NULL',
	'product' => 'VARCHAR(80) NOT NULL',
	'product_alias' => 'VARCHAR(50) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('fuel_tanks', array(
	'id' => 'INT(8) AUTO_INCREMENT PRIMARY KEY',
	'tank_id' => 'INT(5) NOT NULL',
	'tank' => 'VARCHAR(80) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('fuel_sites', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'site_id' => 'INT(14) NOT NULL',
	'dealer' => 'VARCHAR(150) NOT NULL',
	'address' => 'VARCHAR(250) NOT NULL',
	'district' => 'VARCHAR(100) NOT NULL',
	'phone' => 'VARCHAR(100) NOT NULL',
	'email' => 'VARCHAR(150) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('fuel_site_tank_product', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'site_id' => 'INT(14) NOT NULL',
	'tank_id' => 'INT(4) NOT NULL',
	'product_id' => 'INT(5) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('fuel_settings', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'meta' => 'VARCHAR(350) NOT NULL',
	'value' => 'VARCHAR(450) NOT NULL',
	'description' => 'TEXT NOT NULL',
	'input_type' => 'VARCHAR(20) NOT NULL',
	're_order' => 'INT(3) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->insert('fuel_settings',array(
	'meta' => 'low-threshold',
	'value' => '30',
	'description' => 'For fuel below',
	'input_type' => 'number',
	're_order' => 1,
	'status' => 1
));

$sql->insert('fuel_settings',array(
	'meta' => 'low-threshold-color',
	'value' => '#d25e00',
	'description' => 'The warning color for low volume in thank',
	'input_type' => 'color',
	're_order' => 2,
	'status' => 1
));

$sql->insert('fuel_settings',array(
	'meta' => 'lowlow-threshold',
	'value' => '10',
	'description' => 'For fuel below',
	'input_type' => 'number',
	're_order' => 3,
	'status' => 1
));

$sql->insert('fuel_settings',array(
	'meta' => 'lowlow-threshold-color',
	'value' => '#a90000',
	'description' => 'The warning color for low low volume in tank',
	'input_type' => 'color',
	're_order' => 4,
	'status' => 1
));

$sql->insert('fuel_settings',array(
	'meta' => 'high-threshold',
	'value' => '80',
	'description' => 'For fuel above',
	'input_type' => 'number',
	're_order' => 5,
	'status' => 1
));

$sql->insert('fuel_settings',array(
	'meta' => 'high-threshold-color',
	'value' => '#0060ff',
	'description' => 'The warning color for high volume in thank',
	'input_type' => 'color',
	're_order' => 6,
	'status' => 1
));

$sql->insert('fuel_settings',array(
	'meta' => 'normal-fuel-color',
	'value' => '#079100',
	'description' => 'The color for normal fuel volume in thank',
	'input_type' => 'color',
	're_order' => 7,
	'status' => 1
));

$sql->insert('fuel_settings',array(
	'meta' => 'water-color',
	'value' => '#000',
	'description' => 'The color for water volume in thank',
	'input_type' => 'color',
	're_order' => 8,
	'status' => 1
));

$sql->insert('fuel_settings',array(
	'meta' => 'ullage-color',
	'value' => '#626262',
	'description' => 'The color for ullage volume in thank',
	'input_type' => 'color',
	're_order' => 9,
	'status' => 1
));

$sql->insert('fuel_settings',array(
	'meta' => 'title-color',
	'value' => '#626262',
	'description' => 'The color for the titles in the graphs',
	'input_type' => 'color',
	're_order' => 9,
	'status' => 1
));

$sql->insert('fuel_settings',array(
	'meta' => 'refresh-dashboard-configuration',
	'value' => '5',
	'description' => 'Refresh rate for the dashboard, use 0 to disable',
	'input_type' => 'color',
	're_order' => 9,
	'status' => 1
));

$sql->insert('fuel_settings',array(
	'meta' => 'refresh-single-page-configuration',
	'value' => '5',
	'description' => 'Refresh rate for dealer fuel inventory page, use 0 to disable',
	'input_type' => 'color',
	're_order' => 9,
	'status' => 1
));

$sql->insert('fuel_settings',array(
	'meta' => 'col-array',
	'value' => '1',
	'description' => 'Use color array instead',
	'input_type' => 'text',
	're_order' => 1,
	'status' => 1
));

$sql->insert('fuel_settings',array(
	'meta' => 'dashboard-chart',
	'value' => 'doughnut',
	'description' => 'Display charts style on dashboard',
	'input_type' => 'text',
	're_order' => 1,
	'status' => 1
));

// Version 2.2

$sql->alter('fuel_sites',array(
	'add' => array(
		'column' => 'featured_image',
		'type' => 'VARCHAR(200) NOT NULL'
	)
));

$sql->alter('fuel_sites',array(
	'add' => array(
		'column' => 'gallery_image',
		'type' => 'TEXT NOT NULL'
	)
));

// Version 2.3
$sql->create('fuel_sites_user_relation', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'site_id' => 'INT(14) NOT NULL',
	'user_id' => 'INT(14) NOT NULL',
	'added' => 'DATETIME',
	'added_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));