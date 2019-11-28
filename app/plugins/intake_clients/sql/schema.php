<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$sql->create('intake_registered_clients', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'f_name' => 'VARCHAR(250) NOT NULL',
	'l_name' => 'VARCHAR(250) NOT NULL',
	'company' => 'VARCHAR(300) NOT NULL',
	'address' => 'VARCHAR(250) NOT NULL',
	'telephone' => 'VARCHAR(25) NOT NULL',
	'email' => 'VARCHAR(250) NOT NULL',
	'pub_date' => 'DATETIME',
	'user_id' => 'INT(14) NOT NULL',
	'edit_date' => 'DATETIME',
	'user_id_edit' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('intake', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'intake_number' => 'INT(14) NOT NULL',
	'intake_type' => 'INT(5) NOT NULL',
	'intake_brand' => 'INT(5) NOT NULL',
	'intake_model' => 'VARCHAR(150) NOT NULL',
	'intake_model_charger' => 'VARCHAR(250) NOT NULL',
	'intake_model_charger_doc' => 'VARCHAR(250) NOT NULL',
	'intake_model_extra_doc' => 'VARCHAR(250) NOT NULL',
	'client_id' => 'INT(14) NOT NULL',
	'problem_text' => 'TEXT',
	'work_solving' => 'TEXT',
	'pub_date' => 'DATETIME',
	'user_id' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('intake_types', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'product_type' => 'VARCHAR(150) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('intake_brands', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'product_brand' => 'VARCHAR(150) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('intake_settings', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'meta' => 'VARCHAR(150) NOT NULL',
	'value' => 'TEXT',
	'type' => 'VARCHAR(10) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->insert('intake_settings',array(
	'meta' => 'intake_header_text',
	'type' => 'text',
	'status' => 1
));

$sql->insert('intake_settings',array(
	'meta' => 'intake_footer_text',
	'type' => 'text',
	'status' => 1
));

$sql->insert('intake_settings',array(
	'meta' => 'intake_limit',
	'type' => 'number',
	'value' => '10',
	'status' => 1
));

// Version 1.35 update
$sql->create('intake_invoices', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'intake_id' => 'INT(14) NOT NULL',
	'invoice_total' => 'VARCHAR(150) NOT NULL',
	'invoice_total_taxed' => 'VARCHAR(150) NOT NULL',
	'invoice_tax' => 'VARCHAR(150) NOT NULL',
	'invoice_wo' => 'VARCHAR(150) NOT NULL',
	'invoice_ref' => 'VARCHAR(150) NOT NULL',
	'invoice_type' => 'VARCHAR(150) NOT NULL',
	'tax_add' => 'TINYINT(1) NOT NULL',
	'invoice_status' => 'TINYINT(1) NOT NULL',
	'invoiced_date' => 'DATETIME',
	'pub_date' => 'DATETIME',
	'user_id' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('intake_invoice_assets', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'intake_id' => 'INT(14) NOT NULL',
	'invoice_amount' => 'INT(5) NOT NULL',
	'invoice_data' => 'TEXT NOT NULL',
	'invoice_price' => 'VARCHAR(150) NOT NULL',
	'invoice_type' => 'TINYINT(1) NOT NULL',
	'pub_date' => 'DATETIME',
	'user_id' => 'INT(14) NOT NULL',
	'edit_date' => 'DATETIME',
	'user_id_edit' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('intake_invoice_payments', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'intake_id' => 'INT(14) NOT NULL',
	'payment_data' => 'TEXT NOT NULL',
	'payment' => 'VARCHAR(150) NOT NULL',
	'pub_date' => 'DATETIME',
	'user_id' => 'INT(14) NOT NULL',
	'edit_date' => 'DATETIME',
	'user_id_edit' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('intake_history', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'intake_table' => 'VARCHAR(150) NOT NULL',
	'intake_table_id' => 'INT(14) NOT NULL',
	'intake_table_data' => 'TEXT NOT NULL',
	'edit_type' => 'VARCHAR(10) NOT NULL',
	'edit_date' => 'DATETIME',
	'user_id_edit' => 'INT(14) NOT NULL'
));

$sql->insert('intake_settings',array(
	'meta' => 'intake_invoice_tax',
	'type' => 'number',
	'value' => '8',
	'status' => 1
));

$sql->insert('intake_settings',array(
	'meta' => 'company_name',
	'type' => 'text',
	'value' => 'Name of company ...',
	'status' => 1
));

$sql->insert('intake_settings',array(
	'meta' => 'invoice_currencies',
	'type' => 'text',
	'value' => 'SRD,USD',
	'status' => 1
));

$sql->insert('intake_settings',array(
	'meta' => 'invoice_types',
	'type' => 'text',
	'value' => 'Labour, Quotation',
	'status' => 1
));

$sql->alter('intake',array(
	'add' => array(
		'column' => 'intake_add_invoice',
		'type' => 'TINYINT(1) NOT NULL'
	)
));

$sql->alter('intake',array(
	'add' => array(
		'column' => 'intake_add_done_doc',
		'type' => 'VARCHAR(150) NOT NULL'
	)
));