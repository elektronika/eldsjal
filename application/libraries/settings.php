<?php
Class Settings {
	protected $CI;	
	protected $settings = array();
	protected $user_id = 0;
	protected $loaded = FALSE;
	protected $user_settings = array();
	
	public function __construct($config = array()) {
		$this->settings = $config;
		$this->CI = get_instance();
		$this->user_id = $this->CI->session->userid();
	}
	
	protected function loadFromDatabase($user_id) {
		$result = $this->CI->db->where('user_id', (int) $user_id)->get('settings')->result();
		foreach($result as $setting) {
			$this->settings[$setting->key] = $setting->value;
			$this->user_settings[] = $setting->key;
		}
		$this->loaded = TRUE;
		$this->saveToCache();
	}
	
	protected function load() {
		if( (bool) $this->user_id && ! $this->loaded && ! $this->loadFromCache())
			$this->loadFromDatabase($this->user_id);		
		return $this;
	}
	
	protected function loadFromCache() {
		if($user_settings = $this->CI->session->userdata('settings_cache')) {
			foreach($user_settings as $key => $value)
				$this->settings[$key] = $value;
			$this->loaded = TRUE;
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	protected function saveToCache() {
		$settings = array();
		foreach($this->user_settings as $key)
			$settings[$key] = $this->settings[$key];
		$this->CI->session->set_userdata('settings_cache', $settings);
	}
	
	public function flush() {
		$this->loadFromDatabase($this->CI->session->userid());
	}
	
	public function get($key) {
		return $this->load()->settings[$key];
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