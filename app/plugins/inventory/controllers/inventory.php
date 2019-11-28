<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
/**
* 
*/
class Inventory extends Controller {

	function __construct(){ 
		parent::__construct();
	}

	public function admin_index(){
		$this->title = __('All inventories', 'inventory');
		$cats = $this->inventory->get_all_categories();
		$cats_options =	$this->inventory->all_categories_options();
		$types_options = $this->inventory->all_types_options();
		$items = $this->inventory->get_all_items();
		$inventory = $this->inventory->get_inventory();
		$inv_d = array();
		foreach ($items as $key => $value) {
				$items[$key]['inventory'] = 0;
				$inv_d[$value['id']]['inventory'] = 0;
				$inv_d[$value['id']]['notes'] = '';				
		}
		if(!empty($inventory)) {
			$inv_d = unserialize($inventory['inventory_data']);
		}

		foreach ($inv_d as $key => $value) {
		// 	$inv_d[$key]['name'] = '';
		}

		$this->set('items',$items);
		$this->set('cats_options',$cats_options);
		$this->set('types_options',$types_options);
		$this->set('inv_d',$inv_d);
	}

	public function admin_add_inventory($id = NULL){
		$this->set('type', rtrim($id,'/'));
		$this->title = __('Add Inventory', 'inventory');
		$add_inventory = $this->inventory->get_inventory_add(date('Y-m-d'));
		$inventory_id = $this->inventory->get_inventory(date('Y-m-d'));
		if(!empty($add_inventory)) {
			$this->set('add_inventory', $add_inventory['id']);
			$this->set('inventory_id', $inventory_id['id']);
		} else {
			$this->set('add_inventory', false);
			$this->set('inventory_id', false);
		}
		$cats = $this->inventory->get_all_categories();
		$cats_options =	$this->inventory->all_categories_options();
		$types_options = $this->inventory->all_types_options();
		$items = $this->inventory->get_all_items();
		$inventory = $this->inventory->get_inventory();
		$inv_d = array();
		if(!empty($inventory)) {
			$inv_d = unserialize($inventory['inventory_data']);
		} else {
			foreach ($items as $key => $value) {
				$items[$key]['inventory'] = 0;
				$inv_d[$value['id']]['inventory'] = 0;				
			}
		}
		$this->set('items',$items);
		$this->set('cats_options',$cats_options);
		$this->set('types_options',$types_options);
		
		if(isset($this->data['items'])) {
			$inventory = array();
			$add_item = array();
			$this->set('data', $this->data['items']);
			foreach ($this->data['items'] as $key => $value) {
				if(isset($inv_d[$key])) {
					if($value['add'] != NULL) {
						$inv_d[$key]['inventory'] = $inv_d[$key]['inventory'] + $value['add'];
					}
					$inv_d[$key]['notes'] = $value['notes'];
				}
			}
			$this->loadmodel('inventory_add');
			$add_item['created'] = date('Y-m-d H:i');
			$add_item['inventory_date'] = date('Y-m-d');
			$add_item['created_user'] = $this->user['id'];
			$add_item['status'] = 1;
			$add_item['inventory_data'] = serialize($this->data['items']);
			$inventory['created'] = date('Y-m-d');
			$inventory['inventory_date'] = date('Y-m-d');
			$inventory['created_user'] = $this->user['id'];
			$inventory['inventory_action'] = 'add';
			$inventory['status'] = 1;
			$inventory['inventory_data'] = serialize($inv_d);
			$ch1 = $this->inventory->save($inventory);
			$ch2 = $this->inventory_add->save($add_item);
			if($ch1 > 0 && $ch2 > 0) {
				Message::flash(__('Inventory updated'));
			} else {
				Message::flash(__('Something went wrong!'),'error');
			}
			$this->admin_redirect('inventory');
		}

		$this->set('data', array());
		$this->set('inv_d',$inv_d);
	}

