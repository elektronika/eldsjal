<?php
Class view {
	protected $data = array();
	protected $template_folder = '';
	
	public function __construct() {
		$this->template_folder = dirname(FCPATH) . '/system/application/views/';
	}
	
	public function __set($name, $value) {
		$this->data[$name] = $value;
	}
	
	public function &__get($name) {
		return $this->data[$name];
	}
	
	public function display() {
		extract($this->data);
		require($this->template_folder.$this->data['template'].'.php');
	}
}