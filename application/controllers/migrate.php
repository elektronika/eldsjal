<?php
class Migrate extends Controller {
	public function __construct() {
		parent::Controller();
		$this->load->library('migrations');
		$this->output->enable_profiler(TRUE);
	}
	
	public function index() {
		print 'Current version: '.$this->migrations->current().'<br/>Max version: '.$this->migrations->max_version();
	}
	
	public function install() {
		$this->migrations->install();
	}
}