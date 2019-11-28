<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$sql->create('donations', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'person_id' => 'INT(14) NOT NULL',
	'foundation_id' => 'INT(14) NOT NULL',
	'title' => 'VARCHAR(350) NOT NULL',
	'description' => 'TEXT NOT NULL',
	'extra_description' => 'TEXT NOT NULL',
	'added_description' => 'TEXT NOT NULL',
	'cash_description' => 'TEXT NOT NULL',
	'cash_amount' => 'VARCHAR(25) NOT NULL',
	'currency' => 'TINYINT(1) NOT NULL',
	'amount' => 'VARCHAR(25) NOT NULL',
	'max_amount' => 'VARCHAR(25) NOT NULL',
	'approval' => 'TINYINT(1) NOT NULL',
	'reason' => 'TEXT NOT NULL',
	'error_msg' => 'VARCHAR(450) NOT NULL',
	'pos_double_donation' => 'VARCHAR(450) NOT NULL',
	'recurring' => 'TINYINT(2) NOT NULL',
	'recurring_id' => 'INT(14) NOT NULL',
	'hi_reason' => 'VARCHAR(450) NOT NULL',
	'hi_approval' => 'TINYINT(1) NOT NULL',
	'hi_approval_user' => 'INT(14) NOT NULL',
	'hi_approval_updated' => 'DATETIME',
	'donation_within' => 'TINYINT(2) NOT NULL',
	'donated_company' => 'INT(14) NOT NULL',
	'donation_type' => 'VARCHAR(150) NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated' => 'DATETIME',
	'updated_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('donation_persons', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'first_name' => 'VARCHAR(250) NOT NULL',
	'last_name' => 'VARCHAR(250) NOT NULL',
	'full_name' => 'VARCHAR(450) NOT NULL',
	'person_address' => 'VARCHAR(300) NOT NULL',
	'person_telephone' => 'VARCHAR(250) NOT NULL',
	'person_email' => 'VARCHAR(250) NOT NULL',
	'id_number' => 'VARCHAR(250) NOT NULL',
	'same' => 'VARCHAR(300) NOT NULL',
	'overwrite_same' => 'TINYINT(1) NOT NULL',
	'overwrite_same_hi' => 'TINYINT(1) NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated' => 'DATETIME',
	'updated_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('donation_foundation', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'foundation_name' => 'VARCHAR(250) NOT NULL',
	'foundation_address' => 'VARCHAR(250) NOT NULL',
	'foundation_telephone' => 'VARCHAR(300) NOT NULL',
	'foundation_email' => 'VARCHAR(250) NOT NULL',
	'fsame' => 'VARCHAR(300) NOT NULL',
	'foverwrite_same' => 'TINYINT(1) NOT NULL',
	'foverwrite_same_hi' => 'TINYINT(1) NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated' => 'DATETIME',
	'updated_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('donation_person_foundation_relations', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'person_id' => 'INT(14) NOT NULL',
	'foundation_id' => 'INT(14) NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated' => 'DATETIME',
	'updated_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('donation_assets', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'type' => 'INT(5) NOT NULL',
	'company_id' => 'INT(5) NOT NULL',
	'description' => 'VARCHAR(250) NOT NULL',
	'price' => 'VARCHAR(300) NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated' => 'DATETIME',
	'updated_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('donation_documents', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'donation_id' => 'VARCHAR(250) NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated' => 'DATETIME',
	'updated_user' => 'INT(14) NOT NULL',
	'document' => 'VARCHAR(250) NOT NULL'
));

$sql->create('donation_history', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'donation_table' => 'VARCHAR(250) NOT NULL',
	'donation_old_data' => 'TEXT NOT NULL',
	'donation_new_data' => 'TEXT NOT NULL',
	'donation_info' => 'VARCHAR(250) NOT NULL',
	'updated' => 'DATETIME',
	'updated_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->create('donation_settings', array(
	'id' => 'INT(14) AUTO_INCREMENT PRIMARY KEY',
	'meta' => 'VARCHAR(250) NOT NULL',
	'value' => 'VARCHAR(250) NOT NULL',
	'description' => 'VARCHAR(450) NOT NULL',
	'type' => 'VARCHAR(300) NOT NULL',
	'reorder' => 'INT(3) NOT NULL',
	'created' => 'DATETIME',
	'created_user' => 'INT(14) NOT NULL',
	'updated' => 'DATETIME',
	'updated_user' => 'INT(14) NOT NULL',
	'status' => 'TINYINT(1) NOT NULL'
));

