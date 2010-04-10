<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Acl {	
	protected $rights = array();
	protected $is_loaded = FALSE;
	
	protected function __get($var) {
		return get_instance()->$var;
	}
	
	public function check($context_id, $right = 'read') {
		return $this->session->isAdmin() ? TRUE : $this->check_right($context_id, $right);
	}
	
	protected function check_right($context_id, $right) {
		if( ! $this->is_loaded)
			$this->load_rights($this->session->userId());
			
		return isset($this->rights[$context_id][$right]) ? $this->rights[$context_id][$right] : FALSE;
	}
	
	protected function load_rights($user_id) {
		
	}
}