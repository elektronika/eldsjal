<?php
class Library {
	protected $config = array();
	
	public function __construct($config = array()) {
		log_message('debug', __CLASS__." Class Initialized");
		$this->config = $config;
	}
	
	public function __get($name) {
		return get_instance()->$name;
	}
}