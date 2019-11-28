<?php 

class Fuel_inventory_model extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->app_colors = array('#2ed808','#08cdd8','#5b08d8','#c308d8','#d8a408','#d6ff44','#44e6ff','#4980ff','#ff49d7','#bcb008');
		$this->app_colors_max = 10;
		$low_threshold = $this->settings('low-threshold');
		$lowlow_threshold = $this->settings('lowlow-threshold');
		$high_threshold = $this->settings('high-threshold');
		$title_color = $this->settings('title-color');
		$low_color = $this->settings('low-threshold-color');
		$lowlow_color = $this->settings('lowlow-threshold-color');
		$high_color = $this->settings('high-threshold-color');
		$normal_color = $this->settings('normal-fuel-color');
		$water_color = $this->settings('water-color');
		$ullage_color = $this->settings('ullage-color');
		if(!empty($low_threshold)) {
			$this->low_threshold = $low_threshold['value'];
		} else {
			$this->low_threshold = 30;
		}
		if(!empty($lowlow_threshold)) {
			$this->lowlow_threshold = $lowlow_threshold['value'];
		} else {
			$this->lowlow_threshold = 10;
		}
		if(!empty($high_threshold)) {
			$this->high_threshold = $high_threshold['value'];
		} else {
			$this->high_threshold = 80;
		}
		if(!empty($title_color)) {
			$this->title_color = $title_color['value'];
		} else {
			$this->title_color = '#666666';
		}
		if(!empty($low_color)) {
			$this->low_color = $low_color['value'];
		} else {
			$this->low_color = '#d25e00';
		}
		if(!empty($lowlow_color)) {
			$this->lowlow_color = $lowlow_color['value'];
		} else {
			$this->lowlow_color = '#a90000';
		}
		if(!empty($high_color)) {
			$this->high_color = $high_color['value'];
		} else {
			$this->high_color = '#0060ff';
		}
		if(!empty($normal_color)) {
			$this->normal_color = $normal_color['value'];
		} else {
			$this->normal_color = '#079100';
		}
		if(!empty($water_color)) {
			$this->water_color = $water_color['value'];
		} else {
			$this->water_color = '#000000';
		}
		if(!empty($ullage_color)) {
			$this->ullage_color = $ullage_color['value'];
		} else {
			$this->ullage_color = '#626262';
		}
	}
	public function settings($meta) {
		$sql = "SELECT * FROM ".PRE."fuel_settings WHERE status = 1 AND meta = :meta";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':meta' => $meta));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function update_settings($id, $value) {
		$sql = "UPDATE ".PRE."fuel_settings SET value = :value  WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':value' => $value, ':id' => $id));
		return $stmt->rowCount() ? 1 : '';
	}

	public function get_meta($meta = NULL) {
		$meta = '%'.$meta;
		$sql = "SELECT * FROM ".PRE."fuel_settings WHERE status = 1 AND meta LIKE :meta ORDER BY re_order";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':meta' => $meta));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function product_colors(){
		$products = $this->get_all_products();
		$pc = array();
		$i = 0;
		foreach ($products as $key => $value) {
			$pc[$key]['meta'] = strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/','', $value['product_alias']));
			$pc[$key]['meta'] = str_replace('color', '', $pc[$key]['meta']);
			$check = $this->settings($pc[$key]['meta']);
			if(!empty($check)){
				$pc[$key]['value'] = $check['value'];
				$pc[$key]['id'] = $check['id'];
			} else {
				$pc[$key]['value'] = $this->app_colors[$i];
				$pc[$key]['id'] = 0;
			}
			$i++;
			if($i == $this->app_colors_max) {
				$i = 0;
			}
			$pc[$key]['re_order'] = $value['product_id'];
			$pc[$key]['description'] = trim(str_replace(array("'","\""),'',$value['product']));
			$pc[$key]['input_type'] = 'color';
		}
		return $pc;
	}

	public function get_product_colors(){
		$colors = $this->product_colors();
		$cl = array();
		foreach ($colors as $value) {
			$cl[$value['meta']] = $value['value'];
		}
		return $cl;
	}

	public function get_all_sites($cols = 'all'){
		$cols = strtolower($cols);
		if($cols == 'all') {
			$cols = '*';
		}

		$sql = "SELECT $cols FROM ".PRE."fuel_sites WHERE status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_all_user_sites_relations(){
		$sql = "SELECT id, site_id, user_id FROM ".PRE."fuel_sites_user_relation WHERE status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_user_sites_relations($id){
		$sql = "SELECT id, site_id, user_id FROM ".PRE."fuel_sites_user_relation WHERE status = 1 AND user_id = :user_id ";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':user_id' => $id));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_all_tanks($cols = 'all'){
		$cols = strtolower($cols);
		if($cols == 'all') {
			$cols = '*';
		}

		$sql = "SELECT $cols FROM ".PRE."fuel_tanks WHERE status = 1 ORDER BY tank_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}
	public function get_tank($id){
		$sql = "SELECT * FROM ".PRE."fuel_tanks WHERE status = 1 AND tank_id = :tank_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':tank_id' => $id));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_all_products($cols = 'all'){
		$cols = strtolower($cols);
		if($cols == 'all') {
			$cols = '*';
		}
		$sql = "SELECT * FROM ".PRE."fuel_products WHERE status = 1 ORDER BY product_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_product($id){
		$sql = "SELECT * FROM ".PRE."fuel_products WHERE status = 1 AND product_id = :product_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':product_id' => $id));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_all_sites_options($options = NULL){
		if($options  == NULL) {
			$options = $this->get_all_sites();
		}
		$res = array();
		foreach ($options as $value) {
			$res[$value['site_id']] = $value['dealer'];
		}
		return $res;
	}

	public function get_all_tanks_options($options = NULL){
		if($options  == NULL) {
			$options = $this->get_all_tanks();
		}
		$res = array();
		foreach ($options as $value) {
			$res[$value['tank_id']] = $value['tank'];
		}
		return $res;
	}

	public function get_all_products_options($options = NULL){
		if($options  == NULL) {
			$options = $this->get_all_products();
		}
		$res = array();
		foreach ($options as $value) {
			$res[$value['product_id']] = $value['product'];
		}
		return $res;
	}

	public function get_site_data($id) {
		$sql = "SELECT id, site_id, dealer, address, district, phone, email, featured_image  FROM ".PRE."fuel_sites WHERE status = 1 AND site_id = :site_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':site_id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_site_tanks_relations($id) {
		$sql = "SELECT id, site_id, tank_id, product_id FROM ".PRE."fuel_site_tank_product WHERE status = 1 AND site_id = :site_id ORDER BY tank_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':site_id' => $id));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}
	public function get_all_site_tanks_relations($site) {
		$sql = "SELECT id, site_id, tank_id, product_id FROM ".PRE."fuel_site_tank_product WHERE status = 1 AND site_id = :site_id ORDER BY tank_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':site_id' => $site));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function last_fuel_data($id){
		$sql = "SELECT site_date, site_time FROM ".PRE."fuel_inventory WHERE site_id = :site_id ORDER BY site_date DESC, site_time DESC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':site_id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_fuel_data_tanks_all($id,$date1,$date2,$ti){
		$aa = $this->get_fuel_data_tanks_all_helper($id,$date1,$date2,$ti);
		$s = '';
		foreach ($aa as $value) {
			$s .= $value['MAX(id)'].',';
		}
		$s = rtrim($s,',');
		$sql = "SELECT * FROM ".PRE."fuel_inventory WHERE id IN ( $s ) ORDER BY site_date ASC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_fuel_data_tanks_all_helper($id,$date1,$date2,$ti){
		$sql = "SELECT MAX(id) FROM ".PRE."fuel_inventory WHERE site_id = :site_id AND tank_number = :tank_number AND site_date BETWEEN :date1 AND :date2 GROUP BY site_date";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':site_id' => $id, ':tank_number' => $ti, ':date1' => $date1, ':date2' => $date2));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_markers_from_site($id){
		$sql = "SELECT id, station_data FROM ".PRE."map_markers WHERE site_id = :site_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':site_id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_site_id_from_id($id){
		$sql = "SELECT site_id FROM ".PRE."fuel_sites WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_fuel_data_tanks($id,$date1,$date2,$ti){
		$aa = $this->get_fuel_data_tanks_helper($id,$date1,$date2,$ti);
		$s = $aa['MAX(id)'];
		$sql = "SELECT * FROM ".PRE."fuel_inventory WHERE id IN( $s )";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':site_id' => $id, ':tank_number' => $ti));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_fuel_data_tanks_helper($id,$date1,$date2,$ti){
		$sql = "SELECT MAX(id) FROM ".PRE."fuel_inventory WHERE site_id = :site_id AND tank_number = :tank_number AND site_date BETWEEN :date1 AND :date2 GROUP BY site_date";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':site_id' => $id, ':tank_number' => $ti, ':date1' => $date1, ':date2' => $date2));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_fuel_data_tanks_widget($id,$date,$ti){
		$sql = "SELECT id, tank_volume, tank_tc_volume, tank_ullage, tank_water, tank_water_volume, site_date, site_time FROM ".PRE."fuel_inventory WHERE site_id = :site_id AND tank_number = :tank_number AND site_date = :date ORDER BY id DESC LIMIT 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':site_id' => $id, ':tank_number' => $ti, ':date' => $date));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_fuel_data_day($id,$date1,$date2,$ti){
		$sql = "SELECT * FROM ".PRE."fuel_inventory WHERE site_id = :site_id AND tank_number = :tank_number AND site_date BETWEEN :date1 AND :date2 ORDER BY site_time";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':site_id' => $id, ':tank_number' => $ti, ':date1' => $date1, ':date2' => $date2));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}
}