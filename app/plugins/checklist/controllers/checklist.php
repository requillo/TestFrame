<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
/**
* 
*/
class Checklist extends Controller {

	function __construct(){ 
		parent::__construct();
		$cats = $this->checklist->get_list_cat();
		$this->cats_options = array();
		$this->cats_interval_types = array(1 => 'Time', 2 => 'Count');
		$this->list_add_view = array(1 => 'Group block view', 2 => 'Group inline view');
		$this->list_data_view = array(1 => 'Data in one table', 2 => 'Data per table');
		$this->link_type = array(0 => 'No linking', 1 => 'Header', 2 => 'Option');
		$this->function_types = array(1 => 'Sum', 2 => 'Minus', 3 => 'Multiply', 4 => 'Divide', 5 => "Average");
		$this->set('link_type', $this->link_type);
		$this->set('list_add_view', $this->list_add_view);
		$this->set('list_data_view', $this->list_data_view);
		$this->set('function_types', $this->function_types);
		$this->option_types = array(1 => 'Text', 2 => 'Number', 3 => 'Checkbox', 4 => 'Select', 5 => 'App Users', 6 => 'Date',7 => 'Time',8=>'Header title',9=>'Increment text');
		$dep = $this->checklist->get_user_department_from_user_id($this->user['id']);
		if(!empty($dep)) {
			$this->user['department'] = $dep[0];
		} else {
			$this->user['department'] = array('department_id'=>'');
		}
		foreach ($cats as $value) {
		 	$this->cats_options[$value['id']] = $value['name'];
		}
	}

	public function admin_index(){
		$this->title = __('Checklists', 'checklist');
		$this->set('list_names', $this->checklist->get_list_names());
	}

	public function admin_settings(){
		$this->title = __('Settings', 'checklist');
		$checklist_settings = $this->checklist->get_checklist_settings();
		$this->set('checklist_settings', $checklist_settings);
		if(!empty($this->data)) {
			$this->loadmodel('checklist_settings');
			if(!empty($checklist_settings)) {
				$this->checklist_settings->id = $checklist_settings['id'];
				$ch = $this->checklist_settings->save($this->data);
			} else {
				$ch = $this->checklist_settings->save($this->data);
			}
			
			if($ch > 0) {
				Message::flash(__('Settings saved','checklist'));
			} else {
				Message::flash(__('Could not save settings','checklist'),'error');
			}
			$this->admin_redirect('checklist/settings/');
		}
	}

	public function admin_shifts_settings(){
		$this->title = __('Shifts Settings', 'checklist');
		$checklist_settings = $this->checklist->get_checklist_settings();
		$this->set('checklist_settings', $checklist_settings);
		if(!empty($this->data)) {
			$this->loadmodel('checklist_shifts');
				$ch = $this->checklist_shifts->save($this->data);
			if($ch > 0) {
				Message::flash(__('Shift saved','checklist'));
			} else {
				Message::flash(__('Nothing saved','checklist'),'error');
			}
			$this->admin_redirect('checklist/shifts-settings/');
		}
	}

