<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class View
{
	public $class;
	public $method;
	public $var;
	public $theme_path;
	public $views_path;
	public $plugins_path;
	public $render;
	public $error;
	public $dashboard;

	public function __construct(){
		$app = App::config('app');
		$this->theme_path = $app['themes-path'];
		$this->views_path = $app['views-path'];
		$this->plugins_path = $app['plugins-path'];
		$this->webtheme_path = $app['webthemes-path'];
	}

	public function render($class, $method,$arg = NULL){
		if($arg == NULL) {
			$arg['theme'] = '';
			$arg['appname'] = '';
		}
		
		// Replace string for nice urls
		$class = str_replace('-', '_', $class);
		$form = new Form;
		$html = new Html;
		// Vars
		$themepath = str_replace(BASEPATH, URL, $this->theme_path.$arg['theme']);
		$appname = $arg['appname'];
		$applogo = $arg['applogo'];
		$appicon = $arg['appicon'];
		
		$file1 = strtolower($this->theme_path.$arg['theme'].'/views/'.$class.'/'.$method.'.php');
		$file2 = strtolower($this->views_path.$class.'/'.$method.'.php');
		$file3 = strtolower($this->plugins_path.$class.'/views/'.$method.'.php');
		
		if(file_exists($file1)){
		include($file1);	
		} else if(file_exists($file2 )) {
		include($file2);	
		} else if(file_exists($file3 )){
		include($file3);
		}
		
	}

	public function element($name){

	}

	public function admin_content($args = array()){
		// Show the message if extists
		if(!isset($args['title'])) {
			$args['title'] = true;
		}
		$form = new Form;
		$html = new Html;
		$get = $this->get;
		$appname = $this->appname;
		$applogo = $this->applogo;
		// check if show website is true or false to enable pages in the backend
		if($this->website == 0 && $this->class == 'pages') {
			$this->class = '';
		}
		$file1 = $this->theme_path.$this->admin_theme.'/views/'.$this->class.'/'.$this->method.'.php';
		$file2 = $this->views_path.$this->class.'/'.$this->method.'.php';
		$file3 = $this->plugins_path.$this->class.'/views/'.$this->method.'.php';
		$error1 = $this->theme_path.$this->admin_theme.'/views/admin/error.php';
		$error2 = $this->views_path.'admin/'.'error.php';
		$dashboard1 = $this->theme_path.$this->admin_theme.'/views/admin/dashboard.php';
		$dashboard2 = $this->views_path.'admin/dashboard.php';
		$title = $this->page_title;
		// print_r($this->formdata);
		$form->required = Message::form_error();

		if(file_exists($file3) || file_exists($file2) || file_exists($file1)) {
			if($this->page_title != '' && $args['title'] == true) {
			echo '<div class="container-fluid">' ."\n";
			echo '<div class="page-header">'."\n";			
			echo '<h1>'.$this->page_title.'</h1>'."\n";
			echo '</div>';
			echo '</div>';
			}
		} 		
		if($this->var != NULL){
			extract($this->var);
			if($this->error == 1){
				if(file_exists($error1)){
					include($error1);
				} else {
					include($error2);
				}
			} else if($this->dashboard == 'index'){
				if(file_exists($dashboard1)){
					include($dashboard1);
				} else {
					include($dashboard2);
				}
				
			} else if(file_exists($file1)){
			Message::show_flash();
			include($file1);	
			} else if(file_exists($file2)){
			Message::show_flash();
			include($file2);	
			} else if(file_exists($file3)){
			Message::show_flash();
			include($file3);
			} else {
				if($get->message == '') {
					$errors = new Errors;
					$app = App::config('app');
					if($app['app-debug'] == true){
						$get->message = $errors->no_view($this->class,$this->method);
					}
					
				}
				if(file_exists($error1)){
					include($error1);
				} else {
					include($error2);
				}
			}
		} else {
			if($this->error == 1){
				if(file_exists($error1)){
					include($error1);
				} else {
					include($error2);
				}
			} else if($this->dashboard == 'index'){
				if(file_exists($dashboard1)){
					Message::show_flash();
					include($dashboard1);
				} else {
					Message::show_flash();
					include($dashboard2);
				}
			} else if(file_exists($file1)){
			Message::show_flash();
			include($file1);	
			} else if(file_exists($file2)){
			Message::show_flash();
			include($file2);	
			} else if(file_exists($file3)){
			Message::show_flash();
			include($file3);
			} else {
				if($get->message == '') {
					$errors = new Errors;
					$app = App::config('app');
					if($app['app-debug'] == true){
						$get->message = $errors->no_view($this->class,$this->method);
					}
					
				}
				if(file_exists($error1)){
					include($error1);
				} else {
					include($error2);
				}
			}
		}
	}
	// This is for website
	public function content() {
		Message::show_flash();
		$form = new Form;
		$html = new Html;
		$get = $this->get;
		$appname = $this->appname;
		$applogo = $this->applogo;
		$file1 = $this->webtheme_path.$this->website.'/views/'.$this->class.'/'.$this->method.'.php';
		$file2 = $this->plugins_path.$this->class.'/views/'.$this->method.'.php';
		$error1 = $this->webtheme_path.$this->website.'/error.php';
		$error2 = $this->views_path.'website/'.'error.php';
		$dashboard1 = $this->theme_path.$this->admin_theme.'/views/admin/dashboard.php';
		$dashboard2 = $this->views_path.'admin/dashboard.php';
		$theme_url = URL.'themes/'.$this->website;
		$title = $this->page_title;
		if($this->content != '') {
			echo $this->content;
			echo $this->formhtml;
		} else if(file_exists($file1)){
			include($file1);
		} else if(file_exists($file2)){
			include($file2);
		} else if(file_exists($error1)) {
			include($error1);
		} else {
			include($error2);
		}

	}


	public function theme($file,$arr = NULL){
			$html = new Html;
			$form = new Form;

			if($arr != NULL){
				$get = (object) $arr;
				$this->get = $get;
				$this->class = $arr['class'];
				$this->method = $arr['method'];
				$this->page = $this->class.'/'.str_replace('admin_', '', $arr['method']);
				$this->var = $arr['var'];
				$this->admin_theme = $arr['theme'];
				$this->user = $arr['user'];
				$this->url = $arr['url'];
				$this->page_title = language_content($arr['page-title']);
				$this->error = $arr['error'];
				$this->dashboard = $arr['dashboard'];
				$this->plugins = $arr['plugins'];
				$this->appname = $arr['appname'];
				$this->applogo = $arr['applogo'];
				$this->website = $arr['website'];
				$this->appicon = $arr['appicon'];
				$this->formdata = $arr['formdata'];
				if(isset($arr['formhtml'])) {
					$this->formhtml = $arr['formhtml'];
				} else {
					$this->formhtml = '';
				}
				

				$appname = $this->appname;
				$applogo = $this->applogo;
				$appicon = $this->appicon;
				$title = $this->page_title;
				if(isset($arr['content'])) {
					$this->content = language_content($arr['content']);
				} else {
					$this->content = '';
				}
			}
			$themepath = URL.'app/themes/'.$this->admin_theme;
			$theme_url = URL.'themes/'.$this->website;
			if(file_exists($file)){
				include($file);
			}

		}

	public function admin_part($file_name){
		$html = new Html;
		$form = new Form;
		$themepath = URL.'app/themes/'.$this->admin_theme;
		$appname = $this->appname;
		$applogo = $this->applogo;
		$appicon = $this->appicon;
		$file = $this->theme_path.$this->admin_theme.'/parts/'.$file_name.'.php';
		$title = $this->page_title;
		if(file_exists($file)){
			include($file);
		}
	}

	public function admin_widget_content($arr = NULL){
		$app = App::config('app');
		$html = new Html;
		$form = new Form;
		if($arr != NULL) {
			$this->admin_theme = $arr['admin_theme'];
			$this->class = $arr['class'];
			$this->method = $arr['method'];		
			$file1 = $app['themes-path'].$this->admin_theme.'/views/'.$this->class.'/'.$this->method.'.php';
			$file2 = $app['views-path'].$this->class.'/'.$this->method.'.php';
			$file3 = $app['plugins-path'].$this->class.'/views/'.$this->method.'.php';
			extract($arr['var']);
			if(file_exists($file1)){
				include($file1);
			} else if(file_exists($file2)){
				include($file2);
			} else if(file_exists($file3)){
				include($file3);
			}
		}
		

	}

	public function part($file_name){
		$html = new Html;
		$form = new Form;
		$themepath = URL.'themes/'.$this->website;
		$appname = $this->appname;
		$theme_url = URL.'themes/'.$this->website;
		$file = $this->webtheme_path.$this->website.'/parts/'.$file_name.'.php';
		$title = $this->page_title;
		if(file_exists($file)){
			include($file);
		}
	}

	public function admin_header_scripts($scripts = array()){
		$app = App::config('app');
		$plugin_url = URL.str_replace(BASEPATH, '', $app['plugins-path']);
		$theme_url = URL.str_replace(BASEPATH, '', $app['themes-path']).$this->admin_theme;
		$nav = new Nav;
		$enqueue = new Enqueue($theme_url);
		$model = new model;
		$ct =  $model->option('meta_str',array('name' => 'themes','value' => 'admin_theme'));
		$ts =  $model->option('meta_str, meta_int',array('name' => 'admin_theme','value' => $ct));
		$js_theme_file = '';
		$js_theme_style = '';
		
		if(empty($ts)){
			$theme_style = '';
		} else if($ts['meta_str'] == '') {
			$theme_style = '';
		} else {
			$theme_style = '<link id="add-css" href="'.$theme_url.'/assets/css/'.$ts['meta_str'].'.css?vers'.$ts['meta_int'].'" rel="stylesheet">'."\n";
			$js_theme_file = $app['themes-path'].$ct.'/assets/js/'.$ts['meta_str'].'.js';
		}
		if(file_exists($js_theme_file)) {
			$js_theme_style = '<script id="add-js" src="'.$theme_url.'/assets/js/'.$ts['meta_str'].'.js?vers'.$ts['meta_int'].'" type="text/javascript"></script>'."\n";
		}
		$theme_css = '';
		$theme_js = '<script type="text/javascript">
		var Jsapi = "'.url($app['api-url'].'/json/').'";
		var AdminUrl = "'.admin_url().'";
		var MainUrl = "'.url().'";'."\n";
		$theme_js .= '</script>'."\n";
		$plugin_css = '';
		$plugin_js = '';
		$file = $this->theme_path.$this->admin_theme.'/config.php';
		if(file_exists($file)){
			include($file);
			foreach($enqueue->header_style as $style){
			$theme_css .= $style . "\n";
			}
		}

		if(isset($scripts['jQuery']) && $scripts['jQuery'] == false) {
			// no jquery
		} else {
			$theme_js .= '<script type="text/javascript" src="'.URL.'assets/jquery/jquery.js"></script>'."\n";
		}

		foreach($enqueue->header_script as $script){
			$theme_js .= $script . "\n";
			}

		if($app['show-website'] == true) {
			$theme_js .= '<script type="text/javascript" src="'.URL.'assets/tinymce/tinymce.min.js"></script>'."\n";
			$theme_js .= '<script type="text/javascript" src="'.URL.'assets/nestable/js/nestable.js"></script>'."\n";
			$theme_js .= '<script type="text/javascript" src="'.URL.'assets/jquery-ui/js/jquery-ui.min.js"></script>'."\n";
			$theme_js .= '<script type="text/javascript" src="'.URL.'assets/formbuilder/js/form-builder.min.js"></script>'."\n";
			$theme_js .= '<script type="text/javascript" src="'.URL.'assets/formbuilder/js/form-render.min.js"></script>'."\n";
			$theme_js .= '<script type="text/javascript" src="'.URL.'assets/formbuilder/js/jquery.rateyo.min.js"></script>'."\n";

		}

		foreach ($this->plugins as $plugin) {
			if($plugin != ''){
				$pf = $app['plugins-path'].$plugin['plugin'].'/config.php';
				if(file_exists($pf)) {
					$enqueue = new Enqueue($plugin_url.$plugin['plugin']);
					include($pf);
					foreach($enqueue->header_style as $style){
					$plugin_css .= $style . "\n";
					}
					foreach($enqueue->header_script as $script){
					$plugin_js .= $script . "\n";
					}

				}


			}
		}
	echo $theme_css;
	echo $theme_style;
	echo $plugin_css;
	echo $js_theme_style;
	echo $theme_js;
	echo $plugin_js;	
	}

	public function admin_footer_scripts(){
		$app = App::config('app');
		$plugin_url = URL.str_replace(BASEPATH, '', $app['plugins-path']);
		$theme_url = URL.str_replace(BASEPATH, '', $app['themes-path']).$this->admin_theme;
		$nav = new Nav;
		$enqueue = new Enqueue($theme_url);
		$theme_js = '';
		$plugin_js = '';
		$file = $this->theme_path.$this->admin_theme.'/config.php';
		if(file_exists($file)){
			include($file);
			foreach($enqueue->footer_script as $script){
			$theme_js .= $script . "\n";
			}
		}

		foreach ($this->plugins as $plugin) {
			if($plugin != ''){
				$pf = $app['plugins-path'].$plugin['plugin'].'/config.php';
				if(file_exists($pf)) {
					$enqueue = new Enqueue($plugin_url.$plugin['plugin']);
					include($pf);
					foreach($enqueue->footer_script as $script){
					$plugin_js .= $script . "\n";
					}

				}


			}
		}
	echo $theme_js;
	echo $plugin_js;
	}

	public function admin_widgets(){

	}

}