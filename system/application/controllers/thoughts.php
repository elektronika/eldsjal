<?php
class Thoughts extends MY_Controller {	
	public function _remap($method) {
		if(method_exists($this, $method)) {
			call_user_func_array(array($this, $method), array_slice($this->uri->segment_array(), 2));
		} else {
			$this->get_index();
		}
	}
	
	public function acl_controller() {
		return $this->session->isLoggedIn();
	}
	
    public function get_index() {
		$this->thoughts = $this->models->thought->get_timeline($this->arguments->get('page', 0));
				
		$this->pagination->initialize(array(
			'base_url' => '/thoughts/page:',
			'per_page' => $this->session->setting('thoughts_per_page'),
			'total_rows' => $this->models->thought->total_amount(),
			'cur_page' => $this->arguments->get('page', 0)
		));
		$this->pager = $this->pagination->create_links();
    }
	
	public function get_today() {
		$this->thought = $this->models->thought->get_todays_thought($this->session->userId());
	}
	
	public function post_today() {
		$this->form_validation->set_rules('title', 'Rubrik', 'trim|xss_clean|required');
		$this->form_validation->set_rules('body', 'Din tanke', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Fältet "%s" måste fyllas i hörru.');
		
		if ($this->form_validation->run() == FALSE) {
			$this->template = 'thoughts_today.tpl';
		} else {
			$new_thought = (object) $this->input->post_array(array('title', 'body'));
			$thought_id = $this->models->thought->set_todays_thought($new_thought, $this->session->userId());
			
			$this->redirect('/thoughts/view/'.$thought_id);
		}
	}
	
	public function get_view($tid) {
		$this->thought = $this->models->thought->get_by_id($tid);
	}
	
	public function get_mine() {
		$this->thoughts = $this->models->thought->get_by_user($this->session->userId());
	}
	
	public function get_user($user_slug) {		
		//Av någon anledning så blir $user_slug "thoughts". Det har något med routingen att göra, men vad vette tusan!
		$this->user = $this->models->session->get_by_slug($this->uri->rsegment(3));
		$this->thoughts = $this->models->thought->get_by_user($user->userid);
	}
}