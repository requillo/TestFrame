<?php 
/**
 * 
 */
class Next_numbers extends Controller
{
	
	function __construct()
	{
		parent::__construct();
		
	}

	function admin_index(){
		$this->title = __('Add order number','next_numbers');
		$check = $this->next_numbers->get_check_update();
		$numbers = $this->next_numbers->get_numbers();
		$this->set('check',$check);
		$this->set('numbers',$numbers);
	}

	function website_index(){
		if(!empty($this->data)){
			$data = array();
			$check = $this->next_numbers->get_check_update();
			$numbers = $this->next_numbers->get_numbers();
			$data['check'] = $check;
			$data['numbers'] = $numbers;
			echo json_encode($data);
		}
		die();
	}

	function rest_add(){
		if(!empty($this->data)){
			$check = $this->next_numbers->get_check_update();
			$this->data['state'] = 1;
			$this->data['status'] = 1;
			$ch  = $this->next_numbers->save($this->data);
			if($ch > 0) {
				$data['update_number'] = $check + 1;
				$this->loadmodel('next_numbers_check');
				$this->next_numbers_check->id = 1;
				$this->next_numbers_check->save($data);
				$numbers = $this->next_numbers->get_numbers(1);
				echo json_encode($numbers);
			}
		}
	}


}