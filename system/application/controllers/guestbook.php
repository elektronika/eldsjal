<?php
class Guestbook extends MY_Controller {	
	public function acl_controller() {
		return $this->session->isLoggedIn();
	}
		
	public function get_view($user_id) {
		$this->load->library('pagination');
		$offset = $this->arguments->get('page', 0);
		$posts_per_page = $this->settings->get('guestbook_posts_per_page');
		$user = $this->models->user->get_by_id($user_id);		
		$number_of_posts = $this->models->guestbook->count_posts_for_user($user->userid);
		
		$this->pagination->initialize(array(
			'base_url' => '/user/'.$user->userid.'/guestbook/page:',
			'per_page' => $posts_per_page,
			'total_rows' => $number_of_posts,
			'cur_page' => $offset
		));
		
		$this->view->pager = $this->pagination->create_links();	
		$posts = $this->models->guestbook->to_user($user->userid, $offset, $posts_per_page);
		foreach($posts as &$post) {
			if($this->session->userid() == $user_id)
				$post->actions[] = array('href' => '/guestbook/conversation/'.$post->userid, 'title' => 'Svara', 'class' => 'reply');
			$active_user = $this->session->userId();
			if($this->session->isAdmin() || $active_user == $post->toUserId || $active_user == $post->userid)
				$post->actions[] = array('href' => '/guestbook/delete/'.$post->guestbookId, 'title' => 'Radera', 'class' => 'delete');
		}
		$this->view->template = 'list';
		$this->view->before = guestbook_form($user->userid);
		$this->view->item_function = 'post';
		$this->view->items = $posts;
		$this->view->page_title = $user->username.'s gästbok';
		$this->view->sublinks = $this->models->user->sublinks($user->userid, 'guestbook');
		$this->view->user_id = $user->userid;
		$this->view->display_form = $user->userid != $this->session->userid();
		$this->view->form_action = '/guestbook/view/'.$user->userid;
		
		// Markera alla som lästa när man kollar i sin egna gästbok
		if($this->session->userId() == $user->userid)
			$this->models->guestbook->mark_all_as_read($user->userid);
		if($user->userid == $this->session->userId())
			$this->util->trail("kollar i sin egen gästbok");
		else
			$this->util->trail("kollar i {$user->username}s gästbok");
	}
	
	public function post_view($user_id) {
		$this->form_validation->set_rules('body', 'Gästboksmeddelande', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Om du inte har något att säga så kan du lika gärna låta bli. :)');
		if($this->form_validation->run() == FALSE) {
			$this->get_view($user_id);
		} else {
			$user = $this->models->user->get_by_id((int) $user_id);
			$this->models->guestbook->add($this->input->post('body'), $this->session->userId(), $user->userid);
			$this->session->message('Mysigt, nu har du lämnat ett litet avtryck. :)');
			$this->redirect('/guestbook/view/'.$user_id);
		}
	}
	
	public function get_conversation($user_id) {
		$user = $this->models->user->get_by_id((int) $user_id);
		
		$this->load->library('pagination');
		$offset = $this->arguments->get('page', 0);
		$posts_per_page = $this->settings->get('guestbook_posts_per_page');
		$number_of_posts = $this->models->guestbook->count_posts_between_users($user->userid, $this->session->userid());
		
		$this->pagination->initialize(array(
			'base_url' => '/guestbook/conversation/'.$user_id.'/page:',
			'per_page' => $posts_per_page,
			'total_rows' => $number_of_posts,
			'cur_page' => $offset
		));
		
		$this->view->pager = $this->pagination->create_links();
		$this->view->template = 'list';
		$this->view->before = guestbook_form($user->userid);
		$this->view->item_function = 'post';
		
		$this->view->items = $this->models->guestbook->between_users($user->userid, $this->session->userid(), $offset, $posts_per_page);

		$this->view->display_form = TRUE;
		$this->view->form_action = '/guestbook/view/'.$user_id;
		$this->view->page_title = 'Ditt gästbokande med '.$user->username;
		$this->view->sublinks[] = array('href' => '/guestbook/view/'.$this->session->userId(), 'title' => 'Din gästbok');
		$this->view->sublinks[] = array('href' => '/guestbook/view/'.$user->userid, 'title' => $user->username.'s gästbok');
	}
	
	public function get_edit($post_id) {
		$this->post = $this->models->guestbook->get_post_by_id($post_id);
	}
	
	public function post_edit($post_id) {
	}
	
	public function acl_edit($post_id) {
		return $this->session->isAdmin() || $this->models->guestbook->is_by_user($post_id, $this->session->userId());
	}
	
	public function get_delete($post_id) {
		$this->view->template = 'confirm';
		$this->view->message = 'Är du säker på att du vill ta bort gästboksinlägget?';
		$this->view->form_action = '/guestbook/delete/'.$post_id;
		$this->view->page_title = 'Radera gästboksinlägg';
	}
	
	public function post_delete($post_id) {
		$this->models->guestbook->delete((int) $post_id);
		$this->session->message('Gästboksinlägget är nu typ tjockt borta. Poff liksom!');
		$this->redirect('/guestbook/view/'.$this->session->userId());
	}
	
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