	public function admin_add_to_list($id = NULL){
		// print_r($this->user);
		$user_deps = $this->checklist->get_departments($this->user['department']['department_id']);
		$category = array();
		if(isset($user_deps['checklist_name_ids'])) {
			$user_deps_arr = explode(',', $user_deps['checklist_name_ids']);
		} else {
			$user_deps_arr =array();
		}

		if(in_array(rtrim($id,'/'), $user_deps_arr)) {
			$name = $this->checklist->get_list_name($id);
		} else {
			$name = array();
		}

		if(isset($user_deps['checklist_name_ids'])) {
			$listnames = $this->checklist->get_list_names_from_ids($user_deps['checklist_name_ids']);
		} else {
			$listnames = array();
		}

		$settings = $this->checklist->get_checklist_settings();
		$settings['shifts'] = explode(',', $settings['shifts']);
		$time_array = array();
		if(isset($settings['time_array'])) {
			$time_array = explode(',', $settings['time_array']);
		}
		$pasttimes = array();
		$futuretimes = array();
		$currentTime = date('H:i');
		// echo $currentTime;
		$current_shift = $this->checklist->get_checklist_current_shift($currentTime);
		// print_r($current_shift);
		if(!empty($listnames)) {
			foreach ($listnames as $key => $value) {
				if(!isset($category[$value['category']])) {
					$category[$value['category']] = $this->checklist->get_list_cat($value['category']);
				}
				$listnames[$key]['interval_type'] = $category[$value['category']]['interval_type'];
				$listnames[$key]['interval_data'] = json_decode($category[$value['category']]['interval_data'], true);
				if(isset($current_shift['id'])) {
					$listnames[$key]['current_shift'] =  explode(',', $listnames[$key]['interval_data'][$current_shift['id']]);
				} else {
					$listnames[$key]['current_shift'] = array();
				}

				$i = 0;
				$e = 0;
				if(!empty($listnames[$key]['current_shift'])) {
					foreach ($listnames[$key]['current_shift'] as $val) {
						// Interval Type for view all lists
						if($listnames[$key]['interval_type'] == 1) {
							if($current_shift['shift_start'] > $current_shift['shift_end'] ) {
								if($val == '00:00') {
									$val = '24:00';
								}
							}
							if($currentTime >= $val) {
								$pasttimes[$i] = $val;
								$listnames[$key]['pasttimes'][$i] = $val;
								$i++;
							} else {
								$futuretimes[$e] = $value;
								$listnames[$key]['futuretimes'][$e] = $val;
								$e++;
							}
						// Interval Type for view all lists
						// This is for other type count
						} else {
							$dtt = explode('=', $val);
							$dtt_c = $dtt[0];
							if(isset($dtt[1])) {
								$dtt_t = explode('-', $dtt[1]);
							} else {
								$dtt_t[0] = 0;
								$dtt_t[1] = 0;
							}
							
							$listnames[$key]['count'] = $dtt_c;
							if($currentTime >= $dtt_t[0] && $currentTime < $dtt_t[1]) {
								$listnames[$key]['pasttimes'][0] = $dtt_t[0];
								$listnames[$key]['futuretimes'][0] = $dtt_t[1];
							} else {
								$listnames[$key]['pasttimes'][0] = $dtt_t[0];
								$listnames[$key]['pasttimes'][1] = $dtt_t[1];
								$listnames[$key]['notyet'] = 1;
							}
							$listnames[$key]['count_set'] = $dtt_t[0];
							$listnames[$key]['count_max'] = $dtt_t[1];
						}
					}

					if(isset($listnames[$key]['pasttimes'])) {
						$listnames[$key]['pasttimes'] = array_reverse($listnames[$key]['pasttimes']);
					}
				}
			}
		}
		
		$curTimArr = end($pasttimes);
		$this->set('pasttimes', $pasttimes);
		// print_r($listnames);
		if(!empty($name)) {
			// print_r($name);
			$today = date('Y-m-d');
			$user_ids = $this->checklist->get_all_user_ids_from_lists($today);
			$users = $this->checklist->get_app_users($user_ids);
			if($name['no_options'] != '') {
				$options = $this->checklist->get_list_options($name['category'], $name['no_options']);
			} else {
				$options = $this->checklist->get_list_options($name['category']);
			}
			
			$category = $this->checklist->get_list_cat($name['category']);
			$checklists = $this->checklist->get_checklists($id,date('Y-m-d'),array($current_shift['shift_start'],$current_shift['shift_end']));
			// print_r($checklists);
			$name['category'] = $category;
			$current_shift = $this->checklist->get_checklist_current_shift($currentTime);

			$name['category']['interval_data'] = json_decode($name['category']['interval_data'], true);
			if(isset($current_shift['id'])) {
				$name['current_shift'] =  explode(',', $name['category']['interval_data'][$current_shift['id']]);
			} else {
				$name['current_shift'] = array();
			}
			
			if($name['category']['interval_type'] == 2 ) {
				$dtt = explode('=', $name['current_shift'][0]);
				$dtt_c = $dtt[0];
				$name['count'] = $dtt[0];
				if(isset($dtt[1])) {
					$dtt_t = explode('-', $dtt[1]);
					if($currentTime >= $dtt_t[0] && $currentTime < $dtt_t[1]) {
						$name['pasttimes'][0] = $dtt_t[0];
						$name['futuretimes'][0] = $dtt_t[1];
					} else {
						$name['pasttimes'][0] = $dtt_t[0];
						$name['pasttimes'][1] = $dtt_t[1];
						$name['notyet'] = 1;
					} 
				} else {
					if($currentTime >= $current_shift['shift_start'] && $currentTime < $current_shift['shift_end']) {
						$name['pasttimes'][0] = $current_shift['shift_start'];
						$name['futuretimes'][0] = $current_shift['shift_end'];
					} else {
						$name['pasttimes'][0] = $current_shift['shift_start'];;
						$name['pasttimes'][1] = $current_shift['shift_end'];;
						$name['notyet'] = 1;
					}
				}
				$name['count-1'] = $current_shift;
				$name['list-added-count'] = count($checklists);
				$name['list-remain-count'] = $name['count'] - $name['list-added-count'];
				if($name['list-remain-count'] > 0 && isset($name['futuretimes'])) {
					$name['notyet'] = 0;
				} else {
					$name['notyet'] = 1;
				}
				
			} else {
				$i = 0;
				$e = 0;
				if(!empty($name['current_shift'])) {
					foreach ($name['current_shift'] as $value) {
						if($current_shift['shift_start'] > $current_shift['shift_end'] ) {
								if($value == '00:00') {
									$value = '24:00';
								}
							}


						if($currentTime >= $value) {
							$name['pasttimes'][$i] = $value;
							$i++;
						} else {
							$name['futuretimes'][$e] = $value;
							$e++;
						}
					}
				}

			}				

			$check_group = '';
			foreach ($options as $k => $v) {
				if(!is_numeric($v)) {

				}
			}
			$groups = array();
			$t = '';
			$i = 0;
			foreach ($options as $key => $value) {
				if($value['type_options'] != '') {
					if(strpos($value['type_options'], '=')) {
						$roo = explode(',', $value['type_options']);
						$ro = array();
						foreach ($roo as $v) {
							$a = explode('=', $v);
							$ro[$a[0]] = $a[1];
						}
						$options[$key]['type_options'] = $ro;
					} else {
						$roo = explode(',', $value['type_options']);
						$ro = array();
						foreach ($roo as $v) {
							$ro[$v] = $v;
						}
						$options[$key]['type_options'] = $ro;
					}
					
				}
			}
			$a = 0;
			foreach ($options as $key => $value) {
				if($t == '') {
					$t = 0;
				}
				if($t != $value['indu_cat']) {
					$t = $value['indu_cat'];
					$groups[$t][$a] = $options[$key];
					$i++;
					$a++;
				} else {
					$groups[$t][$a] = $options[$key];
					$a++;
				}
			}
			// $listname = $name['name'];
			if($name['category']['interval_type'] == 1) {
			$curTimArr = end($name['pasttimes']);
			$notyet = $this->checklist->check_checklist($id,date('Y-m-d'),$curTimArr);
			$name['notyet'] = $notyet;	
			}
			$this->title = __('Checklist', 'checklist') . " {$name['name']}";
			$this->set('list_names', $this->checklist->get_list_names());
			$this->set('cats', $this->cats_options);
			$this->set('options', $options);
			$this->set('groups', $groups);
			$this->set('option_types', $this->option_types);
			// $this->set('notyet', $notyet);
			$this->set('checklists', $checklists);
			$this->set('listname', $name);
			$this->set('user', $users);
			if(!empty($this->data) && empty($name['notyet']) && !empty($name['pasttimes'])) {
				$empty = array_map('trim', $this->data['data_checklist']); 
				$empty = array_filter($empty);
				// $empty = array();
				$this->data['created'] = date('Y-m-d H:i');
				$this->data['created_user'] = $this->user['id'];
				$this->data['updated'] = date('Y-m-d H:i');
				$this->data['updated_user'] = $this->user['id'];
				$this->data['data_date'] = date('Y-m-d');
				$this->data['data_time'] = date('H:i');
				if($name['category']['interval_type'] == 1){
					$this->data['data_interval'] = end($name['pasttimes']);
				} else {
					$this->data['data_interval'] = $name['category']['interval_type'];
				}
				$this->data['data_checklist'] = json_encode($this->data['data_checklist']);
				$this->data['checklist_name_id'] = $id;
				if(!empty($empty)) {
					$ch = $this->checklist->save($this->data);
				} else {
					$ch = 0;
				}
				
				if($ch > 0) {
					Message::flash(__("Checklist",'checklist')." {$listname} ".__("added",'checklist'));
					$this->admin_redirect('checklist/add-to-list/');
				} else {
					Message::flash(__('Could not add checklist','checklist')." {$listname}",'error');
				}
			}
		} else {
			$this->title = __('Checklist', 'checklist');		
			$list_datas = array();
			$pasttimes = array_reverse($pasttimes);
			$limit = $settings['dashboard_limit'];
			foreach ($listnames as $key => $value) {
				// Checklist interval_type is for time
				if($listnames[$key]['interval_type'] == 1) {
					$i = 0;
					$curTimArr =$value['pasttimes'][0];
					$listnames[$key]['current'] = $curTimArr;
					$listnames[$key]['notyet'] = $this->checklist->check_checklist($value['id'],date('Y-m-d'),$curTimArr);
					$checklists = $this->checklist->get_checklists_simple($value['id'],date('Y-m-d'),array($current_shift['shift_start'],$current_shift['shift_end']));
					foreach ($value['pasttimes'] as $k => $val) {
						if($i == $limit) {
							break;
						}
						foreach ($checklists as $lists) {
							if($lists['data_interval'] == $val) {
								$listnames[$key]['listdata'][$k] = $lists;
								$listnames[$key]['listdata'][$k]['added'] = 1;
							}
						}
						if(!isset($listnames[$key]['listdata'][$k])) {
							$listnames[$key]['listdata'][$k]['data_interval'] = $val;
							$listnames[$key]['listdata'][$k]['added'] = 0;
						}
						$i++;
					}
				// Checklist interval_type is for count
				} else {
					$checklists = $this->checklist->get_checklists_simple($value['id'],date('Y-m-d'),array($current_shift['shift_start'],$current_shift['shift_end']));
					// For count type
					$checklists = array_reverse($checklists);
					$listnames[$key]['list-added-count'] = count($checklists);
					if($listnames[$key]['list-added-count'] < $listnames[$key]['count']) {
						$listnames[$key]['list-remain-count'] = $listnames[$key]['count'] - $listnames[$key]['list-added-count'];
						$listnames[$key]['notyet'] = 0;
					} else {
						$listnames[$key]['list-remain-count'] = 0;
						$listnames[$key]['notyet'] = 1;
					}
					$i = 1;
					$e = count($checklists);
					foreach ($checklists as $k => $lists) {
						if($i == $limit) {
							break;
						}
						$lists['data_interval'] =$e;
						$listnames[$key]['listdata'][$k] = $lists;
						$listnames[$key]['listdata'][$k]['added'] = 1;
						$i++;
						$e--;
					}
				}				
				// 
			}
			$this->set('listnames', $listnames);
			$this->set('futuretimes',$futuretimes);
		}
	}

