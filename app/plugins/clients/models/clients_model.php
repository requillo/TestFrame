<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Clients_model extends Model
{
	
	function __construct()
	{
		parent::__construct();
		// $this->behavior->upload('file',['size' => 5]);
		// $this->behavior->multiple_uploads('test');
	}

	public function get_all_clients($args = NULL){
		$lim = $this->get_setting('clients_per_page','value');
		if(isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
		$from = ($page*$lim)-$lim;
		if(isset($args['limit'])) {
			if($args['limit'] == 'all') {
				$LIMIT = '';
			} else {
				$LIMIT = 'LIMIT '.$from.','. $args['limit'] .'';
			}
			
		} else {
			$LIMIT = 'LIMIT '.$from.','. $lim .'';
		}
		if(isset($args['key']) && isset($args['value'])) {
			$where = "AND ". $args['key'] ." = '".$args['value'] . "' ";
		} else {
			$where = '';
		}
		$sql = "SELECT id, f_name, l_name, email, telephone, address, company 
				FROM ".PRE."clients WHERE active = 1 $where
				ORDER BY l_name ".$LIMIT;
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function tot_clients($args = NULL){
		if(isset($args['key']) && isset($args['value'])) {
			$where = 'WHERE '. $args['key'] ." = '".$args['value'] . "' ";
		} else {
			$where = '';
		}
		$sql = "SELECT id FROM ".PRE."clients $where";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return count($row);
	}

	public function get_client($id){
		$sql = "SELECT * FROM ".PRE."clients WHERE id = :id AND active = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_clients_visas($id){
		$sql = "SELECT * FROM ".PRE."clients_visas WHERE client_id = :id AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}
	public function get_clients_tickets($id){
		$sql = "SELECT * FROM ".PRE."clients_tickets WHERE client_id = :id AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_ticket($id){
		$sql = "SELECT * FROM ".PRE."clients_tickets WHERE id = :id AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	public function get_clients_membership($id){
		$sql = "SELECT * FROM ".PRE."clients_memberships WHERE client_id = :id AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}
	public function get_membership($id){
		$sql = "SELECT * FROM ".PRE."clients_memberships WHERE id = :id AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	public function get_setting($name,$return) {
		$sql = "SELECT $return FROM ".PRE."clients_settings WHERE name = :name";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':name' => $name));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row[$return];
	}

	public function update_setting($name,$val){
		$sql = "UPDATE ".PRE."clients_settings SET value = :val WHERE name = :name";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':name' => $name, ':val' => $val));
		return $stmt->rowCount() ? 1 : '';
	}

	public function get_all_settings($add = NULL, $status = 'delete'){
		if($add == NULL) {
			$add = '';
		}
		$sql = "SELECT * FROM ".PRE."clients_settings WHERE setting = :setting AND status != :status";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':setting' => $add, ':status' => $status));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_expired_visas($case = NULL){
		$dateset = $this->get_setting('visa_expire_reminder','value');
		if($case == 'limit'){
			$limit = 'LIMIT '. $this->get_setting('limit_expire_visas_dashboard','value');
		} else {
			$limit = '';
		}
		$curdate = date('Y-m-d');
		$expdate = date('Y-m-d',strtotime("+$dateset days",strtotime($curdate)));
		$sql = "SELECT * FROM ".PRE."clients_visas WHERE end_date < :end_date AND reminder = 0 AND status = 1 ORDER BY end_date $limit";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':end_date' => $expdate));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function count_expired_visas(){
		$dateset = $this->get_setting('visa_expire_reminder','value');
		$curdate = date('Y-m-d');
		$expdate = date('Y-m-d',strtotime("+$dateset days",strtotime($curdate)));
		$sql = "SELECT id FROM ".PRE."clients_visas WHERE end_date < :end_date AND reminder = 0 AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':end_date' => $expdate));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return count($row);
	}

	public function get_expired_passports($case = NULL){
		$dateset = $this->get_setting('passport_expire_reminder','value');
		if($case == 'limit'){
			$limit = 'LIMIT '. $this->get_setting('limit_expire_passports_dashboard','value');
		} else {
			$limit = '';
		}
		$curdate = date('Y-m-d');
		$expdate = date('Y-m-d',strtotime("+$dateset days",strtotime($curdate)));
		$sql = "SELECT * FROM ".PRE."clients_passports WHERE end_date < :end_date AND reminder = 0 AND status = 1 ORDER BY end_date $limit";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':end_date' => $expdate));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function count_expired_passports(){
		$dateset = $this->get_setting('passport_expire_reminder','value');
		$curdate = date('Y-m-d');
		$expdate = date('Y-m-d',strtotime("+$dateset days",strtotime($curdate)));
		$sql = "SELECT id FROM ".PRE."clients_passports WHERE end_date < :end_date AND reminder = 0 AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':end_date' => $expdate));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return count($row);
	}

	public function get_client_passport($id) {
		$status = 1;
		$sql = "SELECT * FROM ".PRE."clients_passports WHERE client_id = :client_id AND status = :status";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':client_id' => $id, ':status' => $status));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_client_insurance($id) {
		$status = 1;
		$sql = "SELECT * FROM ".PRE."clients_insurance WHERE client_id = :client_id AND status = :status";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':client_id' => $id, ':status' => $status));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_insurance($id) {
		$status = 1;
		$sql = "SELECT * FROM ".PRE."clients_insurance WHERE id = :id AND status = :status";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id, ':status' => $status));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_passport($id) {
		$status = 1;
		$sql = "SELECT * FROM ".PRE."clients_passports WHERE id = :id AND status = :status";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id, ':status' => $status));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_setting_field($id){
		$status = 'delete';
		$sql = "SELECT * FROM ".PRE."clients_settings WHERE setting = :setting AND status != :status";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':setting' => $add, ':status' => $status));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;

	}

	public function get_the_client_meta($setting_id){
		$sql = "SELECT * FROM ".PRE."clients_meta WHERE setting_id = :setting_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':setting_id' => $setting_id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function check_client_meta($setting_id, $client_id){
		$sql = "SELECT * FROM ".PRE."clients_meta WHERE setting_id = :setting_id AND client_id = :client_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':setting_id' => $setting_id, ':client_id' => $client_id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_visa($id){
		$sql = "SELECT * FROM ".PRE."clients_visas WHERE id = :id AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function search_clients(){
		$lim = $this->get_setting('clients_per_page','value');
		if(isset($_GET['s'])) {
			$search = $_GET['s'];
		} else {
			$search = '';
		}
		$words = explode(' ', $search);
		if(isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
		if(isset($_GET['orderby'])) {
			$orderby = $_GET['orderby'];
		} else {
			$orderby = 'f_name';
		}
		$from = ($page*$lim)-$lim;
		$sql = "SELECT id, f_name, l_name, email, telephone, address, company FROM 
		(SELECT id, f_name, l_name, email, telephone, address, company, active FROM ".PRE."clients WHERE id_number LIKE ? 
		OR f_name LIKE ?
		OR l_name LIKE ? 
		OR company LIKE ? ";
		$params[0] = "%$search%";
		$params[1] = "%$search%";
		$params[2] = "%$search%";
		$params[3] = "%$search%";
		$p = 4;
		if(count($words) > 1) {
			foreach($words as $word){
			$sql .= "OR f_name LIKE ? OR l_name LIKE ?";
			$params[$p] = "%$word%";
			$p++;
			$params[$p] = "%$word%";
			$p++;
			}
		}
		$sql .= ") AS tmp_table WHERE active = 1 
		ORDER BY $orderby ASC LIMIT $from, $lim";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}
	public function search_tot(){
		if(isset($_GET['s'])) {
			$search = $_GET['s'];
		} else {
			$search = '';
		}
		$words = explode(' ', $search);
		$sql = "SELECT id FROM 
		(SELECT id, active FROM ".PRE."clients WHERE id_number LIKE ? 
		OR f_name LIKE ?
		OR l_name LIKE ? 
		OR company LIKE ? ";
		$params[0] = "%$search%";
		$params[1] = "%$search%";
		$params[2] = "%$search%";
		$params[3] = "%$search%";
		$p = 4;
		if(count($words) > 1) {
			foreach($words as $word){
			$sql .= "OR f_name LIKE ? OR l_name LIKE ?";
			$params[$p] = "%$word%";
			$p++;
			$params[$p] = "%$word%";
			$p++;
			}
		}
		$sql .= ") AS tmp_table WHERE active = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return count($rows);
	}

	function get_all_companies($company){
		$sql = "SELECT company FROM ".PRE."clients WHERE company LIKE :company GROUP BY company LIMIT 10";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':company' => "%$company%"));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function trash_client_passport($client_id){
		$sql = "UPDATE ".PRE."clients_passports SET status = 2 WHERE client_id = :client_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':client_id' => $client_id));
		return $stmt->rowCount() ? 1 : '';
	}

	public function trash_client_visa($client_id){
		$sql = "UPDATE ".PRE."clients_visas SET status = 2 WHERE client_id = :client_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':client_id' => $client_id));
		return $stmt->rowCount() ? 1 : '';
	}
	public function trash_client_ticket($client_id){
		$sql = "UPDATE ".PRE."clients_tickets SET status = 2 WHERE client_id = :client_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':client_id' => $client_id));
		return $stmt->rowCount() ? 1 : '';
	}
	public function trash_client_membership($client_id){
		$sql = "UPDATE ".PRE."clients_memberships SET status = 2 WHERE client_id = :client_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':client_id' => $client_id));
		return $stmt->rowCount() ? 1 : '';
	}
	public function trash_client_insurance($client_id){
		$sql = "UPDATE ".PRE."clients_insurance SET status = 2 WHERE client_id = :client_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':client_id' => $client_id));
		return $stmt->rowCount() ? 1 : '';
	}

}