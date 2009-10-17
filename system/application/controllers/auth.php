<?php

class Auth extends Controller {

	function __construct() {
		parent::Controller();	
		$this->load->helper('url');
	}
	
	function post_login() {
		// Gör auth-grejen		
		$this->form_validation->set_rules('username', NULL, 'trim|xss_clean|required');
		$this->form_validation->set_rules('password', NULL, 'trim|xss_clean|required');
		
		if($this->form_validation->run() == FALSE) {
			// Visa ett fint litet meddelande
		} else {
			if($this->user->authenticate($this->input->post('username'), $this->input->post('password'))) {
				// Visa joy-meddelande
				$this->user->message('Inloggad och klar!');
				redirect('main');
			} else {
				// Visa sad-meddelande
				$this->user->message('Något gick fel när du försökte logga in. Det är bara att försöka igen!', 'warning');
				redirect('main');
			}
		}
	}
	
	function get_logout() {
		// Gör auth-grejen baklänges
		$this->user->logout();
		redirect('/main');
	}
	
	function post_logout() {
		$this->get_logout();
	}
	
	function get_forgotpassword() {
		$this->dwootemplate->display('auth_forgotpassword.tpl');
	}
	
	function post_forgotpassword() {
		
	}
}