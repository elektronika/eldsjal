<?php
class Board extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->widgets->add('right', 'boardmenu');
	}
	
    public function get_index() {
		$this->view->members = $this->db->query('SELECT username, users.userid, board.title, users.first_name, users.last_name, users.email FROM users JOIN board ON users.userid = board.userid WHERE rights = 10 ORDER BY sort')->result();
    }
	
	// Snabbhack för de statiska sidorna
	public function get_stadgar() {}
	public function get_celler() {}
	public function get_event() {}
	public function get_elektronika() {}
	public function get_fuel() {}
	public function get_internationella() {}
	public function get_core() {}
	public function get_bidrag() {}
	public function get_uteslutande() {}
	public function get_ordning() {}
	public function get_helvetet() {}
	public function get_fadder() {}
	public function get_forsakring() {}
	public function get_sakerhet() {}

}