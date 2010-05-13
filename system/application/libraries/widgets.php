<?php
Class Widgets {
	protected $widgets = array();
	
	public function __construct() {}
	
	public function get($region) {
		return isset($this->widgets[$region]) ? $this->widgets[$region] : array();
	}
	
	public function all() {
		return $this->widgets;
	}
	
	public function set($region, Array $widget_names) {
		foreach(array_filter($widget_names) as $widget)
			$this->add($region, $widget);
		return $this;
	}
	
	public function nonono() {
		
	}
	
	public function add($region, $widget_name) {
		$this->widgets[$region][$widget_name] = $widget_name;
		return $this;
	}
	
	public function prepend($region, $widget_name) {
		$this->widgets[$region] = array($widget_name => $widget_name) + $this->widgets[$region];
		return $this;
	}
	
	public function clear($region) {
		unset($this->widgets[$region]);
		return $this;
	}
	
	public function remove($region, $widget_name) {
		unset($this->widgets[$region][$widget_name]);
		return $this;
	}
}