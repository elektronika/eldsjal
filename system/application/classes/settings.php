<?php
class Settings implements Cacheable {
	protected $settings;
	protected $loaded = FALSE;
	protected $user_id = 0;
	
	public function __construct($user_id = 0) {
		$this->user_id = $user_id;
	}
	
	public function retrieveCacheData() {
		return $this->settings;
	}
	
	public function injectCacheData(Array $data) {
		$this->settings = $data;
		return $this->loaded = TRUE;
	}
	
	protected function db() {
		return get_instance()->db;
	}
	
	protected function loadFromDatabase($user_id) {
		$result = $this->db()->where('user_id', 0)->or_where('user_id', (int) $user_id)->order_by('user_id', 'asc')->get('settings')->result();
		foreach($result as $setting)
			$this->settings[$setting->key] = $setting->value;
		$this->loaded = TRUE;
		$this->saveToCache();
	}
	
	protected function load() {
		if( ! $this->loaded && ! $this->loadFromCache())
			$this->loadFromDatabase($this->user_id);
		return $this;
	}
	
	protected function loadFromCache() {
		// 		if($settings = $this->CI->session->userdata('settings_cache')) {
		// 			$this->settings = $settings;
		// 			$this->loaded = TRUE;
		// 			return TRUE;
		// 		} else {
		// 			return FALSE;
		// 		}
		return FALSE;
	}
	
	protected function saveToCache() {
		// $this->CI->session->set_userdata('settings_cache', $this->settings);
	}
	
	public function flush() {
		$this->loadFromDatabase($this->user_id);
	}
	
	public function get($key) {
		return $this->load()->settings[$key];
	}
	
	public function get_array($key, $separator = ',') {
		return explode($separator, $this->get($key));
	}
	
	public function delete_all() {
		$this->db()->empty_table('settings');
	}
	
	public function set($key, $value, $user_id = 0) {
		if($user_id == $this->user_id) {
			$this->settings[$key] = $value;
			$this->saveToCache();
		}    
		$this->db()->delete('settings', array('key' => $key, 'user_id' => $user_id));
		$this->db()->insert('settings', array('key' => $key, 'value' => $value, 'user_id' => $user_id));
	}
	
	public function get_all() {
		return $this->db()->order_by('key', 'asc')->get('settings')->result();
	}
}