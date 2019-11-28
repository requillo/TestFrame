<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$db['host'] = 'localhost';
$db['user'] = 'root';
$db['pass'] = '';
$db['name'] = 'requillo_newapp';
$db['pre'] = '4xm_';
$db['type'] = 'mysql';
if($db['type'] == 'mysql') {
// mysql:host=localhost;dbname=db_name
$db['connect'] = 'mysql:host='.$db['host'].';dbname='.$db['name'];
} else if($db['type'] == 'db2') {
// ibm:DRIVER={IBM DB2 ODBC DRIVER};DATABASE=testdb;HOSTNAME=localhost;PORT=56789;PROTOCOL=TCPIP;
$db['connect'] = 'ibm:DRIVER={IBM DB2 ODBC DRIVER};DATABASE='.$db['name'].';HOSTNAME='.$db['host'].';PORT=56789;PROTOCOL=TCPIP;';
} else if($db['type'] == 'postgre') {
// pgsql:dbname=db_name;host=localhost
$db['connect'] = 'pgsql:host='.$db['host'].';dbname='.$db['name'];
}