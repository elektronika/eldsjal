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
		$whatsup = $this->db->where(array('security' => 0, 'userid <>' => $this->session->userId()))->order_by('id', 'desc')->get('history', 1);
		return $whatsup ? $whatsup->row()->message : FALSE;
	}
}