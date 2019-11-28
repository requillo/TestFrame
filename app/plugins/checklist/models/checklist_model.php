<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Checklist_model extends Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_list_names() {
		$sql = "SELECT * FROM ".PRE."checklist_name ORDER BY category,id;";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_list_name_where($arr) {
		$key = key($arr);
		$sql = "SELECT * FROM ".PRE."checklist_name WHERE $key = :$key;";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(":$key" => $arr[$key]));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_list_name($id) {
		$sql = "SELECT * FROM ".PRE."checklist_name WHERE id = :id;";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_list_names_from_ids($id) {
		$sql = "SELECT * FROM ".PRE."checklist_name WHERE id IN($id);";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_departments($id = NULL) {
		if($id == NULL) {
			$sql = "SELECT * FROM ".PRE."checklist_department";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $rows;
		} else {
			$sql = "SELECT * FROM ".PRE."checklist_department WHERE id = :id;";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':id' => $id));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			return $row;
		}
	}

	public function get_user_department() {
			$sql = "SELECT * FROM ".PRE."checklist_users_department";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $row;
	}

	public function get_user_department_from_user_id($user_id) {
			$sql = "SELECT * FROM ".PRE."checklist_users_department WHERE user_id = :user_id";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array('user_id' => $user_id));
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $row;
	}

	public function get_list_cat($id = NULL) {
		if($id==NULL) {
			$sql = "SELECT * FROM ".PRE."checklist_options_cat;";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			$sql = "SELECT * FROM ".PRE."checklist_options_cat WHERE id = :id;";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':id' => $id));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		
		return $row;
	}

	public function get_list_options($cat = NULL, $ids = NULL) {
		if($cat == NULL) {
			$sql = "SELECT * FROM ".PRE."checklist_options ORDER BY list_order, id";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();
		} else {
			if($ids != NULL){
				$sql = "SELECT * FROM ".PRE."checklist_options WHERE category = :cat AND id NOT IN ($ids) ORDER BY list_order, id";
			} else {
				$sql = "SELECT * FROM ".PRE."checklist_options WHERE category = :cat ORDER BY list_order, id";
			}
			
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':cat' => $cat));
		}
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_list_options_to_option($cat,$type = NULL) {
		if($type == NULL) {
			$sql = "SELECT id, name, info FROM ".PRE."checklist_options WHERE category = :category AND type != 8 ORDER BY list_order, id";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':category' => $cat));
		} else {
			$sql = "SELECT id, name, info FROM ".PRE."checklist_options WHERE category = :category AND type = :type ORDER BY list_order, id";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':category' => $cat, ':type' => $type));
		}
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_list_option($id) {
		$sql = "SELECT * FROM ".PRE."checklist_options WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_checklist_settings() {
		$sql = "SELECT * FROM ".PRE."checklist_settings";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_checklist_shifts() {
		$sql = "SELECT * FROM ".PRE."checklist_shifts";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_checklist_current_shift($current_time) {
		$sql = "SELECT * FROM ".PRE."checklist_shifts
		WHERE (shift_start < shift_end and (shift_start <= :shift_start and shift_end > :shift_end))
		OR (shift_start > shift_end and (shift_start <= :shift_start or shift_end > :shift_end))";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':shift_start' => $current_time, ':shift_end' => $current_time));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function check_checklist($list_id,$date,$time) {
		$sql = "SELECT id FROM ".PRE."checklist WHERE data_date = :data_date AND data_interval = :data_interval AND checklist_name_id = :checklist_name_id";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':data_date' => $date, ':data_interval' => $time, ':checklist_name_id' => $list_id ));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			return $row;
	}

	public function get_all_user_ids_from_lists($date){
		$sql = "SELECT created_user FROM ".PRE."checklist WHERE data_date = :data_date GROUP BY created_user";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':data_date' => $date));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_app_users($ids){
		$i = 1;
		$t = count($ids);
		$data = '';
		foreach ($ids as $value) {
			if($i == $t) {
				$data .= $value['created_user'];
			} else {
				$data .= $value['created_user'].',';
			}
			$i++;
			
		}
		$sql = "SELECT id, email, fname, lname, gender FROM ".PRE."users WHERE id IN ($data);";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$users = array();
		foreach ($rows as $value) {
			$users[$value['id']] = $value;
		}
		return $users;
	}

	public function get_checklists($list_id,$date,$time = NULL) {
		if($time == NULL ) {
			$sql = "SELECT * FROM ".PRE."checklist WHERE data_date = :data_date AND checklist_name_id = :checklist_name_id";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':data_date' => $date , ':checklist_name_id' => $list_id ));
		} else {
			if($time[0] > $time[1]) {
				$date1 = $date.' '.$time[0];
				$date2 = $date.' '.$time[1];
  				$date2 = date('Y-m-d H:i:s', strtotime($date2." +1 day"));
			} else {
				$date1 = $date.' '.$time[0];
				$date2 = $date.' '.$time[1];
			}
			
			$sql = "SELECT * FROM ".PRE."checklist WHERE checklist_name_id = :checklist_name_id AND created > :date1 AND created < :date2";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':checklist_name_id' => $list_id, ':date1' => $date1, ':date2' =>  $date2));

		}
			
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $row;
	}

	public function get_checklists_from_id($id) {
			$sql = "SELECT * FROM ".PRE."checklist WHERE id = :id";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':id' => $id ));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			return $row;
	}

	public function get_checklists_simple($list_id,$date,$time = NULL) { // id, data_time, data_interval
		if($time == NULL ) {
			$sql = "SELECT id, data_time, data_interval FROM ".PRE."checklist WHERE data_date = :data_date AND checklist_name_id = :checklist_name_id";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':data_date' => $date , ':checklist_name_id' => $list_id ));
		} else {
			if($time[0] > $time[1]) {
				$date1 = $date.' '.$time[0];
				$date2 = $date.' '.$time[1];
  				$date2 = date('Y-m-d H:i:s', strtotime($date2." +1 day"));
			} else {
				$date1 = $date.' '.$time[0];
				$date2 = $date.' '.$time[1];
			}
			
			$sql = "SELECT id, data_time, data_interval FROM ".PRE."checklist WHERE checklist_name_id = :checklist_name_id AND created > :date1 AND created < :date2";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':checklist_name_id' => $list_id, ':date1' => $date1, ':date2' =>  $date2));

		}
			
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $row;
	}

	public function get_users_checklist(){
		$sql = "SELECT created_user FROM ".PRE."checklist GROUP BY created_user";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function delete_data($table,$id) {
		$sql = "DELETE FROM ".PRE."$table WHERE id =:id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		if( ! $stmt->rowCount() ) {
			return 0;
		}else{
			return 1;
		}
	}
}