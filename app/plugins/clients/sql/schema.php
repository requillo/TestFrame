<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$query1 = "CREATE TABLE IF NOT EXISTS ".PRE."clients(
id INT(14) AUTO_INCREMENT PRIMARY KEY,
id_number VARCHAR(20) NOT NULL,
f_name VARCHAR(250) NOT NULL,
l_name VARCHAR(250) NOT NULL,
email VARCHAR(250) NOT NULL,
profile_picture VARCHAR(250) NOT NULL,
telephone VARCHAR(250) NOT NULL,
address VARCHAR(250) NOT NULL,
city VARCHAR(250) NOT NULL,
district VARCHAR(250) NOT NULL,
country VARCHAR(250) NOT NULL,
nationality VARCHAR(250) NOT NULL,
company VARCHAR(250) NOT NULL,
position VARCHAR(250) NOT NULL,
date_of_birth DATE,
gender TINYINT(2),
active TINYINT(2),
edit_date DATETIME,
user_id INT(14) NOT NULL
)";

$query2 = "CREATE TABLE IF NOT EXISTS ".PRE."clients_visas(
id INT(14) AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(250) NOT NULL,
start_date DATE,
end_date DATE,
copy_document VARCHAR(250) NOT NULL,
client_id INT(14),
edit_date DATETIME,
user_id INT(14) NOT NULL,
reminder INT(1) NOT NULL,
status INT(1) NOT NULL,
message_sent TINYINT(1)
)";

$query3 = "CREATE TABLE IF NOT EXISTS ".PRE."clients_meta(
id INT(14) AUTO_INCREMENT PRIMARY KEY,
setting_id INT(14) NOT NULL,
value VARCHAR(250) NOT NULL,
l_value TEXT,
client_id INT(14),
edit_date DATETIME,
user_id INT(14) NOT NULL
)";

$query4 = "CREATE TABLE IF NOT EXISTS ".PRE."clients_settings(
id INT(14) AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(250) NOT NULL,
value VARCHAR(250) NOT NULL,
setting VARCHAR(250) NOT NULL,
status VARCHAR(10) NOT NULL
)";

$query5 = "CREATE TABLE IF NOT EXISTS ".PRE."clients_passports(
id INT(14) AUTO_INCREMENT PRIMARY KEY,
passport_number VARCHAR(250) NOT NULL,
passport_type TINYINT(1) NOT NULL,
start_date DATE,
end_date DATE,
copy_document VARCHAR(250) NOT NULL,
client_id INT(14),
edit_date DATETIME,
user_id INT(14) NOT NULL,
reminder INT(1) NOT NULL,
status INT(1) NOT NULL,
message_sent TINYINT(1)
)";

$query6 = "CREATE TABLE IF NOT EXISTS ".PRE."clients_tickets(
id INT(14) AUTO_INCREMENT PRIMARY KEY,
ticket_number VARCHAR(250) NOT NULL,
ticket_type VARCHAR(250) NOT NULL,
destination TEXT,
start_date DATE,
end_date DATE,
currency VARCHAR(10) NOT NULL,
amount VARCHAR(10) NOT NULL,
copy_document VARCHAR(250) NOT NULL,
client_id INT(14),
edit_date DATETIME,
user_id INT(14) NOT NULL,
travel_status TINYINT(3) NOT NULL,
status INT(1) NOT NULL,
message_sent TINYINT(1)
)";

$query7 = "CREATE TABLE IF NOT EXISTS ".PRE."clients_memberships(
id INT(14) AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(250) NOT NULL,
member_number VARCHAR(250) NOT NULL,
salt VARCHAR(25) NOT NULL,
password TEXT,
client_id INT(14),
edit_date DATETIME,
user_id INT(14) NOT NULL,
status TINYINT(1)
)";

$query8 = "CREATE TABLE IF NOT EXISTS ".PRE."clients_insurance(
id INT(14) AUTO_INCREMENT PRIMARY KEY,
company VARCHAR(250) NOT NULL,
travel_area TINYINT(1) NOT NULL,
ipnumber VARCHAR(250) NOT NULL,
number VARCHAR(250) NOT NULL,
insurance_type TINYINT(1) NOT NULL,
final_destination VARCHAR(250) NOT NULL,
start_date DATE,
end_date DATE,
travel_reason TINYINT(1) NOT NULL,
country_of_origin VARCHAR(250) NOT NULL,
cuba TINYINT(1),
status TINYINT(1)
)";

$sql->query($query1);
$sql->query($query2);
$sql->query($query3);
$sql->query($query4);
$sql->query($query5);
$sql->query($query6);
$sql->query($query7);
$sql->query($query8);

$insert1 = "INSERT INTO ".PRE."clients_settings (name, value)
			VALUES ('clients_per_page','20')";
$insert2 = "INSERT INTO ".PRE."clients_settings (name, value)
			VALUES ('visa_expire_reminder','20')";
$insert3 = "INSERT INTO ".PRE."clients_settings (name, value)
			VALUES ('passport_expire_reminder','20')";
$sql->query($insert1);
$sql->query($insert2);
$sql->query($insert3);