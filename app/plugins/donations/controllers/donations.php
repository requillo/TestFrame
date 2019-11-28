<?php 
/**
* 
*/
class Donations extends Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->donations->pdo = $this->model->pdo ;
		$this->approval = array(0=>__('Disapproved','donations'),1=>__('Approved','donations'),2=>__('Pending','donations'));
		$this->id_types = array(0=>__('None','donations'),1=>__('ID Card','donations'),2=>__('Passport','donations'), 3=>__('Other Identification','donations'));
		$this->applogo = $this->donations->option('meta_text',array('name'=>'settings', 'value' => 'app_logo'));
		$this->appname = $this->donations->option('meta_str', array('name'=>'settings','value'=>'app_name'));
	}

	function rest_api_test(){
		echo json_encode(array("Message" => "All is good"));
	}

	function admin_index(){
		$this->title = __('All Donations','donations');
		// echo $this->appname;
		$lim = $this->donations->get_settings('view_max_results','value');
		$ids = '';
		if(isset($_GET['in']) && $_GET['in'] == 'person') {
			$res = $this->donations->searched_donation_persons($_GET['search']);
			// print_r($res);
			foreach ($res as $value) {
				$ids .= $value['id'] . ',';
			}
			$ids = rtrim($ids,',');
			$donations = $this->donations->get_searched_donations($ids, $this->user);
		} else if(isset($_GET['in']) && $_GET['in'] == 'foundation'){
			$res = $this->donations->searched_donation_foundations($_GET['search']);
			// print_r($res);
			foreach ($res as $value) {
				$ids .= $value['id'] . ',';
			}
			$ids = rtrim($ids,',');
			$donations = $this->donations->get_searched_donations($ids, $this->user);
		} else if(isset($_GET['in']) && $_GET['in'] == 'desc'){
			$donations = $this->donations->get_searched_donations($_GET['search'], $this->user);
			
		} else {
			$donations = $this->donations->get_donations($this->user);
		}
		
		$this->loadmodel('users');
		$donation_types_n = array();
		if(!empty($donations)){
			$donation_types = $this->donations->get_settings('donation_types', 'value');
			$donation_types = explode(',', $donation_types);
			foreach ($donation_types as $value) {
				$value = explode('=', $value);
				$donation_types_n[trim($value[1])] = __(trim($value[0]),'donations');
			}
			foreach ($donations as $key => $value) { // MAIN FOREACH
			$ti = $key;
			$donations[$key]['person-info'] = $this->donations->get_person($value['person_id']);
			$donations[$key]['foundation-info'] = $this->donations->get_foundation($value['foundation_id']);
			$company = $this->users->get_companies($value['donated_company']);
			$donations[$key]['donated_company_name'] = $company['company_name'];

			$xdescar = array();
			$xdesc = explode(',', rtrim($value['extra_description'],','));
			$i = 0;
			$don_desc_data = array();
			if(!empty($xdesc)){
				foreach ($xdesc as $value) {
				$value = explode('-', $value);
					$xdescar[$i]['type'] = $this->donations->get_donation_assets($value[0],'type');
					// echo $xdescar[$i]['type'];
					// echo $donation_types_n[$xdescar[$i]['type']];
					$xdescar[$i]['description'] = $this->donations->get_donation_assets($value[0],'description');
					if(isset($donation_types_n[$xdescar[$i]['type']])) {
						$xdescar[$i]['types'] = $donation_types_n[$xdescar[$i]['type']];
					}
					if(isset($value[2])){
						$xdescar[$i]['price'] = $value[2];
					} else {
						$xdescar[$i]['price'] = '';
					}
					if(isset($value[1])){
						$xdescar[$i]['amount'] = $value[1];
					} else {
						$xdescar[$i]['amount'] = '';
					}
				$i++;
				}
				// $donation['extra_description'] = $xdescar;
					foreach ($xdescar AS $k => $sub_array)
					{

					  $this_level = $sub_array['type'];
					  if($this_level) {
						  	$don_desc_data[$this_level][$k] = array(
						  	'amount' => $sub_array['amount'],
						  	'description' => $sub_array['description'], 
						  	'price' => $sub_array['price'],  
						  	'type' => $sub_array['type'],
						  	'type_name' => $donation_types_n[$sub_array['type']]
						  	);
					  	}
					}
				$don_desc_data = array_values($don_desc_data);
				foreach ($don_desc_data as $key => $value) {
					$don_desc_data[$key] = array_values($don_desc_data[$key]);
				}
			}
			// print_r($don_desc_data);
			$donations[$ti]['don_types'] = $don_desc_data;
			} // END MAIN FOREACH
		}
		// echo $this->donations->paginate($lim,$tot,'donations/');
		$this->set('Donations', $donations);
		$this->set('Approval', $this->approval);
		$this->set('Don_types', $donation_types_n);
		if(isset($_GET['in'])) {
			if($_GET['in'] == 'desc') {
				$tot = $this->donations->get_search_donations_tot($_GET['search'],$this->user);
			} else {
				$tot = $this->donations->get_search_donations_tot($ids,$this->user);
			}
			$this->set('Paginate', $this->donations->paginate($lim,$tot,'donations/',array('search','in')));
		} else {
			$tot = $this->donations->get_donations_tot($this->user);
			$this->set('Paginate', $this->donations->paginate($lim,$tot,'donations/'));
		}
		// print_r($this->user);
	}

	function admin_export($name = NULL) {
		$this->title = __("Export");
		$data = '';
		$area = '';
		$name = rtrim($name,'/');
		$area = $name;
		if(!empty($this->data)) {
			$appoval = $this->data['approval'] ;
			$cat_data = $this->donations->get_donation_cat_data('2-3-1500,5-1-2400,','');
			$this->set('cat_data', $cat_data);
			$this->set('Company_options',$this->donations->get_companies_options($this->data['comp']));
			$dates = explode('=', $this->data['dates']);
			$gd = array(date('Y m d', strtotime($dates[0])),date('Y m d', strtotime($dates[1])));
			$this->set('data', $this->donations->request_donation_data($this->data['dates'],$this->data['comp'],$this->data['approval']));
			$this->set('dates', $gd);
			$this->set('approval',$this->approval);
		} else {
			$gd = array(date('Y m d'),date('Y m d'));
			$this->set('Company_options',$this->donations->get_companies_options());
			$this->set('data', '');
			$this->set('dates', $gd);
			$this->set('approval',$this->approval);
		}
	}

	function admin_blacklisted($id = NULL){
		$id = rtrim($id,'/');
		$this->title = __('All Blacklisted','donations');
		$lim = $this->donations->get_settings('view_max_results','value');
		if($id == 'persons') {
			$persons = $this->donations->get_all_bl_persons($lim);
			$ptot = count($this->donations->get_all_bl_persons());
			$this->set('Paginate', $this->donations->paginate($lim,$ptot,'donations/blacklisted/persons/',array('search','in')));
			$this->set('persons',$persons);
		} else if($id == 'foundations'){
			$foundations = $this->donations->get_all_bl_foundations($lim);
			$ftot = count($this->donations->get_all_bl_foundations());
			$this->set('Paginate', $this->donations->paginate($lim,$ftot,'donations/blacklisted/foundations/',array('search','in')));
			$this->set('foundations',$foundations);
		}
		
	}

	function admin_add_to_blacklist(){
		$this->title = __('Add to blacklist','donations');
		if(!empty($this->data)) {
			if($this->data['add_to_table'] == 'person') {
				$this->loadmodel('donation_persons');
				if(preg_replace('/\s+/', '', $this->data['id_number']) == '') {
					$this->data['id_number'] = 'blacklisted';
				}
				$req = $this->required_data('first_name,last_name,id_number');
				if(empty($req)) {
					$id_number = strtolower($this->data['id_number']);
					$id_number = preg_replace('/\s+/', '', $id_number);
					$this->data['id_number'] = $this->donations->the_person_id($id_number);
					$this->data['status'] = 1;
					$this->data['full_name'] = $this->data['first_name'].' '.$this->data['last_name'];
					$this->data['created'] = date('Y-m-d H:i:s');
					$this->data['created_user'] = $this->user['id'];
					$this->data['updated'] = date('Y-m-d H:i:s');
					$this->data['updated_user'] = $this->user['id'];
					$this->data['black_listed'] = 1;
					$ch = $this->donation_persons->save($this->data);
					if($ch > 0) {
						Message::flash(__('This Donatee is added and blacklisted','donations'));
						$this->admin_redirect('donations/blacklisted/persons/');
					} else {
						Message::flash(__('Nothing to update','donations'),'error');
					}

				} else {
					Message::flash(__('First name, Last name and ID Number is required','donations'),'error');
				}

			} else {
				$this->loadmodel('donation_foundation');
				$this->data['foundation_name'] = strtoupper(strtolower(preg_replace('/\s+/', ' ', $this->data['foundation_name'])));
				$this->data['status'] = 1;
				$this->data['created'] = date('Y-m-d H:i:s');
				$this->data['created_user'] = $this->user['id'];
				$this->data['updated'] = date('Y-m-d H:i:s');
				$this->data['updated_user'] = $this->user['id'];
				$this->data['black_listed'] = 1;
				$ch = $this->donation_foundation->save($this->data);
					if($ch > 0) {
						Message::flash(__('This Company or foundation was added and blacklisted','donations'));
						$this->admin_redirect('donations/blacklisted/foundations/');
					} else {
						Message::flash(__('Nothing to update','donations'),'error');
					}

			}
		}

	}

	function admin_edit_person($id = NULL){
		$this->title = __('Edit person','donations');
		$person = $this->donations->get_person($id);
		$this->set('Person',$person);
		if(!empty($this->data)) {
			$this->loadmodel('donation_persons');
			$this->donation_persons->id = $id;
			$this->data['updated'] = date('Y-m-d H:i:s');
			$this->data['updated_user'] = $this->user['id'];
			$this->data['full_name'] = $this->data['first_name'].' '.$this->data['last_name'];
			$ch = $this->donation_persons->save($this->data);
			if($ch > 0) {
				$data_his = array();
				$person_old = serialize($person);
				$person_new = serialize($this->donations->get_person($id));
				$data_his['donation_table'] = 'donation_persons';
				$data_his['donation_old_data'] = $person_old;
				$data_his['donation_new_data'] = $person_new;
				$data_his['donation_info'] = 'Updated person';
				$data_his['updated'] = date('Y-m-d H:i:s');
				$data_his['updated_user'] = $this->user['id'];
				$data_his['status'] = 1;
				$data_his['ref_id'] = $id;
				$this->loadmodel('donation_history');
				$this->donation_history->save($data_his);
				Message::flash(__('This Donatee is Updated','donations'));
			} else {
				Message::flash(__('Could not update Dontee','donations'),'error');
			}
		$this->admin_redirect('donations/blacklisted/persons/');
		}	
	}

	function admin_view_person($id = NULL){
		$this->title = __('Edit person','donations');
		$person = $this->donations->get_person($id);
		$this->set('Person',$person);
	}

	function admin_edit_foundation($id = NULL){
		$this->title = __('Edit foundation, company etc.','donations');
		$foundation = $this->donations->get_foundation($id);
		$this->set('Foundation',$foundation);
		if(!empty($this->data)) {
			$this->loadmodel('donation_foundation');
			$this->data['updated'] = date('Y-m-d H:i:s');
			$this->data['updated_user'] = $this->user['id'];
			$this->donation_foundation->id = $id;
			$ch = $this->donation_foundation->save($this->data);
			if($ch > 0) {
				$data_his = array();
				$foundation_old = serialize($foundation);
				$foundation_new = serialize($this->donations->get_foundation($id));
				$data_his['donation_table'] = 'donation_foundation';
				$data_his['donation_old_data'] = $foundation_old;
				$data_his['donation_new_data'] = $foundation_new;
				$data_his['donation_info'] = 'Updated Company info';
				$data_his['updated'] = date('Y-m-d H:i:s');
				$data_his['updated_user'] = $this->user['id'];
				$data_his['status'] = 1;
				$data_his['ref_id'] = $id;
				$this->loadmodel('donation_history');
				$this->donation_history->save($data_his);
				Message::flash(__('This foundation, company etc is Updated','donations'));
			} else {
				Message::flash(__('Could not update foundation, company etc','donations'),'error');
			}
		$this->admin_redirect('donations/edit-foundation/'.$id);
		}
	}

	function admin_view_foundation($id = NULL){
		$this->title = __('Edit foundation','donations');
		$person = $this->donations->get_foundation($id);
		$this->set('Person',$person);
	}



	function admin_add_first($id = NULL){
		$this->title = __('Add Donations');
		$go = 1;
		$bl = 0;
		if($id != NULL) {
			$person = $this->donations->get_person($id);
			if(isset($person['id_type'])) {
				$person['the_id_type'] = $this->id_types[$person['id_type']];
			}
			$this->set('Person', $person);
			$this->set('Foundations', $this->donations->get_foundation_relation_data($id));
		} else {
			$this->set('Person', '');
			$this->set('Foundations', '');
		}
		if(!empty($this->data)) {
			$this->loadmodel('donation_persons'); 
			$this->loadmodel('donation_foundation');
			$req = $this->required_data('first_name,last_name,id_number');
			$fid = 0;
			if(isset($this->data['foundation_id'])) {
				$fid = $this->data['foundation_id'];
				$foundation = $this->donations->get_foundation($fid);
			}
			if(isset($this->data['notsame'])) {
				$this->data['overwrite_same'] = 1;
			}
			if($id != NULL) {
				$this->donation_persons->id = $id;
				// unset($this->data[])
			}
			if(isset($person['black_listed']) && $person['black_listed'] == 1) {
				Message::flash(__('Sorry this Donatee is Blacklisted','donations'),'error');
				$go = 0;
				$bl = 1;
			} else if(isset($foundation['black_listed']) && $foundation['black_listed'] == 1) {
				Message::flash(__('Sorry,','donations') . ' ' . $foundation['foundation_name'] .' '. __('is blacklisted!'),'error');
				$go = 0;
				$bl = 1;
			} else if(!empty($req)) {
				Message::flash('Sorry could not add Donatee','error');
				$go = 0;
			} else if($id == NULL) {
				$this->data['first_name'] = ucwords(strtolower(preg_replace('/\s+/', ' ', $this->data['first_name'])));
				$this->data['last_name'] = ucwords(strtolower(preg_replace('/\s+/', ' ', $this->data['last_name'])));
				$this->data['full_name'] = $this->data['first_name'] . ' ' . $this->data['last_name'];
				$this->data['id_number'] = strtolower(preg_replace('/\s+/', '', $this->data['id_number']));
				$this->data['id_number'] = str_replace('_', '', $this->data['id_number']);
				//$document = $this->donations->behavior->upload_protect('scanned_doc',array('size' => 1,'dir' => 'donations/persons'));

				if(strlen($this->data['id_number']) < 9 && $this->data['id_type'] == 1) {
					$go = 0;
					Message::flash('Id number is not valid!','error');
				}

				$this->data['person_telephone'] = strtolower(preg_replace('/\s+/', '', $this->data['person_telephone']));
				$this->data['person_address'] = ucwords(strtolower(preg_replace('/\s+/', ' ', $this->data['person_address'])));
				$this->data['created'] = date('Y-m-d H:i:s');
				$this->data['created_user'] = $this->user['id'];
				$this->data['status'] = 1;
				// $this->data['same_ids'] = $this->data['same'];
				if(empty($this->data['foundation_name']) && empty($this->data['foundation_telephone']) && empty($this->data['foundation_address']) && empty($this->data['foundation_email']) && $go != 0) {
					$id = $this->donation_persons->save($this->data);
				}
				
				if(!empty($this->data['foundation_name']) || !empty($this->data['foundation_telephone']) || !empty($this->data['foundation_address']) || !empty($this->data['foundation_email'])) {
					$freq = $this->required_data('foundation_name');
					// Check if required is empty, do error
					if(!empty($freq)) {
						Message::flash('Sorry name is required!','error');
						$go = 0;
					// add new foundation or oganisation data
					} else if($fid == 0 && empty($freq) && $go != 0) {
						$id = $this->donation_persons->save($this->data);
						$this->data['foundation_name'] = strtoupper(strtolower(preg_replace('/\s+/', ' ', $this->data['foundation_name'])));
						$this->data['created'] = date('Y-m-d H:i:s');
						$this->data['created_user'] = $this->user['id'];
						$this->data['status'] = 1;
						$fid = $this->donation_foundation->save($this->data);
					} else if($fid != 0  && $go != 0){
						$id = $this->donation_persons->save($this->data);
					}
				}
			} else {
				unset($this->data['first_name'],$this->data['last_name'],$this->data['id_number']);
				$this->data['person_telephone'] = strtolower(preg_replace('/\s+/', '', $this->data['person_telephone']));
				$this->data['person_address'] = ucwords(strtolower(preg_replace('/\s+/', ' ', $this->data['person_address'])));
				if(!empty($this->data['foundation_name']) || !empty($this->data['foundation_telephone']) || !empty($this->data['foundation_address']) || !empty($this->data['foundation_email'])) {
					$freq = $this->required_data('foundation_name');
					// Check if required is empty, do error
					if(!empty($freq)) {
						Message::flash('Sorry name is required!','error');
						$go = 0;
					// Add new foundation or oganisation data
					} else if($fid == 0 && empty($freq)) {
						$this->data['foundation_name'] = strtoupper(strtolower(preg_replace('/\s+/', ' ', $this->data['foundation_name'])));
						$this->data['created'] = date('Y-m-d H:i:s');
						$this->data['created_user'] = $this->user['id'];
						$this->data['status'] = 1;
						$id = $this->donation_persons->save($this->data);
						$fid = $this->donation_foundation->save($this->data);
						Message::flash('Check!','error');
					}
				}
			}
			/* if(isset($fid) && $id != ''){
				$this->loadmodel('donation_person_foundation_relations');
				$pfr['person_id'] = $id;
				$pfr['foundation_id'] = $fid;
				$pfr['created'] = date('Y-m-d H:i:s');
				$pfr['created_user'] = $this->user['id'];
				$pfr['status'] = 1;
				$this->donation_person_foundation_relations->save($pfr);
			} */
			// print_r($this->data);
			if($id != '' && $go == 1){
				$id = rtrim($id,'/');
				$this->admin_redirect('donations/add-the-donation/'.$id.'-'.$fid.'/');
			}
		}
		$this->set('blacklist', $bl);
	}

	function admin_add_the_donation($ids = NULL){
		$ids = rtrim($ids,'/');
		$ids = explode('-', $ids);
		$check_rel = $this->donations->check_if_foundation_relation($ids);
		if(empty($check_rel) && $ids[1] != 0) {
			$this->loadmodel('donation_person_foundation_relations');
			$found_data = array();
			$found_data['person_id'] = $ids[0];
			$found_data['foundation_id'] = $ids[1];
			$found_data['created'] = date('Y-m-d H:i:s');
			$found_data['created_user'] = $this->user['id'];
			$found_data['status'] = 1;
			$this->donation_person_foundation_relations->save($found_data);
		}
		$this->title = __('Donations information','donations');
		$Person = $this->donations->get_person($ids[0]);
		$Foundation = $this->donations->get_foundation($ids[1]);
		$this->set('Person', $Person);
		$this->set('Foundation', $Foundation);
		$this->set('Company_assets', $this->donations->get_company_assets($this->user['user_company']));
		$this->set('Company_options',$this->donations->get_companies_options());
		$this->set('Donation_types',$this->donations->get_all_donation_types());
		$add = 0;
		$tp = 0;
		$check_donations = $this->donations->check_donations_within_years($ids);
		$check_donations_approved = $this->donations->check_donations_within_years_approved($ids);
		$check_donations_pending = $this->donations->check_donations_within_years_pending($ids);
		$check_month_donations = $this->donations->check_donations_within_months($check_donations);
		$check_month_donations_approved = $this->donations->check_donations_within_months($check_donations_approved);
		$check_month_donations_pending = $this->donations->check_donations_within_months($check_donations_pending);
		$count_ch_don = count($check_donations);
		$count_ch_month_don = count($check_month_donations);
		$count_ch_month_don_approved = count($check_month_donations_approved);
		$count_ch_month_don_pending = count($check_month_donations_pending);
		$within_months = $this->donations->get_settings('within_months', 'value');
		$limit_months = $this->donations->get_settings('limit_months', 'value');
		$limit_years = $this->donations->get_settings('limit_years', 'value');
		// print_r($check_month_donations);
		$this->set('check_donations',$check_donations);
		$this->set('check_donations_months',$check_month_donations);
		$max = $this->donations->get_settings('max_amount', 'value');
		// Get mail settings for sent
		$s_port = $this->donations->get_settings('smpt_port', 'value');
		$s_host = $this->donations->get_settings('mail_host', 'value');
		$s_sec = trim(strtolower($this->donations->get_settings('smpt_security', 'value')));
		$s_user = $this->donations->get_settings('sent_mail', 'value');
		$s_pass = $this->donations->get_settings('sent_mail_password', 'value');
		$s_on_error_sent = $this->donations->get_settings('on_error_sent_mail','value');
		$s_approval_accounts = $this->donations->get_settings('approval_email_account', 'value');
		$s_approval_accounts = preg_replace('/\s+/', '', $s_approval_accounts);
		$s_approval_accounts = explode(';', $s_approval_accounts);
		$approval_account = array();
		$this->loadmodel('users');
		$s_i = 0;
		foreach ($s_approval_accounts as $value) {
			$hi_user_acc = $this->users->get_user_data_from_email($value);
			if(!empty($hi_user_acc)) {
				$approval_account[$s_i]['account'] = $hi_user_acc;
				$s_i++;
			}	
		}
		// echo '<pre>'; print_r($approval_account); echo '</pre>';
		$mail = new Mail(true);
		// Get mail settings for sent END IIIII||>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

		if(!empty($this->data)){
			// Mail settings
			$mail->SMTPDebug = 0;                                 // Enable verbose debug output use 1, 2, 3 or 0
   			$mail->isSMTP();                                      // Set mailer to use SMTP
    		$mail->Host = $s_host;  					  		  // Specify main and backup SMTP servers e24.ehosts.com
    		$mail->SMTPAuth = true;                               // Enable SMTP authentication
    		$mail->Username = $s_user;   						  // SMTP username info@requillo.com
    		$mail->Password = $s_pass; 				              // SMTP password 
    		if($s_sec == 'none'){
	    		$mail->SMTPSecure = false;						  // Enable TLS encryption, `ssl` also accepted
	    		// This fixes the bug for no Encryption security
	    		$mail->SMTPOptions = array(
	    			'ssl' => array(
	        		'verify_peer' => false,
	        		'verify_peer_name' => false,
	        		'allow_self_signed' => true
	    			)
	    		);      							  
    		} else {
    			$mail->SMTPSecure = $s_sec;
    		}               
    		                   
    		$mail->Port = $s_port;
    		$mail->setFrom($s_user); 
			// End Mail settings
			if($this->data['cash_amount'] == '') {
				$this->data['cash_amount'] = 0;
			}
			$assets = rtrim($this->data['extra_description'],',');
			$assets = explode(',', $assets);
			if(!empty($assets)) {
				foreach ($assets as $value) {
				$asset = explode('-', $value);
				$ass_price = $this->donations->get_donation_assets($asset[0], 'price');
				if($ass_price > 0){
					$tp = $asset[1]*$ass_price;
				}
				$add = $add + $tp;
				
				}
			}
			if($this->data['approval'] == 1) {
				$freq = $this->required_data('title,description');
			} else {
				$freq = $this->required_data('title,description,reason');
			}
			
			
			if($add > 0){
				$this->data['check_amount'] = $this->data['cash_amount'] + $add;
			} else {
				$this->data['check_amount'] = $this->data['cash_amount'] ;
			}
		// First check
		if(isset($this->data['approval']) && $this->data['approval'] == 0 && empty($freq)){
			$this->data['person_id'] = $ids[0];
				if($ids[1] != 0) {
					$this->data['foundation_id'] = $ids[1];	
				}
				$this->data['max_amount'] = $max;
				$this->data['amount'] = $this->data['check_amount'];
				$this->data['created'] = date('Y-m-d H:i:s');
				$this->data['created_user'] = $this->user['id'];
				$this->data['status'] = 1;
			$ch = $this->donations->save($this->data);
			// $document = $this->donations->behavior->upload_protect('document',array('size' => 10,'dir' => 'donations'));
			  if($this->data['document'] != '') {
			  	$data['document'] = $this->data['document'];
			  	$data['donation_id'] = $ch;
			  	$data['created'] = date('Y-m-d H:i:s');
				$data['created_user'] = $this->user['id'];
				$this->loadmodel('donation_documents');
				$this->donation_documents->save($data);
			  }
		message::flash(__('Donation was added and disapproved','donations'));
		$this->admin_redirect('donations/view-donation/'.$ch.'/');
		// recurring check ===============================================================================
		} else if(isset($this->data['recurring'])){

			$this->data['person_id'] = $ids[0];
				if($ids[1] != 0) {
					$this->data['foundation_id'] = $ids[1];	
				}
			$this->data['approval'] = 2;
			$this->data['max_amount'] = $max;
			$this->data['amount'] = $this->data['check_amount'];
			$this->data['created_user'] = $this->user['id'];
			$this->data['status'] = 1;
			// $document = $this->donations->behavior->upload_protect('document',array('size' => 10,'dir' => 'donations'));
			$ssid = 0;
			if($this->user['role_level'] >=6) {
				// Week ==================================================================================
				if($this->data['recurring_type'] == 1) {
					$today = time();
					$today = strtotime('-1 week',$today);
					$rec_amount = $this->data['recurring_amount'];
					for ($x = 0; $x < $rec_amount; $x++) {
						$today = strtotime('+1 week',$today);
						$tdate = date('Y-m-d H:i:s', $today);
						$this->data['created'] = $tdate;
						$ch = $this->donations->save($this->data);
						if($x == 0) {
							$ssid = $ch;
							$this->donations->id = $ch;
							$this->data['recurring_id'] = $ch;
							$this->donations->save($this->data);
							unset($this->donations->id);
						}
						// Document update
						if($this->data['document'] != '') {
						  	$data['document'] = $this->data['document'];
						  	$data['donation_id'] = $ch;
						  	$data['created'] = $tdate;
							$data['created_user'] = $this->user['id'];
							$this->loadmodel('donation_documents');
							$this->donation_documents->save($data);
						  }
					} 
				// Months ===============================================================================
				} else if($this->data['recurring_type'] == 2) {
					$today = time();
					$today = strtotime('-1 months',$today);
					$rec_amount = $this->data['recurring_amount'];
					for ($x = 0; $x < $rec_amount; $x++) {
						$today = strtotime('+1 months',$today);
						$tdate = date('Y-m-d H:i:s', $today);
						$this->data['created'] = $tdate;
						$ch = $this->donations->save($this->data);
						if($x == 0) {
							$ssid = $ch;
							$this->donations->id = $ch;
							$this->data['recurring_id'] = $ch;
							$this->donations->save($this->data);
							unset($this->donations->id);
						}
						// Document update
						if($this->data['document'] != '') {
						  	$data['document'] = $this->data['document'];
						  	$data['donation_id'] = $ch;
						  	$data['created'] = $tdate;
							$data['created_user'] = $this->user['id'];
							$this->loadmodel('donation_documents');
							$this->donation_documents->save($data);
						}						
					}
				// Years ===============================================================================
				} else if($this->data['recurring_type'] == 3){
					$today = time();
					$today = strtotime('-1 year',$today);
					$rec_amount = $this->data['recurring_amount'];
					for ($x = 0; $x < $rec_amount; $x++) {
						$today = strtotime('+1 year',$today);
						$tdate = date('Y-m-d H:i:s', $today);
						$this->data['created'] = $tdate;
						$ch = $this->donations->save($this->data);
						if($x == 0) {
							$ssid = $ch;
							$this->donations->id = $ch;
							$this->data['recurring_id'] = $ch;
							$this->donations->save($this->data);
							unset($this->donations->id);
						}
						// Document update
						if($this->data['document'] != '') {
						  	$data['document'] = $this->data['document'];
						  	$data['donation_id'] = $ch;
						  	$data['created'] = $tdate;
							$data['created_user'] = $this->user['id'];
							$this->loadmodel('donation_documents');
							$this->donation_documents->save($data);
						  }						
					}
				}

			// Do mailing here
				$hi_reason = __('Recurring Donation was added and waiting approval','donations');
				if($s_on_error_sent == 1) {
					foreach ($approval_account as $value) {
					// Reset all recipient;
					$mail->ClearAddresses();
					// Add a recipient
					$mail->addAddress($value['account']['email'], $value['account']['fname'].' '.$value['account']['lname']);
					$mail->isHTML(true);
					$mail->Subject = $hi_reason;
					$html_data = $this->set_html_mail_recurring($ssid,$value,$this->data,$ids);
					$mail->Body = $html_data;
					$mail->send();
					}
				}

			message::flash($hi_reason, 'error');
			$this->admin_redirect('donations/');
			}
		// Second check
		} else if($this->data['check_amount'] > 0 && $this->data['check_amount'] <= $max && $this->data['check_amount'] == $this->data['tot-amount'] && empty($freq)){
				$this->data['person_id'] = $ids[0];
				if($ids[1] != 0) {
					$this->data['foundation_id'] = $ids[1];	
				}
				$this->data['max_amount'] = $max;
				$this->data['amount'] = $this->data['check_amount'];
				$this->data['created'] = date('Y-m-d H:i:s');
				$this->data['created_user'] = $this->user['id'];
				$this->data['status'] = 1;
				if( $limit_years > $count_ch_don) {
					// Good to go
					if($limit_months > $count_ch_month_don) {
						$hi_reason = __('Donation was successfully added','donations');
						$noerror = true;
						// message::flash($hi_reason);
						$ch = $this->donations->save($this->data);
						// $document = $this->donations->behavior->upload_protect('document',array('size' => 10,'dir' => 'donations'));
						  if($this->data['document'] != '') {
						  	$data['document'] = $this->data['document'];
						  	$data['donation_id'] = $ch;
						  	$data['created'] = date('Y-m-d H:i:s');
							$data['created_user'] = $this->user['id'];
							$this->loadmodel('donation_documents');
							$this->donation_documents->save($data);
						  }
					// Exceeded months limit
					} else {
						$this->data['approval'] = 2;
						$hi_reason = __('Exceeded the limit on donations for this Donatee','donations');
						$x_msg = __('Please check with management for approval','donations');
						$this->data['error_msg'] = $hi_reason;
						$ch = $this->donations->save($this->data);
						// $document = $this->donations->behavior->upload_protect('document',array('size' => 10,'dir' => 'donations'));
						  if($this->data['document'] != '') {
						  	$data['document'] = $this->data['document'];
						  	$data['donation_id'] = $ch;
						  	$data['created'] = date('Y-m-d H:i:s');
							$data['created_user'] = $this->user['id'];
							$this->loadmodel('donation_documents');
							$this->donation_documents->save($data);
						  }
						if($s_on_error_sent == 1) {
							foreach ($approval_account as $value) {
							// Reset all recipient;
							$mail->ClearAddresses();
							// Add a recipient
							$mail->addAddress($value['account']['email'], $value['account']['fname'].' '.$value['account']['lname']);
							$mail->isHTML(true);
							$mail->Subject = $hi_reason;
							$html_data = $this->set_html_mail($ch,$value,$this->data,$ids);
							$mail->Body = $html_data;
							$mail->send();
							}
						}
						
					}
					if($noerror){
						message::flash($hi_reason);
					} else {
						message::flash($hi_reason.'<br>'.$x_msg,'error');	
					}
					
				} else {
					$this->data['approval'] = 2;
					$hi_reason = __('Exceeded the limit on donations for this Donatee','donations');
					$x_msg = __('Please check with management for approval','donations');
					$this->data['error_msg'] = $hi_reason;
					$ch = $this->donations->save($this->data);
					// $document = $this->donations->behavior->upload_protect('document',array('size' => 10,'dir' => 'donations'));
					  if($this->data['document'] != '') {
					  	$data['document'] = $this->data['document'];
					  	$data['donation_id'] = $ch;
					  	$data['created'] = date('Y-m-d H:i:s');
						$data['created_user'] = $this->user['id'];
						$this->loadmodel('donation_documents');
						$this->donation_documents->save($data);
					  }
					if($s_on_error_sent == 1) {
							foreach ($approval_account as $value) {
							// Reset all recipient;
							$mail->ClearAddresses();
							// Add a recipient
							$mail->addAddress($value['account']['email'], $value['account']['fname'].' '.$value['account']['lname']);
							$mail->isHTML(true);
							$mail->Subject = $hi_reason;
							$html_data = $this->set_html_mail($ch,$value,$this->data,$ids);
							$mail->Body = $html_data;
							$mail->send();
							}
						}
					message::flash($hi_reason.'<br>'.$x_msg,'error');
				}
				if($ch > 0) {
					$this->admin_redirect('donations/view-donation/'.$ch.'/');
				} else {
					message::flash(__('Something went wrong, could not save','donations'),'error');
				}
		// Third check		
		} else if ($this->data['check_amount'] > $max && $this->data['check_amount'] == $this->data['tot-amount'] && empty($freq)) {

				$this->data['person_id'] = $ids[0];
				if($ids[1] != 0) {
					$this->data['foundation_id'] = $ids[1];	
				}
				$this->data['max_amount'] = $max;
				$this->data['amount'] = $this->data['check_amount'];
				$this->data['created'] = date('Y-m-d H:i:s');
				$this->data['created_user'] = $this->user['id'];
				$this->data['status'] = 1;
				$this->data['approval'] = 2;
					if( $limit_years > $count_ch_don) {
						// Good to go
						if($limit_months > $count_ch_month_don) {
							$hi_reason = 'Donation exceeded the max amount!';
							$x_msg = __('Please check with management for approval','donations');
							$this->data['error_msg'] = $hi_reason;
							$ch = $this->donations->save($this->data);
							// $document = $this->donations->behavior->upload_protect('document',array('size' => 10,'dir' => 'donations'));
							  if($this->data['document'] != '') {
							  	$data['document'] = $this->data['document'];
							  	$data['donation_id'] = $ch;
							  	$data['created'] = date('Y-m-d H:i:s');
								$data['created_user'] = $this->user['id'];
								$this->loadmodel('donation_documents');
								$this->donation_documents->save($data);
							  }
							if($s_on_error_sent == 1) {
							foreach ($approval_account as $value) {
							// Reset all recipient;
							$mail->ClearAddresses();
							// Add a recipient
							$mail->addAddress($value['account']['email'], $value['account']['fname'].' '.$value['account']['lname']);
							$mail->isHTML(true);
							$mail->Subject = $hi_reason;
							$html_data = $this->set_html_mail($ch,$value,$this->data,$ids);
							$mail->Body = $html_data;
							$mail->send();
								}
							}
							message::flash($hi_reason.'<br>'.$x_msg,'error');
						// Exceeded months limit
						} else {
							$hi_reason = __('Exceeded the limit on donations and max amount for this Donatee','donations');
							$x_msg = __('Please check with management for approval','donations');
							$this->data['error_msg'] = $hi_reason;
							$ch = $this->donations->save($this->data);
							// $document = $this->donations->behavior->upload_protect('document',array('size' => 10,'dir' => 'donations'));
							  if($this->data['document'] != '') {
							  	$data['document'] = $this->data['document'];
							  	$data['donation_id'] = $ch;
							  	$data['created'] = date('Y-m-d H:i:s');
								$data['created_user'] = $this->user['id'];
								$this->loadmodel('donation_documents');
								$this->donation_documents->save($data);
							  }
							if($s_on_error_sent == 1) {
								foreach ($approval_account as $value) {
								// Reset all recipient;
								$mail->ClearAddresses();
								// Add a recipient
								$mail->addAddress($value['account']['email'], $value['account']['fname'].' '.$value['account']['lname']);
								$mail->isHTML(true);
								$mail->Subject = $hi_reason;
								$html_data = $this->set_html_mail($ch,$value,$this->data,$ids);
								$mail->Body = $html_data;
								$mail->send();
								}
							}
							message::flash($hi_reason.'<br>'.$x_msg,'error');
						}
					} else {
						$hi_reason = __('Exceeded the limit on donations and max amount for this Donatee','donations');
						$x_msg = __('Please check with management for approval','donations');
						$this->data['error_msg'] = $hi_reason;
						$ch = $this->donations->save($this->data);
						// $document = $this->donations->behavior->upload_protect('document',array('size' => 10,'dir' => 'donations'));
						  if($this->data['document'] != '') {
						  	$data['document'] = $this->data['document'];
						  	$data['donation_id'] = $ch;
						  	$data['created'] = date('Y-m-d H:i:s');
							$data['created_user'] = $this->user['id'];
							$this->loadmodel('donation_documents');
							$this->donation_documents->save($data);
						  }
						if($s_on_error_sent == 1) {
								foreach ($approval_account as $value) {
								// Reset all recipient;
								$mail->ClearAddresses();
								// Add a recipient
								$mail->addAddress($value['account']['email'], $value['account']['fname'].' '.$value['account']['lname']);
								$mail->isHTML(true);
								$mail->Subject = $hi_reason;
								$html_data = $this->set_html_mail($ch,$value,$this->data,$ids);
								$mail->Body = $html_data;
								$mail->send();
								}
							}
						message::flash($hi_reason.'<br>'.$x_msg,'error');
					}
				// Sent mail end code
				$this->admin_redirect('donations/view-donation/'.$ch.'/');

		} else if ( $this->data['tot-amount'] == '' || $this->data['tot-amount'] == 0  && empty($freq)){
				message::flash('Please add a donation amount!','error');
		} else if ( $this->data['check_amount'] != $this->data['tot-amount'] && empty($freq)){
				$this->data['approval'] = 2;
				$this->data['person_id'] = $ids[0];
					if($ids[1] != 0) {
						$this->data['foundation_id'] = $ids[1];
					}
				$this->data['max_amount'] = $max;
				$this->data['amount'] = $this->data['check_amount'];
				$this->data['created'] = date('Y-m-d H:i:s');
				$this->data['created_user'] = $this->user['id'];
				$this->data['status'] = 2;
				$ch = $this->donations->save($this->data);
				// $document = $this->donations->behavior->upload_protect('document',array('size' => 10,'dir' => 'donations'));
				  if($this->data['document'] != '') {
				  	$data['document'] = $this->data['document'];
				  	$data['donation_id'] = $ch;
				  	$data['created'] = date('Y-m-d H:i:s');
					$data['created_user'] = $this->user['id'];
					$this->loadmodel('donation_documents');
					$this->donation_documents->save($data);
				  }
				$this->admin_redirect('donations/view-donation/'.$ch.'/');
				message::flash('Mismatched amount, you have been reported!','error');
		} else {
				message::flash('Donation could not be added, please check the required fields','error');
			}
		}
		// print_r($this->data);
	}

	function admin_settings(){
		$this->title = __('Donations settings','donations');
		$this->set('Data', $this->donations->get_settings_inputs());
		if(!empty($this->data)) {
			$add = 1;
		$this->set('print', $this->data);
			foreach ($this->data as $key => $value) {
				$this->donations->update_settings_inputs($key, $value);
				Message::flash(__('Update settings successful','donations'));
				$this->admin_redirect('donations/settings');
			}
		}
	}

	function admin_donations_assets(){
		$this->title = __('Donations assets','donations');
		$this->loadmodel('users');
		$this->set('Donation_types',$this->donations->get_all_donation_types());
		$this->set('Company_options',$this->donations->get_companies_options());
	}

	function admin_view_donation($id = NULL){
		$this->title = __('Donation','donations');
		$donation = $this->donations->get_the_donation($id,$this->user);
		$donation_types = $this->donations->get_settings('donation_types', 'value');
		$donation_types = explode(',', $donation_types);
		$donation_types_n = array();
		$this->set("id", $id);
		foreach ($donation_types as $value) {
			$value = explode('=', $value);
			$donation_types_n[trim($value[1])] = __(trim($value[0]),'donations');
		}
		// echo $this->donations->get_settings('approval_email_account', 'value');
		
		// do this when post is send
		if(!empty($donation)) {
			$document = $this->donations->get_donation_document($donation['id']);
			$ids = array($donation['person_id'],$donation['foundation_id']);
			$donation['document'] = $document;
			$check_donations = $this->donations->check_donations_within_years($ids);
			$check_donations_approved = $this->donations->check_donations_within_years_approved($ids);
			$check_donations_pending = $this->donations->check_donations_within_years_pending($ids);
			$check_month_donations = $this->donations->check_donations_within_months($check_donations);
			$check_month_donations_approved = $this->donations->check_donations_within_months($check_donations_approved);
			$check_month_donations_pending = $this->donations->check_donations_within_months($check_donations_pending);
			$count_ch_don = count($check_donations);
			$count_ch_don_approved = count($check_donations_approved);
			$count_ch_don_pending = count($check_donations_pending);
			$count_ch_month_don = count($check_month_donations);
			$count_ch_month_don_approved = count($check_month_donations_approved);
			$count_ch_month_don_pending = count($check_month_donations_pending);
			$within_months = $this->donations->get_settings('within_months', 'value');
			$within_years = $this->donations->get_settings('within_years', 'value');
			$limit_months = $this->donations->get_settings('limit_months', 'value');
			$limit_years = $this->donations->get_settings('limit_years', 'value');
			$donation['person-info'] = $this->donations->get_person($donation['person_id']);
			$donation['foundation-info'] = $this->donations->get_foundation($donation['foundation_id']);
			$donation_info_check = array();
			if($donation['approval'] == 2){
				$donation_info_check['tot_request_years'] = $count_ch_don;
				$donation_info_check['tot_request_years_approved'] = $count_ch_don_approved;
				$donation_info_check['tot_request_years_pending'] = $count_ch_don_pending;
				$donation_info_check['within_years'] = $within_years;
				$donation_info_check['limit_years'] = $limit_years;
				$donation_info_check['tot_request_months'] = $count_ch_month_don;
				$donation_info_check['tot_request_months_approved'] = $count_ch_month_don_approved;
				$donation_info_check['tot_request_months_pending'] = $count_ch_month_don_pending;
				$donation_info_check['within_months'] = $within_months;
				$donation_info_check['limit_months'] = $limit_months;
				$donation_info_check['amount'] = $donation['amount'];
				$donation_info_check['max_amount'] = $donation['max_amount'];
			}
			$this->set('donation_info_check',$donation_info_check);
			$xdescar = array();
			$xdesc = explode(',', rtrim($donation['extra_description'],','));
			$i = 0;
			$don_desc_data = array();
			if(!empty($xdesc)){
				foreach ($xdesc as $value) {
				$value = explode('-', $value);
					$xdescar[$i]['type'] = $this->donations->get_donation_assets($value[0],'type');
					$xdescar[$i]['description'] = $this->donations->get_donation_assets($value[0],'description') . ' ' . $this->donations->get_donation_assets($value[0],'unit');
					if(isset($value[2])){
						$xdescar[$i]['price'] = $value[2];
					} else {
						$xdescar[$i]['price'] = '';
					}
					if(isset($value[1])){
						$xdescar[$i]['amount'] = $value[1];
					} else {
						$xdescar[$i]['amount'] = '';
					}
				$i++;
				}
				// $donation['extra_description'] = $xdescar;
					foreach ($xdescar AS $k => $sub_array)
					{
					$this_level = $sub_array['type'];
					if($this_level) {
					  	$don_desc_data[$this_level][$k] = array(
					  	'amount' => $sub_array['amount'],
					  	'description' => $sub_array['description'], 
					  	'price' => $sub_array['price'],  
					  	'type' => $sub_array['type'],
					  	'type_name' => $donation_types_n[$sub_array['type']]
					  	//'type_name' => $donation_types_n[$sub_array['type']]
					  	);
						}
					}
				$don_desc_data = array_values($don_desc_data);
				foreach ($don_desc_data as $key => $value) {
					$don_desc_data[$key] = array_values($don_desc_data[$key]);
				}
			}
			// echo '<pre>'.print_r($don_desc_data, TRUE).'</pre>';
			$this->loadmodel('users');
			$donation['donated_company_info'] = $this->users->get_companies($donation['donated_company']);
			$donation['donated_created_user'] = $this->users->get_user_data($donation['created_user']);
			if(!empty($donation['donated_created_user'])) {
				unset($donation['donated_created_user']['password']);
				unset($donation['donated_created_user']['salt']);
				unset($donation['donated_created_user']['keep']);
			}
			$donation['donation_types'] = $donation_types_n;
			$donation['count-types'] = count($don_desc_data);
			$donation['description-data'] = $don_desc_data;
			$app_user = $this->users->get_user_data($donation['hi_approval_user']);
			$this->set('Approvaluser', $app_user);
		}
		// echo '<pre>'.print_r($donation, TRUE).'</pre>';
		$this->set('Donation',$donation);
		$this->set('Approval', $this->approval);
	}

	function admin_approve_donation($id = NULL){
		if($id != NULL) {
			$donation = $this->donations->get_the_donation($id,$this->user);
			if(!empty($donation)) {
				echo '<pre>';
				print_r($donation);
				echo '</pre>';
				if($donation['recurring_id'] == 0 && $donation['approval'] == 2) {
					$s_on_error_sent = $this->donations->get_settings('on_error_sent_mail','value');
					$data = array();
					$data['hi_approval_updated'] = date('Y-m-d H:i:s');
					$data['hi_approval_user'] = $this->user['id'];
					$data['approval'] = 1;
					$data['hi_approval'] = 1;
					$this->donations->id = $id;
					$ch = $this->donations->save($data);
					if($ch > 0) {
						if($s_on_error_sent == 1) {
						$this->loadmodel('users');
						// $user = $this->users->get_user_data($userid);
						$company = $this->users->get_companies($donation['donated_company']);
						$donation['person_info'] = $this->donations->get_person($donation['person_id']);
						if($donation['foundation_id'] != 0) {
						$donation['foundation_info'] = $this->donations->get_foundation($donation['foundation_id']);
						}
						$mailing_accounts = $this->donations->donation_related_mailing_accounts($donation['donated_company']);
						$mail = $this->set_mail();
						foreach ($mailing_accounts as $value) {
							// Reset all recipient;
							$mail->ClearAddresses();
							// Add a recipient
							$mail->addAddress($value['email'], $value['fname'].' '.$value['lname']);
							$mail->isHTML(true);
							$mail->Subject = __('Donation has been approved','donations');
							$content = "<h3>".$donation['title']."</h3>";
							$content .= "<div>Description: ".$donation['description']."</div>";
							$content .= "<h3>Donatee information</h3>";
							$content .= "<div>".$donation['person_info']['first_name'].' '.$donation['person_info']['last_name']."</div>";
							if(isset($donation['foundation_info'])) { 
								$content .= "<div>".$donation['foundation_info']['foundation_name']."</div>";
							}
							$content .= "<h3>Donor information</h3>";
							$content .= "<div>".$company['company_name']."</div>";
							$content .= "<h4 style='color:#00b927;'>".__('Approved by').' '.$this->user['fname'].' '.$this->user['lname']."</h4>";
							$html_data = $this->notification_mail_layout(__('Donation has been approved','donations'), $content);
							$mail->Body = $html_data;
							$mail->send();
						}
					}
						Message::flash(__('This donation has been approved by you'));
						$this->admin_redirect('donations/view-donation/'.$id);
					}
				}
			}
		}
	}

	function admin_disapprove_donation($id = NULL){
		if($id != NULL) {
			$donation = $this->donations->get_the_donation($id,$this->user);
			if(!empty($donation)) {
				echo '<pre>';
				print_r($donation);
				echo '</pre>';
				if($donation['recurring_id'] == 0 && $donation['approval'] == 2) {
					$s_on_error_sent = $this->donations->get_settings('on_error_sent_mail','value');
					$data = array();
					$data['hi_approval_updated'] = date('Y-m-d H:i:s');
					$data['hi_approval_user'] = $this->user['id'];
					$data['approval'] = 0;
					$data['hi_approval'] = 1;
					$this->donations->id = $id;
					$ch = $this->donations->save($data);
					if($ch > 0) {
						if($s_on_error_sent == 1) {
						$this->loadmodel('users');
						// $user = $this->users->get_user_data($userid);
						$company = $this->users->get_companies($donation['donated_company']);
						$donation['person_info'] = $this->donations->get_person($donation['person_id']);
						if($donation['foundation_id'] != 0) {
						$donation['foundation_info'] = $this->donations->get_foundation($donation['foundation_id']);
						}
						$mailing_accounts = $this->donations->donation_related_mailing_accounts($donation['donated_company']);
						$mail = $this->set_mail();
						foreach ($mailing_accounts as $value) {
							// Reset all recipient;
							$mail->ClearAddresses();
							// Add a recipient
							$mail->addAddress($value['email'], $value['fname'].' '.$value['lname']);
							$mail->isHTML(true);
							$mail->Subject = __('Donation has been disapproved','donations');
							$content = "<h3>".$donation['title']."</h3>";
							$content .= "<div>Description: ".$donation['description']."</div>";
							$content .= "<h3>Donatee information</h3>";
							$content .= "<div>".$donation['person_info']['first_name'].' '.$donation['person_info']['last_name']."</div>";
							if(isset($donation['foundation_info'])) { 
								$content .= "<div>".$donation['foundation_info']['foundation_name']."</div>";
							}
							$content .= "<h3>Donor information</h3>";
							$content .= "<div>".$company['company_name']."</div>";
							$content .= "<h4 style='color:#00b927;'>".__('Disapproved by').' '.$this->user['fname'].' '.$this->user['lname']."</h4>";
							$html_data = $this->notification_mail_layout(__('Donation has been disapproved','donations'), $content);
							$mail->Body = $html_data;
							$mail->send();
						}
					}
						Message::flash(__('This donation has been approved by you'));
						$this->admin_redirect('donations/view-donation/'.$id);
					}
				}
			}
		}
	}

	function admin_approve_recurring_donation($id){
		if($id != NULL) {
			// Get the data
			$s_on_error_sent = $this->donations->get_settings('on_error_sent_mail','value');
			$donations = $this->donations->get_recurring_donations($id);
			if(!empty($donations)) {
				$error = 0;
				$this->title = "Approve Recurring";
				$this->data['hi_approval'] = 1;
				$this->data['hi_approval_updated'] = date('Y-m-d H:i:s');;
				$this->data['hi_approval_user'] = $this->user['id'];
				$this->data['approval'] = 1;

				foreach ($donations as $value) {
					if($value['hi_approval'] == 0) {
						$this->donations->id = $value['id'];
						$this->donations->save($this->data);
					} else {
						$error ++;
					}
					# code...
				}
				if($error == 0) {
					if($s_on_error_sent == 1) {
						$this->loadmodel('users');
						$user = $this->users->get_user_data($this->user['id']);
						$donation['person_info'] = $this->donations->get_person($donations[0]['person_id']);
						if($donations[0]['foundation_id'] != 0) {
						$donation['foundation_info'] = $this->donations->get_foundation($donations[0]['foundation_id']);
						}
						$mailing_accounts = $this->donations->donation_related_mailing_accounts($donations[0]['donated_company']);
						$mail = $this->set_mail();
						foreach ($mailing_accounts as $value) {
							// Reset all recipient;
							$mail->ClearAddresses();
							// Add a recipient
							$mail->addAddress($value['email'], $value['fname'].' '.$value['lname']);
							$mail->isHTML(true);
							$mail->Subject = __('Recurring Donations has been approved','donations');
							$content = "<h3>".$donations[0]['title']."</h3>";
							$content .= "<div>Description: ".$donations[0]['description']."</div>";
							$content .= "<h3>Donatee information</h3>";
							$content .= "<div>".$donation['person_info']['first_name'].' '.$donation['person_info']['last_name']."</div>";
							if(isset($donation['foundation_info'])) { 
								$content .= "<div>".$donation['foundation_info']['foundation_name']."</div>";
							}
							$content .= "<h4 style='color:#00b927;'>".__('Approved by').' '.$user['fname'].' '.$user['lname']."</h4>";
							$html_data = $this->notification_mail_layout(__('Recurring Donations has been approved','donations'), $content);
							$mail->Body = $html_data;
							$mail->send();
						}

						}
					Message::flash(__('Recurring donations approved by '.$user['fname'] . ' ' . $user['lname'] ,'donations'));
				} else {
					$user = $this->donations->get_user_info($donations[0]['hi_approval_user']);
					if($donations[0]['approval'] == 1) {

							$msg = __('Recurring donations was already approved by '.$user['fname'] . ' ' . $user['lname'],'donations');
						} else {
							$msg = __('Recurring donations was already disapproved by'.$user['fname'] . ' ' . $user['lname'],'donations');
						}
					Message::flash($msg,'error');
				}
			}
			$this->admin_redirect('donations/view-donation/'.$id);
		}
		
	}

	function admin_disapprove_recurring_donation($id){
		if($id != NULL) {
			// Get the data
			$s_on_error_sent = $this->donations->get_settings('on_error_sent_mail','value');
			$donations = $this->donations->get_recurring_donations($id);
			if(!empty($donations)) {
				$error = 0;
				$this->title = "Approve Recurring";
				$this->data['hi_approval'] = 1;
				$this->data['hi_approval_updated'] = date('Y-m-d H:i:s');;
				$this->data['hi_approval_user'] = $this->user['id'];
				$this->data['approval'] = 0;

				foreach ($donations as $value) {
					if($value['hi_approval'] == 0) {
						$this->donations->id = $value['id'];
						$this->donations->save($this->data);
					} else {
						$error ++;
					}
					# code...
				}
				if($error == 0) {
					if($s_on_error_sent == 1) {
						$this->loadmodel('users');
						$user = $this->users->get_user_data($this->user['id']);
						$donation['person_info'] = $this->donations->get_person($donations[0]['person_id']);
						if($donations[0]['foundation_id'] != 0) {
						$donation['foundation_info'] = $this->donations->get_foundation($donations[0]['foundation_id']);
						}
						$mailing_accounts = $this->donations->donation_related_mailing_accounts($donations[0]['donated_company']);
						$mail = $this->set_mail();
						foreach ($mailing_accounts as $value) {
							// Reset all recipient;
							$mail->ClearAddresses();
							// Add a recipient
							$mail->addAddress($value['email'], $value['fname'].' '.$value['lname']);
							$mail->isHTML(true);
							$mail->Subject = __('Recurring donations has been disapproved','donations');
							$content = "<h3>".$donations[0]['title']."</h3>";
							$content .= "<div>Description: ".$donations[0]['description']."</div>";
							$content .= "<h3>Donatee information</h3>";
							$content .= "<div>".$donation['person_info']['first_name'].' '.$donation['person_info']['last_name']."</div>";
							if(isset($donation['foundation_info'])) { 
								$content .= "<div>".$donation['foundation_info']['foundation_name']."</div>";
							}
							$content .= "<h4 style='color:#00b927;'>".__('Disapproved by').' '.$user['fname'].' '.$user['lname']."</h4>";
							$html_data = $this->notification_mail_layout(__('Recurring donations has been disapproved','donations'), $content);
							$mail->Body = $html_data;
							$mail->send();
						}

						}
					Message::flash(__('Recurring donations has been disapproved by '.$user['fname'] . ' ' . $user['lname'] ,'donations'),'error');
				} else {
					$user = $this->donations->get_user_info($donations[0]['hi_approval_user']);
					if($donations[0]['approval'] == 1) {

							$msg = __('Recurring donations was already approved by '.$user['fname'] . ' ' . $user['lname'],'donations');
						} else {
							$msg = __('Recurring donations was already disapproved by'.$user['fname'] . ' ' . $user['lname'],'donations');
						}
					Message::flash($msg,'error');
				}
			}
			$this->admin_redirect('donations/view-donation/'.$id);
		}
	}

	function token_donation_info(){
		$this->title = __('Donation information','donations');
		// Get variables
		if(isset($_GET['request']) && isset($_GET['user']) && isset($_GET['nonce']) && isset($_GET['action'])) {
			$id = $_GET['request'];
			$userid = $_GET['user'];
			$nonce = $_GET['nonce'];
			$action = $_GET['action'];
		} else {
			$id = '';
			$userid = '';
			$nonce = '';
			$action = '';
		}
		// Get the userdata
		$this->loadmodel('users');
		$userdata = $this->users->get_user_data($userid);
		// Get approval mail accounts
		$hi_approval_emails = $this->donations->get_settings('approval_email_account', 'value');
		$hi_approval_emails = preg_replace('/\s+/', '', $hi_approval_emails);
		$hi_approval_emails = explode(';', $hi_approval_emails);
		
		$ch_nonce = $this->donations->token_hash($action.$id.$userid);
		// echo $ch_nonce;
		// Check if user is allowed
		if($nonce == $ch_nonce && in_array($userdata['email'], $hi_approval_emails)) {
			$this->set('has_permition','yes');
		} else {
			$this->set('has_permition','no');
		}

		$donation = $this->donations->get_the_donation($id);
		$donation_types = $this->donations->get_settings('donation_types', 'value');
		$donation_types = explode(',', $donation_types);
		$donation_types_n = array();
		// check if a user is logged in
		if(isset($_SESSION['loggedin']['id'])) {
			if($_SESSION['loggedin']['id'] == $userid) {
				$this->set('islogin','yes');
			} else {
				$this->set('islogin','no');
				unset($_SESSION['loggedin']);
			}
		}

		foreach ($donation_types as $value) {
			$value = explode('=', $value);
			$donation_types_n[trim($value[1])] = __(trim($value[0]),'donations');
		}
		// do this when post is send
		if(!empty($donation)) {
			$document = $this->donations->get_donation_document($donation['id']);
			$ids = array($donation['person_id'],$donation['foundation_id']);
			$donation['document'] = $document;
			$check_donations = $this->donations->check_donations_within_years($ids);
			$check_donations_approved = $this->donations->check_donations_within_years_approved($ids);
			$check_donations_pending = $this->donations->check_donations_within_years_pending($ids);
			$check_month_donations = $this->donations->check_donations_within_months($check_donations);
			$check_month_donations_approved = $this->donations->check_donations_within_months($check_donations_approved);
			$check_month_donations_pending = $this->donations->check_donations_within_months($check_donations_pending);
			$count_ch_don = count($check_donations);
			$count_ch_don_approved = count($check_donations_approved);
			$count_ch_don_pending = count($check_donations_pending);
			$count_ch_month_don = count($check_month_donations);
			$count_ch_month_don_approved = count($check_month_donations_approved);
			$count_ch_month_don_pending = count($check_month_donations_pending);
			$within_months = $this->donations->get_settings('within_months', 'value');
			$within_years = $this->donations->get_settings('within_years', 'value');
			$limit_months = $this->donations->get_settings('limit_months', 'value');
			$limit_years = $this->donations->get_settings('limit_years', 'value');
			$donation['person-info'] = $this->donations->get_person($donation['person_id']);
			$donation['foundation-info'] = $this->donations->get_foundation($donation['foundation_id']);
			$donation_info_check = array();
			if($donation['approval'] == 2){
				$donation_info_check['tot_request_years'] = $count_ch_don;
				$donation_info_check['tot_request_years_approved'] = $count_ch_don_approved;
				$donation_info_check['tot_request_years_pending'] = $count_ch_don_pending;
				$donation_info_check['within_years'] = $within_years;
				$donation_info_check['limit_years'] = $limit_years;
				$donation_info_check['tot_request_months'] = $count_ch_month_don;
				$donation_info_check['tot_request_months_approved'] = $count_ch_month_don_approved;
				$donation_info_check['tot_request_months_pending'] = $count_ch_month_don_pending;
				$donation_info_check['within_months'] = $within_months;
				$donation_info_check['limit_months'] = $limit_months;
				$donation_info_check['amount'] = $donation['amount'];
				$donation_info_check['max_amount'] = $donation['max_amount'];
			}
			$this->set('donation_info_check',$donation_info_check);
			$this->set('check_donations_approved',$check_donations_approved);
			$this->set('check_donations_pending',$check_donations_pending);
			// appove link
			$tk_approve = $this->donations->token_hash('donations:approve_donation'.$id);
			$nonce_approve = $this->donations->token_hash('donations:approve_donation'.$id.$userid);
			$donation['approve_link'] = url('?token='.$tk_approve.'&action=donations:approve_donation&request='.$id.'&user='.$userid.'&nonce='.$nonce_approve);
			// disapprove link
			$tk_disapprove = $this->donations->token_hash('donations:disapprove_donation'.$id);
			$nonce_disapprove = $this->donations->token_hash('donations:disapprove_donation'.$id.$userid);
			$donation['disapprove_link'] = url('?token='.$tk_disapprove.'&action=donations:disapprove_donation&request='.$id.'&user='.$userid.'&nonce='.$nonce_disapprove);

			$donation['person-info'] = $this->donations->get_person($donation['person_id']);
			$donation['foundation-info'] = $this->donations->get_foundation($donation['foundation_id']);
			$donation['app_logo'] = $this->applogo;
			$xdescar = array();
			$xdesc = explode(',', rtrim($donation['extra_description'],','));
			$i = 0;
			foreach ($xdesc as $value) {
			$value = explode('-', $value);
				$xdescar[$i]['type'] = $this->donations->get_donation_assets($value[0],'type');
				$xdescar[$i]['description'] = $this->donations->get_donation_assets($value[0],'description').' '.$this->donations->get_donation_assets($value[0],'unit');
				if(isset($value[2])){
					$xdescar[$i]['price'] = $value[2];
				} else {
					$xdescar[$i]['price'] = '';
				}
				if(isset($value[1])){
					$xdescar[$i]['amount'] = $value[1];
				} else {
					$xdescar[$i]['amount'] = '';
				}
			$i++;

			}
			// $donation['extra_description'] = $xdescar;
			$don_desc_data = array();
				foreach ($xdescar AS $k => $sub_array)
				{
				  $this_level = $sub_array['type'];
				  $don_desc_data[$this_level][$k] = array(
				  	'amount' => $sub_array['amount'],
				  	'description' => $sub_array['description'], 
				  	'price' => $sub_array['price'],  
				  	'type' => $sub_array['type']
				  );
				}
			$don_desc_data = array_values($don_desc_data);
			foreach ($don_desc_data as $key => $value) {
				$don_desc_data[$key] = array_values($don_desc_data[$key]);
			}
			// echo '<pre>'.print_r($don_desc_data, TRUE).'</pre>';
			$this->loadmodel('users');
			$donation['donated_company_info'] = $this->users->get_companies($donation['donated_company']);
			$donation['donation_types'] = $donation_types_n;
			$donation['count-types'] = count($don_desc_data);
			$donation['description-data'] = $don_desc_data;
			$app_user = $this->users->get_user_data($donation['hi_approval_user']);
			$this->set('Approvaluser', $app_user);
		}
		
		$this->set('Donation',$donation);
		$this->set('Approval', $this->approval);
	}

	function token_approve_donation(){
		if(isset($_GET['request']) && isset($_GET['user']) && isset($_GET['nonce']) && isset($_GET['action'])) {
			$id = $_GET['request'];
			$userid = $_GET['user'];
			$nonce = $_GET['nonce'];
			$action = $_GET['action'];
		} else {
			$id = '';
			$userid = '';
			$nonce = '';
			$action = '';
		}
		// Get the data
		$s_on_error_sent = $this->donations->get_settings('on_error_sent_mail','value');
		$ch_nonce = $this->donations->token_hash($action.$id.$userid);
		$donation = $this->donations->get_the_donation($id);
		if($nonce == $ch_nonce && !empty($donation)) {
			// $this->title = "Yes";
			$tk_after = $this->donations->token_hash('donations:donation_after_message'.$id);
			$link_after =  url('?token='.$tk_after.'&action=donations:donation_after_message&request='.$id);
			echo $link_after;
			$this->data['approval'] = 1; 
			$this->data['hi_approval'] = 1; 
			$this->data['hi_approval_updated'] = date('Y-m-d H:i:s');
			$this->data['hi_approval_user'] = $userid;
			$this->donations->id = $id;
			if($donation['hi_approval'] == 0) {
				$ch = $this->donations->save($this->data);
				if($ch > 0) {
					if($s_on_error_sent == 1) {
						$this->loadmodel('users');
						$user = $this->users->get_user_data($userid);
						$company = $this->users->get_companies($donation['donated_company']);
						$donation['person_info'] = $this->donations->get_person($donation['person_id']);
						if($donation['foundation_id'] != 0) {
						$donation['foundation_info'] = $this->donations->get_foundation($donation['foundation_id']);
						}
						$mailing_accounts = $this->donations->donation_related_mailing_accounts($donation['donated_company']);
						$mail = $this->set_mail();
						foreach ($mailing_accounts as $value) {
								// Reset all recipient;
								$mail->ClearAddresses();
								// Add a recipient
								$mail->addAddress($value['email'], $value['fname'].' '.$value['lname']);
								$mail->isHTML(true);
								$mail->Subject = __('Donation has been approved','donations');
								$content = "<h3>".$donation['title']."</h3>";
								$content .= "<div>Description: ".$donation['description']."</div>";
								$content .= "<h3>Donatee information</h3>";
								$content .= "<div>".$donation['person_info']['first_name'].' '.$donation['person_info']['last_name']."</div>";
								if($donation['foundation_id'] != 0) { 
									$content .= "<div>".$donation['foundation_info']['foundation_name']."</div>";
								}
								$content .= "<h4 style='color:#00b927;'>".__('Approved by').' '.$user['fname'].' '.$user['lname']."</h4>";
								$html_data = $this->notification_mail_layout(__('Donation has been approved','donations'), $content);
								$mail->Body = $html_data;
								$mail->send();
						}
					}
					header('Location: '.$link_after);
				}
			} else {
				header('Location: '.$link_after.'&error=1');
			}
		}
	}

	function token_disapprove_donation(){
		if(isset($_GET['request']) && isset($_GET['user']) && isset($_GET['nonce']) && isset($_GET['action'])) {
			$id = $_GET['request'];
			$userid = $_GET['user'];
			$nonce = $_GET['nonce'];
			$action = $_GET['action'];
		} else {
			$id = '';
			$userid = '';
			$nonce = '';
			$action = '';
		}
		// Get the data
		$s_on_error_sent = $this->donations->get_settings('on_error_sent_mail','value');
		$ch_nonce = $this->donations->token_hash($action.$id.$userid);
		$donation = $this->donations->get_the_donation($id);
		if($nonce == $ch_nonce && !empty($donation)) {
			// $this->title = "Yes";
			$tk_after = $this->donations->token_hash('donations:donation_after_message'.$id);
			$link_after =  url('?token='.$tk_after.'&action=donations:donation_after_message&request='.$id);
			echo $link_after;
			$this->data['approval'] = 0; 
			$this->data['hi_approval'] = 1; 
			$this->data['hi_approval_updated'] = date('Y-m-d H:i:s');
			$this->data['hi_approval_user'] = $userid;
			$this->donations->id = $id;
			if($donation['hi_approval'] == 0) {
				$ch = $this->donations->save($this->data);
				if($ch > 0) {
					if($s_on_error_sent == 1) {
						$this->loadmodel('users');
						$user = $this->users->get_user_data($userid);
						$donation['person_info'] = $this->donations->get_person($donation['person_id']);
						if($donation['foundation_id'] != 0) {
						$donation['foundation_info'] = $this->donations->get_foundation($donation['foundation_id']);
						}
						$mailing_accounts = $this->donations->donation_related_mailing_accounts($donation['donated_company']);
						$mail = $this->set_mail();
						foreach ($mailing_accounts as $value) {
							// Reset all recipient;
							$mail->ClearAddresses();
							// Add a recipient
							$mail->addAddress($value['email'], $value['fname'].' '.$value['lname']);
							$mail->isHTML(true);
							$mail->Subject = __('Donation has been disapproved','donations');
							$content = "<h3>".$donation['title']."</h3>";
							$content .= "<div>Description: ".$donation['description']."</div>";
							$content .= "<h3>Donatee information</h3>";
							$content .= "<div>".$donation['person_info']['first_name'].' '.$donation['person_info']['last_name']."</div>";
							if($donation['foundation_id'] != 0) { 
								$content .= "<div>".$donation['foundation_info']['foundation_name']."</div>";
							}
							$content .= "<h4 style='color:#e60000;'>".__('Disapproved by').' '.$user['fname'].' '.$user['lname']."</h4>";
							$html_data = $this->notification_mail_layout(__('Donation has been disapproved','donations'), $content);
							$mail->Body = $html_data;
							$mail->send();
						}
					}
					header('Location: '.$link_after);
				}
			} else {
				header('Location: '.$link_after.'&error=1');
			}
		}

	}

	function token_approve_recurring_donation(){
		if(isset($_GET['request']) && isset($_GET['user']) && isset($_GET['nonce']) && isset($_GET['action'])) {
			$id = $_GET['request'];
			$userid = $_GET['user'];
			$nonce = $_GET['nonce'];
			$action = $_GET['action'];
		} else {
			$id = '';
			$userid = '';
			$nonce = '';
			$action = '';
		}
		// Get the data
		$s_on_error_sent = $this->donations->get_settings('on_error_sent_mail','value');
		$ch_nonce = $this->donations->token_hash($action.$id.$userid);
		$user = $this->donations->get_user_info($userid);
		$donations = $this->donations->get_recurring_donations($id);
		if($nonce == $ch_nonce && !empty($donations)) {
			$error = 0;
			$this->title = "Approve Recurring";
			$this->data['hi_approval'] = 1;
			$this->data['hi_approval_updated'] = date('Y-m-d H:i:s');;
			$this->data['hi_approval_user'] = $userid;
			$this->data['approval'] = 1;

			foreach ($donations as $value) {
				if($value['hi_approval'] == 0) {
					$this->donations->id = $value['id'];
					$this->donations->save($this->data);
				} else {
					$error ++;
				}
				# code...
			}
			if($error == 0) {
				if($s_on_error_sent == 1) {
					$this->loadmodel('users');
					$user = $this->users->get_user_data($userid);
					$donation['person_info'] = $this->donations->get_person($donations[0]['person_id']);
					if($donations[0]['foundation_id'] != 0) {
					$donation['foundation_info'] = $this->donations->get_foundation($donations[0]['foundation_id']);
					}
					$mailing_accounts = $this->donations->donation_related_mailing_accounts($donations[0]['donated_company']);
					$mail = $this->set_mail();
					foreach ($mailing_accounts as $value) {
						// Reset all recipient;
						$mail->ClearAddresses();
						// Add a recipient
						$mail->addAddress($value['email'], $value['fname'].' '.$value['lname']);
						$mail->isHTML(true);
						$mail->Subject = __('Recurring Donations has been approved','donations');
						$content = "<h3>".$donations[0]['title']."</h3>";
						$content .= "<div>Description: ".$donations[0]['description']."</div>";
						$content .= "<h3>Donatee information</h3>";
						$content .= "<div>".$donation['person_info']['first_name'].' '.$donation['person_info']['last_name']."</div>";
						if(isset($donation['foundation_info'])) { 
							$content .= "<div>".$donation['foundation_info']['foundation_name']."</div>";
						}
						$content .= "<h4 style='color:#00b927;'>".__('Approved by').' '.$user['fname'].' '.$user['lname']."</h4>";
						$html_data = $this->notification_mail_layout(__('Recurring Donations has been approved','donations'), $content);
						$mail->Body = $html_data;
						$mail->send();
					}

					}
				Message::flash(__('Recurring donations approved by '.$user['fname'] . ' ' . $user['lname'] ,'donations'));
			} else {
				$user = $this->donations->get_user_info($donations[0]['hi_approval_user']);
				if($donations[0]['approval'] == 1) {

						$msg = __('Recurring donations was already approved by '.$user['fname'] . ' ' . $user['lname'],'donations');
					} else {
						$msg = __('Recurring donations was already disapproved by'.$user['fname'] . ' ' . $user['lname'],'donations');
					}
				Message::flash($msg,'error');
			}
		}
	}

	function token_disapprove_recurring_donation(){
		if(isset($_GET['request']) && isset($_GET['user']) && isset($_GET['nonce']) && isset($_GET['action'])) {
			$id = $_GET['request'];
			$userid = $_GET['user'];
			$nonce = $_GET['nonce'];
			$action = $_GET['action'];
		} else {
			$id = '';
			$userid = '';
			$nonce = '';
			$action = '';
		}
		// Get the data
		$s_on_error_sent = $this->donations->get_settings('on_error_sent_mail','value');
		$ch_nonce = $this->donations->token_hash($action.$id.$userid);
		// echo $ch_nonce;
		$user = $this->donations->get_user_info($userid);
		$donations = $this->donations->get_recurring_donations($id);
		if($nonce == $ch_nonce && !empty($donations)) {
			$error = 0;
			$this->title = "Disapprove Recurring";
			$this->data['hi_approval'] = 1;
			$this->data['hi_approval_updated'] = date('Y-m-d H:i:s');;
			$this->data['hi_approval_user'] = $userid;
			$this->data['approval'] = 0;

			foreach ($donations as $value) {
				if($value['hi_approval'] == 0) {
					$this->donations->id = $value['id'];
					$this->donations->save($this->data);
				} else {
					$error ++;
				}
				# code...
			}

			if($error == 0) {
				if($s_on_error_sent == 1) {
					$this->loadmodel('users');
					$user = $this->users->get_user_data($userid);
					$donation['person_info'] = $this->donations->get_person($donations[0]['person_id']);
					if($donation['foundation_id'] != 0) {
					$donation['foundation_info'] = $this->donations->get_foundation($donations[0]['foundation_id']);
					}
					$mailing_accounts = $this->donations->donation_related_mailing_accounts($donations[0]['donated_company']);
					$mail = $this->set_mail();
					foreach ($mailing_accounts as $value) {
						// Reset all recipient;
						$mail->ClearAddresses();
						// Add a recipient
						$mail->addAddress($value['email'], $value['fname'].' '.$value['lname']);
						$mail->isHTML(true);
						$mail->Subject = __('Recurring donations has been disapproved','donations');
						$content = "<h3>".$donations[0]['title']."</h3>";
						$content .= "<div>Description: ".$donations[0]['description']."</div>";
						$content .= "<h3>Donatee information</h3>";
						$content .= "<div>".$donation['person_info']['first_name'].' '.$donation['person_info']['last_name']."</div>";
						if($donations[0]['foundation_id'] != 0) { 
							$content .= "<div>".$donation['foundation_info']['foundation_name']."</div>";
						}
						$content .= "<h4 style='color:#e60000;'>".__('Disapproved by').' '.$user['fname'].' '.$user['lname']."</h4>";
						$html_data = $this->notification_mail_layout(__('Recurring donations has been disapproved','donations'), $content);
						$mail->Body = $html_data;
						$mail->send();
						}
					}
				Message::flash(__('Recurring donations approved by '.$user['fname'] . ' ' . $user['lname'] ,'donations'));
			} else {
				$user = $this->donations->get_user_info($donations[0]['hi_approval_user']);
				if($donations[0]['approval'] == 1) {

						$msg = __('Recurring donations was already approved by '.$user['fname'] . ' ' . $user['lname'],'donations');
					} else {
						$msg = __('Recurring donations was already disapproved by'.$user['fname'] . ' ' . $user['lname'],'donations');
					}
				Message::flash($msg,'error');
			}
		}
	}

	function token_donation_after_message(){
		// echo $_GET['request'];
		if(isset($_GET['request'])) {
			$id = $_GET['request'];
		} else {
			$id = '';
		}
		// echo $id;
		if(isset($_GET['error'])) {
			$this->set('error',1);
		} else {
			$this->set('error','');
		} 
		// $this->title = __('Donation','donations');
		$donation = $this->donations->get_the_donation($id);
		$donation_types = $this->donations->get_settings('donation_types', 'value');
		$donation_types = explode(',', $donation_types);
		$donation_types_n = array();
		foreach ($donation_types as $value) {
			$value = explode('=', $value);
			$donation_types_n[trim($value[1])] = __(trim($value[0]),'donations');
		}
		// do this when post is send
		if(!empty($donation)) {
			$donation['person-info'] = $this->donations->get_person($donation['person_id']);
			$donation['foundation-info'] = $this->donations->get_foundation($donation['foundation_id']);
			$xdescar = array();
			$xdesc = explode(',', rtrim($donation['extra_description'],','));
			$i = 0;
			foreach ($xdesc as $value) {
			$value = explode('-', $value);
				$xdescar[$i]['type'] = $this->donations->get_donation_assets($value[0],'type');
				$xdescar[$i]['description'] = $this->donations->get_donation_assets($value[0],'description');
				if(isset($value[2])){
					$xdescar[$i]['price'] = $value[2];
				} else {
					$xdescar[$i]['price'] = '';
				}
				if(isset($value[1])){
					$xdescar[$i]['amount'] = $value[1];
				} else {
					$xdescar[$i]['amount'] = '';
				}
			$i++;
			}
			// $donation['extra_description'] = $xdescar;
			$don_desc_data = array();
				foreach ($xdescar AS $k => $sub_array)
				{
				  $this_level = $sub_array['type'];
				  $don_desc_data[$this_level][$k] = array(
				  	'amount' => $sub_array['amount'],
				  	'description' => $sub_array['description'], 
				  	'price' => $sub_array['price'],  
				  	'type' => $sub_array['type']
				  );
				}
			$don_desc_data = array_values($don_desc_data);
			foreach ($don_desc_data as $key => $value) {
				$don_desc_data[$key] = array_values($don_desc_data[$key]);
			}
			// echo '<pre>'.print_r($don_desc_data, TRUE).'</pre>';
			$this->loadmodel('users');
			$donation['donated_company_info'] = $this->users->get_companies($donation['donated_company']);
			$donation['donation_types'] = $donation_types_n;
			$donation['count-types'] = count($don_desc_data);
			$donation['description-data'] = $don_desc_data;
			$app_user = $this->users->get_user_data($donation['hi_approval_user']);
			// print_r($app_user);
			$this->set('Approvaluser', $app_user);
		}
		$this->set('Donation',$donation);
		$this->set('Approval', $this->approval);
	}

	function token_view_recurring_donation(){
		$this->title = __('Recurring donation information','donations');
		/////////////////////////////////////////////////////////////////////////////////////////////////////
		// Get variables
		if(isset($_GET['request']) && isset($_GET['user']) && isset($_GET['nonce']) && isset($_GET['action'])) {
			$id = $_GET['request'];
			$userid = $_GET['user'];
			$nonce = $_GET['nonce'];
			$action = $_GET['action'];
		} else {
			$id = '';
			$userid = '';
			$nonce = '';
			$action = '';
		}
		// Get the userdata
		$this->loadmodel('users');
		$userdata = $this->users->get_user_data($userid);
		// Get approval mail accounts
		$hi_approval_emails = $this->donations->get_settings('approval_email_account', 'value');
		$hi_approval_emails = preg_replace('/\s+/', '', $hi_approval_emails);
		$hi_approval_emails = explode(';', $hi_approval_emails);
		
		$ch_nonce = $this->donations->token_hash($action.$id.$userid);
		// echo $ch_nonce;
		// Check if user is allowed
		if($nonce == $ch_nonce && in_array($userdata['email'], $hi_approval_emails)) {
			$this->set('has_permition','yes');
		} else {
			$this->set('has_permition','no');
		}

		$donation = $this->donations->get_the_donation($id);

		$donation_types = $this->donations->get_settings('donation_types', 'value');
		$donation_types = explode(',', $donation_types);
		$donation_types_n = array();
		// check if a user is logged in
		if(isset($_SESSION['loggedin']['id'])) {
			if($_SESSION['loggedin']['id'] == $userid) {
				$this->set('islogin','yes');
			} else {
				$this->set('islogin','no');
				unset($_SESSION['loggedin']);
			}
		}

		foreach ($donation_types as $value) {
			$value = explode('=', $value);
			$donation_types_n[trim($value[1])] = __(trim($value[0]),'donations');
		}
		// do this when post is send
		if(!empty($donation)) {
			$recurrin_dons = $this->donations->get_recurring_donations($donation['recurring_id']);
			$dates = array();
			$cdt = date('d F Y', strtotime($donation['created']));
			$stcdt = strtotime($cdt);
			
			foreach ($recurrin_dons as $key => $value) {
				$dt = date('d F Y', strtotime($value['created']));
				$stdt = strtotime($dt);
				$dates[$key]['recurring'] = $dt;
				if($stcdt == $stdt) {
				$dates[$key]['class'] = 'text-success';	
				} else if($stcdt > $stdt) {
				$dates[$key]['class'] = 'text-danger';
				} else {
				$dates[$key]['class'] = '';	
				}
			}

			$document = $this->donations->get_donation_document($donation['id']);
			$ids = array($donation['person_id'],$donation['foundation_id']);
			$donation['document'] = $document;
			$donation['person-info'] = $this->donations->get_person($donation['person_id']);
			$donation['foundation-info'] = $this->donations->get_foundation($donation['foundation_id']);
			$donation['app_logo'] = $this->applogo;
			$xdescar = array();
			$xdesc = explode(',', rtrim($donation['extra_description'],','));
			$i = 0;
			foreach ($xdesc as $value) {
			$value = explode('-', $value);
				$xdescar[$i]['type'] = $this->donations->get_donation_assets($value[0],'type');
				$xdescar[$i]['description'] = $this->donations->get_donation_assets($value[0],'description');
				if(isset($value[2])){
					$xdescar[$i]['price'] = $value[2];
				} else {
					$xdescar[$i]['price'] = '';
				}
				if(isset($value[1])){
					$xdescar[$i]['amount'] = $value[1];
				} else {
					$xdescar[$i]['amount'] = '';
				}
			$i++;

			}
			// $donation['extra_description'] = $xdescar;
			$don_desc_data = array();
				foreach ($xdescar AS $k => $sub_array)
				{
				  $this_level = $sub_array['type'];
				  $don_desc_data[$this_level][$k] = array(
				  	'amount' => $sub_array['amount'],
				  	'description' => $sub_array['description'], 
				  	'price' => $sub_array['price'],  
				  	'type' => $sub_array['type']
				  );
				}
			$don_desc_data = array_values($don_desc_data);
			foreach ($don_desc_data as $key => $value) {
				$don_desc_data[$key] = array_values($don_desc_data[$key]);
			}
			// echo '<pre>'.print_r($don_desc_data, TRUE).'</pre>';
			$this->loadmodel('users');
			$donation['donated_company_info'] = $this->users->get_companies($donation['donated_company']);
			$donation['donation_types'] = $donation_types_n;
			$donation['count-types'] = count($don_desc_data);
			$donation['description-data'] = $don_desc_data;
			$app_user = $this->users->get_user_data($donation['hi_approval_user']);
			$this->set('Approvaluser', $app_user);
		}
		$this->set('Dates', $dates);
		$this->set('Donation',$donation);
		$this->set('Approval', $this->approval);
		/////////////////////////////////////////////////////////////////////////////////////////////////////
	}

	function rest_get_persons(){
		$data = array();
		$data['similar'] = '';
		$data['similar_ids'] = '';
		$data['per_sim'] = '';
		$data['mix_names'] = '';
		$persons = $this->donations->get_all_persons();
		$first_name = ucwords(strtolower(preg_replace('/\s+/', ' ', $this->data['first_name'])));
		$last_name = ucwords(strtolower(preg_replace('/\s+/', ' ', $this->data['last_name'])));
		$id_number = strtolower(preg_replace('/\s+/', '', $this->data['id_number']));
		$i = 0;
		foreach ($persons as $person) {
			similar_text($person['first_name'], $first_name, $fname);
			similar_text($person['last_name'], $last_name, $lname);
			similar_text($person['first_name'], $last_name, $efname);
			similar_text($person['last_name'], $first_name, $elname);
			similar_text($person['id_number'], $id_number, $idn);
			if($person['black_listed'] == 1) {
					$bl = __('(Blacklisted!)', 'donations');
					$alert = 'alert-danger';
			} else {
					$bl = '';
					$alert = 'alert-info';
			}


			if($efname > 70 && $elname > 70 && $idn > 90){
				$data['similar'] .= '<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">';
				$data['similar'] .= '<div class="alert spec '.$alert.'"><a href="'.admin_url('donations/add-first/'.$person['id']).'">';
				$data['similar'] .= '';
				$data['similar'] .= '<div>'.$person['first_name'].' <span class="text-danger">'.$bl.'</span></div>';
				$data['similar'] .= '<div>'.$person['last_name'].'</div>';
				$data['similar'] .= '<div>'.$person['id_number'].'</div>';
				$data['similar'] .= '</div></a></div>';
				$data['similar_ids'] .= $person['id'] . ',';
				$data['per_sim'] = 1;
				$data['mix_names'] = 1;
				$data['person'][$i] = $person;
				$i++;
				break;
			}else if($idn > 92) {
				$data['similar'] .= '<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">';
				$data['similar'] .= '<div class="alert spec '.$alert.'"><a href="'.admin_url('donations/add-first/'.$person['id']).'">';
				$data['similar'] .= '';
				$data['similar'] .= '<div>'.$person['first_name'].' <span class="text-danger">'.$bl.'</span></div>';
				$data['similar'] .= '<div>'.$person['last_name'].'</div>';
				$data['similar'] .= '<div>'.$person['id_number'].'</div>';
				$data['similar'] .= '</div></a></div>';
				$data['similar_ids'] .= $person['id'] . ',';
				$data['per_sim'] = 1;
				$data['person'][$i] = $person;
				$i++;
				break;
			}else if($fname > 70 && $lname > 70 && $idn > 90){
				$data['similar'] .= '<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">';
				$data['similar'] .= '<div class="alert spec '.$alert.'"><a href="'.admin_url('donations/add-first/'.$person['id']).'">';
				$data['similar'] .= '';
				$data['similar'] .= '<div>'.$person['first_name'].' <span class="text-danger">'.$bl.'</span></div>';
				$data['similar'] .= '<div>'.$person['last_name'].'</div>';
				$data['similar'] .= '<div>'.$person['id_number'].'</div>';
				$data['similar'] .= '</div></a></div>';
				$data['similar_ids'] .= $person['id'] . ',';
				$data['per_sim'] = 1;
				$data['person'][$i] = $person;
				$i++;
				break;
			}
		}
		if($data['per_sim'] == 0){
			foreach ($persons as $person) {
				similar_text($person['first_name'], $first_name, $fname);
				similar_text($person['last_name'], $last_name, $lname);
				similar_text($person['first_name'], $last_name, $efname);
				similar_text($person['last_name'], $first_name, $elname);
				similar_text($person['id_number'], $id_number, $idn);
				if($person['black_listed'] == 1) {
					$bl = __('(Blacklisted!)', 'donations');
					$alert = 'alert-danger';
				} else {
						$bl = '';
						$alert = 'alert-info';
				}
				if($fname > 70 && $lname > 70){
					$data['similar'] .= '<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">';
					$data['similar'] .= '<div class="alert spec '.$alert.'"><a href="'.admin_url('donations/add-first/'.$person['id']).'">';
					$data['similar'] .= '';
					$data['similar'] .= '<div>'.$person['first_name'].' <span class="text-danger">'.$bl.'</span></div>';
					$data['similar'] .= '<div>'.$person['last_name'].'</div>';
					$data['similar'] .= '<div>'.$person['id_number'].'</div>';
					$data['similar'] .= '</div></a></div>';
					$data['similar_ids'] .= $person['id'] . ',';
					$data['person'][$i] = $person;
					$i++;

				} else if($efname > 70 && $elname > 70){
					$data['similar'] .= '<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">';
					$data['similar'] .= '<div class="alert spec '.$alert.'"><a href="'.admin_url('donations/add-first/'.$person['id']).'">';
					$data['similar'] .= '';
					$data['similar'] .= '<div>'.$person['first_name'].' <span class="text-danger">'.$bl.'</span></div>';
					$data['similar'] .= '<div>'.$person['last_name'].'</div>';
					$data['similar'] .= '<div>'.$person['id_number'].'</div>';
					$data['similar'] .= '</div></a></div>';
					$data['similar_ids'] .= $person['id'] . ',';
					$data['mix_names'] = 1;
					$data['person'][$i] = $person;
					$i++;
				}
			}
		}
		$data['similar_ids'] = rtrim($data['similar_ids'],',');
		$data['similar_count'] = $i;
		echo json_encode($data);
	}

	function rest_get_company_assets(){
		if(!empty($this->data)){
			$data = $this->donations->get_company_assets($this->data['company_id']);
			echo json_encode($data);
		}
		
	}

	function rest_file_upload(){
		if(isset($this->data['pers'])) {
			$document = $this->donations->behavior->upload_protect_ajax('scanned_doc',array('size' => 3,'dir' => 'donations/persons'));
			echo $document;
		}

		if(isset($this->data['don'])) {
			$document = $this->donations->behavior->upload_protect_ajax('scanned_doc',array('size' => 5,'dir' => 'donations/docs'));
			echo $document;
		}
				
	}

	function rest_import_company_assets(){

		if(!empty($_FILES['data']['tmp_name']["import_csv_2"]) || !empty($_FILES['data']['tmp_name']["import_csv_3"])) {
		  $data = array();
			if(!empty($_FILES['data']['tmp_name']["import_csv_2"])) {
			  		$filename = $_FILES['data']['tmp_name']["import_csv_2"];
			  		$name = $_FILES['data']['name']["import_csv_2"];
			} else if(!empty($_FILES['data']['tmp_name']["import_csv_3"])) {
			  		$filename = $_FILES['data']['tmp_name']["import_csv_3"];
			  		$name = $_FILES['data']['name']["import_csv_3"];
			} else {
			  		$filename = '';
			  		$name = '';
			}

			$ext = explode('.', $name);
			$ext = strtolower(end($ext));
			if($ext == 'csv') {
				$data['type'] = $this->data['type'];
				$data['company_id'] = $this->data['companies'];
				$data['created'] = date('Y-m-d H:i:s');
				$data['created_user'] = $this->user['id'];
				$data['status'] = 1;
				$file = fopen($filename, "r");
				$this->loadmodel('donation_assets');

	            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
	            	$item_num = strtoupper($getData[0]);
	            	$item_desc = $getData[1];
	            	$item_unit = $getData[2];
	            	$item_price = $getData[3];
	            	// To check if assets exists
	            	$check = $this->donations->check_company_assets($item_num,$data['company_id'],$data['type']);
	            	if(!empty($check)) {
	            		// Disable / delete asset
	            		$this->donations->disable_company_assets($check);
	            	}
	            	if($item_num != 'ITEM NUMBER' && $item_desc != '' && $item_price != '' && is_numeric($item_price)) {
	            		$data['description'] = $item_desc;
		            	$data['price'] = $item_price;
		            	$data['item_number'] = $item_num;
		            	$data['unit'] = $item_unit;
						$result = $this->donation_assets->save($data);
		                if($result) {
		                  $data['message'] = 'Success ';
		                } else {
		                 $data['message'] = 'Failed';
		                }
	            	}
	            }
				echo $data['message'];
				fclose($file);
			} else {
				echo __('no_csv');
			}

		} else {
		// print_r($_FILES);
		echo 'Nothing';
		}

	}

	function rest_update_company_assets(){
		if(!empty($this->data)){
			$this->loadmodel('donation_assets');
			$this->data['updated'] = date('Y-m-d H:i:s');
			$this->data['updated_user'] = $this->user['id'];
			$this->donation_assets->id = $this->data['id'];
			$updated = $this->donation_assets->save($this->data);
			if($updated > 0){
				$data['message'] = 'Updated';
			} else {
				$data['message'] = 'Failed';
			}
			echo json_encode($data);
		}
		
	}

	function rest_delete_company_assets($id=NULL){
		if($id != NULL){
			$this->loadmodel('donation_assets');
			$this->data['updated'] = date('Y-m-d H:i:s');
			$this->data['updated_user'] = $this->user['id'];
			$this->data['status'] = 0;
			$this->donation_assets->id = $id;
			$updated = $this->donation_assets->save($this->data);
			if($updated > 0){
				$data['message'] = 'Deleted';
			} else {
				$data['message'] = 'Failed';
			}
			echo json_encode($data);
		}
					
	}

	function rest_add_company_assets(){
		if(!empty($this->data)){
			$data = array();
			$s_on_error_sent = $this->donations->get_settings('on_error_sent_mail','value');
			$this->loadmodel('donation_assets');
			$this->data['created'] = date('Y-m-d H:i:s');
			$this->data['created_user'] = $this->user['id'];
			$this->data['status'] = 1;
			$id = $this->donation_assets->save($this->data);
			if($id > 0){
				///////////////////////////////////////////////////////////////////////
			if(isset($this->data['ch_product'])) {
				if($s_on_error_sent == 1) {
					// Sent the mail
					// Get mail settings for sent
					$don_types = $this->donations->get_settings('donation_types', 'value');
					$don_types = explode(',', $don_types);
					$dt = array();
					foreach ($don_types as $value) {
						$value = explode('=', $value);
						$dt[trim($value[1])] = trim($value[0]);
					}
					$s_port = $this->donations->get_settings('smpt_port', 'value');
					$s_host = $this->donations->get_settings('mail_host', 'value');
					$s_sec = trim(strtolower($this->donations->get_settings('smpt_security', 'value')));
					$s_user = $this->donations->get_settings('sent_mail', 'value');
					$s_pass = $this->donations->get_settings('sent_mail_password', 'value');
					$ic_check_accounts = $this->donations->get_settings('IC_email_account', 'value');
					$ic_check_accounts = preg_replace('/\s+/', '', $ic_check_accounts);
					$ic_check_accounts = explode(';', $ic_check_accounts);
					$check_account = array();
					$this->loadmodel('users');
					$s_i = 0;
					foreach ($ic_check_accounts as $value) {
						$ic_user_acc = $this->users->get_user_data_from_email($value);
						if(!empty($ic_user_acc)) {
							$check_account[$s_i]['account'] = $ic_user_acc;
							$s_i++;
						}	
					}
					// echo '<pre>'; print_r($check_account); echo '</pre>';
					$mail = new Mail(true);
					// Mail settings
					$mail->SMTPDebug = 0;                                 // Enable verbose debug output use 1, 2, 3 or 0
		   			$mail->isSMTP();                                      // Set mailer to use SMTP
		    		$mail->Host = $s_host;  					  		  // Specify main and backup SMTP servers e24.ehosts.com
		    		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		    		$mail->Username = $s_user;   						  // SMTP username info@requillo.com
		    		$mail->Password = $s_pass; 				              // SMTP password 
		    		if($s_sec == 'none'){
			    		$mail->SMTPSecure = false;						  // Enable TLS encryption, `ssl` also accepted
			    		// This fixes the bug for no Encryption security
			    		$mail->SMTPOptions = array(
			    			'ssl' => array(
			        		'verify_peer' => false,
			        		'verify_peer_name' => false,
			        		'allow_self_signed' => true
			    			)
			    		);      							  
		    		} else {
		    			$mail->SMTPSecure = $s_sec;
		    		}               
		    		                   
		    		$mail->Port = $s_port;
		    		$mail->setFrom($s_user); 
					// End Mail settings
					if(isset($this->data['unit'])) {
						$unit = $this->data['unit'];
					} else {
						$unit = '';
					}
					$title = __('Check if item information is correct','donations');
					$content = '<h3>'.$dt[$this->data['type']].'</h3>';
					$content .= '<div>'.$this->data['description'].' ' .$unit.' '.__('price','donations').' SRD'.$this->data['price'].'</div>';
					$company = $this->users->get_companies($this->data['company_id']);
					$content .= '<div>'.__('Added by:').' '.$this->user['fname'].' '.$this->user['lname'].'</div>';
					$content .= '<div>'.__('Company:').' '.$company['company_name'].'</div>';
					foreach ($check_account as $value) {
						// Reset all recipient;
						$mail->ClearAddresses();
						// Add a recipient
						$mail->addAddress($value['account']['email'], $value['account']['fname'].' '.$value['account']['lname']);
						$mail->isHTML(true);
						$mail->Subject = __('New item added in donation application','donations');
						$html_data = $this->notification_mail_layout($title, $content);
						$mail->Body = $html_data;
						$mail->send();
					}
				}
			}
			$data['message'] = 'updated';
			$data['id'] = $id;
			} else {
				$data['message'] = '';
			}

			echo json_encode($data);
		}
		
	}

	function rest_get_foundations(){
		$data = array();
		$data['similar'] = '';
		$data['similar_ids'] = '';
		$data['per_sim'] = '';
		$foundations = $this->donations->get_all_foundations();
		$foundation_name = strtoupper(strtolower(preg_replace('/\s+/', ' ', $this->data['foundation_name'])));
		$foundation_address = ucwords(strtolower(preg_replace('/\s+/', ' ', $this->data['foundation_address'])));
		$foundation_telephone = strtolower(preg_replace('/\s+/', '', $this->data['foundation_telephone']));
		$foundation_email = strtolower(preg_replace('/\s+/', '', $this->data['foundation_email']));
		$i = 0;
		foreach ($foundations as $foundation) {
			$dfn = $foundation['foundation_name'];
			$dft = $foundation['foundation_address'];
			$dfa = $foundation['foundation_telephone'];
			$dfe = $foundation['foundation_email'];
			if($foundation['black_listed'] == 1) {
					$bl = __('(Blacklisted!)', 'donations');
					$alert = 'alert-danger';
				} else {
					$bl = '';
					$alert = 'alert-success';
				}
			if(empty($dfn)) {
				$dfn = 'N/A';
			}
			if(empty($dft)) {
				$dft = 'N/A';
			}
			if(empty($dfa)) {
				$dfa = 'N/A';
			}
			if(empty($dfe)) {
				$dfe = 'N/A';
			}
			similar_text($foundation['foundation_name'], $foundation_name, $f_name);
			similar_text($foundation['foundation_address'], $foundation_address, $f_addr);
			similar_text($foundation['foundation_telephone'], $foundation_telephone, $f_tel);
			similar_text($foundation['foundation_email'], $foundation_email, $f_mail);
			if($f_name > 60 && $f_addr > 85 && $f_tel > 90 && $f_mail > 80){
				$tp_count = ($f_name+$f_addr+$f_tel+$f_mail)/4;
				$tp_count = round($tp_count);
				$data['similar'] .= '<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 spec">';
				$data['similar'] .= '<div class="overwrite alert '.$alert.'">';
				$data['similar'] .= '<label for="found-'.$foundation['id'].'">';
				$data['similar'] .= '<input type="checkbox" name="data[foundation_id]" id="found-'.$foundation['id'].'" class="nflat" value="'.$foundation['id'].'"> ';
				$data['similar'] .= '<span>'.$dfn.'</span> <span class="text-danger">'.$bl.'</span>';
				$data['similar'] .= '<hr>';
				$data['similar'] .= '<div><i class="fa fa-map-marker" aria-hidden="true"></i> '.$dfa.'</div>';
				$data['similar'] .= '<div><i class="fa fa-phone-square" aria-hidden="true"></i> '.$dft.'</div>';
				$data['similar'] .= '<div><i class="fa fa-envelope" aria-hidden="true"></i> '.$dfe.'</div>';
				$data['similar'] .= __('Name Similarity','donations') .'= '.$tp_count.'%';
				$data['similar'] .= '</div></label></div>';
				$data['similar_ids'] .= $foundation['id'] . ',';
				$data['per_sim'] = 1;
				$data['foundation'][$i] = $foundation;
				$i++;
				break;
			}else if($f_name > 60 && $f_addr > 85 && $f_tel > 90 ) {
				$tp_count = ($f_name+$f_addr+$f_tel)/3;
				$tp_count = round($tp_count);
				$data['similar'] .= '<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 spec">';
				$data['similar'] .= '<div class="overwrite alert '.$alert.'">';
				$data['similar'] .= '<label for="found-'.$foundation['id'].'">';
				$data['similar'] .= '<input type="checkbox" name="data[foundation_id]" id="found-'.$foundation['id'].'" class="nflat" value="'.$foundation['id'].'"> ';
				$data['similar'] .= '<span>'.$dfn.'</span> <span class="text-danger">'.$bl.'</span>';
				$data['similar'] .= '<hr>';
				$data['similar'] .= '<div><i class="fa fa-map-marker" aria-hidden="true"></i> '.$dfa.'</div>';
				$data['similar'] .= '<div><i class="fa fa-phone-square" aria-hidden="true"></i> '.$dft.'</div>';
				$data['similar'] .= '<div><i class="fa fa-envelope" aria-hidden="true"></i> '.$dfe.'</div>';
				$data['similar'] .= __('Name Similarity','donations') .'= '.$tp_count.'%';
				$data['similar'] .= '</div></label></div>';
				$data['similar_ids'] .= $foundation['id'] . ',';
				$data['per_sim'] = 1;
				$data['foundation'][$i] = $foundation;
				$i++;
				break;
			}else if($f_name > 60 && $f_addr > 85 && $f_mail > 85){
				$tp_count = ($f_name+$f_addr+$f_mail)/3;
				$tp_count = round($tp_count);
				$data['similar'] .= '<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 spec">';
				$data['similar'] .= '<div class="overwrite alert '.$alert.'">';
				$data['similar'] .= '<label for="found-'.$foundation['id'].'">';
				$data['similar'] .= '<input type="checkbox" name="data[foundation_id]" id="found-'.$foundation['id'].'" class="nflat" value="'.$foundation['id'].'"> ';
				$data['similar'] .= '<span>'.$dfn.'</span> <span class="text-danger">'.$bl.'</span>';
				$data['similar'] .= '<hr>';
				$data['similar'] .= '<div><i class="fa fa-map-marker" aria-hidden="true"></i> '.$dfa.'</div>';
				$data['similar'] .= '<div><i class="fa fa-phone-square" aria-hidden="true"></i> '.$dft.'</div>';
				$data['similar'] .= '<div><i class="fa fa-envelope" aria-hidden="true"></i> '.$dfe.'</div>';
				$data['similar'] .= __('Name Similarity','donations') .'= '.$tp_count.'%';
				$data['similar'] .= '</div></label></div>';
				$data['similar_ids'] .= $foundation['id'] . ',';
				$data['per_sim'] = 1;
				$data['foundation'][$i] = $foundation;
				$i++;
				break;
			}
		}
		if($data['per_sim'] == ''){
			foreach ($foundations as $foundation) {
				$dfn = $foundation['foundation_name'];
				$dft = $foundation['foundation_address'];
				$dfa = $foundation['foundation_telephone'];
				$dfe = $foundation['foundation_email'];
				if($foundation['black_listed'] == 1) {
					$bl = __('(Blacklisted!)', 'donations');
					$alert = 'alert-danger';
				} else {
					$bl = '';
					$alert = 'alert-success';
				}
				if(empty($dft)) {
					$dft = 'N/A';
				}
				if(empty($dfa)) {
					$dfa = 'N/A';
				}
				if(empty($dfe)) {
					$dfe = 'N/A';
				}
				similar_text($foundation['foundation_name'], $foundation_name, $f_name);
				similar_text($foundation['foundation_address'], $foundation_address, $f_addr);
				similar_text($foundation['foundation_telephone'], $foundation_telephone, $f_tel);
				similar_text($foundation['foundation_email'], $foundation_email, $f_mail);
				if($f_name > 60){
					$tp_count = round($f_name);
					$data['similar'] .= '<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 spec">';
					$data['similar'] .= '<div class="overwrite alert '.$alert.'">';
					$data['similar'] .= '<label for="found-'.$foundation['id'].'">';
					$data['similar'] .= '<input type="checkbox" name="data[foundation_id]" id="found-'.$foundation['id'].'" class="nflat spec_check res_found_check" value="'.$foundation['id'].'"> ';
					$data['similar'] .= '<span>'.$dfn.'</span> <span class="text-danger">'.$bl.'</span>';
					$data['similar'] .= '<hr>';
					$data['similar'] .= '<div><i class="fa fa-map-marker" aria-hidden="true"></i> '.$dfa.'</div>';
					$data['similar'] .= '<div><i class="fa fa-phone-square" aria-hidden="true"></i> '.$dft.'</div>';
					$data['similar'] .= '<div><i class="fa fa-envelope" aria-hidden="true"></i> '.$dfe.'</div>';
					$data['similar'] .= __('Name Similarity','donations') .'= '.$tp_count.'%';
					$data['similar'] .= '</div></label></div>';
					$data['similar_ids'] .= $foundation['id'] . ',';
					$data['foundation'][$i] = $foundation;
					$i++;
				}
			}
		}
		$data['similar_ids'] = rtrim($data['similar_ids'],',');
		$data['similar_count'] = $i;
		echo json_encode($data);
	}

	function rest_get_charts_data() {
		if(!empty($this->data)){
			$data = array();
			$donations = $this->donations->request_donation_data($this->data['dates'],$this->data['comp'],$this->data['approval']);
			$t = $this->donations->sort_all_donations($donations);
			$echarts_data = $this->donations->echarts_data($t);
			$data['donations'] = $donations;
			$data['sorta'] = $t;
			$data['ech_data'] = $echarts_data;
			echo json_encode($data);
		}
	}

