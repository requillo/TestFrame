<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class users extends controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function admin_index(){
		$this->title = __('All Users');
		$this->set('Users', $this->users->get_all_users($this->user['role_level']));
		$roles = $this->users->get_all_user_roles($this->user['role_level']);
		$i = 0;
		$nrole = array();
		foreach ($roles as $role) {
			$nrole[$i]['role_level'] = $role['role_level'];
			$nrole[$i]['role_name'] = $this->users->get_content($role['role_name']);
			$i++;
		}
		$this->set('User_roles', $nrole);
	}

	function admin_new(){
		$this->title = __('Add user');
		$roles = $this->users->get_all_user_roles($this->user['role_level']);
		$i = 0;
		$nrole = array();
		$this->set('Companies',$this->users->get_companies());
		foreach ($roles as $role) {
			$nrole[$i]['role_level'] = $role['role_level'];
			$nrole[$i]['role_name'] = $this->users->get_content($role['role_name']);
			$i++;
		}
		$this->set('User_roles', $nrole);
		// $this->error();
		// echo $this->error;
		if(!empty($this->data)){
			$this->required_data(array('email' => array('email' => true)));

			//$id = $this->users->insert_user_info($this->data['fname'],$this->data['lname'],$this->data['email'],$this->data['username'],$this->data['password'],$this->data['gender'],$this->data['status']);
			$salt = $this->users->generateRandomString();
			$this->data['salt'] = $salt;
			$this->data['password'] = $this->users->passcrypt($this->data['password'], $salt);
			$this->data['created'] = date('Y-m-d H:i:s');
			$id = $this->users->save($this->data);
			if($id != 0) {
				$this->loadmodel('user_relations');
				$data['user_id'] = $id;
				if($this->data['role'] > $this->user['role_level']){
				// $this->users->insert_user_relation($id,$this->user['role_level']);
				$data['role_level'] = $this->user['role_level'];
				$data['user_company'] = $this->data['user_company'];
				} else {
				// $this->users->insert_user_relation($id,$this->data['role']);
				$data['role_level'] = $this->data['role'];
				$data['user_company'] = $this->data['user_company'];
				}
				$id = $this->user_relations->save($data);
				Message::flash(__('User successfully added'));

			} else {
				Message::flash(__('User could not be added'),'error');
			}

			if(isset($this->data['save'])){
				if($id != 0) {
					$this->admin_redirect('users');
				} else {
					$this->admin_redirect('users/new');
				}
				
			} else if(isset($this->data['saveclose'])) {
				$this->admin_redirect('users');
			} else {
				$this->admin_redirect('users/new');
			}
			
		}
	}

	function admin_edit($id){
		$this->title = __('Edit User');
		$user = explode('/', $id);
		$userdata = $this->users->get_user_data($user[0]);
		$theuserrole = $this->users->get_user_role($user[0]);
		$this->set('Companies',$this->users->get_companies());
		if(!isset($userdata['username'])){
			$this->admin_redirect('users');
		}
		if($theuserrole > $this->user['role_level']) {
			$this->admin_redirect('users');
		}
		$this->set('User', $userdata);
		$roles = $this->users->get_all_user_roles($this->user['role_level']);
		$i = 0;
		$nrole = array();
		foreach ($roles as $role) {
			$nrole[$i]['role_level'] = $role['role_level'];
			$nrole[$i]['role_name'] = $this->users->get_content($role['role_name']);
			$i++;
		}
		$this->set('User_roles', $nrole);
		if(!empty($this->data)){
			// print_r($this->data);
			if($this->user['role_level'] >= $theuserrole){
				$id = $this->users->update_user_info($this->data['fname'],$this->data['lname'],$this->data['email'],$this->data['username'],$this->data['password'],$this->data['gender'],$this->data['status'],$user[0],$this->user['id']);
				
				if($id != 0) {
					$this->loadmodel('user_relations');
					if($this->data['role'] > $this->user['role_level']){
						$reldata['role_level'] = $this->user['role_level'];
						$reldata['user_company'] = $this->data['user_company'];
						//$this->users->update_user_relation($id,$this->user['role_level']);
						$this->user_relations->id = $userdata['user_relations_id'];
						$this->user_relations->save($reldata);
					} else {
						$reldata['role_level'] = $this->data['role'];
						$reldata['user_company'] = $this->data['user_company'];
						//$this->users->update_user_relation($id,$this->data['role']);
						$this->user_relations->id = $userdata['user_relations_id'];
						$this->user_relations->save($reldata);
					}
					Message::flash(__('User successfully updated'));
				} else {
					Message::flash(__('User could not be updated'),'error');
				}

				if(isset($this->data['save'])){
					$this->admin_redirect('users/edit/'.$user[0]);
				} else if(isset($this->data['saveclose'])){
					$this->admin_redirect('users');
				} else {
					$this->admin_redirect('users/new');
				}


			} else {
				Message::flash(__("You are trying to do something malicious and you are reported to the Admin"));
				$this->admin_redirect('users');
			}
			

		}
		
	}

	function admin_user_roles(){
		$this->title = __('User roles');
		$this->set('Roles',$this->users->the_roles($this->user['role_level']));
		$this->set('Roles_below_options',$this->users->add_role_below_options($this->user['role_level']));
		$this->set('Roles_above_options',$this->users->add_role_above_options($this->user['role_level']));
		if(!empty($this->data)){
			$data['role_name'] = $this->data['new-user-role'];
			$check = preg_replace('/\s+/', '', $data['role_name']);
			$this->loadmodel('user_roles');
			if (isset($this->data['role'])){
				if($this->data['role'] == 2) {
				$data['role_level'] = $this->data['role_below'] - 1;
				$check_role = $this->data['role_below'];
				} else {
					$data['role_level'] = $this->data['role_above'] + 1;
					$check_role = $this->data['role_above'];
				}
			}
			
			if($check != ''){

				if($this->user_roles->save($data)) {
					$this->loadmodel('meta_options');
					$opt['name'] = 'admin_pages';
					$opt['value'] = $data['role_level'].'.0';
					$opt['meta_text'] = $this->users->option('meta_text',array('name'=>'admin_pages', 'value' => $check_role));
					$this->meta_options->save($opt);
					Message::flash(__("New Role added"));
					$this->admin_redirect('users/user-roles');
				} else {
					Message::flash(__("Role could not be added"),'error');
				}
			} else {
				Message::flash(__("Role could not be added"),'error');
			}

		}
	}

	function admin_companies(){
		$this->title = __('Companies');
		$this->set('Companies',$this->users->get_companies());
	}

	function admin_add_company(){
		$this->title = __('Add Company');
		if(!empty($this->data)){
			$this->loadmodel('user_company');
			if($this->user_company->save($this->data)) {
				Message::flash(__("Company added"));
				$this->admin_redirect('users/companies');
			} else {
				Message::flash(__("Company could not be added"),'error');
			}
		}
	}

	function admin_edit_company($id){
		$this->title = __('Edit Company');
		$this->set('Company',$this->users->get_companies($id));
		$this->loadmodel('user_company');
		$this->user_company->id = $id;
		if(!empty($this->data)){
			if($this->user_company->save($this->data)) {
				Message::flash(__("Company added"));
				$this->admin_redirect('users/companies');
			} else {
				Message::flash(__("Company could not be added"),'error');
			}
		}
	}

	function rest_action(){
		$data = array();
		$data['Role'] = $this->user['role_level'];
		if(!empty($this->data)){
			$data['Key'] = 'Success';
			// This is for the users index page
			if(isset($this->data['bulk'])) {
				// Update user roles
				if($this->data['bulk'] == 1) {
					foreach ($this->data['userids'] as $id) {
						$user_role = $this->users->get_user_role($id);
						if($data['Role'] >= $user_role) {
							if($this->data['role-edit'] > $data['Role']) {
								$role = $data['Role'];
							} else {
								$role = $this->data['role-edit'];
							}
							$this->users->update_user_relation($id,$role);
							$data['Action'] = 'Edit role';
						}
					}
				// Suspend users	
				} else if($this->data['bulk'] == 2){
					
					foreach ($this->data['userids'] as $id) {
						$user_role = $this->users->get_user_role($id);
						if($data['Role'] >= $user_role) {
							$this->users->suspend_user($id);
							$data['Action'] = $id;
						}
					}
				// Enable users
				} else if($this->data['bulk'] == 3){ 
					
					foreach ($this->data['userids'] as $id) {
						$user_role = $this->users->get_user_role($id);
						if($data['Role'] >= $user_role) {
							$this->users->enable_user($id);
							$data['Action'] = 'Enable';
						}
					}
				// Delete users
				} else if($this->data['bulk'] == 4){
					
					foreach ($this->data['userids'] as $id) {
						$user_role = $this->users->get_user_role($id);
						if($data['Role'] >= $user_role) {
							$this->users->delete_user($id);
							$this->users->delete_user_role($id);
							$data['Action'] = 'Delete';	
						}
					}
				}

			}
			// This is for the email check function
			if(isset($this->data['todo'])){
				if($this->data['todo'] == 'emailcheck'){
					$id = $this->users->check_if_email_exists($this->data['email']);
					$data['Key'] = $id;
				}

				if($this->data['todo'] == 'userscheck'){
					$id = $this->users->check_if_username_exists($this->data['user']);
					$data['Key'] = $id;
				}

			}


		}
		echo json_encode($data);
	}

	function rest_groups(){
		$data = array();
		if(!empty($this->data)){		
			$res = $this->users->get_all_groups($this->data['group']);
			if($res) {
				$val = '<div id="res-group">';
				foreach ($res as $value) {
					$val .= '<div class="opt">'.$value['group_name'].'</div>';
				}
				$val .= '</div>';
				$data['val'] = $val;
			} else {
				$data['val'] = '<div id="res-group"><div class="opt">Sorry nothing</div></div>';
			}
		}

		echo json_encode($data);

	}

	function rest_set_edit_roles(){
		if(!empty($this->data)){
			$data = array();
			$this->loadmodel('user_roles');
			$this->user_roles->column('role_level',$this->data['role_level']);
			if(!in_array($this->data['role_level'], $this->users->default_roles) && $this->data['role_level'] <= $this->user['role_level']) {
				$ch = $this->user_roles->save($this->data);
				if($ch > 0) {
					$data['edit'] = 'success';
				}
			}
			echo json_encode($data);	
		}
	}

	function rest_set_delete_roles(){
		 if(!empty($this->data)){
			$roles = $this->users->get_all_roles($this->user['role_level']);
			$key = array_search ($this->data['role_level'], $roles);
			$updatekey = $key + 1;
			$data = array();
			$data['roles'] = $roles;
			$data['key'] = $key;
			$data['update_to_role'] = $roles[$updatekey];
			
			$this->loadmodel('user_roles');
			
			if(!in_array($this->data['role_level'], $this->users->default_roles) && $this->data['role_level'] <= $this->user['role_level']) {
				$this->users->update_all_user_roles($this->data['role_level'], $roles[$updatekey]);
				$ch1 = $this->users->delete_user_roles($this->data['role_level']);
				$ch2 = $this->users->delete_user_role_meta($this->data['role_level']);
				if($ch1 > 0 && $ch2 > 0) {
					$data['check'] = 'success';
				}
			}
			echo json_encode($data);	
		}
	}
}