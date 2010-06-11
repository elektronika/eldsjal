<?php
class Alerts {
	protected $alerts = array();
	protected $alert_count = 0;
	protected $loaded = FALSE;
	
	public function __get($var) {
		return get_instance()->$var;
	}
	
	public function count($type = FALSE) {
		return $type ? $this->count_type($type) : $this->count_all();
	}
	
	public function count_by_type() {
		$out = array();
		foreach($this->alerts as $type => $alerts)
			$out[$type] = count($alerts);
		return $out;
	}
	
	protected function count_type($type) {
		return isset($this->load()->alerts[$type]) ? count($this->alerts[$type]) : 0;
	}
	
	protected function count_all() {
		return $this->load()->alert_count;
	}
	
	public function remove($type, $user_id = NULL, $item_id = NULL) {
		$this->db->where('type', $type);
		
		if(is_null($user_id))
			$user_id = $this->session->userId();
		$this->db->where('user_id', $user_id);
		
		if( ! is_null($item_id) && $item_id)
			$this->db->where('item_id', $item_id);
		
		return $this->db->delete('alerts');
	}
	
	public function add($type, $user_id = NULL, $item_id = NULL) {
		if(is_null($user_id))
			$user_id = $this->session->userId();
		return $this->db->insert('alerts', array('type' => $type, 'user_id' => $user_id, 'item_id' => $item_id));
	}

	protected function load() {
		if( ! $this->loaded) {
			$alerts = $this->db->where('user_id', $this->session->userId())->get('alerts')->result();
			$this->alert_count = count($alerts);
			foreach($alerts as $alert)
				$this->alerts[$alert->type][] = $alert;
			$this->loaded = TRUE;
		}
		
		return $this;
	}
}