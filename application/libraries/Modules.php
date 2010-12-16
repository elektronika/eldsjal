<?php
class Modules extends Library {
	protected $modules = array();
	
	public function __construct($config = array()) {
		parent::__construct();
		foreach($config['modules'] as $module) {
			require(APPPATH.'modules/'.$module.'/'.$module.EXT);
			$this->modules[$module] = new {$module.'Module'}();
		}
	}
}

class Module extends Library {}