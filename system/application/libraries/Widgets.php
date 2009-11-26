<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Widgets {
	protected $CI;
	
	public function __construct() {
		$this->CI =& get_instance();
		log_message('debug', "Widget Class Initialized");
	}
}