<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class pages extends controller
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function admin_index(){
		$this->title = __('All pages');
		$homepage = $this->pages->option('meta_int', array('name'=>'page','value'=>'index'));
		$this->set('pages', $this->pages->get_all_pages());
		$this->set('homepage', $homepage);
	}

	public function admin_new(){
		$this->title = __('New pages');
		$this->loadmodel('forms');
		$forms = $this->forms->get_all_forms();
		$formsoptions = array();
		$formsoptions[0] = __('No form connected to page');
		foreach ($forms as $value) {
			$formsoptions[$value['id']] = $value['name'];
		}
		// Do this for multilang
		$multilang = $this->pages->option('meta_int', array('name'=>'settings','value'=>'multilang'));
		$langs = $this->pages->option('meta_text', array('name'=>'settings','value'=>'languages'));
		$deflangs = $this->pages->option('meta_str', array('name'=>'settings','value'=>'default_lang'));
		
		if($multilang == 1) {
			$langarr = json_decode($langs, true);
		} else {
			$langarr = json_decode($deflangs, true);
		}
		$this->set('langs', $langarr);
		$this->set('Formsoptions', $formsoptions);
		$current_lang = rtrim(LANG_ALIAS,'/');
		$def_lang = rtrim(DEFAULT_LANG_ALIAS,'/');
		$this->set('current_lang', $current_lang);
		if(!empty($this->data)) {
			$this->data['created'] = date('Y-m-d H:i:s');
			$this->data['updated'] = date('Y-m-d H:i:s');
			$this->data['created_user'] = $this->user['id'];
			$this->data['updated_user'] = $this->user['id'];
			$this->data['type'] = 'page';
			$this->data['status'] = 1;
			$this->data['title'] = '';
			$i = 1;
			foreach ($this->data['lang-title'] as $key => $value) {
				if($def_lang == $key) {
					$title = $value;
				}
				$this->data['title'] .= '[:'.$key.':]'.$value;
				$i++;
			}
			$this->data['title'] .= '[::]';
			// Do slug magic
			$this->data['slug'] = strtolower(preg_replace("/[^A-Za-z0-9]/", "-", $title));
			$this->data['slug'] = $this->pages->the_slug($this->data['slug']);
			// End slug magic
			$this->data['content'] = '';
			foreach ($this->data['lang-content'] as $key => $value) {
				$this->data['content'] .= '[:'.$key.':]'.$value;
			}
			$this->data['content'] .= '[::]';
			$res = $this->pages->save($this->data);
			if($res != '' ) {
				Message::flash(__('Page successfully updated'));
				$this->admin_redirect('pages/edit/'.$res);
			} else {
				Message::flash(__('Page could not be updated'));
			}
		}
	}

	public function admin_edit($id){
		$this->title = __('Edit page');
		$this->loadmodel('forms');
		$forms = $this->forms->get_all_forms();
		$formsoptions = array();
		$formsoptions[0] = __('No form connected to page');
		foreach ($forms as $value) {
			$formsoptions[$value['id']] = $value['name'];
		}
		$current_lang = rtrim(LANG_ALIAS,'/');
		$this->set('current_lang', $current_lang);
		$this->set('Formsoptions', $formsoptions);
		// Do this for multilang
		$multilang = $this->pages->option('meta_int', array('name'=>'settings','value'=>'multilang'));
		$langs = $this->pages->option('meta_text', array('name'=>'settings','value'=>'languages'));
		$deflangs = $this->pages->option('meta_str', array('name'=>'settings','value'=>'default_lang'));
		
		if($multilang == 1) {
			$langarr = json_decode($langs, true);
		} else {
			$langarr = json_decode($deflangs, true);
		}
		$this->set('page', $this->pages->get_page($id));
		$this->set('langs', $langarr);
		if(!empty($this->data)) {
			$this->data['updated'] = date('Y-m-d H:i:s');
			$this->data['updated_user'] = $this->user['id'];
			$this->data['title'] = '';
			foreach ($this->data['lang-title'] as $key => $value) {
				$this->data['title'] .= '[:'.$key.':]'.$value;
			}
			$this->data['title'] .= '[::]';
			$this->data['content'] = '';
			foreach ($this->data['lang-content'] as $key => $value) {
				$this->data['content'] .= '[:'.$key.':]'.$value;
			}
			$this->data['content'] .= '[::]';
			$this->pages->id = $id;
			$res = $this->pages->save($this->data);
			if($res == 1) {
				Message::flash(__('Page successfully updated'));
				$this->admin_redirect('pages/edit/'.$id);
			} else {
				Message::flash(__('Page could not be updated'));
			}
		}
	}

	public function rest_check_slug(){
		if(!empty($this->data)) {
			$data = array();
			if(trim($this->data['original']) != '') {
				$this->data['slug'] = strtolower(preg_replace("/[^A-Za-z0-9]/", "-", $this->data['slug']));
				$this->data['slug'] = trim($this->data['slug']);
				if($this->data['slug'] == '') {
					$this->data['slug'] = strtolower(preg_replace("/[^A-Za-z0-9]/", "-", $this->data['title']));
				}
				$this->data['slug'] = rtrim($this->data['slug'],'-');
				$data['slug'] = $this->pages->the_slug($this->data['slug'], $this->data['original']);
				$this->pages->id = $this->data['id'];
				$ch = $this->pages->save($data);
				if($ch > 0) {
					$data['message'] = 'updated';
				} else {
					$data['message'] = 'failed';
				}
				echo json_encode($data);
			}
			
		}
	}
}