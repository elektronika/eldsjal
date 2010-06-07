<?php
class User extends MY_Controller {	
	public function get_view($user_id) {
		$user = $this->models->user->get_by_id((int) $user_id);
		$user->does = $this->models->user->artList($user->userid);
		
		// De här grejerna ska ligga separat sen. Måste.
		if($user->userid == 4757)
			$user->does[] = 'Rosa velour';
		
		// Det här måste göras snyggare... -_-
		$props = array();
		$props[] = (object) array('title' => 'Ålder', 'value' => age($user->birthday).' år'.(date('m-d') == date('m-d', $user->birthday) ? ' - Fyller år idag!' : ''));
		if(isset($user->phone) && trim($user->phone) != '')
			$props[] = (object) array('title' => 'Telefonnummer', 'value' => $user->phone);
		if(trim($user->public_email) != '')
			$props[] = (object) array('title' => 'E-mail', 'value' => $user->public_email);
		if(isset($user->location))
			$props[] = (object) array('title' => 'Bor', 'value' => empty($user->inhabitance) ? $user->location : $user->inhabitance.', '.$user->location);
		if( ! empty($user->fadder_id))
			$props[] = (object) array('title' => 'Fadder', 'value' => $user->userid == 69 ? 'Gudfader' : userlink((object) array('username' => $user->fadder_name, 'userid' => $user->fadder_id)));
		if(trim($user->icq) != '')
			$props[] = (object) array('title' => 'ICQ', 'value' => $user->icq);
		if(trim($user->msn) != '')
			$props[] = (object) array('title' => 'MSN', 'value' => $user->msn);
		if(trim($user->webpage) != '')
			$props[] = (object) array('title' => 'Hemsida', 'value' => "<a href='{$user->webpage}'>{$user->webpage}</a>");
		$props[] = (object) array('title' => 'Medlem sedan', 'value' => $user->userid == 69 ? 'Tidernas begynnelse' : shortdate($user->register_date));
		$props[] = (object) array('title' => 'Senast inloggad', 'value' => $user->ping > (time() - $this->settings->get('online_timeout')) ? '<span class="online">Online!</span>' : fuzzytime($user->lastLogin));
		if( ! empty($user->does))
			$props[] = (object) array('title' => 'Sysslar med', 'value' => natural_implode($user->does, 'och'));		
		$user->properties = $props;
		
		$this->view->user = $user;
		$this->view->page_title = $user->first_name.' "'.$user->username.'" '.$user->last_name;
		$this->view->sublinks = $this->models->user->sublinks($user->userid, 'presentation');
		$this->widgets->remove('content', 'defaultheader');
		if($user_id == $this->session->userId())
			$this->util->trail("tar en kik på sin egna presentation");
		else
			$this->util->trail("spanar in {$user->username}s presentation");
	}
	
	public function acl_view($user_id) {
		if($this->models->user->is_deleted((int) $user_id) && ! $this->session->isAdmin())
			return false;

		if( ! $this->session->isLoggedIn()) {
			$user_level = 0;
		} else {
			if( $this->models->user->has_fadder($this->session->userId()) || $this->session->userId() == $user_id)
				$user_level = 2;
			else
				$user_level = 1;
		}
		return $user_level >= $this->models->user->privacy_level($user_id);
	}
	
	public function get_edit($user_id) {
		$user = $this->models->user->get_by_id((int) $user_id);
		$user = $this->models->user->add_address_info($user);
		$this->view->page_title = $user->first_name.' "'.$user->username.'" '.$user->last_name;
		$this->view->user = $user;
		$this->view->tags = $this->models->tag->get_all_assoc(FALSE);
		$this->view->user_tags = $this->models->user->artList((int) $user_id);
		$this->view->locations = $this->models->location->get_all_assoc();
		$this->view->sublinks = $this->models->user->sublinks((int) $user_id, 'settings');
		$this->view->form_action = '/user/'.$user_id.'/edit';
	}
	
