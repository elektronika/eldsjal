<?php
class Auth extends MY_Controller {	
	public function post_login() {
		// Gör auth-grejen		
		$this->form_validation->set_rules('username', NULL, 'trim|xss_clean|required');
		$this->form_validation->set_rules('password', NULL, 'trim|xss_clean|required');
		
		if($this->form_validation->run() == FALSE) {
			$this->session->message('Men du, du måste ju fylla i både användarnamn och lösenord. Annars funkar det ju inte.');
		} else {
			if($this->session->authenticate($this->input->post('username'), $this->input->post('password'))) {
				$this->session->message('Inloggad och klar!');
				$this->util->trail('loggade precis in');
				
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
	
	public function get_logout() {
		// Gör auth-grejen baklänges
		$this->session->logout();
		$this->session->message('Utloggad och klar!');
		$this->redirect('/main');
	}
	
	public function post_logout() {
		$this->get_logout();
	}
	
	public function get_lostpassword() {
		$this->view->page_title = 'Nollställning utav lösenord';
	}
	
	public function post_lostpassword() {
		$user = $this->models->user->get_by_email($this->input->post('email'));
		if( ! $user) {
			$this->session->message('Tyvärr, någon användare med den emailadressen gick inte att hitta. :/');
			$this->redirect('/lostpassword');
		} else {
			// Skapa reset-key
			$reset_key = $this->models->user->create_reset_key($user->userid);
			$reset_link = 'http://eldsjal.org/resetpassword/'.$user->userid.'/'.$reset_key;
			
			// Skicka mailet						
			$this->load->library('email');
			$this->email->to($user->email);
			$this->email->subject('Eldsjäl - nollställning utav lösenord');
			$this->email->from($this->settings->get('email_from'), $this->settings->get('email_from_name'));
			$this->email->message("Hej {$user->username}!\n\nNågon (förhoppningsvis du) har bett om att få ditt lösenord nollställt på eldsjal.org. Klicka på länken här nedanför för att göra det!\n\n{$reset_link}\n\n(om du inte vill nollställa ditt lösenord så är det bara att strunta i det här mailet)\n\nPuss!\n\n//Eldsjäl crew");
			if($this->email->send()) {
				$this->session->message('Sisådär, nu ska du ha ett litet mail i din inbox om ett strax. :)');
				$this->redirect('/main');
			} else {
				$this->session->message('Hoppsansa, något gick fel när mailet skulle skickas! Försök gärna igen. :)', 'warning');
				$this->redirect('/lostpassword');
			}
		}
	}
	
	public function get_resetpassword($user_id, $key) {
		$this->view->page_title = 'Nollställning utav lösenord';
		$this->view->form_action = '/resetpassword/'.$user_id.'/'.$key;
	}
	
	public function post_resetpassword($user_id, $key) {
		$this->form_validation->set_rules('password', 'Nytt lösenord', 'trim|xss_clean|required|min_length[5]');
		$this->form_validation->set_rules('password_confirm', 'Nytt lösenord igen', 'trim|xss_clean|required|matches[password]');
		$this->form_validation->set_message('matches', 'Stämmer det inte så blir det inte någon ändring här inte!');
		$this->form_validation->set_message('required', 'Heddu, fylla i är ett måste!');
		$this->form_validation->set_message('min_length', 'Lite längre än så måste det vara, annars går korna inte hem.');
		
		if($this->form_validation->run() == FALSE) {
			$this->get_lostpassword($user_id, $key);
		} else {
			$this->models->user->set_password((int) $user_id, $this->input->post('password'));
			$this->models->user->create_reset_key((int) $user_id); // Så man inte kan återanvända samma länk
			$this->session->message('Nu kan du logga in med ditt nya lösenord! :)');
			$this->redirect('/main');
		}
	}
	
	public function acl_resetpassword($user_id, $key) {
		return $this->models->user->validate_reset_key($user_id, $key);
	}
	
	public function get_register() {
		$this->view->page_title = 'Registrera';
	}
	
	public function post_register() {
		$this->form_validation->set_rules('email', 'E-mail', 'trim|xss_clean|required|valid_email|callback_check_unique_email');
		
		$this->form_validation->set_message('required', 'Heddu, fylla i är ett måste!');
		$this->form_validation->set_message('valid_email', 'Meh, en _riktig_ adress!');
		$this->form_validation->set_message('check_unique_email', 'Tyvärr, den adressen är redan paxad.');
		
		if($this->form_validation->run() == FALSE) {
			$this->get_register();
		} else {
			$user_id = $this->models->user->create($this->input->post('email'));
			
			$register_key = $this->models->user->create_reset_key((int) $user_id);
			$register_link = 'http://eldsjal.org/register/'.$user_id.'/'.$register_key;
			
			$this->load->library('email');
			$this->email->to($this->input->post('email'));
			$this->email->subject('Eldsjäl - skapa nytt konto');
			$this->email->from($this->settings->get('email_from'), $this->settings->get('email_from_name'));
			$this->email->message("Hej {$user->username}!\n\nNågon (förhoppningsvis du) har registrerat sig med din mailadress på eldsjal.org. Klicka på länken här nedanför för att fortsätta skapa ditt  konto!\n\n{$register_link}\n\nPuss och välkommen!\n\n//Eldsjäl crew");
			$this->email->send();
			
			$this->session->message('Nu är ett mail på väg till '.$this->input->post('email').' med info om hur du fortsätter. Dags att höka över inboxen mao!');
			$this->redirect('/main');
		}		
	}
	
	public function get_register2($user_id, $key) {
		$this->view->page_title = 'Slutför registrering';
		$this->view->user = $this->models->user->get_by_id((int) $user_id);
		$this->view->locations = $this->models->location->get_all_assoc();
		$this->view->form_action = '/register/'.$user_id.'/'.$key;
	}
	
	public function post_register2($user_id, $key) {
		$this->form_validation->set_rules('password', 'Nytt lösenord', 'trim|xss_clean|required|min_length[5]');
		$this->form_validation->set_rules('password_confirm', 'Nytt lösenord igen', 'trim|xss_clean|required|matches[password]');
		$this->form_validation->set_rules('email', 'E-mail', 'trim|xss_clean|required|valid_email|callback_check_unique_email');
		$this->form_validation->set_rules('username', 'Användarnamn', 'trim|xss_clean|required|callback_check_unique_username|callback_check_bad_username');
		$this->form_validation->set_rules('presentation', 'Presentation', 'trim|xss_clean|required|min_length[5]');			
		$this->form_validation->set_rules('first_name', 'Förnamn', 'trim|xss_clean|required');			
		$this->form_validation->set_rules('last_name', 'Efternamn', 'trim|xss_clean|required');
		
		$this->form_validation->set_message('matches', 'Stämmer det inte så blir det inte någon ändring här inte!');
		$this->form_validation->set_message('required', 'Heddu, fylla i är ett måste!');
		$this->form_validation->set_message('min_length', 'Lite längre än så måste det vara, annars går korna inte hem.');
		$this->form_validation->set_message('valid_email', 'Meh, en _riktig_ adress!');
		$this->form_validation->set_message('check_unique_email', 'Tyvärr, den adressen är redan paxad.');
		
		if($this->form_validation->run() == FALSE) {
			$this->get_register2($user_id, $key);
		} else {
			$user = (object) $this->input->post_array(array('username', 'email', 'presentation', 'first_name', 'last_name'));
			$user_id = $this->models->user->create($user);
			
			$this->models->user->set_password((int) $user_id, $this->input->post('password'));
			
			$confirm_key = $this->models->user->create_reset_key((int) $user_id);
			$confirm_link = 'http://eldsjal.org/resetpassword/'.$user_id.'/'.$confirm_key;
			

				
			$this->session->message('Det enda som fattas nu är att du klickar på länken i mailet skickats till adressen du angivit. Dags att höka över inboxen mao!');
			$this->redirect('/main');
		}
	}
	
	public function acl_register2($user_id, $key) {
		return $this->models->user->validate_reset_key((int) $user_id, $key);
	}
	
	public function check_unique_username($username) {
		return $this->models->user->check_unique_username($username);
	}
	
	public function check_unique_email($email) {
		return $this->models->user->check_unique_email($email);
	}
	
	public function check_bad_username($username) {
		return $this->models->user->check_bad_username($username);
	}
}