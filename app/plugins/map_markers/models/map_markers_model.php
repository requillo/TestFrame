<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Map_markers_model extends Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_settings($meta = NULL, $all = NULL) {
		if($meta == NULL) {
			$sql = "SELECT * FROM ".PRE."map_marker_settings";
		} else {
			$sql = "SELECT * FROM ".PRE."map_marker_settings WHERE meta = :meta AND status = 1";
		}
		$stmt = $this->pdo->prepare($sql);
		if($meta == NULL) {
			$stmt->execute();
		} else {
			$stmt->execute(array(':meta' => $meta));
		}
		if($all == NULL) {
			$rows = $stmt->fetchALL(PDO::FETCH_ASSOC);
		} else {
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		
		return $rows;
	}

	public function get_all_stations() {
		$sql = "SELECT * FROM ".PRE."map_markers WHERE status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_all_no_relation_stations() {
		$sql = "SELECT * FROM ".PRE."map_markers WHERE status = 1 AND site_id = 0";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_all_regions() {
		$sql = "SELECT * FROM ".PRE."map_marker_regions WHERE status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_station($id) {
		$sql = "SELECT * FROM ".PRE."map_markers WHERE status = 1 AND id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id'=> $id));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_related_markers() {
		$sql = "SELECT site_id FROM ".PRE."map_markers WHERE status = 1 GROUP BY site_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

}