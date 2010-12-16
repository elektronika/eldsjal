<?php
class Migrate extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('migrations');
		$this->output->enable_profiler(TRUE);
	}
	
	public function get_index() {
		print 'Current version: '.$this->migrations->current().'<br/>Max version: '.$this->migrations->max_version();
	}
	
	public function get_install() {
		$this->migrations->install();
	}
}