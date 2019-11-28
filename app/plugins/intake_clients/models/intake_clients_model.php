<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Intake_clients_model extends Model
{
	
	function __construct()
	{
		parent::__construct();
		// $this->behavior->upload('file',['size' => 5]);
		// $this->behavior->multiple_uploads('test');
	}

	public function get_the_client($id){
		$sql = "SELECT * FROM ".PRE."intake_registered_clients WHERE id = :id AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function clients_array(){
		$sql = "SELECT id, f_name, l_name FROM ".PRE."intake_registered_clients WHERE status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$data = array();
		if(!empty($rows)) {
			foreach ($rows as $value) {
			$data[$value['id']] = $value['f_name'] . ' ' . $value['l_name'];
			}
		}
		return $data;
	}

	public function search_intake_clients_index(){
		$lim = $this->get_settings('intake_limit');
		if(isset($_GET['s']) && $_GET['s'] != '') {
			$search = $_GET['s'];
		} else {
			$search = '';
		}
		// echo $search ;
		if(isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
		$from = ($page*$lim)-$lim;
		$sql = "SELECT id FROM 
		(SELECT * FROM ".PRE."intake_registered_clients WHERE f_name LIKE ? 
		OR l_name LIKE ? ";
		$params[0] = "%$search%";
		$params[1] = "%$search%";
		$sql .= ") AS tmp_table WHERE status = 1 
		 LIMIT $from, $lim";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if(isset($_GET['s']) && $_GET['s'] != '') {
			return $rows;
		} else {
			return 1;
		}
	}

	public function tot_intakes(){
		$sql = "SELECT id FROM ".PRE."intake WHERE status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return count($rows);
	}

	public function get_intake_type_id($name) {
		$sql = "SELECT id FROM ".PRE."intake_types WHERE product_type = :product_type AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':product_type' => $name));
		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['id'];
	}

	public function get_intake_brand_id($name) {
		$sql = "SELECT id FROM ".PRE."intake_brands WHERE product_brand = :product_brand AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':product_brand' => $name));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['id'];
	}

	public function get_type_name($id){
		$sql = "SELECT product_type FROM ".PRE."intake_types WHERE id = :id AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['product_type'];

	}

	public function get_brand_name($id){
		$sql = "SELECT product_brand FROM ".PRE."intake_brands WHERE id = :id AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['product_brand'];
		
	}

	public function get_intakes($id = NULL) {
		$lim = $this->get_settings('intake_limit');
		if(isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
		$from = ($page*$lim)-$lim;
		$LIMIT = 'LIMIT '.$from.','. $lim .'';
		if($id == NULL) {
			$sql = "SELECT * FROM ".PRE."intake WHERE status = 1 ORDER BY id DESC $LIMIT";
			$arr = array();
		} else {
			$sql = "SELECT * FROM ".PRE."intake WHERE status = 1 AND client_id = :client_id ORDER BY id DESC";
			$arr = array(':client_id' => $id);
		}
		
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($arr);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($rows as $key => $value) {
			$rows[$key]['client'] = $this->get_the_client($value['client_id']);
			$rows[$key]['admin_num'] = 'RUCOM-'.$value['id'];
			$rows[$key]['type_name'] = $this->get_type_name($value['intake_type']);
			$rows[$key]['brand_name'] = $this->get_brand_name($value['intake_brand']);
		}
		return $rows;
	}

	public function get_intakes_for_invoice($id = NULL) {
		$lim = $this->get_settings('intake_limit');
		if(isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
		$from = ($page*$lim)-$lim;
		$LIMIT = 'LIMIT '.$from.','. $lim .'';
		if($id == NULL) {
			$sql = "SELECT id, intake_type, intake_brand , client_id  FROM ".PRE."intake WHERE status = 1 AND intake_add_invoice = 0 ORDER BY id DESC $LIMIT";
			$arr = array();
		} else {
			$sql = "SELECT * FROM ".PRE."intake WHERE status = 1 AND id = :id AND intake_add_invoice = 0 ORDER BY id DESC";
			$arr = array(':id' => $id);
		}
		
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($arr);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($rows as $key => $value) {
			$rows[$key]['client'] = $this->get_the_client($value['client_id']);
			$rows[$key]['admin_num'] = 'RUCOM-'.$value['id'];
			$rows[$key]['type_name'] = $this->get_type_name($value['intake_type']);
			$rows[$key]['brand_name'] = $this->get_brand_name($value['intake_brand']);
		}
		return $rows;
	}

	public function get_the_intake($id) {
		$sql = "SELECT * FROM ".PRE."intake WHERE id = :id AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!empty($row)) {
			$row['client_info'] = $this->get_the_client($row['client_id']);
			$row['admin_num'] = 'RUCOM-'.$row['id'];
			$row['type'] = $this->get_type_name($row['intake_type']);
			$row['brand'] = $this->get_brand_name($row['intake_brand']);
		}
		return $row;
	}

	public function search_intake_clients($arr){
		$q = '';
		$bind = array();
		foreach ($arr as $key => $value) {
			$q = "$key LIKE :$key";
			$bind[":$key"] = "$value%";
		}

		$sql = "SELECT id, f_name, l_name, telephone, address, email  FROM ".PRE."intake_registered_clients WHERE $q";
		// print_r($bind);
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($bind);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}
	public function search_intake_product_types($type){
		$sql = "SELECT * FROM ".PRE."intake_types WHERE product_type LIKE :product_type AND status = 1 LIMIT 5";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':product_type' => "$type%"));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function search_intake_product_brands($brand){
		$sql = "SELECT product_brand  FROM ".PRE."intake_brands WHERE product_brand LIKE :product_brand AND status = 1 LIMIT 5";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':product_brand' => "$brand%"));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}
	public function search_intake_product_models($model){
		$sql = "SELECT intake_model  FROM ".PRE."intake WHERE intake_model LIKE :intake_model LIMIT 5";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':intake_model' => "%$model%"));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}
	public function get_settings($meta){
		$sql = "SELECT value  FROM ".PRE."intake_settings WHERE meta = :meta AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':meta' => $meta));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['value'];
	}

	public function get_all_settings(){
		$sql = "SELECT id, meta, value, type  FROM ".PRE."intake_settings WHERE status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_settings_inputs(){
		$settings = $this->get_all_settings();
		$fdata = '';
		foreach ($settings as $key => $value) {
			$fdata .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
			<label for="sett-id-'.$value['id'].'">'.ucwords(str_replace('_', ' ', $value['meta'])).'</label>';
			if($value['type'] == 'number') {
				$fdata .= '<input type="number" class="form-control" name="data['.$value['meta'].']" id="sett-id-'.$value['id'].'" value="'.$value['value'].'" min="1">';
			} else if($value['type'] == 'number') {
			} else {
				$fdata .= '<textarea class="form-control" name="data['.$value['meta'].']" id="sett-id-'.$value['id'].'">'.$value['value'].'</textarea>';
			}
			$fdata .= '</div></div>';
		}
		return $fdata;
	}
	public function update_settings_inputs($key, $update){
		$sql = "UPDATE ".PRE."intake_settings SET value = :value WHERE meta = :meta AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(":value"=>$update,':meta' => $key));
		return $stmt->rowCount() ? 1 : 0;
	}
}