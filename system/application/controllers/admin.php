<?php
class Admin extends MY_Controller {
	// public function acl_controller() {
	// 	return $this->session->isAdmin();
	// }
	// 
	// public function get_artslug() {
	// 	$artlist = $this->db->get('artlist')->result();
	// 	foreach($artlist as $art) {
	// 		$slug = $this->util->slugify($art->artName);
	// 		$this->db->query("UPDATE artlist SET slug = '{$slug}' WHERE artid = {$art->artId}");
	// 	}
	// }
	// 
	// public function get_userslug() {
	// 	$userlist = $this->db->get('users')->result();
	// 	foreach($userlist as $user) {
	// 		$slug = $this->util->slugify($user->username);
	// 		$this->db->query("UPDATE users SET slug = '{$slug}' WHERE userid = {$user->userId}");
	// 	}
	// }
	// 
	// public function get_reindex_all_threads($offset) {		
	// 	$threads = $this->db->get('forumtopics', 10000, $offset)->result();
	// 	foreach($threads as $thread)
	// 		$this->models->forum->reindex_thread($thread->topicId);
	// }
	// 
	// public function get_whatsup() {}
	// 
	// public function post_whatsup() {		
	// 	$this->form_validation->set_rules('text', 'Just nu', 'trim|xss_clean|required');
	// 	$this->form_validation->set_message('required', 'Något måste ju hända!');
	// 	
	// 	if($this->form_validation->run() == FALSE) {
	// 		$this->template = 'admin_whatsup.tpl';
	// 	} else {
	// 		$this->models->whatsup->set($this->input->post('text'), 0);
	// 		$this->session->message('Fixelidonat!');
	// 		$this->redirect('/admin/whatsup');
	// 	}
	// }
	// 
	// public function get_tabledata($table) {
	// 	print '<pre>';
	// 	print_r($this->db->query('SHOW FIELDS FROM '.$table)->result());
	// 	print '</pre>';
	// }
	
	public function get_settings() {
		$this->view->items = $this->settings->get_all();
		$this->view->page_title = 'Inställningar';
		$this->view->template = 'inputgrid';
		$this->view->form_action = '/admin/settings';
	}
	
	public function post_settings() {
		$this->settings->delete_all();
		foreach($_POST['items'] as $setting)
			if( ! empty($setting['key'])) {
				$this->settings->set($setting['key'], $setting['value'], $setting['user_id']);
				if($setting['user_id'] != 0)
					$this->alerts->add('flush', $setting['user_id']);
			}
		$this->alerts->add('flush');
		$this->session->message('Jaru, nu är inställningarna ändrade med.');
		$this->redirect('/admin/settings');
	}
	
	public function acl_settings() {
		return $this->session->isAdmin();
	}
	
	public function get_board() {
		$this->view->items = $this->db->select('userid, rights, title, sort')->order_by('rights', 'desc')->get('board')->result();
		$this->view->page_title = 'Rättigheter';
		$this->view->template = 'inputgrid';
		$this->view->form_action = '/admin/board';
	}
	
	public function post_board() {
		$this->db->empty_table('board');
		foreach($_POST['items'] as $item)
			if( ! empty($item['rights']))
				$this->db->insert('board', $item);
		$this->session->message('Sweet, rättigheterna uppdaterades!');
		$this->redirect('/admin/board');
	}
	
	public function acl_board() {
		return $this->session->isAdmin();
	}
	
	// public function get_log() {
	// 	$this->view->log = $this->db->order_by('date', 'desc')->get('log');
	// 	$this->view->page_title = 'Logg';
	// }
	// 
	// public function post_log() {
	// 	$this->db->empty_table('log');
	// 	$this->session->message('Loggen är rensad! *poff* liksom!');
	// 	$this->redirect('/admin/log');
	// }
	// 
	// public function get_convertevents() {
	// 	$events = $this->upcoming_events();
	// 	$forum_category = 2;
	// 	foreach($events as $event) {
	// 		$topic = new stdClass();
	// 		$topic->category = $forum_category;
	// 		$topic->title = $event->title;
	// 		$topic->userid = $event->userid;
	// 		$topic->topicdate = $event->created;
	// 		$topic->body = $event->body;
	// 		
	// 		$topic_id = $this->models->forum->create_topic($topic);
	// 		$fields = array(
	// 			'is_event' => 1,
	// 			'date_from' => $this->util->assureTimestamp($event->date),
	// 			'latestentry' => $event->created,
	// 			'topicdate' => $event->created
	// 		);
	// 		$this->models->forum->set_topic_fields($topic_id, $fields);
	// 		
	// 		$message_id = current($this->models->forum->get_posts_for_topic($topic_id))->id;
	// 		$fields = array(
	// 			'messagedate' => $event->created
	// 		);
	// 		$this->models->forum->set_message_fields($message_id, $fields);
	// 		
	// 		$attendees = $this->attendees($event->id);
	// 		foreach($attendees as $user)
	// 			$this->models->event->signup($topic_id, $user->userid);
	// 	}
	// 	$this->view->template = 'item';
	// 	$this->session->message('Kalendern konverterad!');
	// 	// $this->redirect('/main');
	// }
	// 
	// protected function upcoming_events($limit = NULL) {
	// 	$events =  $this->db
	// 		->select("e.title, e.eventid AS id, e.fulldate AS date, e.text AS body, e.regdate AS created, e.*, l.*, u.userid, u.username, CONCAT('/calendar/view/', e.eventid) AS href", FALSE)
	// 		->from('calendarevents AS e')
	// 		->join('users AS u', 'u.userid = e.userid')
	// 		->join('locations AS l', 'e.locationid = l.locationid')
	// 		->where('e.fulldate >=', $this->util->mysql_date())
	// 		->order_by('e.fulldate ASC');
	// 	
	// 	if( ! is_null($limit))
	// 		$events->limit($limit);
	// 		
	// 	return $events->get()->result();
	// }
	// 
	// protected function attendees($event_id) {
	// 	return $this->db->select('users.username, users.userid')->join('users', 'users.userid = joinactivity.userid')->where('joinactivity.eventid', $event_id)->get('joinactivity')->result();
	// }
	
