<?php
class Info extends MY_Controller {
    function get_index() {
		$this->boardmembers = $this->db->query('SELECT username, users.userid, board.title, users.first_name, users.last_name, users.email FROM users JOIN board ON users.userid = board.userid WHERE rights = 10 ORDER BY sort')->result();
    }

	function get_policies($policy = 'index') {
		$this->policies = $this->db->get('policy')->result();
		$this->policy = $this->db->where('slug', $policy)->get('policy')->result();
	}
	
	function get_groups() {}
	
	function get_rules() {}
}