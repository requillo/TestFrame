<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends Controller {
	function __construct() {
		parent::__construct();
	}

	function admin_index() {
		
	}

	function admin_get_file($file = NULL){
		$app = App::config('app');
		$mediafile = $app['media-protect'].'media.php';
		include_once($mediafile);
		if($file != NULL) {
			$file = str_replace('-', '/', $file);
			$file = rtrim($file,'/');
			$getext = explode('.', $file);
			$ext =  strtolower(end($getext));
			$getfile = MEDIA_PATH.'/media/uploads/'.$file;
			if(file_exists($getfile)) {
				if($ext == 'pdf') {
					header("Content-type: application/pdf");
				} else if ($ext == 'jpg' || $ext == 'jpeg') {
					header("Content-type: image/jpeg");
				} else if ($ext == 'png') {
					header("Content-type: image/png");
				} else if ($ext == 'gif') {
					header("Content-type: image/gif");
				}
				 readfile($getfile);
			}
		}
		die();
	}

	function token_protected_file($file = NULL){
		// error_reporting(0);
		$app = App::config('app');
		$mediafile = $app['media-protect'].'media.php';
		include_once($mediafile);
		if(isset($_GET['request'])){
			$file = $_GET['request'];
		}
		if($file != NULL) {
			$file = str_replace('-', '/', $file);
			$file = rtrim($file,'/');
			$getext = explode('.', $file);
			$ext =  strtolower(end($getext));
			$getfile = MEDIA_PATH.'/media/uploads/'.$file;
			// echo $getfile;
			if(file_exists($getfile)) {
				// echo $getfile;
				if($ext == 'pdf') {
					header("Content-type: application/pdf");
				} else if ($ext == 'jpg' || $ext == 'jpeg') {
					header("Content-type: image/jpeg");
				} else if ($ext == 'png') {
					header("Content-type: image/png");
				} else if ($ext == 'gif') {
					header("Content-type: image/gif");
				}		
				 readfile($getfile);
			}
		}
		die();
	}

}