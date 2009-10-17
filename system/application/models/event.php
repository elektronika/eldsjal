<?php
class Event extends Model {
	public function __construct() {
		parent::Model();
	}
	
	public function get_upcoming($limit = NULL) {
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
	
	public function get_upcoming_by_attendance($user_id) {
		return $this->db
			->select('e.title, e.eventid AS id')
			->from('calendarevents AS e')
			->join('joinactivity AS j', 'e.eventid = j.eventid')
			->where('j.userid', $user_id)
			->where('e.fulldate >=', $this->util->mysql_date())
			->order_by('e.fulldate ASC')
			->get()->result();
	}
	
	public function get_interval($timestamp_start, $timestamp_end) {
		$date_start = $this->util->mysql_date($timestamp_start);
		$date_end = $this->util->mysql_date($timestamp_end);
		
		$events = $this->db
			->select("e.title, e.eventid AS id, e.fulldate AS date, e.text AS body, e.regdate AS created, e.*, l.*, u.userid, u.username, CONCAT('/calendar/view/', e.eventid) AS href", FALSE)
			->from('calendarevents AS e')
			->join('users AS u', 'e.userid = u.userid')
			->join('locations AS l', 'e.locationid = l.locationid')
			->where('fulldate >= ', $date_start)
			->where('fulldate <=', $date_end)
			->order_by('fulldate')
			->get()
			->result();

		// foreach($events as &$event)
		// 	$this->ormify($event);
		
		return $events;
	}
	
	public function get_by_id($event_id) {
		$event = $this->db
			->select("e.title, e.eventid AS id, e.fulldate AS date, e.text AS body, e.regdate AS created, e.*, l.*, u.userid AS creator, u.userid, u.username, CONCAT('/calendar/view/', e.eventid) AS href", FALSE)
			->from('calendarevents AS e')
			->join('users AS u', 'e.userid = u.userid')
			->join('locations AS l', 'e.locationid = l.locationid')			// ->join_related('users', 'e.userid = creator.userid', 'creator', array('userid', 'username'))
			->where('eventid', $event_id)
			->get()->row();
		$event->subtitle = $event->date;
		$event = $this->add_actions($event);
		return $event;
		// return $this->ormify($event);
	}
	
	public function signup($event_id, $user_id) {
		$this->db->insert('joinactivity', array('userid' => $user_id, 'eventid' => $event_id));
	}
	
	public function signoff($event_id, $user_id) {
		$this->db->delete('joinactivity', array('userid' => $user_id, 'eventid' => $event_id));
	}
	
	public function get_attendees($event_id) {
		return $this->db->select('users.username, users.userid')->join('users', 'users.userid = joinactivity.userid')->where('joinactivity.eventid', $event_id)->get('joinactivity')->result();
	}
	
	public function group_by_day($events) {
		$out = array();
		foreach($events as $event) {
			$out[$event->dd][] = $event;
		}
		return $out;
	}
	
	public function group_by_month($events) {
		$out = array();
		foreach($events as $event) {
			$out[$event->mm][] = $event;
		}
		return $out;
	}
	
	public function user_has_signed_up($userid, $eventid) {
		return ($this->db->where('userid', $userid)->where('eventid', $eventid)->get('joinactivity')->num_rows() > 0);
	}
	
	public function save(stdClass $event) {
		$new_event = new stdClass();
		$new_event->title = $event->title;
		$new_event->text = $event->body;
		$new_event->fulldate = $this->util->mysql_date($event->date);
		$new_event->userid = $event->creator;
		$new_event->locationid = $event->location;
		$new_event->dd = date('d', $event->date);
		$new_event->mm = date('m', $event->date);
		$new_event->yyyy = date('Y', $event->date);
		$new_event->regdate = $this->util->mysql_date();
		
		if(isset($event->id)) {
			$this->db->update('calendarevents', $new_event, array('eventid' => $event->id));
			$event_id = $event->id;
		} else {
			$this->db->insert('calendarevents', $new_event);
			$event_id =  $this->db->insert_id();			
		}
		
		return $event_id;
	}
	
	public function flag_as_having_image($event_id) {
		$this->db->update('calendarevents', array('eventimage' => $event_id.'.'.$this->util->setting('default_image_extension')), array('eventid' => $event_id));
	}
	
	protected function add_actions($event) {
		if($this->user->isAdmin() || $event->creator == $this->user->userId()) {
			$event->actions[] = array('href' => '/calendar/delete/'.$event->id, 'title' => 'Radera', 'class' => 'delete');
			$event->actions[] = array('href' => '/calendar/edit/'.$event->id, 'title' => 'Redigera', 'class' => 'edit');
		}
		
		if($this->user->isAdmin()) {
			$event->actions[] = array('href' => '/calendar/alert/'.$event->id, 'title' => 'Påminn', 'class' => 'alert');
			$event->actions[] = array('href' => '/calendar/deleteimage/'.$event->id, 'title' => 'Radera bild', 'class' => 'deleteimage');
		}
		
		return $event;
	}
}