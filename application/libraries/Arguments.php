<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_Arguments {
	protected $args = array();
	
	public function __construct() {
		log_message('debug', "Arguments Class Initialized");
		
		foreach(get_instance()->uri->segment_array() as $segment) {
			$args = explode(':', $segment);
			$this->args[array_shift($args)] = $args;
		}
	}
	
	public function get($key, $fallback = FALSE) {
		return (isset($this->args[$key])) ? current($this->args[$key]) : $fallback;
	}
	
	public function getArray($key, $fallback = FALSE) {
		return (isset($this->args[$key]) && count($this->args[$key]) > 0) ? $this->args[$key] : $fallback;
	}
}