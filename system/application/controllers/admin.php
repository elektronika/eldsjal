<?php
class Admin extends MY_Controller {
	public function acl_controller() {
		return $this->session->isAdmin();
	}
	
	public function get_artslug() {
		$artlist = $this->db->get('artlist')->result();
		foreach($artlist as $art) {
			$slug = $this->util->slugify($art->artName);
			$this->db->query("UPDATE artlist SET slug = '{$slug}' WHERE artid = {$art->artId}");
		}
	}
	
	public function get_userslug() {
		$userlist = $this->db->get('users')->result();
		foreach($userlist as $user) {
			$slug = $this->util->slugify($user->username);
			$this->db->query("UPDATE users SET slug = '{$slug}' WHERE userid = {$user->userId}");
		}
	}
	
	public function get_reindex_all_threads($offset) {		
		$threads = $this->db->get('forumtopics', 10000, $offset)->result();
		foreach($threads as $thread)
			$this->models->forum->reindex_thread($thread->topicId);
	}
	
	public function get_whatsup() {}
	
	public function post_whatsup() {		
		$this->form_validation->set_rules('text', 'Just nu', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Något måste ju hända!');
		
		if($this->form_validation->run() == FALSE) {
			$this->template = 'admin_whatsup.tpl';
		} else {
			$this->models->whatsup->set($this->input->post('text'), 0);
			$this->session->message('Fixelidonat!');
			$this->redirect('/admin/whatsup');
		}
	}
	
	public function get_tabledata($table) {
		print '<pre>';
		print_r($this->db->query('SHOW FIELDS FROM '.$table)->result());
		print '</pre>';
	}
	
	public function get_settings() {
		$this->view->items = $this->settings->get_all();
		$this->view->page_title = 'Inställningar';
		$this->view->template = 'inputgrid';
		$this->view->form_action = '/admin/settings';
	}
	
	public function post_settings() {
		$this->settings->delete_all();
		foreach($_POST['items'] as $setting)
			if( ! empty($setting['key']))
				$this->settings->set($setting['key'], $setting['value'], $setting['user_id']);
		$this->session->message('Jaru, nu är inställningarna ändrade med.');
		$this->redirect('/admin/settings');
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
	
	public function get_log() {
		$this->view->log = $this->db->order_by('date', 'desc')->get('log');
		$this->view->page_title = 'Logg';
	}
	
	public function post_log() {
		$this->db->empty_table('log');
		$this->session->message('Loggen är rensad! *poff* liksom!');
		$this->redirect('/admin/log');
	}
	
	public function get_convertevents() {
		$events = $this->upcoming_events();
		$forum_category = 2;
		foreach($events as $event) {
			$topic = new stdClass();
			$topic->category = $forum_category;
			$topic->title = $event->title;
			$topic->userid = $event->userid;
			$topic->topicdate = $event->created;
			$topic->body = $event->body;
			
			$topic_id = $this->models->forum->create_topic($topic);
			$fields = array(
				'is_event' => 1,
				'date_from' => $this->util->assureTimestamp($event->date),
				'latestentry' => $event->created,
				'topicdate' => $event->created
			);
			$this->models->forum->set_topic_fields($topic_id, $fields);
			
			$message_id = current($this->models->forum->get_posts_for_topic($topic_id))->id;
			$fields = array(
				'messagedate' => $event->created
			);
			$this->models->forum->set_message_fields($message_id, $fields);
			
			$attendees = $this->attendees($event->id);
			foreach($attendees as $user)
				$this->models->event->signup($topic_id, $user->userid);
		}
		$this->view->template = 'item';
		$this->session->message('Kalendern konverterad!');
		// $this->redirect('/main');
	}
	
	protected function upcoming_events($limit = NULL) {
		$events =  $this->db
			->select("e.title, e.eventid AS id, e.fulldate AS date, e.text AS body, e.regdate AS created, e.*, l.*, u.userid, u.username, CONCAT('/calendar/view/', e.eventid) AS href", FALSE)
			->from('calendarevents AS e')
			->join('users AS u', 'u.userid = e.userid')
			->join('locations AS l', 'e.locationid = l.locationid')
			->where('e.fulldate >=', $this->util->mysql_date())
			->order_by('e.fulldate ASC');
		
		if( ! is_null($limit))
			$events->limit($limit);
			
		return $events->get()->result();
	}
	
	protected function attendees($event_id) {
		return $this->db->select('users.username, users.userid')->join('users', 'users.userid = joinactivity.userid')->where('joinactivity.eventid', $event_id)->get('joinactivity')->result();
	}
	
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
}
