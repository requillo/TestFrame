<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$sql->create('messages', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'user_id' => 'INT(14) NOT NULL',
	'to_person_id' => 'INT(14) NOT NULL',
	'message' => 'TEXT NOT NULL',
	'attachments' => 'TEXT NOT NULL',
	'has_read' => 'TINYINT(1) NOT NULL',
	'created' => 'DATETIME',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('messages_has_user', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'user_id' => 'INT(14) NOT NULL',
	'to_person_id' => 'INT(14) NOT NULL',
	'is_typing' => 'TINYINT(1) NOT NULL',
	'is_typing_date' => 'DATETIME',
	'has_update' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('messages_settings', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'meta' => 'VARCHAR(100) NOT NULL',
	'value' => 'VARCHAR(250) NOT NULL',
	'description' => 'TEXT NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->insert('messages_settings',array(
	'meta' => 'interval_seconds',
	'description' => 'Set the interval for checking is user is typing in seconds',
	'value' => '5',
	'status' => 1
));