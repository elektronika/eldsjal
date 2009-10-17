<?php

class People extends Controller {
    function get_index()
    {
		$this->output->enable_profiler(TRUE);
	
		$people = $this->db
			->select("username, userid, CONCAT(SUBSTRING(presentation, 1, 250), '...') AS body", FALSE)
			->where('usertype >', 0)
			->order_by('register_date DESC')
			->get('users', 20)
			->result();
		$this->dwootemplate->assign('people', $people);
    	$this->dwootemplate->display('people_index.tpl');
    }

	public function acl_controller() {
		return $this->user->isLoggedIn();
	}
	
	public function get_map() {
		return 'hej';
	}
	
	public function acl_map() {
		return $this->user->isAdmin();
	}
}