	public function post_edit($user_id) {
		$user = $this->models->user->get_by_id((int) $user_id);
		
		// Fulhack för att ge password-callbacket tillgång till användar-id't
		$this->username = $user->username;
		
		// Specialkoll utav dödsviktiga fält
 		if($this->input->post('username') != $user->username || $this->input->post('email') != $user->email || $this->input->post('new_password') != '' || $this->input->post('new_password_confirm') != '') {
			$this->form_validation->set_rules('old_password', 'Ditt lösenord', 'trim|xss_clean|required|callback_check_password');
			if($this->input->post('username') != $user->username)
				$this->form_validation->set_rules('username', 'Användarnamn', 'trim|xss_clean|required|callback_check_unique_username|callback_check_bad_username');
			if($this->input->post('email') != $user->email)
				$this->form_validation->set_rules('email', 'E-mail', 'trim|xss_clean|required|valid_email|callback_check_unique_email');			
			if($this->input->post('new_password')) {
				$this->form_validation->set_rules('new_password', 'Nytt lösenord', 'trim|xss_clean|required|min_length[5]');
				$this->form_validation->set_rules('new_password_confirm', 'Nytt lösenord igen', 'trim|xss_clean|required|matches[new_password]');
			}
		}
		// Grejer som måste fyllas i.
		$this->form_validation->set_rules('presentation', 'Presentation', 'trim|xss_clean|required|min_length[5]');			
		$this->form_validation->set_rules('first_name', 'Förnamn', 'trim|xss_clean|required');			
		$this->form_validation->set_rules('last_name', 'Efternamn', 'trim|xss_clean|required');			
		$this->form_validation->set_rules('street_address', 'Gatuadress', 'trim|xss_clean|required');			
		$this->form_validation->set_rules('postal_code', 'Postnummer', 'trim|xss_clean|required');			
		$this->form_validation->set_rules('postal_city', 'Postort', 'trim|xss_clean|required');			
		$this->form_validation->set_rules('country', 'Land', 'trim|xss_clean|required');
		$this->form_validation->set_rules('privacy', '', 'trim|xss_clean|required|integer');
		$this->form_validation->set_rules('city', '', 'trim|xss_clean|required|integer');
		
		// Grejer som inte måste fyllas i, men som ändå måste kollas på någon vänster
		$this->form_validation->set_rules('public_email', 'E-mail', 'trim|xss_clean|valid_email');			
		$this->form_validation->set_rules('msn', 'MSN', 'trim|xss_clean|valid_email');			
		$this->form_validation->set_rules('webpage', 'Hemsida', 'trim|xss_clean|prep_url');			
		
		// Radera konto
		if($this->input->post('delete_password') != '')
			$this->form_validation->set_rules('delete_password', 'Lösenord', 'trim|xss_clean|required|callback_check_password');			
		
		// Mer eller mindre användarvänliga meddelanden för respektive fel. Varför finns det inte systemvänliga användare?
		$this->form_validation->set_message('required', 'Heddu, fylla i är ett måste!');
		$this->form_validation->set_message('matches', 'Stämmer det inte så blir det inte någon ändring här inte!');
		$this->form_validation->set_message('check_password', 'Mja, du måste kunna ditt lösenord för att få göra så. Du har ju trots allt loggat in med det...');
		$this->form_validation->set_message('min_length', 'Lite längre än så måste det vara, annars går korna inte hem.');
		$this->form_validation->set_message('valid_email', 'Njae, det där ser inte riktigt ut som en riktig e-mail. Bättre kan du!');
		$this->form_validation->set_message('check_unique_username', 'Sorry, det namnet är redan taget.');
		$this->form_validation->set_message('check_unique_email', 'Det där är någon annans mailadress. Inte ok.');
		$this->form_validation->set_message('check_bad_username', 'Njae, det blir nog inte så bra om du tar det namnet.');

		if($this->form_validation->run() == FALSE) {
			$this->get_edit($user_id);
		} else {
			if($this->input->post('new_password') != '')
				$this->models->user->set_password($user->userid, $this->input->post('new_password'));
			
			// Ehm, ja, egentligen borde väl mer utav det här ske i user-modellen. Men wtf.
			
			// Users-tabellen
			$fields = array('username', 'email', 'presentation', 'privacy', 'first_name', 'last_name', 'msn', 'icq', 'webpage', 'city', 'inhabitance', 'public_email', 'newsletter');
			$data = (object) $this->input->post_array($fields);
			$data->yahoo = $this->input->post('phone');
			$this->db->update('users', $data, array('userid' => $user->userid));
			
			// Address-tabellen
			$data = new stdClass();
			$data->gatuadress1 = $this->input->post('street_address');
			$data->postnummer = $this->input->post('postal_code');
			$data->stad = $this->input->post('postal_city');
			$data->land = $this->input->post('country');
			$this->db->update('address', $data, array('userid' => $user->userid));
			
			// Bild
			if($this->input->post('delete_image'))
				$this->models->user->delete_image($user->userid);
			else
				$this->handle_image($user);
			
			// Sysslar med
			$this->models->user->set_art_list($user->userid, $_POST['tags']);
			
			// Radera konto
			if($this->input->post('delete_password') != '') {
				$delete_key = $this->models->user->create_reset_key((int) $user_id);
				$delete_link = 'http://eldsjal.org/deleteaccount/'.(int) $user_id.'/'.$delete_key;
				
				// Skicka mailet						
				$this->load->library('email');
				$this->email->to($this->input->post('email'));
				$this->email->subject('Eldsjäl - radera konto');
				$this->email->from($this->settings->get('email_from'), $this->settings->get('email_from_name'));
				$this->email->message("Hej {$user->username}!\n\nNågon (förhoppningsvis du) har bett om att få ditt konto raderat på eldsjal.org. Klicka på länken här nedanför för att göra det!\n\n{$delete_link}\n\n(om du inte vill radera ditt konto så är det bara att strunta i det här mailet)\n\nPuss!\n\n//Eldsjäl crew");
				if($this->email->send())
					$this->session->message('Sisådär, nu ska du ha ett litet mail i din inbox om ett strax.');
			} else {
				$this->session->message('Uppdaterat. Ja jävlar vad uppdaterat!');
			}
			
			$this->redirect('/user/'.$user->userid);
		}
	}
	
