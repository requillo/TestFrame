<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function __($text,$domain = NULL,$lang = NULL){
	if($lang == NULL) {
		$tl = LANG;
	} else {
		$tl = $lang;
	}
	$plugins = array();
	$themes = array();
	$webthemes = array();
	$app = App::config('app');
	$default_file = $app['language-path'].$tl.'-app.ini';
	
	if($domain == NULL) { 
		$file = $default_file;
	} else {
		// Check is website is on
		if($app['show-website'] == true){
			$webthemes = array();
			foreach (glob($app['webthemes-path']."*",GLOB_ONLYDIR) as $key => $value) {
				$value = str_replace($app['webthemes-path'], '', $value);
				$webthemes[$key] = $value;
			}
		}
	foreach (glob($app['plugins-path']."*",GLOB_ONLYDIR) as $key => $value) {
				$value = str_replace($app['plugins-path'], '', $value);
				$plugins[$key] = $value;
			}
	foreach (glob($app['themes-path']."*",GLOB_ONLYDIR) as $key => $value) {
				$value = str_replace($app['themes-path'], '', $value);
				$themes[$key] = $value;
			}
		// Check if your in backend or frontend	
		if(in_array($domain, $themes)) {
			$file = $app['themes-path'].$domain.'/lang/'.LANG.'-'.$domain.'.ini';
		} else if(in_array($domain, $plugins)) {
			$file = $app['plugins-path'].$domain.'/lang/'.LANG.'-'.$domain.'.ini';
		} else {
			$file = $default_file;
		}


	}

	//
	$file;
	if(file_exists($file)){
	$data = file_get_contents($file);
	$goodstr = str_replace('"',"'" , $data);
	$goodstr = stripslashes(stripslashes($goodstr));
	$goodstr = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $goodstr);
	$goodstr = preg_replace("/^#..*\\n/m", "\n", $goodstr);
	$goodstr = str_replace(array(' => ','=>',"\n"), array('":"','":"','","'), $goodstr);
	$goodstr = ltrim($goodstr,'",');
	$goodstr = '{"' .$goodstr.'"}';
	$goodstr = str_replace(',""', '' , $goodstr);
	} else {
	$goodstr = '';
	}
	$lang = json_decode($goodstr,true);

	if(isset($lang[$text]) && $lang[$text] != '') {
			return $lang[$text];
		} else {
			return $text;
		}
}

function widget($class,$widget,$attr = NULL){
	$app = App::config('app');
	$widget = str_replace('-', '_', $widget);
	$page1 = $class.'/'.$widget;
	$widget = 'widget_'.$widget;
	$page = $class.'/'.$widget;
	$controller = new controller;
	$controller->is_plugin($class);
	$allowed = $controller->model->is_admin_page_allowed($controller->user['role_level'],$page1);
	if($allowed && class_exists($class)) {
		$viewvars = array();
		$wc = new $class;
		if(method_exists($wc,$widget)) {
			$wc->$widget($attr);
		}
		$viewvars['var'] = $wc->var;
		$viewvars['var']['title'] = $wc->title;
		$viewvars['admin_theme'] = $controller->model->option('meta_str', array('name'=>'themes','value'=>'admin_theme'));
		$viewvars['class'] = $class;
		$viewvars['method'] = $widget;
		$wc->view->admin_widget_content($viewvars);
	}
}

function widget_isset($class,$widget,$attr = NULL){
	$pass = false;
	$widget = str_replace('-', '_', $widget);
	$page1 = $class.'/'.$widget;
	$widget = 'widget_'.$widget;
	$page = $class.'/'.$widget;
	$controller = new controller;
	$controller->is_plugin($class);
	$allowed = $controller->model->is_admin_page_allowed($controller->user['role_level'],$page1);
	if($allowed && class_exists($class)) {
		$viewvars = array();
		$wc = new $class;
		if(method_exists($wc,$widget)) {
			$pass = 1;
		}
	} else {
		$pass = false;
	}
	return $pass;
}

function get_admin_widgets($pos = NULL){
	$Appearance = new Appearance_model;
	$widgets = $Appearance->get_admin_widgets($pos);
	$all_widgets = array();
	if(!empty($widgets)) {
		foreach ($widgets as $key => $value) {
			$tw = json_decode($value['widget_data'], true);
			$all_widgets = array_merge($all_widgets,$tw);
		}
		foreach ($all_widgets as $val) {
			$clmet = explode('/', $val['widget']);
			if(widget_isset($clmet[0],$clmet[1])) {
				widget($clmet[0],$clmet[1]);
			}
		}
	}
}

