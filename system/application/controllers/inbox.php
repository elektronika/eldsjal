<?php

class Inbox extends Controller {

	function __construct() {
		parent::Controller();	
		// $this->output->enable_profiler(TRUE);
	}

	function get_index() {
		$alerts = $this->alert->get_all_for_user($this->user->userId());
		
		$this->dwootemplate->assign('alerts', $alerts);
		$this->dwootemplate->display('inbox.tpl');
	}
}