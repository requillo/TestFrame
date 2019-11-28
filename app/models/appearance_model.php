<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Appearance_model extends Model { 
	function __construct()
	{
		parent::__construct();
		$this->widgets = array();
	}

	public function activate_theme($theme) {
		$value = array('meta_str' => $theme);
		$where = array('name' => 'themes', 'value' => 'admin_theme');
		return $this->update_option($value,$where);
	}

	public function widget($name, $arg){
		$widget[$name] = $arg;
		$this->widgets = array_merge($this->widgets,$widget);
	}

	public function get_plugin_widgets(){
		$app = App::config('app');
		$sql = "SELECT plugin, active FROM ".PRE."plugins WHERE active = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$widgets = array();
		if(!empty($rows)) {
			foreach ($rows as $key => $row) {
				$nav = new Nav;
				$enqueue = new Enqueue;
				$pn = $row['plugin'];
				$file = $app['plugins-path'].$pn.'/config.php';
				$controller = $app['plugins-path'].$pn.'/controllers/'.$pn.'.php';
				if(file_exists($file)) {
					include($file);
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
						if (strpos($val, 'widget_') !== false) {
							$b = str_replace('widget_', '', $val);
							$pn = ucfirst(str_replace(array('-','_'), ' ', $b));
							$widgets[$key]['widget'][$i]['name'] = $pn;
							$widgets[$key]['widget'][$i]['link'] = $row['plugin'] . '/'.str_replace('widget_', '', $val);
							$i++;
						}
					}
					if($i > 0) {
						if(isset($plugin['name'])) {
							$widgets[$key]['plugin-name'] = __($plugin['name'],$row['plugin']);
							$widgets[$key]['plugin'] = $row['plugin'];
						} else {
							$widgets[$key]['plugin-name'] =  ucfirst(str_replace('_', ' ', $row['plugin']));
							$widgets[$key]['plugin'] = $row['plugin'];
						}
					}
				} 
			}
			return $widgets;
		}
	}


	public function get_main_widgets(){
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
				$methods = array_diff($methods, $app['defaultmethods']);
				$e = 0;
				foreach ($methods as $val) {
					if (strpos($val, 'widget_') !== false) {
						$b = str_replace('widget_', '', $val);
						$pn = ucfirst(str_replace('_', ' ', $b));

						$pages[$i]['widget'][$e]['name'] = $pn;
						$pages[$i]['widget'][$e]['link'] = str_replace('-', '_', $key).'/'.$b;
						$e++;
					}
				}

				if($e > 0) {
					$pages[$i]['main-name'] = ucfirst(str_replace(array('-','_'), ' ', $key));
					$pages[$i]['name'] = $key;
					$i++;
				}
			}
			
		}
		return $pages; 
	}

	public function get_admin_widgets($pos = NULL){
		if($pos == NULL) {
			$sql = "SELECT widget_position, widget_data FROM ".PRE."widgets WHERE widget_type = 'admin' AND status = 1";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();
		} else {
			$sql = "SELECT widget_position, widget_data FROM ".PRE."widgets WHERE widget_type = 'admin' AND widget_position = :widget_position AND status = 1";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':widget_position' => $pos));
		}
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}
}