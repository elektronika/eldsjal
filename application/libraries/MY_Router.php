<?php
class MY_Router extends CI_Router {

	public $method = 'get_index';

	public function set_method($method) {
		$this->method = strtolower($_SERVER['REQUEST_METHOD']).'_'.$method;
	}

	public function fetch_method() {
		return ($this->method == $this->fetch_class()) ? strtolower($_SERVER['REQUEST_METHOD']).'_index' : $this->method;
	}
}