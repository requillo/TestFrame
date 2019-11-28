<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Messages_model extends Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_messages($ids){
		if(is_array($ids)) {
		$sql = "SELECT * FROM ".PRE."messages WHERE user_id = :user_id AND to_person_id = :to_person_id  AND status = 1 ORDER BY created DESC LIMIT 50;";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':user_id'=> $ids[1], ':to_person_id' => $ids[0]));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
		} 		
	}

	public function get_messages_from($ids){
		if(is_array($ids)) {
		$sql = "SELECT * FROM ".PRE."messages WHERE user_id = :user_id AND to_person_id = :to_person_id  AND status = 1 ORDER BY created DESC LIMIT 50;";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':user_id'=> $ids[0], ':to_person_id' => $ids[1]));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
		} 		
	}

	public function has_messages_from($ids){
		if(is_array($ids)) {
		$sql = "SELECT id FROM ".PRE."messages WHERE user_id = :user_id AND to_person_id = :to_person_id  AND status = 1 AND has_read = 0";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':user_id'=> $ids[0], ':to_person_id' => $ids[1]));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
		} 		
	}

	public function has_messages($ids){
		if(is_array($ids)) {
		$sql = "SELECT * FROM ".PRE."messages_has_user WHERE user_id = :user_id AND to_person_id = :to_person_id  AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':user_id'=> $ids[1], ':to_person_id' => $ids[0]));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		return $rows;
		} 
	}

	public function update_has_seen($ids){
		$sql = "UPDATE ".PRE."messages SET has_read = 1 WHERE user_id = :user_id AND to_person_id = :to_person_id  AND status = 1 AND has_read = 0";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':user_id'=> $ids[0], ':to_person_id' => $ids[1]));
		$res = $stmt->rowCount() ? 1 : '';
		return $res;
	}

	public function get_messages_users($id = NULL){
		if($id != NULL) {
		$sql = "SELECT * FROM ".PRE."messages_has_user WHERE user_id = :user_id OR to_person_id = :to_person_id  AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':user_id'=> $id, ':to_person_id' => $id));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
		}
	}

	public function get_messages_user($ids){
		if(is_array($ids)) {
		$sql = "SELECT * FROM ".PRE."messages_has_user WHERE user_id = :user_id AND to_person_id = :to_person_id  AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':user_id'=> $ids[0], ':to_person_id' => $ids[1]));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		return $rows;
		}
	}

	public function get_messages_user_info($ids){
		if(is_array($ids)) {
		$sql = "SELECT id, email, fname, lname  FROM ".PRE."users WHERE id IN (".implode(',',$ids).") AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
		}
	}

}