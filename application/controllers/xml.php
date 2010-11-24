<?php
class Xml extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->show_profiler = FALSE;
	}
	
	public function acl_controller() {
		return $this->session->isLoggedIn();
	}

	public function get_usermenu($user_id) {
		$this->user = $this->models->user->get_by_id($user_id);
		$this->user->does = $this->models->user->artList($user_id);
		$this->template = 'usermenu.tpl';
	}
	
	public function get_guestbook($user_id) {
		$this->userid = $user_id;
		$this->template = 'usermenu_guestbook.tpl';
	}
	
	public function get_message($user_id) {
		$this->userid = $user_id;
		$this->template = 'usermenu_message.tpl';
	}
}
