<?php

class Info extends Controller {
    function get_index()
    {
		$this->load->helper('url');
		$boardmembers = $this->db->query('SELECT username, users.userid, board.title, users.first_name, users.last_name, users.email FROM users JOIN board ON users.userid = board.userid WHERE rights = 10 ORDER BY sort')->result();
		$this->dwootemplate->assign('boardmembers', $boardmembers);
    	$this->dwootemplate->display('info_index.tpl');
    }

	function get_policies($policy = 'index') {
		$policies = $this->db->get('policy')->result();
		$policy = $this->db->where('slug', $policy)->get('policy')->result();
		
		$this->dwootemplate->assign('policy', $policy);
		$this->dwootemplate->assign('policies', $policies);
		$this->dwootemplate->display('info_policies.tpl');
	}
	
	function get_groups() {
		$this->dwootemplate->display('info_groups.tpl');
	}
	
	function get_rules() {
		$this->dwootemplate->display('info_rules.tpl');
	}
}