///////////////////////////////////////// Cron jobs methods /////////////////////////////////////////

	function cron_check_recurring_donations(){
		$donations = $this->donations->get_upcomming_recurring_donations();
		$s_on_error_sent = $this->donations->get_settings('on_error_sent_mail','value');
		$cdon = count($donations);
		if(!empty($donations)) {
			if($s_on_error_sent == 1) {
				$s_approval_accounts = $this->donations->get_settings('approval_email_account', 'value');
				$s_approval_accounts = preg_replace('/\s+/', '', $s_approval_accounts);
				$s_approval_accounts = explode(';', $s_approval_accounts);
				$approval_account = array();
				$this->loadmodel('users');
				$s_i = 0;
				$mail = $this->set_mail();
				foreach ($s_approval_accounts as $value) {
						$hi_user_acc = $this->users->get_user_data_from_email($value);
						if(!empty($hi_user_acc)) {
							$approval_account[$s_i]['account'] = $hi_user_acc;
							$s_i++;
						}	
				}
				if(!empty($approval_account)) {
					foreach ($approval_account as $value) {
					$userid	= $value['account']['id'];
					$useremail = $value['account']['email'];
					$username = $value['account']['fname'].' '.$value['account']['lname'];
					$html_data = '<div>'.__('Hi','donations').' '.$value['account']['fname'].',</div>';
					if($cdon == 1) {
						$html_data .= '<div>'.__('This is a reminder that you have an upcomming recurring donation.','donations').'</div>';
					} else {
						$html_data .= '<div>'.__('This is a reminder that you have upcomming recurring donations.','donations').'</div>';
					}
					
						foreach ($donations as $key => $value) {
						$token = $this->donations->token_hash('donations:view_recurring_donation'.$value['id']);
						// check this later for mailing
						$nonce = $this->donations->token_hash('donations:view_recurring_donation'.$value['id'].$userid);
						$viewlink = url().'?token='.$token.'&action=donations:view_recurring_donation&request='.$value['id'].'&user='.$userid.'&nonce='.$nonce;
						$html_data .= '<h3>'.$value['title'].'</h3>';
						$html_data .= '<div>'.$value['description'].'</div>';
						$html_data .= '<table style="font-family:Calibri,Helvetica,sans-serif;">
									    <tr>
									        <td style="background-color: #81bb29;border-color: #75bc0a;border: 2px solid #75bc0a;text-align: center; border-radius: 6px;padding: 10px;">
									            <a style="display: block;color: #ffffff;font-size: 18px;text-decoration: none;" href="'.$viewlink.'">'.__('View full donation information','donations').'</a>
									        </td>
									    </tr>
									</table><br>';
						}
					$mail->ClearAddresses();
					// Add a recipient
					$mail->addAddress($useremail, $username);
					$mail->isHTML(true);
					$mail->Subject = __('Upcomming recurring donation','donations');
					$mail->Body = $html_data;
					// $mail->send();
					}
				}
			}
			

			echo '<pre>';
			print_r($donations);
			echo '</pre>';
		}
		
	}

	function cron_check_approvals(){
		$donations = $this->donations->get_all_approval_donations();
		$s_on_error_sent = $this->donations->get_settings('on_error_sent_mail','value');
		$approval_accounts = $this->hi_approval_accounts();
		if(!empty($donations)) {
			if($s_on_error_sent == 1) {
				$mail = $this->set_mail();
				if(!empty($approval_accounts)) {
					foreach ($approval_accounts as $value) {
						// notification_mail_layout($title, $content, $footer = NULL)
						$userid	= $value['id'];
						$useremail = $value['email'];
						$username = $value['fname'].' '.$value['lname'];
						$content = '<div>'.__('Hi','donations').' '.$value['fname'].',</div>';
						$content .= '<div>'.__('It seems like there are donations awaiting approvals.','').'</div>';
						$content .= '<div>'.__('Please login to the application or check your older mails.','').'</div>';
						$mail->ClearAddresses();
						$html_data = $this->notification_mail_layout('', $content);
						// Add a recipient
						$mail->addAddress($useremail, $username);
						$mail->isHTML(true);
						$mail->Subject = __('You have a few donations waiting approvals','donations');
						$mail->Body = $html_data;
						$mail->send();
					}
				}
			}
		}
		// echo '<pre>';
		// print_r($donations);
		//echo '</pre>';
		
	}
	///////////////////////////////////////// WIDGETS Methods ///////////////////////////////////////////////////////////////////////////
	public function widget_get_all_donations() {
		if(!empty($this->data)){
			$this->loadmodel('users');
			$comp = $this->users->get_companies($this->data['comp']);
			$this->set('Company_options',$this->donations->get_companies_options($this->data['comp']));
			$dates = explode('=', $this->data['dates']);
			$donations = $this->donations->request_donation_data($this->data['dates'],$this->data['comp'],$this->data['approval']);
			$t = $this->donations->sort_all_donations($donations);
			$echarts_data = $this->donations->echarts_data($t);
			$gd = array(date('Y-m-d', strtotime($dates[0])),date('Y-m-d', strtotime($dates[1])));
			$this->set('dates', $gd);
			$this->set('data',$t);
			$this->set('echart',$echarts_data);
			$tt = $this->donations->all_donations_totals($donations);
			$this->set('totals',$tt);
			if($this->data['approval'] == 'all') {
				// do a hack for studip zero value
				$this->data['approval'] = 1000;
			}
			$this->set('approval',$this->data['approval']);
			if($this->data['comp'] != 'all') {
				$this->set('companies',$comp['company_name']);
			} else {
				$this->set('companies',__('All Companies','donations'));
			}
			
		} else {
			$this->set('Company_options',$this->donations->get_companies_options());
			$now = strtotime("now");
			$month_ago = strtotime("-1 months");
			// Dates like 2018-04-20 23:59:59,2018-03-20 00:00:00
			$periods = date('Y-m-d',$now).' 23:59:59' . ','. date('Y-m-d',$month_ago).' 00:00:00';
			$gd = array(date('Y-m-d', strtotime("-29 days")),date('Y-m-d'));
			$this->set('dates', $gd);
			$donations = $this->donations->get_donations_from($periods);
			$t = $this->donations->sort_all_donations($donations);
			$echarts_data = $this->donations->echarts_data($t);
			$this->set('data',$t);
			$this->set('echart',$echarts_data);
			$tt = $this->donations->all_donations_totals($donations);
			$this->set('totals',$tt);
			$this->set('approval',1);
			$this->set('companies',__('All Companies','donations'));
		}

	}

	public function widget_get_company_options($id = NULL){
		$Donation_options = $this->donations->get_companies_options($id);
		echo $Donation_options;
	}

	public function widget_get_company_donations() {
		
	}

	///////////////////////////////////////// STARTING HERE ALL PRIVATE Methods /////////////////////////////////////////////////////////

	private function hi_approval_accounts(){
		$s_approval_accounts = $this->donations->get_settings('approval_email_account', 'value');
		$s_approval_accounts = preg_replace('/\s+/', '', $s_approval_accounts);
		$s_approval_accounts = explode(';', $s_approval_accounts);
		$approval_account = array();
		$this->loadmodel('users');
		$s_i = 0;
		foreach ($s_approval_accounts as $value) {
			$hi_user_acc = $this->users->get_user_data_from_email($value);
			if(!empty($hi_user_acc)) {
				$approval_account[$s_i] = $hi_user_acc;
				$s_i++;
			}	
		}
		return $approval_account;
	}

	private function notification_mail_layout($title, $content){
		$strthtml = '<html>
						<head>
							<meta http-equiv="Content-Type" content="text/html; charset=US-ASCII">
						</head>
						<body dir="ltr">
							<div id="divtagdefaultwrapper" style="font-size:16px;color:#000000;font-family:Calibri,Helvetica,sans-serif;" dir="ltr">';
		$endhtml = '</div></body></html>';
		$title = '<h2>'.$title.'</h2>';
		$content = '<div>'.$content.'</div>';
		$footer = $this->mail_footer();
		return $strthtml.$title.$content.$footer.$endhtml;

	}

	private function set_mail() {
		$s_port = $this->donations->get_settings('smpt_port', 'value');
		$s_host = $this->donations->get_settings('mail_host', 'value');
		$s_sec = trim(strtolower($this->donations->get_settings('smpt_security', 'value')));
		$s_user = $this->donations->get_settings('sent_mail', 'value');
		$s_pass = $this->donations->get_settings('sent_mail_password', 'value');
		$mail = new Mail(true);
		$mail->SMTPDebug = 0;                                 // Enable verbose debug output use 1, 2, 3 or 0
   		$mail->isSMTP();                                      // Set mailer to use SMTP
    	$mail->Host = $s_host;  					  		  // Specify main and backup SMTP servers e24.ehosts.com
    	$mail->SMTPAuth = true;                               // Enable SMTP authentication
    	$mail->Username = $s_user;   						  // SMTP username info@requillo.com
    	$mail->Password = $s_pass; 				              // SMTP password 
		if($s_sec == 'none'){
    		$mail->SMTPSecure = false;						  // Enable TLS encryption, `ssl` also accepted
    		// This fixes the bug for no Encryption security
    		$mail->SMTPOptions = array(
    			'ssl' => array(
        		'verify_peer' => false,
        		'verify_peer_name' => false,
        		'allow_self_signed' => true
    			)
    		);      							  
		} else {
			$mail->SMTPSecure = $s_sec;
		}
		$mail->Port = $s_port;
    	$mail->setFrom($s_user);
		return $mail;
	}

	private function set_html_mail($save_id,$userdata,$data,$ids=NULL){
		if($ids != NULL) {
			$Person = $this->donations->get_person($ids[0]);
			$Foundation = $this->donations->get_foundation($ids[1]);	
		}
		
		$this->loadmodel('users');
		// Check types of donations
				$xdesc = explode(',', rtrim($data['extra_description'],','));
				$i = 0;
				$don_desc_data = array();
				if(!empty($xdesc)){
					$donation_types = $this->donations->get_settings('donation_types', 'value');
					$donation_types = explode(',', $donation_types);
					// Get donation types
					$donation_types_n = array();
					foreach ($donation_types as $value) {
						$value = explode('=', $value);
						$donation_types_n[trim($value[1])] = __(trim($value[0]),'donations');
					}
					foreach ($xdesc as $value) {
					$value = explode('-', $value);
						$xdescar[$i]['type'] = $this->donations->get_donation_assets($value[0],'type');
						$xdescar[$i]['description'] = $this->donations->get_donation_assets($value[0],'description');
						if(isset($value[2])){
							$xdescar[$i]['price'] = $value[2];
						} else {
							$xdescar[$i]['price'] = '';
						}
						if(isset($value[1])){
							$xdescar[$i]['amount'] = $value[1];
						} else {
							$xdescar[$i]['amount'] = '';
						}
					$i++;
					}				
						foreach ($xdescar AS $k => $sub_array)
						{
						  $this_level = $sub_array['type'];
						  $don_desc_data[$this_level][$k] = array(
						  	'amount' => $sub_array['amount'],
						  	'description' => $sub_array['description'], 
						  	'price' => $sub_array['price'],
						  	'type' => $sub_array['type'],  
						  	'type_name' => $donation_types_n[$sub_array['type']]
						  );
						}
					$don_desc_data = array_values($don_desc_data);
					foreach ($don_desc_data as $key => $value) {
						$don_desc_data[$key] = array_values($don_desc_data[$key]);
					}
				}
				// echo '<pre>'.print_r($don_desc_data, TRUE).'</pre>';
				$data_don = '';
				$html_start = '<html>
							<head>
							<meta http-equiv="Content-Type" content="text/html; charset=US-ASCII">
							</head>
							<body dir="ltr">
							<div id="divtagdefaultwrapper" style="font-size:16px;color:#000000;font-family:Calibri,Helvetica,sans-serif;" dir="ltr">';
				if(!empty($xdesc[0])) {
					
					$data_don .= '<table cellpadding="4" style="font-family:Calibri,Helvetica,sans-serif;">';
					$data_don .= '<thead>
						<tr class="headings" style="background: #8c5f1e; color: #fff;border-radius: 6px;">
						<th class="column-title" style="width: 64px;">'. __('Quantity','donations').'</th>
						<th class="column-title" style="text-align: left;">'. __('Description','donations').'</th>
						<th class="column-title" style="width: 130px; text-align: right;">'. __('Amount in SRD','donations').'</th>
						</tr>
					</thead>
					<tbody>';
					foreach ($don_desc_data as $value) {
							$i = 1;
							foreach ($value as $v) {
								if($i == 1) {
							$data_don .= '<tr style="background: #ffdcaa;">
											<td></td>
											<td><b>'. $v['type_name'] . '</b></td>
											<td></td>
										</tr>';		
								}
							$data_don .= '<tr style="background: #d4d4d4;">
											<td style="text-align: center;">'.$v['amount'] .'</td>
											<td>'. $v['description'] . ' Price SRD '. $v['price'] . '</td>
											<td style="text-align: right;">' . $v['amount']*$v['price'] . '</td>
										</tr>';
							$i++;
							}
						}
					
				}
				if($data_don == '') {
					$data_don .= '<table cellpadding="4" style="font-family:Calibri,Helvetica,sans-serif;">';
					$data_don .= '<thead>
						<tr class="headings" style="background: #8c5f1e; color: #fff;border-radius: 6px;">
						<th class="column-title" style="width: 64px;">'. __('Quantity','donations').'</th>
						<th class="column-title" style="text-align: left;">'. __('Description','donations').'</th>
						<th class="column-title" style="width: 130px; text-align: right;">'. __('Amount in SRD','donations').'</th>
						</tr>
					</thead>
					<tbody>';
				}
				if($data['cash_description'] != '' && $data['cash_amount'] != '') {
						$data_don .= '<tr style="background: #ffdcaa;">
										<td></td>
										<td><b>'. __('Cash', 'donations') . '</b></td>
										<td></td>
									</tr>';
						$data_don .= '<tr style="background: #d4d4d4;">
										<td></td>
										<td>'. nl2br($data['cash_description']) . '</td>
										<td style="text-align: right;">'.$data['cash_amount'].'</td>
									</tr>';
					}

					$data_don .= '</tbody>
								<tfoot>
								<tr style="background: #343434; color: #fff;">
									<th></th>
									<th>'. __('Total donation amount in SRD','donations').'</th>
									<th style="text-align: right;">'. $data['amount'].'</th>
								</tr>
							</tfoot>';
				
					$data_don .= '
							</table><br>';
				// END check types of donations

				// Person information
				$donatee = '';
				$donatee .= '<h2 style="margin-bottom: 4px;">' .__('Donatee information','donations').'</h2>';
				$donatee .= $Person['first_name'] . ' ' . $Person['last_name'].'<br>';
				if(!empty($Foundation)) {
				$donatee .= $Foundation['foundation_name'] .'<br>';	
				}	
				// Donation information
				$donate_info = '';
				$donate_info .= '<h2 style="margin-bottom: 4px;">'.__('Donation information','donations').'</h2>';
				$donate_info .= '<b>'.__('Subject','donations').'</b>: '.$data['title'].'<br>';
				$donor_comp = $this->users->get_companies($data['donated_company']);
				$donate_info .= '<b>'.__('Donor','donations').'</b>: '.$donor_comp['company_name'].'<br>';
				$donate_info .= '<b>'.__('Donation','donations').'</b>';
				// Sent mail add code
				$html_end = '</div>
							</body>
							</html>';
				// Links
					// appove link
					$tk_approve = $this->donations->token_hash('donations:approve_donation'.$save_id);
					$nonce_approve = $this->donations->token_hash('donations:approve_donation'.$save_id.$userdata['account']['id']);
					$appove_lnk = url('?token='.$tk_approve.'&action=donations:approve_donation&request='.$save_id.'&user='.$userdata['account']['id'].'&nonce='.$nonce_approve);
					// disapprove link
					$tk_disapprove = $this->donations->token_hash('donations:disapprove_donation'.$save_id);
					$nonce_disapprove = $this->donations->token_hash('donations:disapprove_donation'.$save_id.$userdata['account']['id']);
					$disappove_lnk = url('?token='.$tk_disapprove.'&action=donations:disapprove_donation&request='.$save_id.'&user='.$userdata['account']['id'].'&nonce='.$nonce_disapprove);
					// End Links
					$approve_or_disapp = '
					<h2 style="margin-bottom: 4px;">'.__('Approve or Disapprove the donation','donations').'</h2>
					<table style="font-family:Calibri,Helvetica,sans-serif;">
						<tr>
							<td>
								<table style="font-family:Calibri,Helvetica,sans-serif;">
								    <tr>
								        <td style="background-color: #81bb29;border-color: #75bc0a;border: 2px solid #75bc0a;text-align: center; border-radius: 6px;padding: 10px;">
								            <a style="display: block;color: #ffffff;font-size: 18px;text-decoration: none;" href="'.$appove_lnk.'">'.__('Approve donation','donations').'</a>
								        </td>
								    </tr>
								</table>
							</td>
							<td>OR</td>
							<td>
								<table style="font-family:Calibri,Helvetica,sans-serif;">
								    <tr>
								        <td style="background-color: #d63338;border-color: #d61117;border: 2px solid #d61117;text-align: center; border-radius: 6px;padding: 10px;">
								            <a style="display: block;color: #ffffff;font-size: 18px;text-decoration: none;" href="'.$disappove_lnk.'">'.__('Disapprove donation','donations').'</a>
								        </td>
								    </tr>
								</table>
							</td>
						</tr>
					</table><br>';
					$tk_viewdon = $this->donations->token_hash('donations:donation_info'.$save_id);
					$nonce_viewdon = $this->donations->token_hash('donations:donation_info'.$save_id.$userdata['account']['id']);
					$viewdon_lnk = url('?token='.$tk_viewdon.'&action=donations:donation_info&request='.$save_id.'&user='.$userdata['account']['id'].'&nonce='.$nonce_viewdon);
					$view_donation_ol = '
					<h2 style="margin-bottom: 4px;">'.__('View the full information on this donation request','donations').'</h2>
					<table style="font-family:Calibri,Helvetica,sans-serif;">
					    <tr>
					        <td style="background-color: #81bb29;border-color: #75bc0a;border: 2px solid #75bc0a;text-align: center; border-radius: 6px;padding: 10px;">
					            <a style="display: block;color: #ffffff;font-size: 18px;text-decoration: none;" href="'.$viewdon_lnk.'">'.__('View complete Donation','donations').'</a>
					        </td>
					    </tr>
					</table><br>';
					$powered = $this->mail_footer();
					// End Links
		return $html_start.$donatee.$donate_info.$data_don.$approve_or_disapp.$view_donation_ol.$powered.$html_end;

	}

	private function set_html_mail_recurring($save_id,$userdata,$data,$ids=NULL){
		if($ids != NULL) {
			$Person = $this->donations->get_person($ids[0]);
			$Foundation = $this->donations->get_foundation($ids[1]);	
		}
		
		$this->loadmodel('users');
		// Check types of donations
				$xdesc = explode(',', rtrim($data['extra_description'],','));
				$i = 0;
				$don_desc_data = array();
				if(!empty($xdesc)){
					$donation_types = $this->donations->get_settings('donation_types', 'value');
					$donation_types = explode(',', $donation_types);
					// Get donation types
					$donation_types_n = array();
					foreach ($donation_types as $value) {
						$value = explode('=', $value);
						$donation_types_n[trim($value[1])] = __(trim($value[0]),'donations');
					}
					foreach ($xdesc as $value) {
					$value = explode('-', $value);
						$xdescar[$i]['type'] = $this->donations->get_donation_assets($value[0],'type');
						$xdescar[$i]['description'] = $this->donations->get_donation_assets($value[0],'description') . ' ' . $this->donations->get_donation_assets($value[0],'unit');
						if(isset($value[2])){
							$xdescar[$i]['price'] = $value[2];
						} else {
							$xdescar[$i]['price'] = '';
						}
						if(isset($value[1])){
							$xdescar[$i]['amount'] = $value[1];
						} else {
							$xdescar[$i]['amount'] = '';
						}
					$i++;
					}				
						foreach ($xdescar AS $k => $sub_array)
						{
						  $this_level = $sub_array['type'];
						  $don_desc_data[$this_level][$k] = array(
						  	'amount' => $sub_array['amount'],
						  	'description' => $sub_array['description'], 
						  	'price' => $sub_array['price'],
						  	'type' => $sub_array['type'],  
						  	'type_name' => $donation_types_n[$sub_array['type']]
						  );
						}
					$don_desc_data = array_values($don_desc_data);
					foreach ($don_desc_data as $key => $value) {
						$don_desc_data[$key] = array_values($don_desc_data[$key]);
					}
				}
				// echo '<pre>'.print_r($don_desc_data, TRUE).'</pre>';
				$data_don = '';
				$html_start = '<html>
							<head>
							<meta http-equiv="Content-Type" content="text/html; charset=US-ASCII">
							</head>
							<body dir="ltr">
							<div id="divtagdefaultwrapper" style="font-size:16px;color:#000000;font-family:Calibri,Helvetica,sans-serif;" dir="ltr">';
				if(!empty($xdesc[0])) {
					
					$data_don .= '<table cellpadding="4" style="font-family:Calibri,Helvetica,sans-serif;">';
					$data_don .= '<thead>
						<tr class="headings" style="background: #8c5f1e; color: #fff;border-radius: 6px;">
						<th class="column-title" style="width: 64px;">'. __('Quantity','donations').'</th>
						<th class="column-title" style="text-align: left;">'. __('Description','donations').'</th>
						<th class="column-title" style="width: 130px; text-align: right;">'. __('Amount in SRD','donations').'</th>
						</tr>
					</thead>
					<tbody>';
					foreach ($don_desc_data as $value) {
							$i = 1;
							foreach ($value as $v) {
								if($i == 1) {
							$data_don .= '<tr style="background: #ffdcaa;">
											<td></td>
											<td><b>'. $v['type_name'] . '</b></td>
										<td></td>
									</tr>';		
								}
							$data_don .= '<tr style="background: #d4d4d4;">
											<td style="text-align: center;">'.$v['amount'] .'</td>
											<td>'. $v['description'] . ' Price SRD '. $v['price'] . '</td>
											<td style="text-align: right;">' . $v['amount']*$v['price'] . '</td>
										</tr>';
							$i++;
							}
						}
					
				}
				if($data_don == '') {
					$data_don .= '<table cellpadding="4" style="font-family:Calibri,Helvetica,sans-serif;">';
					$data_don .= '<thead>
						<tr class="headings" style="background: #8c5f1e; color: #fff;border-radius: 6px;">
						<th class="column-title" style="width: 64px;">'. __('Quantity','donations').'</th>
						<th class="column-title" style="text-align: left;">'. __('Description','donations').'</th>
						<th class="column-title" style="width: 130px; text-align: right;">'. __('Amount in SRD','donations').'</th>
						</tr>
					</thead>
					<tbody>';
				}
				if($data['cash_description'] != '' && $data['cash_amount'] != '') {
						$data_don .= '<tr style="background: #ffdcaa;">
										<td></td>
										<td><b>'. __('Cash', 'donations') . '</b></td>
										<td></td>
									</tr>';
						$data_don .= '<tr style="background: #d4d4d4;">
										<td></td>
										<td>'. nl2br($data['cash_description']) . '</td>
										<td style="text-align: right;">'.$data['cash_amount'].'</td>
									</tr>';
					}

					$data_don .= '</tbody>
								<tfoot>
								<tr style="background: #343434; color: #fff;">
									<th></th>
									<th>'. __('Total donation amount in SRD','donations').'</th>
									<th style="text-align: right;">'. $data['amount'].'</th>
								</tr>
							</tfoot>';
				
					$data_don .= '
							</table><br>';
				// END check types of donations

				// Person information
				$donatee = '';
				$donatee .= '<h2 style="margin-bottom: 4px;">' .__('Donatee information','donations').'</h2>';
				$donatee .= $Person['first_name'] . ' ' . $Person['last_name'].'<br>';
				if(!empty($Foundation)) {
				$donatee .= $Foundation['foundation_name'] .'<br>';	
				}	
				// Donation information
				$donate_info = '';
				$donate_info .= '<h2 style="margin-bottom: 4px;">'.__('Donation information','donations').'</h2>';
				$donate_info .= '<b>'.__('Subject','donations').'</b>: '.$data['title'].'<br>';
				$donor_comp = $this->users->get_companies($data['donated_company']);
				$donate_info .= '<b>'.__('Donor','donations').'</b>: '.$donor_comp['company_name'].'<br>';
				$donate_info .= '<b>'.__('Donation','donations').'</b>';
				// Sent mail add code
				$html_end = '</div>
							</body>
							</html>';
				// Links
					// appove link
					$tk_approve = $this->donations->token_hash('donations:approve_recurring_donation'.$save_id);
					$nonce_approve = $this->donations->token_hash('donations:approve_recurring_donation'.$save_id.$userdata['account']['id']);
					$appove_lnk = url('?token='.$tk_approve.'&action=donations:approve_recurring_donation&request='.$save_id.'&user='.$userdata['account']['id'].'&nonce='.$nonce_approve);
					// disapprove link
					$tk_disapprove = $this->donations->token_hash('donations:disapprove_recurring_donation'.$save_id);
					$nonce_disapprove = $this->donations->token_hash('donations:disapprove_recurring_donation'.$save_id.$userdata['account']['id']);
					$disappove_lnk = url('?token='.$tk_disapprove.'&action=donations:disapprove_recurring_donation&request='.$save_id.'&user='.$userdata['account']['id'].'&nonce='.$nonce_disapprove);
					// End Links
					$approve_or_disapp = '
					<h2 style="margin-bottom: 4px;">'.__('Approve or Disapprove the donation','donations').'</h2>
					<table style="font-family:Calibri,Helvetica,sans-serif;">
						<tr>
							<td>
								<table style="font-family:Calibri,Helvetica,sans-serif;">
								    <tr>
								        <td style="background-color: #81bb29;border-color: #75bc0a;border: 2px solid #75bc0a;text-align: center; border-radius: 6px;padding: 10px;">
								            <a style="display: block;color: #ffffff;font-size: 18px;text-decoration: none;" href="'.$appove_lnk.'">'.__('Approve donation','donations').'</a>
								        </td>
								    </tr>
								</table>
							</td>
							<td>OR</td>
							<td>
								<table style="font-family:Calibri,Helvetica,sans-serif;">
								    <tr>
								        <td style="background-color: #d63338;border-color: #d61117;border: 2px solid #d61117;text-align: center; border-radius: 6px;padding: 10px;">
								            <a style="display: block;color: #ffffff;font-size: 18px;text-decoration: none;" href="'.$disappove_lnk.'">'.__('Disapprove donation','donations').'</a>
								        </td>
								    </tr>
								</table>
							</td>
						</tr>
					</table><br>';
					$tk_viewdon = $this->donations->token_hash('donations:view_recurring_donation'.$save_id);
					$nonce_viewdon = $this->donations->token_hash('donations:view_recurring_donation'.$save_id.$userdata['account']['id']);
					$viewdon_lnk = url('?token='.$tk_viewdon.'&action=donations:view_recurring_donation&request='.$save_id.'&user='.$userdata['account']['id'].'&nonce='.$nonce_viewdon);
					$view_donation_ol = '
					<h2 style="margin-bottom: 4px;">'.__('View the full information on this donation request','donations').'</h2>
					<table style="font-family:Calibri,Helvetica,sans-serif;">
					    <tr>
					        <td style="background-color: #81bb29;border-color: #75bc0a;border: 2px solid #75bc0a;text-align: center; border-radius: 6px;padding: 10px;">
					            <a style="display: block;color: #ffffff;font-size: 18px;text-decoration: none;" href="'.$viewdon_lnk.'">'.__('View complete Donation','donations').'</a>
					        </td>
					    </tr>
					</table><br>';
					$powered = $this->mail_footer();
					// End Links
		return $html_start.$donatee.$donate_info.$data_don.$approve_or_disapp.$view_donation_ol.$powered.$html_end;

	}

	private function mail_footer(){
		$power = $this->appname . ' ' . __('created by') . ' '. '<a style="color:#0e76bc; text-decoration:none; display:inline-block" href="http://www.rucomnv.com/" target="_blank">Rucom IT Solutions N.V.</a>';
		$power = '<div>'.$power.'</div>';
		$confidentiality = '<div>'.__('Due to the confidentiality of this mail, we advise not to forward any of these mails.','donations').'</div>';
		$confidentiality .= '<div>'.__('These mails were sent to specific persons who are allowed to receive them.','donations').'</div>';
		return '<div style="text-align:center; padding:10px 0; margin:40px 0 0 0; border-top: 1px solid #7c5723; border-bottom: 1px solid #7c5723;">'.$confidentiality.$power.'</div>';
	}


}