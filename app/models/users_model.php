<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Users_model extends Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->arg = 'User model';
		$this->default_roles = array('100.0','60.0','8.0','5.0','1.0');
	}

	function get_all_users($role){
		$ids = $this->get_all_users_ids($role);
		$user = array();
		$i = 0;
		foreach ($ids as $id) {
			$user[$i] = $this->get_user_data($id['user_id']);
			$i++;
		}
		return $user;
	}

	function get_user_data($id){
		$sql = "SELECT * FROM ".PRE."users WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!empty($row)){
			$relation = $this->get_user_relation($id);
			$row['level'] = $relation['role_level'];
			$row['company_id'] = $relation['user_company'];
			$row['user_relations_id'] = $relation['id'];
			$row['level-name'] = $this->get_role_name($row['level']);
			$row['group-id'] = $relation['user_group'];
			$row['group-name'] = $this->get_group_name($relation['user_group']);
		}
		return $row;
	}

	function get_user_data_from_email($email){
		$sql = "SELECT * FROM ".PRE."users WHERE email = :email AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':email' => $email));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!empty($row)) {
			$relation = $this->get_user_relation($row['id']);
			$row['level'] = $relation['role_level'];
			$row['company_id'] = $relation['user_company'];
			$row['user_relations_id'] = $relation['id'];
			$row['level-name'] = $this->get_role_name($row['level']);
			$row['group-id'] = $relation['user_group'];
			$row['group-name'] = $this->get_group_name($relation['user_group']);
		}
		return $row;
	}

	function get_companies($id = NULL){
		if($id == NULL) {
			$sql = "SELECT * FROM ".PRE."user_company";
		} else {
			$sql = "SELECT * FROM ".PRE."user_company WHERE id = :id";
		}
		
		$stmt = $this->pdo->prepare($sql);
		
		if($id == NULL) {
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			$stmt->execute(array(':id' => $id));
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		return $rows;
	}

	function get_all_users_ids($role){
		$sql = "SELECT user_id, role_level FROM ".PRE."user_relations WHERE role_level <= :role_level";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':role_level' => $role));
		$rows = $stmt->fetchALL(PDO::FETCH_ASSOC);
		return $rows;
	}

	function get_user_relation($id){
		$sql = "SELECT * FROM ".PRE."user_relations WHERE user_id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	function the_roles($current_user_role){
		$res = '';
		$sql = "SELECT id, role_name, role_level FROM ".PRE."user_roles ORDER BY role_level DESC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$i = 1;
		$ridb = 1;
			foreach ($rows as $row) {
				if($current_user_role >= $row['role_level']) {
					$cr = explode('.', $row['role_level']);
					if($cr[0] == $ridb) {
						if(in_array($row['role_level'], $this->default_roles)) {
							$res .= '</li><li class="holder"><span class="level-name">'.$this->get_content($row['role_name']). '</span> <span class="level-number">'.__('Level').': '.$row['role_level'].'</span>';
						} else {
							$res .= '</li><li class="holder"><a href="#" data-id="'.$row['id'].'" data-level="'.$row['role_level'].'"><span class="level-name">'.$this->get_content($row['role_name']). '</span> <span class="level-number">'.__('Level').': '.$row['role_level'].'</a></span>';

						}
						
					} else {
						if(in_array($row['role_level'], $this->default_roles)) {
							$res .= "\n".'<ul class="level-'.$i.' role"><li class="holder"><span class="level-name">'.$this->get_content($row['role_name']). '</span> <span class="level-number">'.__('Level').': '.$row['role_level'].'</span>';
						} else {
							$res .= "\n".'<ul class="level-'.$i.' role"><li class="holder"><a href="#" data-id="'.$row['id'].'" data-level="'.$row['role_level'].'"><span class="level-name">'.$this->get_content($row['role_name']). '</span> <span class="level-number">'.__('Level').': '.$row['role_level'].'</a></span>';

						}

						
						$i++;
					}
					$ridb = $cr[0];					
				}

			}

			for ($x = 1; $x < $i; $x++) {
   			 $res .= '</li></ul>'."\n";
			} 
			return $res;
	}

	function get_all_roles($level){
		$sql = "SELECT role_level FROM ".PRE."user_roles WHERE role_level < :level ORDER BY role_level DESC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':level' => $level));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$roles = array();
		foreach ($rows as $key => $value) {
			$roles[$key] = $value['role_level'];
		}
		return $roles;
	}

	function update_all_user_roles($wherelevel, $updatelevel){
		$sql = "UPDATE ".PRE."user_relations SET role_level = :role_level  WHERE role_level = :wherelevel";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':role_level' => $updatelevel, ':wherelevel' => $wherelevel));
		$res = $stmt->rowCount() ? 1 : 0;
		return $res;
	}

	function delete_user_roles($wherelevel){
		$sql = "DELETE FROM ".PRE."user_roles WHERE role_level = :wherelevel";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':wherelevel' => $wherelevel));
		$res = $stmt->rowCount() ? 1 : 0;
		return $res;
	}

	function delete_user_role_meta($wherelevel){
		$sql = "DELETE FROM ".PRE."meta_options WHERE value = :wherelevel AND name = 'admin_pages'";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':wherelevel' => $wherelevel));
		$res = $stmt->rowCount() ? 1 : 0;
		return $res;
	}

	function get_role_name($level){
		$sql = "SELECT role_name FROM ".PRE."user_roles WHERE role_level = :level";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':level' => $level));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $this->get_content($row['role_name']);

	}

	function get_group_name($id){
		$sql = "SELECT group_name FROM ".PRE."user_groups WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['group_name'];
	}

	function get_group_id($group_name){
		$sql = "SELECT id FROM ".PRE."user_groups WHERE group_name = :group_name";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':group_name' => $group_name));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['id'];
	}

	function get_all_user_roles($role){
		$sql = "SELECT role_name, role_level FROM ".PRE."user_roles WHERE role_level <= :role ORDER BY role_level";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':role' => $role));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$i = 0;
		foreach ($rows as $row) {
			$rows[$i]['role_name'] = $this->get_content($row['role_name']);
			$i++;
		}
		return $rows;
	}

	function add_role_below_options($role){
		$roles = $this->get_all_user_roles($role);
		$i = 0 ;
		$data = array();
		foreach ($roles as $role) {
			$rb = $role['role_level'] - 1;
			if($this->role_exists($roles,'role_level',$rb)){
				$data[$i]['role_name'] = $role['role_name'];
				$data[$i]['role_level'] = $role['role_level'];
				$i++;
			}
			
		}
		return $data;
	}

	function add_role_above_options($role){
		$roles = $this->get_all_user_roles($role);
		$i = 0 ;
		$data = array();
		foreach ($roles as $role) {
			$rb = $role['role_level'] + 1;
			if($this->role_exists($roles,'role_level',$rb)){
				$data[$i]['role_name'] = $role['role_name'];
				$data[$i]['role_level'] = $role['role_level'];
				$i++;
			}
			
		}
		return $data;
	}

	function role_exists($array, $key, $val) {
	    foreach ($array as $item)
	        if (isset($item[$key]) && $item[$key] == $val ||  $val == 0 || $val > 99)
	            return false;
	    return true;
	}

	function get_all_groups($group){
		$sql = "SELECT group_name FROM ".PRE."user_groups WHERE group_name LIKE :group_name";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':group_name' => "%$group%"));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	function insert_user_info($fname,$lname,$email,$username,$pass,$gender,$status){
		$sql = "INSERT INTO ".PRE."users (email,fname,lname,salt,password,username,gender,status,created) 
			VALUES (:email, :fname, :lname, :salt, :password, :username, :gender, :status, :created)";
		$stmt = $this->pdo->prepare($sql);
		$salt = $this->generateRandomString();
		$saltedpass = $this->passcrypt($pass, $salt);
		$date = date('Y-m-d H:i:s');
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':fname', $fname);
		$stmt->bindParam(':lname', $lname);
		$stmt->bindParam(':salt', $salt);
		$stmt->bindParam(':password', $saltedpass);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':gender', $gender);
		$stmt->bindParam(':status', $status);
		$stmt->bindParam(':created', $date);
		$stmt->execute();
		return $this->pdo->lastInsertId();
	}

	function update_user_info($fname,$lname,$email,$username,$pass,$gender,$status,$id,$userid){
		$salt = $this->generateRandomString();
		$saltedpass = $this->passcrypt($pass, $salt);
		$date = date('Y-m-d H:i:s');
		if($pass != '') {
			$sql = "UPDATE ".PRE."users SET email = :email,fname = :fname,lname = :lname,salt = :salt,password = :password,username = :username,gender = :gender,status = :status,updated_user = :updated_user,updated_date = :updated_date WHERE id = :id";
		} else {
			$sql = "UPDATE ".PRE."users SET email = :email,fname = :fname,lname = :lname,username = :username,gender = :gender,status = :status, updated_user = :updated_user, updated_date = :updated_date WHERE id = :id";
		}
		$stmt = $this->pdo->prepare($sql);
		if($pass != '') {
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':fname', $fname);
			$stmt->bindParam(':lname', $lname);
			$stmt->bindParam(':salt', $salt);
			$stmt->bindParam(':password', $saltedpass);
			$stmt->bindParam(':username', $username);
			$stmt->bindParam(':gender', $gender);
			$stmt->bindParam(':status', $status);
			$stmt->bindParam(':updated_user', $userid);
			$stmt->bindParam(':updated_date', $date);
			$stmt->bindParam(':id', $id);
		} else {
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':fname', $fname);
			$stmt->bindParam(':lname', $lname);
			$stmt->bindParam(':username', $username);
			$stmt->bindParam(':gender', $gender);
			$stmt->bindParam(':status', $status);
			$stmt->bindParam(':updated_user', $userid);
			$stmt->bindParam(':updated_date', $date);
			$stmt->bindParam(':id', $id);
		}
		if($stmt->execute()) {
			return $id;
		} else {
			return 0;
		}
		
		
	}

	function insert_user_relation($id,$role){
		$sql = "INSERT INTO ".PRE."user_relations (user_id, role_level) 
			VALUES (:user_id, :role_level)";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(':user_id', $id);
		$stmt->bindParam(':role_level', $role);
		$stmt->execute();
	}

	function update_user_relation($id,$role){
		$sql = "UPDATE ".PRE."user_relations SET role_level = :role_level WHERE user_id = :user_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(':user_id', $id);
		$stmt->bindParam(':role_level', $role);
		$stmt->execute();
	}

	function suspend_user($id) {
		$sql = "UPDATE ".PRE."users SET status = :status WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$status = 0;
		$stmt->execute(array(':status' => $status, ':id' => $id));
	}

	function enable_user($id) {
		$sql = "UPDATE ".PRE."users SET status = :status WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$status = 1;
		$stmt->bindParam(':status', $status);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		
	}

	function delete_user($id){
		$sql = "DELETE FROM ".PRE."users WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
	}

	function delete_user_role($id){
		$sql = "DELETE FROM ".PRE."user_relations WHERE user_id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
	}

	function check_if_email_exists($email){
		$email = trim($email);
		$sql = "SELECT id FROM ".PRE."users WHERE email = :email";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':email' => $email));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row['id'] != ''){
			return 2;
		} else {
			return 1;
		}
	}

	function check_if_username_exists($user){
		$user = trim($user);
		$sql = "SELECT id FROM ".PRE."users WHERE username = :username";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':username' => $user));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row['id'] != ''){
			return 2;
		} else {
			return 1;
		}
	}

}