	public function admin_view_list($get = NULL){
		$curr_date = date('Y-m-d');
		$get = explode('/', $get);
		if(isset($get[1]) && $get[1] == '') {
			$get[1] = date('Y-m-d');
		}
		$current_time = date('H:i');
		$name = $this->checklist->get_list_name($get[0]);
		$shifts = $this->checklist->get_checklist_shifts();
		$current_shift = $this->checklist->get_checklist_current_shift($current_time);
		// $check_curr_shift = explode('-', $current_shift);
		// print_r($current_shift);
		if(!empty($name)) {
			$category = $this->checklist->get_list_cat($name['category']);
			$name['category'] = $category;
			if($name['no_options'] != ''){
				$options = $this->checklist->get_list_options($name['category']['id'], $name['no_options']);
			} else {
				$options = $this->checklist->get_list_options($name['category']['id']);
			}
			
			$name['category']['interval_data'] = json_decode($name['category']['interval_data'],true);
			$name['shift'] = $name['category']['interval_data'][$current_shift['id']];
			$name['all_shifts'] = $shifts;
			$user_ids = $this->checklist->get_all_user_ids_from_lists($get[1]);
			$users = $this->checklist->get_app_users($user_ids);
			$settings = $this->checklist->get_checklist_settings();
			$time_array = array();
			if(isset($name['shift'])) {
				$time_array = explode(',', $name['shift']);
			}
			$pasttimes = array();
			$currentTime = date('H:i');
			$i = 0;
			if(!empty($time_array)) {
				foreach ($time_array as $value) {
					// Dirty hack fix later
					if($current_shift['shift_start'] > $current_shift['shift_end']) {
						if($value == '00:00') {
							$value = '24:00';
						}
					} 
					if($currentTime >= $value) {
						$pasttimes[$i] = $value;
						$i++;
					}

				}
			}
			if($name['category']['interval_type'] == 1) {

			}
			if($curr_date != $get[1]) {
				$pasttimes = $time_array;
			}
			$curTimArr = end($pasttimes);
			
			foreach ($options as $key => $value) {
				if($value['type_options'] != '') {
					if(strpos($value['type_options'], '=')) {
						$roo = explode(',', $value['type_options']);
						$ro = array();
						foreach ($roo as $v) {
							$a = explode('=', $v);
							$ro[$a[0]] = $a[1];
						}
						$options[$key]['type_options'] = $ro;
					} else {
						$roo = explode(',', $value['type_options']);
						$ro = array();
						foreach ($roo as $v) {
							$ro[$v] = $v;
						}
						$options[$key]['type_options'] = $ro;
					}
				}
			}
			$listname = $name['name'];	
			$checklists = $this->checklist->get_checklists($get[0],$get[1],array($current_shift['shift_start'],$current_shift['shift_end']));
			if($name['category']['interval_type'] == 1) {
				foreach ($checklists as $key => $value) {
				$now = time();
				$when = strtotime('+'.$settings['time_to_edit'].' minutes', strtotime($value['created']));
				if($when > $now) {
					$checklists[$key]['can_edit'] = 1;
				} else {
					$checklists[$key]['can_edit'] = 0;
				}
				}
			} else {

			}
			foreach ($checklists as $key => $value) {
				$now = time();
				$when = strtotime('+'.$settings['time_to_edit'].' minutes', strtotime($value['created']));
				if($when > $now) {
					$checklists[$key]['can_edit'] = 1;
				} else {
					$checklists[$key]['can_edit'] = 0;
				}
			}


			$this->set('list_names', $this->checklist->get_list_names());
			$this->set('cats', $this->cats_options);
			$this->set('options', $options);
			$this->set('option_types', $this->option_types);
			$this->set('user', $users);
			$this->set('checklists', $checklists);
			$this->set('pasttimes', $pasttimes);
			$this->set('listname', $name);
			$this->set('category', $category);
			$this->set('page',$get);
		}
	}

