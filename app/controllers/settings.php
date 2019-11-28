<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class settings extends controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function admin_index($test = 'test'){
		// $app = App::config('app');
		$this->title = __('Main settings');
		// print_r($this->settings->get_plugins());
		$app = App::config('set');
		$app_version = $this->settings->option('meta_str', array('name'=>'application','value'=>'version'));
		$file_verion = $app['version'];
		$this->set('app_version',$app_version);
		$this->set('file_verion',$file_verion);
		$this->set('plugins', $this->settings->get_user_roles($this->user['role_level']));
		$this->set('appname', $this->settings->option('meta_str', array('name'=>'settings','value'=>'app_name')));
		$this->set('multilang', $this->settings->option('meta_int', array('name'=>'settings','value'=>'multilang')));
		$this->set('applogo', $this->settings->option('meta_text', array('name'=>'settings','value'=>'app_logo')));
		$this->set('appicon', $this->settings->option('meta_text', array('name'=>'settings','value'=>'app_icon')));
		$this->set('lang_options', $this->settings->get_lang());
		$this->set('timezone_options', $this->settings->get_timezones());
		
		if(!empty($this->data)){
			  $logo = $this->settings->behavior->upload('app_logo',array('size' => 10,'dir' => 'app/logo'));
			  if($logo != '') {
			  	$this->data['app_logo'] = $logo;
			  } else {
			  	$this->data['app_logo'] = $this->data['string_logo'];
			  }
			  $app_icon = $this->settings->behavior->upload('app_icon',array('size' => 2,'dir' => 'app/logo'));
			  if($app_icon != '') {
			  	$this->data['app_icon'] = $app_icon;
			  } else {
			  	$this->data['app_icon'] = $this->data['string_app_icon'];
			  }
			
			$get = '';
			if($this->data['tabs'] != '') {
				$tab = ltrim($this->data['tabs'],'#');
			} else {
				$tab = '';
			}

			if($this->data['side-tabs'] != '') {
				$sub = ltrim($this->data['side-tabs'],'#');
			} else {
				$sub = '';
			}

			if($tab != '') {
				$get .= '?tab='.$tab;
			}

			if($sub != '') {
				$get .= '&sub='.$sub;
			}
			
			$lang = $this->data['lang'];
			$lang_arr = explode('_', $lang);
			$lang_val = array($lang_arr[0] => $lang);
			$lang_val = json_encode($lang_val);
			if(isset($this->data['multilang'])) {
				$multilang = 1;
			} else {
				$multilang = 0;
			}
			$updated = '';
			$updated .= $this->settings->update_option(array('meta_str' => $this->data['app_name']),array('name'=>'settings','value'=>'app_name'));
			$updated .= $this->settings->update_option(array('meta_text' => $this->data['app_logo']),array('name'=>'settings','value'=>'app_logo'));
			$updated .= $this->settings->update_option(array('meta_text' => $this->data['app_icon']),array('name'=>'settings','value'=>'app_icon'));
			$updated .= $this->settings->update_option(array('meta_str' => $lang_val),array('name'=>'settings','value'=>'default_lang'));
			$updated .= $this->settings->update_option(array('meta_int' => $multilang),array('name'=>'settings','value'=>'multilang'));
			$updated .= $this->settings->update_option(array('meta_str' => $this->data['timezone']),array('name'=>'settings','value'=>'timezone'));
			

			if($updated != '') {
				Message::flash(__('Settings updated'));
				
			}
			$this->admin_redirect('settings',$get);
		}
	}

	function admin_page_roles($id = NULL){
		$id = rtrim($id,'/');
		$this->title = __('Page roles');
		$roles = $this->settings->get_user_roles($this->user['role_level']);
		
		$this->set('user_roles', $roles);
		$this->set('plugins', $this->settings->get_plugins());
		$this->set('pages', $this->settings->get_pages());
		$this->set('pages_not_allowed', $this->settings->get_role_form_meta());
		foreach ($roles as $key => $value) {
			$rlsch[$key] = $value['role_level'];
		}
		if($id == NULL) {
			if(isset($roles[0]['role_level'])) {
				$id = $roles[0]['role_level'];
			}
		} else {
			if(!in_array($id, $rlsch)) {
				if(isset($roles[0]['role_level'])) {
				$id = $roles[0]['role_level'];
				} else {
					$id = NULL;
				}
			}

		}
		$this->set('id',$id);
		$updated = '';
		if(!empty($this->data)){
			$id = $this->data['set'];
			if(!in_array($id, $rlsch)) {
				if(isset($roles[0]['role_level'])) {
				$id = $roles[0]['role_level'];
				} else {
					$id = NULL;
				}
			}
			foreach ($roles as $key => $value) {
			if(!isset($this->data['page'][$value['role_level']])) {
				$this->data['page'][$value['role_level']] = '';
				}
			}
			$updated = $this->settings->update_page_roles($this->data['page']);
			if($updated != '') {
				Message::flash(__('Pages and plugins roles updated'));
			} else {
				Message::flash(__('No new selections were made'),'error');
			}
			$this->admin_redirect('settings/page-roles/'.$id.'/');
		}

	}

	public function rest_update_appliction() {
		$data = array();
		$data['message'] = 'failed';
		if(!defined('DB_IS_NOT_INSTALLED')) {
			define('DB_IS_NOT_INSTALLED', true);
		}
		if(!empty($this->data)) {
			$set = App::config('set');
			$app = App::config('app');
			$app_version = $this->settings->option('meta_str', array('name'=>'application','value'=>'version'));
			$file_verion = $set['version'];
			if($file_verion > $app_version) {

				$sql = new sql;
				$sql_file = $app['app-path'].'config/sql/schema.php';
				if(file_exists($sql_file)){
					include($sql_file);
					$tables = $sql->db;
					foreach ($tables as $table) {
								if(isset($table['sql'])) {
									$this->settings->pdo->exec($table['sql']);
								} else if(isset($table['alterdb'])) {
									$this->settings->pdo->exec($table['alterdb']);
								} 
							}
					$this->settings->update_option(array('meta_str'=>$file_verion),array('name'=>'application','value'=>'version'));
					$data['message'] = 'success';
					$data['class'] = 'success';
					sleep(1);
				}
			}
		}
		echo json_encode($data);
	}

}