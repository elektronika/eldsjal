<?php
class Alerts extends Library {
	protected $alerts = array();
	protected $alert_count = 0;
	protected $loaded = FALSE;
	
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
	
	public function item_ids($type) {
		return isset($this->alerts[$type]) ? array_keys($this->alerts[$type]) : array();
	}
	
	public function item_has_alert($type, $item_id) {
		return isset($this->alerts[$type][$item_id]);
	}
	
	public function remove($type, $user_id = NULL, $item_id = NULL) {
		if( ! is_null($item_id)) {
			if($this->item_has_alert($type, $item_id))
				unset($this->alerts[$type][$item_id]);
			else
				return; // Onödigt att köra databasfrågor om vi vet att dom ändå inte kommer att göra något.
		}
		
		$this->db->where('type', $type);
		
		if(is_null($user_id))
			$user_id = $this->session->userId();
		if($user_id)
			$this->db->where('user_id', $user_id);
		
		if( ! is_null($item_id) && $item_id)
			$this->db->where('item_id', $item_id);
		
		return $this->db->delete('alerts');
	}
	
	public function add($type, $user_id = NULL, $item_id = NULL) {
		if(is_array($user_id)) {
			foreach($user_id as $id)
				$this->add($type, $id, $item_id);
			return;
		} elseif(is_null($user_id))
			$user_id = $this->session->userId();
		return $this->db->insert('alerts', array('type' => $type, 'user_id' => $user_id, 'item_id' => $item_id));
	}

	protected function load() {
		if( ! $this->loaded) {
			$alerts = $this->db->where('user_id', $this->session->userId())->get('alerts')->result();
			$this->alert_count = count($alerts);
			foreach($alerts as $alert)
				if( ! empty($alert->item_id))
					$this->alerts[$alert->type][$alert->item_id] = $alert;
				else
					$this->alerts[$alert->type][] = $alert;
			$this->loaded = TRUE;
		}
		
		return $this;
	}
}