	public function get_wisdom($wisdom_id = NULL) {
		if( ! is_null($wisdom_id))
			$wisdom = $this->models->wisdom->get_by_id((int) $wisdom_id);
		else
			$wisdom = (object) array('body' => '');
		$this->view->template = 'list';
		$this->view->items = $this->models->wisdom->get_all();
		$this->view->item_function = 'wisdom_item';
		$this->view->page_title = 'Vishetsadmin';
		$this->view->before = form_open('/admin/wisdom/'.$wisdom_id).textarea('body', 'Vishet', rqForm($wisdom->body)).submit('Spara vishet').form_close();
		$this->view->sublinks[] = array('href' => '/admin/wisdom', 'title' => 'Ny vishet');
	}
	
	public function post_wisdom($wisdom_id = NULL) {
		if(is_null($wisdom_id)) {
			if($this->input->post('body') != '') {
				$this->db->insert('wisebox', array('wisdom' => $this->input->post('body'), 'addedbyid' => $this->session->userid(), 'addeddate' => $this->util->mysql_date()));
				$this->session->message('Vishet sparad!');
			}
		} else {
			if($this->input->post('body') != '') {
				$this->db->update('wisebox', array('wisdom' => $this->input->post('body'), 'addedbyid' => $this->session->userid(), 'addeddate' => $this->util->mysql_date()), array('wiseboxid' => (int) $wisdom_id));
				$this->session->message('Vishet uppdaterad!');
			} else {
				$this->db->delete('wisebox', array('wiseboxid' => (int) $wisdom_id));
				$this->session->message('Vishet raderad!');
			}
		}
		$this->redirect('/admin/wisdom');		
	}
	
	public function acl_wisdom() {
		return $this->acl->check($this->settings->get('wisdom_category'));
	}
	
	public function get_flush() {
		$this->alerts->add('flush', $this->session->userId());
		$this->redirect('/main');
	}
	
	public function get_massmail() {
		$this->view->page_title = 'Massmail';
		$this->view->from_email = $this->settings->get('email_from');
		$this->view->from_name = $this->settings->get('email_from_name');
	}
	
	public function post_massmail() {
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Ämne', 'trim|required|xss_clean');
		$this->form_validation->set_rules('from_email', 'Från', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('from_name', 'Från', 'trim|required|xss_clean');
		$this->form_validation->set_rules('body', 'Meddelande', 'trim|required|xss_clean');
		
		$this->form_validation->set_message('required', 'Måste fyllas i. Jättemåste.');
		$this->form_validation->set_message('valid_email', 'Sorry, det måste vara en riktig adress.');
		
		if( ! $this->form_validation->run() === TRUE) {
			$this->get_massmail();
		} else {
			$this->load->library('email');
			$this->email->initialize(array('bcc_batch_mode' => TRUE));
			$emails = array();
			$success_count = 0;
			$fail_count = 0;
			
			if( ! $this->input->post('broadcast')) {
				$emails[] = $this->models->user->get_by_id($this->session->userId())->email;
			} else {				
				// Hämta alla adresser
				$users = $this->db->select('email')->get('users')->result();
				
				// Validera adresser
				foreach($users as $user)
					if($this->form_validation->valid_email(trim($user->email)))
						$emails[] = trim($user->email);
			}

			// And off we go!
			
			$count = count($emails);
			
			$this->email->from($this->input->post('from_email'), $this->input->post('from_name'));

			$this->email->subject($this->input->post('title'));
			$this->email->message($this->input->post('body'));
			
			foreach($emails as $email) {
				$this->email->to($email);
				if($this->email->send())
					$success_count++;
				else
					$fail_count++;
			}
			
			$this->session->message('Av '.$count.' mail lyckades '.$success_count);
			$this->redirect('/admin/massmail');
		}
	}
	
	public function acl_massmail() {
		return $this->session->isAdmin();
	}
}
