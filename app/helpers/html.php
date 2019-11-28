<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Html
{
	public function css($file){		
			echo "<link href=\"$file\" rel=\"stylesheet\">\n";
	}

	public function js($file){
			echo "<script type=\"text/javascript\" src=\"$file\"></script>\n";
	}

	public function link($name, $link, $arg = NULL){
		$link = ltrim($link,'/');
		$link = rtrim($link,'/');
		if(is_string ($arg)){
			$class = 'class="'.$arg.'"';
		} else if(is_array($arg)) {
			$class = 'class="'.$arg['class'].'"';
		} else {
			$class = '';
		}

		if(DEFAULT_LANG_ALIAS == LANG_ALIAS) {
			return '<a href="'.URL.$link.'/" '.$class.'>'.$name.'</a>'."\n";	
		} else {
			return '<a href="'.URL.LANG_ALIAS.$link.'/" '.$class.'>'.$name.'</a>'."\n";
		}

		

	}

	public function admin_link($name, $link, $arg = NULL){
		$link = ltrim($link,'/');
		$link = rtrim($link,'/');
		if(!empty($link)) {
			$link = $link.'/';
		}
		if(is_string ($arg)){
			$class = 'class="'.$arg.'"';
			$target = '';
		} else if(is_array($arg)) {
			if(isset($arg['class'])) {
				$class = 'class="'.$arg['class'].'"';
			} else {
				$class = '';
			}
			if(isset($arg['target'])){
				$target = 'target="'.$arg['target'].'"';
			} else {
				$target = '';
			}
			
			
		} else {
			$class = '';
			$target = '';
		}

		if(DEFAULT_LANG_ALIAS == LANG_ALIAS) {
			return '<a href="'.URL.BACKEND_URL.$link.'" '.$class.' '.$target.'>'.$name.'</a>'."\n";
		} else {
			return '<a href="'.URL.LANG_ALIAS.BACKEND_URL.$link.'" '.$class.' '.$target.'>'.$name.'</a>'."\n";
		}
			
	}


}