<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$query1 = "CREATE TABLE IF NOT EXISTS ".PRE."rubrieken(
id INT(14) AUTO_INCREMENT PRIMARY KEY,
id_number VARCHAR(20) NOT NULL,
f_name VARCHAR(250) NOT NULL,
l_name VARCHAR(250) NOT NULL,
telephone VARCHAR(25) NOT NULL,
talli VARCHAR(20) NOT NULL,
talli_year DATE NOT NULL,
pub_date DATETIME,
user_id INT(14) NOT NULL,
edit_date DATETIME,
user_id_edit INT(14) NOT NULL,
status TINYINT(1) NOT NULL
)";

$query2 = "CREATE TABLE IF NOT EXISTS ".PRE."rubrieken_advertisements(
id INT(14) AUTO_INCREMENT PRIMARY KEY,
advertisement TEXT NOT NULL,
client_id INT(14) NOT NULL,
rubriek_category INT(5) NOT NULL,
chars INT(5) NOT NULL,
chars_lim INT(5) NOT NULL,
price VARCHAR(20) NOT NULL,
dates TEXT NOT NULL,
status TINYINT(1) NOT NULL
)";

$query3 = "CREATE TABLE IF NOT EXISTS ".PRE."rubrieken_settings(
id INT(14) AUTO_INCREMENT PRIMARY KEY,
meta VARCHAR(20) NOT NULL,
name VARCHAR(20) NOT NULL,
value TEXT NOT NULL,
status TINYINT(1) NOT NULL
)";

$query4 = "CREATE TABLE IF NOT EXISTS ".PRE."rubrieken_categories(
id INT(14) AUTO_INCREMENT PRIMARY KEY,
category_name VARCHAR(250) NOT NULL,
status TINYINT(1) NOT NULL
)";

$sql->query($query1);
$sql->query($query2);
$sql->query($query3);
$sql->query($query4);