<?php
class Migrate extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('migrations');
		$this->output->enable_profiler(TRUE);
		$this->redirect = TRUE; // Så den inte försöker visa en view.
		$this->show_profiler = TRUE; // Så man ser vad som görs.
	}
	
	public function get_index() {
		print 'Current version: '.$this->migrations->current().'<br/>Max version: '.$this->migrations->max_version();
	}
	
	public function get_install() {
		$this->migrations->install();
	}
}