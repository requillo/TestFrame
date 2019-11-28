<?php 
defined('IS_NOT_INSTALLED') OR exit('No direct script access allowed');
$model = new model;
if(!empty($_POST)) {
	if(isset($_POST['check_db'])) {
		$dbpre = $model->generateRandomString(4, 1, false);
		$db['host'] = $_POST['dbhost'];
		$db['name'] = $_POST['dbtable'];
		$db['user'] = $_POST['dbuser'];
		$db['pass'] = $_POST['dbpass'];
		$db['type'] = $_POST['dbtype'];
		$db['pre'] = $_POST['dbpre'];

		if($db['name'] == '') {
			$db['name'] = 1;
		}

		if($db['user'] == '') {
			$db['user'] = 1;
		}

		if($db['pre'] == '') {
			$db['pre'] = strtolower($dbpre);
		}

		if($db['type'] == 'mysql') {
			// mysql:host=localhost;dbname=db_name
		$db['connect'] = 'mysql:host='.$db['host'].';dbname='.$db['name'];
		} else if($db['type'] == 'db2') {
			// ibm:DRIVER={IBM DB2 ODBC DRIVER};DATABASE=testdb;HOSTNAME=localhost;PORT=56789;PROTOCOL=TCPIP;
		$db['connect'] = 'ibm:DRIVER={IBM DB2 ODBC DRIVER};DATABASE='.$db['name'].';HOSTNAME='.$db['host'].';PORT=56789;PROTOCOL=TCPIP;';
		} else if($db['type'] == 'postgre') {
			// pgsql:dbname=db_name;host=localhost
		$db['connect'] = 'pgsql:host='.$db['host'].';dbname='.$db['name'];
		} 

		try {
    		$conn =  new pdo($db['connect'],$db['user'],$db['pass']);
			}
		catch( PDOException $Exception ) {
			$conn = 'Not connected';
			}
		if($conn == 'Not connected') {
			$data['message'] = $ai['error-find-db'];
			$data['class'] = 'error';
		} else {
			$data['message'] = $ai['db-connected'];
			$data['class'] = 'success';
			$data['pre'] = $db['pre'];
		}
		sleep(1);	
		echo json_encode($data);
	} else {
		$my_file = $app['app-path'].'config/db/db.php';
		$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
		if($_POST['dbtype'] == 'db2') {
			$dbpre = rtrim($_POST['dbpre'],'_').'.';
		} else {
			$dbpre = rtrim($_POST['dbpre'],'_').'_';
		}
		
		$dt = '';
		if($handle) {
			$auth = str_replace(' ','',trim($_POST['auth']));
			$salt = str_replace(' ','',trim($_POST['salt']));
			$secure = str_replace(' ','',trim($_POST['secure']));
			if($auth == '') {
				$auth = $model->generateRandomString(64, 66);
			}

			if($salt == '') {
				$salt = $model->generateRandomString(64, 66);
			}

			if($secure == '') {
				$secure = $model->generateRandomString(64, 66);		
			}

			$dt .= '<?php'."\n";
			$dt .= "defined('BASEPATH') OR exit('No direct script access allowed');"."\n";
			$dt .= '$db[\'host\'] = '."'". $_POST['dbhost'] ."';"."\n";
			$dt .= '$db[\'user\'] = '."'". $_POST['dbuser'] ."';"."\n";
			$dt .= '$db[\'pass\'] = '."'". $_POST['dbpass'] ."';"."\n";
			$dt .= '$db[\'name\'] = '."'". $_POST['dbtable'] ."';"."\n";
			$dt .= '$db[\'pre\'] = '."'". $dbpre ."';"."\n";
			$dt .= '$db[\'type\'] = '."'". $_POST['dbtype'] ."';"."\n";
			$dt .= 'if($db[\'type\'] == \'mysql\') {'."\n";
			$dt .= '// mysql:host=localhost;dbname=db_name'."\n";
			$dt .= '$db[\'connect\'] = \'mysql:host=\'.$db[\'host\'].\';dbname=\'.$db[\'name\'];'."\n";
			$dt .= '} else if($db[\'type\'] == \'db2\') {'."\n";
			$dt .= '// ibm:DRIVER={IBM DB2 ODBC DRIVER};DATABASE=testdb;HOSTNAME=localhost;PORT=56789;PROTOCOL=TCPIP;'."\n";
			$dt .= '$db[\'connect\'] = \'ibm:DRIVER={IBM DB2 ODBC DRIVER};DATABASE=\'.$db[\'name\'].\';HOSTNAME=\'.$db[\'host\'].\';PORT=56789;PROTOCOL=TCPIP;\';'."\n";
			$dt .= '} else if($db[\'type\'] == \'postgre\') {'."\n";
			$dt .= '// pgsql:dbname=db_name;host=localhost'."\n";
			$dt .= '$db[\'connect\'] = \'pgsql:host=\'.$db[\'host\'].\';dbname=\'.$db[\'name\'];'."\n";
			$dt .= '}'."\n";
			fwrite($handle, $dt);
			fclose($handle);
			$app_file = $app['app-path'].'config/app.php';
			$the_app = fopen($app_file, 'a') or die('Cannot open file:  '.$app_file);
			$apdt = "\n";
			if($uri[0] != '') {
				$apdt .= '$app[\'domain\'] = HTTP.\'://\'.$_SERVER[\'HTTP_HOST\'] .\'/'.$uri[0].'/\' ;'."\n";
			} else {
				$apdt .= '$app[\'domain\'] = HTTP.\'://\'.$_SERVER[\'HTTP_HOST\'] .\'/\' ;'."\n";
			}
			
			$apdt .= '# Security hash'."\n";
			$apdt .= '$app[\'auth\'] = \''.$auth.'\';'."\n";
			$apdt .= '$app[\'salt\'] = \''.$salt.'\';'."\n";
			$apdt .= '$app[\'secure\'] = \''.$secure.'\';'."\n";
			fwrite($the_app, $apdt);
			fclose($the_app);
			$data['message'] = $ai['config-done'];
			$data['class'] = 'success';
		} else {
			$data['message'] = $ai['error-wr-config'];
			$data['class'] = 'errer';
		}
		sleep(1);
		echo json_encode($data);
	}
} else {
	//$uri = trim($_SERVER['REQUEST_URI'],'/');
	//$uri = explode('/', $uri);
	$view_install = $app['views-path'].'install/install.php';
	$auth = $model->generateRandomString(64, 66);
	$salt = $model->generateRandomString(64, 66);
	$secure = $model->generateRandomString(64, 66);
	if(file_exists($view_install)) {
		include($view_install);
	}
}