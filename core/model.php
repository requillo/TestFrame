<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Model
{
	public $id;
	public $column;
	public $db_where;
	
	function __construct()
	{
		$db_file = 'app/config/db/db.php';
		if(file_exists($db_file)) {
			include('app/config/db/db.php');
		}
		$this->no_save = '';
		$this->isconn = "No";
		if(isset($db)) {
			if(!defined('PRE')){
				define('PRE',$db['pre']);
			}
			if($this->db($db['connect'],$db['user'],$db['pass']) != 'Not connected') {
				$this->isconn = "Yes";
				$this->pdo = $this->db($db['connect'],$db['user'],$db['pass']);
			}
		}
		
		$this->behavior = new Behavior;
	}

	public function db($con, $user, $pass){
		try {
    		$conn =  new pdo($con,$user,$pass);
			}
			catch( PDOException $Exception ) {
			$conn = 'Not connected';
			}
			return $conn;		
		}

	public function option($name,$where){
		$sql = "SELECT $name FROM ".PRE."meta_options WHERE name = :name AND value = :value";
		$stmt = $this->pdo->prepare($sql);
		$t = $stmt->execute(array(':name' => $where['name'], ':value' => $where['value']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(strpos($name, ',') === false) {
			return $row[$name];
		} else {
			return $row;
		}
		
	}

	public function update_option($value,$where){
		$key = key($value);
		$update = $value[$key];
		$sql = "UPDATE ".PRE."meta_options SET $key = :$key WHERE name = :name AND value = :value";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(":$key"=>$update,':name' => $where['name'], ':value' => $where['value']));
		return $stmt->rowCount() ? 1 : '';
	}

	public function update_table($table,$cols,$where){
		$table = str_replace(PRE, '', $table);
		$set = 'SET ';
		$tc = count($cols);
		$c = 1;
		$update = array();
		foreach ($cols as $key => $value) {
			$set .= "$key = :$key ";
			$update[$key] = $value;
			if($c < $tc) {
				$set .= ", ";
			}
		}
		$where = 'WHERE ';
		$wt = count($where);
		$w = 1;
		foreach ($where as $key => $value) {
			$where .= "$key = :$key ";
			$update[$key] = $value;
			if($c < $tc) {
				$where .= "AND ";
			}
		}
		$sql = "UPDATE ".PRE."$table $set $where";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($update);
		return $stmt->rowCount() ? 1 : '';
	}

	public function importmodel($name){
		$app = App::config('app');
		$file1 = $app['models-path'].$name.'_model.php';
		$file2 = $app['plugins-path'].'model/'.$name.'_model.php';		
		if(file_exists($file1)){
			
			include_once($file1);
			$class = $name."_model";					
			return $this->{$name} = new $class;
		} else if(file_exists($file2)){
			
			include_once($file2);
			$class = $name."_model";
			return $this->{$name} = new $class;
		}
	}

	public function tocrypt($string, $key){
		$crypted = $key.$string.$key;		
		return hash('sha256', $crypted);		
		}
		
	public function passcrypt($pass, $salt){
		$app = App::config('app');
		$asalt = explode('i',$salt);
		$salted_pass = str_rot13($app['salt'].$asalt[0].$pass.$asalt[1]);
		$hashed = str_rot13(base64_encode(hash('sha256', $salted_pass)));
		$hashed = str_replace(array('1','2','3','4','5','6','=','j'),array('/','_','1','3','2','-','',''),$hashed);
		return $hashed;		
		}
		
	public function generateRandomString($length = 10, $mid = 5, $spec = true) {
	$special = '$#%&*()!@-><?';
    $characters = '0123456789abcdefghjklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if($spec == true){
    	$characters = $characters.$special;
    }
    $charactersLength = strlen($characters) - 1;
    $characters = str_split($characters);   
    $randomString = '';
    for ($i = 1; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength)];
		if($mid != 1) {
			if($i == $mid) {
			$randomString .= 'i';	
					}
				}
			}
    return $randomString;
		}

	public function get_user_info($id = NULL){
		if(isset($_SESSION['loggedin']['id'])){
			$id = $_SESSION['loggedin']['id'];
		} else if($id == NULL) {
			$id = 0;
		}
		
		$sql = "SELECT id, email, fname, lname, salt, password, sid, username, gender, status, created, exp_token FROM ".PRE."users WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$t = $stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$user_relations = $this->get_user_relations($id);
		$row['role_level'] = $user_relations['role_level'];
		$row['user_group'] = $user_relations['user_group'];
		$row['user_company'] = $user_relations['user_company'];
		$row['user_relation_id'] = $user_relations['id'];
		return $row; 

	}
	public function check_user_db(){
		$id = 1;	
		$sql = "SELECT id, username FROM ".PRE."users WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$t = $stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row; 
	}
	public function get_user_role($id){
		$sql = "SELECT role_level FROM ".PRE."user_relations WHERE user_id = :id";
		$stmt = $this->pdo->prepare($sql);
		$t = $stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['role_level'];
	}

	public function get_user_relations($id){
		$sql = "SELECT * FROM ".PRE."user_relations WHERE user_id = :id";
		$stmt = $this->pdo->prepare($sql);
		$t = $stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function token_hash($keys, $secret = NULL , $hash = 'sha256'){
		$app = App::config('app');
		if($secret == NULL) {
			$secret = $app['auth'];
		}
		return hash($hash, $keys.$secret);
	}

	/*public function get_admin_pages($role_level){
		if($role_level == 0) {
			$app = App::config('app');
			return $app['default_admin_pages'];
			die();
		}
		$sql = "SELECT meta_text FROM ".PRE."meta_options WHERE name = :name AND value = :value AND meta_int = :level";
		$stmt = $this->pdo->prepare($sql);
		$t = $stmt->execute(array(':name' => 'setting', ':value' => 'admin_pages', ':level' => $role_level));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(! $row) {
			$split_role = explode('.', $role_level);
			if(isset($split_role[1])){
			$prev_role = $split_role[0];
			} else {
			$prev_role = $split_role[0] - 1;	
			}
			return $this->get_admin_pages($prev_role);
		} else {
			return $row['meta_text'];
		}

	} */

	function get_content($str,$lang = NULL){
		$content = array();
		if(strpos($str, '[:') !== false && strpos($str, '[::]') !== false) {
			if($lang != NULL) {
				$lang_a = $lang;
			} else {
				$lang_a = rtrim(LANG_ALIAS,'/');
			}
			$dlang_a = rtrim(DEFAULT_LANG_ALIAS,'/');			
			$langarr = explode("[:", $str);
			$langarr = array_filter($langarr);
			if(end($langarr) == ':]') {
			$last = array_pop($langarr);
				}
			foreach ($langarr as $value) {
				$value = explode(":]", $value);
					if(isset($value[1])) {
						$content[$value[0]] = $value[1];
					}
				}
			if(isset($content[$lang_a])) {
				return $content[$lang_a];
			} else if(isset($content[$dlang_a])) {
				return $content[$dlang_a];
			} else {
				return reset($content);
			}	
		} else if(strpos($str, '(:') !== false && strpos($str, '(::)') !== false) {
			if($lang != NULL) {
				$lang_a = $lang;
			} else {
				$lang_a = rtrim(LANG_ALIAS,'/');
			}
			$dlang_a = rtrim(DEFAULT_LANG_ALIAS,'/');			
			$langarr = explode("(:", $str);
			$langarr = array_filter($langarr);
			if(end($langarr) == ':)') {
			$last = array_pop($langarr);
				}
			foreach ($langarr as $value) {
				$value = explode(":)", $value);
					if(isset($value[1])) {
						$content[$value[0]] = $value[1];
					}
				}
			if(isset($content[$lang_a])) {
				return $content[$lang_a];
			} else if(isset($content[$dlang_a])) {
				return $content[$dlang_a];
			} else {
				return reset($content);
			}	
		} else {
			return $str;
		}
	}
	function dash_item(){
		$app = App::config('app');
		$theme = $this->option('meta_str',array('name' => 'themes', 'value' => 'admin_theme'));
		$splash = $app['themes-path'].$theme.'/splash.php';
		$html = new Html;
		if(DEFAULT_LANG_ALIAS == LANG_ALIAS) {
			$current_page = str_replace(URL.BACKEND_URL, '', CURRENT_URL);
			$lang = '';
		} else {
			$current_page = str_replace(URL.LANG_ALIAS.BACKEND_URL, '', CURRENT_URL);
			$lang = LANG_ALIAS;
		}
		$current_page = rtrim($current_page,'/');
		$current_page = str_replace('/index', '', $current_page);

		$file = $app['themes-path'].$theme.'/config.php';
		$enqueue = new Enqueue;
		$nav = new Nav;
		include($app['app-path'].'config/menu.php');
		if(file_exists($file)){
			include($file);
		}
		
		$nav->icon = array_reduce($nav->icon, 'array_merge', array());
		$nav_icon = '<i class="'.$nav->icon['dashboard'].'"></i> ';
		if(file_exists($splash)) {
			$dash_link = $app['dashboard-url'];
		} else {
			$dash_link = '';
		}
		if($current_page == $dash_link) {
			$active_class = ' active';
		} else {
			$active_class = '';
		}
		$res = '<li class="'.$active_class.'">'.$html->admin_link($nav_icon.__('Dashboard'),$dash_link).'</li>';
		return $res;
	}

	function admin_nav($class = NULL){

		$id = $_SESSION['loggedin']['id'];
		$role = $this->get_user_role($id);
		if($class == NULL) {
			$res = '<ul class="main-nav">';
		} else {
			$res = '<ul class="main-nav '.$class.'">';
		}
		$res .= $this->dash_item();
		$res .= $this->plugin_menu_items($role);
		$res .= $this->menu_items($role);
		$res .= '</ul>';
		return $res;
	}

	function menu_items($role){
		// Get the admin theme

		$user = $this->get_user_info();
		if($user['gender'] == 1) {
			$g = 'm';
		} else {
			$g = 'f';
		}
		// echo $user['gender'];
		$theme = $this->option('meta_str', array('name'=>'themes','value'=>'admin_theme'));
		$app = App::config('app');
		$file = $app['themes-path'].$theme.'/config.php';
		$enqueue = new Enqueue;		
		$nav = new Nav;
		include($app['app-path'].'config/menu.php');
		if(file_exists($file)){
			include($file);
		}

		$nav->icon = array_reduce($nav->icon, 'array_merge', array());
		
		if(DEFAULT_LANG_ALIAS == LANG_ALIAS) {
			$current_page = str_replace(URL.BACKEND_URL, '', CURRENT_URL);
		} else {
			$current_page = str_replace(URL.LANG_ALIAS.BACKEND_URL, '', CURRENT_URL);
		}
		$current_page = rtrim($current_page,'/');
		$current_page = str_replace('/index', '', $current_page);
		// echo $current_page;
		$res = '';
		$html = new Html;
		$active_class = '';
		
		foreach ($menu as $key => $value) {

			// Check if website is enabled and enable pages for backend
			if($app['show-website'] == false && $key == 'pages') {
				// Here we do nothing
			} else if($app['show-website'] == false && $key == 'web-settings') {
				// Here we do nothing
			} else if($app['show-website'] == false && $key == 'forms') {
				// Here we do nothing
			} else {
			// $key =  str_replace('-', '_', $key);

			$checks = explode('/', $current_page);

			if($checks[0] == $key) {
				$pclass = ' active';
			} else {
				$pclass = '';
			}

			if($key == 'profile'){

				if(isset($nav->icon[$key][$g])){
					$nav_icon = '<i class="'.$nav->icon[$key][$g].'"></i> ';
				} else {
					$nav_icon = '';
				}

			} else {
				if(isset($nav->icon[$key])){
					$nav_icon = '<i class="'.$nav->icon[$key].'"></i> ';
				} else {
					$nav_icon = '';
				}
			}				

			if(is_array($value)) {
				$item = '';
				$i = 1;
				$page = '';
				foreach ($value as $k => $v) {

					
					if($this->is_admin_page_allowed($role,$key . '/' . $k)  == true) {
						
						$page = $key . '/' . $k;
						$pos = strpos($current_page, $page);
						$page = str_replace('/index', '', $page);
						// check if method var is in url
						$chend = explode('/', $current_page);
						$endvar = '';
						if(isset($chend[2])) {
							$endvar = '/'.$chend[2];
						} 

						if($current_page == $page || $current_page == $page . $endvar) {
							$active_class = ' active';
						} else {
							$active_class = '';
						}
						$check = explode('/', $current_page);
						$parent = $check[0];
						if($parent == $key) {
							$parentclass = ' active';
							$style = '';
						} else {
							$parentclass = '';
							$style = '';
						}
						$item .= '<li class="'.$key.'-'.$k.$active_class.'">'.$html->admin_link(__($v),$page).'</li>';
						$i++;
					}
				}
				
				if($i==2){

					if($page == $key){
						$name = ucfirst(str_replace(array('-','_'), ' ', $key));
					} else {
						$name = $v;
					}
					$page = str_replace('/index', '', $page);
					if($current_page == $page) {
							$active_class = ' active';
						}else {
							$active_class = '';
						}
					$res .= '<li class="'.$key.'-'.$k.$active_class.'">'.$html->admin_link($nav_icon.__($name),$page).'</li>';
				} else if($i>2) {
					if($parentclass == '') {
						$res .= '<li class="parent parent-'.$key.$parentclass.'"><a>'.$nav_icon.__(ucfirst(str_replace(array('-','_'), ' ', $key))).'<span class="fa fa-chevron-down"></span></a>';
					} else {
						$res .= '<li class="parent parent-'.$key.$parentclass.'"><a>'.$nav_icon.__(ucfirst(str_replace(array('-','_'), ' ', $key))).'<span class="fa fa-chevron-up"></span></a>';
					}
					

					$res .= '<ul class="submenu nav child_menu" '.$style.'>'.$item.'</ul></li>';

				}
			} else {
				$page = $key . '/index';				
					if($this->is_admin_page_allowed($role,$page)  == true) {
						$page = str_replace('/index', '', $page);

					if($current_page == $page) {
							$active_class = ' active';
						}else {
							$active_class = '';
						}
				$res .= '<li class="'.$key.'-'.'index'.$active_class.$pclass.'">'.$html->admin_link($nav_icon.$value,$page).'</li>';
				}
			}
			}
		} // end foreach ($menu as $key => $value)

		return $res;


	}
	public function get_all_plugins(){
		$sql = "SELECT plugin FROM ".PRE."plugins WHERE active = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function plugin_menu_items($role){
		$res = '';
		$onepage = '';
		$active_class = '';
		$pageclass = '';
		$html = new Html;
		$enqueue = new Enqueue;
		$rows = $this->get_all_plugins();
		$app = App::config('app');
		$i = 0;
		if(DEFAULT_LANG_ALIAS == LANG_ALIAS) {
			$current_page = str_replace(URL.BACKEND_URL, '', CURRENT_URL);
		} else {
			$current_page = str_replace(URL.LANG_ALIAS.BACKEND_URL, '', CURRENT_URL);
		}
		$current_page = rtrim($current_page,'/');
		$current_page = str_replace('/index', '', $current_page);

		foreach ($rows as $row) {
			$parentclass = '';
			$style = '';
			$plugin['icon'] = '';
			$file = $app['plugins-path'].$row['plugin'].'/config.php';
			$nav = new Nav;
			include($app['app-path'].'config/menu.php');
			$theme = $this->option('meta_str', array('name'=>'themes','value'=>'admin_theme'));
			$themefile = $app['themes-path'].$theme.'/config.php';
			include($themefile);
			if(file_exists($file)) {
				include($file);
				$s = count($nav->subs);
				$m = count($nav->main);
			}
			if($plugin['icon'] == '') {
				$plugin['icon'] = $nav->default_icon;
			}
			$pln = $row['plugin'];
			$nav_icon = '<i class="'.$plugin['icon'].'"></i> ';
			$item = '';
			$mitem = '';
			if(isset($plugin['name'])){
				$pagename = __($plugin['name'],$pln);
			} else {
				$pagename = __(ucfirst(str_replace(array('-','_'), ' ', $pln)),$pln);
			}
			$p = 0;
			$mp = 0;
			$check = explode('/', $current_page);
			$parent = str_replace('-', '_', $check[0]);
			if($parent == $pln) {
				$parentclass = ' active';
				$style = '';
			}

			if($m > 0) {
				//print_r($nav->main);
				//echo $pln;
				
				foreach ($nav->main as $mk => $mv) {
					$active_class = '';
					$pic = '';
					if($mv['link'] != NULL) {
						if(strpos($mv['icon'], '<img')) {
							$pic = $mv['icon'] .' ';
						} else {
							$pic = '<i class="'.$mv['icon'].'"></i> ';
						}
					}

					$page = str_replace('_', '-', $pln).'/'.$mv['link'];
					if($this->is_admin_page_allowed($role,$page)) {
						$pagename = __(ucfirst(str_replace(array('-','_'), ' ', $mk)),$pln);
						$pageclass = str_replace('/', '-', $page);		
						$onepage = str_replace('/index', '', $page);
						// check if method var is in url
						$chend = explode('/', $current_page);
						$endvar = '';
						if(isset($chend[6])) {
							$endvar = '/'.$chend[2].'/'.$chend[3].'/'.$chend[4].'/'.$chend[5].'/'.$chend[6];
						} else if(isset($chend[5])){
							$endvar = '/'.$chend[2].'/'.$chend[3].'/'.$chend[4].'/'.$chend[5];
						} else if(isset($chend[4])){
							$endvar = '/'.$chend[2].'/'.$chend[3].'/'.$chend[4];
						} else if(isset($chend[3])){
							$endvar = '/'.$chend[2].'/'.$chend[3];
						} else if(isset($chend[2])){
							$endvar = '/'.$chend[2];
						} 
						if($current_page == $onepage || $current_page == $onepage . $endvar){
						$active_class = ' active';	
						}
						$mitem .= '<li class="'.$pageclass.$active_class.'">'.$html->admin_link($pic.$pagename,$onepage).'</li>';
						$mp++;
					}

				}

				if($mp > 0) {
					$res .= $mitem ;
				}


			}

			if($s > 0) {
				foreach ($nav->subs as $k => $v) {
					$active_class = '';
					$page = str_replace('_', '-', $pln).'/'.$v;
					
					if($this->is_admin_page_allowed($role,$page)) {
						$pagename = __(ucfirst(str_replace(array('-','_'), ' ', $k)),$pln);
						$pageclass = str_replace('/', '-', $page);		
						$onepage = str_replace('/index', '', $page);
						// check if method var is in url
						$chend = explode('/', $current_page);
						$endvar = '';
						if(isset($chend[6])) {
							$endvar = '/'.$chend[2].'/'.$chend[3].'/'.$chend[4].'/'.$chend[5].'/'.$chend[6];
						} else if(isset($chend[5])){
							$endvar = '/'.$chend[2].'/'.$chend[3].'/'.$chend[4].'/'.$chend[5];
						} else if(isset($chend[4])){
							$endvar = '/'.$chend[2].'/'.$chend[3].'/'.$chend[4];
						} else if(isset($chend[3])){
							$endvar = '/'.$chend[2].'/'.$chend[3];
						} else if(isset($chend[2])){
							$endvar = '/'.$chend[2];
						} 
						if($current_page == $onepage || $current_page == $onepage . $endvar){
						$active_class = ' active';	
						}
						$item .= '<li class="'.$pageclass.$active_class.'">'.$html->admin_link($pagename,$onepage).'</li>';
						$p++;
					}
					
				}
				if($p > 1) {
					if($parentclass == '') {
						$res .= '<li class="parent parent-'.$pln.$parentclass.'"><a>'.$nav_icon . __(ucfirst(str_replace(array('-','_'), ' ', $pln)),$pln).'<span class="fa fa-chevron-down"></span></a>';
					} else {
						$res .= '<li class="parent parent-'.$pln.$parentclass.'"><a>'.$nav_icon . __(ucfirst(str_replace(array('-','_'), ' ', $pln)),$pln).'<span class="fa fa-chevron-up"></span></a>';
					}
					

					$res .= '<ul class="submenu nav child_menu" '.$style.'>'.$item.'</ul></li>';
					
				} else if($p == 0){
					// This is for when user is not allowed
				} else {
					$active_class = '';
					if($current_page == $onepage){
						$active_class = ' active';	
						}
					$res .= '<li class="test '.$p.' - '.$pageclass.$active_class.'">'.$html->admin_link($nav_icon.' '.$pagename,$onepage).'</li>';
				}
				
			} else {
				$page = $pln.'/index';
				if($this->is_admin_page_allowed($role,$page)) {
					$page = str_replace('/index', '', $page);
				if($mp > 0) {
					// $res .= '<li class="'.$pln.'-'.'index'."".$parentclass.'">'.$html->admin_link($nav_icon.$pagename,$page).'</li>';
				}
				
				}
			}

			
		
		}

		return $res;
	}

	function is_admin_page_allowed($role,$page){
		$page = str_replace('-', '_', $page);
	if($role > 99){
		return true;
	} else {
		$sql = "SELECT meta_text FROM ".PRE."meta_options WHERE name = :name AND value = :value";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':name' => 'admin_pages',':value' => $role));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row['meta_text'] != ''){
			$app_pages = explode(',', $row['meta_text']);
			if(in_array($page, $app_pages)) {
				return false;
			} else {
				return true;
			}

		} else {
			return true;
		}

	}		
		
	
	}

	public function column($col,$val){
		$this->column = $col;
		$this->db_where = $val;
	}

	public function save($arrs){
		$res = 0;
		if(isset($arrs['nonce'])) {
			if(in_array($arrs['nonce'], $_SESSION['nonce'])) {
				$key = array_search($arrs['nonce'], $_SESSION['nonce']);
				unset($_SESSION['nonce'][$key]);
				if(!empty($arrs) && Message::$required == '' && $this->no_save < 1){
					$bind = array();
					if(isset($this->name)){
					$table = strtolower($this->name);	
					} else {
					$table = str_replace('_model','',strtolower(get_class($this)));	
					}
					if($this->id != ''){
					$set ='';
					foreach ($arrs as $key => $value) {
						if($this->db_column_exists($table,$key)) {
							$set .= "$key=:$key, ";
							$bind[":$key"] = $value;
						}
					}
					$bind[':id'] = $this->id;
					$set = rtrim($set,', ');
					$sql = "UPDATE ".PRE."$table SET " . $set ." WHERE id=:id";
					} else if($this->column != '' && $this->db_where != '') {
						$col = ':'.$this->column;
						$id = $this->column;
						$set ='';
						foreach ($arrs as $key => $value) {
							if($this->db_column_exists($table,$key)) {
								$set .= "$key=:$key, ";
								$bind[":$key"] = $value;
							}
						}
						$bind[$col] = $this->db_where;
						$set = rtrim($set,', ');
						$sql = "UPDATE ".PRE."$table SET " . $set ." WHERE ".$id."=$col";
					} else {
						$tab = '';
						$val = '';
						foreach ($arrs as $key => $value) {
						if($this->db_column_exists($table,$key)) {
							$tab .= "$key, ";
							$val .= ":$key,";
							$bind[":$key"] = $value;
							}
						}
						$tab = rtrim($tab,', ');
						$val = rtrim($val,', ');
						$sql = "INSERT INTO ".PRE."$table($tab) VALUES($val)";
					}
					$stmt = $this->pdo->prepare($sql);
					$res = $stmt->execute($bind);
					if($this->id == '' && $this->column == ''){ 
						$res = $this->pdo->lastInsertId();
					} else {
						$res = $stmt->rowCount() ? 1 : '';
					}

				}

			} else {
				$res = 1;
			}

		} else {
			if(!empty($arrs) && Message::$required == '' && $this->no_save < 1){
				$bind = array();
				if(isset($this->name)){
				$table = strtolower($this->name);	
				} else {
				$table = str_replace('_model','',strtolower(get_class($this)));	
				}
				
				if($this->id != ''){
				$set ='';
				foreach ($arrs as $key => $value) {
					if($this->db_column_exists($table,$key)) {
						$set .= "$key=:$key, ";
						$bind[":$key"] = $value;
					}
				}
				$bind[':id'] = $this->id;
				$set = rtrim($set,', ');
				$sql = "UPDATE ".PRE."$table SET " . $set ." WHERE id=:id";
				} else if($this->column != '' && $this->db_where != '') {
					$col = ':'.$this->column;
					$id = $this->column;
					$set ='';
					foreach ($arrs as $key => $value) {
						if($this->db_column_exists($table,$key)) {
							$set .= "$key=:$key, ";
							$bind[":$key"] = $value;
						}
					}
					$bind[$col] = $this->db_where;
					$set = rtrim($set,', ');
					$sql = "UPDATE ".PRE."$table SET " . $set ." WHERE ".$id."=$col";
				} else {
					$tab = '';
					$val = '';
					foreach ($arrs as $key => $value) {
					if($this->db_column_exists($table,$key)) {
						$tab .= "$key, ";
						$val .= ":$key,";
						$bind[":$key"] = $value;
						}
					}
					$tab = rtrim($tab,', ');
					$val = rtrim($val,', ');
					$sql = "INSERT INTO ".PRE."$table($tab) VALUES($val)";
				}
				$stmt = $this->pdo->prepare($sql);
				$res = $stmt->execute($bind);
				if($this->id == '' && $this->column == ''){ 
					$res = $this->pdo->lastInsertId();
				} else {
					$res = $stmt->rowCount() ? 1 : '';
				}
			}
		}
		return $res;
	}
	public function find($cols = '*', $where = NULL, $limit = ''){
		$cols = strtolower($cols);
		if($cols == 'all') {
			$cols = '*';
		}
		if(isset($this->name)){
			$table = strtolower($this->name);	
			} else {
			$table = str_replace('_model','',strtolower(get_class($this)));	
			}
		if($limit != '') {
			$limit = 'LIMIT '.$limit;
		}
		$sql = "SELECT $cols FROM ".PRE."$table $where $limit";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_keep_user_info($keep){
		$sql = "SELECT id, username FROM ".PRE."users WHERE keep = :keep";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':keep' => $keep));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	private function db_column_exists($table,$column){
		$stmt = $this->pdo->prepare("SHOW COLUMNS FROM ".PRE."$table WHERE Field = '$column'");
		$stmt->execute();
		$row = $stmt->fetch();
		if($row){
			return true;
		} else {
			return false;
		}
	}

	public function paginate($limit,$all,$link = '',$get = NULL){
		$link = admin_url($link);
		if(isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
		if(isset($_GET['s'])) {
			$search = '&s='.$_GET['s'];
		} else {
			$search = '';
		}
		if(isset($_GET['orderby'])){
			$orderby = '&orderby='.$_GET['orderby'];
		} else {
			$orderby = '';
		}
		if($get != NULL) {
			foreach ($get as $value) {
				if(isset($_GET[$value])) {
					$search .= '&'.$value.'='.$_GET[$value];
				}
				
			}
		}
		$pages = ceil($all/$limit);
		$res = '';
		if($page == 1) {
			$res .= '<li class="paginate page nolink prev">&nbsp;</li>';
		} else {
			$prev = $page-1;
			$res .= '<li class="paginate page prev"><a href="'.$link.'?page='.$prev.$search.$orderby.'">&nbsp;</a></li>';
		}
		if($pages <= 5) {
			for ($x = 1; $x <= $pages; $x++) {
			if($page == $x) {
				$res .= '<li class="paginate page active">'.$x.'</li>';
				} else {
				$res .= '<li class="paginate page"><a href="'.$link.'?page='.$x.$search.$orderby.'">'.$x.'</a></li>';
				}
			}
		} else {
			for ($x = 1; $x <= $pages; $x++) {
				$before = $page - 1;
				$beforeB = $page - 2;
				$after = $page + 1;
				$afterB = $page + 2;
				if($page == $x) {
					$res .= '<li class="paginate page active">'.$x.'</li>';
				} else if($x == $pages ){
					$res .= '<li class="paginate page last-page"><a href="'.$link.'?page='.$x.$search.$orderby.'">'.$x.'</a></li>';
				} else if($x == 1 && $page != 1 ){
					$res .= '<li class="paginate page first-page"><a href="'.$link.'?page='.$x.$search.$orderby.'">'.$x.'</a></li>';
				} else if($before > 1 && $x == $before){
					$res .= '<li class="paginate page before-blank">...</li>';
				} else if($before > 1 && $x == $beforeB){
					// $res .= '<li class="paginate page before-blank">...</li>';
				} else if($after < $pages && $x == $after){
					$res .= '<li class="paginate page after-blank">...</li>';
				} else if($after < $pages && $x == $afterB){
					// $res .= '<li class="paginate page after-blank">...</li>';
				} else {
				
				}
			}			
		}	
		if($page == $pages) {
			$res .= '<li class="paginate page nolink next">&nbsp;</li>';
		} else {
			$next = $page+1;
			$res .= '<li class="paginate page next"><a href="'.$link.'?page='.$next.$search.$orderby.'">&nbsp;</a></li>';
		}
		if($all > $limit) {
			return '<ul class="pagination">'.$res.'</ul>';
		}
		
		
		}

}