$sql->insert('donation_settings',array(
	'meta' => 'max_amount',
	'description' => 'Max amount for standard approval in SRD',
	'type' => 'number',
	'value' => '5000',
	'reorder' => 1,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'donation_types',
	'description' => 'Add types like: Cash = 1, Products = 2, Services = 3',
	'type' => 'text',
	'value' => 'Cash = 1, Products = 2, Services = 3',
	'reorder' => 2,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'mail_host',
	'description' => 'Could be mail.yourapp.com (check with your hosting)',
	'type' => 'text',
	'value' => '',
	'reorder' => 3,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'sent_mail',
	'description' => 'E-mail address to sent mail from',
	'type' => 'text',
	'value' => 'noreply@thisapp.com',
	'reorder' => 4,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'sent_mail_password',
	'description' => 'E-mail address password for sent mail',
	'type' => 'text',
	'value' => 'P@$w0orD',
	'reorder' => 5,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'smpt_port',
	'description' => 'Use 25 or 26 or 587 (check with your hosting)',
	'type' => 'text',
	'value' => '26',
	'reorder' => 6,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'smpt_security',
	'description' => 'ssl, tls, none. (check with your hosting)',
	'type' => 'text',
	'value' => 'none',
	'reorder' => 7,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'approval_email_account',
	'description' => 'HI approval e-mail accounts like: ceo@thisapp.com;manager@thisapp.com;finance@thisapp.com',
	'type' => 'text',
	'reorder' => 8,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'reminder_email_account',
	'description' => 'To remind HI approval e-mail accounts like: secretary@thisapp.com;info@thisapp.com',
	'type' => 'text',
	'reorder' => 9,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'IC_email_account',
	'description' => 'For finance double check who adds products like: cfo@thisapp.com;finance@thisapp.com',
	'type' => 'text',
	'reorder' => 10,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'reminder_approval',
	'description' => 'How many days should pass to sent a reminder for approval on donations',
	'type' => 'number',
	'value' => '2',
	'reorder' => 6,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'reminder_upcomming_recurring_donation',
	'description' => 'How many days before recurring donation to sent a reminder',
	'type' => 'number',
	'value' => '2',
	'reorder' => 6,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'on_error_sent_mail',
	'description' => 'Use "1" to sent mail on errors',
	'type' => 'number',
	'value' => 2,
	'reorder' => 11,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'limit_months',
	'description' => 'Limit on donations within a month or months',
	'type' => 'number',
	'value' => 1,
	'reorder' => 12,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'within_months',
	'description' => 'Within how many months',
	'type' => 'number',
	'value' => 2,
	'reorder' => 13,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'limit_years',
	'description' => 'Limit on donations within a year or years',
	'type' => 'number',
	'value' => 4,
	'reorder' => 14,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'within_years',
	'description' => 'Within how many years',
	'type' => 'number',
	'value' => 1,
	'reorder' => 15,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'year_start',
	'description' => 'Use 1 to start looking year at january first or use 2 to start looking at current date one year ago.',
	'type' => 'number',
	'value' => 1,
	'reorder' => 16,
	'status' => 1
));

$sql->insert('donation_settings',array(
	'meta' => 'view_max_results',
	'description' => 'The limit of donations per page or search results',
	'type' => 'number',
	'value' => '10',
	'reorder' => 17,
	'status' => 1
));

// Update 3.2

$sql->alter('donation_persons',array(
	'add' => array(
		'column' => 'black_listed',
		'type' => 'TINYINT(1) NOT NULL'
	)
));

$sql->alter('donation_persons',array(
	'add' => array(
		'column' => 'ch_js',
		'type' => 'TINYINT(1) NOT NULL'
	)
));

$sql->alter('donation_persons',array(
	'add' => array(
		'column' => 'black_listed_reason',
		'type' => 'VARCHAR(350) NOT NULL'
	)
));

$sql->alter('donation_foundation',array(
	'add' => array(
		'column' => 'black_listed',
		'type' => 'TINYINT(1) NOT NULL'
	)
));

$sql->alter('donation_foundation',array(
	'add' => array(
		'column' => 'ch_js',
		'type' => 'TINYINT(1) NOT NULL'
	)
));

$sql->alter('donation_foundation',array(
	'add' => array(
		'column' => 'black_listed_reason',
		'type' => 'VARCHAR(350) NOT NULL'
	)
));

$sql->alter('donation_history',array(
	'add' => array(
		'column' => 'meta_data',
		'type' => 'VARCHAR(350) NOT NULL'
	)
));

$sql->alter('donation_history',array(
	'add' => array(
		'column' => 'ref_id',
		'type' => 'INT(14) NOT NULL'
	)
));

/*
$sql->alter('donations', array(
	'relation' => array(
		'column' => 'person_id', 
		'rel-table' => 'donation_persons',
		'rel-column' => 'id'
	)
));

$sql->alter('donation_person_foundation_relations', array(
	'relation' => array(
		'column' => 'person_id', 
		'rel-table' => 'donation_persons',
		'rel-column' => 'id'
	)
));

$sql->alter('donation_person_foundation_relations', array(
	'relation' => array(
		'column' => 'foundation_id', 
		'rel-table' => 'donation_foundation',
		'rel-column' => 'id'
	)
)); donation_persons
*/ 

// Update 3.3

$sql->alter('donation_persons',array(
	'add' => array(
		'column' => 'id_type',
		'type' => 'TINYINT(1) NOT NULL'
	)
));

$sql->alter('donation_persons',array(
	'add' => array(
		'column' => 'scanned_doc',
		'type' => 'VARCHAR(250) NOT NULL'
	)
));

// Update 3.4 donation_assets

$sql->alter('donation_assets',array(
	'add' => array(
		'column' => 'item_number',
		'type' => 'VARCHAR(250) NOT NULL'
	)
));

$sql->alter('donation_assets',array(
	'add' => array(
		'column' => 'unit',
		'type' => 'VARCHAR(250) NOT NULL'
	)
));