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
				
				$this->alerts->add('flush', $this->session->userId());
				
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
		$this->view->page_title = 'Bli medlem';
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
		$user = $this->models->user->get_by_id((int) $user_id);
		
		$this->form_validation->set_rules('new_password', 'Nytt lösenord', 'trim|xss_clean|required|min_length[5]');
		$this->form_validation->set_rules('new_password_confirm', 'Nytt lösenord igen', 'trim|xss_clean|required|matches[new_password]');
		if($this->input->post('email') != $user->email)
			$this->form_validation->set_rules('email', 'E-mail', 'trim|xss_clean|required|valid_email|callback_check_unique_email');
		$this->form_validation->set_rules('new_username', 'Användarnamn', 'trim|xss_clean|required|callback_check_unique_username|callback_check_bad_username');
		$this->form_validation->set_rules('presentation', 'Presentation', 'trim|xss_clean|required|min_length[5]');			
		$this->form_validation->set_rules('first_name', 'Förnamn', 'trim|xss_clean|required');			
		$this->form_validation->set_rules('last_name', 'Efternamn', 'trim|xss_clean|required');
		$this->form_validation->set_rules('born_year', 'År', 'trim|xss_clean|required|callback_not_dash');
		$this->form_validation->set_rules('born_month', 'Månad', 'trim|xss_clean|required|callback_not_dash');
		$this->form_validation->set_rules('born_date', 'Dag', 'trim|xss_clean|required|callback_not_dash');
		$this->form_validation->set_rules('pul', 'PUL', 'trim|xss_clean|callback_required_checkbox');
		$this->form_validation->set_rules('rules', 'regler', 'trim|xss_clean|callback_required_checkbox');
		$this->form_validation->set_rules('cookies', 'cookies', 'trim|xss_clean|callback_required_checkbox');
		
		$this->form_validation->set_message('matches', 'Stämmer det inte så blir det inte någon ändring här inte!');
		$this->form_validation->set_message('required', 'Heddu, fylla i är ett måste!');
		$this->form_validation->set_message('min_length', 'Lite längre än så måste det vara, annars går korna inte hem.');
		$this->form_validation->set_message('valid_email', 'Meh, en _riktig_ adress!');
		$this->form_validation->set_message('check_unique_email', 'Tyvärr, den adressen är redan paxad.');
		$this->form_validation->set_message('not_dash', 'Men du, det låter väl inte så troligt?');
		$this->form_validation->set_message('required_checkbox', 'Tyvärr, du måste gå med på det för att få vara med. Lite ordning får det trots allt vara. :)');
		
		if($this->form_validation->run() == FALSE) {
			$this->get_register2($user_id, $key);
		} else {
			$user = (object) $this->input->post_array(array('presentation', 'first_name', 'last_name', 'city', 'inhabitance', 'born_month', 'born_year', 'born_date'));
			$user->username = $this->input->post('new_username');
			$this->db->update('users', $user, array('userid' => (int) $user_id));
			$user->user_id = (int) $user_id;
			
			$this->models->user->set_password((int) $user_id, $this->input->post('new_password'));
			
			$this->models->timeline->add($user->user_id, 'user', $user->user_id, $user->first_name.' "'.$user->username.'" '.$user->last_name, $user->presentation, TRUE, NULL, -1, $user->city);
			
			// Den här är duplicerad från users/edit, känns inte så DRY
			$this->handle_image($user);
			
			// Skicka välkomstmeddelandet	
			$message_from = $this->models->user->get_by_id($this->settings->get('admin_user_id'));
			$title = 'Hej och välkommen till Eldsjäl!';
			$body = "Som du säkert förstår så är det här ett automatiskt meddelande, men det kändes bättre än att kanske glömma skicka det manuellt. :)\n\nJag är mer eller mindre (o)ansvarig för den här sidan, så om du har några frågor som gäller den så är det mig du ska vända dig till i första hand. Allt annat står alla för tillsammans. Det är fritt fram att ta så lite eller mycket plats du vill, så känn dig fri att slösurfa runt, spana på sötnosar, starta forumtrådar och lägga upp saker i kalendern.\n\nFramförallt är du välkommen att komma på de träffar och arrangemang som finns i kalendern! Din tid här kommer garanterat att bli trevligare när du har träffat oss utan massor med elektronik emellan. :) Om du inte hittar något i din hemtrakt så är det bara att slänga upp en tråd i forumet, så kanske det händer något.\n\nI vilket fall, se till att snoka runt ordentligt, och var inte rädd att fråga någon som du tror kan veta om du undrar över något. Det enklaste sättet är att svara på det här meddelandet, om det är mig du vill fråga.\n\nPöss & kräm!\n\n//{$message_from->username}";
			$message_id = $this->models->message->add($title, $body, $message_from->userid, $user->user_id);				
			$this->alerts->add('message', $user->user_id, $message_id);
			
			$this->session->message('Woho, nu är det klart! Det är bara att logga in med dom uppgifterna du har angett. Syns där inne! :)');
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
	
	public function not_dash($input) {
		return $input != '-';
	}
	
	// Den här finns bara för att kunna sätta ett specifikt felmeddelande på vissa fält
	public function required_checkbox($input) {
		return (bool) $input;
	}
	
	public function handle_image($user) {		
		$config['upload_path'] = './tmp_upload/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		
		$this->load->library('upload', $config);
		
		if($this->upload->do_upload('image', $config)) {
			$upload_data = (object) $this->upload->data();
			$errors = array();
			
			// Byt namn på originalfilen, och lägg den på rätt ställe
			$original_file = $this->settings->get('original_user_image_folder').$user->userid.$upload_data->file_ext;
			if(file_exists($original_file))
				unlink($original_file);
			rename($upload_data->full_path, $original_file);
			
			// Dona thumbnailen
			$config = array(
				'source_image' => $original_file,
				'maintain_ratio' => TRUE,
				'new_image' => $this->settings->get('user_image_folder').'tn_'.$user->userid.'.'.$this->settings->get('default_image_extension'),
				'width' => 100,
				'height' => 300
			);
			$this->load->library('image_lib', $config);

			if( ! $this->image_lib->resize())
				$errors[] = $this->image_lib->display_errors();
			
			if( ! empty($errors))
				foreach($errors as $error)
					$this->session->message($error, 'warning');
			else
				$this->models->user->mark_as_having_image($user->userid);
		}
	}
}