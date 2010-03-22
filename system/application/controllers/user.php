<?php
class User extends MY_Controller {	
	public function get_view($user_id) {
		$user = $this->models->user->get_by_id((int) $user_id);
		$user->does = $this->models->user->artList($user->userid);
		
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
		$this->view->display_header = FALSE;
		$this->util->trail("spanar in {$user->username}s presentation");
	}
	
	public function acl_view($user_id) {
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
		$user = $this->models->user->get_by_id($user_id);
		$user = $this->models->user->add_address_info($user);
		$this->view->page_title = $user->first_name.' "'.$user->username.'" '.$user->last_name;
		$this->view->user = $user;
		$this->view->locations = $this->models->location->get_all_assoc();
		$this->view->sublinks = $this->models->user->sublinks($user_id, 'settings');
		$this->view->form_action = '/user/'.$user_id.'/edit';
	}
	
	public function post_edit($user_id) {
		$user = $this->models->user->get_by_id((int) $user_id);
		
		// Fulhack för att ge password-callbacket tillgång till användar-id't
		$this->username = $user->username;
		
		// Specialkoll utav dödsviktiga fält
 		if($this->input->post('username') != $user->username || $this->input->post('email') != $user->email || $this->input->post('new_password') != '' || $this->input->post('new_password_confirm') != '') {
			$this->form_validation->set_rules('old_password', 'Ditt lösenord', 'trim|xss_clean|required|callback_password_check');
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
		$this->form_validation->set_rules('webpage', 'Hemsida', 'trim|xss_clean');			
		
		// Mer eller mindre användarvänliga meddelanden för respektive fel. Varför finns det inte systemvänliga användare?
		$this->form_validation->set_message('required', 'Heddu, fylla i är ett måste!');
		$this->form_validation->set_message('matches', 'Stämmer det inte så blir det inte någon ändring här inte!');
		$this->form_validation->set_message('password_check', 'Mja, du måste kunna ditt gamla lösenord för att få ändra det. Du har ju trots allt loggat in med det...');
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
			$fields = array('username', 'email', 'presentation', 'privacy', 'first_name', 'last_name', 'msn', 'icq', 'city', 'inhabitance', 'public_email');
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
			
			$this->session->message('Uppdaterat. Ja jävlar vad uppdaterat!');
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
	
	public function get_delete($user_id) {
		
	}
	
	public function post_delete($user_id) {
		die('Nej. Inte.');
		$userid = intval( $_GET['userid'] );

		//R.I.P-account 1590
		//styr om fadderskapet
		//response.Write("&Auml;ndra fadderbarnens fadder - ")
		//SQL = "update users set approved_by = (select approved_by from users where userid = " & userid & ") where approved_by = " userid
		//conn.execute SQL, rowsaffected, adCmdText
		//response.Write(rowsaffected & " rader <br><br>")

		//Ta bort fr&#140;n adresshistoriken

		print "tar bort gamla adressrader - ";
		$sql = "delete from address where userid = ".$userid;

		//Ta bort gamla namn
		print "tar bort gamla namn - ";
		$sql = "delete from history_name where user_id = ".$userid;

		// Update all inserted wisdom by the user
		print "&Auml;ndrar ansvarig p&aring; alla visheter som kommer fr&aring;n anv&auml;ndaren - ";
		$sql = "update wisebox set addedbyid = ".$application['ripuser']." where addedbyid = ".$userid;

		// Update all inserted trivias by the user
		print "&Auml;ndrar ansvarig p&aring; all trivia som kommer fr&aring;n anv&auml;ndaren - ";
		$sql = "update trivia set insertedby = ".$application['ripuser']." where insertedby = ".$userid;

		// Update all approved trivias by the user
		print "&Auml;ndrar ansvarig p&aring; godk&auml;nd trivia av anv&auml;ndaren - ";
		$sql = "update trivia set approvedby = ".$application['ripuser']." where approvedby = ".$userid;

		// Changes the userid of all messages sent FROM the RIP-user
		print "&Auml;ndrar avs&auml;ndare p&aring; alla meddelanden skickade FR&Aring;N anv&auml;ndaren - ";
		$sql = "update messages set messagefrom = ".$application['ripuser']." where messagefrom = ".$userid;

		// Changes the userid of all news posted FROM the user
		print "&Auml;ndrar avs&auml;ndare p&aring; alla nyheter skickade FR&Aring;N anv&auml;ndaren - ";
		$sql = "update news set newsauthor = ".$application['ripuser']." where newsauthor = ".$userid;

		// Changes the userid to the RIP-user in login-statistics
		print "Styr om alla inloggningar f&ouml;r statistikens skull - ";
		$sql = "update loginhistory set userid = ".$application['ripuser']." where userid = ".$userid;

		// Redirect all links submitted by the users to the RIP-account
		print "Styr om alla l&auml;nkar registrerade av anv&auml;ndaren till RIP-anv&auml;ndaren - ";
		$sql = "update links set posterid = ".$application['ripuser']." where posterid = ".$userid;

		// Redirect all posts to users from the deleted user to the RIP-account
		print "Styr om alla bilduppladdningar fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ";
		$sql = "update images set uploadedby = ".$application['ripuser']." where uploadedby = ".$userid;

		// Redirect all posts to users from the deleted user to the RIP-account
		print "Styr om alla bildgodk&auml;nningar av anv&auml;ndaren till RIP-anv&auml;ndaren - ";
		$sql = "update images set approvedby = ".$application['ripuser']." where approvedby = ".$userid;

		// Redirect all posts to users from the deleted user to the RIP-account
		print "Styr om alla foruminl&auml;gg fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ";
		$sql = "update guestbook set fromuserid = ".$application['ripuser']." where fromuserid = ".$userid;

		// Update the posterID to the R.I.P-id on all messages posted by the user in the forum
		print "Styr om alla foruminl&auml;gg fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ";
		$sql = "update forummessages set posterid = ".$application['ripuser']." where posterid = ".$userid;

		// Update the topics that the user might have created
		print "Styr om alla forumtr&aring;dar fr&aring;n anv&auml;ndaren till RIP-anv&auml;ndaren - ";
		$sql = "update forumtopics set topicposterid = ".$application['ripuser']." where topicposterid = ".$userid;

		// If the user ever registred an event, direct to the R.I.P-user
		print "Styr om alla aktiviteter registrerad av anv&auml;ndaren till RIP-anv&auml;ndaren - ";
		$sql = "update calendarevents set userid = ".$application['ripuser']." where userid = ".$userid;

		//Remove user from Userlist
		print "Tar bort anv&auml;ndare ur listan - ";
		$sql = "delete from users where userid = ".$userid;

		// If the user was a member of the board, remove him from the list
		print "Tar bort anv&auml;ndare ur styrelsen - ";
		$sql = "delete from board where userid = ".$userid;

		// Delete all pending notifications
		print "Tar bort alla kalendernotifieringar - ";
		$sql = "delete from calendarnotify where userid = ".$userid;

		// Delete all traces of the people that read the diary first, before deleting the actual diarys,
		// or else we dont know which diarys to delete

		print "Tar bort alla l&auml;smarkeringar i tankar - ";
		$sql = "delete from diaryread where diaryid in (select diaryid from diary where userid = ".$userid.")";

		// Delete all diarys
		print "Tar bort alla tankar - ";
		$sql = "delete from diary where userid = ".$userid;

		// Remove all friendrelation to and from the user
		print "Tar bort alla v&auml;nrelation till och fr&aring;n anv&auml;ndaren - ";
		$sql = "delete from friends where user_id = ".$userid." or friend_id = ".$userid;

		// Remove all guestBookentrys to and from the user
		print "Tar bort alla g&auml;stboksinl&auml;gg till anv&auml;ndaren - ";
		$sql = "delete from guestbook where touserid = ".$userid;

		// Remove all imagescoring from the user
		print "Rensar alla po&auml;ng anv&auml;ndare satt p&aring; bilder - ";
		$sql = "delete from imagescore where userid = ".$userid;

		// Remove all traces of activities that the user has participated in
		print "Tar bort alla sp&aring;r av de aktiviteter anv&auml;ndaren varit med p&aring; - ";
		$sql = "delete from joinactivity where userid = ".$userid;

		// Remove all messages sent TO the user
		print "Tar bort alla meddelanden anv&auml;ndaren har f&aring;tt - ";
		$sql = "delete from messages where userid = ".$userid;

		// Remove all news notifications to the user
		print "Tar bort alla nyhetsnotifieringar anv&auml;ndaren har f&aring;tt - ";
		$sql = "delete from newsnotify where userid = ".$userid;

		// Remove all adoption processes
		print "Tar bort alla adoptionsprocesser som p&aring;g&aring;r f&ouml;r anv&auml;ndaren - ";
		$this->db->query("delete from pendingadoption where adopteeuserid = ".$userid);
		
		// Remove the user from pending delete-table
		print "Tar bort anv&auml;ndaren ur tabort-k&ouml;n - ";
		$this->db->query("delete from pendingdelete where userid = ".$userid);

		// Remove the user from the logged in-table
		print "Om anv&auml;ndaren hakat upp sig i inloggadtabellen s&aring; rensar vi bort denne d&auml;r nu - ";
		$this->db->query("delete from seen where userid = ".$user_id);

		// Remove the user from the artlist table
		print "Tar bort alla aktiviter som anv&auml;ndaren sagt sig h&aring;lla p&aring; med - ";
		$this->db->query("delete from userartlist where userid = ".$user_id);

		// Remove the user from the artlist table
		print "Tar bort alla medlemsskapsbekr&auml;ftelser - ";
		$this->db->query("delete from user_years where userid = ".$userid);

		print "Anv&auml;ndaren nu helt borttagen!";
		exit( );
	}
	
	public function acl_delete($user_id) {
		return $this->session->isAdmin();
	}
}