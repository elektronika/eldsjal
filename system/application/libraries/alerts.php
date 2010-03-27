<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Alerts {
	protected $CI;
	protected $alerts = array();
	protected $alert_count = 0;
	protected $loaded = FALSE;
	
	public function __construct() {
		log_message('debug', "Arguments Class Initialized");
		$this->CI =& get_instance();
	}
	
	public function count($type = 'all') {
		if( ! $this->loaded)
			$this->load();
		
		if($type == 'all')
			return $this->alert_count;
		elseif(isset($this->alerts[$type]))
			return count($this->alerts[$type]);
		else
			return 0;
	}
	
	public function get($type = 'all') {
		if( ! $this->loaded)
			$this->load();
			
		if($type == 'all') {
			$out = array();
			foreach($this->alerts as $group)
				$out = array_merge($out, $group);
			return $out;
		} elseif(isset($this->alerts[$type])) {
			return $this->alerts[$type];
		} else {
			return 0;
		}
	}
	
	public function add($type, $user_id = NULL, $item_id = NULL) {
		if(is_null($user_id))
			$user_id = $this->CI->session->userId();
		$this->CI->db->insert('alerts', array('type' => $type, 'user_id' => $user_id, 'item_id' => $item_id));
	}
	
	public function remove($type, $user_id = NULL, $item_id = NULL) {
		if(is_null($user_id))
			$user_id = $this->CI->session->userId();
		$arguments = array('type' => $type, 'user_id' => $user_id);
		if( ! is_null($item_id))
			$arguments['item_id'] = $item_id;
		$this->CI->db->delete('alerts', $arguments);
	}
	
	protected function load() {
		$alerts = $this->CI->db->where('user_id', $this->CI->session->userId())->get('alerts')->result();
		$this->alert_count = count($alerts);
		foreach($alerts as $alert)
			$this->alerts[$alert->type] = $alert;
		$this->loaded = TRUE;
	}
}