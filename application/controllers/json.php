<?php
class Json extends MY_Controller {	
	public function __construct() {
		parent::__construct();
		$this->show_profiler = FALSE;
		$this->view->template = 'json';
	}
	
	function get_keepalive() {
		$this->view->data->keepalive = 'stayin alive';
		$this->view->data->alerts = $this->alerts->count_by_type();
	}
	
	function get_tagsearch() {
		$this->view->data->query = $this->input->get('query');
		$this->view->data->suggestions = $this->models->user->search_tags($this->input->get('query'), 'after');
	}
}
