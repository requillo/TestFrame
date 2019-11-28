<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class plugins extends controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function admin_index(){
		$this->title = __("All plugins");
		$app = App::config('app');
		$this->set('Serverd_names',$app['reserved-names']);
		$this->set('plugins',$this->plugins->get_all_plugins());
	}

	public function admin_add(){
		$this->title = __("Add plugins");
	}

	public function rest_add(){
		$app = App::config('app');
		if($_FILES["file"]["name"]) {
			$filename = $_FILES["file"]["name"];
			$source = $_FILES["file"]["tmp_name"];
			$type = $_FILES["file"]["type"];
			$filesize = $_FILES['file']['size'];
			$name = explode(".", $filename);
			$src = "default.png";
			$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
			foreach($accepted_types as $mime_type) {
				if($mime_type == $type) {
					$okay = true;
					break;
				} 
			}
			
			$continue = strtolower($name[1]) == 'zip' ? true : false;
			if(!$continue) {
				$message = "The file you are trying to upload is not a .zip file. Please try again.";
			}
			$location = $app['plugins-path'];
			$target_path = $location.$filename;  // change this to the correct site path
			if(move_uploaded_file($source, $target_path)) {
				$zip = new ZipArchive();
				$x = $zip->open($target_path);
				if ($x === true) {
					$zip->extractTo($location); // change this to the correct site path
					$zip->close();
					unlink($target_path);
				}
				$message = "Your .zip file was uploaded and unpacked.";
			} else {	
				$message = "There was a problem with the upload. Please try again.";
			}

			$return_arr = array("name" => $filename,"size" => $filesize, "src"=> $src, "message" => $message);
			echo json_encode($return_arr);
		}
	}

	public function admin_delete($id){
		$id = explode('/', $id);
		if($id[1] == '') {
		$plugin = $this->plugins->plugin_info($id[0]);
		
			if($plugin['name'] != '') {
				$pname = ucfirst(str_replace(array('-','_'), ' ', $plugin['plugin']));
				$this->title = __("Delete plugin").' "'.__($pname,$plugin['plugin']).'"';
				$this->set('Plugin',$plugin);
				if(!empty($this->data)) {

					if(isset($this->data['full']) && $this->data['full'] == 1){
						$t = $this->plugins->delete_plugin($plugin['id'],$plugin['plugin'],$plugin['relations']);
					} else {
						$t = $this->plugins->delete_plugin($plugin['id'],$plugin['plugin']);
					}
					
					
					if($t == "Yes") {
						Message::flash($plugin['name'].' '.__('successfully deleted'));
						$this->admin_redirect('plugins');
					}
				}

			} else {
				$this->error();
			}
		} else {
		$this->error();
		}
		
	}

	public function rest_action(){
		$role = $this->user['role_level'];
		$page = __CLASS__.'/'.'index';
		if(!empty($this->data)){
			$data = array();
			if($this->plugins->is_admin_page_allowed($role,$page)  == true){
				if($this->data['do'] == 'install') {
					
					$res = $this->plugins->install($this->data['plugin'],$this->data['version']);
					$data = $res;
				} else if($this->data['do'] == 'update') {
					
					$res = $this->plugins->update($this->data['id'],$this->data['plugin'],$this->data['version']);
					$data = $res;
				} else if($this->data['do'] == 'active'){
					
					if($this->data['active'] == 1) {
						$ac = 0;
						$message_good = __('Plugin was successfully deactivated');
						$message_bad = __('Plugin could not be deactivated');
					} else {
						$ac = 1;
						$message_good = __('Plugin was successfully activated');
						$message_bad = __('Plugin could not be activated');
					}
					$res = $this->plugins->active($this->data['id'],$ac);
					
					if($res['Key'] == 'Success') {
						$data['Message'] = $message_good;
					} else {
						$data['Message'] = $message_bad;
					}
					$data['Key'] = $res['Key'];
					$data['Active'] = $ac;
					$data['check'] = $this->data['active'];
				}
				echo json_encode($data);
			}
		}

	}
}