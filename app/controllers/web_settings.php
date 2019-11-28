<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Web_settings extends controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function admin_index(){
		$this->title = __('Website setting');
		$this->set('homepage', $this->web_settings->option('meta_int', array('name'=>'page','value'=>'index')));
		$this->set('weblogo', $this->web_settings->option('meta_text', array('name'=>'website','value'=>'web_logo')));
		$this->set('favicon', $this->web_settings->option('meta_text', array('name'=>'website','value'=>'favicon')));
		$this->set('websitename', $this->web_settings->option('meta_text', array('name'=>'website','value'=>'name')));
		$this->set('websitedesc', $this->web_settings->option('meta_text', array('name'=>'website','value'=>'description')));
		$this->set('pages', $this->web_settings->get_all_pages_options());
		$this->set('homeblog', '1');
		$updated = '';
		if(!empty($this->data)) {
			$updated .= $this->web_settings->update_option(array('meta_int' => $this->data['home']),array('name'=>'page','value'=>'index'));
			$updated .= $this->web_settings->update_option(array('meta_text' => $this->data['web_name']),array('name'=>'website','value'=>'name'));
			$updated .= $this->web_settings->update_option(array('meta_text' => $this->data['web_description']),array('name'=>'website','value'=>'description'));
			$logo = $this->web_settings->behavior->upload('web_logo',array('size' => 10,'dir' => 'app/website'));
			if($logo != '') {
			  	$this->data['web_logo'] = $logo;
			  } else {
			  	$this->data['web_logo'] = $this->data['string_web_logo'];
			  }
			$favicon = $this->web_settings->behavior->upload('favicon',array('size' => 1,'dir' => 'app/website'));
			if($favicon != '') {
			  	$this->data['favicon'] = $favicon;
			  } else {
			  	$this->data['favicon'] = $this->data['string_favicon'];
			  }
			$updated .= $this->web_settings->update_option(array('meta_text' => $this->data['web_logo']),array('name'=>'website','value'=>'web_logo'));
			$updated .= $this->web_settings->update_option(array('meta_text' => $this->data['favicon']),array('name'=>'website','value'=>'favicon'));
		}
		if($updated != '') {
			Message::flash(__('Websetting updated'));
			$this->admin_redirect('web-settings');
		}
	}

	public function admin_menu() {
		$this->title = __('Add website menu');
		// Do this for multilang
		$multilang = $this->web_settings->option('meta_int', array('name'=>'settings','value'=>'multilang'));
		$langs = $this->web_settings->option('meta_text', array('name'=>'settings','value'=>'languages'));
		$deflangs = $this->web_settings->option('meta_str', array('name'=>'settings','value'=>'default_lang'));
		
		if($multilang == 1) {
			$langarr = json_decode($langs, true);
		} else {
			$langarr = json_decode($deflangs, true);
		}
		$this->set('langs', $langarr);
		$current_lang = rtrim(LANG_ALIAS,'/');
		$def_lang = rtrim(DEFAULT_LANG_ALIAS,'/');
		$this->set('current_lang', $current_lang);
		$plugins = $this->web_settings->get_plugin_front_pages();
		$this->set('Plugins', $plugins);
		$this->loadmodel('pages');
		$pages = $this->pages->get_all_pages('publish');
		$this->set('Pages', $pages);
		$menu_options = '';
		$Menudata = $this->web_settings->get_all_menu_data();
		if(!empty($Menudata)) {
			foreach ($Menudata as $value) {
			$menu_options .= '<option value="'.$value['id'].'">'.$value['meta_str'].'</option>';
			}
			$menu_items = json_decode($Menudata[0]['meta_text'], true);
			$menu_items = $this->web_settings->backend_menu_items($menu_items);
		} else {
			$menu_items = '<ol class="dd-list outer"></ol>';
		}
		$this->set('Menu_options', $menu_options);
		$this->set('Menu_items', $menu_items);
	}

	public function rest_get_menus_options(){

	}

	public function rest_get_menu_items(){
		if(!empty($this->data)){ 
			$data = array();
			$jsondata = $this->web_settings->get_all_menu_data_json($this->data['menu_id']);
			$menu_items = json_decode($jsondata, true);
			$menu_items = $this->web_settings->backend_menu_items($menu_items);
			$data['message'] = 'success';
			$data['items'] = $menu_items;
			echo json_encode($data);
		}
	}

	public function rest_add_menu_items(){
		$this->loadmodel('meta_options');
		if(!empty($this->data)){
			$data = array();
			$data['message'] = 'failed';
			$this->data['meta_text'] = $this->data['menu_str'];
			$this->meta_options->id = $this->data['menu_id'];
			$id = $this->meta_options->save($this->data);
			if($id > 0) {
				$data['message'] = 'success';
			}
			echo json_encode($data);
		}

	}

	public function rest_add_menu_option(){
		$this->loadmodel('meta_options');
		if(!empty($this->data)){
			$data = array();
			$data['message'] = 'failed';
			$this->data['name'] = 'website';
			$this->data['value'] = 'menu';
			$id = $this->meta_options->save($this->data);
			if($id > 0) {
				$data['message'] = 'success';
			}
			echo json_encode($data);
		}

	}
}