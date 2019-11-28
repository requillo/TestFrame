<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
/**
* The helper class for Authentication of users. Check is user is logged in. This is used for the website area
*/
class Auth
{
	public function usenow(){
		if(isset($_SESSION['loggedin']['id'])){
			$this->id = $_SESSION['loggedin']['id'];
		} else {
			$app = App::config('app');
			header('Location: '.URL.$app['user-login']);
		}
	}
}