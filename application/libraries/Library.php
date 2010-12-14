<?php
class Library {
	public function __construct() {
		log_message('debug', __CLASS__." Class Initialized");
	}
	
	public function __get($name) {
		return get_instance()->$name;
	}
}