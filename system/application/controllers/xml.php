<?php
class Xml extends Controller {	
	function __construct() {
		parent::Controller();
	}
	
	function acl_controller() {
		return $this->user->isLoggedIn();
	}

	function get_usermenu($user_id) {
		$this->load->model('user_model');
		
		$user = $this->user_model->get_by_id($user_id);
		$user->does = $this->user_model->artList($user_id);
		
		$this->dwootemplate->assign('user', $user);
		$this->dwootemplate->display('usermenu.tpl');
	}
	
	function get_guestbook($user_id) {
		$this->dwootemplate->assign('userid', $user_id);
		$this->dwootemplate->display('usermenu_guestbook.tpl');
	}
}
