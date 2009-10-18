<?php
abstract class Spiffy_View {
	protected $data = array();
	
	public function set($key, $data) {
		$this->data[$key] = $data;
	}
	
	public abstract function render();
	
	public abstract function redirect();
}