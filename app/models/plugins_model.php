<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Plugins_model extends Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_all_plugins(){
		$res = array();
		$app = App::config('app');
		$admin_theme = $this->option('meta_str', array('name'=>'themes','value'=>'admin_theme'));
		$i = 0;
		// This is for the object in the file config.php. You can now add the vars without isset function
		$nav = new Nav;
		$enqueue = new Enqueue;
		foreach (glob($app['plugins-path'].'*') as $plugin) {
			$name = str_replace($app['plugins-path'], '', $plugin);
			$pp = $plugin;
			$folder = $name;
			$installed = $this->is_installed($name);
			$name = str_replace(array('-','_'),' ',ucwords($name));			
			$file = $plugin . '/config.php';
			$image1 = $pp . '/plugin.jpg';
			$image2 = $app['themes-path'] . $admin_theme.'/images/default-plugin.jpg';
			$image3 = $app['assets-path'] . 'images/default-plugin.jpg';
			if(file_exists($image1)) {
				$img = URL.str_replace(BASEPATH, '', $app['plugins-path']).$folder.'/plugin.jpg';
			} else if(file_exists($image2)) {
				$img = URL.str_replace(BASEPATH, '', $app['themes-path']).$admin_theme.'/images/default-plugin.jpg';
			} else {
				$img = URL.str_replace(BASEPATH, '', $app['assets-path']).'images/default-plugin.jpg';
			}

			if(file_exists($file)){
				$plugin = array();
				$plugin['name'] = $name;
				include($file);
				$plugin['db-version'] = $installed['version'];
				$plugin['active'] = $installed['active'];
				$plugin['id'] = $installed['id'];
				$plugin['domain'] = $folder;
				$plugin['img'] = $img;
    			$res[$i] = $plugin;
    			$i++;
			}
		}
		return $res;
	}

	private function is_installed($plugin){
		$sql = "SELECT id, plugin, active, version FROM ".PRE."plugins WHERE plugin = :plugin";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':plugin' => $plugin));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function install($plugin,$version){
		$app = App::config('app');
		$data = array();
		$sql = new Sql;
		$file = $app['plugins-path'].$plugin.'/sql/schema.php';
		if(file_exists($file)) {
				include($file);
				$data['plugin_db_file'] = 'File found';
			} else {
				$data['plugin_db_file'] = 'No file found';
			}
		$tables = $sql->db;
		$tbns = '';
		foreach ($tables as $table) {
			if(isset($table['name'])) {
			$tbns .= str_replace(PRE, '', $table['name']).',';
			}
		}
		$tbns = rtrim($tbns,',');

		$sql = "INSERT INTO ".PRE."plugins (plugin,version,relations) VALUES (:plugin, :version, :relations)";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(':plugin', $plugin);
		$stmt->bindParam(':version', $version);
		$stmt->bindParam(':relations', $tbns);
		if($stmt->execute()){
			$data['Key'] = 'Success';
			$data['Id'] = $this->pdo->lastInsertId();
			$data['Message'] = __('Plugin was successfully installed');
			foreach ($tables as $table) {
				if(isset($table['sql'])) {
					$this->add_alter_table($table['sql']);
				} else if(isset($table['insert'])){
					$this->add_alter_table($table['insert']);
				} else if(isset($table['alterdb'])) {
					$this->add_alter_table($table['alterdb']);
				} else if(isset($table['add'])) {
					if($this->if_data_setting_isset($table['dbname'], $table['where'], $table['val']) == false) {
					$this->add_alter_table($table['add']);
					}
				}
				
			}
			return $data;
		} else {
			$data['Key'] = 'Failed';
			$data['Id'] = '';
			$data['Message'] = __('Plugin was not installed');
			return $data;
		}
	}

	public function update($id,$plugin,$version){
		$app = App::config('app');
		$data = array();
		$sql = new Sql;
		$file = $app['plugins-path'].$plugin.'/sql/schema.php';
		if(file_exists($file)) {
				include($file);
			}
		$tables = $sql->db;
		$tbns = '';
		foreach ($tables as $table) {
			if(isset($table['name'])) {
				$tbns .= str_replace(PRE, '', $table['name']).',';
			}
		}
		$tbns = rtrim($tbns,',');
		$sql = "UPDATE ".PRE."plugins SET plugin = :plugin ,version = :version ,relations = :relations WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':plugin', $plugin);
		$stmt->bindParam(':version', $version);
		$stmt->bindParam(':relations', $tbns);
		if($stmt->execute()){
			$data['Key'] = 'Update Success';
			$data['Message'] = __('Plugin was successfully updated');
			foreach ($tables as $table) {
				if(isset($table['sql'])) {
					$this->add_alter_table($table['sql']);
				} else if(isset($table['insert'])){
					$this->add_alter_table($table['insert']);
				} else if(isset($table['alterdb'])) {
					$this->add_alter_table($table['alterdb']);
					$data['Alter'] = 'Yes';
				} else if(isset($table['add'])) {
					if($this->if_data_setting_isset($table['dbname'], $table['where'], $table['val']) == false) {
					$this->add_alter_table($table['add']);
					}
				}	
			}
			return $data;
		} else {
			$data['Key'] = 'Update Failed';
			$data['Message'] = __('Something went wrong while updating');
			return $data;
		}

	}

	public function plugin_info($id){
		$app = App::config('app');
		$sql = "SELECT id, plugin, relations, active, version FROM ".PRE."plugins WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$name = ucwords(str_replace(array('-','_'), ' ', $row['plugin']));
		$row['name'] = __($name,$row['plugin']);
		// This is for the object in the file config.php. You can now add the vars without isset function
		$nav = new Nav;
		$enqueue = new Enqueue;
		// The config file
		$file =$app['plugins-path'] .$row['plugin'] . '/config.php';
		if($row['relations'] != '') {
			$dbs = explode(',', $row['relations']);
			foreach ($dbs as $db) {
				$db = trim($db);
				$row['rec'][$db] = $this->count_rec($db);
			}
		}
		if(file_exists($file)){
				$plugin = array();
				include($file);
			}
		$row['info'] = $plugin;
		return $row;

	}

	public function active($id,$active){
		$sql = "UPDATE ".PRE."plugins SET active = :active WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':active', $active);
		if($stmt->execute()){
			$data['Key'] = 'Success';
			$data['Message'] = __('Plugin was successfully activated');
			return $data;
		} else {
			$data['Key'] = 'Failed';
			$data['Message'] = __('Plugin could not be activated');
			return $data;
		}

	}

	public function delete_plugin($id,$name,$relations = NULL){
		$app = App::config('app');
		if($relations != NULL) {
			$tables = explode(',', $relations);
			foreach ($tables as $tb) {
				$tb = trim($tb);
				$this->drop_table($tb);
			}

		}
		if($name != '') {
			$target = $app['plugins-path'].$name;
		} else {
			$target = '';
		}
		
		$this->delete_dir($target);
		 $sql = "DELETE FROM ".PRE."plugins WHERE id = :id";
		 $stmt = $this->pdo->prepare($sql);
		 $stmt->bindParam(':id', $id);
		 if($stmt->execute()){ 
		 	return 'Yes';
		 } else {
		 	return 'No';
		 }
		
	}
	public function if_data_setting_isset($table, $where, $val) {
		$sql = "SELECT * FROM $table WHERE $where = '$val'";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!empty($row)) {
			return true;
		} else {
			return false;
		}
	}
	private function delete_dir($target){
		if(is_dir($target)) {
        $files = glob( $target . '*', GLOB_MARK ); 

	        foreach( $files as $file )
		        {
		            $this->delete_dir( $file );      
		        }

	        rmdir( $target );
	    } elseif(is_file($target)) {
	        unlink( $target );  
	    }
	}

	private function add_alter_table($query){
		$this->pdo->exec($query);
	}
	private function drop_table($table){
		$sql = "DROP TABLE ".PRE.$table;
		$stmt = $this->pdo->prepare($sql);
		if($stmt->execute()){
			return $table . __('Deleted');
		} else {
			return __('Could not delete Database table').' '.  $table;
		}
	}
	private function count_rec($table){
		$sql = "SELECT COUNT(*) FROM ".PRE.$table;
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$count = $stmt->fetch(PDO::FETCH_NUM);
		return reset($count);
	}
}