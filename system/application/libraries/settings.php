<?php
Class settings {
	protected $CI;	
	protected $settings;
	
	public function __construct() {
		$this->CI = get_instance();
		$this->settings = $this->load($this->CI->session->userid());
	}
	
	protected function load($user_id = 0) {
		$settings = array();
		$result = $this->CI->db->where('user_id', 0)->or_where('user_id', (int) $user_id)->order_by('user_id', 'asc')->get('settings')->result();
		foreach($result as $setting)
			$settings[$setting->key] = $setting->value;
		return $settings;
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
		$this->settings[$key] = $value;
		$this->CI->db->insert('settings', array('key' => $key, 'value' => $value, 'user_id' => $user_id));
	}
	
	public function get_all() {
		return $this->CI->db->order_by('key', 'asc')->get('settings')->result();
	}
}