function admin_menu($class = NULL){
	$pos = strpos(CURRENT_URL, admin_url());
	if(isset($_SESSION['loggedin']['id']) && isset($_SESSION['loggedin']['username']) && $pos !== false){
		$m = new model;
		echo '<div id="main_admin_menu">';
		echo $m->admin_nav($class);
		echo '</div>';
	}
}

function plugin_path(){
	$app = App::config('app');
	$app['plugins-path'] = str_replace(BASEPATH, '', $app['plugins-path']);
	return URL.$app['plugins-path'].getcwd();
}

function url($link = ''){
	if(LANG_ALIAS == DEFAULT_LANG_ALIAS) {
		return URL.$link;
	} else {
		return URL.LANG_ALIAS.$link;
	}

}

function admin_url($link = ''){
	if(LANG_ALIAS == DEFAULT_LANG_ALIAS) {
		return URL.BACKEND_URL.$link;
	} else {
		return URL.LANG_ALIAS.BACKEND_URL.$link;
	}
}

function default_image(){
	$model = new model;
	$theme = $model->option('meta_str', array('name'=>'themes','value'=>'admin_theme'));
	$app = App::config('app');
	$file1 = $app['themes-path'].$theme.'/assets/images/defaul-image.jpg';
	$file2 = $app['themes-path'].$theme.'/assets/images/defaul-image.png';
	$file3 = $app['assets-path'].'images/no-image.jpg';
	if(file_exists($file1)) {
		$tf = str_replace(BASEPATH, '', $file1);
	} else if(file_exists($file2)) {
		$tf = str_replace(BASEPATH, '', $file2);
	} else {
		$tf = str_replace(BASEPATH, '', $file3);
	}
	return $tf;
}

function country_options($selected = NULL) {
	$res = '';
	$countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Nederland", "Nederlandse Antillen", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

	foreach ($countries as $value) {
		$res .= '<option value="'.$value.'" ';
		if($selected == $value) $res .= 'selected';
		$res .= '>'.$value.'</option>';
		
	}

	return $res;

}

function get_protected_media($file = NULL){
	return admin_url().'media/get-file/'.$file;
}

function get_protected_token_media($file){
	$keys = 'media:protected_file'.$file;
	$token = token_hash($keys);
	return url().'?token='.$token.'&action=media:protected_file&request='.$file;
}

function get_media($file = NULL){
	$file = str_replace('-', '/', $file);
	return URL.'media/uploads/'.$file;
}

function get_media_serverpath($file = NULL){
	$file = str_replace('-', '/', $file);
	return BASEPATH.'media/uploads/'.$file;
}

function get_user($id, $value = 'fname, lname'){
	$user = new Users_model;
	$data = $user->get_user_data($id);
	$value = str_replace(' ', '', $value);
	$values = explode(',', $value );
	$alldata = '';
	foreach ($values as $val) {
		if(isset($data[$val])) {
			$alldata .= $data[$val] . ' ';
		}
	}
		return $alldata;
}

function get_company($id, $value = 'company_name'){
	$user = new Users_model;
	$data = $user->get_companies($id);
	$value = str_replace(' ', '', $value);
	$values = explode(',', $value );
	$alldata = '';
	foreach ($values as $val) {
		if(isset($data[$val])) {
			$alldata .= $data[$val] . ' ';
		}
	}
		return $alldata;
}

