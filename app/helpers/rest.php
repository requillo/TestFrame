<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* The helper class for Authentication of users. Check is user is logged in. This is used for the website area
*/
class Rest
{

	static function request(){
		$inputJSON = file_get_contents('php://input');
		if (is_object(json_decode($inputJSON)))	{
        $input = json_decode($inputJSON, TRUE); //convert JSON into array
        return $input;
    	} else if(!empty($_POST)) {
    	return $_POST;
    	}

	}

	static function is_valid($input) {
		if(isset($input['token'])) {
			$input['check_token'] = token($input['id'].$input['username'].$input['special']);
			if($input['check_token'] == $input['token']) {
				return true;
			} else {
				return false;
			}
		}
		
	}

	public function xml($class,$method,$attr = NULL){

	}

}