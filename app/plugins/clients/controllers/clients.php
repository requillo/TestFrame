<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class clients extends controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->enc = new Encrypt(MCRYPT_BLOWFISH, MCRYPT_MODE_CBC);
		$this->PT = array('1' => __('Normal','clients'),'2' =>  __('Business','clients'),'3' =>  __('Diplomatic','clients'));
		$this->TT = array('1' => __('Private' ,'clients') , '2' => __('Business' ,'clients'));
		$this->TS = array('1' => __('Open' ,'clients') , '2' => __('Used' ,'clients') , '3' => __('Refunded' , 'clients'));
		$this->TC = array('1' => '&dollar;' , '2' => '&euro;' );
		$this->Insurance_companies = array('1' => 'Assuria','2' => 'Self Reliance');
		$this->Insurance_area = array('1' => __('Europa (Schengenlanden)','clients'), '2' => __('Caribisch gebied, Nederlandse Antillen, Caricom & Associate states, Dominicaanse Republiek','clients'),'3' => __('De rest van de Wereld','clients'));
		$this->Travel_reason = array('1' => __('Vacation','clients'), '2' => __('Business','clients'));
		$this->Insurance_type = array(
			'1' => __('TRIAS EUROPA KORTLOPEND','clients'),
			'2' => __('TRIAS EUROPA DOORLOPEND','clients'),
			'3' => __('ANNULERINGSVERZEKERING','clients'),
			'4' => __('TRIAS CARIBBEAN KORTLOPEND','clients'),
			'5' => __('TRIAS WERELD KORTLOPEND','clients'),
			'6' => __('TRIAS WERELD DOORLOPEND','clients')
			); 
	}

	public function admin_index(){
		$this->title = __('All Clients','clients');
		$lim = $this->clients->get_setting('clients_per_page','value');
		if(isset($_GET['s'])) {
			$search = $this->clients->search_clients();
			$this->set('Clients', $search);
			$this->set('Paginate',$this->clients->paginate($lim,$this->clients->search_tot(),'clients/'));
		} else {
			$this->set('Clients', $this->clients->get_all_clients());
			$this->set('Paginate', $this->clients->paginate($lim,$this->clients->tot_clients(),'clients/'));
		}
	}

	public function admin_company(){
		if(isset($_GET['c'])) {
		$company = rtrim($_GET['c'],'/');
		$this->title = __('All clients','clients');
		$lim = $this->clients->get_setting('clients_per_page','value');
		$this->set('Clients', $this->clients->get_all_clients(array('key' => 'company', 'value' => $company)));
		$this->set('Paginate', $this->clients->paginate($lim,$this->clients->tot_clients(array('key' => 'company', 'value' => $company)),'clients/company/',array('c')));
		}
		
		// $this->set('Paginate', $this->clients->paginate($lim,$this->clients->tot_clients(),'clients/company/'.$company));
	}

	public function admin_new(){
		$this->title = __('New Clients','clients');
		$this->set('New_fields', $this->clients->get_all_settings('add'));
		if(!empty($this->data)) {
			$f_name = preg_replace('/\s+/', '', $this->data['f_name']);
			$l_name = preg_replace('/\s+/', '', $this->data['l_name']);
			
			if(!empty($f_name) && !empty($l_name)) {
			$this->data['profile_picture'] = $this->clients->behavior->upload_protect('profile_picture',['size' => 5,'dir' => 'clients/profile']);				
				$this->data['date_of_birth'] = date('Y-m-d', strtotime($this->data['date_of_birth']));
				$this->data['user_id'] = $this->user['id'];
				$this->data['edit_date'] = date('Y-m-d H:i:s');
				$this->data['active'] = 1;
				$id = $this->clients->save($this->data);
				if($id > 0) {
					Message::flash(__('Client successfully added'));
					if(isset($this->data['fieldname'])){
						$this->loadmodel('clients_meta');
						$data = array();
						foreach ($this->data['fieldname'] as $key => $value) {
							$data['setting_id'] = $key;
							$data['value'] = $value; 
							$data['client_id'] = $id;
							$data['edit_date'] = date('Y-m-d H:i:s');
							$data['user_id'] = $this->user['id'];
							if($value != '') {
								$this->clients_meta->save($data);
							}
						}

					}
				} else {
					Message::flash(__('Could not add client','clients'));
				}

				if(isset($this->data['save'])){
					if($id != 0) {
						$this->admin_redirect('clients/view/'.$id);
					} else {
						$this->admin_redirect('clients/new');
					}
					
				} else if(isset($this->data['saveclose'])) {
					$this->admin_redirect('clients');
				} else {
					$this->admin_redirect('clients/new');
				}
			} else {
				Message::flash(__('Could not add client, please enter First name and Last name','clients'),'error');
				$this->admin_redirect('clients/new');
			}
		}
		
		// die();
	}
	public function admin_view($id){
		$this->title = __('Client information','clients');
		// Message::flash(__('Client successfully updated'));
		$Client = $this->clients->get_client($id);
		if(!empty($Client)) {
			$visa_expire = $this->clients->get_setting('visa_expire_reminder','value');
			$passport_expire = $this->clients->get_setting('passport_expire_reminder','value');
			$this->set('Client', $this->clients->get_client($id));
			$this->set('Visas', $this->clients->get_clients_visas($id));
			$this->set('Passports', $this->clients->get_client_passport($id));
			$this->set('Tickets', $this->clients->get_clients_tickets($id));
			$this->set('Passport_type', $this->PT);
			$this->set('Travel_type', $this->TT);
			$this->set('Travel_status', $this->TS);
			$this->set('Travel_currency', $this->TC);
			$this->set('Memberships', $this->clients->get_clients_membership($id));
			$this->set('Insurance', $this->clients->get_client_insurance($id));
			$this->set('Insurance_companies', $this->Insurance_companies);
			$this->set('Insurance_type',$this->Insurance_type);
			$this->set('Insurance_area', $this->Insurance_area);
			$this->set('Visa_expire',$visa_expire);
			$this->set('Passport_expire',$passport_expire);
			$field = array();
			$fields = $this->clients->get_all_settings('add');
			$i = 0;
			foreach ($fields as $value) {
				$field[$i]['id'] = $value['id'];
				$field[$i]['name'] = $value['name'];
				$field[$i]['type'] = $value['setting'];
				$field[$i]['meta'] = $this->clients->check_client_meta($value['id'], $id);
				$i++;
			}

			$this->set('Extra_fields', $field);

		}
		

	}

	public function admin_edit($id){
		$this->title = __('Edit client','clients');
		$this->set('Client', $this->clients->get_client($id));
		$field = array();
		$fields = $this->clients->get_all_settings('add');
		$i = 0;
		foreach ($fields as $value) {
			$field[$i]['id'] = $value['id'];
			$field[$i]['name'] = $value['name'];
			$field[$i]['type'] = $value['setting'];
			$field[$i]['meta'] = $this->clients->check_client_meta($value['id'], $id);
			$i++;
		}

		$this->set('Extra_fields', $field);

		if(!empty($this->data)) {
			print_r($this->data);
				
				$f_name = preg_replace('/\s+/', '', $this->data['f_name']);
				$l_name = preg_replace('/\s+/', '', $this->data['l_name']);
				if(!empty($f_name) && !empty($l_name)) {
					$file = $this->clients->behavior->upload_protect('profile_picture',['size' => 5,'dir' => 'clients/profile']);
					if($file != ''){
						$this->data['profile_picture'] = $file;
					}

				$this->data['date_of_birth'] = date('Y-m-d', strtotime($this->data['date_of_birth']));
				$this->data['user_id'] = $this->user['id'];
				$this->data['edit_date'] = date('Y-m-d H:i:s');
				$this->data['active'] = 1;
				$this->clients->id = $id;
				$update = $this->clients->save($this->data);

				if($update != 0) {
					Message::flash(__('Client successfully updated','clients'));
					if(isset($this->data['fieldname'])){
						$this->loadmodel('clients_meta');
						$data = array();
						foreach ($this->data['fieldname'] as $key => $value) {
							$data['setting_id'] = $key;
							$data['value'] = $value; 
							$data['client_id'] = $id;
							$data['edit_date'] = date('Y-m-d H:i:s');
							$data['user_id'] = $this->user['id'];
							$empty = 0;
							if(!empty($this->clients->check_client_meta($key, $id))) {
								$res = $this->clients->check_client_meta($key, $id);
								$this->clients_meta->id = $res['id'];
								$empty = 1;
							}
							if($value != '' && $empty == 0) {
								$this->clients_meta->save($data);
							} else if($empty == 1) {
								$this->clients_meta->save($data);
							}
							
						}

					}
				} else {
					Message::flash(__('Could not update client','clients'),'error');
				}

				if(isset($this->data['save'])){
					$this->admin_redirect('clients/view/'.$id);
				} else if(isset($this->data['saveclose'])) {
					$this->admin_redirect('clients');
				} else {
					$this->admin_redirect('clients/new');
				}
			} else {
				Message::flash(__('Could not update client','clients'),'error');
			}
		}
	}

	public function admin_delete($id){
		$this->data['user_id'] = $this->user['id'];
		$this->data['edit_date'] = date('Y-m-d H:i:s');
		$this->data['active'] = 2;
		$this->clients->id = $id;
		$update = $this->clients->save($this->data);
		if($update != 0) {
			$this->clients->trash_client_passport($id);
			$this->clients->trash_client_visa($id);
			$this->clients->trash_client_ticket($id);
			$this->clients->trash_client_membership($id);
			$this->clients->trash_client_insurance($id);
			Message::flash(__('Client successfully deleted','clients'));
			$this->admin_redirect('clients');
		} else {
			Message::flash(__('Could not delete client','clients'));
			$this->admin_redirect('clients');
		}
	}
	public function admin_settings(){
		$this->title = __('Clients settings','clients');
		$this->set('Main_settings', $this->clients->get_all_settings());
		$this->set('Extra_settings', $this->clients->get_all_settings('add'));
		$add = '';
		if(!empty($this->data)) {
			foreach ($this->data as $key => $value) {
				$i = $this->clients->update_setting($key,$value);
				$add = $add . $i;
			}
		if($add != '') {
		Message::flash(__('Client settings updated','clients'));	
		}
		$this->admin_redirect('clients/settings/');	
		}
		// die();
	}
	public function admin_add_passport($id){
		$Client = $this->clients->get_client($id);
		$this->title = __('Add Passport for','clients').' '. $Client['f_name'].' '.$Client['l_name'];
		$this->set("Client", $Client);
		$this->set('Passport_type', $this->PT);
		$this->loadmodel('clients_passports');
		if(!empty($this->data)) {

			$name = preg_replace('/\s+/', '', $this->data['passport_number']);
			if(!empty($name)) {
				$this->data['copy_document'] = $this->clients_passports->behavior->upload_protect('copy_document',['size' => 5,'dir' => 'clients/passports']);
				$this->data['client_id'] = $id;
				$this->data['start_date'] = date('Y-m-d', strtotime($this->data['start_date']));
				$this->data['end_date'] = date('Y-m-d', strtotime($this->data['end_date'])); 
				$this->data['status'] = 1;
				$this->data['edit_date'] = date('Y-m-d H:i:s');
				$this->data['user_id'] = $this->user['id'];
				$add = $this->clients_passports->save($this->data);
				if($add > 0) {
					Message::flash(__('Passport successfully added','clients'));
					$this->admin_redirect('clients/view/'.$id);
				} else {
					Message::flash(__('Could not add Passport','clients'),'error');
				}
			} else {
				Message::flash(__('Could not add Passport, Passport number is required','clients'),'error');
			}
		}
		
	}
	public function admin_add_insurance($id){
		$Client = $this->clients->get_client($id);
		$this->title = __('Add Insurance for','clients').' '. $Client['f_name'].' '.$Client['l_name'];
		$this->set("Client", $Client);
		$this->set('Insurance_companies', $this->Insurance_companies);
		$this->set('Insurance_area', $this->Insurance_area);
		$this->set('Travel_reason', $this->Travel_reason);
		$this->set('Insurance_type',$this->Insurance_type);
		$this->loadmodel('clients_insurance');
		if(!empty($this->data)) {
			$bad = 0;
			if($this->data['company'] == 2) {
				if($this->data['travel_area'] == 1) {
					$this->data['insurance_type'] = 1;
				} else if($this->data['travel_area'] == 2) {
					$this->data['insurance_type'] = 4;
				} else {
					$this->data['insurance_type'] = 5;
				}

			} else {
				if(isset($this->data['in_type'])) {
					$this->data['insurance_type'] = $this->data['in_type'];
				} else {
					$this->data['insurance_type'] = '';
					$bad = 1;
				}
			}

			$this->data['client_id'] = $id;
			$this->data['start_date'] = date('Y-m-d', strtotime($this->data['start_date']));
			if($this->data['insurance_type'] == 2 || $this->data['insurance_type'] == 6) {
				$this->data['end_date'] = date('Y-m-d', strtotime('+1 year', strtotime($this->data['start_date'])));
			} else {
				$this->data['end_date'] = date('Y-m-d', strtotime($this->data['end_date']));
			}
			 
			$this->data['status'] = 1;
			$this->data['edit_date'] = date('Y-m-d H:i:s');
			$this->data['user_id'] = $this->user['id'];
			$add = 0;
			if($bad == 0) {
			 $add = $this->clients_insurance->save($this->data);	
			}
			if($add > 0) {
				Message::flash(__('Insurance successfully added','clients'));
				$this->admin_redirect('clients/view/'.$id);
			} else {
				Message::flash(__('Could not add Insurance','clients'),'error');
			}
		}
		
	}

	public function admin_edit_insurance($id){
		$Insurance = $this->clients->get_insurance($id);
		$Client = $this->clients->get_client($Insurance['client_id']);
		$this->title = __('Edit Insurance for','clients').' '. $Client['f_name'].' '.$Client['l_name'];
		$this->set("Client", $Client);
		$this->set('Insurance_companies', $this->Insurance_companies);
		$this->set('Insurance_area', $this->Insurance_area);
		$this->set('Travel_reason', $this->Travel_reason);
		$this->set('Insurance_type',$this->Insurance_type);
		$this->set('Insurance',$Insurance);
		$this->loadmodel('clients_insurance');
		if(!empty($this->data)) {
			$bad = 0;
			if($this->data['company'] == 2) {
				if($this->data['travel_area'] == 1) {
					$this->data['insurance_type'] = 1;
				} else if($this->data['travel_area'] == 2) {
					$this->data['insurance_type'] = 4;
				} else {
					$this->data['insurance_type'] = 5;
				}

			} else {
				if(isset($this->data['in_type'])) {
					$this->data['insurance_type'] = $this->data['in_type'];
				} else {
					$this->data['insurance_type'] = $Insurance['insurance_type'];
				}
			}
			$this->data['start_date'] = date('Y-m-d', strtotime($this->data['start_date']));
			if($this->data['insurance_type'] == 2 || $this->data['insurance_type'] == 6) {
				$this->data['end_date'] = date('Y-m-d', strtotime('+1 year', strtotime($this->data['start_date'])));
			} else {
				$this->data['end_date'] = date('Y-m-d', strtotime($this->data['end_date']));
			}
			$this->data['edit_date'] = date('Y-m-d H:i:s');
			$this->data['user_id'] = $this->user['id'];
			$add = 0;
			if($bad == 0) {
			$this->clients_insurance->id = $id;
			$add = $this->clients_insurance->save($this->data);	
			}
			if($add > 0) {
				Message::flash(__('Insurance successfully updated','clients'));
				$this->admin_redirect('clients/view/'.$Insurance['client_id']);
			} else {
				Message::flash(__('Could not update Insurance','clients'),'error');
			}
		}
		
	}

	public function admin_view_insurance($id){
		$Insurance = $this->clients->get_insurance($id);
		$Client = $this->clients->get_client($Insurance['client_id']);
		$this->title = __('Insurance for','clients').' '. $Client['f_name'].' '.$Client['l_name'];
		$this->set("Client", $Client);
		$this->set('Insurance_companies', $this->Insurance_companies);
		$this->set('Insurance_area', $this->Insurance_area);
		$this->set('Travel_reason', $this->Travel_reason);
		$this->set('Insurance_type',$this->Insurance_type);
		$this->set('Insurance',$Insurance);
		$this->loadmodel('clients_insurance');
		if(!empty($this->data)) {
			$bad = 0;
			if($this->data['company'] == 2) {
				if($this->data['travel_area'] == 1) {
					$this->data['insurance_type'] = 1;
				} else if($this->data['travel_area'] == 2) {
					$this->data['insurance_type'] = 4;
				} else {
					$this->data['insurance_type'] = 5;
				}

			} else {
				if(isset($this->data['in_type'])) {
					$this->data['insurance_type'] = $this->data['in_type'];
				} else {
					$this->data['insurance_type'] = $Insurance['insurance_type'];
				}
			}
			$this->data['start_date'] = date('Y-m-d', strtotime($this->data['start_date']));
			if($this->data['insurance_type'] == 2 || $this->data['insurance_type'] == 6) {
				$this->data['end_date'] = date('Y-m-d', strtotime('+1 year', strtotime($this->data['start_date'])));
			} else {
				$this->data['end_date'] = date('Y-m-d', strtotime($this->data['end_date']));
			}
			$this->data['edit_date'] = date('Y-m-d H:i:s');
			$this->data['user_id'] = $this->user['id'];
			$add = 0;
			if($bad == 0) {
			$this->clients_insurance->id = $id;
			$add = $this->clients_insurance->save($this->data);	
			}
			if($add > 0) {
				Message::flash(__('Insurance successfully updated','clients'));
				$this->admin_redirect('clients/view/'.$Insurance['client_id']);
			} else {
				Message::flash(__('Could not update Insurance','clients'),'error');
			}
		}
		
	}

	public function admin_delete_insurance($id){
		$Insurance = $this->clients->get_insurance($id);
		$Client = $this->clients->get_client($Insurance['client_id']);
		$this->loadmodel('clients_insurance');
		$this->clients_insurance->id = $id;
		if(empty($this->data)) {
			$this->data['status'] = 2;
			$this->data['edit_date'] = date('Y-m-d H:i:s');
			$this->data['user_id'] = $this->user['id'];
			$add = $this->clients_insurance->save($this->data);
			if($add > 0) {
				Message::flash(__('Insurance successfully deleted','clients'));
				$this->admin_redirect('clients/view/'.$Insurance['client_id']);
			} else {
				Message::flash(__('Could not delete Insurance','clients'),'error');
			}
		} 	
		
	}

	public function admin_edit_passport($id){
		$passport = $this->clients->get_passport($id);
		$Client = $this->clients->get_client($passport['client_id']);
		$this->title = __('Edit Passport for','clients').' '. $Client['f_name'].' '.$Client['l_name'];
		$this->set('Passport',$passport);
		$this->set("Client",$Client);
		$this->set('Passport_type', $this->PT);
		$this->loadmodel('clients_passports');
		if(!empty($this->data)) {

			$name = preg_replace('/\s+/', '', $this->data['passport_number']);
			if(!empty($name)) {
				$file =  $this->clients_passports->behavior->upload_protect('copy_document',['size' => 5,'dir' => 'clients/passports']);
				if($file != '') {
					$this->data['copy_document'] = $file;
				}
				
				$this->data['start_date'] = date('Y-m-d', strtotime($this->data['start_date']));
				$this->data['end_date'] = date('Y-m-d', strtotime($this->data['end_date'])); 
				$this->data['status'] = 1;
				$this->data['edit_date'] = date('Y-m-d H:i:s');
				$this->data['user_id'] = $this->user['id'];
				$this->clients_passports->id = $id;
				$add = $this->clients_passports->save($this->data);
				if($add > 0) {
					Message::flash(__('Passport successfully updated','clients'));
					$this->admin_redirect('clients/view/'.$passport['client_id']);
				} else {
					Message::flash(__('Could not update Passport','clients'),'error');
				}
			} else {
				Message::flash(__('Could not update Passport, Passport number is required','clients'),'error');
			}
		}
		
	}

	public function admin_delete_passport($id){
		$passport = $this->clients->get_passport($id);
		$this->loadmodel('clients_passports');
		$this->clients_passports->id = $id;
		if(empty($this->data)) {
			$this->data['status'] = 2;
			$this->data['edit_date'] = date('Y-m-d H:i:s');
			$this->data['user_id'] = $this->user['id'];
			$add = $this->clients_passports->save($this->data);
			if($add > 0) {
				Message::flash(__('Passport successfully deleted','clients'));
				$this->admin_redirect('clients/view/'.$passport['client_id']);
			} else {
				Message::flash(__('Could not delete passport','clients'),'error');
			}
		} 
		
	}

	public function admin_add_ticket($id){
		$Client = $this->clients->get_client($id);
		$this->title = __('Add Ticket for','clients').' '. $Client['f_name'].' '.$Client['l_name'];
		$this->set("Client",$Client);
		$this->set("Travel_type", $this->TT);
		$this->set("Status", $this->TS);
		$this->set("Currency", $this->TC);
		$this->loadmodel('clients_tickets');		
		if(!empty($this->data)) {
			$name = preg_replace('/\s+/', '', $this->data['ticket_number']);
			if(!empty($name)) {
				$this->data['copy_document'] = $this->clients_tickets->behavior->upload_protect('copy_document',['size' => 5,'dir' => 'clients/visas']);
				$this->data['client_id'] = $id;
				$this->data['start_date'] = date('Y-m-d', strtotime($this->data['start_date']));
				$this->data['end_date'] = date('Y-m-d', strtotime($this->data['end_date'])); 
				$this->data['status'] = 1;
				$this->data['edit_date'] = date('Y-m-d H:i:s');
				$this->data['user_id'] = $this->user['id'];
				$add = $this->clients_tickets->save($this->data);
				if($add > 0) {
					Message::flash(__('Ticket successfully added','clients'));
					$this->admin_redirect('clients/view/'.$id);
				} else {
					Message::flash(__('Could not add Ticket','clients'),'error');
				}
			} else {
				Message::flash(__('Could not add Ticket, Ticket number is required','clients'),'error');
			}
		}
		
	}

	public function admin_edit_ticket($id){
		$ticket = $this->clients->get_ticket($id);
		$Client = $this->clients->get_client($ticket['client_id']);
		$this->title = __('Edit Ticket for','clients').' '. $Client['f_name'].' '.$Client['l_name'];
		$this->set("Client",$Client);
		$this->set("Travel_type", $this->TT);
		$this->set("Status", $this->TS);
		$this->set("Ticket",$ticket);
		$this->set("Currency", $this->TC);
		$this->loadmodel('clients_tickets');
		if(!empty($this->data)) {
			$name = preg_replace('/\s+/', '', $this->data['ticket_number']);
			if(!empty($name)) {
				$this->data['copy_document'] = $this->clients_tickets->behavior->upload_protect('copy_document',['size' => 5,'dir' => 'clients/visas']);
				$this->data['client_id'] = $ticket['client_id'];
				$this->data['start_date'] = date('Y-m-d', strtotime($this->data['start_date']));
				$this->data['end_date'] = date('Y-m-d', strtotime($this->data['end_date'])); 
				$this->data['status'] = 1;
				$this->data['edit_date'] = date('Y-m-d H:i:s');
				$this->data['user_id'] = $this->user['id'];
				$this->clients_tickets->id = $id;
				$add = $this->clients_tickets->save($this->data);
				if($add > 0) {
					Message::flash(__('Ticket successfully updated','clients'));
					
					$this->admin_redirect('clients/view/'.$ticket['client_id']);
				} else {
					Message::flash(__('Could not update Ticket','clients'),'error');
				}
			} else {
				Message::flash(__('Could not update Ticket, Ticket number is required','clients'),'error');
			}
		}
		
	}

	public function admin_view_ticket($id){
		$ticket = $this->clients->get_ticket($id);
		$Client = $this->clients->get_client($ticket['client_id']);
		$this->title = __('Ticket for','clients').' '. $Client['f_name'].' '.$Client['l_name'];
		$this->set("Client",$Client);
		$this->set("Travel_type", $this->TT);
		$this->set("Status", $this->TS);
		$this->set("Ticket",$ticket);
		$this->set("Currency", $this->TC);
		$this->loadmodel('clients_tickets');
		if(!empty($this->data)) {
			$name = preg_replace('/\s+/', '', $this->data['ticket_number']);
			if(!empty($name)) {
				$this->data['copy_document'] = $this->clients_tickets->behavior->upload_protect('copy_document',['size' => 5,'dir' => 'clients/visas']);
				$this->data['client_id'] = $ticket['client_id'];
				$this->data['start_date'] = date('Y-m-d', strtotime($this->data['start_date']));
				$this->data['end_date'] = date('Y-m-d', strtotime($this->data['end_date'])); 
				$this->data['status'] = 1;
				$this->data['edit_date'] = date('Y-m-d H:i:s');
				$this->data['user_id'] = $this->user['id'];
				$this->clients_tickets->id = $id;
				$add = $this->clients_tickets->save($this->data);
				if($add > 0) {
					Message::flash(__('Ticket successfully updated','clients'));
					
					$this->admin_redirect('clients/view/'.$ticket['client_id']);
				} else {
					Message::flash(__('Could not update Ticket','clients'),'error');
				}
			} else {
				Message::flash(__('Could not update Ticket, Ticket number is required','clients'),'error');
			}
		}
		
	}

	public function admin_delete_ticket($id){
		$ticket = $this->clients->get_ticket($id);
		$this->loadmodel('clients_tickets');
		$this->clients_tickets->id = $id;
		if(empty($this->data)) {
			$this->data['status'] = 2;
			$this->data['edit_date'] = date('Y-m-d H:i:s');
			$this->data['user_id'] = $this->user['id'];
			$add = $this->clients_tickets->save($this->data);
			if($add > 0) {
				Message::flash(__('Ticket successfully deleted','clients'));
				$this->admin_redirect('clients/view/'.$ticket['client_id']);
			} else {
				Message::flash(__('Could delete ticket','clients'),'error');
			}
		} 
		
	}


	public function admin_add_visa($id){
		$Client = $this->clients->get_client($id);
		$this->title = __('Add Visa for','clients').' '. $Client['f_name'].' '.$Client['l_name'];
		$this->set("Client",$Client);
		$this->loadmodel('clients_visas');
		if(!empty($this->data)) {
			$name = preg_replace('/\s+/', '', $this->data['name']);
			if(!empty($name)) {
				$this->data['copy_document'] = $this->clients_visas->behavior->upload_protect('copy_document',['size' => 5,'dir' => 'clients/visas']);
				$this->data['client_id'] = $id;
				$this->data['start_date'] = date('Y-m-d', strtotime($this->data['start_date']));
				$this->data['end_date'] = date('Y-m-d', strtotime($this->data['end_date'])); 
				$this->data['status'] = 1;
				$this->data['edit_date'] = date('Y-m-d H:i:s');
				$this->data['user_id'] = $this->user['id'];
				$add = $this->clients_visas->save($this->data);
				if($add > 0) {
					Message::flash(__('Visa successfully added','clients'));
					$this->admin_redirect('clients/view/'.$id);
				} else {
					Message::flash(__('Could not add Visa','clients'),'error');
				}
			} else {
				Message::flash(__('Could not add Visa, Visa name is required','clients'),'error');
			}
		}
		
	}

	public function admin_edit_visa($id){
		$visa = $this->clients->get_visa($id);
		$Client = $this->clients->get_client($visa['client_id']);
		$this->title = __('Edit Visa for','clients').' '. $Client['f_name'].' '.$Client['l_name'];
		$this->set("Client",$Client);
		$this->set('Visa', $visa);
		$this->loadmodel('clients_visas');
		if(!empty($this->data)){
			$name = preg_replace('/\s+/', '', $this->data['name']);
			if(!empty($name)) {
				$file = $this->clients_visas->behavior->upload_protect('copy_document',['size' => 5,'dir' => 'clients/visas']);
				if($file != ''){
					$this->data['copy_document'] = $file;
				}
				$this->data['start_date'] = date('Y-m-d', strtotime($this->data['start_date']));
				$this->data['end_date'] = date('Y-m-d', strtotime($this->data['end_date'])); 
				$this->data['edit_date'] = date('Y-m-d H:i:s');
				$this->data['user_id'] = $this->user['id'];
				$this->clients_visas->id = $id;
				$add = $this->clients_visas->save($this->data);
				if($add != 0) {
					Message::flash(__('Edit Visa successful','clients'));
					$this->admin_redirect('clients/view/'.$visa['client_id']);
				} else {
					Message::flash(__('Could not update Visa','clients'),'error');
				}
			} else {
				Message::flash(__('Could not update Visa','clients'),'error');
			}
		}
	}

	public function admin_delete_visa($id){
		$visa = $this->clients->get_visa($id);
		$this->loadmodel('clients_visas');
		$this->clients_visas->id = $id;
		$this->data['status'] = 2;
		$this->data['edit_date'] = date('Y-m-d H:i:s');
		$this->data['user_id'] = $this->user['id'];
		$add = $this->clients_visas->save($this->data);
		if($add > 0) {
			Message::flash(__('Visa successfully deleted','clients'));
			$this->admin_redirect('clients/view/'.$visa['client_id']);
		}

	}

	public function admin_add_membership($id){
		$app = App::config('app');
		$Client = $this->clients->get_client($id);
		$this->title = __('Add Membership for','clients').' '. $Client['f_name'].' '.$Client['l_name'];
		$this->set("Client",$Client);
		$this->loadmodel('clients_memberships');
		if(!empty($this->data)) {
			$name = preg_replace('/\s+/', '', $this->data['title']);
			$number = preg_replace('/\s+/', '', $this->data['member_number']);
			$pass = preg_replace('/\s+/', '', $this->data['password']);
			if(!empty($name) && !empty($number) && !empty($pass)) {
				$salt = $this->clients->generateRandomString(14,7);
				$this->data['salt'] = $salt;
				$this->data['password'] = $this->enc->encrypt(htmlspecialchars($this->data['password']), $salt . $app['salt']);
				$this->data['client_id'] = $id;
				$this->data['status'] = 1;
				$this->data['edit_date'] = date('Y-m-d H:i:s');
				$this->data['user_id'] = $this->user['id'];
				$add = $this->clients_memberships->save($this->data);
				if($add > 0) {
					Message::flash(__('Membership successfully added','clients'));
					$this->admin_redirect('clients/view/'.$id);
				} else {
					Message::flash(__('Could not add Membership','clients'),'error');
				}
			} else {
				Message::flash(__('Could not add Membership, all fields are required','clients'),'error');
			}
		}
		
	}

	public function admin_edit_membership($id){
		$app = App::config('app');
		$Membership = $this->clients->get_membership($id);
		$Membership['password'] =  $this->enc->decrypt($Membership['password'], $Membership['salt'] . $app['salt']);
		$Client = $this->clients->get_client($Membership['client_id']);
		$this->title = __('Edit Membership for','clients').' '. $Client['f_name'].' '.$Client['l_name'];
		$this->set("Client",$Client);
		$this->set("Membership",$Membership );
		$this->loadmodel('clients_memberships');
		if(!empty($this->data)) {
			$name = preg_replace('/\s+/', '', $this->data['title']);
			$number = preg_replace('/\s+/', '', $this->data['member_number']);
			$pass = preg_replace('/\s+/', '', $this->data['password']);
			if(!empty($name) && !empty($number) && !empty($pass)) {
				$salt = $this->clients->generateRandomString(14,7);
				$this->data['salt'] = $salt;
				$password = htmlspecialchars_decode($this->data['password']);
				$this->data['password'] = $this->enc->encrypt(htmlspecialchars($password), $salt . $app['salt']);
				$this->data['edit_date'] = date('Y-m-d H:i:s');
				$this->data['user_id'] = $this->user['id'];
				$this->clients_memberships->id = $id;
				$add = $this->clients_memberships->save($this->data);
				if($add > 0) {
					Message::flash(__('Membership successfully updated','clients'));
					$this->admin_redirect('clients/view/'.$Membership['client_id']);
				} else {
					Message::flash(__('Could not update Membership','clients'),'error');
				}
			} else {
				Message::flash(__('Could not update Membership, all fields are required','clients'),'error');
			}
		}
		
	}

	public function admin_delete_membership($id){
		$membership = $this->clients->get_membership($id);
		$this->loadmodel('clients_memberships');
		$this->clients_memberships->id = $id;
		$this->data['status'] = 2;
		$this->data['edit_date'] = date('Y-m-d H:i:s');
		$this->data['user_id'] = $this->user['id'];
		$add = $this->clients_memberships->save($this->data);
		if($add > 0) {
			Message::flash(__('Membership successfully deleted','clients'));
			$this->admin_redirect('clients/view/'.$membership['client_id']);
		}

	}
	public function admin_check_visas(){
		$this->title = __('Visas to expire','clients');
		$visas = $this->clients->get_expired_visas();
		$i = 0;
		foreach ($visas as $value) {
			$visas[$i]['client'] = $this->clients->get_client($value['client_id']);
			$i++;
		}
		$this->set('Visas', $visas);
	}
	public function admin_check_passports(){
		$this->title = __('Passports to expire','clients');
		$passports = $this->clients->get_expired_passports();
		$i = 0;
		foreach ($passports as $value) {
			$passports[$i]['client'] = $this->clients->get_client($value['client_id']);
			$i++;
		}
		$this->set('Passports', $passports);
	}

	public function widget_expire_visas(){
		$evc =  $this->clients->count_expired_visas();
		if($evc > 0){
			$extt = ' <small class="text-danger">('.$evc.')</small>';
		} else {
			$extt = '';
		}
		$this->title = __('Visas to expire','clients').$extt;
		$visas = $this->clients->get_expired_visas('limit');
		$i = 0;
		foreach ($visas as $value) {
			$visas[$i]['client'] = $this->clients->get_client($value['client_id']);
			$i++;
		}
		$this->set('Visas', $visas);
		$this->set('Total',$evc);

	}

	public function widget_expire_passports(){
		$evc = $this->clients->count_expired_passports();
		if($evc > 0){
			$extt = ' <small class="text-danger">('.$evc.')</small>';
		} else {
			$extt = '';
		}
		$this->title = __('Passports to expire','clients').$extt;
		$passports = $this->clients->get_expired_passports('limit');
		$i = 0;
		foreach ($passports as $value) {
			$passports[$i]['client'] = $this->clients->get_client($value['client_id']);
			$i++;
		}
		$this->set('Passports', $passports);
		$this->set('Total',$evc);

	}

	public function widget_memberships($id){
		$this->title = __('Memberships','clients');
		$this->set('Memberships', $this->clients->get_clients_membership($id));
		$this->set('Client', $this->clients->get_client($id));
		$this->set('test','Test vars all the vars');

	}

	public function rest_get_membership(){
		if(isset($this->data['id'])) {
			$app = App::config('app');
			$Membership = $this->clients->get_membership($this->data['id']);
			if($Membership['password'] != '') {
				$Membership['password'] =  $this->enc->decrypt($Membership['password'], $Membership['salt'] . $app['salt']);
			}
			$Client = $this->clients->get_client($Membership['client_id']);
			$Membership['client_name'] =  $Client['f_name'].' '.$Client['l_name'];
			unset($Membership['salt']);
			unset($Membership['client_id']);
			unset($Membership['edit_date']);
			unset($Membership['user_id']);
			unset($Membership['status']);
			echo json_encode($Membership);
		}
		
			
	}

	public function rest_add_fields(){
		$data = array();
		if(!empty($this->data)) {
			$add = 0;
			$this->loadmodel('clients_settings');
			$this->data['setting'] = 'add';
			if($this->data['name'] != '') {
				$add = $this->clients_settings->save($this->data);
			}
			if($add > 0) {
			$data['Key'] = 'Success';
			} else {
			$data['Key'] = 'Failed';	
			}
		}
		echo json_encode($data);
	}

	public function rest_remove_fields(){
		$data = array();
		if(!empty($this->data)) {
			$this->loadmodel('clients_settings');
			$this->data['status'] = 'delete';
			$this->clients_settings->id = $this->data['id'];
			$add = $this->clients_settings->save($this->data);
			if($add > 0) {
			$data['Key'] = 'Success';
			} else {
			$data['Key'] = 'Failed';	
			}
		}
		echo json_encode($data);
	}

	function rest_companies(){
		$data = array();
		if(!empty($this->data)){
			
			$res = $this->clients->get_all_companies($this->data['company']);

			if($res) {
				$val = '<div id="res-group">';
				foreach ($res as $value) {
					$val .= '<div class="opt">'.$value['company'].'</div>';
				}
				$val .= '</div>';



				$data['val'] = $val;
			} else {
				$data['val'] = '';
			}
		}

		echo json_encode($data);

	}

	

}