function excerpt($text, $length = 150, $ending = '...', $exact = false, $considerHtml = true) {
	if ($considerHtml) {
		// if the plain text is shorter than the maximum length, return the whole text
		if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
			return $text;
		}
		// splits all html-tags to scanable lines
		preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
		$total_length = strlen($ending);
		$open_tags = array();
		$truncate = '';
		foreach ($lines as $line_matchings) {
			// if there is any html-tag in this line, handle it and add it (uncounted) to the output
			if (!empty($line_matchings[1])) {
				// if it's an "empty element" with or without xhtml-conform closing slash
				if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
					// do nothing
				// if tag is a closing tag
				} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
					// delete tag from $open_tags list
					$pos = array_search($tag_matchings[1], $open_tags);
					if ($pos !== false) {
					unset($open_tags[$pos]);
					}
				// if tag is an opening tag
				} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
					// add tag to the beginning of $open_tags list
					array_unshift($open_tags, strtolower($tag_matchings[1]));
				}
				// add html-tag to $truncate'd text
				$truncate .= $line_matchings[1];
			}
			// calculate the length of the plain text part of the line; handle entities as one character
			$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
			if ($total_length+$content_length> $length) {
				// the number of characters which are left
				$left = $length - $total_length;
				$entities_length = 0;
				// search for html entities
				if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
					// calculate the real length of all entities in the legal range
					foreach ($entities[0] as $entity) {
						if ($entity[1]+1-$entities_length <= $left) {
							$left--;
							$entities_length += strlen($entity[0]);
						} else {
							// no more characters left
							break;
						}
					}
				}
				$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
				// maximum lenght is reached, so get off the loop
				break;
			} else {
				$truncate .= $line_matchings[2];
				$total_length += $content_length;
			}
			// if the maximum length is reached, get off the loop
			if($total_length>= $length) {
				break;
			}
		}
	} else {
		if (strlen($text) <= $length) {
			return $text;
		} else {
			$truncate = substr($text, 0, $length - strlen($ending));
		}
	}
	// if the words shouldn't be cut in the middle...
	if (!$exact) {
		// ...search the last occurance of a space...
		$spacepos = strrpos($truncate, ' ');
		if (isset($spacepos)) {
			// ...and cut the text in this position
			$truncate = substr($truncate, 0, $spacepos);
		}
	}
	// add the defined ending to the text
	$truncate .= $ending;
	if($considerHtml) {
		// close all unclosed html-tags
		foreach ($open_tags as $tag) {
			$truncate .= '</' . $tag . '>';
		}
	}
	return $truncate;
}

function token($str = NULL) {
	$app = App::config('app');
	$key = md5($app['auth'].$str);
	$key = hash('sha256', $key);
	return $key;
}

function token_hash($keys, $secret = 'requillo', $hash = 'sha256'){
		$app = App::config('app');
		return hash($hash, $keys.$app['auth']);
}

// This wil convert the links
function token_link($action,$request,$user = NULL){
	$keys = $action.$request;
	$token = token_hash($keys);
	if($user == NULL) {
		$nonce = '';
	} else {
		$nonce = '&user='.$user.'&nonce='.token_hash($keys.$user);
	}
	return url().'?token='.$token.'&action='.$action.'&request='.$request.$nonce;
}

function replace_spec_chars($str,$replace = ""){
	$data = strtolower(preg_replace('/[^A-Za-z0-9]/', $replace, $str));
	return $data;
}

function parent_current($arr, $curr_url) {
    $res = '';
    foreach ($arr as $value) {
        $url = url($value['link'].'/');
        if(isset($value['children'])){ 
            $res = parent_current($value['children'], $curr_url);
        }
        if(rtrim( $curr_url,'/') == rtrim($url,'/')) {
        $res = 'active-parent ';
        break;
        }
    }
return $res;
}

function site_navigation($menu = NULL){
	if($menu != NULL) {
		if(is_array($menu)) {
			if(isset($menu['menu'])) {
				$menu_name = $menu['menu'];
			} else {
				$menu_name = NULL;
			}

			if(isset($menu['class'])) {
				$class = $menu['class'];
			} else {
				$class = 'navigation';
			}
		
		} else {
			$menu_name = $menu;
			$class = 'navigation';
		}

	} else {
		$menu_name = $menu;
		$class = 'navigation';
	}
	$website = new web_settings_model();
	$menudata = $website->menu_json_data($menu_name);
	$arr = json_decode($menudata, true);
	$res = menu_html($arr,$class);
	echo $res;
}

