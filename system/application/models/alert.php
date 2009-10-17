<?php
class Alert extends Model {
  	protected $alerts;
	
	public function __construct() {	
		parent::Model();
	}
	
	public function alert_watching($type, $id) {
		$people = $this->get_people_watching($type, $id);
		// Kapten::korka_upp('alert', array(&$type, $id, &$people));
		if( is_array($people) && count($people) > 0 )
			$this->add($type, $people, $id);
	}
	
	public function watch($type, $id, $uid) {
		$this->db->query("INSERT INTO alert_watch (type, uid, id) VALUES ('{$type}','{$uid}','{$id}')");
	}
	
	public function unwatch($type, $id, $uid) {
		$this->db->query("DELETE FROM alert_watch WHERE type='{$type}' AND uid='{$uid}' AND id='{$id}'");
	}
	
	public function user_is_watching($type, $id, $uid) {
		return ($this->db->query("SELECT * FROM alert_watch WHERE type='{$type}' AND uid='{$uid}' AND id='{$id}'")->num_rows() > 0);
	}
	
	public function get_people_watching($type, $id) {
		$result = $this->db->query("SELECT * FROM alert_watch WHERE type='{$type}' AND id='{$id}'");
		while($result && $p = $result->fetch_assoc())
			$people[] = $p['uid'];
		return (isset($people) ? $people : array());
	}
	
  	/* Räknar alerts av en viss typ eller hämtar alla. */
	public function count($type = null) {
	    if(!is_array($this->alerts) && $this->user->isLoggedIn()) {
			self::$alerts = Array();
			$alerts = $this->db->query("SELECT type,count(type) AS count FROM alert WHERE uid='{$this->user->userId()}' GROUP BY type")->result_array();
			while($alerts && $alert = $alerts->fetch_assoc()) 
				self::$alerts[$alert['type']] = $alert['count'];
	    }
	    if($type == null)
	    	return self::$alerts;
	    else if(isset(self::$alerts[$type]))
	    	return self::$alerts[$type];
	    else 
	      	return null;
	}
	
	/*
	public function get_all_alerts($uid) {
		$result = $this->db->query("SELECT * FROM alert WHERE uid='{$uid}'");
		while($result && $alert = $result->fetch_assoc()) 
				$alerts[] = $alert;
		return ( is_array($alerts) ? $alerts : array() );
	}
	
	public function total_alert_count() {
	  	$alerts = $this->count();
	  	$count = 0;
	  	if(!is_null($alerts))
	  		foreach( $alerts as $type )
	  			$count = $count + $type;
	  	else
	  		$count = NULL;
	  	return $count;
  	}
	*/
	
	public function total_count() {
		return $this->count_gb() + $this->count_mess() + $this->count_forum() + $this->count_event();
	}
	
	protected function count_gb() {
		return $this->db->query("select count(unread) as count from guestbook where touserid = ".$this->user->userId()." and unread = 1")->row()->count;
	}
	
	protected function count_mess() {
		return $this->db->query("select count(readmessage) as count from messages where userid = ".$this->user->userId()." and readmessage = 0")->row()->count;
	}
	
	protected function count_forum() {
		return 0;
	}
	
	protected function count_event() {
		return $this->db->query("select count(calendarnotifyid) as count from calendarnotify where userid = ".$this->user->userId())->row()->count;
	}
	
	public function get_all_for_user($user_id) {
		$alerts = array();
		
		$gb_alerts = $this->get_gb_alerts($user_id);
		if(count($gb_alerts) > 0)
			$alerts['guestbook'] = $gb_alerts;
		
		$mess_alerts = $this->get_mess_alerts($user_id);
		if(count($mess_alerts) > 0)
			$alerts['message'] = $mess_alerts;
		
		$forum_alerts = $this->get_forum_alerts($user_id);
		if(count($forum_alerts) > 0)
			$alerts['forum'] = $forum_alerts;
		
		$event_alerts = $this->get_event_alerts($user_id);
		if(count($event_alerts) > 0)
			$alerts['event'] = $event_alerts;
		
		return $alerts;
	}
	
	protected function get_gb_alerts($user_id) {
		$alerts = $this->db->query("SELECT username AS title, date, guestbookid AS id FROM guestbook JOIN users ON users.userid = guestbook.fromuserid WHERE touserid = {$user_id} AND unread = 1")->result();
		$userslug = $this->util->slugify($this->user->username());
		foreach($alerts as $alert) {
			$alert->href = '/user/'.$userslug.'/guestbook#gb-'.$alert->id;
		}
		return $alerts;
	}
	
	protected function get_mess_alerts($user_id) {
		$alerts = $this->db->query("SELECT messagetopic AS title, messagedate AS date, messagefrom AS userid, username, messageid AS id FROM messages JOIN users ON users.userid = messages.messagefrom WHERE messages.userid = {$user_id} AND readmessage = 0")->result();
		foreach($alerts as $alert) {
			$alert->href = '/messages/view/'.$alert->id;
		}
		return $alerts;
	}
	
	protected function get_forum_alerts($user_id) {
		$alerts = array();
		return $alerts;
	}
	
	protected function get_event_alerts($user_id) {
		$alerts = array();
		return $alerts;
	}
  	/* Lägger till alerts. $uid kan vara ett uid eller en array uid. */
  	public function add($type, $uid, $id=null) {
	    if(is_array($uid))
			$uid = implode("','{$type}','{$id}'),('",$uid);
	    $this->db->query("INSERT INTO alert (uid,type,id) VALUES ('{$uid}','{$type}','{$id}')");
	}
	
	/* Tar bort alerts. $id kan vara ett id eller en array med id*/

	public function remove($type, $uid, $id = null) {
		if(!isset($id))
			$result = $this->db->query("DELETE FROM alert WHERE uid='{$uid}' AND type='{$type}'");
		else {
			if(is_array($id))
				$id = implode("' OR id='",$id);
			$result = $this->db->query("DELETE FROM alert WHERE uid='{$uid}' AND type='{$type}' AND (id='$id')");
		}
		return (mysqli_affected_rows($db) > 0);
	}

}