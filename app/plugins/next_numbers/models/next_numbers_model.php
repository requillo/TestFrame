<?php 
/**
 * 
 */
class Next_numbers_model extends Model
{
	
	function __construct()
	{
		parent::__construct();
		
	}

	function get_check_update(){
		$sql = "SELECT update_number FROM ".PRE."next_numbers_check WHERE meta = 'check_update' AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['update_number'];
	}

	function get_numbers($state = 2){
		$sql = "SELECT * FROM ".PRE."next_numbers WHERE state <= :state AND status = 1 ORDER BY id DESC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':state' => $state));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

}