function menu_html($arr,$class = 'navigation'){
	if(!empty($arr)){
		$curr_url = CURRENT_URL;
	    $res = '<ul class="'.$class.'">';
	    foreach ($arr as $value) {
	    	if($value['link'] == '') {
	    		$url = url();
	    	} else if( strpos($value['link'], 'http') !== false){	
	    		$url = $value['link'];
	    	} else {
	    		$url = url($value['link'].'/');
	    	}
	       	$curr_pos = str_replace(url(), '', $curr_url);
	       	$url_pos = $value['link'];
	       	if($url_pos = '') {
	       		$url_pos = '1';
	       	}
	        $spec = strtolower(preg_replace("/[^A-Za-z0-9]/", "-", $value['link'])).' ';
	        if(isset($value['children'])){
	            $activeparent = parent_current($value['children'], $curr_url);
	            $pclass = 'parent ';
	        } else {
	            $pclass = '';
	            $activeparent = '';
	        }
	        if(rtrim( $curr_url,'/') == rtrim($url,'/')) {
	            $active = 'active ';
	        } else if(strpos($curr_pos, $url_pos) !== false) {
	        	$active = 'active-parent-link ';
	        } else {
	            $active = '';
	        }
	        $res .= '<li class="'.$pclass.$activeparent.$active.$spec.$value['type'].'"><a href="'.$url.'">'.language_content($value['name']).'</a>';
	        if(isset($value['children'])){
	            $res .= menu_html($value['children'], 'submenu');
	        }
	        $res .= '</li>';
	    }
	    $res .= '</ul>';
	    return $res;
    }
}

function web_logo($class = NULL){
	$model = new model;
	$logo = $model->option('meta_text', array('name'=>'website','value'=>'web_logo'));
		if($logo != '') {
			echo '<img src="'.get_media($logo).'" class="website-logo '.$class.'">';
		}
}

function favicon(){
	$model = new model;
	$logo = $model->option('meta_text', array('name'=>'website','value'=>'favicon'));
	echo get_media($logo);
}

function language_content($str,$lang = NULL){
	$model = new model;
	return $model->get_content($str,$lang);
}

