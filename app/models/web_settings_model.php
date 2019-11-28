<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Web_settings_model extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function get_all_pages_options(){
		$type = 'page';
		$status = 1;
		$sql = "SELECT id, title FROM ".PRE."pages WHERE type = :type AND status = :status";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':type' => $type, ':status' => $status));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$options = array();
		foreach ($rows as $row) {
			$options[$row['id']] = $row['title'];
		}

		return $options;
	}

	public function get_plugin_front_pages(){
		$app = App::config('app');
		$sql = "SELECT plugin, active FROM ".PRE."plugins WHERE active = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$res = '';
		$nav = new Nav;
		$enqueue = new Enqueue;
		$plugins = array();
		$i = 0;
		foreach ($rows as $row) {
			$ipl = 0;
			$pn = $row['plugin'];
			
			$file = $app['plugins-path'].$pn.'/config.php';
			$controller = $app['plugins-path'].$pn.'/controllers/'.$pn.'.php';
			$nav->subs = array();
			if(file_exists($file)) {
				include($file);
			}
			if(file_exists($controller)) {
				include_once($controller);
			}
			$pages = get_class_methods($pn);
			if(is_array($pages)) {
			$pages = array_diff($pages, $app['defaultmethods']);	
			}
			
			$menu = array_flip($nav->subs);
			if(is_array($pages)) {
				$plname = str_replace('_',' ',ucfirst(strtolower($pn)));
				$plugins[$i]['name'] =  __($plname,$pn);
				foreach ($pages as $p) {
					if (strpos($p, 'website_') !== false) {
						$pt = str_replace('website_', '', $p);
						if(strpos($pt, 'widget_') === false) {
							$page = $pt;
							$plugins[$i]['pages'][$ipl]['name'] = ucwords(str_replace('_', ' ', $page));
							$plugins[$i]['pages'][$ipl]['url'] = str_replace('_', '-', $page);
							$ipl++;
						}
						
					} 

				}
			}
			$i++;			
		}
		return $plugins;
	}

	public function get_all_menu_data(){
		$sql = "SELECT id, meta_str, meta_text FROM ".PRE."meta_options WHERE name = 'website' AND value = 'menu'";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function menu_json_data($menu = NULL) {
		if($menu == NULL) {
			$sql = "SELECT meta_text FROM ".PRE."meta_options WHERE name = 'website' AND value = 'menu'";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
		} else {
			$sql = "SELECT meta_text FROM ".PRE."meta_options WHERE name = 'website' AND value = 'menu' AND meta_str = :meta_str";
			$array = array(':meta_str' => $menu);
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute($array);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		return $row['meta_text'];
	}

	public function get_all_menu_data_json($id){
		$sql = "SELECT meta_text FROM ".PRE."meta_options WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['meta_text'];
	}

	public function backend_menu_items($arr){
		$multilang = $this->option('meta_int', array('name'=>'settings','value'=>'multilang'));
		$langs = $this->option('meta_text', array('name'=>'settings','value'=>'languages'));
		$deflangs = $this->option('meta_str', array('name'=>'settings','value'=>'default_lang'));
		$current_lang = rtrim(LANG_ALIAS,'/');
		if($multilang == 1) {
			$langarr = json_decode($langs, true);
		} else {
			$langarr = json_decode($deflangs, true);
		}
		$res = '<ol class="dd-list outer">';
		if(is_array($arr)) {

			foreach ($arr as $value) {
				if(strpos($value['link'], 'http') === false) {
					$url = url($value['link'].'/');
				} else {
					$url = $value['link'];
				}

				if($value['typename'] != '') {
					$type = $value['type'].' ('.$value['typename'].')';
				} else {
					$type = $value['type'];
				}
				$res .= '<li class="dd-item" data-link="'.$value['link'].'" data-name="'.$value['name'].'" data-type="'.$value['type'].'" data-typename="'.$value['typename'].'" data-original="'.$value['original'].'">';
				$res .= '<div class="dd-handle dd3-handle"><i class="fa fa-arrows"></i></div>';
				$res .= '<div class="dd3-content">';
				foreach ($langarr as $ky => $val) {
					if($ky == $current_lang) {
						$res .= '<span class="menu-each-lang menu-lang-'.$val.'">'.language_content($value['name'],$ky).'</span>';
					} else {
						$res .= '<span class="menu-each-lang menu-lang-'.$val.' hide">'.language_content($value['name'],$ky).'</span>';
					}
				}
				$res .= '</div>';
				$res .= '<div class="item-data hide">';
				foreach ($langarr as $ky => $val) {
					if($ky == $current_lang) {
						$res .= '<input type="text" class="new-menu-name menu-input-lang-'.$val.'" value="'.language_content($value['name'],$ky).'">';
						$res .= '<div class="original-menu-name menu-span original-menu-lang-'.$val.'">'. __('Original name: ').'<span>'.language_content($value['original'],$ky).'</span></div>';
					} else {
						$res .= '<input type="text" class="new-menu-name menu-input-lang-'.$val.' hide" value="'.language_content($value['name'],$ky).'">';
						$res .= '<div class="original-menu-name menu-span original-menu-lang-'.$val.' hide">'. __('Original name: ').'<span>'.language_content($value['original'],$ky).'</span></div>';
					}
				}
				$res .= '<div class="menu-span">'. __('Type: ').'<span>'.__($type).'</span></div>';
				$res .= '<div class="menu-span">'. __('Link: ').'<span>'.$url.'</span></div>';
				$res .= '<a class="btn btn-success save-menu-item">'.__('Save').'</a>';
				$res .= '<a class="btn btn-danger del-menu-item pull-right">'.__('Delete').'</a>';
				$res .= '</div>';
				if(isset($value['children'])){
					$res .= $this->backend_menu_items($value['children']);
				}
				$res .= '</li>';
			}
			
		}
		$res .= '</ol>';
		return $res;		
	}
}