	public function admin_manage_list($get = NULL){
		$curr_date = date('Y-m-d');
		$get = explode('/', $get);
		if(isset($get[1]) && $get[1] == '') {
			$get[1] = date('Y-m-d');
		}
		$names_options = array();
		$user_deps = $this->checklist->get_departments($this->user['department']['department_id']);
		// $names = $this->checklist->get_list_names();
		if(!empty($user_deps)) {
			$names = $this->checklist->get_list_names_from_ids($user_deps['checklist_name_ids']);
			foreach ($names as $key => $value) {
				$names_options[$value['id']] = $value['name'];
			}
		}
		
		$this->set('names_options', $names_options);
		if(isset($user_deps['checklist_name_ids'])) {
			$user_deps_arr = explode(',', $user_deps['checklist_name_ids']);
		} else {
			$user_deps_arr = array();
		}
		
		if(in_array($get[0], $user_deps_arr)) {
			$name = $this->checklist->get_list_name($get[0]);
		} else {
			$name = array();
		}
		
		if(!empty($name)) {
			$category = $this->checklist->get_list_cat($name['category']);
			$user_ids = $this->checklist->get_all_user_ids_from_lists($get[1]);
			$users = $this->checklist->get_app_users($user_ids);
			$settings = $this->checklist->get_checklist_settings();
			$time_array = array();
			if(isset($settings['time_array'])) {
				$time_array = explode(',', $settings['time_array']);
			}
			$pasttimes = array();
			$currentTime = date('H:i');
			$i = 0;
			if(!empty($time_array)) {
				foreach ($time_array as $value) {
					if($currentTime >= $value) {
						$pasttimes[$i] = $value;
						$i++;
					}
				}
			}
			if($curr_date != $get[1]) {
				$pasttimes = $time_array;
			}
			$curTimArr = end($pasttimes);
			$options = $this->checklist->get_list_options($name['category']);
			foreach ($options as $key => $value) {
				if($value['type_options'] != '') {
					if(strpos($value['type_options'], '=')) {
						$roo = explode(',', $value['type_options']);
						$ro = array();
						foreach ($roo as $v) {
							$a = explode('=', $v);
							$ro[$a[0]] = $a[1];
						}
						$options[$key]['type_options'] = $ro;
					} else {
						$roo = explode(',', $value['type_options']);
						$ro = array();
						foreach ($roo as $v) {
							$ro[$v] = $v;
						}
						$options[$key]['type_options'] = $ro;
					}
					
				}
			}
			$listname = $name['name'];
			
			$checklists = $this->checklist->get_checklists($get[0],$get[1]);

			$listdata = array();
			$t = count($pasttimes);
			$i = 1;
			

			foreach ($checklists as $key => $value) {
				$now = time();
				$when = strtotime('+'.$settings['time_to_edit'].' minutes', strtotime($value['created']));
				if($when > $now) {
					$checklists[$key]['can_edit'] = 1;
				} else {
					$checklists[$key]['can_edit'] = 0;
				}
			}

			foreach ($pasttimes as $key => $value) {
				foreach ($checklists as $lists) {
					if($lists['data_interval'] == $value) {
						$listdata[$key] = $lists;
						$listdata[$key]['data_checklist'] = json_decode($lists['data_checklist'], true);
						$listdata[$key]['added'] = 1;
					}
				}
				if(!isset($listdata[$key])) {
					$listdata[$key]['data_interval'] = $value;
					$listdata[$key]['added'] = 0;
					if($i == $t && date('Y-m-d') == $get[1]) {
						$listdata[$key]['locked'] = $this->checklist->check_checklist($get[0],date('Y-m-d'),$value);;
					} else {
						$listdata[$key]['locked'] = 1;
					}
				}
				$i++;
			}
			$this->set('list_names', $this->checklist->get_list_names());
			$this->set('cats', $this->cats_options);
			$this->set('options', $options);
			$this->set('option_types', $this->option_types);
			$this->set('user', $users);
			$this->set('checklists', $checklists);
			$this->set('pasttimes', $pasttimes);
			$this->set('listname', $name);
			$this->set('category', $category);
			$this->set('page',$get);
			$this->set('listdata',$listdata);

		}
	}
////
	public function admin_edit_list($id = NULL){
		if($id != NULL) {
			$allow_save = false;
			$checklist = $this->checklist->get_checklists_from_id($id);
			$name = $this->checklist->get_list_name($checklist['checklist_name_id']);
			$options = $this->checklist->get_list_options($name['category']);
			foreach ($options as $key => $value) {
				if($value['type_options'] != '') {
					if(strpos($value['type_options'], '=')) {
						$roo = explode(',', $value['type_options']);
						$ro = array();
						foreach ($roo as $v) {
							$a = explode('=', $v);
							$ro[$a[0]] = $a[1];
						}
						$options[$key]['type_options'] = $ro;
					} else {
						$roo = explode(',', $value['type_options']);
						$ro = array();
						foreach ($roo as $v) {
							$ro[$v] = $v;
						}
						$options[$key]['type_options'] = $ro;
					}
					
				}
			}
			$groups = array();
			$t = '';
			$i = 0;
			$a = 0;
			foreach ($options as $key => $value) {
				if($t == '') {
					$t = 0;
				}
				if($t != $value['indu_cat']) {
					$t = $value['indu_cat'];
					$groups[$t][$a] = $options[$key];
					$i++;
					$a++;
				} else {
					$groups[$t][$a] = $options[$key];
					$a++;
				}
			}
			$checklist['data_checklist'] = json_decode($checklist['data_checklist'], true);
			$settings = $this->checklist->get_checklist_settings();
			$listname = $name['name'];
			$now = time();
			$when = strtotime('+'.$settings['time_to_edit'].' minutes', strtotime($checklist['created']));
			if($when > $now || $checklist['manage_open'] > 0) {
				$this->set('checklist',$checklist);
				$allow_save = true;
			} else {
				$this->set('checklist',array());
			}
			$this->set('name',$name);
			$this->set('options',$options);
			$this->set('groups',$groups);
			$this->set('option_types', $this->option_types);
			if($allow_save && !empty($this->data)) {
				$empty = array_map('trim', $this->data['data_checklist']); 
				$empty = array_filter($empty);
				$this->checklist->id = $id;
				$this->data['data_checklist'] = json_encode($this->data['data_checklist']);
				$this->data['updated_user'] = $this->user['id'];
				$this->data['updated'] = date('Y-m-d H:i');
				$this->data['manage_open'] = 0;
				if(!empty($empty)) {
					$ch = $this->checklist->save($this->data);
				} else {
					$ch = 0;
				}
				
				if($ch > 0) {
					Message::flash(__("Checklist",'checklist')." {$listname} ".__("updated",'checklist'));
					$this->admin_redirect('checklist/view-list/'.$checklist['checklist_name_id'].'/'.$checklist['data_date'].'/');
				} else {
					Message::flash(__('Could not update checklist','checklist')." {$listname}",'error');
				}
			}
		}

	}

