<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Enqueue
{

	public function __construct($theme = ''){
		$app = App::config('app');
		$this->path_url = $theme;		
		$this->assets = URL.str_replace(BASEPATH, '', $app['assets-path']);
		$this->header_style = array();
		$this->footer_style = array();
		$this->header_script = array();
		$this->footer_script = array();

	}

	public function style($style){
			array_push($this->header_style, '<link href="'.$this->path_url.'/'.$style.'" rel="stylesheet">');	
	}
	public function script($script,$pos = 'header'){
		if($pos == 'header') {
			array_push($this->header_script, '<script src="'.$this->path_url.'/'.$script.'"></script>');
		} else if($pos == 'footer') {
			array_push($this->footer_script, '<script src="'.$this->path_url.'/'.$script.'"></script>');
		}
	}

	public function app_style($style,$pos = 'header'){
			array_push($this->header_style, '<link href="'.URL.$style.'" rel="stylesheet">');
	}

	public function app_script($script,$pos = 'header'){
		if($pos == 'header') {
			array_push($this->header_script, '<script src="'.URL.$script.'"></script>');
		} else if($pos == 'footer') {
			array_push($this->footer_script, '<script src="'.URL.$script.'"></script>');
		}	
	}

	public function assets($type,$file,$pos = 'header'){
		if($type == 'css') {
				array_push($this->header_style, '<link href="'.$this->assets.$file.'" rel="stylesheet">');
			}

		if($pos == 'header') {
			if($type == 'js') {
				array_push($this->header_script, '<script src="'.$this->assets.$file.'"></script>');
			}

		} else if($pos == 'footer'){
			if($type == 'js') {
				array_push($this->footer_script, '<script src="'.$this->assets.$file.'"></script>');
			} 

		}
		
	}
}