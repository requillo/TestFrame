<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
/**
* 
*/
class Smiley_survey extends Controller {

	function __construct(){ 
		parent::__construct();
		$this->answer_types = array(
		0 => __('Choose a type', 'smiley_survey'),
		1 => __('Emoticons', 'smiley_survey'),
		2 => __('Text', 'smiley_survey')
		);
	}

	public function admin_index(){
		$this->title = __('Hello', 'smiley_survey');
	}

	public function admin_link_users(){
		$this->title = __('Link users to Companies','smiley_survey');
		$this->loadmodel('users');
		$Users = $this->users->get_all_users($this->user['role_level']);		
		$companies = $this->smiley_survey->get_all_companies();
		$sites_user_relation = $this->smiley_survey->get_all_user_company_relations();
		$user_relation = array();
		if(!empty($sites_user_relation)) {
			foreach ($sites_user_relation as $value) {
				$user_relation[$value['user_id']] = $value['company_id'];
			}
		}
		$companies_arr = array();
		foreach ($companies as $value) {
			$companies_arr[$value['id']] = $value['company'];
		}
		foreach ($Users as $key => $value) {
			if(isset($user_relation[$value['id']]) && isset($companies_arr[$user_relation[$value['id']]])) {
				$Users[$key]['company'] = $user_relation[$value['id']];
				$Users[$key]['company_name'] = $companies_arr[$user_relation[$value['id']]];
			}
		}
		$this->set('Users', $Users);
		$this->set('Sites', $companies_arr);
	}

	public function admin_add_terminal() {
		$this->title = __('Add terminals', 'smiley_survey');
		
		$companies = $this->smiley_survey->get_all_companies();
		$terminals = $this->smiley_survey->get_all_terminals();
		$company_options =  array();
		foreach ($companies as $company) {
			$company_options[$company['id']] = $company['company'];
		}
		$this->set('company_options',$company_options);
		$this->set('terminals',$terminals);
		if(!empty($this->data)) { 
			$req = $this->required_data('terminal');
			if(empty($req)) { 
				$this->loadmodel('smiley_servey_terminals');
				$ch = $this->smiley_servey_terminals->save($this->data);
				if($ch > 0) {
					Message::flash(__('Terminal added','smiley_survey'));
				} else {
					Message::flash(__('Could not add terminal','smiley_survey'),'error');
				}
			} else {
				Message::flash(__('Terminal name is required','smiley_survey'),'error');
			}
			$this->admin_redirect('smiley-survey/add-terminal/');
		}

	}

	public function admin_add_question() {
		$this->title = __('Add question', 'smiley_survey');
		$companies = $this->smiley_survey->get_all_companies();
		$questions = $this->smiley_survey->get_all_questions();
		$terminals = $this->smiley_survey->get_all_terminals();
		$company_options =  array();
		$term_comp = array();
		$terminal_options = array();
		foreach ($companies as $company) {
			$company_options[$company['id']] = $company['company'];
		}
		foreach ($terminals as $terminal) {
			$term_comp[$terminal['id']] = $terminal['company_id'];
			$terminal_options[$terminal['id']] = $terminal['terminal'];
		}
		$this->set('company_options',$company_options);
		$this->set('terminal_options',$terminal_options);
		$this->set('term_comp',$term_comp);
		$this->set('questions',$questions);
		$this->set('answer_types',$this->answer_types);
		if(!empty($this->data)) {
			// Do this for select is empty
			if(!isset($this->data['terminal_id'])) {
				$this->data['terminal_id'] = '';
			}
			if($this->data['type'] == 0) {
				$this->data['type'] = '';
			} 
			if(!isset($this->data['answers'])) {
				$this->data['answers'] = '';
			}
			$req = $this->required_data('terminal_id,question,type,answers');
			print_r($this->data);
			if(empty($req)) { 
				$this->data['terminal_id'] = json_encode($this->data['terminal_id']);
				$this->loadmodel('smiley_servey_questions');
				$this->loadmodel('smiley_servey_answers');
				$this->loadmodel('smiley_servey_feedbacks');
				$ch = $this->smiley_servey_questions->save($this->data);
				if($ch > 0) {
					$da = array();
					Message::flash(__('Question added','smiley_survey'));
					$i = 1;
					foreach ($this->data['answers']['description'] as $key => $value) {
						$da['type'] = $this->data['type'];
						$da['question_id'] = $ch;
						$da['list_order'] = $i;
						if(isset($this->data['answers']['id'][$key])) {
							$da['emoticons_id'] = $this->data['answers']['id'][$key];
						}
						$da['description'] = $value;
						$ca = $this->smiley_servey_answers->save($da);
						if(isset($this->data['answers']['feedback_'.$da['emoticons_id']])) {
							$fbd = array();
							$fi = 1;
							foreach ($this->data['answers']['feedback_'.$da['emoticons_id']] as $ke => $val) {
								if(trim($val) != '') {
									$fbd['list_order'] = $fi;
									$fbd['answer_id'] = $ca;
									$fbd['feedback'] = $val;
									$this->smiley_servey_feedbacks->save($fbd);
									$fi++;
								}
							}
						}
						$i++;
					}
					
				} else {
					Message::flash(__('Could not add question','smiley_survey'),'error');
				}

			} else {
				Message::flash(__('All fields are required!','smiley_survey'),'error');
			}

			$this->admin_redirect('smiley-survey/add-question/');
		}

	}

