<?php
class Json extends MY_Controller {	
	function get_keepalive() {
		$this->view->data->keepalive = 'stayin alive';
		$this->view->data->alerts = $this->alerts->count_by_type();
		$this->show_profiler = FALSE;
		$this->view->template = 'json';
	}
}
