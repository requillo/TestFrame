<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Rubrieken_model extends Model
{
	
	function __construct()
	{
		parent::__construct();
		// $this->behavior->upload('file',['size' => 5]);
		// $this->behavior->multiple_uploads('test');
	}

	public function get_all_cats(){
		$res = array();
		$sql = "SELECT id, category_name FROM ".PRE."rubrieken_categories WHERE status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($rows as $value) {
			$res[$value['id']] = $value['category_name'];
		}
		return $res;
	}

	public function get_all_the_cats(){
		$res = array();
		$sql = "SELECT id, category_name FROM ".PRE."rubrieken_categories";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($rows as $value) {
			$res[$value['id']] = $value['category_name'];
		}
		return $res;
	}

	public function get_settings($select, $where, $order = ''){
		$sql = "SELECT $select FROM ".PRE."rubrieken_settings WHERE meta = :meta AND status = 1 ".$order;
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':meta' => $where));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_all_cats_settings(){
		$sql = "SELECT * FROM ".PRE."rubrieken_categories WHERE status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function closest($array, $number) {

	    sort($array);
	    foreach ($array as $a) {
	        if ($a >= $number) return $a;
	    }
	    return end($array); // or return NULL;
	}

	public function get_rubrieken(){
		$sql = "SELECT * FROM ".PRE."rubrieken WHERE status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;

	}

	public function get_rubrieken_ads($id){
		$sql = "SELECT * FROM ".PRE."rubrieken_advertisements WHERE rubriek_id = :rubriek_id AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':rubriek_id' => $id));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function the_rubrieken_ads($id){
		$sql = "SELECT * FROM ".PRE."rubrieken_advertisements WHERE id = :id AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}
}