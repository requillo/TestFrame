<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Messages extends Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->img_ext = array('jpg','png','gif','jpeg');
	}

	public function admin_view($id = NULL){
		$ids[0] = rtrim($id,'/');
		$ids[1] = $this->user['id'];
		$this->title = __("Messages",'messages');
		$this->loadmodel('messages_has_user');
		$chd = $this->messages->get_messages_user($ids);
		
		if($chd['is_typing'] == 1) {
			$this->messages_has_user->id = $chd['id'];
			$t['is_typing'] = 0;
			$this->messages_has_user->save($t);
		}
		if(!isset($_GET['no-update'])){
			$ups = $this->messages->update_has_seen($ids);
			if($ups > 0) {
			$uids[0] = $ids[1];
			$uids[1] = $ids[0];
			$us = $this->messages->get_messages_user($uids);
			$d['has_update'] = ($us['has_update']+1);
			$this->messages_has_user->id = $us['id'];
			$this->messages_has_user->save($d);
			}
		}
		
		$messages =  $this->messages->get_messages($ids);
		$messagesFr = $this->messages->get_messages_from($ids);
		$all_message = array_merge($messages,$messagesFr);
		$has_messages = $this->messages->has_messages($ids);
		$all_users = $this->messages->get_messages_users($ids[1]);
		$tu = array();
		$cu[0] = $ids[0];
		$message_users = array();
		$current_user = $this->messages->get_messages_user_info($cu);
		if(!empty($all_users)) {
			$i = 0;
			foreach ($all_users as $key => $value) {
				if($value['user_id'] == $ids[1]) {
					$tu[$i] = $value['to_person_id'];
					$i++;
				} else if($value['to_person_id'] == $ids[1]) {
					$tu[$i] = $value['user_id'];
					$i++;
				}
			}
			$tu = array_unique($tu);
		}
		if(empty($has_messages)) {
			$this->loadmodel('messages_has_user');
			$data['user_id'] = $ids[1];
			$data['to_person_id'] = $ids[0];
			$data['is_typing'] = 0;
			$data['status'] = 1;
			$this->messages_has_user->save($data);
		} else {
			$message_users = $this->messages->get_messages_user_info($tu);
			// print_r($current_user);
		}
		foreach ($all_message as $key => $value) {
			$all_message[$key]['day'] = date('Y-m-d', strtotime($value['created']));
			$sort[$key] = strtotime($value['created']);
		}
		if(!empty($all_message)) {
			array_multisort($sort, SORT_DESC, $all_message);
			$all_message = array_reverse($all_message);
		}
		$this->set('messages',$all_message);
		$this->set('message_users',$message_users);
		$this->set('current_user',$current_user);
		$this->set('img_ext', $this->img_ext);
		$this->set('chd',$chd);
	}

	public function admin_index(){
		$this->title = __("Messages",'messages');
		// messages-files-D0twlIs87g91Ed6enbFyGkAxfCJ42q1539631995.jpg
		// app-logo-Ny63v4uwGHkoxqK2Oz8i1524063246.png
		// echo $this->messages->behavior->resize_image('app-logo-EwrNMFd0t45vsLjcxKfb1539700423.jpg', 150, 150, true);
	}

	public function widget_pop_messages(){

	}

	public function widget_menu_item(){
		$cur_menu = CURRENT_URL;
		$link = admin_url('messages/view');
		$res = '';
		if(strpos($cur_menu, $link)) {
			$res .= '<li class="active"><a href="'.$link.'"><i class="fa fa-envelope-o" aria-hidden="true"></i> <span>'.__('Messages','messages').'</span></a></li>';
		} else {
			$res .= '<li class=""><a href="'.$link.'"><i class="fa fa-envelope-o" aria-hidden="true"></i> <span>'.__('Messages','messages').'</span></a></li>';
		}
		echo $res;
	}

	public function rest_get_messages(){
		$ids[0] = $this->data['to_person_id'];
		$ids[1] = $this->user['id'];
		$messages =  $this->messages->get_messages($ids);
		$messagesFr = $this->messages->get_messages_from($ids);
		$all_message = array_merge($messages,$messagesFr);
		foreach ($all_message as $key => $value) {
			$all_message[$key]['day'] = date('Y-m-d', strtotime($value['created']));
			$sort[$key] = strtotime($value['created']);
		}
		if(!empty($all_message)) {
			array_multisort($sort, SORT_DESC, $all_message);
			$all_message = array_reverse($all_message);
		}

		json_encode($all_message);

	}

	public function rest_send_message(){
		if(!empty($this->data)) {
			$this->data['created'] = date('Y-m-d H:i:s');
			$this->data['status'] = 1;
			$this->data['user_id'] = $this->user['id'];
			$this->data['message'] = trim($this->data['message']);
			$ch = $this->messages->save($this->data);
			if($ch > 0){
				$data['ok'] = 'success';
				$ids[0] = $this->user['id'];
				$ids[1] = $this->data['to_person_id'];
				$chids [0] = $ids[1];
				$chids [1] = $ids[0];
				$us = $this->messages->get_messages_user($ids);
				$usch = $this->messages->get_messages_user($chids);
				$this->loadmodel('messages_has_user');
				$d['has_update'] = ($us['has_update']+1);
				$d['is_typing'] = 0;
				$this->messages_has_user->id = $us['id'];
				$this->messages_has_user->save($d);
				$data['see'] = $us;
				if($usch['is_typing'] == 1) {
					$t['is_typing'] = 0;
					$this->messages_has_user->id = $usch['id'];
					$this->messages_has_user->save($t);
				}
			} else {
				$data['ok'] = 'failed';
			}
			echo json_encode($data);
		}
	}

	public function rest_do_update(){
		$ids[0] = $this->user['id'];
		$ids[1] = $this->data['to_person_id'];
		$us = $this->messages->get_messages_user($ids);
		$this->loadmodel('messages_has_user');
		$d['has_update'] = ($us['has_update']+1);
		$this->messages_has_user->id = $us['id'];
		$this->messages_has_user->save($d);
	}


	public function rest_check_update(){
		if(!empty($this->data)) {
			$ids[1] = $this->user['id'];
			$ids[0] = $this->data['to_person_id'];
			$data = $this->messages->get_messages_user($ids);
			$ch_m = $this->messages->has_messages_from($ids);
			$data['has_messages'] = count($ch_m);
			if($data['is_typing'] == 1) {
			$n = strtotime(date('Y-m-d H:i:s'));
			$d = strtotime($data['is_typing_date']);
			$o = ($n - $d);
				if($o > 8){
					$this->loadmodel('messages_has_user');
					$this->messages_has_user->id = $data['id'];
					$t['is_typing'] = 0;
					$this->messages_has_user->save($t);
				}
			}
			echo json_encode($data);
		}
	}

	public function rest_check_my_update(){
		if(!empty($this->data)) {
			$ids[0] = $this->user['id'];
			$ids[1] = $this->data['to_person_id'];
			$data = $this->messages->get_messages_user($ids);

			// $data = $us;
			echo json_encode($data);
		}
	}

	public function rest_update_seen(){
		if(!empty($this->data)) {
			
			echo json_encode($data);
		}
	}

	public function rest_is_typing(){
		if(!empty($this->data)) {
			$ids[0] = $this->user['id'];
			$ids[1] = $this->data['to_person_id'];
			$us = $this->messages->get_messages_user($ids);
			if(!empty($us) && $us['is_typing'] == 0) {
				$this->loadmodel('messages_has_user');
				$data = array();
				$this->messages_has_user->id = $us['id'];
				$data['is_typing'] = 1;
				$data['is_typing_date'] = date('Y-m-d H:i:s');
				$this->messages_has_user->save($data);
			}
			$d = $us;
			echo json_encode($d);
		}
	}

	public function rest_is_not_typing(){
		if(!empty($this->data)) {
			$ids[0] = $this->user['id'];
			$ids[1] = $this->data['to_person_id'];
			$us = $this->messages->get_messages_user($ids);
			if(!empty($us) && $us['is_typing'] == 1) {
				$this->loadmodel('messages_has_user');
				$data = array();
				$this->messages_has_user->id = $us['id'];
				$data['is_typing'] = 0;
				$data['is_typing_date'] = date('Y-m-d H:i:s');
				$this->messages_has_user->save($data);
			}
			$d = $us;
			echo json_encode($d);
		}
	}

	function rest_file_upload(){
		if(isset($this->data['file'])) {
			$document = $this->messages->behavior->upload_protect_ajax('attachment',array('size' => 5,'dir' => 'messages/files'));
			echo $document;
		}				
	}
}