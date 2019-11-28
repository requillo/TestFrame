<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Inventory_model extends Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_all_types(){
		$sql = "SELECT * FROM ".PRE."inventory_item_types WHERE status = 1 ORDER BY id DESC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_all_categories(){
		$sql = "SELECT * FROM ".PRE."inventory_categories WHERE status = 1 ORDER BY id DESC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_inventory($date = NULL, $action = 'add'){ // $action = add / use
		if($date != NULL && $action != NULL) {
			$date = date('Y-m-d', strtotime($date)) ;
			$sql = "SELECT * FROM ".PRE."inventory WHERE status = 1 AND inventory_date = :inventory_date AND inventory_action = :inventory_action ORDER BY id DESC";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':inventory_date' => $date, ':inventory_action' => $action));
		} else {
			$sql = "SELECT * FROM ".PRE."inventory WHERE status = 1 ORDER BY id DESC";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();
		}
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_inventory_date_before($date){ 
		$date = date('Y-m-d', strtotime($date)) ;
		$sql = "SELECT * FROM ".PRE."inventory WHERE status = 1 AND inventory_date < :inventory_date ORDER BY inventory_date DESC, id DESC LIMIT 2";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':inventory_date' => $date));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_inventory_date_after($date){ 
		$date = date('Y-m-d', strtotime($date)) ;
		$sql = "SELECT * FROM ".PRE."inventory WHERE status = 1 AND inventory_date > :inventory_date ORDER BY inventory_date DESC, id DESC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':inventory_date' => $date));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_inventory_add($date = NULL) {
		if($date != NULL ) {
			$date = date('Y-m-d', strtotime($date)) ;
			$sql = "SELECT * FROM ".PRE."inventory_add WHERE status = 1 AND inventory_date = :inventory_date ORDER BY id DESC";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':inventory_date' => $date));
		} else {
			$sql = "SELECT * FROM ".PRE."inventory_add WHERE status = 1 ORDER BY id DESC";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();
		}
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_inventory_use($date = NULL) {
		if($date != NULL ) {
			$date = date('Y-m-d', strtotime($date)) ;
			$sql = "SELECT * FROM ".PRE."inventory_use WHERE status = 1 AND inventory_date = :inventory_date ORDER BY id DESC";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':inventory_date' => $date));
		} else {
			$sql = "SELECT * FROM ".PRE."inventory_use WHERE status = 1 ORDER BY id DESC";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();
		}
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_inventory_use_from_id($id) {
		$sql = "SELECT * FROM ".PRE."inventory_use WHERE status = 1 AND id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_latest_inventory_use($limit = 10) {
		$sql = "SELECT * FROM ".PRE."inventory_use WHERE status = 1 ORDER BY id DESC LIMIT $limit";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_all_items(){
		$sql = "SELECT * FROM ".PRE."inventory_items WHERE status = 1 ORDER BY category, id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function all_categories_options($cats = NULL){
		$cats = $this->get_all_categories();
		$data = array();
		$i = 1;
		$data[0] = __('None', 'inventory');
		foreach ($cats as $value) {
			$data[$value['id']] = $value['name'];
		}
		return $data;
	}

	public function all_types_options($cats = NULL){
		$cats = $this->get_all_types();
		$data = array();
		$i = 1;
		foreach ($cats as $value) {
			$data[$value['id']] = $value['name'];
		}
		return $data;
	}
}