<?php
// YOU MUST EDIT THIS TO BE THE PATH TO YOUR DOCTRINE LIBRARY
// I put mine in a 'libs' folder at the same level as the 
// CI application folder, but it can be anywhere.
require_once APPPATH   	   . DIRECTORY_SEPARATOR . 
				// '..' 	   . DIRECTORY_SEPARATOR . 
				'libraries'     . DIRECTORY_SEPARATOR . 
				'Doctrine' . DIRECTORY_SEPARATOR . 
				'Doctrine.php';
 
function bootstrap_doctrine() {
 
	@include APPPATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'database' . EXT;
 
	// Set the autoloader
	spl_autoload_register(array('Doctrine', 'autoload'));
 
	//optional, you can set this to whatever you want, or not set it at all
	Doctrine_Manager::getInstance()->setAttribute('model_loading', 'aggressive');
 
	// Load the Doctrine connection
	// (Notice the use of $active_group here, to make it easy to swap out
	//  you connection based on you database.php configs)
 
	if (!isset($db[$active_group]['dsn'])) {
		//try to create the dsn, if it has not been manually set
		//in your config. I personally would opt to set my
		//dsn manually, but it works either way
		$db[$active_group]['dsn'] = $db[$active_group]['dbdriver'] . 
                        '://' . $db[$active_group]['username'] . 
                        ':' . $db[$active_group]['password']. 
                        '@' . $db[$active_group]['hostname'] . 
                        '/' . $db[$active_group]['database'];
	}
 
	Doctrine_Manager::connection($db[$active_group]['dsn'])->setCharset('utf8'); ;
 
	// Load the models for the autoloader
	// This assumes all of your models will exist in you
	// application/models folder
	Doctrine::loadModels(APPPATH . DIRECTORY_SEPARATOR . 'models/generated');
	Doctrine::loadModels(APPPATH . DIRECTORY_SEPARATOR . 'models');
}