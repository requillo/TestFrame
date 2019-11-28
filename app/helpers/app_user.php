<?php 
defined('DB_ADMIN_USER_NOT_FOUND') OR exit('No direct script access allowed');

if(!empty($_POST) && isset($_POST['appuser']) && isset($_POST['appuserpass'])){
$model = new model;
$username = $_POST['appuser'];
$pass = $_POST['appuserpass'];
$status = 1;
$sql = "INSERT INTO ".PRE."users (salt,password,username,status,created) 
	VALUES (:salt, :password, :username, :status, :created)";
$stmt = $model->pdo->prepare($sql);
$salt = $model->generateRandomString();
$saltedpass = $model->passcrypt($pass, $salt);
$date = date('Y-m-d H:i:s');
$stmt->bindParam(':salt', $salt);
$stmt->bindParam(':password', $saltedpass);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':status', $status);
$stmt->bindParam(':created', $date);
$stmt->execute();
$user_id = $model->pdo->lastInsertId();
	if($user_id) {
		$data['class'] = 'success';
		$data['message'] = $ai['user-created'];
	} else {
		$data['class'] = 'error';
		$data['message'] = $ai['user-created-error'];
	}
sleep(2);
echo json_encode($data);
} else {
	$app_user = $app['views-path'].'install/app_user.php';
	if(file_exists($app_user)) {
		include($app_user);
	}
}