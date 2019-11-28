<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Rubrieken extends controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function admin_index(){
		$this->title = __('All Rubrieken','rubrieken');
		$rubrieken = $this->rubrieken->get_rubrieken();
		foreach ($rubrieken as $key => $value) {
			$rubrieken[$key]['ads'] = $this->rubrieken->get_rubrieken_ads($value['id']);
		}

		$this->set('Rubrieken', $rubrieken);
		$this->set('Category', $this->rubrieken->get_all_the_cats());
		
	}

	public function admin_new(){
		$this->title = __('Add new Rubriek','rubrieken');
		$this->set('Cats_options', $this->rubrieken->get_all_cats());
		$this->set('data', '');
		$price_chars = $this->rubrieken->get_settings('*', 'price_chars','ORDER BY name * 1 ASC');
		$this->set('price_chars', $price_chars);
		$totalprice = 0;
		$limits = array(); 
		$price = array();
		foreach ($price_chars as $key => $value) {
			$limits[$key] = $value['name'];
			$price[$value['name']] = $value['value'];
		}
		
		if(!empty($this->data)){
				$this->data['talli_year'] = date('Y');
				$this->data['user_id'] = $this->user['id'];
				$this->data['pub_date'] = date('Y-m-d H:i:s');
				$this->data['status'] = 1;
				//$id = $this->rubrieken->save($this->data);
				//$this->loadmodel('rubrieken_advertisements');

			foreach ($this->data['content'] as $key => $value) {
				$content = str_replace(' ', '', $value);
				$content = trim(preg_replace('/\s+/', '', $content));
				$dateslength = count(explode(',', $this->data['dates'][$key]));
				$this->data['ads'][$key]['content'] = $value;
				$this->data['ads'][$key]['dates'] = $this->data['dates'][$key];
				$this->data['ads'][$key]['num_days'] = $dateslength;
				$this->data['ads'][$key]['rubriek_category'] = $this->data['cat'][$key];
				$this->data['ads'][$key]['chars'] = mb_strlen(html_entity_decode($content, ENT_QUOTES, 'UTF-8'));
				$this->data['ads'][$key]['chars_lim'] = $this->rubrieken->closest($limits, $this->data['ads'][$key]['chars']);
				$this->data['ads'][$key]['per_price'] = $price[$this->data['ads'][$key]['chars_lim']];
				$this->data['ads'][$key]['per_price_total'] = $price[$this->data['ads'][$key]['chars_lim']]*$dateslength;
				$totalprice = $totalprice + $this->data['ads'][$key]['per_price_total'];
			}
			$this->data['total_price'] = $totalprice;
			$this->set('data', $this->data);
			$id = $this->rubrieken->save($this->data);
			$this->loadmodel('rubrieken_advertisements');
			if($id > 0) {
				foreach ($this->data['ads'] as $value) {
				$value['rubriek_id'] = $id;
				$value['status'] = 1;
				$add = $this->rubrieken_advertisements->save($value);
				$add = $add * $add;
				}
				if($add > 0) {
					Message::flash(__('Rubriek saved successfully','rubrieken'));
					$this->admin_redirect('rubrieken');
				} else {
					Message::flash(__('Could not save Rubriek','rubrieken'),'error');
				}

			} else {
				Message::flash(__('Talli number is already used this year','rubrieken'),'error');
			}
			
		}

	}

	public function admin_settings(){
		$this->title = __('Settings','rubrieken');
		$this->set('Cats_options', $this->rubrieken->get_all_cats());
		if(!empty($this->rubrieken->get_settings('name, value', 'price_chars'))) {
			$this->set('price_chars', $this->rubrieken->get_settings('*', 'price_chars','ORDER BY name * 1 ASC'));
		} else {
			$this->set('price_chars', '');
		}
		$this->set('Cats', $this->rubrieken->get_all_cats_settings());

		if(!empty($this->data)){
			if(isset($this->data['add_limits'])){
				$this->loadmodel('rubrieken_settings');
				$this->data['meta'] = 'price_chars';
				$this->data['status'] = 1;
				$this->data['name'] = $this->data['start_limit'];
				$this->data['value'] = $this->data['start_price'];
				for ($x = 1; $x <= $this->data['total']; $x++) {
					$add = $this->rubrieken_settings->save($this->data);
					$this->data['name'] = $this->data['name'] + $this->data['limit_increment'];
					$addprice = ((float)$this->data['value']*(float)$this->data['price_increment'])/100;
					$addprice = round($addprice,2,PHP_ROUND_HALF_DOWN);
					$this->data['value'] = (float)$this->data['value']+$addprice;
				}
				if($add > 0) {
					Message::flash(__('Charater limits saved','rubrieken'));
					$this->admin_redirect('rubrieken/settings/');
				}
				

			}

		}
		
	}

	public function admin_delete_category($id){
		$this->loadmodel('rubrieken_categories');
		$this->rubrieken_categories->id = $id;
		$this->data['status'] = 0;
		$add = $this->rubrieken_categories->save($this->data);
		if($add > 0 ){
			Message::flash(__('Category successfully deleted','rubrieken'));
			$this->admin_redirect('rubrieken/settings/');
		} else {
			Message::flash(__('Could not delete category','rubrieken'),'error');
			$this->admin_redirect('rubrieken/settings/');
		}

	}

	public function rest_update_char_limit(){
		$data = array();
		if(!empty($this->data)) {
			$add = 0;
			$this->loadmodel('rubrieken_settings');
			$this->rubrieken_settings->id = $this->data['id'];
				$add = $this->rubrieken_settings->save($this->data);
			if($add > 0) {
			$data['Key'] = 'Success';
			Message::flash(__('Charater limit saved','rubrieken'));
			} else {
			$data['Key'] = 'Failed';
			Message::flash(__('Could not save Charater limit','rubrieken'),'error');	
			}
		}
		echo json_encode($data);
	}

	public function rest_add_category(){
		$data = array();
		if(!empty($this->data)) {
			$add = 0;
			$this->loadmodel('rubrieken_categories');
			$this->data['status'] = 1;
			$add = $this->rubrieken_categories->save($this->data);
			if($add > 0) {
			$data['Key'] = 'Success';
			Message::flash(__('Category added','rubrieken'));
			} else {
			$data['Key'] = 'Failed';
			Message::flash(__('Could not add category','rubrieken'),'error');	
			}
		}
		echo json_encode($data);
	}
	public function rest_update_category(){
		$data = array();
		if(!empty($this->data)) {
			$add = 0;
			$this->loadmodel('rubrieken_categories');
			$this->rubrieken_categories->id = $this->data['id'];
			$add = $this->rubrieken_categories->save($this->data);
			if($add > 0) {
			$data['Key'] = 'Success';
			Message::flash(__('Category updated','rubrieken'));
			} else {
			$data['Key'] = 'Failed';
			Message::flash(__('Could not update category','rubrieken'),'error');	
			}
		}
		echo json_encode($data);
	}
}
