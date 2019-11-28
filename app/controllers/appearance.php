<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Appearance extends controller
{
	function __construct()
	{
		parent::__construct();
		$this->styles = array();
		$this->widgets = array();
	}

	public function admin_index(){
		$this->title = __('Appearance');
		$ct =  $this->model->option('meta_str',array('name' => 'themes','value' => 'admin_theme'));
		$ts =  $this->model->option('meta_str',array('name' => 'admin_theme','value' => $ct));
		if(empty($ts)){
			$default = 'checked';
		} else {
			$default = '';
		}
		$this->set('ts',$ts);
		$this->set('default',$default);
		$app = App::config('app');
		$cf = $app['themes-path'].$ct;
		$uri_theme = str_replace(BASEPATH, '', $app['themes-path']);
		$uri_theme = URL.$uri_theme.$ct.'/assets/';
		$this->set('theme_assets_uri', $uri_theme);
		if(file_exists($cf.'/editor.php')) {
			include($cf.'/editor.php');
			$this->set('has_options',true);
			if(isset($styles) && !empty($styles)) {
				$this->set('theme_options',$styles);
			}
			$this->set('has_options',true);
		} else {
			$this->set('has_options',false);
		}
		$this->set('dir', $app['themes-path']);
		$files = glob($app['themes-path'] . "*");
		$templates = array();
		$enqueue = new Enqueue;
		$nav = new Nav;
		$i = 1;
		$ct =  $this->model->option('meta_str',array('name' => 'themes','value' => 'admin_theme'));
		$templates[0]['dir'] = $ct;
		$templates[0]['theme'] = array();
		$cf = $app['themes-path'].$ct;
		if(file_exists($cf.'/template.jpg')) {
			$uri_path = str_replace(BASEPATH, '', $app['themes-path']).$ct.'/template.jpg';
		} else if(file_exists($cf.'/assets/images/no-preview.jpg')){
			$uri_path = str_replace(BASEPATH, '', $app['themes-path']).$ct.'/assets/images/no-preview.jpg';
		} else {
			$uri_path = str_replace(BASEPATH, '', $app['assets-path']).'images/no-image.jpg';
		}

		$template['image'] =  URL.$uri_path;
		$template['class'] = 'active';
		if(file_exists($cf.'/config.php')) {
			include $cf.'/config.php';
			$templates[0]['theme'] = $template;
		}
		// echo $ct; 
		foreach ($files as $value) {
			$folder = $value;
			if(is_dir($folder) && $folder != $cf) {
				$name = str_replace($app['themes-path'], '', $value);
				$templates[$i]['dir'] = $name;
				$conf = $value.'/config.php';
				$template = array();
				$templates[$i]['theme'] = $template;
				if(file_exists($value.'/template.jpg')) {
					$uri_path = str_replace(BASEPATH, '', $value).'/template.jpg';
				} else if(file_exists($cf.'/assets/images/no-preview.jpg')){
					$uri_path = str_replace(BASEPATH, '', $app['themes-path']).$ct.'/assets/images/no-preview.jpg';
				} else {
					$uri_path = str_replace(BASEPATH, '', $app['assets-path']).'images/no-image.jpg';
				}
				$template['image'] = URL.$uri_path;
				$template['class'] = '';
				if(file_exists($conf)) {
					include $conf;
					$templates[$i]['theme'] = $template;
				}			
				$i++;
			}
		}
		$this->set('files', $templates);
	}

	public function admin_edit_admin(){
		$ct =  $this->model->option('meta_str',array('name' => 'themes','value' => 'admin_theme'));
		$app = App::config('app');
		$cf = $app['themes-path'].$ct;
		if(file_exists($cf.'/editor.php')) {
			include($cf.'/editor.php');
			$this->title = __('Edit the admin theme');
		} else {
			$this->title = __('This theme has no editor');
		}
	}

	public function admin_admintheme_widgets(){
		$ct =  $this->model->option('meta_str',array('name' => 'themes','value' => 'admin_theme'));
		$app = App::config('app');
		$wids_array = array();
		$ww = array();
		$allwidgets = $this->appearance->get_admin_widgets();
		// print_r($allwidgets);
		foreach ($allwidgets as $key => $value) {
			$ww[$value['widget_position']] = json_decode($value['widget_data'], true);
			$wids_array = array_merge($wids_array,$ww);
		}

		$register = $this->appearance;
		$cf = $app['themes-path'].$ct;
		if(file_exists($cf.'/widgets.php')) {
			include($cf.'/widgets.php');
			$this->title = __('Add your widgets');
			$this->set('have_theme_widgets',true);
			$this->set('widgets',$register->widgets);
			$this->set('saved_widgets',$wids_array);
			$this->set('plugin_widgets',$this->appearance->get_plugin_widgets());
			$this->set('main_widgets',$this->appearance->get_main_widgets());
		} else {
			$this->title = __('You have no widget positions in your theme');
			$this->set('have_theme_widgets',false);
			$this->set('saved_widgets',$wids_array);
			$this->set('plugin_widgets',$this->appearance->get_plugin_widgets());
			$this->set('main_widgets',$this->appearance->get_main_widgets());
		}
	}
	public function rest_activate_theme(){
		$data = array();
		if(!empty($this->data)){
			$ch = $this->appearance->activate_theme($this->data['theme']);
			if($ch > 0) {
				$data['ok'] = 'success';
			} else {
				$data['ok'] = 'failed';
			}
		} else {
			$data['ok'] = 'bad';
		}

		echo json_encode($data);
	}

	public function rest_activate_theme_style(){
		$data = array();
		if(!empty($this->data)){
			$this->loadmodel('meta_options');
			$ct =  $this->model->option('meta_str',array('name' => 'themes','value' => 'admin_theme'));
			$id =  $this->model->option('id',array('name' => 'admin_theme','value' => $ct));
			if(empty($id)){
			$dt['name'] = 'admin_theme';
			$dt['value'] = $ct;
			$dt['meta_str'] = $this->data['style'];
			$dt['meta_int'] = time();
			} else {
				$dt['meta_str'] = $this->data['style'];
				$dt['meta_int'] = time();
				$this->meta_options->id = $id;
			}
			$ch = $this->meta_options->save($dt);
			if($ch > 0) {
				$data['ok'] = 'success';
			} else {
				$data['ok'] = 'failed';
			}
		} else {
			$data['ok'] = 'bad';
		}

		echo json_encode($data);
	}

	public function rest_set_update_widgets(){
		$data = array();
		//if(!empty($this->data)){
			$this->loadmodel('widgets');
			$wid = $this->appearance->get_admin_widgets($this->data['widget_id']);
			if(!empty($wid)) {
				$this->widgets->column('widget_position',$this->data['widget_id']);
				$this->data['updated'] = date('Y-m-d H:i:s');
				$this->data['updated_user'] = $this->user['id'];
			} else {
				$this->data['status'] = 1;
				$this->data['widget_position'] = $this->data['widget_id'];
				$this->data['widget_type'] = 'admin';
				$this->data['created'] = date('Y-m-d H:i:s');
				$this->data['created_user'] = $this->user['id'];
			}
			$ch = $this->widgets->save($this->data);
			if($ch > 0) {
				$data['ok'] = 'success';
			} else {
				$data['ok'] = 'failed';
			}
			echo json_encode($data);
		}
	//} 

	
}