	public function admin_edit_question($id = NULL) {
		$this->title = __('Edit question', 'smiley_survey');
		$question = $this->smiley_survey->get_question($id);
		$terminal_ids = json_decode($question['terminal_id']);
		$terminals = $this->smiley_survey->get_terminals_from_company(array('terminal' => $terminal_ids[0]));
		$this->set('terminals',$terminals);
		$terminal_options = array();
		foreach ($terminals as $terminal) {
			$terminal_options[$terminal['id']] = $terminal['terminal'];
		}
		$terminals = array();
		foreach ($terminal_ids as $value) {
			$terminals[$value] = $this->smiley_survey->get_terminal_info($value);
		}
		$answers = $this->smiley_survey->get_answers_info($question['id']);
		foreach ($answers as $key => $value) {
			$feedback = $this->smiley_survey->get_feedback_info($value['id']);
			if(!empty($feedback)) {
				$answers[$key]['feedback'] = $feedback;
			}
			if($value['emoticons_id'] != 0) {
				$answers[$key]['icon'] = $this->smiley_survey->get_icon($value['emoticons_id']);
			}
		}
		$company_id = $this->smiley_survey->get_company_from_terminal_id($terminal_ids[0]);
		$company = $this->smiley_survey->get_all_company_info($company_id);
		$question['company'] = $company;
		$question['terminals'] = $terminals;
		$question['answers'] = $answers;
		$this->set('id',$id);
		$this->set('question',$question);
		$this->set('terminal_options',$terminal_options);
		$this->set('terminal_selected',$terminal_ids);
		if(!empty($this->data)) {
			if(!isset($this->data['terminal_id'])) {
				$this->data['terminal_id'] = '';
			} 
			if(!isset($this->data['answers'])) {
				$this->data['answers'] = '';
			}
			$req = $this->required_data('terminal_id,question,answers');
			if(empty($req)) {
				$this->data['terminal_id'] = json_encode($this->data['terminal_id']);
				$this->loadmodel('smiley_servey_questions');
				$this->loadmodel('smiley_servey_answers');
				$this->loadmodel('smiley_servey_feedbacks');
				$this->smiley_servey_questions->id = $id;
				$ch = $this->smiley_servey_questions->save($this->data);
					$da = array();
					Message::flash(__('Question updated','smiley_survey'));
					$i = 1;
					foreach ($this->data['answers']['description'] as $key => $value) {
						$da['list_order'] = $i;
						$da['description'] = $value;
						$this->smiley_servey_answers->id = $key;
						$ca = $this->smiley_servey_answers->save($da);
						if(isset($this->data['answers']['feedback_'.$da['emoticons_id']])) {
							$fbd = array();
							$fi = 1;
							foreach ($this->data['answers']['feedback_'.$da['emoticons_id']] as $ke => $val) {
								if(trim($val) != '') {
									$fbd['list_order'] = $fi;
									$fbd['feedback'] = $val;
									$this->smiley_servey_feedbacks->id = $ke;
									$this->smiley_servey_feedbacks->save($fbd);
									$fi++;
								}
							}
						}
						$i++;
					}
		
			} else {
				Message::flash(__('Could not update question','smiley_survey'),'error');
			}

			$this->admin_redirect('smiley-survey/view-question/'.$id.'/');
		}
	}

	public function admin_view_question($id = NULL) {
		$question = $this->smiley_survey->get_question($id);
		$this->title = $question['question'];
		$terminal_ids = json_decode($question['terminal_id']);
		$terminals = array();
		foreach ($terminal_ids as $value) {
			$terminals[$value] = $this->smiley_survey->get_terminal_info($value);
		}
		$answers = $this->smiley_survey->get_answers_info($question['id']);
		foreach ($answers as $key => $value) {
			$feedback = $this->smiley_survey->get_feedback_info($value['id']);
			if(!empty($feedback)) {
				$answers[$key]['feedback'] = $feedback;
			}
			if($value['emoticons_id'] != 0) {
				$answers[$key]['icon'] = $this->smiley_survey->get_icon($value['emoticons_id']);
			}
		}
		$question['terminals'] = $terminals;
		$question['answers'] = $answers;
		$this->set('id',$id);
		$this->set('question',$question);
	}