	public function admin_use_inventory($id = NULL){
		$this->set('type', rtrim($id,'/'));
		$this->title = __('Use Inventory', 'inventory'); 
		$use_inventory = $this->inventory->get_inventory_use(date('Y-m-d'));
		$inventory_id = $this->inventory->get_inventory(date('Y-m-d'),'use');
		if(!empty($use_inventory)) {
			$this->set('use_inventory', $use_inventory['id']);
			$this->set('inventory_id', $inventory_id['id']);
		} else {
			$this->set('use_inventory', false);
			$this->set('inventory_id', false);
		}
		$latest_inventory_use = $this->inventory->get_latest_inventory_use(5);
		$cats = $this->inventory->get_all_categories();
		$cats_options =	$this->inventory->all_categories_options();
		$types_options = $this->inventory->all_types_options();
		$items = $this->inventory->get_all_items();
		$inventory = $this->inventory->get_inventory();
		$inv_d = array();
		if(!empty($inventory)) {
			$inv_d = unserialize($inventory['inventory_data']);
		} else {
			foreach ($items as $key => $value) {
				$items[$key]['inventory'] = 0;
				$inv_d[$value['id']]['inventory'] = 0;				
			}
		}
		$this->set('latest_inventory_use',$latest_inventory_use);
		$this->set('items',$items);
		$this->set('cats_options',$cats_options);
		$this->set('types_options',$types_options);
		$this->set('data', array());

		if(isset($this->data['items'])) {
			$this->set('data', $this->data);
			$inventory = array();
			$add_item = array();
			$this->set('data', $this->data['items']);
			foreach ($this->data['items'] as $key => $value) {
				if(isset($inv_d[$key])) {
					if($value['use'] != NULL) {
						$inv_d[$key]['inventory'] = $inv_d[$key]['inventory'] - $value['use'];
					}
					$inv_d[$key]['notes'] = $value['notes'];
				}
			}
			$this->loadmodel('inventory_use');
			$use_item['created'] = date('Y-m-d H:i');
			$use_item['inventory_date'] = date('Y-m-d', strtotime($this->data['inventory_date']));
			$use_item['created_user'] = $this->user['id'];
			$use_item['status'] = 1;
			$use_item['inventory_data'] = serialize($this->data['items']);
			$inventory['created'] = date('Y-m-d H:i');
			$inventory['inventory_date'] = $use_item['inventory_date'];
			$inventory['created_user'] = $this->user['id'];
			$inventory['inventory_action'] = 'use';
			$inventory['status'] = 1;
			$inventory['inventory_data'] = serialize($inv_d);
			$ch1 = $this->inventory->save($inventory);
			$ch2 = $this->inventory_use->save($use_item);
			if($ch1 > 0 && $ch2 > 0) {
				Message::flash(__('Inventory updated'));
			} else {
				Message::flash(__('Something went wrong!'),'error');
			}
			$this->admin_redirect('inventory');
		}
		$this->set('inv_d',$inv_d);
	}

	public function admin_use_inventory_edit($id = NULL) {
		$this->set('type', NULL);
		if($id == NULL) {
			$this->set("id",false);
		} else {
			$this->set("id",$id);
			$use_inventory = $this->inventory->get_inventory_use_from_id($id);
			$inventory = $this->inventory->get_inventory($use_inventory['inventory_date'],'use');
			$items = $this->inventory->get_all_items();
			$inventory_before = $this->inventory->get_inventory_date_before($use_inventory['inventory_date']);
			$inventory_after = $this->inventory->get_inventory_date_after($use_inventory['inventory_date']);
			$inv_d = unserialize($inventory['inventory_data']);
			$inv_u = unserialize($use_inventory['inventory_data']);
			print_r($inv_u);
			$this->set('items',$items);
			$this->set('inv_d',$inv_d);
			$this->set('inv_u',$inv_u);
			$this->set("use_inventory",$use_inventory);
			$this->set("inventory_before",$inventory_before);
			$this->set("inventory_after",$inventory_after);
		}
	}

	public function admin_add_inventory_all(){
		$this->title = __('Add All Inventory', 'inventory');
	}

	public function admin_write_off(){
		$this->title = __('Write off Inventory', 'inventory');
	}

	public function admin_categories(){
		$this->title = __('Inventory categories', 'inventory');
		$cats = $this->inventory->get_all_categories();
		$this->set('cats',$cats);
	}

	public function admin_types(){
		$this->title = __('Inventory Item Types', 'inventory');
		$types = $this->inventory->get_all_types();
		$this->set('types',$types);
	}

	public function admin_inventory_items(){
		$this->title = __('Inventory items', 'inventory');
		$cats = $this->inventory->get_all_categories();
		$cats_options =	$this->inventory->all_categories_options();
		$types_options = $this->inventory->all_types_options();
		$items = $this->inventory->get_all_items();
		$this->set('items',$items);
		$this->set('cats_options',$cats_options);
		$this->set('types_options',$types_options);
	}
/*
* Rest api Item types
*/
	public function rest_add_item_types(){
		if(!empty($this->data)) {
			$data = array();
			$this->loadmodel('inventory_item_types');
			$this->data['created'] = date('Y-m-d H:i:s');
			$this->data['created_user'] = $this->user['id'];
			$this->data['status'] = 1;
			$ch = $this->inventory_item_types->save($this->data);
			if($ch > 0) {
				$data['message'] = 'success';
				Message::flash(__('Added successful'));
			} else {
				$data['message'] = 'failed';
				Message::flash(__('Added failed'),'error');
			}
			echo json_encode($data);
		}
	}

