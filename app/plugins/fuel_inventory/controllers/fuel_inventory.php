<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
/**
* 
*/
class Fuel_inventory extends Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->app_colors = $this->fuel_inventory->app_colors;
		$this->lowlow_threshold = $this->fuel_inventory->lowlow_threshold;
		$this->low_threshold = $this->fuel_inventory->low_threshold;
		$this->high_threshold = $this->fuel_inventory->high_threshold;
		$this->lowlow_color = $this->fuel_inventory->lowlow_color;
		$this->low_color = $this->fuel_inventory->low_color;
		$this->high_color = $this->fuel_inventory->high_color;
		$this->normal_color = $this->fuel_inventory->normal_color;
		$this->title_color = $this->fuel_inventory->title_color;
		$this->water_color = $this->fuel_inventory->water_color;
		$this->ullage_color = $this->fuel_inventory->ullage_color;
		$this->set("lowlow_threshold", $this->lowlow_threshold);
		$this->set("low_threshold", $this->low_threshold);
		$this->set("high_threshold", $this->high_threshold);
		$this->set("lowlow_color", $this->lowlow_color);
		$this->set("low_color", $this->low_color);
		$this->set("high_color", $this->high_color);
		$this->set("normal_color", $this->normal_color);
		$this->set("title_color", $this->title_color);
		$this->set("water_color", $this->water_color);
		$this->set("ullage_color", $this->ullage_color);
		$this->set("app_colors", $this->app_colors);
		$rel_site = $this->fuel_inventory->get_user_sites_relations($this->user['id']);
		if(!empty($rel_site)){
			if($rel_site['site_id'] != 0) {
				$this->user['gas_station'] = $rel_site['site_id'];
			}	
		}
	}

	public function admin_link_users(){

		$this->title = __('Link users to Stations','fuel_inventory');
		$this->loadmodel('users');
		$Users = $this->users->get_all_users($this->user['role_level']);		
		$sites = $this->fuel_inventory->get_all_sites('site_id, dealer');
		$sites_user_relation = $this->fuel_inventory->get_all_user_sites_relations();
		$user_relation = array();
		if(!empty($sites_user_relation)) {
			foreach ($sites_user_relation as $value) {
				$user_relation[$value['user_id']] = $value['site_id'];
			}
		}
		$site_arr = array();
		foreach ($sites as $value) {
			$site_arr[$value['site_id']] = $value['dealer'];
		}
		foreach ($Users as $key => $value) {
			if(isset($user_relation[$value['id']]) && isset($site_arr[$user_relation[$value['id']]])) {
				$Users[$key]['gas_station'] = $user_relation[$value['id']];
				$Users[$key]['gas_station_name'] = $site_arr[$user_relation[$value['id']]];
			}
		}
		$this->set('Users', $Users);
		$this->set('Sites', $site_arr);
	}