	public function admin_emoticons() {
		$this->title = __('Survey company', 'smiley_survey');
		$emoticons = $this->smiley_survey->get_all_emoticons();
		$this->set('emoticons',$emoticons);
		if(!empty($this->data)) { 
			$this->loadmodel('smiley_servey_emoticons');
			$ch = $this->smiley_servey_emoticons->save($this->data);
			if($ch > 0) {
					Message::flash(__('Emoticon added','smiley_survey'));
					
			} else {
					Message::flash(__('Could not add emoticon','smiley_survey'),'error');
			}
			$this->admin_redirect('smiley-survey/emoticons/');
		}
	}

	public function admin_add_companies() {
		$this->title = __('Survey company', 'smiley_survey');
		$this->loadmodel('smiley_servey_companies');
		$companies = $this->smiley_survey->get_all_companies();
		$this->set('companies',$companies);
		if(!empty($this->data)) {
			$req = $this->required_data('company,address,telephone');
			if(empty($req)) {
				
				$api_key = $this->get_company_api();
				$this->data['company_key'] = $api_key;
				$ch = $this->smiley_servey_companies->save($this->data);
				if($ch > 0) {
					Message::flash(__('Company added','smiley_survey'));
					
				} else {
					Message::flash(__('Could not add company','smiley_survey'),'error');
				}
				
			} else {
				Message::flash(__('Check required fields!','smiley_survey'),'error');
			}
			$this->admin_redirect('smiley-survey/add-companies/');
		}
		
	}

	private function get_company_api($api = NULL){
		if($api == NULL) {
			$api = strtoupper($this->smiley_survey->generateRandomString(8,9,false));
		}
		$api_e = $this->smiley_survey->get_company_api($api);
		if (!empty($api_e)) {
			$api = $this->get_company_api();
		}
		return $api;
	}

	public function rest_file_upload(){
		if(isset($this->data['image_upload'])) {
			$document = $this->smiley_survey->behavior->upload_ajax('image_upload',array('size' => 3,'dir' => 'smiley_survey/companies'));
			echo $document;
		} else if(isset($this->data['image_emoticons'])) {
			$document = $this->smiley_survey->behavior->upload_ajax('image_emoticons',array('size' => 3,'dir' => 'smiley_survey/emoticons'));
			echo $document;
		} 				
	}

	public function rest_get_terminals(){
		if(isset($this->data['company_id'])) {
			$terminals = $this->smiley_survey->get_all_terminals($this->data['company_id']);
			$term =  array();
			$term['has_options'] = 'no';
			$term['options'] = '';
			if(!empty($terminals)) {
				$term['has_options'] = 'yes';
				foreach ($terminals as $terminal) {
				$term['options'] .= '<li class="ui-state-default">';
				$term['options'] .= '<input class="flat" type="checkbox" id="terminal_'.$terminal['id'].'" name="data[terminal_id][]" value="'.$terminal['id'].'"> <label for="terminal_'.$terminal['id'].'">'.$terminal['terminal'].'</label> ';
				$term['options'] .= '</li>';
				}
			}
			echo json_encode($term);
		}				
	}

	public function rest_get_emoticons(){
		$emoticons = $this->smiley_survey->get_all_emoticons();
		foreach ($emoticons as $key => $value) {
			$emoticons[$key]['image_svg'] = get_media($value['image_svg']);
		}
		echo json_encode($emoticons);
	}

		public function rest_update_user_relation(){
		$data = array();
		$data['add'] = 'nothing';
		$dd = array();
		if(!empty($this->data)){ // sites_user_relation
			$company_user_relation = $this->smiley_survey->get_all_user_company_relations();
			$user_relation = array();
			if(!empty($company_user_relation)) {
				foreach ($company_user_relation as $value) {
					$user_relation[$value['user_id']] = $value['id'];
				}
			}
			$this->loadmodel('smiley_servey_users');
			if(!empty($this->data['userids'])) {
				$dd['added'] = date('Y-m-d H:i:s');
				$dd['added_user'] = $this->user['id'];
				$dd['status'] = 1;
				foreach ($this->data['userids'] as $value) {
					$dd['user_id'] = $value;
					if($this->data['bulk'] == 1) {
						$dd['company_id'] = $this->data['site'];
					} else {
						$dd['company_id'] = 0;
					}
					
					if(isset($user_relation[$value])) {
						$this->smiley_servey_users->id = $user_relation[$value];
					} else {
						$this->smiley_servey_users->id = NULL;
					}
					$ch = $this->smiley_servey_users->save($dd);
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