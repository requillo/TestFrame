<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Donations_model extends Model
{
	function get_all_persons($lim = NULL){
		if ($lim == NULL) {
			$sql = "SELECT id, first_name, last_name, person_address, person_telephone, person_email, id_number, black_listed, black_listed_reason FROM ".PRE."donation_persons WHERE status = 1";
		} else {
			if(isset($_GET['page'])) {
				$page = $_GET['page'];
			} else {
				$page = 1;
			}
			$from = ($page*$lim)-$lim;
			$LIMIT = 'LIMIT '.$from.','. $lim .'';
			$sql = "SELECT * FROM ".PRE."donation_persons WHERE status = 1 $LIMIT";
		}
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	function get_all_bl_persons($lim = NULL){
		if ($lim == NULL) {
			$sql = "SELECT id, first_name, last_name, person_address, person_telephone, person_email, id_number, black_listed, black_listed_reason FROM ".PRE."donation_persons WHERE status = 1 AND black_listed = 1 ";
		} else {
			if(isset($_GET['page'])) {
				$page = $_GET['page'];
			} else {
				$page = 1;
			}
			$from = ($page*$lim)-$lim;
			$LIMIT = 'LIMIT '.$from.','. $lim .'';
			$sql = "SELECT * FROM ".PRE."donation_persons WHERE status = 1 AND black_listed = 1 $LIMIT";
		}
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	function get_person($id){
		$sql = "SELECT * FROM ".PRE."donation_persons WHERE id = :id AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	function get_all_foundations($lim = NULL){
		if ($lim == NULL) {
			$sql = "SELECT id, foundation_name, foundation_address, foundation_telephone, foundation_email, black_listed, black_listed_reason FROM ".PRE."donation_foundation WHERE status = 1";
		} else {
			if(isset($_GET['page'])) {
				$page = $_GET['page'];
			} else {
				$page = 1;
			}
			$from = ($page*$lim)-$lim;
			$LIMIT = 'LIMIT '.$from.','. $lim .'';
			$sql = "SELECT id, foundation_name, foundation_address, foundation_telephone, foundation_email, black_listed, black_listed_reason FROM ".PRE."donation_foundation WHERE status = 1 $LIMIT";
		}
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	function get_donation_cat_data($data,$case = NULL){
		$data = substr($data,0,-1);
		$data = rtrim($data,',');
		$data = explode(',', $data);
		$tot = 0;
		$donation_types = $this->get_settings('donation_types', 'value');
		$donation_types = explode(',', $donation_types);
		foreach ($donation_types as $value) {
			$value = explode('=', $value);
			$donation_types_n[trim($value[1])] = __(trim($value[0]),'donations');
		}

		foreach ($data as $k => $value) {
			if(!empty($value) && $value != '') {
				$value = explode('-', $value);
				$amount = $value[1]*$value[2];
				$dd[$k]['description'] = $this->get_donation_assets( $value[0], 'description') . ' ' . $this->get_donation_assets( $value[0], 'unit');
				$dd[$k]['type_id'] = $this->get_donation_assets( $value[0], 'type');
				if(isset($donation_types_n[$this->get_donation_assets( $value[0], 'type')])) {
					$dd[$k]['type'] = $donation_types_n[$this->get_donation_assets( $value[0], 'type')];
				}
				$dd[$k]['amount'] = $value[1];
				$dd[$k]['price'] = $value[2];
				$dd[$k]['total_price_amount'] = $amount;
				$tot = $tot + $amount;
				if($dd[$k]['type_id'] == 2) {
					$prod = $dd[$k]['type'];
				} else if($dd[$k]['type_id'] == 3) {
					$ser = $dd[$k]['type'];
				}
			}
		}
		if(isset($prod) && isset($ser)) {
			$dd['all_types'] = $prod . ' - '. $ser;
		} else if(isset($prod)) {
			$dd['all_types'] = $prod ;
		} else if(isset($ser)) {
			$dd['all_types'] =  $ser ;
		}
		$dd['all_total'] = $tot;

		if($case == 'total') {
			return $dd['all_total'];
		} else if($case == 'types') {
			return $dd['all_types'];
		} else {
			return $dd;
		}

		

	}

	function get_all_bl_foundations($lim = NULL){
		if ($lim == NULL) {
			$sql = "SELECT * FROM ".PRE."donation_foundation WHERE status = 1 AND black_listed = 1";
		} else {
			if(isset($_GET['page'])) {
				$page = $_GET['page'];
			} else {
				$page = 1;
			}
			$from = ($page*$lim)-$lim;
			$LIMIT = 'LIMIT '.$from.','. $lim .'';
			$sql = "SELECT * FROM ".PRE."donation_foundation WHERE status = 1 AND black_listed = 1 $LIMIT";
		}
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	function get_foundation($id){
		$sql = "SELECT * FROM ".PRE."donation_foundation WHERE id = :id AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	function get_foundation_relation($id){
		$sql = "SELECT foundation_id FROM ".PRE."donation_person_foundation_relations WHERE person_id = :id AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	function get_donation_document($id){
		$sql = "SELECT document FROM ".PRE."donation_documents WHERE donation_id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['document'];
	}

	function get_foundation_relation_data($id){
		$frs = $this->get_foundation_relation($id);
		foreach ($frs as $key => $value) {
			$frs[$key]['info'] = $this->get_foundation($value['foundation_id']);
		}
		return $frs ;
	}

	function check_if_foundation_relation($ids){
		$sql = "SELECT id FROM ".PRE."donation_person_foundation_relations WHERE person_id = :id AND foundation_id = :fid AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $ids[0], ':fid' => $ids[1]));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		return $rows;
	}

	function get_donation_assets($id, $value, $st = NULL) {
		if($st != NULL) {
			$sql = "SELECT $value FROM ".PRE."donation_assets WHERE id = :id";
		} else {
			$sql = "SELECT $value FROM ".PRE."donation_assets WHERE id = :id AND status = 1";
		}
		
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row[$value];

	}

	function request_donation_data($dates,$get = NULL,$status = NULL) {
		
		$this->importmodel('users');
		$dates = explode('=', $dates);
		$date_1 = $dates[0];
		if(isset($dates[1])) {
			$date_2 = $dates[1].' 23:59:59';
		} else {
			$date_2 = '';
		}
		
		$sel = '';		

		$sel = rtrim( $sel , ", ");

		if($status == 'all' || $status == NULL) {
			$st = '';
		} else {
			$st = ' approval = ' . $status . ' AND ';
		}

		if($get == NULL || $get == 'all') {
			$sql = "SELECT * FROM ".PRE."donations WHERE $st (created BETWEEN '$date_1' AND '$date_2') AND status = 1";
		} else {
			$id = $get;
			$sql = "SELECT * FROM ".PRE."donations WHERE $st donated_company = :id AND (created BETWEEN '$date_1' AND '$date_2') AND status = 1";
		}

		

		$stmt = $this->pdo->prepare($sql);
		if(isset($id)) {
			$stmt->execute(array(':id' => $id));
		} else {
			$stmt->execute();
		}	
		
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$don_types = '';
		$desc = '';
		if(!empty($row)) {
			$i = 1;
			foreach ($row as $key => $value) {
				$desc = '';
				if($value['cash_amount'] != 0) {
					$don_types = 'Cash';
				}
				if($value['extra_description'] != ''){
					// $value['extra_description'] = substr($value['extra_description'],0,-1);
					$prod_data = $this->get_donation_cat_data($value['extra_description']);
					$t = count($prod_data);
					$t = $t - 2;
					$row[$key]['see'] = $prod_data;
					
					$i = 1;
					foreach ($prod_data as $k => $val) {
						if(isset($val['description'])) {
							if($i < $t) {
								$desc .= $val['amount'] . 'x '.$val['description'].' @ SRD'.$val['price'].' = SRD'.$val['total_price_amount'] . '<span class="hide">, </span><br>'."\r\n";
							} else if($i == $t) {
								$desc .= $val['amount'] . 'x '.$val['description'].' @ SRD'.$val['price'].' = SRD'.$val['total_price_amount'];
							}
							
							$i++;
						}
						# code...
					}
					if($don_types != '') {
						$don_types = $don_types.' - '. $prod_data['all_types'];
					} else {
						$don_types = $prod_data['all_types'];
					}
					
				}
				if($value['cash_amount'] != 0) {
					if($desc == '') {
						$desc .= $row[$key]['cash_description'] .' SRD '. $value['cash_amount'];
					} else {
						$desc .= '<span class="hide">, </span><br>'."\r\n" .$row[$key]['cash_description'] .' SRD'. $value['cash_amount'];
					}
					
				}
				$row[$key]['donated_company'] = $this->users->get_companies($value['donated_company']);
				$row[$key]['hi_approval_user'] = $this->users->get_user_data($value['hi_approval_user']);
				$row[$key]['person_id'] = $this->get_person($value['person_id']);
				$row[$key]['foundation_id'] = $this->get_foundation($value['foundation_id']);
				$row[$key]['donation_description'] = $desc;
				$row[$key]['donation_types'] = $don_types;

				$don_types = '';
			}
			
		}
		return $row;
	}

	function get_the_donation($id,$user = NULL) {
		if($user != NULL) {
			// print_r($user);
			// For every role above 7 change here top is 10 use '$user['role_level'] > 9'
			if($user['role_level'] >= 6) {
				$sql = "SELECT * FROM ".PRE."donations WHERE id = :id";
			} else {
				$compid = $user['user_company'];
				$sql = "SELECT * FROM ".PRE."donations WHERE id = :id AND status = 1 AND donated_company = $compid";
			}
		} else {
			$sql = "SELECT * FROM ".PRE."donations WHERE id = :id AND status = 1";
		}
		
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;

	}
 // 
	function get_donations($user = NULL) {
		$lim = $this->get_settings('view_max_results','value');
		if(isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
		$from = ($page*$lim)-$lim;
		$LIMIT = 'LIMIT '.$from.','. $lim .'';

		if($user != NULL && is_array($user)) {
			// print_r($user);
			// For every role above 7
			if($user['role_level'] >= 6) {
				$sql = "SELECT * FROM ".PRE."donations ORDER BY id DESC $LIMIT";
			} else {
				$compid = $user['user_company'];
				$sql = "SELECT * FROM ".PRE."donations WHERE status = 1 AND donated_company = $compid ORDER BY id DESC $LIMIT";
			}
		} else {
			$sql = "SELECT * FROM ".PRE."donations WHERE status = 1 ORDER BY id DESC $LIMIT";
		}
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	function get_all_recurring_donations() {
				$sql = "SELECT recurring_id FROM ".PRE."donations WHERE recurring = 1 AND status = 1 GROUP BY recurring_id ORDER BY id DESC";
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute();
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $rows; 		
	}

	function get_all_approval_donations() {
		$ds1 = $this->get_settings('reminder_approval','value');
		$ds1st = strtotime("-$ds1 day");
		$date1 = date('Y-m-d',$ds1st).' 23:59:59';
		$date2 = date('Y-m-d',$ds1st).' 00:00:00';
		$sql = "SELECT * FROM ".PRE."donations WHERE approval = 2 AND status = 1 AND created < '$date1'";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows; 		
	}


	function get_recurring_donations($id, $user = NULL) {

		if($user != NULL && is_array($user)) {
			// For every role above 6
			if($user['role_level'] >= 6) {
				$sql = "SELECT * FROM ".PRE."donations WHERE recurring_id = :recurring_id AND status = 1  ORDER BY id DESC";
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute(array(':recurring_id' => $id));
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $rows; 
			}

		} else {
			$sql = "SELECT * FROM ".PRE."donations WHERE recurring_id = :recurring_id AND status = 1  ORDER BY id DESC";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':recurring_id' => $id));
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $rows;
		} 
		
	}

	function get_upcomming_recurring_donations() {
		$g_days1 = $this->get_settings('reminder_upcomming_recurring_donation', 'value');
		$g_days2 = $g_days1 + 1;
		$ch_dt1 = strtotime("+$g_days1 day");
		$ch_dt2 = strtotime("+$g_days2 day");
		$dt1 = date('Y-m-d',$ch_dt1).' 00:00:00';
		$dt2 = date('Y-m-d',$ch_dt2).' 00:00:00';
		$sql = "SELECT * FROM ".PRE."donations WHERE recurring = 1 AND status = 1 AND created BETWEEN '$dt1' and '$dt2'";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows; 		
	}

	function get_donations_tot($user = NULL) {
		if($user != NULL && is_array($user)) {
			// print_r($user);
			// For every role above 7
			if($user['role_level'] >= 6) {
				$sql = "SELECT id FROM ".PRE."donations";
			} else {
				$compid = $user['user_company'];
				$sql = "SELECT id FROM ".PRE."donations WHERE status = 1 AND donated_company = $compid";
			}
		} else {
			$sql = "SELECT id FROM ".PRE."donations WHERE status = 1";
		}
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return count($rows);
	}

	function get_searched_donations($get, $user = NULL) {
		$lim = $this->get_settings('view_max_results','value');
		if(isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
		$from = ($page*$lim)-$lim;
		$LIMIT = 'LIMIT '.$from.','. $lim .'';

		

		if($user != NULL && is_array($user)) {
			// print_r($user);
			// For every role above 7
			if($user['role_level'] >= 6) {
				if(isset($_GET['in']) && $_GET['in'] == 'person') {
					$sql = "SELECT * FROM ".PRE."donations WHERE person_id IN(".$get.") AND status = 1 ORDER BY FIELD(person_id, ".$get.") $LIMIT";
				} else if(isset($_GET['in']) && $_GET['in'] == 'foundation') {
					// echo $_GET['in'];
					$sql = "SELECT * FROM ".PRE."donations WHERE foundation_id IN(".$get.") AND status = 1 ORDER BY FIELD(foundation_id, ".$get.") $LIMIT";
				} else if(isset($_GET['in']) && $_GET['in'] == 'desc') {
					$sql = "SELECT * FROM ".PRE."donations WHERE (title LIKE :title) OR (description LIKE :desc) AND status = 1 ORDER BY created DESC $LIMIT";
				}
			} else {
				$compid = $user['user_company'];
				$sql = "SELECT * FROM ".PRE."donations WHERE status = 1 AND donated_company = $compid ORDER BY id DESC $LIMIT";
			}
		} else {
			$sql = "SELECT * FROM ".PRE."donations WHERE status = 1 ORDER BY id DESC $LIMIT";
		}
		$stmt = $this->pdo->prepare($sql);
		if(isset($_GET['in']) && $_GET['in'] == 'desc') {
			$stmt->execute(array(':title' => '%'.$get.'%',':desc' => '%'.$get.'%'));
		} else {
			$stmt->execute();
		}
		
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	function get_search_donations_tot($get,$user = NULL) {
		if($user != NULL && is_array($user)) {
			// print_r($user);
			// For every role above 7
			if($user['role_level'] >= 6) {
				if(isset($_GET['in']) && $_GET['in'] == 'person') {
					$sql = "SELECT id FROM ".PRE."donations WHERE person_id IN(".$get.") AND status = 1";
				} else if(isset($_GET['in']) && $_GET['in'] == 'foundation') {
					// echo $_GET['in'];
					$sql = "SELECT id FROM ".PRE."donations WHERE foundation_id IN(".$get.") AND status = 1";
				} else if(isset($_GET['in']) && $_GET['in'] == 'desc') {
					$sql = "SELECT id FROM ".PRE."donations WHERE (title LIKE :title) OR (description LIKE :desc) AND status = 1";
				}
			} else {
				// Do this later
				$compid = $user['user_company'];
				$sql = "SELECT id FROM ".PRE."donations WHERE status = 1 AND donated_company = $compid";
			}
		} else {
			$sql = "SELECT id FROM ".PRE."donations WHERE status = 1";
		}
		$stmt = $this->pdo->prepare($sql);
		if(isset($_GET['in']) && $_GET['in'] == 'desc') {
			$stmt->execute(array(':title' => '%'.$get.'%',':desc' => '%'.$get.'%'));
		} else {
			$stmt->execute();
		}
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return count($rows);
	}

	public function get_donations_from($periods,$company = NULL) {
		$periods = explode(',', $periods);
		// echo $periods[1];
		if($company == NULL) {
			$sql = "SELECT * FROM ".PRE."donations WHERE (created < :period1 AND created > :period2) AND status = 1 AND approval = 1 ORDER BY created";
			$arr = array(':period1' => $periods[0],':period2' => $periods[1]);
		} else {
			$sql = "SELECT * FROM ".PRE."donations WHERE (created < :period1 AND created > :period2) AND status = 1 AND approval = 1 AND donated_company = :donated_company ORDER BY created";
			$arr = array(':period1' => $periods[0],':period2' => $periods[1], ':donated_company' =>$company);
		}

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($arr);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function sort_all_donations($donations){
		$i = 0;
		$res = array();
		$dates = array();
		foreach ($donations as $value) {
		 	$the_date = date('Y-m-d', strtotime($value['created']));
		 	$prod = $this->sort_prod_serv($value['extra_description'],'product');
		 	$serv = $this->sort_prod_serv($value['extra_description'],'service');
		 	if(in_array($the_date, $dates)) {
		 		$key = array_search($the_date, $dates);
		 		$res['all'][$key]['amount'] = $res['all'][$key]['amount'] + $value['amount'];
		 		$res['prod'][$key]['amount'] = $res['prod'][$key]['amount'] + $prod;
		 		$res['service'][$key]['amount'] = $res['service'][$key]['amount'] + $serv;
		 		$res['cash'][$key]['amount'] = $res['cash'][$key]['amount'] + $value['cash_amount'];
		 	} else {
		 		$dates[$i] = $the_date;
		 		$res['all'][$i]['amount'] = $value['amount'];
		 		$res['all'][$i]['date'] = $the_date;
		 		$res['prod'][$i]['amount'] = $prod;
		 		$res['prod'][$i]['date'] = $the_date;
		 		$res['service'][$i]['amount'] = $serv;
		 		$res['service'][$i]['date'] = $the_date;
		 		$res['cash'][$i]['amount'] = $value['cash_amount'];
		 		$res['cash'][$i]['date'] = $the_date;
		 		$i++;
		 	}
		}
		return $res;
	}

	public function check_company_assets($itemcode,$company,$type){
		$sql = "SELECT id FROM ".PRE."donation_assets WHERE item_number = :item_number AND company_id = :company_id AND type = :type AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':item_number' => $itemcode, ':company_id' => $company, ':type' => $type));
		$rows = $stmt->fetch();
		return $rows['id'];

	}

	public function disable_company_assets($id){
		$sql = "UPDATE ".PRE."donation_assets SET status = 0 WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
	}

	public function echarts_data($data){
		$res = array();
		$res['dates'] = '';
		$res['all'] = '';
		$res['product'] = '';
		$res['service'] = '';
		$res['cash'] = '';
		if(isset($data['all'])) {
			foreach ($data['all'] as $value) {
			$res['dates'] .= "'".date('d M',strtotime($value['date'])) . "',";
			$res['all'] .= $value['amount'] . ",";
			}
		}

		if(isset($data['prod'])) {
			foreach ($data['prod'] as $value) {
			$res['product'] .= $value['amount'] . ",";
			}
		}
		
		
		if(isset($data['service'])) {
			foreach ($data['service'] as $value) {
			$res['service'] .= $value['amount'] . ",";
			}
		}

		
		if(isset($data['cash'])) {
			foreach ($data['cash'] as $value) {
			$res['cash'] .= $value['amount'] . ",";
			}
		}

		$res['dates'] = rtrim($res['dates'],',');
		$res['all'] = rtrim($res['all'],',');
		$res['product'] = rtrim($res['product'],',');
		$res['service'] = rtrim($res['service'],',');
		$res['cash'] = rtrim($res['cash'],',');
		return $res;
	}

	public function all_donations_totals($donations){
	
		$totals = array();
		$prt = 0;
		$prp = 0;
		$prs = 0;
		$prc = 0;
		$ch = '';
		$ch_p = '';
		$ch_s = '';
		$ch_c = '';
		$db = array();
		 foreach ($donations as $value) {
		 	$prt = $prt + $value['amount'];
		 	$ch .= $value['amount'] . ' - ';
		 	if($value['cash_amount'] > 0) {
		 		$prc = $prc + $value['cash_amount'];
		 	}
		 	$ch_c .=  $value['cash_amount'].' - ';
		 	if(!empty($value['extra_description'])) {
		 		$prod = $this->sort_prod_serv($value['extra_description'],'product');
		 		$serv = $this->sort_prod_serv($value['extra_description'],'service');
		 		$prp = $prp + $prod;
		 		$prs = $prs + $serv;
		 		$ch_p .= $prod .' - ';
				$ch_s .= $serv .' - ';
		 	}
		 }
		 if($prt == 0) {
		 	$prt = 1;
		 	$totals['all']['amount'] = 0;
		 } else {
		 	$totals['all']['amount'] = $prt;
		 }
		 $totals['check'] = $ch;
		 $totals['check-prod'] = $ch_p;
		 $totals['check-serv'] = $ch_s;
		 $totals['check-cash'] = $ch_c;
		 $totals['all']['perc'] = '100';
		 $totals['cash']['amount'] = $prc;
		 $totals['cash']['perc'] = round(($prc/$prt)*100);
		 $totals['prod']['amount'] = $prp;
		 $totals['prod']['perc'] = round(($prp/$prt)*100);
		 $totals['service']['amount'] = $prs;
		 $totals['service']['perc'] = round(($prs/$prt)*100);
		 return $totals;
	}

	public function sort_prod_serv($xdesc, $type = NULL){
		$donation_types_n[2] = "Product";
		$donation_types_n[3] = "Service";
		$xdescar = array();
		$xdesc = explode(',', rtrim($xdesc,','));
		$i = 0;
		$price = 0;
		$don_desc_data = array();
			foreach ($xdesc as $value) {
			$value = explode('-', $value);
				$t = $this->get_donation_assets($value[0],'type');				
				if(strtolower($type) == "product") {
					if($t == 2) {
						$totp = $value[1] * $value[2];
						$price = $price + $totp;
					}
				} else {
					if($t == 3) {
						$totp = $value[1] * $value[2];
						$price = $price + $totp;
					}

				}
			$i++;
			}
		return $price;
	}

	public function searched_donation_persons($get){
		$sql = "SELECT id FROM ".PRE."donation_persons WHERE full_name LIKE :get AND status = 1 ORDER BY first_name";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':get' => '%'.$get.'%'));
		$rows = $stmt->fetchAll();
		return $rows;
	}

	public function searched_donation_foundations($get){
		$sql = "SELECT id FROM ".PRE."donation_foundation WHERE foundation_name LIKE :get AND status = 1 ORDER BY foundation_name";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':get' => '%'.$get.'%'));
		$rows = $stmt->fetchAll();
		return $rows;
	}

	public function update_settings_inputs($key, $update){
		$sql = "UPDATE ".PRE."donation_settings SET value = :value WHERE meta = :meta AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(":value"=>$update,':meta' => $key));
		return $stmt->rowCount() ? 1 : 0;
	}

	public function get_all_settings(){
		$sql = "SELECT id, meta, value, description, type  FROM ".PRE."donation_settings WHERE status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_settings($meta, $value){
		$sql = "SELECT $value  FROM ".PRE."donation_settings WHERE meta = :meta AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':meta' => $meta));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row[$value];
	}

	public function get_settings_inputs(){
		$settings = $this->get_all_settings();
		$fdata = '';
		foreach ($settings as $key => $value) {
			$fdata .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
			<label for="sett-id-'.$value['id'].'">'.__(ucwords(str_replace('_', ' ', $value['meta'])),'donations').'</label><br>';
			$fdata .= '<small>'.__($value['description'],'donations').'</small>';
			if($value['type'] == 'number') {
				$fdata .= '<input type="number" class="form-control" name="data['.$value['meta'].']" id="sett-id-'.$value['id'].'" value="'.$value['value'].'" min="1">';
			} else if($value['type'] == 'textarea') {
				$fdata .= '<textarea class="form-control" name="data['.$value['meta'].']" id="sett-id-'.$value['id'].'">'.$value['value'].'</textarea>';
			} else {
				$fdata .= '<input type="'.$value['type'].'" class="form-control" name="data['.$value['meta'].']" id="sett-id-'.$value['id'].'" value="'.$value['value'].'" min="1">';				
			}
			$fdata .= '</div></div>';
		}
		return $fdata;
	}

	public function get_companies_options($id = NULL){
		$this->importmodel('users');
		$comp = $this->users->get_companies();
		$res = '';
		foreach ($comp as $value) {
			if($id == $value['id']) {
				$sel = ' selected';
			} else {
				$sel = '';
			}
			$res .= '<option value="'.$value['id'].'" '.$sel.'>'.$value['company_name'].'</option>';
		}
		return $res;
	}

	public function get_all_donation_types(){
		$sql = "SELECT value FROM ".PRE."donation_settings WHERE meta = 'donation_types' AND status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$data = rtrim($row['value'],',');
		$data = ltrim($data,',');
		$data = explode(',', $data);
		$res = array();
		foreach ($data as $value) {
			$v = explode('=', $value);
			$res[$v[1]] = $v[0];
		}
		return $res;
	}
	public function get_hi_approval_accounts(){
		$s_approval_accounts = $this->get_settings('approval_email_account', 'value');
		$s_approval_accounts = preg_replace('/\s+/', '', $s_approval_accounts);
		$s_approval_accounts = explode(';', $s_approval_accounts);
		$approval_account = array();
		$this->importmodel('users');
		$s_i = 0;
		foreach ($s_approval_accounts as $value) {
			$hi_user_acc = $this->users->get_user_data_from_email($value);
			if(!empty($hi_user_acc)) {
				$approval_account[$s_i]['account'] = $hi_user_acc;
				$s_i++;
			}	
		}
		return $approval_account;
	}
	public function get_related_accounts_company_id($user_company){
		$sql = "SELECT user_id FROM ".PRE."user_relations WHERE user_company = :user_company";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':user_company' => $user_company));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}
	public function donation_related_mailing_accounts($comp_id){
		$hi_approval_accounts = $this->get_hi_approval_accounts();
		$acc = array();
		$i = 0 ;
		foreach ($hi_approval_accounts as $value) {
			$acc[$i] = $value['account']['id'];
			$i++;
		}
		$otherids = $this->get_related_accounts_company_id($comp_id);
		$accs = array();
		$i = 0 ;
		foreach ($otherids as $value) {
			$accs[$i] = $value['user_id'];
			$i++;
		}
		$array = array_merge($acc, array_diff($accs, $acc));
		$this->importmodel('users');
		$res = array();
		$i = 0;
		foreach ($array as $value) {
			$res[$i] = $this->users->get_user_data($value);
			$i++;
		}
		return $res;
	}

	public function get_company_assets($id){
		$sql = "SELECT id, type, description, price, item_number, unit FROM ".PRE."donation_assets WHERE company_id = :company_id AND status = 1 ORDER BY id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':company_id' => $id));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}
	// check the donations from settings
	public function check_donations_within_years($ids){
		if($ids[1] == 0){
			// Never look for foundation hack
			$ids[1] = 9999999999999999999999999999;
		}
		$sy = $this->get_settings('year_start', 'value');
		$wy = $this->get_settings('within_years', 'value');
		// Check start year
		// Year starts at januari first
		if($sy == 1) {

			if($wy == 1) {
				$yeardate = date('Y').'-01-01';

			} else {
				$wy--;
				$yeardate = date('Y', strtotime('-'.$wy.' year')).'-01-01';
			}
		// Year starts current date one year ago
		} else {
			$yeardate = date('Y-m-d', strtotime('-'.$wy.' year'));
		}
		// echo $yeardate;
		$sql = "SELECT id, person_id, foundation_id, title, description, amount, max_amount, approval, donated_company, created, created_user  FROM ".PRE."donations 
		WHERE (person_id = :person_id AND approval > 0 AND created >= '$yeardate' AND status = 1) 
		OR(foundation_id = :foundation_id AND approval > 0 AND created >= '$yeardate' AND status = 1) ORDER BY id DESC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':person_id' => $ids[0], ':foundation_id' => $ids[1]));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($rows as $key => $value) {
			$rows[$key]['created_timestamp'] = strtotime($value['created']);
		}
		// $rows['test'] = strtotime('2018-03-12');
		return $rows;
	}

	public function check_donations_within_years_approved($ids){
		if($ids[1] == 0){
			// Never look for foundation hack
			$ids[1] = 9999999999999999999999999999;
		}
		$sy = $this->get_settings('year_start', 'value');
		$wy = $this->get_settings('within_years', 'value');
		// Check start year
		// Year starts at januari first
		if($sy == 1) {

			if($wy == 1) {
				$yeardate = date('Y').'-01-01';

			} else {
				$wy--;
				$yeardate = date('Y', strtotime('-'.$wy.' year')).'-01-01';
			}
		// Year starts current date one year ago
		} else {
			$yeardate = date('Y-m-d', strtotime('-'.$wy.' year'));
		}
		// echo $yeardate;
		$sql = "SELECT id, person_id, foundation_id, title, description, amount, max_amount, approval, donated_company, created, created_user  FROM ".PRE."donations 
		WHERE (person_id = :person_id AND approval = 1 AND created >= '$yeardate' AND status = 1) 
		OR(foundation_id = :foundation_id AND approval = 1 AND created >= '$yeardate' AND status = 1) ORDER BY id DESC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':person_id' => $ids[0], ':foundation_id' => $ids[1]));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($rows as $key => $value) {
			$rows[$key]['created_timestamp'] = strtotime($value['created']);
		}
		// $rows['test'] = strtotime('2018-03-12');
		return $rows;
	}

	public function check_donations_within_years_pending($ids){
		if($ids[1] == 0){
			// Never look for foundation hack
			$ids[1] = 9999999999999999999999999999;
		}
		$sy = $this->get_settings('year_start', 'value');
		$wy = $this->get_settings('within_years', 'value');
		// Check start year
		// Year starts at januari first
		if($sy == 1) {

			if($wy == 1) {
				$yeardate = date('Y').'-01-01';

			} else {
				$wy--;
				$yeardate = date('Y', strtotime('-'.$wy.' year')).'-01-01';
			}
		// Year starts current date one year ago
		} else {
			$yeardate = date('Y-m-d', strtotime('-'.$wy.' year'));
		}
		// echo $yeardate;
		$sql = "SELECT id, person_id, foundation_id, title, description, amount, max_amount, approval, donated_company, created, created_user  FROM ".PRE."donations 
		WHERE (person_id = :person_id AND approval = 2 AND created >= '$yeardate' AND status = 1) 
		OR(foundation_id = :foundation_id AND approval = 2 AND created >= '$yeardate' AND status = 1) ORDER BY id DESC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':person_id' => $ids[0], ':foundation_id' => $ids[1]));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($rows as $key => $value) {
			$rows[$key]['created_timestamp'] = strtotime($value['created']);
		}
		// $rows['test'] = strtotime('2018-03-12');
		return $rows;
	}

	public function check_donations_within_months($donations){
		$don = array();
		$i = 0;
		$wm = $this->get_settings('within_months', 'value');
		$swm =  date('Y-m-d', strtotime('-'.$wm.' month'));
		$swm = strtotime($swm);
		foreach ($donations as $value) {
			if($value['created_timestamp'] > $swm) {
				$don[$i] =  $value;
				$i++;
			}
			
		}
		return $don;
	}

	public function check_id($slug){
		$sql = "SELECT id_number FROM ".PRE."donation_persons WHERE id_number = :id_number";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id_number' => $slug));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(empty($row)) {
			return true;
		} else {
			return false;
		}
	}

	public function the_person_id($slug, $original = NULL){
		$check = $this->check_id($slug);
		
		if($original != NULL && $slug == $original) {
			$res = $slug;
		} else if($check == true) {
			$res = $slug;
		} else {
			if(strpos($slug, 'blacklisted-') !== false) {
				$slgarr = explode('-', $slug);
				$cn = end($slgarr);
				$cnn = (int)$cn+1;
				$search = '-'.$cn;
				$replace = '-'.$cnn;
				$slug = str_replace($search, $replace, $slug);
				$res = $this->the_person_id($slug);
			} else {
				$slug = $slug .'-1';
				$res = $this->the_person_id($slug);
			}
		}
		return $res;
	}

}