	public function admin_create_list_name(){
		$this->title = __('List name', 'checklist');
		$this->set('list_names', $this->checklist->get_list_names());
		$i = 1;
		$ni = 1;
		foreach ( $this->cats_options as $key => $value ) {
			if ($i == 1) { 
				$ni = $key;
			}
			$i++;
		}
		$this->set('options', $this->checklist->get_list_options($ni));
		$this->set('cat_options', $this->cats_options);
		if(!empty($this->data)) {
			if(isset($this->data['no_options'])) {
				$this->data['no_options'] = implode(',', $this->data['no_options']);
			}

			if(isset($this->data['function'])) {
				$this->data['no_options'] = '';
				$this->data['category'] = $this->data['category-radio'];
			} else {
				$this->data['name_functions'] = '';
				$this->data['function_selection'] = '';
			}
			
			$req = $this->required_data('name');
			if(empty($req)) {
				$this->loadmodel('checklist_name');
				$ch = $this->checklist_name->save($this->data);
				if($ch > 0) {
					Message::flash(__('Listname added','checklist'));
				} else {
					Message::flash(__('Could not add listname','checklist'),'error');
				}
			} else {
				Message::flash(__('List name is required!','checklist'),'error');
			}
			
			$this->admin_redirect('checklist/create-list-name/');
		}
	}

		public function admin_edit_list_name($id = NULL){
		$this->title = __('List name', 'checklist');
		$list_name = $this->checklist->get_list_name($id);
		$list_name['no_options'] = explode(',', $list_name['no_options']);
		$this->set('options', $this->checklist->get_list_options($list_name['category']));
		$this->set('list_name', $list_name);
		$this->set('cat_options', $this->cats_options);
		if(!empty($this->data)) {
			$this->data['no_options'] = implode(',', $this->data['no_options']);
			$req = $this->required_data('name');
			if(empty($req)) {
				$this->loadmodel('checklist_name');
				$this->checklist_name->id = $id;
				$ch = $this->checklist_name->save($this->data);
				if($ch > 0) {
					Message::flash(__('Listname added','checklist'));
				} else {
					Message::flash(__('Could not add listname','checklist'),'error');
				}
			} else {
				Message::flash(__('List name is required!','checklist'),'error');
			}
			
			$this->admin_redirect('checklist/create-list-name/');
		}
	}

	public function admin_create_list_options($id = NULL){
		if($id == NULL) {
			$this->title = __('Create list options', 'checklist');
		} else {
			$id = rtrim($id,'/');
			if(isset($this->cats_options[$id])) {
				$this->title = __('Create list options for', 'checklist').' '.$this->cats_options[$id];
			}
		}
		$options = $this->checklist->get_list_options($id);
		$options_arr = array();
		foreach ($options as $value) {
			$options_arr[$value['id']] = $value['name'].' <small>'.$value['info'].'</small>';
		}
		$this->set('options_arr', $options_arr);
		$this->set('list_options', $options);
		$this->set('cat_options', $this->cats_options);
		$this->set('option_types', $this->option_types);
		$this->set('options', $options);
		$this->set('id', $id);
		if(!empty($this->data)) {
			$this->data['category'] = $id;
			$this->required_data('name');
			$this->loadmodel('checklist_options');
			if(isset($this->data['is_required'])) {
				$this->data['is_required'] = 1;
			} else {
				$this->data['is_required'] = 0;
			}
			
			$ch = $this->checklist_options->save($this->data);
			if($ch > 0) {
				Message::flash(__('List option added','checklist'));
			} else {
				Message::flash(__('Could not add list option','checklist'),'error');
			}
			// print_r($this->data);
			$this->admin_redirect('checklist/create-list-options/'.$id);
		}
	}

	public function admin_edit_list_options($id = NULL){
		if($id == NULL) {
			$this->title = __('Create list options', 'checklist');
		} else {
			$id = rtrim($id,'/');
			if(isset($this->cats_options[$id])) {
				$this->title = __('Create list options for', 'checklist').' '.$this->cats_options[$id];
			}
		}
		$options = $this->checklist->get_list_option($id);
		if($options['link_type'] != 0) {
			if($options['link_type'] == 1) {
				$opts = $this->checklist->get_list_options_to_option($options['category'],8);
			} else {
				$opts = $this->checklist->get_list_options_to_option($options['category']);
			}
		} else {
			$opts = array();
		}
		$opts_arr = array();
		if(!empty($opts)) {
			foreach ($opts as $value) {
				$opts_arr[$value['id']] = $value['name'].' '.$value['info'];
			}
		}
		// custom post type
		$this->set('cat_options', $this->cats_options);
		$this->set('option_types', $this->option_types);
		$this->set('link_option', $opts_arr);
		$this->set('options', $options);
		$this->set('id', $id);
		if(!empty($this->data) && !empty($options)) {
			$this->required_data('name');
			$this->loadmodel('checklist_options');
			if(isset($this->data['is_required'])) {
				$this->data['is_required'] = 1;
			} else {
				$this->data['is_required'] = 0;
			}
			$this->checklist_options->id = $id;
			$ch = $this->checklist_options->save($this->data);
			if($ch > 0) {
				Message::flash(__('List option updated','checklist'));
			} else {
				Message::flash(__('Nothing updated','checklist'),'error');
			}
			// print_r($this->data);
			$this->admin_redirect('checklist/create-list-options/'.$options['category']);
		}
	}

	public function admin_create_list_category(){
		$this->title = __('Create list options', 'checklist');
		$this->cats_interval_types;
		$shifts = $this->checklist->get_checklist_shifts();
		$this->set('cats_interval_types', $this->cats_interval_types);
		$this->set('list_cats', $this->checklist->get_list_cat());
		$this->set('shifts', $shifts);
		if(!empty($this->data)) {
			$this->required_data('name');
			$this->loadmodel('checklist_options_cat');
			$this->data['interval_data'] = json_encode($this->data['shifts']);
			$ch = $this->checklist_options_cat->save($this->data);
			if($ch > 0) {
				Message::flash(__('Category added','checklist'));
			} else {
				Message::flash(__('Could not add category','checklist'),'error');
			}
			$this->admin_redirect('checklist/create-list-category/');
		}
	}

