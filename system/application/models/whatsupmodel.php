<?php
class WhatsupModel extends AutoModel {	
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
		return $message = $this->db->query('SELECT message FROM history WHERE security = 0 AND userid <> '.$this->session->userId().' ORDER BY id DESC LIMIT 1')->row() ? $message->message : NULL;
	}
}