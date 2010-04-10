<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Alerts {
	protected $alerts = array();
	protected $alert_count = 0;
	protected $loaded = FALSE;
	
	public function __get($var) {
		return get_instance()->$var;
	}
	
	public function count($type = 'all') {
		switch($type) {
			case 'all':
				return $this->total_count();
			case 'guestbook':
				return $this->count_gb();
			case 'message':
				return $this->count_mess();
			default:
				return 0;
		}
	}
	
	protected function total_count() {
		return $this->count_gb() + $this->count_mess();
	}
	
	protected function count_gb() {
		return $this->db->query("SELECT COUNT(unread) AS count FROM guestbook WHERE touserid = ".$this->session->userId()." AND unread = 1")->row()->count;
	}
	
	protected function count_mess() {
		return $this->db->query("SELECT COUNT(readmessage) AS count FROM messages WHERE userid = ".$this->session->userId()." AND readmessage = 0")->row()->count;
	}
	
	// public function count($type = 'all') {
	// 	if( ! $this->loaded)
	// 		$this->load();
	// 	
	// 	if($type == 'all')
	// 		return $this->alert_count;
	// 	elseif(isset($this->alerts[$type]))
	// 		return count($this->alerts[$type]);
	// 	else
	// 		return 0;
	// }
	// 
	// public function get($type = 'all') {
	// 	if( ! $this->loaded)
	// 		$this->load();
	// 		
	// 	if($type == 'all') {
	// 		$out = array();
	// 		foreach($this->alerts as $group)
	// 			$out = array_merge($out, $group);
	// 		return $out;
	// 	} elseif(isset($this->alerts[$type])) {
	// 		return $this->alerts[$type];
	// 	} else {
	// 		return 0;
	// 	}
	// }
	// 
	// public function add($type, $user_id = NULL, $item_id = NULL) {
	// 	if(is_null($user_id))
	// 		$user_id = $this->CI->session->userId();
	// 	$this->CI->db->insert('alerts', array('type' => $type, 'user_id' => $user_id, 'item_id' => $item_id));
	// }
	// 
	// public function remove($type, $user_id = NULL, $item_id = NULL) {
	// 	if(is_null($user_id))
	// 		$user_id = $this->CI->session->userId();
	// 	$arguments = array('type' => $type, 'user_id' => $user_id);
	// 	if( ! is_null($item_id))
	// 		$arguments['item_id'] = $item_id;
	// 	$this->CI->db->delete('alerts', $arguments);
	// }
	// 
	// protected function load() {
	// 	$alerts = $this->CI->db->where('user_id', $this->CI->session->userId())->get('alerts')->result();
	// 	$this->alert_count = count($alerts);
	// 	foreach($alerts as $alert)
	// 		$this->alerts[$alert->type] = $alert;
	// 	$this->loaded = TRUE;
	// }
}