<?php 
defined('DB_IS_NOT_INSTALLED') OR exit('No direct script access allowed');
// Create Application Settings Table
$sql->create('meta_options', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'name' => 'VARCHAR(50) NOT NULL',
	'value' => 'VARCHAR(50) NOT NULL',
	'meta_str' => 'VARCHAR(250) NOT NULL',
	'meta_int' => 'INT(14) NOT NULL',
	'meta_text' => 'TEXT'
));
// Insert Application Settings Data
$sql->insert('meta_options',array(
	'name' => 'settings',
	'value' => 'multilang',
	'meta_str' => '',
	'meta_int' => '1',
	'meta_text' => ''
));
$sql->insert('meta_options',array(
	'name' => 'settings',
	'value' => 'languages',
	'meta_str' => '',
	'meta_int' => 0,
	'meta_text' => '{"en":"en_EN","nl":"nl_NL","es":"es_ES"}'
));
$sql->insert('meta_options',array(
	'name' => 'settings',
	'value' => 'default_lang',
	'meta_str' => '{"en":"en_EN"}',
	'meta_int' => 0,
	'meta_text' => ''
));
$sql->insert('meta_options',array(
	'name' => 'settings',
	'value' => 'app_name',
	'meta_str' => 'Requillo Application',
	'meta_int' => 0,
	'meta_text' => ''
));
$sql->insert('meta_options',array(
	'name' => 'settings',
	'value' => 'lang_name',
	'meta_str' => '',
	'meta_int' => 0,
	'meta_text' => '{"en":"English","nl":"Nederlands","es":"Espanol"}'
));
$sql->insert('meta_options',array(
	'name' => 'settings',
	'value' => 'timezone',
	'meta_str' => 'America/Argentina/Buenos_Aires',
	'meta_int' => 0,
	'meta_text' => ''
));
$sql->insert('meta_options',array(
	'name' => 'settings',
	'value' => 'app_logo',
	'meta_str' => '',
	'meta_int' => 0,
	'meta_text' => ''
));
$sql->insert('meta_options',array(
	'name' => 'settings',
	'value' => 'app_icon',
	'meta_str' => '',
	'meta_int' => 0,
	'meta_text' => ''
));
$sql->insert('meta_options',array(
	'name' => 'themes',
	'value' => 'admin_theme',
	'meta_str' => 'gents',
	'meta_int' => 0,
	'meta_text' => ''
));
$sql->insert('meta_options',array(
	'name' => 'themes',
	'value' => 'web_theme',
	'meta_str' => 'default',
	'meta_int' => 0,
	'meta_text' => ''
));
$sql->insert('meta_options',array(
	'name' => 'page',
	'value' => 'index',
	'meta_str' => '',
	'meta_int' => 0,
	'meta_text' => ''
));
$sql->insert('meta_options',array(
	'name' => 'admin_pages',
	'value' => '60.0',
	'meta_str' => '',
	'meta_int' => 0,
	'meta_text' => ''
));
$sql->insert('meta_options',array(
	'name' => 'admin_pages',
	'value' => '8.0',
	'meta_str' => '',
	'meta_int' => 0,
	'meta_text' => ''
));
$sql->insert('meta_options',array(
	'name' => 'admin_pages',
	'value' => '5.0',
	'meta_str' => '',
	'meta_int' => 0,
	'meta_text' => ''
));
$sql->insert('meta_options',array(
	'name' => 'admin_pages',
	'value' => '1.0',
	'meta_str' => '',
	'meta_int' => 0,
	'meta_text' => ''
));
$sql->insert('meta_options',array(
	'name' => 'website',
	'value' => 'menu',
	'meta_str' => 'Main menu',
	'meta_int' => 0,
	'meta_text' => ''
));
$sql->insert('meta_options',array(
	'name' => 'website',
	'value' => 'web_logo',
	'meta_str' => '',
	'meta_int' => 0,
	'meta_text' => ''
));
$sql->insert('meta_options',array(
	'name' => 'website',
	'value' => 'favicon',
	'meta_str' => '',
	'meta_int' => 0,
	'meta_text' => ''
));
$sql->insert('meta_options',array(
	'name' => 'website',
	'value' => 'name',
	'meta_str' => '',
	'meta_int' => 0,
	'meta_text' => ''
));
$sql->insert('meta_options',array(
	'name' => 'website',
	'value' => 'description',
	'meta_str' => '',
	'meta_int' => 0,
	'meta_text' => ''
));
// Widgets
$sql->create('widgets', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'widget_type' => 'VARCHAR(50) NOT NULL',
	'widget_position' => 'VARCHAR(250) NOT NULL',
	'widget_settings' => 'TEXT NOT NULL',
	'widget_data' => 'TEXT NOT NULL',
	'reorder' => 'INT(14) NOT NULL',
	'created' => 'DATETIME',
	'updated' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));