public function admin_site($arg = NULL){
		$data = explode('/', $arg);
		$colors_js = '';
		foreach ($this->app_colors as $value) {
			$colors_js .= "'$value',";
		}
		$colors_js = rtrim($colors_js,",");
		$this->set('Colors_js',$colors_js);
		$this->set("SiteOptions", $this->fuel_inventory->get_all_sites_options());
		$site = $data[0];
		if($data[0] == '') {
			$nosite = true;
		} else {
			$nosite = false;
		}
		$site_data = $this->fuel_inventory->get_site_data($site);
		if(!empty($site_data)) {
			$this->title = $site_data['dealer'];
		} else {
			$this->title = __('Fuel Inventory','fuel_inventory');
		}
		
		$last_fuel = $this->fuel_inventory->last_fuel_data($data[0]);
		if(!isset($data[1]) || $data[1] == '') {
			if(isset($last_fuel['site_date'])) {
				$data[1] = $last_fuel['site_date'];
			} else {
				$data[1] = date('F d, Y');
			}
		}
		if(!isset($data[2]) || $data[2] == '') {
			if(isset($last_fuel['site_date'])) {
				$data[2] = $last_fuel['site_date'];
			} else {
				$data[2] = date('F d, Y');
			}
		}
		if(strtotime($data[1]) > strtotime($data[2])) {
			$data[1] = $data[2];
		}
		// echo $data[2];
		$startdate = date('F d, Y', strtotime($data[1]));
		$enddate = date('F d, Y', strtotime($data[2]));
		if($data[1] == $data[2]) {
			$the_date = $startdate;
		} else {
			$the_date = $startdate.' - '. $enddate;
		}
		$product_colors = $this->fuel_inventory->get_product_colors();
		$site_tanks_relations = $this->fuel_inventory->get_site_tanks_relations($data[0]);
		$thanks = '';
		$TankUllage = '';
		$TankTCVolume = '';
		$TankTCVolumeCol = '';
		$TankTCVolumeN = '';
		$TankWaterVolume = '';
		$ProductAlias = '';
		$TankUllage_perc = '';
		$TankTCVolume_perc = '';
		$TankWaterVolume_perc = '';
		$TankUllagePerc = 0;
		$TankTCVolumePerc = 0;
		$TankWaterVolumePerc = 0;
		$fuel_data_tanks = array();
		foreach ($site_tanks_relations as $k => $value) {
			$product = $this->fuel_inventory->get_product($value['product_id']);
			$tank = $this->fuel_inventory->get_tank($value['tank_id']);
			if($data[1] == $data[2]) {
				$daybefore = strtotime($data[1].' -1 day');
				$daybefore = date('Y-m-d', $daybefore);
				$db_fuel_data = $this->fuel_inventory->get_fuel_data_tanks_widget($data[0],$daybefore,$value['tank_id']);
				$fuel_data = $this->fuel_inventory->get_fuel_data_day($data[0],$data[1],$data[2],$value['tank_id']);
				$ladd = end($fuel_data);
				$last_fuel['site_date'] = $ladd['site_date'];
				$last_fuel['site_time'] = $ladd['site_time'];
				$e = 0;
				foreach ($fuel_data as $key => $val) {
					$alias_meta = strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/','', $product['product_alias']));
					$alias_meta = str_replace('color', '', $alias_meta);
					$fuel_data_tanks[$k]['date'] = date('d M Y', strtotime($data[1]));
					$fuel_data_tanks[$k]['tank'] = $tank['tank'];
					$fuel_data_tanks[$k]['product'] = $product['product'];
					$fuel_data_tanks[$k]['product_alias'] = $product['product_alias'];
					$fuel_data_tanks[$k]['product_color'] = $product_colors[$alias_meta];
					$fuel_data_tanks[$k]['name'] = $tank['tank'] . ' = ' . $product['product_alias'];
					$fuel_data_tanks[$k]['cat'][$key] = date('H:i',strtotime($val['site_time']));
					$fuel_data_tanks[$k]['volume'][$key] = $val['tank_tc_volume'];
					if(!empty($db_fuel_data)) {
						$old_tank_tc_volume = $db_fuel_data['tank_tc_volume'];
					} else {
						$old_tank_tc_volume = $fuel_data_tanks[$k]['volume'][$key];
					}
					if($e == 0) {
						$sale = number_format($old_tank_tc_volume - $fuel_data_tanks[$k]['volume'][$key], 3, '.', '');
						if($sale < 0) {
							$sale = 0;
						}
						$fuel_data_tanks[$k]['sale'][$key] = $sale;
					} else {
						$sale = number_format($fuel_data_tanks[$k]['volume'][$key-1] - $fuel_data_tanks[$k]['volume'][$key], 3, '.', '');
						if($sale < 0) {
							$sale = 0;
						}
						$fuel_data_tanks[$k]['sale'][$key] = $sale;
					}
					$e++;
				}
			} else {
				$daybefore = strtotime($data[1].' -1 day');
				$daybefore = date('Y-m-d', $daybefore);
				$db_fuel_data = $this->fuel_inventory->get_fuel_data_tanks_widget($data[0],$daybefore,$value['tank_id']);
				$fuel_data = $this->fuel_inventory->get_fuel_data_tanks_all($data[0],$data[1],$data[2],$value['tank_id']);
				$ladd = $fuel_data[0];
				$last_fuel['site_date'] = $ladd['site_date'];
				$last_fuel['site_time'] = $ladd['site_time'];
				$e = 0;
				foreach ($fuel_data as $key => $val) {
					$alias_meta = strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/','', $product['product_alias']));
					$alias_meta = str_replace('color', '', $alias_meta);
					$fuel_data_tanks[$k]['date'] = date('d M Y', strtotime($data[1])) . ' - ' . date('d M Y', strtotime($data[2]));
					$fuel_data_tanks[$k]['tank'] = $tank['tank'];
					$fuel_data_tanks[$k]['product'] = $product['product'];
					$fuel_data_tanks[$k]['product_alias'] = $product['product_alias'];
					$fuel_data_tanks[$k]['product_color'] = $product_colors[$alias_meta];
					$fuel_data_tanks[$k]['name'] = $tank['tank'] . ' = ' . $product['product_alias'];
					$fuel_data_tanks[$k]['cat'][$key] = date('d M',strtotime($val['site_date']));
					$fuel_data_tanks[$k]['volume'][$key] = $val['tank_tc_volume'];
					if(!empty($db_fuel_data)) {
						$old_tank_tc_volume = $db_fuel_data['tank_tc_volume'];
					} else {
						$old_tank_tc_volume = $fuel_data_tanks[$k]['volume'][$key];
					}
					if($e == 0) {
						$sale = number_format($old_tank_tc_volume - $fuel_data_tanks[$k]['volume'][$key], 3, '.', '');
						if($sale < 0) {
							$sale = 0;
						}
						$fuel_data_tanks[$k]['sale'][$key] = $sale;
					} else {
						$sale = number_format($fuel_data_tanks[$k]['volume'][$key-1] - $fuel_data_tanks[$k]['volume'][$key], 3, '.', '');
						if($sale < 0) {
							$sale = 0;
						}
						$fuel_data_tanks[$k]['sale'][$key] = $sale;
					}
					$e++;
				}
			}
			$th = $this->fuel_inventory->get_tank($value['tank_id']);
			$pr = $this->fuel_inventory->get_product($value['product_id']);
			$fd = $this->fuel_inventory->get_fuel_data_tanks($data[0],$data[1],$data[2],$value['tank_id']);
			$tot = $fd['tank_ullage'] + $fd['tank_tc_volume'] + $fd['tank_water'];
			//echo $perc . ' - ';
			$col = $this->fuel_inventory->normal_color;
			if(!empty($fd)) {
				$perc = ($fd['tank_tc_volume']/$tot)*100;
				$perc = number_format($perc, 2, '.', '');
				if($perc < $this->fuel_inventory->lowlow_threshold) {
				$col = $this->fuel_inventory->lowlow_color;
				} else if($perc < $this->fuel_inventory->low_threshold) {
					$col = $this->fuel_inventory->low_color;
				} else if($perc > $this->fuel_inventory->high_threshold) {
					$col = $this->fuel_inventory->high_color;
				}
			}

			$TankTotals = $fd['tank_ullage'] + $fd['tank_tc_volume'] + $fd['tank_water'];
			if($TankTotals > 0) {
				$TankUllagePerc = ($fd['tank_ullage']/$TankTotals)*100;
				$TankTCVolumePerc = ($fd['tank_tc_volume']/$TankTotals)*100;
				$TankWaterVolumePerc = ($fd['tank_water']/$TankTotals)*100;
			}
			
			$TankUllagePerc = round($TankUllagePerc, 5, PHP_ROUND_HALF_DOWN);
			
			$TankTCVolumePerc = round($TankTCVolumePerc, 5, PHP_ROUND_HALF_DOWN);
			
			$TankWaterVolumePerc = round($TankWaterVolumePerc, 5, PHP_ROUND_HALF_DOWN);

			$TankUllage_perc .= $TankUllagePerc.',';
			$TankTCVolume_perc .=  $TankTCVolumePerc.',';
			$TankWaterVolume_perc .=  $TankWaterVolumePerc.',';
			$TankUllage .= $fd['tank_ullage'].',';
			$TankTCVolume .= '{color:"'.$col.'", y:'.$fd['tank_tc_volume'].'},';
			$TankTCVolumeCol .= '"'.$col.'",';
			$TankTCVolumeN .= $fd['tank_tc_volume'].',';
			$TankWaterVolume .= $fd['tank_water'].',';
			$thanks .= "'".$th['tank']."',";
			$ProductAlias .= "'".$pr['product_alias']."',";
		}
		// $test = $this->fuel_inventory->get_fuel_data_tanks($data[0],$data[1],$data[2],1);
		$TankUllage = rtrim($TankUllage,',');
		$TankTCVolume = rtrim($TankTCVolume,',');
		$TankTCVolumeCol = rtrim($TankTCVolumeCol,',');
		$TankTCVolumeN = rtrim($TankTCVolumeN,',');
		$TankWaterVolume = rtrim($TankWaterVolume,',');
		$ProductAlias = rtrim($ProductAlias,',');
		$thanks = rtrim($thanks,',');
		$TankUllage_perc = rtrim($TankUllage_perc,',');
		$TankTCVolume_perc =  rtrim($TankTCVolume_perc,',');
		$TankWaterVolume_perc =  rtrim($TankWaterVolume_perc,',');

		// print_r($fuel_data_tanks);
		$this->set("fuel_data_tanks", $fuel_data_tanks);
		$this->set("site", $site_data);
		$this->set("last_data", $last_fuel);
		$this->set("startdate", $startdate);
		$this->set("enddate", $enddate);
		$this->set("Thanks", $thanks);
		$this->set("dates", $the_date);
		$this->set("TankUllage", $TankUllage);
		$this->set("TankTCVolume", $TankTCVolume);
		$this->set("TankTCVolumeCol", $TankTCVolumeCol);
		$this->set("TankTCVolumeN", $TankTCVolumeN);
		$this->set("TankWaterVolume", $TankWaterVolume);
		$this->set("ProductAlias", $ProductAlias);
		$this->set("TankUllage_perc", $TankUllage_perc);
		$this->set("TankTCVolume_perc", $TankTCVolume_perc);
		$this->set("TankWaterVolume_perc", $TankWaterVolume_perc);
		$this->set('product_colors',$this->fuel_inventory->get_product_colors());
		$this->set('colors_array', $this->fuel_inventory->settings('col-array'));
		$this->set("NoSite",$nosite);
		$single_refresh = $this->fuel_inventory->get_meta('refresh-single-page-configuration');
		$this->set('single_refresh',$single_refresh[0]['value']);
		if(!empty($this->data)) {
			$sid = $this->data['site'];
			$dates = $this->data['site_date'];
			$this->admin_redirect('fuel-inventory/site/'.$sid.'/'.$dates.'/');
		}
	}

	public function admin_my_site($arg = NULL){
		if(isset($this->user['gas_station'])) {
			$this->set('has_gas_station',true);
			$data = explode('/', $arg);
			$colors_js = '';
			foreach ($this->app_colors as $value) {
				$colors_js .= "'$value',";
			}
			$colors_js = rtrim($colors_js,",");
			$this->set('Colors_js',$colors_js);
			$this->set("SiteOptions", $this->fuel_inventory->get_all_sites_options());
			$site = $this->user['gas_station'];
			$nosite = false;			
			$site_data = $this->fuel_inventory->get_site_data($site);
			$this->title = $site_data['dealer'];
			$last_fuel = $this->fuel_inventory->last_fuel_data($site);
			if(!isset($data[0]) || $data[0] == '') {
				if(isset($last_fuel['site_date'])) {
					$data[0] = $last_fuel['site_date'];
				} else {
					$data[0] = date('F d, Y');
				}
			}
			if(!isset($data[1]) || $data[1] == '') {
				if(isset($last_fuel['site_date'])) {
					$data[1] = $last_fuel['site_date'];
				} else {
					$data[1] = date('F d, Y');
				}
			}
			if(strtotime($data[0]) > strtotime($data[1])) {
				$data[0] = $data[1];
			}
			// echo $data[2];
			$startdate = date('F d, Y', strtotime($data[0]));
			$enddate = date('F d, Y', strtotime($data[1]));
			if($data[0] == $data[1]) {
				$the_date = $startdate;
			} else {
				$the_date = $startdate.' - '. $enddate;
			}
			$product_colors = $this->fuel_inventory->get_product_colors();
			$site_tanks_relations = $this->fuel_inventory->get_site_tanks_relations($site);
			$thanks = '';
			$TankUllage = '';
			$TankTCVolume = '';
			$TankTCVolumeCol = '';
			$TankTCVolumeN = '';
			$TankWaterVolume = '';
			$ProductAlias = '';
			$TankUllage_perc = '';
			$TankTCVolume_perc = '';
			$TankWaterVolume_perc = '';
			$TankUllagePerc = 0;
			$TankTCVolumePerc = 0;
			$TankWaterVolumePerc = 0;
			$fuel_data_tanks = array();
			foreach ($site_tanks_relations as $k => $value) {
				$product = $this->fuel_inventory->get_product($value['product_id']);
				$tank = $this->fuel_inventory->get_tank($value['tank_id']);
				if($data[0] == $data[1]) {
					$daybefore = strtotime($data[0].' -1 day');
					$daybefore = date('Y-m-d', $daybefore);
					$db_fuel_data = $this->fuel_inventory->get_fuel_data_tanks_widget($site,$daybefore,$value['tank_id']);
					$fuel_data = $this->fuel_inventory->get_fuel_data_day($site,$data[0],$data[1],$value['tank_id']);
					$ladd = end($fuel_data);
					$last_fuel['site_date'] = $ladd['site_date'];
					$last_fuel['site_time'] = $ladd['site_time'];
					$e = 0;
					foreach ($fuel_data as $key => $val) {
						$alias_meta = strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/','', $product['product_alias']));
						$alias_meta = str_replace('color', '', $alias_meta);
						$fuel_data_tanks[$k]['date'] = date('d M Y', strtotime($data[1]));
						$fuel_data_tanks[$k]['tank'] = $tank['tank'];
						$fuel_data_tanks[$k]['product'] = $product['product'];
						$fuel_data_tanks[$k]['product_alias'] = $product['product_alias'];
						$fuel_data_tanks[$k]['product_color'] = $product_colors[$alias_meta];
						$fuel_data_tanks[$k]['name'] = $tank['tank'] . ' = ' . $product['product_alias'];
						$fuel_data_tanks[$k]['cat'][$key] = date('H:i',strtotime($val['site_time']));
						$fuel_data_tanks[$k]['volume'][$key] = $val['tank_tc_volume'];
						if(!empty($db_fuel_data)) {
							$old_tank_tc_volume = $db_fuel_data['tank_tc_volume'];
						} else {
							$old_tank_tc_volume = $fuel_data_tanks[$k]['volume'][$key];
						}
						if($e == 0) {
							$sale = number_format($old_tank_tc_volume - $fuel_data_tanks[$k]['volume'][$key], 3, '.', '');
							if($sale < 0) {
								$sale = 0;
							}
							$fuel_data_tanks[$k]['sale'][$key] = $sale;
						} else {
							$sale = number_format($fuel_data_tanks[$k]['volume'][$key-1] - $fuel_data_tanks[$k]['volume'][$key], 3, '.', '');
							if($sale < 0) {
								$sale = 0;
							}
							$fuel_data_tanks[$k]['sale'][$key] = $sale;
						}
						$e++;
					}
				} else {
					$daybefore = strtotime($data[0].' -1 day');
					$daybefore = date('Y-m-d', $daybefore);
					$db_fuel_data = $this->fuel_inventory->get_fuel_data_tanks_widget($site,$daybefore,$value['tank_id']);
					$fuel_data = $this->fuel_inventory->get_fuel_data_tanks_all($site,$data[0],$data[1],$value['tank_id']);
					$ladd = $fuel_data[0];
					$last_fuel['site_date'] = $ladd['site_date'];
					$last_fuel['site_time'] = $ladd['site_time'];
					$e = 0;
					foreach ($fuel_data as $key => $val) {
						$alias_meta = strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/','', $product['product_alias']));
						$alias_meta = str_replace('color', '', $alias_meta);
						$fuel_data_tanks[$k]['date'] = date('d M Y', strtotime($data[0])) . ' - ' . date('d M Y', strtotime($data[1]));
						$fuel_data_tanks[$k]['tank'] = $tank['tank'];
						$fuel_data_tanks[$k]['product'] = $product['product'];
						$fuel_data_tanks[$k]['product_alias'] = $product['product_alias'];
						$fuel_data_tanks[$k]['product_color'] = $product_colors[$alias_meta];
						$fuel_data_tanks[$k]['name'] = $tank['tank'] . ' = ' . $product['product_alias'];
						$fuel_data_tanks[$k]['cat'][$key] = date('d M',strtotime($val['site_date']));
						$fuel_data_tanks[$k]['volume'][$key] = $val['tank_tc_volume'];
						if(!empty($db_fuel_data)) {
							$old_tank_tc_volume = $db_fuel_data['tank_tc_volume'];
						} else {
							$old_tank_tc_volume = $fuel_data_tanks[$k]['volume'][$key];
						}
						if($e == 0) {
							$sale = number_format($old_tank_tc_volume - $fuel_data_tanks[$k]['volume'][$key], 3, '.', '');
							if($sale < 0) {
								$sale = 0;
							}
							$fuel_data_tanks[$k]['sale'][$key] = $sale;
						} else {
							$sale = number_format($fuel_data_tanks[$k]['volume'][$key-1] - $fuel_data_tanks[$k]['volume'][$key], 3, '.', '');
							if($sale < 0) {
								$sale = 0;
							}
							$fuel_data_tanks[$k]['sale'][$key] = $sale;
						}
						$e++;
					}
				}
				$th = $this->fuel_inventory->get_tank($value['tank_id']);
				$pr = $this->fuel_inventory->get_product($value['product_id']);
				$fd = $this->fuel_inventory->get_fuel_data_tanks($site,$data[0],$data[1],$value['tank_id']);
				$tot = $fd['tank_ullage'] + $fd['tank_tc_volume'] + $fd['tank_water'];
				//echo $perc . ' - ';
				$col = $this->fuel_inventory->normal_color;
				if(!empty($fd)) {
					$perc = ($fd['tank_tc_volume']/$tot)*100;
					$perc = number_format($perc, 2, '.', '');
					if($perc < $this->fuel_inventory->lowlow_threshold) {
					$col = $this->fuel_inventory->lowlow_color;
					} else if($perc < $this->fuel_inventory->low_threshold) {
						$col = $this->fuel_inventory->low_color;
					} else if($perc > $this->fuel_inventory->high_threshold) {
						$col = $this->fuel_inventory->high_color;
					}
				}

				$TankTotals = $fd['tank_ullage'] + $fd['tank_tc_volume'] + $fd['tank_water'];
				if($TankTotals > 0) {
					$TankUllagePerc = ($fd['tank_ullage']/$TankTotals)*100;
					$TankTCVolumePerc = ($fd['tank_tc_volume']/$TankTotals)*100;
					$TankWaterVolumePerc = ($fd['tank_water']/$TankTotals)*100;
				}
				
				$TankUllagePerc = round($TankUllagePerc, 5, PHP_ROUND_HALF_DOWN);
				
				$TankTCVolumePerc = round($TankTCVolumePerc, 5, PHP_ROUND_HALF_DOWN);
				
				$TankWaterVolumePerc = round($TankWaterVolumePerc, 5, PHP_ROUND_HALF_DOWN);

				$TankUllage_perc .= $TankUllagePerc.',';
				$TankTCVolume_perc .=  $TankTCVolumePerc.',';
				$TankWaterVolume_perc .=  $TankWaterVolumePerc.',';
				$TankUllage .= $fd['tank_ullage'].',';
				$TankTCVolume .= '{color:"'.$col.'", y:'.$fd['tank_tc_volume'].'},';
				$TankTCVolumeCol .= '"'.$col.'",';
				$TankTCVolumeN .= $fd['tank_tc_volume'].',';
				$TankWaterVolume .= $fd['tank_water'].',';
				$thanks .= "'".$th['tank']."',";
				$ProductAlias .= "'".$pr['product_alias']."',";
			}
			// $test = $this->fuel_inventory->get_fuel_data_tanks($data[0],$data[1],$data[2],1);
			$TankUllage = rtrim($TankUllage,',');
			$TankTCVolume = rtrim($TankTCVolume,',');
			$TankTCVolumeCol = rtrim($TankTCVolumeCol,',');
			$TankTCVolumeN = rtrim($TankTCVolumeN,',');
			$TankWaterVolume = rtrim($TankWaterVolume,',');
			$ProductAlias = rtrim($ProductAlias,',');
			$thanks = rtrim($thanks,',');
			$TankUllage_perc = rtrim($TankUllage_perc,',');
			$TankTCVolume_perc =  rtrim($TankTCVolume_perc,',');
			$TankWaterVolume_perc =  rtrim($TankWaterVolume_perc,',');

			// print_r($fuel_data_tanks);
			$this->set("fuel_data_tanks", $fuel_data_tanks);
			$this->set("site", $site_data);
			$this->set("last_data", $last_fuel);
			$this->set("startdate", $startdate);
			$this->set("enddate", $enddate);
			$this->set("Thanks", $thanks);
			$this->set("dates", $the_date);
			$this->set("TankUllage", $TankUllage);
			$this->set("TankTCVolume", $TankTCVolume);
			$this->set("TankTCVolumeCol", $TankTCVolumeCol);
			$this->set("TankTCVolumeN", $TankTCVolumeN);
			$this->set("TankWaterVolume", $TankWaterVolume);
			$this->set("ProductAlias", $ProductAlias);
			$this->set("TankUllage_perc", $TankUllage_perc);
			$this->set("TankTCVolume_perc", $TankTCVolume_perc);
			$this->set("TankWaterVolume_perc", $TankWaterVolume_perc);
			$this->set('product_colors',$this->fuel_inventory->get_product_colors());
			$this->set('colors_array', $this->fuel_inventory->settings('col-array'));
			$this->set("NoSite",$nosite);
			$single_refresh = $this->fuel_inventory->get_meta('refresh-single-page-configuration');
			$this->set('single_refresh',$single_refresh[0]['value']);
			if(!empty($this->data)) {
				$sid = $this->data['site'];
				$dates = $this->data['site_date'];
				$this->admin_redirect('fuel-inventory/my-site/'.$dates.'/');
			}

		} else {
			$this->title = __('My Inventory','fuel_inventory');
			$nosite = true;
			$this->set("NoSite",$nosite);
			$this->set('has_gas_station',false);
		}
		
	}

	
	public function admin_settings($page = NULL){
		$this->title = __('Settings','fuel_inventory');
		$pc = $this->fuel_inventory->product_colors();
		$btns = array( 
			0 => array('name' => __('Products','fuel_inventory'), 'link' => 'products', 'class' => ''),
			1 => array('name' => __('Tanks','fuel_inventory'), 'link' => 'tanks', 'class' => ''),
			2 => array('name' => __('Gas Stations','fuel_inventory'), 'link' => 'gas-stations', 'class' => ''),
			3 => array('name' => __('Relations','fuel_inventory'), 'link' => 'relations', 'class' => ''),
			4 => array('name' => __('Colorset','fuel_inventory'), 'link' => 'colorset', 'class' => ''),
			5 => array('name' => __('Configurations','fuel_inventory'), 'link' => 'configurations', 'class' => '')
		);

		if($this->is_plugin_active('map_markers')) {
			$this->set('map_markers', true);
			$this->loadmodel('map_markers');
			$markers = $this->map_markers->get_all_no_relation_stations();
			$marker_option = array();
			if(!empty($markers)) {
				foreach ($markers as $value) {
				$stat_data = unserialize($value['station_data']);
				$marker_option[$value['id']] = $stat_data['dealer'];
				}
			}
			
			$this->set('marker_option', $marker_option);
		} else {
			$this->set('map_markers', false);
		}


		if($page == NULL) {
			$page = 'products';
		}
		if($page == NULL) {
			$this->set('page', false);
			$this->set('btns',$btns);
			
		} else {

			$this->set('site_options', $this->fuel_inventory->get_all_sites_options());
			$this->set('tank_options', $this->fuel_inventory->get_all_tanks_options());
			$this->set('product_options', $this->fuel_inventory->get_all_products_options());
			$page = rtrim($page,'/');
			
			$page = explode('/', $page);
			foreach ($btns as $key => $value) {
				if($value['link'] == $page[0]) {
					$btns[$key]['class'] = 'btn-success';
				} else {
					$btns[$key]['class'] = 'btn-primary';
				}
			}
			

			$products = $this->fuel_inventory->get_all_products();
			$sites = $this->fuel_inventory->get_all_sites();
			$tanks = $this->fuel_inventory->get_all_tanks();
			$this->set('products', $products);
			$this->set('sites', $sites);
			$this->set('tanks', $tanks);
			if(isset($page[1])) {
				$rel = $this->fuel_inventory->get_all_site_tanks_relations($page[1]);
				foreach ($rel as $key => $value) {
					$dealer = $this->fuel_inventory->get_site_data($value['site_id']);
					$tank = $this->fuel_inventory->get_tank($value['tank_id']);
					$product = $this->fuel_inventory->get_product($value['product_id']);
					if(empty($dealer) || empty($tank) || empty($product)) {
						unset($rel[$key]);
					} else {
						$rel[$key]['dealer'] = $dealer;
						$rel[$key]['tank'] = $tank;
						$rel[$key]['product'] = $product;
					}
					
				}
				$this->set('relations', $rel);
			} else {
				$page[1] = $sites[0]['site_id'];
				$rel = $this->fuel_inventory->get_all_site_tanks_relations($sites[0]['site_id']);
				foreach ($rel as $key => $value) {
					$dealer = $this->fuel_inventory->get_site_data($value['site_id']);
					$tank = $this->fuel_inventory->get_tank($value['tank_id']);
					$product = $this->fuel_inventory->get_product($value['product_id']);
					$rel[$key]['dealer'] = $dealer;
					$rel[$key]['tank'] = $tank;
					$rel[$key]['product'] = $product;
				}
				$this->set('relations', $rel);

			}
			$this->set('page', $page); 
			$this->set('colorset_products', $pc);
			$this->set('btns',$btns);
			$this->set('thresholds', $this->fuel_inventory->get_meta('threshold'));
			$this->set('colors', $this->fuel_inventory->get_meta('color'));
			$this->set('colors_array', $this->fuel_inventory->settings('col-array'));
			$this->set('configurations', $this->fuel_inventory->get_meta('configuration'));
			$this->set('dashboard_chart', $this->fuel_inventory->get_meta('chart'));
			$dashboard_chart_options = array('doughnut','pie','radar','bar');
			$this->set('dashboard_chart_options', $dashboard_chart_options);
		}

	}

	public function admin_edit_gas_station($id = NULL){
		if($id != NULL) {
			$marker_option = array();
			$this->title = __('Edit Gas Station','fuel_inventory');
			$station = $this->fuel_inventory->get_site_data($id);
			$map_id = $this->fuel_inventory->get_markers_from_site($id);
			if(!empty($map_id )) {
				$map_data = unserialize($map_id['station_data']);
				$map_data['id'] = $map_id['id'];
			} else {
				$map_data = array();
			}
			
				if($this->is_plugin_active('map_markers')) {
				$this->set('map_markers', true);
				$this->loadmodel('map_markers');
				$markers = $this->map_markers->get_all_no_relation_stations();
				$marker_option = array();
				if(!empty($markers)) {
					foreach ($markers as $value) {
					$stat_data = unserialize($value['station_data']);
					$marker_option[$value['id']] = $stat_data['dealer'];
					}
				}
				
				} else {
					$this->set('map_markers', false);
				}
			if(!empty($this->data)){
			$this->loadmodel('fuel_sites');
			$this->fuel_sites->id = $station['id'];
			$ch = $this->fuel_sites->save($this->data);
				if(isset($this->data['map_id'])) {
					$this->loadmodel('map_markers');
					if($this->data['map_id'] > 0) {
						$this->map_markers->id = $this->data['map_id'];
						$dd['site_id'] = rtrim($id,'/');
						$this->map_markers->save($dd);
					} else {
						if(isset($map_id['id'])){
							$this->map_markers->id = $map_id['id'];
							$dd['site_id'] = rtrim($id,'/');
							$this->map_markers->save($dd);
						}
					}
				}

				if($ch > 0) {
					Message::flash(__('Gas Station has been saved','fuel_inventory'));
					$this->admin_redirect('fuel-inventory/settings/gas-stations/');
				} else {
					Message::flash(__('Nothing to save','fuel_inventory'));
					$this->admin_redirect('fuel-inventory/settings/gas-stations/');
				}
			}
		} else {
			$map_id = array();
			$map_data = array();
			$this->title = __('Sorry, no Gas Station to edit','fuel_inventory');
			$station = '';
		}
		$this->set('map_id',$map_id);
		$this->set('map_data',$map_data);
		$this->set('station',$station);
		$this->set('marker_option', $marker_option);

	}
