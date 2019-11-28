<?php 
defined('DB_IS_NOT_INSTALLED') OR exit('No direct script access allowed');

$sql = new sql;
$sql_file = $app['app-path'].'config/sql/schema.php';
if(file_exists($sql_file)){
	include($sql_file);
	$tables = $sql->db;
	$model = new model;

	foreach ($tables as $table) {
				if(isset($table['sql'])) {
					$model->pdo->exec($table['sql']);
				} else if(isset($table['insert'])){
					$model->pdo->exec($table['insert']);
				} else if(isset($table['alter'])) {
					$model->pdo->exec($table['alter']);
				} else if(isset($table['alterdb'])) {
					$model->pdo->exec($table['alterdb']);
				} else if(isset($table['add'])) {
					$model->pdo->exec($table['add']);
				}
			}
	$data['message'] = $ai['app-install-success'];
	$data['class'] = 'success';
	sleep(1);
	echo json_encode($data);
}