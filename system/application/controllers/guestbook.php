<?php
class Guestbook extends MY_Controller {		
	public function get_view($user_slug) {
		$this->load->library('pagination');
		$offset = $this->arguments->get('page', 0);
		$posts_per_page = $this->settings->get('guestbook_posts_per_page');
		$user = $this->models->user->get_by_slug($user_slug);		
		$number_of_posts = $this->models->guestbook->count_posts_for_user($user->userid);
		
		$this->pagination->initialize(array(
			'base_url' => '/user/'.$user_slug.'/guestbook/page:',
			'per_page' => $posts_per_page,
			'total_rows' => $number_of_posts,
			'cur_page' => $offset
		));
		
		$this->view->pager = $this->pagination->create_links();		
		$this->view->items = $this->models->guestbook->to_user($user->userid, $offset, $posts_per_page);
		$this->view->page_title = $user->username.'s gästbok';
		$this->view->item_function = 'post';
		$this->view->template = 'list';
		$this->view->sublinks = array(
			array('href' => '/user/'.$user_slug, 'title' => 'Presentation'),
			array('href' => '/thoughts/user/'.$user_slug, 'title' => 'Tankar'),
			array('href' => '/gallery/user/'.$user_slug, 'title' => 'Bilder'),
		);
	}
	
	public function get_edit($post_id) {
		$this->post = $this->models->guestbook->get_post_by_id($post_id);
	}
	
	public function post_edit($post_id) {
		return $this->session->isAdmin() || $this->models->guestbook->is_by_user($post_id, $this->session->userId());
	}
	
	public function acl_edit($post_id) {
		return $this->session->isLoggedIn();
	}
	
	public function get_delete($post_id) {}
	
	public function post_delete($post_id) {}
	
	public function acl_delete($post_id) {
		return $this->session->isAdmin() || $this->models->guestbook->is_by_user($post_id, $this->session->userId()) || $this->models->guestbook->is_to_user($post_id, $this->session->userId());
	}
	
	public function post_ajax_add($user_id) {
		$this->redirect = TRUE;
		$this->form_validation->set_rules('body', 'Gästboksmeddelande', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Om du inte har något att säga så kan du lika gärna låta bli. :)');
		if($this->form_validation->run() == FALSE) {
			$this->userid = $user_id;
			$this->template = 'usermenu_guestbook.tpl';
		} else {
			$this->models->guestbook->add($this->input->post('body'), $this->session->userId(), $user_id);
			print 'Gött hörru, nu är det donat!';
		}
	}
}