	public function admin_edit_list_category($id){
		$this->title = __('Edit list options', 'checklist');
		$this->cats_interval_types;
		$shifts = $this->checklist->get_checklist_shifts();
		$this->set('cats_interval_types', $this->cats_interval_types);
		$this->set('list_cat', $this->checklist->get_list_cat($id));
		$this->set('shifts', $shifts);
		if(!empty($this->data)) {
			$this->required_data('name');
			$this->loadmodel('checklist_options_cat');
			$this->checklist_options_cat->id = $id;
			$this->data['interval_data'] = json_encode($this->data['shifts']);
			$ch = $this->checklist_options_cat->save($this->data);
			if($ch > 0) {
				Message::flash(__('Category added','checklist'));
			} else {
				Message::flash(__('Could not add category','checklist'),'error');
			}
			$this->admin_redirect('checklist/create-list-category/');
		}
	}

	public function admin_create_department(){
		$this->title = __('Create department', 'checklist');
		$this->set('departments', $this->checklist->get_departments());
		$checklistnames = $this->checklist->get_list_names(); 
		
		$checklistnamesoptions = array();
		if(!empty($checklistnames)) {
			foreach ($checklistnames as $key => $value) {
				$checklistnames[$key]['category-name'] = $this->cats_options[$value['category']];
				$checklistnamesoptions[$value['id']] = $value['name'];
			}
		} 
		$this->set('checklistnames',$checklistnames);
		$this->set('checklistnamesoptions',$checklistnamesoptions);
		if(!empty($this->data)) {
			if(isset($this->data['checklist_name_ids'])) {
				$this->data['checklist_name_ids'] = implode(',',$this->data['checklist_name_ids']);
			} else {
				$this->data['checklist_name_ids'] = '';
			}
			$this->required_data('name,checklist_name_ids');
			$this->loadmodel('checklist_department');
			$ch = $this->checklist_department->save($this->data);
			if($ch > 0) {
				Message::flash(__('Departments added','checklist'));
			} else {
				Message::flash(__('Nothing added','checklist'),'error');
			}
			$this->admin_redirect('checklist/create-department/');
		}
	}

	public function admin_edit_department($id) {
		$deps = $this->checklist->get_departments($id);
		$checklistnames = $this->checklist->get_list_names();
		$checklistnamesoptions = array();
		if(!empty($checklistnames)) {
			foreach ($checklistnames as $key => $value) {
				$checklistnames[$key]['category-name'] = $this->cats_options[$value['category']];
				$checklistnamesoptions[$value['id']] = $value['name'];
			}
		}
		$this->set('checklistnamesoptions',$checklistnamesoptions);
		$this->set('checklistnames',$checklistnames);
		$this->set('departments',$deps);
		if(!empty($this->data)) {
			if(isset($this->data['checklist_name_ids'])) {
				$this->data['checklist_name_ids'] = implode(',',$this->data['checklist_name_ids']);
			} else {
				$this->data['checklist_name_ids'] = '';
			}
			$this->required_data('name,checklist_name_ids');
			$this->loadmodel('checklist_department');
			$this->checklist_department->id = $id;
			$ch = $this->checklist_department->save($this->data);
			if($ch > 0) {
				Message::flash(__('Departments updated','checklist'));
			} else {
				Message::flash(__('Nothing updated','checklist'),'error');
			}
			$this->admin_redirect('checklist/create-department/');
		}
	}

	public function admin_department_users(){
		$this->title = __('Link users to Department','fuel_inventory');
		$this->loadmodel('users');
		$Users = $this->users->get_all_users($this->user['role_level']);		
		$departments = $this->checklist->get_departments();
		$sites_user_relation = $this->checklist->get_user_department();
		$user_relation = array();
		if(!empty($sites_user_relation)) {
			foreach ($sites_user_relation as $value) {
				$user_relation[$value['user_id']] = $value['department_id'];
			}
		}
		$departments_arr = array();
		foreach ($departments as $value) {
			$departments_arr[$value['id']] = $value['name'];
		}
		foreach ($Users as $key => $value) {
			if(isset($user_relation[$value['id']]) && isset($departments_arr[$user_relation[$value['id']]])) {
				$Users[$key]['gas_station'] = $user_relation[$value['id']];
				$Users[$key]['gas_station_name'] = $departments_arr[$user_relation[$value['id']]];
			}
		}
		$this->set('Users', $Users);
		$this->set('Sites', $departments_arr);
	}

	public function rest_get_list_options_html(){
		$option = "";
		$data = array();
		if(!empty($this->data)) {
			if($this->data['link_type'] == 1) {
				$options = $this->checklist->get_list_options_to_option($this->data['cat'],8);
			} else if($this->data['link_type'] == 0) {
				$option = "";
			} else {
				$options = $this->checklist->get_list_options_to_option($this->data['cat']);
			}
			if(isset($options)) {
				foreach ($options as $key => $value) {
				$option .= '<option value="'.$value['id'].'">'.$value['name'].' '.$value['info'].'</option>'."\n";
				}
			}
		}
		$data['option'] = $option;
		echo json_encode($data);
	}

	public function rest_get_list_options_array(){

		$data = array();
		$option = array();
		$dt_c = '';
		$dt_r = '';
		if(!empty($this->data)) {
			$options = $this->checklist->get_list_options($this->data['cat']);
			if(isset($options) && !empty($options)) {
				foreach ($options as $key => $value) {
				$option[$value['id']] = $value['name'].' '.$value['info'];
				$dt_c .= '<span class="checklist-wells">';
				$dt_c .= '<input class="flat" type="checkbox" name="data[no_options][]" id="inp-'.$value['id'].'" value="'.$value['id'].'">';
				$dt_c .= ' <label for="inp-'.$value['id'].'">'.$value['name'].' '.$value['info'].'</label>';
				$dt_c .= '</span>';
				$dt_r .= '<span class="checklist-wells">';
				$dt_r .= '<input class="flat" type="radio" name="data[options]" id="inp-'.$value['id'].'" value="'.$value['id'].'">';
				$dt_r .= ' <label for="inp-'.$value['id'].'">'.$value['name'].' '.$value['info'].'</label>';
				$dt_r .= '</span>';
				}
			}
			
		}
		$data['option'] = $option;
		$data['dt_c'] = $dt_c;
		$data['dt_r'] = $dt_r;
		echo json_encode($data);
	}

	public function rest_copy_options_json(){
		$data = array();
		if(!empty($this->data)) {
			$options = $this->checklist->get_list_options($this->data['copy-cat']);
			$this->loadmodel('checklist_options');
			foreach ($options as $key => $value) {
				unset($value['id']);
				$value['category'] = $this->data['cat'];
				$ch = $this->checklist_options->save($value);
			}
			
			if($ch > 0) {
				Message::flash(__('Options added','checklist'));
			} else {
				Message::flash(__('Nothing added','checklist'), 'error');
			}
		} else {
	
		}
		echo json_encode($data);
	}

