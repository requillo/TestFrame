<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Intake_clients extends controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function website_index(){

	}
	public function website_page_test(){

	}
	public function website_widget_test(){

	}

	public function admin_index(){
		$lim = $this->intake_clients->get_settings('intake_limit');
		$this->title = __('All Intakes','intake_clients');
		$ids = $this->intake_clients->search_intake_clients_index();	
		if($ids != 1) {
			$intake_results = array();
			foreach ($ids as $id) {
				$intakes = $this->intake_clients->get_intakes($id['id']);
				$intake_results = array_merge($intake_results, $intakes);
			}
			$tot = 0;
		} else {
			$intake_results = $this->intake_clients->get_intakes();
			$tot = $this->intake_clients->tot_intakes();
		}
		$this->set('Intakes', $intake_results);
		$this->set('Paginate', $this->intake_clients->paginate($lim,$tot,'intake-clients/'));
	}

	public function admin_new($id = NULL){
		$this->title = __('Add new Intakes','intake_clients');
		$this->set('Client', $this->intake_clients->get_the_client($id));
		$this->set('Data', $this->data);
		if(!empty($this->data)){
			print_r($this->data);
			$this->loadmodel('intake');
			$intake_type = preg_replace('/\s+/', '', $this->data['intake_type']);
			$intake_brand = preg_replace('/\s+/', '', $this->data['intake_brand']);
			$intake_model = preg_replace('/\s+/', '', $this->data['intake_model']);
			$problem_text = preg_replace('/\s+/', '', $this->data['problem_text']);
			if(isset($this->data['client_id']) && !empty($intake_type) && !empty($intake_brand) && !empty($intake_model) && !empty($problem_text) ) {
				$data = array();
				$data['status'] = 1;
				$intake_type_id = $this->intake_clients->get_intake_type_id($this->data['intake_type']);
				$intake_brand_id = $this->intake_clients->get_intake_brand_id($this->data['intake_brand']);
				if($intake_type_id > 0) {
					$data['intake_type'] = $intake_type_id;
				} else { 
					$this->loadmodel('intake_types');
					$data['product_type'] = $this->data['intake_type'];
					$intake_type_id = $this->intake_types->save($data);
					$data['intake_type'] = $intake_type_id;
				}

				if($intake_brand_id > 0) {
					$data['intake_brand'] = $intake_brand_id;
				} else { 
					$this->loadmodel('intake_brands');
					$data['product_brand'] = $this->data['intake_brand'];
					$intake_brand_id = $this->intake_brands->save($data);
					$data['intake_brand'] = $intake_brand_id;
				}
					
				$data['client_id'] = $this->data['client_id'];
				$data['intake_model'] = $this->data['intake_model'];
				$data['problem_text'] = $this->data['problem_text'];
				$data['work_solving'] = $this->data['work_solving'];
				$data['pub_date'] = date('Y-m-d H:i:s');
				$data['user_id'] = $this->user['id'];

				if(isset($this->data['add_charger'])) {
					$file1 = $this->intake->behavior->upload('charger_photo',['size' => 10,'dir' => 'intake/docs']);
					$file2 = $this->intake->behavior->upload('extra_photo',['size' => 10,'dir' => 'intake/docs']);
					if($file1 != '') {
						$data['intake_model_charger_doc'] = $file1;
					}

					if($file2 != '') {
						$data['intake_model_extra_doc'] = $file2;
					}
					
					$data['intake_model_charger'] = $this->data['charger_text'];
				}
				
				$add = $this->intake->save($data);

				if($add > 0) {
					Message::flash(__('Save intake successful','intake_clients'));
					$this->admin_redirect('intake-clients/view/'.$add.'/');
				} else {
					Message::flash(__('Could not save the intake','intake_clients'),'error');
				}
				
				

			} else if(!isset($this->data['client_id'])) {
				$this->loadmodel('intake_registered_clients');
				$this->data['pub_date'] = date('Y-m-d H:i:s');
				$this->data['user_id'] = $this->user['id'];
				$this->data['status'] = 1;
				$f_name = preg_replace('/\s+/', '', $this->data['f_name']);
				$l_name = preg_replace('/\s+/', '', $this->data['l_name']);
				$address = preg_replace('/\s+/', '', $this->data['address']);
				$telephone = preg_replace('/\s+/', '', $this->data['telephone']);
				$company = preg_replace('/\s+/', '', $this->data['company']);
				$add_id = 0;
				if(!empty($intake_type) && !empty($intake_brand) && !empty($intake_model) && !empty($problem_text) && !empty($f_name) && !empty($l_name) && !empty($address) && !empty($telephone)) {
				 $add_id = $this->intake_registered_clients->save($this->data);	
				} else if(!empty($intake_type) && !empty($intake_brand) && !empty($intake_model) && !empty($problem_text) && !empty($company) && !empty($address) && !empty($telephone)){
				$add_id = $this->intake_registered_clients->save($this->data);
				} else {
					Message::flash(__('Could not save the intake','intake_clients'),'error');
				}
				
				if($add_id > 0){
					$data = array();
					$data['status'] = 1;
					$intake_type_id = $this->intake_clients->get_intake_type_id($this->data['intake_type']);
					$intake_brand_id = $this->intake_clients->get_intake_brand_id($this->data['intake_brand']);
					if($intake_type_id > 0) {
						$data['intake_type'] = $intake_type_id;
					} else { 
						$this->loadmodel('intake_types');
						$data['product_type'] = $this->data['intake_type'];
						$intake_type_id = $this->intake_types->save($data);
						$data['intake_type'] = $intake_type_id;
					}

					if($intake_brand_id > 0) {
						$data['intake_brand'] = $intake_brand_id;
					} else { 
						$this->loadmodel('intake_brands');
						$data['product_brand'] = $this->data['intake_brand'];
						$intake_brand_id = $this->intake_brands->save($data);
						$data['intake_brand'] = $intake_brand_id;
					}
					$data['client_id'] = $add_id;
					$data['intake_model'] = $this->data['intake_model'];
					$data['problem_text'] = $this->data['problem_text'];
					$data['work_solving'] = $this->data['work_solving'];
					$data['pub_date'] = date('Y-m-d H:i:s');
					$data['user_id'] = $this->user['id'];
					if(isset($this->data['add_charger'])) {
						$file1 = $this->intake->behavior->upload('charger_photo',['size' => 10,'dir' => 'intake/docs']);
						$file2 = $this->intake->behavior->upload('extra_photo',['size' => 10,'dir' => 'intake/docs']);
					if($file1 != '') {
						$data['intake_model_charger_doc'] = $file1;
					}

					if($file2 != '') {
						$data['intake_model_extra_doc'] = $file2;
					}
					
					$data['intake_model_charger'] = $this->data['charger_text'];
					}
					$add = $this->intake->save($data);

				if($add > 0) {
					Message::flash(__('Save intake successful','intake_clients'));
					$this->admin_redirect('intake-clients/view/'.$add.'/');
				} else {
					Message::flash(__('Could not save the intake','intake_clients'),'error');
				}
				}

			} else {
				Message::flash(__('Could not save the intake','intake_clients'),'error');
			}
		}

	}

	public function admin_edit($id = NULL){
		$this->title = __('Edit Intake','intake_clients');
		$Intake = $this->intake_clients->get_the_intake($id);
		$Client = $this->intake_clients->get_the_client($Intake['client_id']);
		$this->set('Intake',$Intake);
		$this->set('Client',$Client);
		$this->set('Clients_array',$this->intake_clients->clients_array());
		
		if(!empty($this->data)){
			$data = array();
			$data['status'] = 1;
			$this->loadmodel('intake');
			if(isset($this->data['other-client'])){
				$this->data['client_id'] = $this->data['new-client'];
			}

			$intake_type_id = $this->intake_clients->get_intake_type_id($this->data['intake_type']);
			$intake_brand_id = $this->intake_clients->get_intake_brand_id($this->data['intake_brand']);

			if($intake_type_id > 0) {
				$this->data['intake_type'] = $intake_type_id;
			} else { 
				$this->loadmodel('intake_types');
				$data['product_type'] = $this->data['intake_type'];
				$intake_type_id = $this->intake_types->save($data);
				$this->data['intake_type'] = $intake_type_id;
			}

			if($intake_brand_id > 0) {
				$this->data['intake_brand'] = $intake_brand_id;
			} else { 
				$this->loadmodel('intake_brands');
				$data['product_brand'] = $this->data['intake_brand'];
				$intake_brand_id = $this->intake_brands->save($data);
				$this->data['intake_brand'] = $intake_brand_id;
			}
			if(isset($this->data['add_charger'])) {
				$file1 = $this->intake->behavior->upload('charger_photo',['size' => 10,'dir' => 'intake/docs']);
				$file2 = $this->intake->behavior->upload('extra_photo',['size' => 10,'dir' => 'intake/docs']);
				if($file1 != '') {
					$this->data['intake_model_charger_doc'] = $file1;
				}
				if($file2 != '') {
					$this->data['intake_model_extra_doc'] = $file2;
				}
				$this->data['intake_model_charger'] = $this->data['charger_text'];
			}
		$this->intake->id = $id;
		$add = $this->intake->save($this->data);
		if($add > 0) {
				Message::flash(__('Intake updated successful','intake_clients'));
				$this->admin_redirect('intake-clients/view/'.$id.'/');
			} else {
				Message::flash(__('Could not updated the intake','intake_clients'),'error');
			}

		}
		$this->set('Data', $this->data);
		
	}

	public function admin_view_client($id = NULL){
		$this->title = __('Client information','intake_clients');
		$this->set('Client', $this->intake_clients->get_the_client($id));
		$this->set('Intakes', $this->intake_clients->get_intakes($id));
	}

	public function admin_edit_client($id = NULL){
		$this->title = __('Edit Client information','intake_clients');
		$this->set('Client', $this->intake_clients->get_the_client($id));
		if(!empty($this->data)){
			$this->loadmodel('intake_registered_clients');
			$this->intake_registered_clients->id = $id;
			if($this->data['f_name'] != '' && $this->data['l_name'] != '' && $this->data['address'] != '' && $this->data['telephone'] != '') {
				$this->data['user_id_edit'] = $this->user['id'];
				$this->data['edit_date'] = date('y-m-d H:i:s');
				$add = $this->intake_registered_clients->save($this->data);
				if($add > 0) {
					Message::flash(__('Update client successful','intake_clients'));
					$this->admin_redirect('intake-clients/view-client/'.$id.'/');
				} else {
					Message::flash(__('Could not update client','intake_clients'),'error');
				}
			}
		}
	}

	public function admin_invoices($id = NULL){
		$this->title = __('Invoices','intake_clients');
		$this->set('Intake_id', $id);
		$this->set('Intakes', $this->intake_clients->get_intakes_for_invoice($id));
	}

	public function admin_add_invoice($id = NULL){
		$this->title = __('Add invoice','intake_clients');
		$this->set('Intake_id', $id);
		$Intakes = $this->intake_clients->get_intakes_for_invoice($id);
		$this->set('Intakes', $Intakes);
		$Invoices = array(); 
		$Invoices[0] = __('Choose intake','intake_clients');
		foreach ($Intakes as $value) {
			$Invoices[$value['id']] = $value['admin_num'] . ' - '. $value['client']['f_name'] . ' ' . $value['client']['l_name'];
		}
		$this->set('Invoices', $Invoices);
	}

	public function admin_settings(){
		$this->title = __('Settings','intake_clients');
		$this->set('Data', $this->intake_clients->get_settings_inputs());
		if(!empty($this->data)) {
			$add = 1;
		$this->set('print', $this->data);
			foreach ($this->data as $key => $value) {
			$this->intake_clients->update_settings_inputs($key, $value);
			Message::flash(__('Update settings successful','intake_clients'));
			$this->admin_redirect('intake-clients/settings/');
			}
		} else {
		$this->set('print', '');		
		}
		
	}

	public function admin_qr_scan(){
		$this->title = __('Scan QR code','intake_clients');
		
	}

	public function admin_view($id = NULL){
		$this->set('Intake',  $this->intake_clients->get_the_intake($id));
		$set_data = $this->intake_clients->get_all_settings();
		$intake_set = array();
		foreach ($set_data as $value) {
			$intake_set[$value['meta']] = $value['value'];
		}
		$this->set('Intake_set',  $intake_set);
	}

	public function rest_get_intake_clients(){
		$data = array();
		if(!empty($this->data)) {
			$add = 0;
			if(isset($this->data['f_name'])) {
				$res = $this->intake_clients->search_intake_clients(array('f_name' => $this->data['f_name']));
			} else {
				$res = $this->intake_clients->search_intake_clients(array('l_name' => $this->data['l_name']));
			}
			$val = '';
			if(!empty($res)) {
			$data['Key'] = 'Success';
			$val .= '<div id="res-group">';
				foreach ($res as $value) {
					$val .= '<div class="opt" data-id="'.$value['id'].'">'.$value['f_name'].' ';
					$val .= $value['l_name'].' '.'('.$value['telephone'].')'.'</div>';
				}
			$val .= '</div>';
			$data['Results'] = $val;
			} else {
			$data['Key'] = 'Failed';
			$data['Results'] = $val;	
			}
		}
		echo json_encode($data);
	}

	public function rest_get_intake_product_types(){
		$data = array();
		if(!empty($this->data)) {		
			$res = $this->intake_clients->search_intake_product_types($this->data['intake_type']);
			$val = '';
			if(!empty($res)) {
			$data['Key'] = 'Success';
			$val .= '<div id="res-group">';
				foreach ($res as $value) {
					$val .= '<div class="opt">'.$value['product_type'].'</div>';
				}
			$val .= '</div>';
			$data['Results'] = $val;
			} else {
			$data['Key'] = 'Failed';
			$data['Results'] = '';	
			}
		}
		echo json_encode($data);
	}

	public function rest_get_intake_product_brands(){
		$data = array();
		if(!empty($this->data)) {		
			$res = $this->intake_clients->search_intake_product_brands($this->data['intake_brand']);
			$val = '';
			if(!empty($res)) {
			$data['Key'] = 'Success';
			$val .= '<div id="res-group">';
				foreach ($res as $value) {
					$val .= '<div class="opt">'.$value['product_brand'].'</div>';
				}
			$val .= '</div>';
			$data['Results'] = $val;
			} else {
			$data['Key'] = 'Failed';
			$data['Results'] = '';	
			}
		}
		echo json_encode($data);
	}

	public function rest_get_intake_product_models(){
		$data = array();
		if(!empty($this->data)) {		
			$res = $this->intake_clients->search_intake_product_models($this->data['intake_model']);
			$val = '';
			if(!empty($res)) {
			$data['Key'] = 'Success';
			$val .= '<div id="res-group">';
				foreach ($res as $value) {
					$val .= '<div class="opt">'.$value['intake_model'].'</div>';
				}
			$val .= '</div>';
			$data['Results'] = $val;
			} else {
			$data['Key'] = 'Failed';
			$data['Results'] = '';	
			}
		}
		echo json_encode($data);
	}
}