	public function rest_edit_item_types(){
		if(!empty($this->data)) {
			$data = array();
			$this->loadmodel('inventory_item_types');
			$this->data['updated'] = date('Y-m-d H:i:s');
			$this->data['updated_user'] = $this->user['id'];
			$this->inventory_item_types->id = $this->data['id'];
			$ch = $this->inventory_item_types->save($this->data);
			if($ch > 0) {
				$data['message'] = 'success';
				Message::flash(__('Updated successful'));
			} else {
				$data['message'] = 'failed';
				Message::flash(__('Update failed'),'error');
			}

			echo json_encode($data);
		}
		
	}

	public function rest_delete_item_types(){
		if(!empty($this->data)) {
			$data = array();
			$this->loadmodel('inventory_item_types');
			$this->data['updated'] = date('Y-m-d H:i:s');
			$this->data['status'] = 0;
			$this->data['updated_user'] = $this->user['id'];
			$this->inventory_item_types->id = $this->data['id'];
			$ch = $this->inventory_item_types->save($this->data);
			if($ch > 0) {
				$data['message'] = 'success';
				Message::flash(__('Deleted successful'));
			} else {
				$data['message'] = 'failed';
				Message::flash(__('Delete failed'),'error');
			}
			echo json_encode($data);
		}
	}

/*
* Rest api Category
*/
	public function rest_add_category(){
		if(!empty($this->data)) {
			$data = array();
			$this->loadmodel('inventory_categories');
			$this->data['created'] = date('Y-m-d H:i:s');
			$this->data['created_user'] = $this->user['id'];
			$this->data['status'] = 1;
			$ch = $this->inventory_categories->save($this->data);
			if($ch > 0) {
				$data['message'] = 'success';
				Message::flash(__('Added successful'));
			} else {
				$data['message'] = 'failed';
				Message::flash(__('Added failed'),'error');
			}
			echo json_encode($data);
		}
	}

	public function rest_edit_category(){
		if(!empty($this->data)) {
			$data = array();
			$this->loadmodel('inventory_categories');
			$this->data['updated'] = date('Y-m-d H:i:s');
			$this->data['updated_user'] = $this->user['id'];
			$this->inventory_categories->id = $this->data['id'];
			$ch = $this->inventory_categories->save($this->data);
			if($ch > 0) {
				$data['message'] = 'success';
				Message::flash(__('Updated successful'));
			} else {
				$data['message'] = 'failed';
				Message::flash(__('Update failed'),'error');
			}

			echo json_encode($data);
		}
		
	}

	public function rest_delete_category(){
		if(!empty($this->data)) {
			$data = array();
			$this->loadmodel('inventory_categories');
			$this->data['updated'] = date('Y-m-d H:i:s');
			$this->data['status'] = 0;
			$this->data['updated_user'] = $this->user['id'];
			$this->inventory_categories->id = $this->data['id'];
			$ch = $this->inventory_categories->save($this->data);
			if($ch > 0) {
				$data['message'] = 'success';
				Message::flash(__('Deleted successful'));
			} else {
				$data['message'] = 'failed';
				Message::flash(__('Delete failed'),'error');
			}
			echo json_encode($data);
		}
	}
/*
* Rest api Items
*/
	public function rest_add_item(){
		if(!empty($this->data)) {
			$data = array();
			$this->loadmodel('inventory_items');
			$this->data['created'] = date('Y-m-d H:i:s');
			$this->data['created_user'] = $this->user['id'];
			$this->data['status'] = 1;
			$ch = $this->inventory_items->save($this->data);
			if($ch > 0) {
				$data['message'] = 'success';
				Message::flash(__('Added successful'));
			} else {
				$data['message'] = 'failed';
				Message::flash(__('Added failed'),'error');
			}
			echo json_encode($data);
		}
	}
	public function rest_edit_item(){
		if(!empty($this->data)) {
			$data = array();
			$this->loadmodel('inventory_items');
			$this->data['updated'] = date('Y-m-d H:i:s');
			$this->data['updated_user'] = $this->user['id'];
			$this->data['status'] = 1;
			$this->inventory_items->id = $this->data['id'];
			$ch = $this->inventory_items->save($this->data);
			if($ch > 0) {
				$data['message'] = 'success';
				Message::flash(__('Added successful'));
			} else {
				$data['message'] = 'failed';
				Message::flash(__('Added failed'),'error');
			}
			echo json_encode($data);
		}
	}
	public function rest_delete_item(){
		if(!empty($this->data)) {
			$data = array();
			$this->loadmodel('inventory_items');
			$this->data['updated'] = date('Y-m-d H:i:s');
			$this->data['updated_user'] = $this->user['id'];
			$this->data['status'] = 0;
			$this->inventory_items->id = $this->data['id'];
			$ch = $this->inventory_items->save($this->data);
			if($ch > 0) {
				$data['message'] = 'success';
				Message::flash(__('Added successful'));
			} else {
				$data['message'] = 'failed';
				Message::flash(__('Added failed'),'error');
			}
			echo json_encode($data);
		}
	}
}