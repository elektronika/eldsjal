<?php
class Classloader {
	public function __construct() {
		spl_autoload_register(array('Classloader', 'autoload'));
	}
	
	public static function autoload($className) {
		if(file_exists(APPPATH.'classes/'.$className.'.php'))
			require(APPPATH.'classes/'.$className.'.php');
	}
}