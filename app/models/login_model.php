<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Login_model extends Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function user_login($user,$pass,$link,$keep = NULL){
		$sql = "SELECT id, salt, password, username, status FROM ".PRE."users WHERE username = :user";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':user' => $user));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!empty($row)){
			$this->importmodel('users');
			$saltedpass = $this->passcrypt($pass, $row['salt']);
			$md5pass = md5($pass);
			$sha1pass = sha1($pass);
			if(strlen($row['password']) == 32 && $md5pass == $row['password'] && $row['status'] == 1) {
				$this->users->id = $row['id'];
				$this->users->save(array('sid' => ''));
				$_SESSION['loggedin']['id'] = $row['id'];
				$_SESSION['loggedin']['username'] = $row['username'];
				if(LANG_ALIAS == DEFAULT_LANG_ALIAS) {
					header('Location:'.URL.BACKEND_URL);
				} else {
					header('Location:'.URL.LANG_ALIAS.BACKEND_URL);
				}
				Message::flash(__("You've logged in with a MD5 password, please change your password in your profile page"));

			} else if(strlen($row['password']) == 40 && $sha1pass == $row['password'] && $row['status'] == 1) {
				$this->users->id = $row['id'];
				$this->users->save(array('sid' => ''));
				$_SESSION['loggedin']['id'] = $row['id'];
				$_SESSION['loggedin']['username'] = $row['username'];
				if(LANG_ALIAS == DEFAULT_LANG_ALIAS) {
					header('Location:'.URL.BACKEND_URL);
				} else {
					header('Location:'.URL.LANG_ALIAS.BACKEND_URL);
				}
				Message::flash(__("You've logged in with a SHA1 password, please change your password in your profile page"));

			} else if($saltedpass == $row['password'] && $row['status'] == 1) {
				$this->users->id = $row['id'];
				$this->users->save(array('sid' => ''));
				$_SESSION['loggedin']['id'] = $row['id'];
				$_SESSION['loggedin']['username'] = $row['username'];
				if($keep == 1) {
					$keep = $this->keep($row['username']);
					$this->update_keep($keep,$row['id']);
					$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
					setcookie('keep', $keep, time()+60*60*24*365, '/', $domain, false);
				} else {
					// $keep = '';
					// $this->update_keep($keep,$row['id']);
				}
				if(LANG_ALIAS == DEFAULT_LANG_ALIAS) {
					header('Location:'.URL.BACKEND_URL);
				} else {
					header('Location:'.URL.LANG_ALIAS.BACKEND_URL);
				}
				
			} else {
				if($row['status'] == 0) {
					Message::flash(__('You have been blocked'),'error');
					header('Location:'.$link);
				} else {
					Message::flash(__('Password is incorrect'),'error');
					header('Location:'.$link);
				}
				
			}

		} else {
			Message::flash(__('User does not exists'),'error');
			header('Location:'.$link);
		}
		 
	}

	public function rest_user_login($user,$pass){
		$sql = "SELECT id, fname, lname, username, email, salt, password FROM ".PRE."users WHERE username = :user";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':user' => $user));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$res = array();
		if(!empty($row)){
			$saltedpass = $this->passcrypt($pass, $row['salt']);
			$md5pass = md5($pass);
			$sha1pass = sha1($pass);
			if(strlen($row['password']) == 32 && $md5pass == $row['password']) {
				$res['id'] = $row['id'];
				$res['first_name'] = $row['fname'];
				$res['last_name'] = $row['lname'];
				$res['username'] = $row['username'];
				$res['email'] = $row['email'];
				$res['special'] = substr($row['password'], 4, 10);
				$res['logged_in'] = 'Yes';
				$res['message'] = __("You've logged in with a MD5 password, please change your password in your profile page");
				$res['token'] = token($res['id'].$res['username'].$res['special']);

			} else if(strlen($row['password']) == 40 && $sha1pass == $row['password']) {
				$res['id'] = $row['id'];
				$res['first_name'] = $row['fname'];
				$res['last_name'] = $row['lname'];
				$res['username'] = $row['username'];
				$res['email'] = $row['email'];
				$res['special'] = substr($row['password'], 4, 10);
				$res['logged_in'] = 'Yes';
				$res['message'] = __("You've logged in with a MD5 password, please change your password in your profile page");
				$res['token'] = token($res['id'].$res['username'].$res['special']);

			} else if($saltedpass == $row['password']) {
				$res['id'] = $row['id'];
				$res['first_name'] = $row['fname'];
				$res['last_name'] = $row['lname'];
				$res['username'] = $row['username'];
				$res['email'] = $row['email'];
				$res['special'] = substr($row['password'], 4, 10);
				$res['logged_in'] = 'Yes';
				$res['message'] = __("Welcome, your logged in");
				$res['token'] = token($res['id'].$res['username'].$res['special']);
				
			} else {
				$res['logged_in'] = 'No';
				$res['message'] = __('Password is incorrect');
				$res['token'] = '';
				// header('Location:'.$link);
			}

		} else {
			$res['logged_in'] = 'No';
			$res['message'] = __('User does not exists');
			$res['token'] = '';
		}

		return json_encode($res);
		 
	}

	public function keep($name){
		$token = round(microtime(true)).mt_rand().$name;
		$token = hash('sha512', $token);
		$token = substr($token, 4, -4);
		return $token;
	}

	public function update_keep($keep,$id){
		$sql = "UPDATE ".PRE."users SET keep = :keep WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':keep' => $keep, ':id' => $id));
	}

}