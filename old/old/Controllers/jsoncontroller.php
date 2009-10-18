<?php
class JsonController extends Spiffy_Controller {
	public function __construct() {
		$this->view = new JsonView();
		// print 'hej';
		// print_r($this->view);
	}
	
	public function get_keepalive() {
		// DB::query('UPDATE users SET online = 0 WHERE TIMEDIFF(MINUTE, lastseen, NOW()) > 10');
		$this->view->set('online', 1);
		$this->view->set('lasse', 'liten');
		// print_r($this->view);
		return $this->view->render();
	}
	
	public function acl_keepalive() {
		return 1;
	}
}