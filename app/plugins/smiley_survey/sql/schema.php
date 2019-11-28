<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 

$sql->create('smiley_servey_questions',array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'terminal_id' => 'VARCHAR(350) NOT NULL',
	'company_id' => 'VARCHAR(350) NOT NULL',
	'question' => 'TEXT NOT NULL'
));

$sql->create('smiley_servey_emoticons',array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'emoticons' => 'VARCHAR(50) NOT NULL',
	'image_svg' => 'TEXT NOT NULL'
));

$sql->create('smiley_servey_answers',array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'description' => 'VARCHAR(350) NOT NULL',
	'type' => 'VARCHAR(350) NOT NULL',
	'list_order' => 'INT(4) NOT NULL',
	'list_style' => 'VARCHAR(5) NOT NULL',
	'emoticons_id' => 'INT(14) NOT NULL',
	'question_id' => 'INT(14) NOT NULL'
));

$sql->create('smiley_servey_companies',array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'company' => 'VARCHAR(350) NOT NULL',
	'address' => 'VARCHAR(350) NOT NULL',
	'telephone' => 'VARCHAR(350) NOT NULL',
	'place' => 'VARCHAR(350) NOT NULL',
	'logo' => 'VARCHAR(350) NOT NULL',
	'featured_image' => 'VARCHAR(350) NOT NULL',
	'company_key' => 'VARCHAR(350) NOT NULL'
));

$sql->create('smiley_servey_users',array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'company_id' => 'INT(14) NOT NULL',
	'user_id' => 'INT(14) NOT NULL'
));

$sql->create('smiley_servey_terminals',array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'terminal' => 'VARCHAR(350) NOT NULL',
	'company_id' => 'INT(14) NOT NULL'
));

$sql->create('smiley_servey_feedbacks',array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'feedback' => 'VARCHAR(350) NOT NULL',
	'list_order' => 'INT(4) NOT NULL',
	'answer_id' => 'INT(14) NOT NULL'
));

$sql->create('smiley_servey',array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'terminal_id' => 'INT(14) NOT NULL',
	'question_id' => 'INT(14) NOT NULL',
	'answers_id' => 'INT(14) NOT NULL',
	'feedback_id' => 'INT(14) NOT NULL',
	'added_date' => 'DATETIME'
));