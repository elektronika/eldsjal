<?php
class Messages extends MY_Controller {
	public function acl_controller() {
		return $this->session->isLoggedIn();
	}

	public function get_index() {
		$this->load->library('pagination');
		$offset = $this->arguments->get('page', 0);
		$messages_per_page = $this->settings->get('messages_per_page');
		$number_of_messages = $this->models->message->count_messages_to_user($this->session->userid());
		
		$this->pagination->initialize(array(
			'base_url' => '/messages/index/page:',
			'per_page' => $messages_per_page,
			'total_rows' => $number_of_messages,
			'cur_page' => $offset
		));
		
		$this->view->pager = $this->pagination->create_links();

		$this->view->items = $this->models->message->get_messages_to($this->session->userId(), $messages_per_page, $offset);
		foreach($this->view->items as &$message)
			$message->counterpart = $message->sender->userid == $this->session->userid() ? $message->receiver : $message->sender;
		$this->view->page_title = 'Dina meddelanden';
	}
	
	public function get_new($user_id) {
		$this->view->user = $this->models->user->get_by_id((int) $user_id);
		$this->view->page_title = 'Nytt meddelande till '.$this->view->user->username;
		$this->view->sublinks = $this->models->user->sublinks((int) $user_id, 'message');
	}
	
	public function post_new($user_id) {
		$this->form_validation->set_rules('body', 'Meddelande', 'trim|xss_clean|required');
		$this->form_validation->set_rules('title', 'Ämne', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Appappapp!');
		
		if($this->form_validation->run() == FALSE) {
			$this->get_new($user_id);
		} else {
			$message_id = $this->models->message->add($this->input->post('title'), $this->input->post('body'), $this->session->userId(), (int) $user_id);
			$this->alerts->add('message', (int) $user_id, (int) $message_id);
			$this->session->message('Meddelandet skickat!');
			$this->redirect('/messages/view/'.$message_id);
		}
	}
	
	public function get_view($message_id) {
		$this->view->template = 'list';
		$this->view->item_function = 'post';
		
		$messages = $this->models->message->get_conversation((int) $message_id);
		foreach($messages as $message)
			$this->alerts->remove('message', $this->session->userId(), $message->id);
		
		$this->view->items = $messages;
		$this->view->page_title = current($this->view->items)->title;
		$this->view->after = form_open('/messages/view/'.$message_id).textarea('body', 'Meddelande').submit('Svara!').form_close();
		$this->view->sublinks[] = array('href' => '/messages', 'title' => 'Tillbaka till inboxen!');
	}
	
	public function post_view($message_id) {
		$this->form_validation->set_rules('body', 'Meddelande', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Appappapp!');
		
		if($this->form_validation->run() == FALSE) {
			$this->get_view($message_id);
		} else {
			$message = $this->models->message->get_by_id((int) $message_id);
			$user_id = $message->userId == $this->session->userId() ? $message->messageFrom : $message->userId;
			$this->models->message->add('', $this->input->post('body'), $this->session->userId(), $user_id, (int) $message_id);
			$this->alerts->add('message', $user_id, (int) $message_id);
			$this->session->message('Meddelandet skickat!');
			$this->redirect('/messages/view/'.$message_id);
		}	
	}
	
	public function acl_view($message_id) {
		$message = $this->models->message->get_by_id((int) $message_id);
		return $message->userId == $this->session->userId() || $message->messageFrom == $this->session->userId();
	}
	
	// Radera meddelande får vänta lite, iom att man då riskerar att radera för både sändare och mottagare
	public function get_delete($message_id) {}
	public function post_delete($message_id) {}	
	public function acl_delete($message_id) {}
	
	// public function post_ajax_add($user_id) {
	// 	$this->show_profiler = FALSE;
	// 	
	// 	$this->form_validation->set_rules('body', 'Meddelande', 'trim|xss_clean|required');
	// 	$this->form_validation->set_rules('title', 'Ämne', 'trim|xss_clean|required');
	// 	$this->form_validation->set_message('required', 'Om du inte har något att säga så kan du lika gärna låta bli. :)');
	// 	
	// 	if($this->form_validation->run() == FALSE) {
	// 		$this->userid = $user_id;
	// 		$this->template = 'usermenu_message.tpl';
	// 	} else {
	// 		$this->models->message->add($this->input->post('title'), $this->input->post('body'), $this->session->userId(), $user_id);
	// 		$this->redirect = TRUE;
	// 		print 'Göttans hörru!';
	// 	}
	// }
}