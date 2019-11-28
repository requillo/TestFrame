<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Settings_model extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function get_lang(){
		$lang_opt = '';
		
		$langs = $this->option('meta_text', array('name'=>'settings','value'=>'languages'));
		$langs = json_decode($langs,true);
		$lang_names = $this->option('meta_text', array('name'=>'settings','value'=>'lang_name'));
		$lang_names = json_decode($lang_names,true);
		$lang_default = $this->option('meta_str', array('name'=>'settings','value'=>'default_lang'));
		$lang_default = json_decode($lang_default,true);
		foreach ($langs as $key => $value) {
			if(isset($lang_default[$key])) {
				$selected = ' selected';
			} else {
				$selected = '';
			}
			$lang_opt .= '<option value="'.$value.'"'.$selected.'>'.$lang_names[$key].'</option>';
		}
		return $lang_opt;
	}

	public function get_timezones(){
		$app = App::config('app');
		$res = '';
		$default_lang = $this->option('meta_str', array('name'=>'settings','value'=>'default_lang'));
		$currentzone = $this->option('meta_str', array('name'=>'settings','value'=>'timezone'));
		$default_lang = json_decode($default_lang);
		$default_lang = reset($default_lang);
		$file1 = $app['globals-path'].LANG.'_timezones.php';
		$file2 = $app['globals-path'].$default_lang.'_timezones.php';
		$file3 = $app['globals-path'].'en_EN_timezones.php';
		if(file_exists($file1)) {
			include($file1);
		} else if(file_exists($file2)) {
			include($file2);
		} else {
			include($file3);
		}
		foreach ($timezones as $key => $value) {
			$res .= '<optgroup label="'.$key.'">';
			foreach ($value as $k => $v) {
				$res .= '<option value="'.$v.'" ';
				if($currentzone == $v) { $res .= 'selected'; }
				$res .='>'.$k.'</option>';
			}
			$res .= '</optgroup>';
		}
		return $res ;
	}



	public function get_role_form_meta(){
		$sql = "SELECT value, meta_text FROM ".PRE."meta_options WHERE name = 'admin_pages' AND meta_text != ''";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$role = array();
		foreach ($rows as $key => $value) {
			$role[$value['value']] = explode(',', $value['meta_text']);
		}
		return $role;
	}

	public function get_plugins(){
		
		$app = App::config('app');
		$sql = "SELECT plugin, active FROM ".PRE."plugins";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$pages = array();
		if(!empty($rows)) {
			foreach ($rows as $key => $row) {
				$nav = new Nav;
				$enqueue = new Enqueue;
				$pages[$key]['name'] =  $row['plugin'];
				$pn = $row['plugin'];
				if($row['active'] == 0){
					$status = 'disabled';
				} else {
					$status = 'enabled';
				}
				$pages[$key]['status'] = $status;
				$file = $app['plugins-path'].$pn.'/config.php';
				$controller = $app['plugins-path'].$pn.'/controllers/'.$pn.'.php';
				if(file_exists($file)) {
					include($file);
				}
				if(isset($plugin['name'])) {
					$pages[$key]['plugin-name'] = __($plugin['name'],$row['plugin']);
				} else {
					$pages[$key]['plugin-name'] =  ucfirst(str_replace('_', ' ', $row['plugin']));
				}
				$subs = array_flip($nav->subs);
				$mains = $nav->names;
				if(file_exists($controller)) {
					include_once($controller);
				}
				$all_pages = get_class_methods($pn);
				if(is_array($all_pages)) {
				$all_pages = array_diff($all_pages, $app['defaultmethods']);
				$i = 0;
					foreach ($all_pages as $k => $val) {
						if (strpos($val, 'admin_') !== false) {
							$b = str_replace('admin_', '', $val);
							$c = str_replace('_', '-', $b);
							if(isset($subs[$b])) {
								$pn = $subs[$b];
							} else if(isset($subs[$c])) {
								$pn = $subs[$c];
							} else if(isset($mains[$b])){
								$pn = $mains[$b];
							} else if(isset($mains[$c])){
								$pn = $mains[$c];
							} else {
								$pn = ucfirst(str_replace(array('-','_'), ' ', $b));
							}
							$pages[$key]['pages']['admin'][$i]['name'] = $pn;
							$pages[$key]['pages']['admin'][$i]['link'] = $row['plugin'] . '/'.str_replace('admin_', '', $val);
							$i++;
						}
					}
					foreach ($all_pages as $k => $val) {
						if (strpos($val, 'widget_') !== false) {
							$b = str_replace('widget_', '', $val);
							$pn = ucfirst(str_replace(array('-','_'), ' ', $b));
							$pages[$key]['pages']['widget'][$i]['name'] = $pn;
							$pages[$key]['pages']['widget'][$i]['link'] = $row['plugin'] . '/'.str_replace('widget_', '', $val);
							$i++;
						}
					}
					foreach ($all_pages as $k => $val) {
						if (strpos($val, 'rest_') !== false) {
							$b = str_replace('rest_', '', $val);
							$pn = ucfirst(str_replace(array('-','_'), ' ', $b));
							$pages[$key]['pages']['rest'][$i]['name'] = $pn;
							$pages[$key]['pages']['rest'][$i]['link'] = $row['plugin'] . '/'.str_replace('rest_', '', $val);
							$i++;
						}
					}
				} 
			}
			return $pages;
		}
	}

	public function get_pages(){
		$nav = new Nav;
		$enqueue = new Enqueue;
		$app = App::config('app');
		$menus = $app['app-path'].'config/menu.php';
		$pages = array();
		$i = 0;
		include($menus);
		if($app['show-website'] == false) {
			unset($menu['pages']);
			unset($menu['forms']);
			unset($menu['web-settings']);
			}
		foreach ($menu as $key => $value) {
			$class = str_replace('-', '_', $key);
			$methods = get_class_methods($class);
			
			if(is_array($methods)) {
				$pages[$i]['name'] = $key;
				$pages[$i]['page-name'] = ucfirst(str_replace(array('-','_'), ' ', $key));
				$methods = array_diff($methods, $app['defaultmethods']);
				$e = 0;
				foreach ($methods as $val) {
					if (strpos($val, 'admin_') !== false) {
						$b = str_replace('admin_', '', $val);
						if(isset($value[$b])) {
							$pn = $value[$b];
						} else {
							$pn = ucfirst(str_replace('_', ' ', $b));
						}
						$pages[$i]['pages']['admin'][$e]['name'] = $pn;
						$pages[$i]['pages']['admin'][$e]['link'] = str_replace('-', '_', $key).'/'.$b;
						$e++;
					} else if(strpos($val, 'widget_') !== false) {
						$b = str_replace('widget_', '', $val);
						$pn = ucfirst(str_replace('_', ' ', $b));

						$pages[$i]['pages']['widget'][$e]['name'] = $pn;
						$pages[$i]['pages']['widget'][$e]['link'] = str_replace('-', '_', $key).'/'.$b;
						$e++;

					} else if(strpos($val, 'rest_') !== false) {
						$b = str_replace('rest_', '', $val);						
						$pn = ucfirst(str_replace('_', ' ', $b));
						
						$pages[$i]['pages']['rest'][$e]['name'] = $pn;
						$pages[$i]['pages']['rest'][$e]['link'] = str_replace('-', '_', $key).'/'.$b;
						$e++;

					}
				}
				// $pages[$i]['pages'] = $methods;
			}
			$i++;
		}
		return $pages; 
	}

	public function get_user_roles($role){
		$sql = "SELECT role_name, role_level FROM ".PRE."user_roles WHERE role_level < $role ORDER BY role_level DESC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($rows as $key => $value) {
			$rows[$key]['role_name'] = $this->get_content($value['role_name']);
		}
		return $rows;
	}


	public function check_rows_role($role) {
		$ap = $this->option('name', array('name'=>'admin_pages','value'=>$role));
		if($ap != '') {
			return true;
		} else {
			return false;
		}
	}

	public function insert_option($value){
		$key = key($value);
		$update = $value[$key];
		$admin_page = 'admin_pages';
		$sql = "INSERT INTO ".PRE."meta_options (name, value, meta_text) VALUES (:name, :value, :meta_text)";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':name' => $admin_page, ':value' => $where['value']));
		return $stmt->rowCount() ? 1 : 0;
	}

	public function update_page_roles($roles){
		$res = '';
		$updated = '';
		foreach ($roles as $key => $value) {
			$data = '';
			$res .= $key . '=';
			foreach ($value as $k => $v) {
				$data .= $v . ',';
			}
			$data = rtrim($data,',');
			$res .= $data . '<br>';
			$updated .= $this->update_option(array('meta_text' => $data),array('name'=>'admin_pages','value'=>$key));
		}
		return $updated;
	}

}