<?php
class Modules extends Library {
	protected $modules = array();
	
	public function __construct($config = array()) {
		parent::__construct();
		$this->benchmark->mark('load_modules_start');
		foreach($config['load'] as $module) {
			require(APPPATH.'modules/'.$module.'/'.$module.EXT);
			$module_class = $module.'Module';
			$this->modules[$module] = new $module_class();
			if($this->profiler)
				$this->profiler->add_data('Modules', $module);
		}
		$this->benchmark->mark('load_modules_end');
	}
}

class Module extends Library {}