function language_selector($option = array()){
	$app = App::config('app');


	if(!isset($option['class'])) {
		$option['class'] = '';
	}
	if(!isset($option['style'])) {
		$option['style'] = 'select';
	}
	if(!isset($option['icon'])) {
		$option['icon'] = '<i class="caret"></i>';
	}
	$model = new model;
	$def_lang = rtrim(DEFAULT_LANG_ALIAS,'/');
	$l_a = rtrim(LANG_ALIAS,'/');
	$langs = $model->option('meta_text', array('name'=>'settings','value'=>'lang_name'));
	$multilang = $model->option('meta_int', array('name'=>'settings','value'=>'multilang'));
	$admin_theme = $model->option('meta_str', array('name'=>'themes','value'=>'admin_theme'));
	$ft = $app['themes-path'].$admin_theme.'/assets/images/flags/';
	$fm = $app['assets-path'].'images/flags/';
	$uri_ft = str_replace(BASEPATH, '', $ft);
	$uri_fm = str_replace(BASEPATH, '', $fm);;
	$flags = array();
	$thflags = array();
	foreach (glob($fm."*.png") as $filename) {
		$fl = explode('/', $filename);
		$fl = end($fl);
		$fmn = explode('.', $fl);
		   $flags[$fmn[0]] = URL.$uri_fm.$fl;
		}

	if(file_exists($ft)) {
		foreach (glob($ft."*.png") as $filename) {
		    $fl = explode('/', $filename);
			$fl = end($fl);
			$fmn = explode('.', $fl);
			   $thflags[$fmn[0]] = URL.$uri_ft.$fl;
		}
	}
	$langs = json_decode($langs, true);
	$olang = $langs;
	if(isset($olang[$def_lang])) {
		unset($olang[$def_lang]);
	}
	if(isset($langs[$l_a])) {
		$btn_txt = $langs[$l_a];
	} else {
		$btn_txt = __('Select language');
	}
	$url = rtrim(admin_url(),'/');
	$current = CURRENT_URL;
	$cur = str_replace($url, '', $current);
	$cur = ltrim($cur,'/');
	$default_link = URL.BACKEND_URL.$cur;
	if($default_link == CURRENT_URL) {
		$ms = 'selected';
	} else {
		$ms = '';
	}
	$ss = '<select class="form-control">';
	$se = '</select>';
	if($option['style'] == 'select') {
		$option = '<option value="'.$default_link.'" '.$ms.'>'.$langs[$def_lang].'</option>';
		foreach ($olang as $key => $value) {
			$this_url = URL.$key.'/'.BACKEND_URL.$cur;
			if($this_url == CURRENT_URL) {
				$ms = 'selected';
			} else {
				$ms = '';
			}
			$option .= '<option value="'.$this_url.'" '.$ms.'>'.$value.'</option>';
		}

		$language_selector = $ss.$option.$se;

	} else if($option['style'] == 'alias'){
		$option = '<option value="'.$default_link.'" '.$ms.'>'.strtoupper($def_lang).'</option>';
		foreach ($olang as $key => $value) {
			$this_url = URL.$key.'/'.BACKEND_URL.$cur;
			if($this_url == CURRENT_URL) {
				$ms = 'selected';
			} else {
				$ms = '';
			}
			$option .= '<option value="'.$this_url.'" '.$ms.'>'.strtoupper($key).'</option>';
		}

		$language_selector = $ss.$option.$se;

	} else if($option['style'] == 'dropdown'){

		$add = '<div class="dropdown">';
		$add .= '<button class="btn btn-default dropdown-toggle" type="button" id="select_language" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
		$add .= $btn_txt;
		$add .= ' <span class="caret"></span></button>';
		$add .= '<ul class="dropdown-menu" aria-labelledby="select_language">';
		foreach ($langs as $key => $value) {
			if($key != $l_a) {
				if($key == $def_lang) {
					$this_url = URL.BACKEND_URL.$cur;
				} else {
					$this_url = URL.$key.'/'.BACKEND_URL.$cur;
				}
				$add .= '<li><a href="'.$this_url.'">'.$value.'</a></li>';
			}

		}
		$add .= '</ul></div>';
		$language_selector = $add;

	} else if($option['style'] = 'dropdown-in-list') {
		$add = '<li class="dropdown">';
		$add .= '<a href="#" class="dropdown-toggle" id="select_language" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
		if(isset($thflags[$l_a])) {
			$add .= '<span class="lang-flag main-flag"><img src="'.$thflags[$l_a].'"></span>';
		} else if(isset($flags[$l_a])) {
			$add .= '<span class="lang-flag"><img src="'.$flags[$l_a].'"></span>';
		}
		$add .= '<span class="lang-text main-text">'.$btn_txt.'</span>';
		$add .= ' '.$option['icon'].'</a>';
		$add .= '<ul class="dropdown-menu '.$option['class'].'" aria-labelledby="select_language">';
		foreach ($langs as $key => $value) {
			if($key != $l_a) {
				if($key == $def_lang) {
					$this_url = URL.BACKEND_URL.$cur;
				} else {
					$this_url = URL.$key.'/'.BACKEND_URL.$cur;
				}
				$add .= '<li><a href="'.$this_url.'">';
				if(isset($thflags[$key])) {
					$add .= '<span class="lang-flag"><img src="'.$thflags[$key].'"></span>';
				} else if(isset($flags[$key])) {
					$add .= '<span class="lang-flag"><img src="'.$flags[$key].'"></span>';
				}
				$add .= '<span class="lang-text">'. $value.'</span></a></li>';
			}

		}
		$add .= '</ul></li>';
		$language_selector = $add;

	}
	if($multilang == 1) {
		return $language_selector;
	}
}

// $add = whether to add the separater to the number
// $sep = the decimal separater character  
function separate_decimal($number, $add = true, $sep = ','){
	$res = '';
	$t_number = explode($sep, $number);
	if($add == true) {
		$s = '<span class="the_num sep">'.$sep.'</span>';
	} else {
		$s = '';
	}
	$res .= '<span class="the_num b_num">'.$t_number[0].'</span>';
	if(isset($t_number[1])) {
		$res .= $s.'<span class="the_num e_num">'.$t_number[1].'</span>';
	}
	return $res;	
}

function is_admin_allow($page){
	$res = false;
	$page = trim($page,'/');
	$cm = explode('/', $page);
	$cont = new controller;
	$a = $cont->is_plugin($cm[0]);
	if($a['allow'] && $cont->model->is_admin_page_allowed($cont->user['role_level'],$page)) {
		$res = true;
	}
	return $res;
}

// convert color hex to rgb
function hex2rgb( $colour ) {
        if ( $colour[0] == '#' ) {
                $colour = substr( $colour, 1 );
        }
        if ( strlen( $colour ) == 6 ) {
                list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
        } elseif ( strlen( $colour ) == 3 ) {
                list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
        } else {
                return false;
        }
        $r = hexdec( $r );
        $g = hexdec( $g );
        $b = hexdec( $b );
        return $r . ','.$g . ',' .$b;
}