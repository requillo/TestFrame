<?php
$sql->create('next_numbers', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'next' => 'INT(14) NOT NULL',
	'state' => 'TINYINT(2) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('next_numbers_check', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'update_number' => 'INT(8) NOT NULL',
	'meta' => 'VARCHAR(15) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->insert('next_numbers_check',array(
	'meta' => 'check_update',
	'update_number' => 1,
	'status' => 1
));