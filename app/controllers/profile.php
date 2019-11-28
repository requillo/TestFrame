<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Controller {
	function __construct() {
		parent::__construct();
	}

	function admin_index() {
		$this->title = __('My Profile');
		$this->loadmodel('users');
		$duser = $this->users->get_user_data($this->user['id']);
		$this->set('User',$duser);
		if(!empty($this->data)) {
			$this->users->id = $this->user['id'];

			if($this->data['password'] != '') {
				$this->data['password'] = $this->users->passcrypt($this->data['password'], $duser['salt']);
			} else {
				unset($this->data['password']);
			}
			unset($this->data['email']);
			unset($this->data['username']);
			$add = $this->users->save($this->data);
			if($add != 0) {
				Message::flash(__('Your Profile is successfully updated'));
				$this->admin_redirect('profile');
			} else {
				Message::flash(__('Could not update your profile'));
				$this->admin_redirect('profile');
			}
		}
	}

}