	public function rest_copy_selected_options_json(){
		$data = array();
		if(!empty($this->data)) {
			$this->loadmodel('checklist_options');
			foreach ($this->data['ids'] as $value) {
				$option = $this->checklist->get_list_option($value);
				$name = explode('-', $option['name']);
				$gn = $option['name'];
				$n = 2;
				if(end($name) != $name[0]){
					if(is_numeric (end($name))){
						$n = (int)end($name);
						if($n<2){
							$n = 2;
						} else {
							$n = $n+1;
						}
						$gn = str_replace(array('-'.end($name),'- '.end($name)), '', $gn);
					}
				}
				unset($option['id']);
				for ($i=0; $i < $this->data['times'] ; $i++) { 
					if($n<10) {
						$ngn = $gn.'-0'.$n;
					} else {
						$ngn = $gn.'-'.$n;
					}
					$option['name'] = $ngn;
					$ch = $this->checklist_options->save($option);
					$n++;
				}
			}
			if($ch > 0) {
				$data['msg'] = 'success';
				Message::flash(__('Options added','checklist'));
			} else {
				$data['msg'] = 'failed';
				Message::flash(__('Nothing added','checklist'), 'error');
			}
		} else {
	
		}
		echo json_encode($data);
	}

	public function rest_edit_category_json($id = NULL){
		$data = array();
		if(!empty($this->data) && $id != NULL) {
			$this->loadmodel('checklist_options_cat');
			$this->checklist_options_cat->id = $id;
			$ch = $this->checklist_options_cat->save($this->data);
			if($ch > 0) {
				Message::flash(__('Category updated','checklist'));
			} else {
				Message::flash(__('Nothing updated','checklist'), 'error');
			}
		} else {
			$data['message'] = 'no data or id';
		}
		echo json_encode($data);
	}

	public function rest_delete_category_json(){
		$data = array();
		if(isset($this->data['id'])) {
			$ch = $this->checklist->delete_data('checklist_options_cat',$this->data['id']);
			if($ch > 0) {
				Message::flash(__('Category deleted','checklist'));
			} else {
				Message::flash(__('Nothing deleted','checklist'), 'error');
			}
		} else {
			$data['message'] = 'no data or id';
		}
		echo json_encode($data);
	}

	public function rest_edit_name_json($id = NULL){
		$data = array();
		if(!empty($this->data) && $id != NULL) {
			$this->loadmodel('checklist_name');
			$this->checklist_name->id = $id;
			$ch = $this->checklist_name->save($this->data);
			if($ch > 0) {
				Message::flash(__('Category name updated','checklist'));
			} else {
				Message::flash(__('Nothing updated','checklist'), 'error');
			}
		} else {
			$data['message'] = 'no data or id';
		}
		echo json_encode($data);
	}

	public function rest_delete_name_json(){
		$data = array();
		if(isset($this->data['id'])) {
			$ch = $this->checklist->delete_data('checklist_name',$this->data['id']);
			if($ch > 0) {
				Message::flash(__('Checklist name deleted','checklist'));
				$data['message'] = 'Done';
			} else {
				Message::flash(__('Nothing deleted','checklist'), 'error');
				$data['message'] = 'Nope';
			}
		} 
		echo json_encode($data);
	}

	public function rest_edit_option_json($id = NULL){
		$data = array();
		if(!empty($this->data) && $id != NULL) {
			$this->loadmodel('checklist_options');
			$this->checklist_options->id = $id;
			$ch = $this->checklist_options->save($this->data);
			if($ch > 0) {
				Message::flash(__('Category option updated','checklist'));
			} else {
				Message::flash(__('Nothing updated','checklist'), 'error');
			}
		} else {
			$data['message'] = 'no data or id';
		}
		echo json_encode($data);
	}

	public function rest_delete_option_json(){
		$data = array();
		if(isset($this->data['id'])) {
			$ch = $this->checklist->delete_data('checklist_options',$this->data['id']);
			if($ch > 0) {
				Message::flash(__('Checklist option deleted','checklist'));
				$data['message'] = 'Done';
			} else {
				Message::flash(__('Nothing deleted','checklist'), 'error');
				$data['message'] = 'Nope';
			}
		} 
		echo json_encode($data);
	}

	public function rest_manage_open_list_json(){
		if(!empty($this->data)) {
			$data = array();
			if(isset($this->data['id'])) {
				$this->checklist->id = $this->data['id'];
				$this->data['manage_open'] = 1;
				$this->data['manage_open_user'] = $this->user['id'];
				$ch = $this->checklist->save($this->data);
				if($ch > 0) {
					Message::flash(__('Checklist open','checklist'));
					$data['message'] = 'Done';
				} else {
					Message::flash(__('Could not open the checklist','checklist'), 'error');
					$data['message'] = 'Nope';
				}
			} else {
				$this->data['manage_open'] = 1;
				$this->data['manage_open_user'] = $this->user['id'];
				$this->data['created'] = date('Y-m-d H:i');
				$ch = $this->checklist->save($this->data);
				if($ch > 0) {
					Message::flash(__('Checklist open','checklist'));
					$data['message'] = 'Done';
				} else {
					Message::flash(__('Could not open the checklist','checklist'), 'error');
					$data['message'] = 'Nope';
				}
			}
			echo json_encode($data);
		} 
	}

	public function rest_manage_close_list_json(){
		if(!empty($this->data)) {
			$data = array();
			if(isset($this->data['id'])) {
				$this->checklist->id = $this->data['id'];
				$this->data['manage_open'] = 0;
				$this->data['manage_open_user'] = $this->user['id'];
				$ch = $this->checklist->save($this->data);
				if($ch > 0) {
					Message::flash(__('Checklist open','checklist'));
					$data['message'] = 'Done';
				} else {
					Message::flash(__('Could not open the checklist','checklist'), 'error');
					$data['message'] = 'Nope';
				}
			} 
			echo json_encode($data);
		} 
	}

	public function cron_log_users_out(){
		$this->loadmodel('users');
		$users = $this->users->get_all_users_ids(1000);
		foreach ($users as $key => $value) {
			$this->users->id = $value['user_id'];
			$this->users->save(array('sid' => 1));
		}
	}

