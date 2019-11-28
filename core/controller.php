<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Controller
{
	public $var = array();
	public $view;
	public $model;
	public $data;
	public $error;
	public $form_error;
	public $ext;
	public function __construct()
	{
		$this->view = new View;
		$this->model = new Model;
		$this->isdbcon = $this->model->isconn;
		$this->title = '';
		// $this->form_error = 'dsfsd';
		if($this->isdbcon != 'No') {
			$this->user = $this->model->get_user_info();
		}

		if(strpos(CURRENT_URL, '.json')) {
			$this->ext = 'json';
		} else if(strpos(CURRENT_URL, '.xml')) {
			$this->ext = 'xml';
		} else {
			$this->ext = 'html';
		}
		
		// Get config variables
		$app = App::config('app');
		// Check if model file exists and include the file
		$model1 = $app['models-path'].strtolower(get_class($this)).'_model.php';
		$model2 = $app['plugins-path'] . strtolower(get_class($this)) . '/models/'.strtolower(get_class($this)).'_model.php';
		if(file_exists($model1)){
			include_once($model1);		
			$class = get_class($this)."_model";
			$this->{strtolower(get_class($this))} = new $class;
		} else if(file_exists($model2)){
			include_once($model2);	
			$class = get_class($this)."_model";
			$this->{strtolower(get_class($this))} = new $class;
		} else {
			$this->{strtolower(get_class($this))} = new Model;
		}

		if(!empty($_POST['data'])){
			$this->data = $_POST['data'];
		} else if(!empty($_GET['data'])){
			$this->data = $_GET['data'];
		} else if(!empty($_POST)) {
			// $this->data = $_POST;
		} else if(!empty($_GET)) {
			// $this->data = $_GET;
		}
	}
	// Set variable to view
	public function set($var,$data){
		$array = array($var => $data);
		$this->var = array_merge($this->var, $array);
		return $this->var;
	}
	// Load controller model
	public function loadmodel($name){
		$app = App::config('app');
		$file1 = $app['models-path'].$name.'_model.php';
		$plugins = $this->model->get_all_plugins();
		$file2 = $app['plugins-path'].$name.'/models/'.$name.'_model.php';
		$isplugin = false;
		foreach ($plugins as $value) {
			$pluginfile = $app['plugins-path'].$value['plugin'].'/models/'.$name.'_model.php';
			if(file_exists($pluginfile)) {
				$isplugin = true;
				include_once($pluginfile);
				$class = $name."_model";
				if(class_exists($class)) {
					return $this->{$name} = new $class;
				} else {
					$this->{$name} = new model;
					return $this->{$name}->name = $name;
				}
				
			}
		}
		
		if(file_exists($file1) && $isplugin == false){
			include_once($file1);
			$class = $name."_model";					
			return $this->{$name} = new $class;
		} else if($isplugin == false) {
			$this->{$name} = new model;
			return $this->{$name}->name = $name;
		}
	}
	public function error(){
		$this->error = true;
	}

	public function admin_redirect($page,$get = NULL){
		if(isset($_SESSION['flash']) && !empty($_POST)){
			$_SESSION['flash-count'] = 1;
		} 
		$page = rtrim($page,'/');
		$page = $page.'/';
		$multi = $this->model->option('meta_int',array('name' => 'settings', 'value' => 'multilang'));
		$url = URL.BACKEND_URL;
		if($multi == 0) {
			header('Location:'.$url.$page);
		} else if($get == NULL) {
			header('Location:'.admin_url().$page);
		} else {
			header('Location:'.admin_url().$page.$get);
		}
		
	}
	public function is_plugin($str){
		$str = str_replace('-', '_', $str);
		$app = App::config('app');
		$res = array();
		$sql = "SELECT plugin, active FROM ".PRE."plugins WHERE plugin = :plugin";
		$stmt = $this->model->pdo->prepare($sql);
		$t = $stmt->execute(array(':plugin' => $str));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row['plugin'] != '') {
			 if($row['active'] == 1) {
			 	$res['allow'] = true;
			 	$res['message'] = 'plugin';
			 	$file = $app['plugins-path'] . strtolower($str) . '/controllers/'.strtolower($str).'.php';
			 	if(file_exists($file)){
			 		include_once($file);
			 	}
			 	
			 } else {
			 	$res['allow'] = false;
			 	$res['message'] = 'disabled';
			 }

		} else {
			$res['allow'] = true;
			$res['message'] = 'no plugin';

		}
		return $res;
	}

	public function is_plugin_active($str){
		$str = str_replace('-', '_', $str);
		$sql = "SELECT plugin, active FROM ".PRE."plugins WHERE plugin = :plugin";
		$stmt = $this->model->pdo->prepare($sql);
		$t = $stmt->execute(array(':plugin' => $str));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!empty($row)) {
			 if($row['active'] == 1) {
			 	return true;
			 } else {
			 	return false;
			 }
		} else {
			return false;
		}
	}


	public function required_data($data = NULL){
		$errorpost = '';
		$this->model->no_save = 0;
		if(is_string($data)){
			$data = explode(',', $data);
				foreach ($data as $value) {
					if(isset($this->data[$value]) && $this->data[$value] == ''){
						$errorpost .= $value .',';
					} else if(!isset($this->data[$value])) {
						$errorpost .= $value .',';
					}
					
				}
			
		} else if(is_array($data)) {
			foreach ($data as $key => $value) {
				
				if(isset($this->data[$key]) && $this->data[$key] == ''){
						$errorpost .= $key .',';
				} else if(isset($this->data[$key]) && isset($value['email']) && $value['email'] == true && filter_var($this->data[$key], FILTER_VALIDATE_EMAIL) === false) {
						$errorpost .= $key .',';
				}
			}

		}
		if($errorpost != ''){
			$this->model->no_save = 1;
			$this->form_error = 1;
			// return 1;
		}
		return Message::$required = $errorpost;
	}

	public function get_page_forms($id){
		// print_r($this->data);
		$res = '';
		$this->loadmodel('forms');
		$tf = $this->forms->get_form($id);
		if(!empty($tf)) {
				$res = $this->web_forms->html_form($tf['inputs']);
		}
		return $res;
	}

	private function get_form_data($id){
		$this->loadmodel('forms');
		$tf = $this->forms->get_form($id);

	}

}