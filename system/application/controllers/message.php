<?php
class Message extends MY_Controller {
	public function acl_controller() {
		return $this->session->isLoggedIn();
	}
	
	public function post_ajax_add($user_id) {
		$this->show_profiler = FALSE;
		
		$this->form_validation->set_rules('body', 'Meddelande', 'trim|xss_clean|required');
		$this->form_validation->set_rules('title', 'Ämne', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Om du inte har något att säga så kan du lika gärna låta bli. :)');
		
		if($this->form_validation->run() == FALSE) {
			$this->userid = $user_id;
			$this->template = 'usermenu_message.tpl';
		} else {
			$this->models->message->add($this->input->post('title'), $this->input->post('body'), $this->session->userId(), $user_id);
			$this->redirect = TRUE;
			print 'Göttans hörru!';
		}
	}
}