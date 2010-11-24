<?php
class EventModel extends AutoModel {
	public function get_upcoming(Array $categories, $limit = NULL) {
		$events =  $this->db
			->select("ft.topicname AS title, ft.topicid AS id, ft.date_from, ft.topicdate AS created, DATE(FROM_UNIXTIME(ft.date_from)) AS body, u.userid, u.username, CONCAT('/forum/topic/', ft.topicid) AS href", FALSE)
			->from('forumtopics AS ft')
			->join('users AS u', 'u.userid = ft.topicposterid')
			// ->join('forumcategory AS fc', 'ft.forumcategoryid = fc.forumcategoryid')
			// ->join('locations AS l', 'e.locationid = l.locationid')
			->where('ft.date_from >=', time())
			->where_in('ft.forumcategoryid', $categories)
			->order_by('ft.date_from ASC');
		
		if( ! is_null($limit))
			$events->limit($limit);
			
		return $events->get()->result();
	}
	
	public function get_upcoming_by_attendance($user_id) {
		return $this->db
			->select("ft.topicname AS title, ft.topicid AS id, ft.topicdate AS created, CONCAT('/forum/topic/', ft.topicid) AS href, u.userid, u.username, DATE(FROM_UNIXTIME(ft.date_from)) AS body", FALSE)
			->from('forumtopics AS ft')
			->join('forumjoin AS j', 'ft.topicid = j.topic_id')
			->join('users AS u', 'u.userid = ft.topicposterid')
			->where('j.user_id', $user_id)
			->where('ft.date_from >=', time())
			->order_by('ft.date_from ASC')
			->get()->result();
	}
	
	public function get_interval($timestamp_start, $timestamp_end, Array $categories) {
		return $this->db
			->select("ft.topicname AS title, ft.topicid AS id, ft.date_from, ft.date_to, ft.topicdate AS created, u.userid, u.username, DATE(FROM_UNIXTIME(ft.date_from)) AS body, CONCAT('/forum/topic/', ft.topicid) AS href", FALSE)
			->from('forumtopics AS ft')
			->join('users AS u', 'ft.topicposterid = u.userid')
			// ->join('forumcategory AS fc', 'ft.forumcategoryid = fc.forumcategoryid')
			// ->join('locations AS l', 'e.locationid = l.locationid')
			->where('date_from >= ', $timestamp_start)
			->where('date_from <=', $timestamp_end)
			->where_in('ft.forumcategoryid', $categories)
			->where('is_event', 1)
			->order_by('date_from', 'asc')
			->order_by('date_to', 'asc')
			->get()
			->result();
	}
	
	public function signup($event_id, $user_id) {
		$this->db->insert('forumjoin', array('user_id' => $user_id, 'topic_id' => $event_id));
	}
	
	public function signoff($event_id, $user_id) {
		$this->db->delete('forumjoin', array('user_id' => $user_id, 'topic_id' => $event_id));
	}
	
	public function get_attendees($topic_id) {
		return $this->db->select('users.username, users.userid, forumjoin.comment AS body')->join('users', 'users.userid = forumjoin.user_id')->where('forumjoin.topic_id', $topic_id)->get('forumjoin')->result();
	}
	
	public function group_by_day($events, $out = array()) {
		foreach($events as $event) {
			$date_from = date('j', $event->date_from);
			$date_to = date('j', $event->date_to);
			if($date_to < $date_from)
				$date_to = $date_from;
			foreach(range($date_from, $date_to) as $date)
				$out[$date][] = $event;
		}
		return $out;
	}
	
	public function group_by_month($events, $out = array()) {
		foreach($events as $event)
			$out[date('n', $event->date_from)][] = $event;
		return $out;
	}
	
	public function user_has_signed_up($userid, $eventid) {
		return ($this->db->where('user_id', $userid)->where('topic_id', $eventid)->get('forumjoin')->num_rows() > 0);
	}
	
	// Borde vara del av alerts-modellen
	public function delete_notifications($event_id, $user_id) {
		$this->db->delete('calendarnotify', array('eventid' => $event_id, 'userid' => $user_id));
	}
	
	public function get_comment($topic_id, $user_id) {
		return $this->db->where('topic_id', $topic_id)->where('user_id', $user_id)->get('forumjoin')->row()->comment;
	}
}