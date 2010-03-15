<?php
class Json extends MY_Controller {	
	function get_keepalive() {
		$data = array('data' => array('keepalive', 'stayin alive'));
		$this->redirect = TRUE;
		$this->show_profiler = FALSE;
		$this->load->view('json', $data);
	}
}
