<?php
class Whatsup extends Model {	
	public function __construct() {
		parent::Model();
	}
	
	public function set($text, $userId, $action = 'random', $security = 0) {
		$whatsup = array(
			'message' => $text, 
			'date' => $this->util->mysql_date(), 
			'userid' => $userId, 
			'action' => $action, 
			'security' => $security);
		$this->db->insert('history', $whatsup);
	}
	
	public function get() {
		return $this->db->query('SELECT message FROM history WHERE security = 0 AND userid <> '.$this->user->userId().' ORDER BY id DESC LIMIT 1')->row()->message;
	}
}