<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Message 
{
	public static $required = '';
	public static function flash($message,$class = NULL){
		if(isset($_SESSION['flash'])){
			unset($_SESSION['flash']);	
		}
		if($class == NULL){

		$flash = '<div class="msg alertmsg"><div class="inner-msg the-msg">'.$message.'</div></div>';	

		} else {
			$flash = '<div class="msg alertmsg '.$class.'"><div class="inner-msg the-msg">'.$message;
			$flash .= '</div></div>';			
		}			
	$_SESSION['flash']['message'] = $flash;
	$_SESSION['flash']['error'] = self::$required;		
	}
	
	public static function show_flash(){
		if(isset($_SESSION['flash'])){
			echo $_SESSION['flash']['message'];		
		} 
		if(isset($_SESSION['flash-count'])){
			$_SESSION['flash-count'] = $_SESSION['flash-count'] + 1;
		}
		if(isset($_SESSION['flash-count'])) {
			if($_SESSION['flash-count'] > 2) {
				unset($_SESSION['flash']);
				unset($_SESSION['flash-count']);
			}	
		} else {
			 unset($_SESSION['flash']);
		}	
	}

	public static function form_error(){
		if(isset($_SESSION['flash']['error'])) {
			return $_SESSION['flash']['error'];
		}
	}
	
}
