<?php

class Thoughts extends Controller {
	public function __construct() {
		parent::Controller();
		$this->load->model('thought');
		// $this->output->enable_profiler(TRUE);
	}
	
	public function _remap($method) {
		if(method_exists($this, $method)) {
			call_user_func_array(array($this, $method), array_slice($this->uri->segment_array(), 2));
		} else {
			$this->get_index();
		}
	}
	
    public function get_index() {
		$this->load->library('pagination');
		
		$thoughts = $this->thought->get_timeline($this->arguments->get('page', 0));
				
		$this->pagination->initialize(array(
			'base_url' => '/thoughts/page:',
			'per_page' => $this->user->setting('thoughts_per_page'),
			'total_rows' => $this->thought->total_amount(),
			'cur_page' => $this->arguments->get('page', 0)
		));
		$pager = $this->pagination->create_links();
		
		$this->dwootemplate->assign('pager', $pager);
		$this->dwootemplate->assign('thoughts', $thoughts);
    	$this->dwootemplate->display('thoughts_index.tpl');
    }

	public function acl_controller() {
		return $this->user->isLoggedIn();
	}
	
	public function get_today() {
		$thought = $this->thought->get_todays_thought($this->user->userId());
		
		$this->dwootemplate->assign('thought', $thought);
		$this->dwootemplate->display('thoughts_today.tpl');
	}
	
	public function post_today() {
		$this->form_validation->set_rules('title', 'Rubrik', 'trim|xss_clean|required');
		$this->form_validation->set_rules('body', 'Din tanke', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Fältet "%s" måste fyllas i hörru.');
		
		if ($this->form_validation->run() == FALSE) {
			$this->dwootemplate->display('thoughts_today.tpl');
		} else {
			$new_thought = new stdClass();
			$new_thought->diarytopic = $this->input->post('title');
			$new_thought->diary = $this->input->post('body');
			
			$thought_id = $this->thought->set_todays_thought($new_thought, $this->user->userId());
			
			$this->load->helper('url');			
			redirect('/thoughts/view/'.$thought_id);
		}
	}
	
	public function get_view($tid) {
		$thought = $this->thought->get_by_id($tid);
		
		$this->dwootemplate->assign('thought', $thought);
		$this->dwootemplate->display('thoughts_view.tpl');
	}
	
	public function get_mine() {
		$thoughts = $this->thought->get_by_user($this->user->userId());
		
		$this->dwootemplate->assign('thoughts', $thoughts);
		$this->dwootemplate->display('thoughts_mine.tpl');
	}
	
	public function get_user($user_slug) {
		$this->load->model('user_model');
		
		//Av någon anledning så blir $user_slug "thoughts". Det har något med routingen att göra, men vad vette tusan!
		$user = $this->user_model->get_by_slug($this->uri->rsegment(3));
		$thoughts = $this->thought->get_by_user($user->userid);
		
		$this->dwootemplate->assign('thoughts', $thoughts);
		$this->dwootemplate->assign('user', $user);
		$this->dwootemplate->display('thoughts_user.tpl');
	}
}