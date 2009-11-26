<?php
class People extends MY_Controller {
    function get_index() {	
		$this->people = $this->db
			->select("username, userid, CONCAT(SUBSTRING(presentation, 1, 250), '...') AS body", FALSE)
			->where('usertype >', 0)
			->order_by('register_date DESC')
			->get('users', 20)
			->result();
    }

	public function acl_controller() {
		return $this->session->isLoggedIn();
	}
	
	public function get_map() {}
	
	public function acl_map() {
		return $this->session->isAdmin();
	}
}