	public function cron_mail_list(){
		$settings = $this->checklist->get_checklist_settings();
		$mail = new Mail(true);
		// print_r($settings);
		// Mail settings
		$mail->SMTPDebug = 0;           // Enable verbose debug output use 1, 2, 3 or 0
   		$mail->isSMTP();                // Set mailer to use SMTP
    	$mail->Host = $settings['email_smtp'];  		// Specify main and backup SMTP servers e24.ehosts.com
    	$mail->SMTPAuth = true;         // Enable SMTP authentication
    	$mail->Username = $settings['email_address'];   	// SMTP username info@requillo.com
    	$mail->Password = $settings['email_pass']; 		// SMTP password 
    	if($settings['email_security'] == 'none'){
	    	$mail->SMTPSecure = false;	// Enable TLS encryption, `ssl` also accepted
	    	// This fixes the bug for no Encryption security
	    	$mail->SMTPOptions = array(
	    		'ssl' => array(
	       		'verify_peer' => false,
	       		'verify_peer_name' => false,
	       		'allow_self_signed' => true
	    		)
	    	);							  
    	} else {
    		$mail->SMTPSecure = $settings['email_security'];
    	}            
    	$mail->Port = $settings['email_port'];
    	$mail->setFrom($settings['email_address']);
    	// END Mail settings
    	$sent_to = explode(',', $settings['email_sent_to']);
    	$hi_reason = __('Daily checklists','checklist'); 
		
		foreach ($sent_to as $value) { 
		// Reset all recipient;
		$mail->ClearAddresses();
		// Add a recipient
		$mail->addAddress($value);
		$mail->isHTML(true);
		$mail->Subject = $hi_reason;
		$html_data = $this->set_html_mail();
		$mail->Body = $html_data;
		$mail->send();
		}	
	}

	public function set_html_mail(){
		$settings = $this->checklist->get_checklist_settings();
		$date = date('Y-m-d');
		$time_array = array();
		if(isset($settings['time_array'])) {
			$time_array = explode(',', $settings['time_array']);
		}
		$this->title = __('Checklist', 'checklist');
		$listnames = $this->checklist->get_list_names();
		$list_datas = array();
		$limit = $settings['dashboard_limit'];
		foreach ($listnames as $key => $value) {
			$opt = array();
			foreach ($this->checklist->get_list_options($value['category']) as $va) {
				$opt[$va['id']] = $va;
			}
			$listnames[$key]['options'] = $opt;
			$listnames[$key]['category'] = $this->checklist->get_list_cat($value['category']);
			$checklists = $this->checklist->get_checklists($value['id'],$date);
			foreach ($time_array as $k => $val) {
				foreach ($checklists as $lists) {
					if($lists['data_interval'] == $val) {
						$listnames[$key]['listdata'][$k] = $lists;
						$listnames[$key]['listdata'][$k]['data_checklist'] = json_decode($lists['data_checklist'], true);
						$listnames[$key]['listdata'][$k]['added'] = 1;
					}
				}
				if(!isset($listnames[$key]['listdata'][$k])) {
					$listnames[$key]['listdata'][$k]['data_interval'] = $val;
					$listnames[$key]['listdata'][$k]['added'] = 0;
				}
				
			}
		}
		$this->set('listnames', $listnames); 
		$res = '';
			foreach ($listnames as $key => $value) {
			$res .= '<div><h2 style="text-align:center">'.__('Checklist','checklist').' '.$value['name'].'</h2>';
			$res .= '<div style="text-align:center;"><b>'.date('d-m-Y', strtotime($date)).'</b></div>';
			$res .= '<table width="100%">';
			$res .= '<thead>';
			$res .= '<tr>';
			$res .= '<th>'.__('Time','checklist').'</th>';
			foreach ($value['options'] as $k => $val) {
				$res .= '<th>' .htmlentities($val['name']). '<div><small>'.htmlentities($val['info']).'</small></div></th>';
			}
			$res .= '</tr>';
			$res .= '</thead>';
			$res .= '<tbody>';
			foreach ($value['listdata'] as $val) {
				
				if($val['added'] == 1) {
					$res .= '<tr style="background:#a9ffb5">';
					$res .= '<td style="text-align:center">'.date('H:i', strtotime($val['data_interval'])).'</td>';
					foreach ($value['options'] as $ke => $va) {
						if( isset($val['data_checklist'][$ke])) { 
							if($val['data_checklist'][$ke] == 'on') {
								$res .= '<td style="text-align:center"><span style="color:#00562f">&#10004;</span></td>';
							} else {
								$res .= '<td style="text-align:center">'.$val['data_checklist'][$ke]. ' ' .htmlentities($va['side_info']).'</td>';
							}
						} else {
							$res .= '<td style="text-align:center"></td>';
						}
					}
				} else{ 
					$res .= '<tr style="background:#ffa500; color:#fff;">';
					$res .= '<td style="text-align:center">'.date('H:i', strtotime($val['data_interval'])).'</td>';
					$ts = count($value['options']);
					foreach ($value['options'] as $ke => $va) {
						$res .= '<td style="text-align:center"><i class="text-success"></i></td>';
					}
				}
				$res .= '</tr>';
			}
			$res .= '</tbody>';
			$res .= '</table>';
			$res .= '<div style="display:inline-block; padding:10px;">';
			$res .= nl2br(htmlentities ($value['category']['info_01']));
			$res .= '</div>';
			$res .= '<div style="display:inline-block; padding:10px;">';
			$res .= nl2br(htmlentities ($value['category']['info_02']));
			$res .= '</div>';
			$res .= '<div style="display:inline-block; padding:10px;">';
			$res .= nl2br(htmlentities ($value['category']['info_03']));
			$res .= '</div>';
			$res .= '</div>';
			}
			return $res;
		}


		public function rest_update_user_relation(){
		$data = array();
		$data['add'] = 'nothing';
		$dd = array();
		if(!empty($this->data)){
			$sites_user_relation = $this->checklist->get_user_department();
			$user_relation = array();
			if(!empty($sites_user_relation)) {
				foreach ($sites_user_relation as $value) {
					$user_relation[$value['user_id']] = $value['id'];
				}
			}
			$this->loadmodel('checklist_users_department');
			if(!empty($this->data['userids'])) {

				foreach ($this->data['userids'] as $value) {
					$dd['user_id'] = $value;
					if($this->data['bulk'] == 1) {
						$dd['department_id'] = $this->data['department_id'];
					} else {
						$dd['department_id'] = 0;
					}
					
					if(isset($user_relation[$value])) {
						$this->checklist_users_department->id = $user_relation[$value];
					} else {
						$this->checklist_users_department->id = NULL;
					}
					$ch = $this->checklist_users_department->save($dd);
				}
			}
			$data['check'] = $ch;
			if($ch > 0) {
				$data['add'] = "success";
			} else {
				$data['add'] = "failed";
			}
		}
		echo json_encode($data);
	}

}