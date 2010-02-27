<?php
class Auth extends MY_Controller {	
	function post_login() {
		// Gör auth-grejen		
		$this->form_validation->set_rules('username', NULL, 'trim|xss_clean|required');
		$this->form_validation->set_rules('password', NULL, 'trim|xss_clean|required');
		
		if($this->form_validation->run() == FALSE) {
			$this->session->message('Men du, du måste fylla i både användarnamn och lösenord. Annars funkar det ju inte.');
		} else {
			if($this->session->authenticate($this->input->post('username'), $this->input->post('password'))) {
				$this->session->message('Inloggad och klar!');
				
				if($this->input->post('cookie'))
					setcookie("username", $this->input->post('username'), time()+60*60*24*30);
				else
					setcookie("username",'', time()-3600);
			} else {
				$this->session->message('Något gick fel när du försökte logga in. Det är bara att försöka igen!', 'warning');				
			}
		}
		$this->redirect('/main');
		
	}
	
	function get_logout() {
		// Gör auth-grejen baklänges
		$this->session->logout();
		$this->session->message('Utloggad och klar!');
		$this->redirect('/main');
	}
	
	function post_logout() {
		$this->get_logout();
	}
	
	function get_forgotpassword() {}
	
	function post_forgotpassword() {}
}