// ======================== All Widgets ======================== //

	public function widget_all_latest_fuels(){
		$sites = $this->fuel_inventory->get_all_sites('id, site_id, dealer');
		$site_data = array();
		$i = 0;
		foreach ($sites as $key => $value) {
			$last_fuel_data = $this->fuel_inventory->last_fuel_data($value['site_id']);
			$site_relations_data = $this->fuel_inventory->get_site_tanks_relations($value['site_id']);
			$date = $last_fuel_data['site_date'];
			$tanks_data = array();
			$e = 0;
			foreach ($site_relations_data as $k => $val) {
				$tank = $this->fuel_inventory->get_tank($val['tank_id']);
				$product = $this->fuel_inventory->get_product($val['product_id']);
				$fuel_data = $this->fuel_inventory->get_fuel_data_tanks_widget($value['site_id'],$date,$val['tank_id']);
				if(!empty($fuel_data)) {
					$c = $fuel_data['tank_tc_volume'] + $fuel_data['tank_ullage'] + $fuel_data['tank_water'];
					$water_perc = ($fuel_data['tank_water']/$c)*100;
					$tank_tc_volume_perc = ($fuel_data['tank_tc_volume']/$c)*100;
					$tank_ullage_perc = ($fuel_data['tank_ullage']/$c)*100;
					$fuel_data['tank_total_volume'] = $c;
					$fuel_data['tank_tc_volume_perc'] = number_format($tank_tc_volume_perc,2,'.','');
					if($tank_tc_volume_perc < $this->lowlow_threshold ) {
						$fuel_data['tank_tc_volume_color'] = hex2rgb($this->lowlow_color);
					} else if($tank_tc_volume_perc < $this->low_threshold) {
						$fuel_data['tank_tc_volume_color'] = hex2rgb($this->low_color);
					} else if($tank_tc_volume_perc > $this->high_threshold) {
						$fuel_data['tank_tc_volume_color'] = hex2rgb($this->high_color);
					} else {
						$fuel_data['tank_tc_volume_color'] = hex2rgb($this->normal_color);
					}
					$fuel_data['tank_ullage_perc'] = number_format($tank_ullage_perc,2,'.','');
					$fuel_data['tank_ullage_color'] = hex2rgb($this->ullage_color);
					$fuel_data['water_perc'] = number_format($water_perc,2,'.','');
					$fuel_data['water_color'] = hex2rgb($this->water_color);
					$tanks_data[$k]['tank-name'] = $tank;
					$tanks_data[$k]['product-name'] = $product;
					$tanks_data[$k]['tank_data'] = $fuel_data;
					$e++;
				}
			}
			$sites[$key]['date'] = $last_fuel_data['site_date'].' '.$last_fuel_data['site_time'];
			$sites[$key]['tanks'] = $tanks_data;
			if(!empty($sites[$key]['tanks'])) {
				$site_data[$i] = $sites[$key];
				$i++;
			}
		}
		$this->set('sites',$site_data);
		$chart_style = $this->fuel_inventory->get_meta('dashboard-chart');
		$dash_refresh = $this->fuel_inventory->get_meta('refresh-dashboard-configuration');
		$this->set('chart_style',$chart_style[0]['value']);
		$this->set('dash_refresh',$dash_refresh[0]['value']);
	}

	public function widget_show_inventory_link_in_map_markers(){
		
	}

