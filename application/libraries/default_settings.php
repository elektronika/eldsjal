<?php
class default_settings extends Library {
	protected $config;
	
	public function __construct($config = array()) {
		$this->config = $config;
	}
	
	public function install() {
		$this->load->library('settings');
		
		foreach($this->config as $setting)
			$this->settings->set($setting['key'], $setting['value']);
	}
}