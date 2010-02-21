<?php
class Thoughts extends MY_Controller {	
	// public function _remap($method) {
	// 	if(method_exists($this, $method)) {
	// 		call_user_func_array(array($this, $method), array_slice($this->uri->segment_array(), 2));
	// 	} else {
	// 		$this->get_index();
	// 	}
	// }
	
	public function acl_controller() {
		return $this->session->isLoggedIn();
	}
	
    public function get_index() {
		$this->load->library('pagination');
		$this->view->items = $this->models->thought->get_timeline($this->arguments->get('page', 0));
		$this->view->page_title = 'Tankar';
		$this->util->trail('filurar runt bland tankarna');
		$this->pagination->initialize(array(
			'base_url' => '/thoughts/index/page:',
			'per_page' => $this->session->setting('thoughts_per_page'),
			'total_rows' => $this->models->thought->total_amount(),
			'cur_page' => $this->arguments->get('page', 0)
		));
		$this->view->pager = $this->pagination->create_links();
		$this->view->sublinks = array(
			array('href' => '/thoughts/today', 'title' => 'Dagens tanke'),
			array('href' => '/thoughts/mine', 'title' => 'Mina tankar')
		);
		$this->view->template = 'list';
    }
	
	public function get_today() {
		$this->view->page_title = 'Dagens tanke';
		$this->util->trail('präntar ner dagens tanke');
		$thought = $this->models->thought->get_todays_thought($this->session->userId());
		$this->view->thought = $thought ? $thought : (object) array('title' => '', 'body' => '');
	}
	
	public function post_today() {
		$this->form_validation->set_rules('title', 'Rubrik', 'trim|xss_clean|required');
		$this->form_validation->set_rules('body', 'Din tanke', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Fältet "%s" måste fyllas i hörru.');
		
		if ($this->form_validation->run() == FALSE) {
			$this->get_today();
		} else {
			$new_thought = (object) $this->input->post_array(array('title', 'body'));
			$thought_id = $this->models->thought->set_todays_thought($new_thought, $this->session->userId());
			$this->get_today();
			
			// $this->redirect('/thoughts/view/'.$thought_id);
		}
	}
	
	public function get_view($tid) {
		$thought = $this->models->thought->get_by_id((int) $tid);
		$this->view->page_title = $thought->title;
		$this->util->trail('läser '.$thought->username.'s tanke '.$thought->title);
		$this->view->item = $thought;
		$this->view->sublinks = array(
			array('href' => '/thoughts/user/'.$thought->userid, 'title' => $thought->username.'s andra tankar')
		);
		$this->view->template = 'item';
	}
	
	public function get_mine() {
		$this->get_user($this->session->userid());
	}
	
	public function get_user($user_id) {		
		$user = $this->models->user->get_by_id((int) $user_id);
		$this->view->items = $this->models->thought->get_by_user($user->userid);
		$this->view->page_title = $user->username.'s tankar';
		$this->view->sublinks = array(
			array('href' => '/userPresentation.php?userid='.$user->userid, 'title' => $user->username.'s presentation')
		);
		$this->view->template = 'list';
	}
}