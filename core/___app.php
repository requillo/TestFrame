<?php
class App {
	public static $vars = array();
	public function __construct() {
		// Start Sessions and header
		session_start();
		ob_start();
		// The Application base path
		define('BASEPATH',str_replace('core','',dirname(__FILE__)));
		// Current url
		define('HTTP',(isset($_SERVER['HTTPS']) ? "https" : "http"));
		$actual_link = HTTP . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		define('CURRENT_URL',$actual_link);
		// HTML Wrappers
        $html_start = '<!Doctype html>
                        <html>
                        <head>
                            <meta charset="utf-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1">
                            <title>Something went wrong!</title>                            
                        </head>
                        <body>';
        $html_end = '</body></html>';
		// Include config files
		$app = App::config('app');
		// Set debugging mode
		if($app['app-debug'] == false) {
		ini_set('display_errors', 'Off');	
			} else {
		ini_set('display_errors', 'On');		
		}
		// Set backend url
		if($app['show-website'] == true) {
		define('BACKEND_URL',$app['admin-url'].'/');
		$this->website = 1;
		} else {
		define('BACKEND_URL','');
		$this->website = 0;
		}
		// Set logout url
		define('LOGOUT_URL', $app['logout-url']);
		// Set Api uri
        define('API_URL', $app['api-url']);
        
		// Auto include core classes when use
		function classloader($class) {
            $app = App::config('app');
            $file1 =  'core/'.strtolower($class) . '.php';
            $file2 = $app['controllers-path'] . strtolower($class) . '.php';
            $file3 = $app['helpers-path'] . strtolower($class) . '.php';
            $file4 = $app['models-path'] . strtolower($class) . '.php';
            if(file_exists($file1)) {
                include $file1;
            } else if(file_exists($file2)){
                include $file2; 
            } else if(file_exists($file3)){
                include $file3; 
            } else if(file_exists($file4)) {
                include $file4; 
            }
        }
		spl_autoload_register('classloader');
		// Get or set url
		if(isset($_GET['url'])){
			$url = $_GET['url'];
		} else {
			$url = 'index';
		}
		// Get url pieces
		$this->url =explode('/',  rtrim($url,'/'));
		// Include the helper functions
        include($app['helpers-path'].'functions.php');
		// Enable the controller
		$this->controller = new controller;
		// This is for the application istall
        // Check if database is connected
        if($this->controller->isdbcon == 'No') {
            // Date Time Zone settings
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            // Set main URL
            $uri = trim($_SERVER['REQUEST_URI'],'/');
            $uri = explode('/', $uri);
            $appdomain = '';
            define('URL',$appdomain);
            define('IS_NOT_INSTALLED', true);
            $get_install = $app['helpers-path'] . 'install_app.php';
            $get_error = $app['views-path'] . 'install/error.php';
            if(!isset($this->url[1]) && $this->url[0] == 'index' || $this->url[0] == 'nl' || $this->url[0] == 'es') {
                $dfln = $app['globals-path'].'en_EN_app_install.php';
                if($this->url[0] == 'index') {
                    $fln = 'en_EN_';
                } else if($this->url[0] == 'nl') {
                    $fln = 'nl_NL_';
                } else if($this->url[0] == 'es') {
                    $fln = 'es_ES_';
                }
                $tlf = $app['globals-path'].$fln.'app_install.php';
 
                if(file_exists($tlf)){
                    include($tlf);
                } else {
                    include($dfln);
                }
                if(file_exists($get_install)) {
                include $get_install;
                } else {
                    echo $html_start;
                    echo '<div style="position:fixed; top:20%; text-align:center; left:0; right:0">';
                    echo 'Something went wrong, please check your <b>"app"</b> file in config folder.<br>';
                    echo 'Make sure all the directory paths are correct.<br>';
                    echo '</div>';
                    echo $html_end;
                }
            } else {
                if(file_exists($get_error)) {
                include $get_error;
                } else {
                    echo $html_start;
                    echo '<div style="position:fixed; top:20%; text-align:center; left:0; right:0">';
                    echo 'Something went wrong, please check your <b>"app"</b> file in config folder.<br>';
                    echo 'Make sure all the directory paths are correct.<br>';
                    echo '</div>';
                    echo $html_end;
                }
            }
            // Kill the appliction if is not installed
            die();
        } else {
            // get lang file
            $dfln = $app['globals-path'].'en_EN_app_install.php';
                if($this->url[0] == 'index') {
                    $fln = 'en_EN_';
                } else if($this->url[0] == 'nl') {
                    $fln = 'nl_NL_';
                } else if($this->url[0] == 'es') {
                    $fln = 'es_ES_';
                } else {
                    $fln = '';
                }
                $tlf = $app['globals-path'].$fln.'app_install.php';
                if(file_exists($tlf)){
                    include($tlf);
                } else {
                    include($dfln);
                }
            // Set main URL
            define('URL',$app['domain']);
            // Date Time Zone settings
            $timezone = $this->controller->model->option('meta_str', array('name'=>'settings','value'=>'timezone'));
            if($timezone != '') {
                date_default_timezone_set($timezone);
            } else {
                date_default_timezone_set('America/Argentina/Buenos_Aires');
            }
            // Check if database setting is set
            $admin_theme = $this->controller->model->option('meta_str', array('name'=>'themes','value'=>'admin_theme'));
            $check_user_db = $this->controller->model->check_user_db();
            if($admin_theme == '') {
                define('DB_IS_NOT_INSTALLED', true);
                $db_install = $app['helpers-path'] . 'install_data.php';
                if(file_exists($db_install)) {
                    include $db_install;
                } else {
                    echo json_encode(['message' => 'Could not install application data', 'class' => 'error']);
                }
                die();  
            } else if(empty($check_user_db)){
                $app_user = $app['helpers-path'] . 'app_user.php';
                define('DB_ADMIN_USER_NOT_FOUND', true);
                if(file_exists($app_user)) {
                    include $app_user;
                } else {
                    echo json_encode(['message' => 'Could not install application data', 'class' => 'error']);
                }
                die();
            }
        }
        // End of  Application Installation
		// Log user in if cookie keep isset
		if(isset($_COOKIE['keep']) && $_COOKIE['keep'] != '') {
			$row = $this->controller->model->get_keep_user_info($_COOKIE['keep']);
			if(!empty($row)) {
				$_SESSION['loggedin']['id'] = $row['id'];
				$_SESSION['loggedin']['username'] = $row['username'];
				$this->controller->user = $this->controller->model->get_user_info();
			}
			
		}
		// Application name
		// $arguments = $this->controller->model->option('meta_str', ['name' => 'settings', 'value' => 'app_name']);
		// Application name
		$appname = $this->controller->model->option('meta_str', array('name'=>'settings','value'=>'app_name'));
		$this->appname = $appname;
		// Application logo
        $applogo = $this->controller->model->option('meta_text', array('name'=>'settings','value'=>'app_logo'));
        $this->applogo = $applogo;
        // Application icon
        $appicon = $this->controller->model->option('meta_text', array('name'=>'settings','value'=>'app_icon'));
        $this->appicon = $appicon;
		// Get multilang val
		$multilang = $this->controller->model->option('meta_int', array('name'=>'settings','value'=>'multilang'));
		// Get default language
		$defaultlangdata = $this->controller->model->option('meta_str', array('name'=>'settings','value'=>'default_lang'));
		$defaultlangarray = json_decode($defaultlangdata,true);
		reset($defaultlangarray);
		$defaultlang = current($defaultlangarray);
		$defaultlang_alias = key($defaultlangarray);
		// Get all enable langauges
		$languages = $this->controller->model->option('meta_text', array('name'=>'settings','value'=>'languages'));
		// Set languages to array
		$languages = json_decode($languages,true);
		// Check if multilang is set
			if($multilang == 1){
				// Check if language is in url
				if(array_key_exists($this->url[0], $languages)) {					
					define('LANG',$languages[$this->url[0]]);
					define('LANG_ALIAS', $this->url[0].'/');
					define('DEFAULT_LANG_ALIAS',$defaultlang_alias.'/');
					// Do a redirect if the language is the default language
					if($defaultlang == LANG) {
						$link = str_replace('/'.$this->url[0], '', CURRENT_URL);
						header('Location: '.$link);
					}
					// Remove the first array position if it is a known language variable
					array_splice($this->url, 0, 1);
					// After the array position is remove and there are no positions left in the array
					// give it a default value
					if(!isset($this->url[0])){
						$this->url[0] = 'index';
					}
					// Set language constant here
				} else {					
					define('LANG', $defaultlang);
					define('LANG_ALIAS', $defaultlang_alias.'/');
					define('DEFAULT_LANG_ALIAS',$defaultlang_alias.'/');
				}
			// If multilang is not set
			} else {
				define('LANG', $defaultlang);
				define('LANG_ALIAS', $defaultlang_alias.'/');
				define('DEFAULT_LANG_ALIAS',$defaultlang_alias.'/');
			}
		if($app['show-website'] == false){
			if(LANG_ALIAS == DEFAULT_LANG_ALIAS) {
			$app['login-link'] = URL; 
			} else {
			$app['login-link'] = URL.LANG_ALIAS;
			}
			
			define('DASHBOARD',false);
		} else {
			define('DASHBOARD',$app['dashboard-url']);

			if(LANG_ALIAS == DEFAULT_LANG_ALIAS) {
			$app['login-link'] = URL.$app['login-url'].'/';
			$app['logout-link'] = URL.BACKEND_URL.LOGOUT_URL.'/';
			} else {
			$app['login-link'] = URL.LANG_ALIAS.$app['login-url'].'/';
			$app['logout-link'] = URL.LANG_ALIAS.BACKEND_URL.LOGOUT_URL.'/';
			}
		}
		// Get the admin theme
		$this->admin_theme = $this->controller->model->option('meta_str', array('name'=>'themes','value'=>'admin_theme'));
		// Get the web theme
		$this->web_theme = $this->controller->model->option('meta_str', array('name'=>'themes','value'=>'web_theme'));
		// Get all active plugins
		$this->plugins = $this->controller->model->get_all_plugins();
		// This is for the appliction without website attached to it
		if($app['show-website'] == false){
			// Check if someone is logged in
			if(isset($_SESSION['loggedin']['id'])){
				// For the rest api
				if($this->url[0] == $app['api-url']){
                    // $api = new Rest;
                    if(isset($this->url[3])) {
                        // Check if it's a plugin
                        $page = str_replace('-', '_', $this->url[2]) .'/'. str_replace('-', '_', $this->url[3]);
                        $guard =  $this->controller->is_plugin($this->url[2]);
                        $allow = $this->controller->model->is_admin_page_allowed($this->controller->user['role_level'],$page);
                        if($allow && $guard['allow'] == true) {
                        $class = str_replace('-', '_', $this->url[2]);
                        $class_file = $app['plugins-path'].$class.'/controllers/'.$class.'.php';
                        if(file_exists($class_file)) {
                            include_once($class_file);
                        }
                        $class = new $class;
                        $method = 'rest_'. str_replace('-', '_', $this->url[3]);
                        if(isset($this->url[4])){
                            $class->$method($this->url[4]);
                        } else {
                            $class->$method();
                        }
                        
                        }
                    }
                    die();
                }
				// Do the logout stuff
				if($this->url[0] == LOGOUT_URL) {
					unset($_SESSION['loggedin']['id']);
					unset($_SESSION['loggedin']['user']);
					$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
					setcookie('keep', "", time()-3600, '/', $domain, false);
					Message::flash(__('You successfully logged out!'));
					header('Location: '.$app['login-link']);
				} else{
					 // Do the token stuff
                    if(isset($_GET['token'])) {
                        $this->token($_GET);
                    } else {
                        $this->admin();
                    }
				}
			// When no one is logged in
			} else {
				// Show people to log in
				if($this->url[0] == 'index' && !isset($this->$url[1])){
					if(isset($_GET['token'])) {
                            $this->token($_GET);
                        } else {
                            $login = new login;
                    $arg = array('theme' => $this->admin_theme, 'appname' => $appname, 'applogo' => $this->applogo, 'appicon' => $this->appicon);
                    $login->login($arg);
                        }
                    
                } else if($this->url[0] == $app['api-url']) {
                    if(isset($this->url[2]) && $this->url[2] == $app['login-url']) {
                        
                            $login = new login;
                            $login->rest_login();
                    } else if(isset($this->url[3])) {
 
                    }
				}
			}
		// This area is for when website is enabled	
		} else {
			// Check if someone is logged in
			if(isset($_SESSION['loggedin']['id'])){
				// For the rest api
				if($this->url[0] ==  $app['api-url']){
					// echo $this->url[0];
					// $api = new Rest;
					if(isset($this->url[3])) {
						// Check if it's a plugin
						$page = $this->url[2] .'/'. str_replace('-', '_', $this->url[3]);
						$guard =  $this->controller->is_plugin($this->url[2]);
						$allow = $this->controller->model->is_admin_page_allowed($this->controller->user['role_level'],$page);
						if($allow && $guard['allow'] == true) {
						$class = new $this->url[2];
						$method = 'rest_'. str_replace('-', '_', $this->url[3]);
						if(isset($this->url[4])){
							$class->$method($this->url[4]);
						} else {
							$class->$method();
						}
						
						}
					}
					die();
				}
				// echo 'Someone is logged in<br>'; ////////////////////////////////////////////////////////////////////////////
				// Do the logout stuff
				if(CURRENT_URL == $app['logout-link']) {
					unset($_SESSION['loggedin']['id']);
					unset($_SESSION['loggedin']['user']);
					$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
					setcookie('keep', "", time()-3600, '/', $domain, false);
					Message::flash(__('You successfully logged out!'));
					header('Location: '.$app['login-link']);
				// If someone is logged in, go to admin area
				} else if(CURRENT_URL == $app['login-link']){
					if($multilang == 1){
						header('Location: '.URL.LANG_ALIAS.BACKEND_URL);
					} else {
						header('Location: '.URL.BACKEND_URL);
					}
				
				} else {
				// Do the admin stuff
				$this->admin();
				// Do Website stuff
				$this->front();
				}
			} else {
				// echo 'No one is logged in<br>';
				// If there is need for a website, use login link to login	
				if($this->url[0] == $app['login-url']){
				$login = new login;
				 $arg = array('theme' => $this->admin_theme, 'appname' => $appname, 'applogo' => $this->applogo, 'appicon' => $this->appicon);
				$login->login($arg);
				} else if($this->url[0] == 'api'){
                    echo 'test';
				} else {
				// Do Website stuff
				$this->front();	
				}
			}
		}	
	}
	// Method for getting config vars
	public static function config($file_name){
		$$file_name = array();
		$file = 'app/config/' . $file_name . '.php';
		if(file_exists($file)){
			include($file);
			self::$vars = $$file_name;
			return self::$vars;
		 }
	}
	// token stuff
    private  function token($arg) {
        $app = App::config('app');
        $theme = $app['themes-path'] . $this->admin_theme . '/token.php';
        $action = explode(':', $arg['action']);
        $guard =  $this->controller->is_plugin($action[0]);
        $page = $action[0] .'/'. $action[1];
        $method = 'token_'.$action[1];
        $keys = $arg['action'].$arg['request'];
        // $nonce = $keys.$arg['user'];
        $token_check = $this->controller->model->token_hash($keys);
        // echo $token_check;
        if(class_exists($action[0]) && $guard['allow'] == true ) {
            $class = new $action[0];
            //echo 1;
            if(method_exists($class,$method)) {
                //echo 2;
                if($token_check == $arg['token']) {
                    // echo 3;
                    $class->$method();
                    $viewvars = array();
                    $viewvars['theme'] = $this->admin_theme;
                    $viewvars['class'] =  $action[0];
                    $viewvars['method'] = $method;
                    $viewvars['page-title'] = '';
                    if(isset($class->title)){
                        $viewvars['page-title'] = $class->title;
                    }
                    $viewvars['message'] = '';
                    $viewvars['error'] = '';
                    $viewvars['user'] = array();
                    $viewvars['dashboard'] = '';
                    $viewvars['url'] = '';
                    $viewvars['plugins'] = $this->plugins;
                    $viewvars['appname'] = $this->appname;
                    $viewvars['website'] = $this->website;
                    $viewvars['applogo'] = $this->applogo;
                    $viewvars['appicon'] = $this->appicon;
                    $viewvars['var'] = $class->var;
                    $viewvars['formdata'] = $class->data;
                    // $this->controller->view->theme($theme,$viewvars);
                }
                
            }
        }
        
    } 
	// The main action for the backend
	private function admin(){
		// Set default View variables
		$viewvars = array();
		$viewvars['theme'] = $this->admin_theme;
		$viewvars['class'] = '';
		$viewvars['method'] = '';
		$viewvars['page-title'] = '';
		$viewvars['message'] = '';
		$viewvars['error'] = '';
		$viewvars['user'] = $this->controller->user;
		$viewvars['dashboard'] = '';
		$viewvars['plugins'] = $this->plugins;
		$viewvars['appname'] = $this->appname;
		$viewvars['website'] = $this->website;
		$viewvars['applogo'] = $this->applogo;
        $viewvars['appicon'] = $this->appicon;
		// $viewvars['user']['role_level'] = 4.1;
		$viewvars['pages'] = '';//$this->model->get_admin_pages($viewvars['user']['role_level']);
		$viewvars['var'] = array();
		$viewvars['formdata'] = array();
		// echo $this->model->menu_items($viewvars['user']['role_level']);
		// Get config variables
		$app = App::config('app');
		// check for Splash
		$splash = $app['themes-path'] . $this->admin_theme . '/splash.php';
		// The index theme file
		$theme = $app['themes-path'] . $this->admin_theme . '/index.php';
		// The error file
		// $error = $app['themes-path'] . $this->admin_theme . '/error.php';
		// This is for when website is enabled
		if(isset($this->url[0]) && $this->url[0] == rtrim(BACKEND_URL,'/') && $app['show-website'] == true){
		// Set default values for class and method
		if(!isset($this->url[1])){
				$this->url[1] = 'index';
			}
		if(!isset($this->url[2])){
				$this->url[2] = 'index';
			}
		// Set the url for view
		$viewvars['url'] = $this->url;
		// Do the admin magic in here
			if($this->url[1] != 'index'){
				$this->url[1] = str_replace('-', '_', $this->url[1]);
				// Check if it's a plugin
				$guard =  $this->controller->is_plugin($this->url[1]);
				$page = $this->url[1] .'/'. $this->url[2];
				$allow = $this->controller->model->is_admin_page_allowed($this->controller->user['role_level'],$page);
				// Check if the url is dashboard to do splash or not
				if($this->url[1] == $app['dashboard-url']) {
					// If splash exists, include the file
					if(file_exists($splash)){
						$this->controller->view->theme($splash,$viewvars);
					} else {
						// If file not exists do error
						echo 'error';
					}	
				} 
				// Check if Class exists
				else if(class_exists($this->url[1]) && $guard['allow'] == true ){
					// Initiate the class
					$this->url[2] = str_replace('-', '_', $this->url[2]);
					$admin = new $this->url[1];
					// Set class method for admin
					$method = 'admin_'.$this->url[2];
					// Check if arguments is set
					if(isset($this->url[3])) {
						// Remove class and method
						$arguments = array_slice($this->url, 3);
						// Set variable for arguments
						$strvars = '';
						// Set arguments to string
						foreach ($arguments as $value) {
							$strvars .= $value . '/';
						}
						// Set urls for view. Use $urlvars to get the url string
						$urlvars = array('urlvars' => $strvars );
						if(method_exists($admin,$method) && $allow == true) {
							
							$admin->$method($strvars);
							
							$admin->var = array_merge($admin->var, $urlvars);
							// $this->view->render($this->url[1],$method,$admin->var);
							$viewvars['class'] = $this->url[1];
							$viewvars['method'] = $method;
							$viewvars['var'] = $admin->var;
							$viewvars['formdata'] = $admin->data;
							
							if(isset($admin->title)){
								$viewvars['page-title'] = $admin->title;
							}
							
							// Check for error call
							if($admin->error == true){
								$viewvars['message'] = '';
								$viewvars['error'] = 1;
								$this->controller->view->theme($theme,$viewvars);
							} else {
							// Get the theme for the view
							$this->controller->view->theme($theme,$viewvars);
							}							
						} else {
							// Do something more here to view the error
							$errors = new Errors;
							if($app['app-debug'] == true){
								$viewvars['method'] = $method;
								//$viewvars['message'] = __('Method').' <strong>'.$viewvars['method'].'</strong> '.__('does not exists');
								$viewvars['message'] = $errors->no_method($this->url[1],$viewvars['method']);
							} else {
								$viewvars['method'] = '';
								$viewvars['message'] = '';
							}
							
							$this->controller->view->theme($theme,$viewvars);
							
						}
					} else {
						if(method_exists($admin,$method) && $allow == true) {

						$admin->$method('');
						//$this->view->render($this->url[1],$method,$admin->var);
						
						$viewvars['class'] = $this->url[1];
						$viewvars['method'] = $method;
						$viewvars['var'] = $admin->var;
						$viewvars['formdata'] = $admin->data;
						if(isset($admin->title)){
								$viewvars['page-title'] = $admin->title;
							}
						// Check for error call
						if($admin->error == true){
							$viewvars['message'] = '';
							$viewvars['error'] = 1;
							$this->controller->view->theme($theme,$viewvars);
						} else {
						// Get the theme for the view
						$this->controller->view->theme($theme,$viewvars);
						}
						// If the Method does not exists
						} else {
							// Do something more here to view the error
							$errors = new Errors;
							if($app['app-debug'] == true){
								$viewvars['method'] = $method;
								// $viewvars['message'] = __('Method').' <strong>'.$viewvars['method'].'</strong> '.__('does not exists');
								$viewvars['message'] = $errors->no_method($this->url[1],$viewvars['method']);
							} else {
								$viewvars['method'] = '';
								$viewvars['message'] = '';
							}
							
							$this->controller->view->theme($theme,$viewvars);
						}
					}
				// If the Class does not exists
				} else {
					// Do something more here to view the error
					$errors = new Errors;
					if($app['app-debug'] == true){
						if($guard['allow'] == true) {
						$viewvars['class'] = $this->url[1];
						// $viewvars['message'] = __('Class').' <strong>'.$viewvars['class'].'</strong> '.__('does not exists');
						$viewvars['message'] = $errors->no_class($this->url[1]);
						} else {
						$viewvars['class'] = '';
						$viewvars['message'] = $guard['message'];	
						}
						
					} else {
						$viewvars['class'] = '';
						$viewvars['message'] = '';
					}
					
					$this->controller->view->theme($theme,$viewvars);
				}	
			// In here for the dashboard or splash page	
			} else {

				if($this->url[0] == rtrim(BACKEND_URL,'/') && $this->url[1] == 'index'){
					$viewvars['dashboard'] = $this->url[1];
					if(file_exists($splash)){	
						$this->controller->view->theme($splash,$viewvars);
					} else {
						$this->controller->view->theme($theme,$viewvars);
					}
		}
			}
		// When website is disabled, do this magic
		} else if($app['show-website'] == false) {

		// Set vars for the view
		$viewvars['url'] = $this->url;
			// Set the second parameter
			if(!isset($this->url[1])){
				$this->url[1] = 'index';
			}

			// Do the admin magic in here
			if($this->url[0] != 'index'){
				// for nice url
				$this->url[0] = str_replace('-', '_', $this->url[0]);
				// Check if it's a plugin
				$guard =  $this->controller->is_plugin($this->url[0]);
				$page = $this->url[0] .'/'. $this->url[1];
				$allow = $this->controller->model->is_admin_page_allowed($this->controller->user['role_level'],$page);
				
				// Check if the url is dashboard to do splash or not
				if($this->url[0] == $app['dashboard-url']) {
					// If splash exists, include the file
					if(file_exists($splash)){
						$this->controller->view->theme($splash,$viewvars);
					} else {
						// If file not exists do error
						echo 'error';
					}	
				}
				// Check if Class exists and allow
				else if(class_exists($this->url[0]) && $guard['allow'] == true){
					// Initiate the class
					$admin = new $this->url[0];
					// Set class method for admin
					$this->url[1] = str_replace('-', '_', $this->url[1]);
					$method = 'admin_'.$this->url[1];
					if(isset($this->url[2])) {
						// Remove class and method
						$attributes = array_slice($this->url, 2);
						// Set variable for attributes
						$strvars = '';
						// Set attributes to string
						foreach ($attributes as $value) {
							$strvars .= $value . '/';
						}
						// Set urls for view. Use $urlvars to get the url string
						$urlvars = array('urlvars' => $strvars );
						// Check if method exists
						if(method_exists($admin,$method) && $allow == true) {
						$admin->$method($strvars);
						$admin->var = array_merge($admin->var, $urlvars);
						
						$viewvars['class'] = $this->url[0];
						$viewvars['method'] = $method;
						$viewvars['var'] = $admin->var;
						$viewvars['formdata'] = $admin->data;
						// Check for the title
						if(isset($admin->title)){
								$viewvars['page-title'] = $admin->title;
							}
						// Check for error call
						if($admin->error == true){
							$viewvars['message'] = '';
							$viewvars['error'] = 1;
							$this->controller->view->theme($theme,$viewvars);
						} else {
						// Get the theme for the view
						$this->controller->view->theme($theme,$viewvars);
						}
						// Do error
						} else {
							$errors = new Errors;
							// Do something more here to view the error
							if($app['app-debug'] == true){
								$viewvars['method'] = $method;
								// $viewvars['message'] = __('Method').' <strong>'.$viewvars['method'].'</strong> '.__('does not exists');
								$viewvars['message'] = $errors->no_method($this->url[0],$viewvars['method']);
							} else {
								$viewvars['method'] = '';
								$viewvars['message'] = '';
							}

							$this->controller->view->theme($theme,$viewvars);

						}
					} else {
						// Check if method exists
						if(method_exists($admin,$method) && $allow == true) {
						// Initiate the method
						$admin->$method();
						// Set all the for the view
						$viewvars['class'] = $this->url[0];
						$viewvars['method'] = $method;
						$viewvars['var'] = $admin->var;
						$viewvars['formdata'] = $admin->data;
						// Set var for the page title
						if(isset($admin->title)){
								$viewvars['page-title'] = $admin->title;
							}
						// Check for error call
						if($admin->error == true){
							$viewvars['message'] = '';
							$viewvars['error'] = 1;
                            $this->controller->view->theme($theme,$viewvars);
						} else {
						// Get the theme for the view
						$this->controller->view->theme($theme,$viewvars);
						}
						// If the Method does not exists
						} else {
							// Do something more here to view the error
							$errors = new Errors;
							if($app['app-debug'] == true){
								$viewvars['method'] = $method;
								// $viewvars['message'] = __('Method').' <strong>'.$viewvars['method'].'</strong> '.__('does not exists');
								$viewvars['message'] = $errors->no_method($this->url[0],$viewvars['method']);
							} else {
								$viewvars['method'] = '';
								$viewvars['message'] = '';
							}
							
							$this->controller->view->theme($theme,$viewvars);
						}
					}
				// Error views
				 } else {
				 	// Do the error stuff here
				 	$errors = new Errors;
					if($app['app-debug'] == true){
						if($guard['allow'] == true) {
						$viewvars['class'] = $this->url[0];
						$viewvars['message'] = __('Class').' <strong>'.$viewvars['class'].'</strong> '.__('does not exists');
						$viewvars['message'] = $errors->no_class($this->url[0]);
						} else {
						$viewvars['class'] = '';
						$viewvars['message'] = $guard['message'];	
						}
						
					} else {
						$viewvars['class'] = '';
						$viewvars['message'] = '';
					}
					
					$this->controller->view->theme($theme,$viewvars);

				 }
			// In here for the dashboard or splash page
			} else {
				$viewvars['dashboard'] = $this->url[0];
				// Check if splash file exists then call the file
				if(file_exists($splash)){
						$this->controller->view->theme($splash,$viewvars);
					} else {
						$this->controller->view->theme($theme,$viewvars);
					}
			}
			
		}
		
	}
	// The main action for the frontend
	private function front(){
		$app = App::config('app');
		$viewvars = array();
		$viewvars['page-title'] = '';
		$viewvars['content'] = '';
		$viewvars['class'] = '';
		$viewvars['method'] = '';
		$viewvars['var'] = '';
		$viewvars['user'] = '';
		$viewvars['url'] = '';
		$viewvars['error'] = '';
		$viewvars['dashboard'] = '';
		$viewvars['plugins'] = '';
		$viewvars['appname'] = '';
		$viewvars['website'] = $this->web_theme;
		$viewvars['applogo'] = $this->applogo;
        $viewvars['appicon'] = $this->appicon;
        $viewvars['formdata'] = array();
		$viewvars['theme'] = '';
		$theme = $app['webthemes-path'].$this->web_theme.'/index.php';

		if(isset($this->url[0]) && $this->url[0] != rtrim(BACKEND_URL,'/')){
			// Check for the home page
			if($this->url[0] == 'index'){
				$id = $this->controller->model->option('meta_int', array('name'=>'page','value'=>'index'));
				$page = $this->get_page_from_id($id);
				$viewvars['page-title'] = $page['title'];
				$viewvars['content'] = $page['content'];
				$this->controller->view->theme($theme,$viewvars);

			} else {
				// check if page exists
				$page = $this->get_page($this->url[0]);
				if(is_array($page)) {
				$viewvars['page-title'] = $page['title'];
				$viewvars['content'] = $page['content'];
				$this->controller->view->theme($theme,$viewvars);
				} else {
					echo "No";
				}

			}
		
		// check if is login, error if not
		} else {
			if(!isset($_SESSION['loggedin']['id'])){
				echo 'Error not found!';
			}
		}
	}

	private function get_page($slug){
		$sql = "SELECT title, content, id FROM ".PRE."pages WHERE slug = :slug AND status = 1";
		$stmt = $this->controller->model->pdo->prepare($sql);
		$stmt->execute(array(':slug' => $slug));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	private function get_page_from_id($id){
		$sql = "SELECT title, content, id FROM ".PRE."pages WHERE id = :id AND status = 1";
		$stmt = $this->controller->model->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

}