// Create Application Pages Table
$sql->create('pages', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'title' => 'VARCHAR(255) NOT NULL',
	'slug' => 'VARCHAR(255) NOT NULL',
	'content' => 'TEXT',
	'parent' => 'INT(8) NOT NULL',
	'level' => 'TINYINT(3) NOT NULL',
	'forms' => 'SMALLINT(4) NOT NULL',
	'plugins' => 'TEXT NOT NULL',
	'created' => 'DATETIME',
	'updated' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated_user' => 'INT(14) NOT NULL',
	'type' => 'VARCHAR(50) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));
// Create Application Forms Table
$sql->create('forms', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'name' => 'VARCHAR(350) NOT NULL',
	'inputs' => 'TEXT NOT NULL',
	'created' => 'DATETIME',
	'updated' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated_user' => 'INT(14) NOT NULL',
	'use_smpt' => 'TINYINT(1) NOT NULL',
	'send_email_address' => 'VARCHAR(350) NOT NULL',
	'send_email_pass' => 'VARCHAR(350) NOT NULL',
	'send_message' => 'TEXT NOT NULL',
	'mailto_address' => 'VARCHAR(500) NOT NULL',
	'cc_address' => 'VARCHAR(500) NOT NULL',
	'thank_you_message' => 'TEXT NOT NULL',
	'thank_you_title' => 'VARCHAR(355) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));
$sql->create('form_settings', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'meta' => 'VARCHAR(350) NOT NULL',
	'value' => 'VARCHAR(350) NOT NULL',
	'description' => 'VARCHAR(450) NOT NULL',
	'data' => 'TEXT NOT NULL'
));
$sql->insert('form_settings',array(
	'meta' => 'smtp-port',
	'value' => '',
	'description' => 'Check with your hosting. Need this for when you send mail vai SMTP',
	'data' => ''
));
$sql->insert('form_settings',array(
	'meta' => 'smtp-security',
	'value' => '',
	'description' => 'Use ssl, tls, or none. Need this for when you send mail vai SMTP',
	'data' => ''
));
$sql->insert('form_settings',array(
	'meta' => 'mail-host',
	'value' => '',
	'description' => 'Usually mail.yourdomain.com. Need this for when you send mail vai SMTP',
	'data' => ''
));
$sql->insert('form_settings',array(
	'meta' => 'send-mail',
	'value' => '',
	'description' => 'Default e-mail address to send mail from. Could use noreply@yourdomain.com',
	'data' => ''
));
$sql->insert('form_settings',array(
	'meta' => 'send-mail-pass',
	'value' => '',
	'description' => 'To send mail via SMTP. If empty, standard phpmail method wil be used.',
	'data' => ''
));
$sql->insert('form_settings',array(
	'meta' => 'google-recaptcha-site-key',
	'value' => '',
	'description' => 'Please check in your reCAPTCHA admin',
	'data' => ''
));
$sql->insert('form_settings',array(
	'meta' => 'google-recaptcha-secret-key',
	'value' => '',
	'description' => 'Please check in your reCAPTCHA admin',
	'data' => ''
));
$sql->insert('form_settings',array(
	'meta' => 'google-recaptcha-version',
	'value' => '',
	'description' => 'Use v2, invisible, andriod, etc. Please check what type it is in your reCAPTCHA admin',
	'data' => ''
));
// Create Application Plugins Table
$sql->create('plugins', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'plugin' => 'VARCHAR(150) NOT NULL UNIQUE KEY',
	'level' => 'VARCHAR(255) NOT NULL',
	'relations' => 'VARCHAR(255) NOT NULL',
	'active' => 'TINYINT(150) NOT NULL',
	'version' => 'VARCHAR(15) NOT NULL'
));
// Create Application Users Table
$sql->create('users', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'email' => 'VARCHAR(150) NOT NULL UNIQUE KEY',
	'fname' => 'VARCHAR(150) NOT NULL',
	'lname' => 'VARCHAR(150) NOT NULL',
	'salt' => 'VARCHAR(14) NOT NULL',
	'password' => 'VARCHAR(95) NOT NULL',
	'sid' => 'VARCHAR(100) NOT NULL',
	'username' => 'VARCHAR(50) NOT NULL UNIQUE KEY',
	'gender' => 'TINYINT(1) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL',
	'created' => 'DATETIME',
	'exp_token' => 'DATETIME',
	'updated_user' => 'INT(14) NOT NULL',
	'updated_date' => 'DATETIME',
	'keep' => 'VARCHAR(120) NOT NULL'
));
// Create Application User Company Table
$sql->create('user_company', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'company_name' => 'VARCHAR(255) NOT NULL',
	'company_address' => 'VARCHAR(255) NOT NULL',
	'company_telephone' => 'VARCHAR(25) NOT NULL',
));
// Version 1.1
$sql->alter('user_company', array(
	'add' => array(
		'column' => 'company_image',
		'type' => 'VARCHAR(255) NOT NULL'
	)
));
$sql->alter('user_company', array(
	'add' => array(
		'column' => 'company_description',
		'type' => 'TEXT NOT NULL'
	)
));
$sql->alter('user_company', array(
	'add' => array(
		'column' => 'company_logo',
		'type' => 'VARCHAR(255) NOT NULL'
	)
));
// Create Application User Relations Table
$sql->create('user_relations', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'user_id' => 'INT(14) NOT NULL',
	'role_level' => 'DECIMAL(4,1) NOT NULL',
	'user_group' => 'INT(14) NOT NULL',
	'user_company' => 'INT(14) NOT NULL'
));

$sql->insert('user_relations',array(
	'user_id' => 1,
	'role_level' => 100
));

// Create Application User roles Table
$sql->create('user_roles', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'role_name' => 'TEXT',
	'role_level' => 'DECIMAL(4,1) NOT NULL'
));

$sql->insert('user_roles',array(
	'role_name' => '[:en:]Superhero[:nl:]Superheld[::]',
	'role_level' => 100
));
$sql->insert('user_roles',array(
	'role_name' => '[:en:]Super Administrator[:nl:]Super Beheerder[::]',
	'role_level' => 60
));
$sql->insert('user_roles',array(
	'role_name' => '[:en:]Administrator[:nl:]Beheerder[::]',
	'role_level' => 8
));
$sql->insert('user_roles',array(
	'role_name' => '[:en:]Manager[:nl:]Manager[::]',
	'role_level' => 5
));
$sql->insert('user_roles',array(
	'role_name' => '[:en:]User[:nl]:Gebruiker[::]',
	'role_level' => 1
));