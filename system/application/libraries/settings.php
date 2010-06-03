<?php
Class settings {
	protected $CI;	
	protected $settings;
	
	public function __construct() {
		$this->CI = get_instance();
		$this->load($this->CI->session->userid());
	}
	
	protected function loadFromDatabase($user_id) {
		$settings = array();
		$result = $this->CI->db->where('user_id', 0)->or_where('user_id', (int) $user_id)->order_by('user_id', 'asc')->get('settings')->result();
		foreach($result as $setting)
			$settings[$setting->key] = $setting->value;
		$this->settings = $settings;
		$this->saveToCache();
	}
	
	protected function load($user_id) {
		if( ! $this->loadFromCache())
			$this->loadFromDatabase($user_id);
	}
	
	protected function loadFromCache() {
		if($settings = $this->CI->session->userdata('settings_cache')) {
			$this->settings = $settings;
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	protected function saveToCache() {
		$this->CI->session->set_userdata('settings_cache', $this->settings);
	}
	
	public function flush() {
		$this->loadFromDatabase($this->CI->session->userid());
	}
	
	public function get($key) {
		return $this->settings[$key];
	}
	
	public function get_array($key, $separator = ',') {
		return explode($separator, $this->get($key));
	}
	
	public function delete_all() {
		$this->CI->db->empty_table('settings');
	}
	
	public function set($key, $value, $user_id = 0) {
		if($user_id == $this->CI->session->userId()) {
			$this->settings[$key] = $value;
			$this->saveToCache();
		}
		$this->CI->db->delete('settings', array('key' => $key, 'user_id' => $user_id));
		$this->CI->db->insert('settings', array('key' => $key, 'value' => $value, 'user_id' => $user_id));
	}
	
	public function get_all() {
		return $this->CI->db->order_by('key', 'asc')->get('settings')->result();
	}
}