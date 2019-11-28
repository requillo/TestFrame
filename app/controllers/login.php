<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Login extends Controller
{
	var $components = 'test';
	function __construct()
	{
		parent::__construct();
	}
	// Delete later
	function rest_login(){
		$inputJSON = Rest::request();
    	 if(!empty($inputJSON)) {
    		echo $this->login->rest_user_login($inputJSON['username'],$inputJSON['password']);
    	}
	}
	// For the login page
	function login($arg = NULL){

		if($arg == NULL) {
			$this->view->render('Login','login');
		} else {
			$this->view->render('Login','login',$arg);
		}
		
		if(!empty($this->data)){
			if(isset($this->data['pass'])) {
				$this->login->user_login($this->data['user'],$this->data['pass'], $this->data['link'],$this->data['keep']);
			}

		}

	}
}