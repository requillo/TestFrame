<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$sql->create('inventory', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'inventory_data' => 'TEXT NOT NULL',
	'inventory_date' => 'DATE',
	'inventory_action' => 'VARCHAR(10) NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated' => 'DATETIME',
	'updated_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('inventory_use', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'inventory_data' => 'TEXT NOT NULL',
	'inventory_date' => 'DATE',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated' => 'DATETIME',
	'updated_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('inventory_add', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'inventory_data' => 'TEXT NOT NULL',
	'inventory_date' => 'DATE',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated' => 'DATETIME',
	'updated_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('inventory_categories', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'name' => 'VARCHAR(150) NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated' => 'DATETIME',
	'updated_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('inventory_item_types', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'name' => 'VARCHAR(150) NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated' => 'DATETIME',
	'updated_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('inventory_items', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'name' => 'VARCHAR(200) NOT NULL',
	'inventory_min' => 'INT(10) NOT NULL',
	'inventory_min_message' => 'VARCHAR(200) NOT NULL',
	'category' => 'INT(14) NOT NULL',
	'item_type' => 'INT(14) NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated' => 'DATETIME',
	'updated_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('inventory_history', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'inventory_data' => 'TEXT NOT NULL',
	'inventory_table' => 'TEXT NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated' => 'DATETIME',
	'updated_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('inventory_meta_option', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'meta_type' => 'VARCHAR(200) NOT NULL',
	'meta_table' => 'VARCHAR(200) NOT NULL',
	'meta_name' => 'VARCHAR(200) NOT NULL',
	'meta_val' => 'VARCHAR(200) NOT NULL',
	'meta_message' => 'VARCHAR(200) NOT NULL',
	'meta_scope' => 'VARCHAR(200) NOT NULL',
	'meta_rel' => 'VARCHAR(200) NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated' => 'DATETIME',
	'updated_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));