	public function acl_edit($user_id) {
		return ($this->session->isAdmin() || $user_id == $this->session->userId());
	}
	
	// Callbacks för lattjolajbankoll av viktiga fält
	public function check_password($password) {
		return $this->models->user->check_password($this->username, $password);
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
	
	public function whatever($password) {
		return $this->check_password($password);
	}
	
	// Fulhackig admin-funktion, men den funkar.
	public function get_admin($user_id) {
		$this->view->user = $this->models->user->get_by_id($user_id);
		$this->view->fields = $this->models->user->get_restricted_fields();
		$this->view->user_array = (array) $this->view->user;
		$this->view->sublinks = $this->models->user->sublinks($user_id, 'admin');
		$this->view->page_title = $this->view->user->username.' - admin';
		$this->view->form_action = '/user/'.$user_id.'/admin';
	}
	
	public function post_admin($user_id) {
		$fields = $this->models->user->get_restricted_fields();
		unset($fields['userid']);
		$values = $this->input->post_array($fields);
		$this->db->update('users', $values, array('userid' => $user_id));
		$this->session->message('Uppdaterat och klart!');
		$this->redirect('/user/'.$user_id.'/admin');
	}
	
	public function acl_admin($user_id) {
		return $this->session->isAdmin();
	}
	
	// Bildhanteringen är lite dödsig, så den fick en egen metod
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
	
	public function get_delete($user_id, $key) {
		$this->view->page_title = 'Radera konto';
		$this->view->user = $this->models->user->get_by_id((int) $user_id);
		$this->view->form_action = '/deleteaccount/'.$user_id.'/'.$key;
	}
	
	public function post_delete($user_id, $key) {
		$user = $this->models->user->get_by_id((int) $user_id);
		
		// Fulhack för att ge password-callbacket tillgång till användar-id't
		$this->username = $user->username;
		
		$this->form_validation->set_rules('password', 'Ditt lösenord', 'trim|required|xss_clean|callback_check_password');
		
		$this->form_validation->set_message('required', 'Sorry, måste fyllas i!');
		$this->form_validation->set_message('check_password', 'Det där verkar inte riktigt stämma hörru. Försök igen!');
		
		if($this->form_validation->run() == FALSE) {
			$this->get_delete((int) $user_id, $key);
		} else {
			// Markera som raderad
			$this->db->update('users', array('deleted' => 1), array('userid' => (int) $user_id));
			
			$rip_id = $this->settings->get('rip_user_id');
			
			// Ge bilder till r.i.p-kontot
			$this->db->update('images', array('uploadedby' => $rip_id), array('uploadedby' => (int) $user_id));
			
			// Radera meddelanden
			$this->db->where('userid', (int) $user_id)->or_where('message_from', (int) $user_id)->delete('messages');
			
			// Radera tankar
			$this->db->where('userid', (int) $user_id)->delete('diary');
			
			// Radera GB-inlägg
			$this->db->where('fromuserid', (int) $user_id)->or_where('touserid', (int) $user_id)->delete('images');
			
			// Radera event-joins
			$this->db->where('user_id', (int) $user_id)->delete('forumjoin');
			
			// Radera ACL's
			$this->db->where('user_id', (int) $user_id)->delete('acl');
			
			// Radera taggar
			$this->db->where('userid', (int) $user_id)->delete('userartlist');
			
			// Skyffla fadderbarn uppåt
			$this->db->update('users', array('approvedby' => $user->fadder_id), array('approvedby' => $user->userid));
			
			// Radera profil-bild
			$this->models->user->delete_image((int) $user_id);
			
			// Skicka hejdåmeddelandet				
			$message_from = (int) $user_id;
			$title = 'Jag har raderat mitt konto!';
			$body = $this->input->post('byebye') == '' ? 'Men jag hade inte något att hälsa.' : $this->input->post('byebye');
			$message_id = $this->models->message->add($title, $body, $message_from, $this->settings->get('admin_user_id'));				
			$this->alerts->add('message', $this->settings->get('admin_user_id'), $message_id);
			
			// Logga ut
			$this->session->logout();			

			// Visa meddelande
			$this->session->message('Ditt konto har nu raderats. Haregött & välkommen tillbaka! :)');

			$this->redirect('/main');
		}
		
	}
	
	public function acl_delete($user_id, $key) {
		return $this->models->user->validate_reset_key($user_id, $key);
	}
}