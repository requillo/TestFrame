<?php 
// Create this Class
class Forms extends Controller {

function __construct() {
	parent::__construct();
	}
	function admin_index(){
		$this->title = __('All forms');
		$forms = $this->forms->get_all_forms();
		$this->set('forms', $forms);
	}

	function admin_add(){
		$this->title = __('Add Form');
		$multilang = $this->forms->option('meta_int', array('name'=>'settings','value'=>'multilang'));
		$langs = $this->forms->option('meta_text', array('name'=>'settings','value'=>'languages'));
		$deflangs = $this->forms->option('meta_str', array('name'=>'settings','value'=>'default_lang'));
		if($multilang == 1) {
			$langarr = json_decode($langs, true);
		} else {
			$langarr = json_decode($deflangs, true);
		}
		foreach ($langarr as $key => $value) {
			if($value == 'en_EN') {
				$langarr[$key] = 'en_US';
			}
		}
		$deflangs = json_decode($deflangs, true);
		$deflang = LANG;
		if($deflang == 'en_EN') {
			$deflang = 'en_US';
		} 
		$this->set('deflang', $deflang);
		$this->set('langs', $langarr);
		if(!empty($this->data)) {
			$this->data['inputs'] = '';
			foreach ($this->data['form'] as $key => $value) {
				$this->data['inputs'] .= '(:'.$key.':)'.$value;
			}
			$this->data['inputs'] .= '(::)';
			$data_input = preg_replace("/\r|\n/", "",$this->data['inputs']);
			$this->data['inputs'] = $data_input;
			$this->data['created'] = date('Y-m=d H:i');
			$this->data['created_user'] = $this->user['id'];
			$this->data['status'] = 1; 
			$ch = $this->forms->save($this->data);
			if($ch > 0) {
				Message::flash(__('Form updated'));
				$this->admin_redirect('forms/configure/'.$ch.'/');
			}
			
		}
	
	}

	function admin_edit($id){
		$this->title = __('Edit Form');
		// Do this for multilang

		$multilang = $this->forms->option('meta_int', array('name'=>'settings','value'=>'multilang'));
		$langs = $this->forms->option('meta_text', array('name'=>'settings','value'=>'languages'));
		$deflangs = $this->forms->option('meta_str', array('name'=>'settings','value'=>'default_lang'));
		if($multilang == 1) {
			$langarr = json_decode($langs, true);
		} else {
			$langarr = json_decode($deflangs, true);
		}
		foreach ($langarr as $key => $value) {
			if($value == 'en_EN') {
				$langarr[$key] = 'en_US';
			}
		}
		$deflangs = json_decode($deflangs, true);
		$deflang = LANG;
		if($deflang == 'en_EN') {
			$deflang = 'en_US';
		} 
		$this->set('deflang', $deflang);
		$this->set('langs', $langarr);
		$this->set('FormData', $this->forms->get_form($id));
		if(!empty($this->data)) {
			$this->data['inputs'] = '';
			foreach ($this->data['form'] as $key => $value) {
				$this->data['inputs'] .= '(:'.$key.':)'.$value;
			}
			$this->data['inputs'] .= '(::)';
			$data_input = preg_replace("/\r|\n/", "",$this->data['inputs']);
			$this->data['inputs'] = $data_input;
			$this->data['created'] = date('Y-m=d H:i');
			$this->data['created_user'] = $this->user['id'];
			$this->data['status'] = 1; 
			$this->forms->id = $id;
			$ch = $this->forms->save($this->data);
			if($ch > 0) {
				Message::flash(__('Form updated'));
			}
			$this->admin_redirect('forms/configure/'.$id.'/');
		}
	}

	function admin_configure($id){
	$this->title = __('Configure Form');
	// Do this for multilang
		$smtp_port = preg_replace('/\s+/', '', $this->forms->get_settings('smtp-port', 'value'));
		$smtp_security = preg_replace('/\s+/', '', $this->forms->get_settings('smtp-security', 'value'));
		$smtp_host = preg_replace('/\s+/', '', $this->forms->get_settings('mail-host', 'value'));
		$smtp_mail = preg_replace('/\s+/', '', $this->forms->get_settings('send-mail', 'value'));
		$smtp_mail_pass = preg_replace('/\s+/', '', $this->forms->get_settings('send-mail-pass', 'value'));
		if($smtp_port != '' && $smtp_security != '' && $smtp_host != '' && $smtp_mail != '' && $smtp_mail_pass != '') {
			$smtp = true;
		} else {
			$smtp = false;
		}
		$multilang = $this->forms->option('meta_int', array('name'=>'settings','value'=>'multilang'));
		$langs = $this->forms->option('meta_text', array('name'=>'settings','value'=>'languages'));
		$deflangs = $this->forms->option('meta_str', array('name'=>'settings','value'=>'default_lang'));
		if($multilang == 1) {
			$langarr = json_decode($langs, true);
		} else {
			$langarr = json_decode($deflangs, true);
		}
		foreach ($langarr as $key => $value) {
			if($value == 'en_EN') {
				$langarr[$key] = 'en_US';
			}
		}
		$deflangs = json_decode($deflangs, true);
		$deflang = LANG;
		if($deflang == 'en_EN') {
			$deflang = 'en_US';
		}
		$FormData = $this->forms->get_form($id);
		$Shortcodes = $this->forms->form_shortcode($FormData['inputs']);
		$this->set('Shortcodes', $this->forms->form_shortcode($FormData['inputs']));
		$this->set('smtp', $smtp);
		$this->set('deflang', $deflang);
		$this->set('langs', $langarr);
		$this->set('FormData', $this->forms->get_form($id));
		$this->set('Id', $id);
		// $this->set('Testform', $this->data);
		$this->set('TheForm',$this->forms->html_form_inputs($FormData['inputs'], NULL, true));
		// Message::flash(__('Form configured'));
		if(!empty($this->data)) {
			if(isset($this->data['use_smpt'])) {
				$this->data['use_smpt'] = 1;
			} else {
				$this->data['use_smpt'] = 0;
			}
			$this->data['send_message'] = '';
			foreach ($this->data['send_html'] as $key => $value) {
				$this->data['send_message'] .= '[:'.$key.':]'.$value;
			}
			$this->data['send_message'] .= '[::]';
			$this->data['thank_you_title'] = '';
			foreach ($this->data['tk_title'] as $key => $value) {
				$this->data['thank_you_title'] .= '[:'.$key.':]'.$value;
			}
			$this->data['thank_you_title'] .= '[::]';
			$this->data['thank_you_message'] = '';
			foreach ($this->data['thank_you'] as $key => $value) {
				$this->data['thank_you_message'] .= '[:'.$key.':]'.$value;
			}
			$this->data['thank_you_message'] .= '[::]';
			$this->forms->id = $id;
			$chid = $this->forms->save($this->data);
			if($ch > 0) {
			Message::flash(__('Form configured'));
			} else {
			Message::flash(__('Form configured'));
			}
			$this->admin_redirect('forms/');
		}
		
	}

	function admin_settings(){
		$this->title = __('Main settings');
		$this->set('Data', $this->forms->get_settings_inputs());
		if(!empty($this->data)) {
			$add = 1;
		$this->set('print', $this->data);
			foreach ($this->data as $key => $value) {
				$this->forms->update_settings_inputs($key, $value);
				Message::flash(__('Update settings successful'));
				$this->admin_redirect('forms/settings/');
			}
		}
	}
}