<?php
class Json extends MY_Controller {	
	function get_keepalive() {
		$this->db->query("UPDATE users SET online = 0 WHERE TIMESTAMPDIFF(MINUTE, lastseen, NOW()) > 10");
		$data = array('data' => array('keepalive', 'stayin alive'));
		$this->redirect = TRUE;
		$this->load->view('json', $data);
	}
}
