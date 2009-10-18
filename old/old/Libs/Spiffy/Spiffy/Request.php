<?php
class Spiffy_Request {
	protected $args = array();
	protected $allArgs = array();
	
	public function __construct() {
		$this->args = explode('/', $_GET['q']);
		$this->allArgs = $this->args;
	}
	
	public function nextArg() {
		return array_shift($this->args);
	}
	
	public function restOfArgs() {
		return $this->args;
	}
	
	public function allArgs() {
		return $this->allArgs;
	}
	
	public function requestMethod() {
		return 'get'; // *HOST*
	}
	
	public function undoNextArg() {
		$arg = end(array_diff($this->args, $this->allArgs));
		array_unshift($this->args, $arg);
		return $this;
	}
}