// ======================== All REST methods ======================== //
	# Settings page Product methods
	public function rest_add_product(){
		$data = array();
		$data['add'] = 'nothing';
		if(!empty($this->data)){
			$this->loadmodel('fuel_products');
			$this->data['status'] = 1;
			$ch = $this->fuel_products->save($this->data);
			if($ch > 0) {
				$data['add'] = "success";
			} else {
				$data['add'] = "failed";
			}
		}
		echo json_encode($data);
	}

	public function rest_edit_product(){
		$data = array();
		$data['add'] = 'nothing';
		if(!empty($this->data)){
			$this->loadmodel('fuel_products');
			$this->fuel_products->id = $this->data['id'];
			// $this->fuel_products->column('id',$this->data['id']);
			$ch = $this->fuel_products->save($this->data);
			$data['check'] = $ch;
			if($ch > 0) {
				$data['add'] = "success";
			} else {
				$data['add'] = "failed";
			}
		}
		echo json_encode($data);
	}

	public function rest_delete_product(){
		$data = array();
		$data['add'] = 'nothing';
		if(!empty($this->data)) {
			$this->loadmodel('fuel_products');
			$this->data['status'] = 0;
			$this->fuel_products->id = $this->data['id'];
			$ch = $this->fuel_products->save($this->data);
			if($ch > 0) {
				if(isset($this->data['prod'])) {
					$this->loadmodel('fuel_site_tank_product');
					$fdata['status'] = 0;
					$this->fuel_site_tank_product->column('product_id',$this->data['prod']);
					$ss = $this->fuel_site_tank_product->save($fdata);
					if($ss > 0) {
						$data['add'] = "success";
					} else {
						$data['add'] = "success";
					}
					
				} else {
					$data['add'] = "success";
				}
				
			} else {
				$data['add'] = "failed";
			}
		}
		echo json_encode($data);
	}

	# Settings page Site methods
	public function rest_add_site(){
		$data = array();
		$data['add'] = 'nothing';
		if(!empty($this->data)){
			$this->loadmodel('fuel_sites');
			$this->data['status'] = 1;
			$ch = $this->fuel_sites->save($this->data);

			if($ch > 0) {
				if($this->data['rel_id_map'] != 0) {
					$this->loadmodel('map_markers');
					$this->map_markers->id = $this->data['rel_id_map'];
					$this->map_markers->save(array('site_id' => $this->data['site_id']));
				}
				$data['add'] = "success";
			} else {
				$data['add'] = "failed";
			}
		}
		echo json_encode($data);
	}

	public function rest_edit_site(){
		$data = array();
		$data['add'] = 'nothing';
		if(!empty($this->data)){
			$this->loadmodel('fuel_sites');
			$this->fuel_sites->id = $this->data['id'];
			$ch = $this->fuel_sites->save($this->data);
			if($ch > 0) {
				$data['add'] = "success";
			} else {
				$data['add'] = "failed";
			}
		}
		echo json_encode($data);
	}

	public function rest_delete_site(){
		$data = array();
		$data['do'] = 'nothing';
		if(!empty($this->data)) {
			$this->loadmodel('fuel_sites');
			$this->data['status'] = 0;
			$this->fuel_sites->id = $this->data['id'];
			$ch = $this->fuel_sites->save($this->data);
			if($ch > 0) {
				if(isset($this->data['st'])) {
					$this->loadmodel('fuel_site_tank_product');
					$fdata['status'] = 0;
					$this->fuel_site_tank_product->column('site_id',$this->data['st']);
					$ss = $this->fuel_site_tank_product->save($fdata);
					if($ss > 0) {
						$data['do'] = "success";
					} else {
						$data['do'] = "success";
					}
				} else {
					$data['do'] = "success";
				}
				$sd = $this->fuel_inventory->get_site_id_from_id($this->data['id']);
				$mp = $this->fuel_inventory->get_markers_from_site($sd['site_id']);
				if(!empty($mp)) {
					$this->loadmodel('map_markers');
					$this->map_markers->id = $mp['id'];
					$this->map_markers->save(array('site_id' => 0));
				}
			} else {
				$data['do'] = "failed";
			}
		}
		echo json_encode($data);
	}

	# Settings page Tank methods
	public function rest_add_tank(){
		$data = array();
		$data['add'] = 'nothing';
		if(!empty($this->data)){
			$this->loadmodel('fuel_tanks');
			$this->data['status'] = 1;
			$ch = $this->fuel_tanks->save($this->data);
			if($ch > 0) {
				$data['add'] = "success";
			} else {
				$data['add'] = "failed";
			}
		}
		echo json_encode($data);
	}

	public function rest_edit_tank(){
		$data = array();
		$data['add'] = 'nothing';
		if(!empty($this->data)){
			$this->loadmodel('fuel_tanks');
			$this->fuel_tanks->id = $this->data['id'];
			$ch = $this->fuel_tanks->save($this->data);
			if($ch > 0) {
				$data['add'] = "success";
			} else {
				$data['add'] = "failed";
			}
		}
		echo json_encode($data);
	}

	public function rest_delete_tank(){
		$data = array();
		$data['do'] = 'nothing';
		if(!empty($this->data)){
			$this->loadmodel('fuel_tanks');
			$this->data['status'] = 0;
			$this->fuel_tanks->id = $this->data['id'];
			$ch = $this->fuel_tanks->save($this->data);
			if($ch > 0) {
				if(isset($this->data['ti'])) {
					$this->loadmodel('fuel_site_tank_product');
					$fdata['status'] = 0;
					$this->fuel_site_tank_product->column('tank_id',$this->data['ti']);
					$ss = $this->fuel_site_tank_product->save($fdata);
					if($ss > 0) {
						$data['do'] = "success";
					} else {
						$data['do'] = "success";
					}
				} else {
					$data['do'] = "success";
				}
			} else {
				$data['do'] = "failed";
			}
		}
		echo json_encode($data);
	}

	# Settings page Relation methods
	public function rest_add_relation(){
		$data = array();
		$data['add'] = 'nothing';
		if(!empty($this->data)){
			$this->loadmodel('fuel_site_tank_product');
			$this->data['status'] = 1;
			$ch = $this->fuel_site_tank_product->save($this->data);
			if($ch > 0) {
				$data['add'] = "success";
			} else {
				$data['add'] = "failed";
			}
		}
		echo json_encode($data);
	}

	public function rest_edit_relation(){
		$data = array();
		$data['add'] = 'nothing';
		if(!empty($this->data)){
			$this->loadmodel('fuel_site_tank_product');
			$this->fuel_site_tank_product->id = $this->data['id'];
			$ch = $this->fuel_site_tank_product->save($this->data);
			if($ch > 0) {
				$data['add'] = "success";
			} else {
				$data['add'] = "failed";
			}
		}
		echo json_encode($data);
	}

	public function rest_delete_relation($id){
		$data = array();
		$data['add'] = 'nothing';
		if(isset($id)){
			$this->loadmodel('fuel_site_tank_product');
			$this->data['status'] = 0;
			$this->fuel_site_tank_product->id = $id;
			$ch = $this->fuel_site_tank_product->save($this->data);
			if($ch > 0) {
				$data['add'] = "success";
			} else {
				$data['add'] = "failed";
			}
		}
		echo json_encode($data);
	}

	# Settings page Colorset methods
	public function rest_edit_settings(){
		$data = array();
		$data['add'] = 'nothing';
		if(!empty($this->data)){
			$this->loadmodel('fuel_settings');
			if(!isset($this->data['thres'])) {
				$this->data['value'] = '#'.$this->data['value'];
			}
			if(isset($this->data['id'])) {
				$this->fuel_settings->id = $this->data['id'];
			} else {
				$this->data['status'] = 1;
			}
			$ch = $this->fuel_settings->save($this->data);
			if($ch > 0) {
				$data['add'] = "success";
			} else {
				$data['add'] = "success";
			}
		}
		echo json_encode($data);
	}

	function rest_file_upload(){
		if(isset($this->data['pers'])) {
			$document = $this->fuel_inventory->behavior->upload_protect_ajax('scanned_doc',array('size' => 5,'dir' => 'fuel/inventory/galary'));
			echo $document;
		}

		if(isset($this->data['don'])) {
			$document = $this->fuel_inventory->behavior->upload_protect_ajax('scanned_doc',array('size' => 5,'dir' => 'fuel/inventory/images'));
			echo $document;
		}
				
	}

	public function rest_update_user_relation(){
		$data = array();
		$data['add'] = 'nothing';
		$dd = array();
		if(!empty($this->data)){
			$sites_user_relation = $this->fuel_inventory->get_all_user_sites_relations();
			$user_relation = array();
			if(!empty($sites_user_relation)) {
				foreach ($sites_user_relation as $value) {
					$user_relation[$value['user_id']] = $value['id'];
				}
			}
			$this->loadmodel('fuel_sites_user_relation');
			if(!empty($this->data['userids'])) {
				$dd['added'] = date('Y-m-d H:i:s');
				$dd['added_user'] = $this->user['id'];
				$dd['status'] = 1;
				foreach ($this->data['userids'] as $value) {
					$dd['user_id'] = $value;
					if($this->data['bulk'] == 1) {
						$dd['site_id'] = $this->data['site'];
					} else {
						$dd['site_id'] = 0;
					}
					
					if(isset($user_relation[$value])) {
						$this->fuel_sites_user_relation->id = $user_relation[$value];
					} else {
						$this->fuel_sites_user_relation->id = NULL;
					}
					$ch = $this->fuel_sites_user_relation->save($dd);
				}
			}
			// $this->fuel_products->id = $this->data['id'];
			// $this->fuel_products->column('id',$this->data['id']);
			// $ch = $this->fuel_products->save($this->data);
			$data['check'] = $ch;
			if($ch > 0) {
				$data['add'] = "success";
			} else {
				$data['add'] = "failed";
			}
		}
		echo json_encode($data);
	}

	public function rest_get_map_marker () {
		$data = array();
		if(!empty($this->data)){
			$this->loadmodel('map_markers');
			$dd = $this->map_markers->get_station($this->data['id']);
			if(!empty($dd)) {
				$data['marker'] = unserialize($dd['station_data']);
				$data['do'] = 'success';
			} else {
				$data['do'] = 'failed';
			}
			
		}
		echo json_encode($data);
	}

	public function rest_remove_map_link () {
		$data = array();
		if(!empty($this->data)){
			$this->loadmodel('map_markers');
			$dd['site_id'] = 0;
			$this->map_markers->id = $this->data['id'];
			$ch = $this->map_markers->save($dd);
			if($ch > 0) {
				$data['do'] = 'success';
			}

		}
		echo json_encode($data);
	}
}

