<?php
Class Notifications {	
	public function __get($var) {
		return get_instance()->$var;
	}
	
	public function notify($user_id, $type, $data = array()) {
		$message = $this->load->view('notifications/'.$type, $data, TRUE);
		foreach($this->services_for_user($user_id) as $service)
			$this->send($message, $service);
	}
	
	public function services_for_user($user_id) {
		return array();
		return $this->db->where('user_id', $user_id)->get('services')->result();
	}
	
	protected function send($message, $service) {
		return TRUE;
	}
}