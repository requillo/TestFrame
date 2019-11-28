<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 

$sql->create('checklist',array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'created' => 'DATETIME NOT NULL',
	'created_user' => 'INT(14) NOT NULL',
	'updated' => 'DATETIME NOT NULL',
	'updated_user' => 'INT(14) NOT NULL',
	'data_date' => 'DATE NOT NULL',
	'data_time' => 'TIME NOT NULL',
	'data_interval' => 'VARCHAR(10) NOT NULL',
	'data_checklist' => 'TEXT NOT NULL',
	'manage_open' => 'TINYINT(1) NOT NULL',
	'manage_open_user' => 'INT(14) NOT NULL',
	'checklist_name_id' => 'INT(14) NOT NULL'
));

$sql->create('checklist_settings',array(
	'id' => 'INT(2) AUTO_INCREMENT PRIMARY KEY',
	'email_address' => 'VARCHAR(50) NOT NULL',
	'email_smtp' => 'VARCHAR(50) NOT NULL',
	'email_port' => 'INT(6) NOT NULL',
	'email_security' => 'VARCHAR(10) NOT NULL',
	'email_pass' => 'VARCHAR(15) NOT NULL',
	'email_sent_to' => 'VARCHAR(50) NOT NULL',
	'dashboard_limit' => 'INT(3) NOT NULL',
	'time_to_edit' => 'INT(3) NOT NULL',
	'time_array' => 'TEXT NOT NULL',
	'shifts' => 'TEXT NOT NULL'
));

$sql->create('checklist_name',array(
	'id' => 'INT(5) AUTO_INCREMENT PRIMARY KEY',
	'name' => 'VARCHAR(255) NOT NULL',
	'no_options' => 'VARCHAR(255) NOT NULL',
	'name_functions' => 'VARCHAR(255) NOT NULL',
	'function_selection' => 'VARCHAR(255) NOT NULL',
	'function_input' => 'INT(9) NOT NULL',
	'custom_script' => 'TEXT NOT NULL',
	'category' => 'INT(4) NOT NULL'
));

$sql->create('checklist_options',array(
	'id' => 'INT(9) AUTO_INCREMENT PRIMARY KEY',
	'name' => 'VARCHAR(255) NOT NULL',
	'info' => 'VARCHAR(255) NOT NULL',
	'graph_options' => 'VARCHAR(255) NOT NULL',
	'indu_cat' => 'VARCHAR(255) NOT NULL',
	'type' => 'INT(4) NOT NULL',
	'type_options' => 'TEXT NOT NULL',
	'list_order' => 'INT(4) NOT NULL',
	'side_info' => 'VARCHAR(10) NOT NULL',
	'rel_id' => 'INT(9) NOT NULL',
	'is_required' => 'TINYINT(1) NOT NULL',
	'link_type' => 'TINYINT(1) NOT NULL',
	'link_option' => 'INT(9) NOT NULL',
	'category' => 'INT(4) NOT NULL'
));

$sql->create('checklist_options_cat',array(
	'id' => 'INT(4) AUTO_INCREMENT PRIMARY KEY',
	'name' => 'VARCHAR(255) NOT NULL',
	'info_01' => 'TEXT NOT NULL',
	'info_02' => 'TEXT NOT NULL',
	'info_03' => 'TEXT NOT NULL',
	'interval_type' => 'TINYINT(2) NOT NULL',
	'interval_data' => 'TEXT NOT NULL',
	'list_add_view' => 'TINYINT(1) NOT NULL',
	'list_view' => 'TINYINT(1) NOT NULL'
));

$sql->create('checklist_department',array(
	'id' => 'INT(4) AUTO_INCREMENT PRIMARY KEY',
	'name' => 'VARCHAR(255) NOT NULL',
	'checklist_name_ids' => 'TEXT NOT NULL'
));

$sql->create('checklist_users_department',array(
	'id' => 'INT(4) AUTO_INCREMENT PRIMARY KEY',
	'user_id' => 'VARCHAR(255) NOT NULL',
	'department_id' => 'INT(4) NOT NULL'
));

$sql->create('checklist_shifts',array(
	'id' => 'INT(4) AUTO_INCREMENT PRIMARY KEY',
	'name' => 'VARCHAR(255) NOT NULL',
	'shift_start' => 'TIME NOT NULL',
	'shift_end' => 'TIME NOT NULL'
));