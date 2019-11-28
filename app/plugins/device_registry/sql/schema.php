<?php

$sql->create('device_registry_company', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'name' => 'VARCHAR(250) NOT NULL',
	'address' => 'VARCHAR(250) NOT NULL',
	'telephone' => 'VARCHAR(150) NOT NULL',
	'website' => 'VARCHAR(150) NOT NULL',
	'email' => 'VARCHAR(80) NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('device_registry_department', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'name' => 'VARCHAR(250) NOT NULL',
	'company_id' => 'INT(14) NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('device_registry_brands', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'name' => 'VARCHAR(250) NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('device_registry_users', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'f_name' => 'VARCHAR(250) NOT NULL',
	'l_name' => 'VARCHAR(250) NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('device_registry', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'name' => 'VARCHAR(250) NOT NULL',
	'model' => 'VARCHAR(250) NOT NULL',
	'extra_info' => 'VARCHAR(300) NOT NULL',
	'note' => 'VARCHAR(250) NOT NULL',
	'brand_id' => 'VARCHAR(25) NOT NULL',
	'registry_code' => 'VARCHAR(250) NOT NULL',
	'department_id' => 'DATETIME',
	'user_id' => 'INT(14) NOT NULL',
	'loan_agreement' => 'TINYINT(1) NOT NULL',
	'loan_agreement_doc' => 'VARCHAR(250) NOT NULL',
	'in_use_date' => 'DATETIME',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('device_registry_history', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'edit_table' => 'VARCHAR(250) NOT NULL',
	'table_id' => 'VARCHAR(250) NOT NULL',
	'edit_data' => 'VARCHAR(300) NOT NULL',
	'edited' => 'VARCHAR(250) NOT NULL',
	'edit_user' => 'VARCHAR(25) NOT NULL'
));

$sql->create('device_registry_settings', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'meta' => 'VARCHAR(250) NOT NULL',
	'value' => 'VARCHAR(250) NOT NULL',
	'type' => 'VARCHAR(300) NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));