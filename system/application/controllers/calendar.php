<?php
class Calendar extends MY_Controller {
	function get_index() {
		$this->view->upcoming = $this->models->event->get_upcoming(5, $this->session->usertype());
		$this->view->attending = $this->models->event->get_upcoming_by_attendance($this->session->userId());
		$this->view->page_title = 'Kalendern';
		$this->view->sublinks[] = array('href' => '/calendar/browse/'.date('Y/m/j'), 'title' => 'Visa idag');
		$this->view->sublinks[] = array('href' => '/calendar/browse/'.date('Y/m'), 'title' => 'Visa denna månaden');
		$this->view->sublinks[] = array('href' => '/calendar/browse/'.date('Y'), 'title' => 'Visa detta året');
		$this->view->sublinks[] = array('href' => '/calendar/browse/', 'title' => 'Visa alla kommande');
		$category_id = 2;
		if($this->session->isloggedin() && $this->acl->check($category_id, 'create'))
			$this->view->sublinks[] = array('href' => '/forum/new/'.$category_id.'/?event=1', 'title' => 'Skapa event!');
    }

	function get_browse($year = NULL, $month = NULL, $day = NULL) {
		if( ! is_null($year)) {
			$timestamp_start = $this->util->timestamp_start($year, $month, $day);
			$timestamp_end = $this->util->timestamp_end($year, $month, $day);
			$events = $this->models->event->get_interval($timestamp_start, $timestamp_end, $this->session->usertype());
			$this->view->sublinks[] = array('href' => '/calendar/browse', 'title' => 'Visa i en lång lista istället');
			
			$this->view->year = $year;
			$this->view->month = $month;
			$this->view->day = $day;
					
			if( ! is_null($day)) {
				$this->view->template = 'calendar_day';
				$this->view->events = $events;
				$this->view->page_title = strftime('%e %B %Y',mktime(0,0,0,$month, $day, $year));
			} elseif( ! is_null($month)) {
				$this->view->template = 'calendar_month';
				$this->view->events = $this->models->event->group_by_day($events);
				$this->view->page_title = strftime('%B %Y',mktime(0,0,0,$month));
			} else {
				$this->view->template = 'calendar_year';
				$events = $this->models->event->group_by_month($events);
				foreach($events as &$event_month)
					$event_month = $this->models->event->group_by_day($event_month);
				$this->view->events = $events;
				$this->view->page_title = (int) $year;
			}
		}
		else
			$this->get_upcoming();
	}

	function get_upcoming() {
		$this->view->items = $this->models->event->get_upcoming(NULL, $this->session->usertype());
		$this->view->template = 'list';
		$this->view->page_title = 'Kommande i kalendern';
		$this->view->sublinks[] = array('href' => '/calendar/browse/'.date('Y/m/j'), 'title' => 'Visa idag');
		$this->view->sublinks[] = array('href' => '/calendar/browse/'.date('Y/m'), 'title' => 'Visa denna månaden');
		$this->view->sublinks[] = array('href' => '/calendar/browse/'.date('Y'), 'title' => 'Visa detta året');
	}
	
	function get_attendees($topic_id) {
		$topic = $this->models->forum->get_topic_by_id((int) $topic_id);
		$this->view->page_title = 'Vi ska med till '.$topic->title;
		$this->view->sublinks[] = array('href' => '/forum/topic/'.(int) $topic_id, 'title' => 'Tillbaka till tråden!');
		if($topic->creator == $this->session->userid() || $this->session->isAdmin()) {
			$this->view->sublinks[] = array('href' => '/calendar/message/'.(int) $topic_id, 'title' => 'Massmeddelande');
			$this->view->sublinks[] = array('href' => '/calendar/attendees_print/'.(int) $topic_id, 'title' => 'Utskriftsvänlig version');			
		}
		$this->view->items = $this->models->event->get_attendees((int) $topic_id);
		$this->view->item_function = 'userlist_item';
		$this->view->template = 'list';
		if($this->models->event->user_has_signed_up($this->session->userId(), $topic_id)) {
			$comment = $this->models->event->get_comment($topic_id, $this->session->userId());
			$this->view->before = form_open('/calendar/attendees/'.$topic_id).textarea('body', 'Din deltagarnotis! (allergi, samåkning, eller vad som helst)', $comment).submit('Så äre!').form_close();			
		}
	}
	
	function post_attendees($topic_id) {
		$this->db->update('forumjoin', array('comment' => $this->input->post('body')), array('user_id' => $this->session->userId(), 'topic_id' => (int) $topic_id));
		$this->session->message('Fixat och klart!');
		$this->redirect('/calendar/attendees/'.$topic_id);
	}
	
	function acl_attendees($topic_id) {
		$category_id = $this->models->forum->get_topic_by_id((int) $topic_id)->category_id;
		return $this->session->isloggedin() && $this->models->forum->acl($this->session->userId(), $category_id);
	}
	
	function get_message($topic_id) {
		$topic = $this->models->forum->get_topic_by_id((int) $topic_id);
		$this->view->form_action = '/calendar/message/'.$topic_id;
		$this->view->page_title = 'Massmeddelande till alla som ska med på '.$topic->title;
		$this->view->prefilled_title = 'Till dig som ska med på '.$topic->title;
		$this->view->sublinks[] = array('href' => '/forum/topic/'.$topic_id, 'title' => 'Tillbaka till tråden!');
	}
	
	function post_message($topic_id) {		
		$this->form_validation->set_rules('title', 'Rubrik', 'trim|xss_clean|required');
		$this->form_validation->set_rules('body', 'Meddelande', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Glöm inte att fylla i "%s" pysen!');
		
		if ($this->form_validation->run() == FALSE) {
			$this->get_message($topic_id);
		} else {		
			$users = $this->models->event->get_attendees((int) $topic_id);
			foreach($users as $user) {
				$message_id = $this->models->message->add($this->input->post('title'), $this->input->post('body'), $this->session->userId(), $user->userid);				
				$this->alerts->add('message', $user->userid, $message_id);
			}
			$this->session->message('Massmeddelande skickat!');
			$this->redirect('/calendar/attendees/'.$topic_id);
		}
	}
	
	function acl_message($topic_id) {
		$topic = $this->models->forum->get_topic_by_id((int) $topic_id);
		return $topic->creator == $this->session->userid() || $this->session->isAdmin();
	}
	
	function get_signup($event_id) {
		$this->models->event->signup($event_id, $this->session->userId());
		$this->session->message('*gilla* Syns där!');
		$this->redirect('/forum/topic/'.$event_id);
	}
	
	function acl_signup($event_id) {
		$category_id = $this->models->forum->get_topic_by_id((int) $event_id)->category_id;
		return $this->session->isloggedin() && $this->acl->check($category_id);
	}
	
	function get_signoff($event_id) {
		$this->models->event->signoff($event_id, $this->session->userId());
		$this->session->message('Det är ok, vi syns säkert någon annan gång. :)');
		$this->redirect('/forum/topic/'.$event_id);		
	}
	
	function acl_signoff($event_id) {
		$category_id = $this->models->forum->get_topic_by_id((int) $event_id)->category_id;
		return $this->session->isloggedin() && $this->acl->check($category_id);
	}
}