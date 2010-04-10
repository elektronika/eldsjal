<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Acl {	
	protected $rights = array();
	protected $loaded = FALSE;
	
	public function __get($var) {
		return get_instance()->$var;
	}
	
	public function check($context_id, $right = 'read') {
		return $this->session->isAdmin() ? TRUE : $this->check_right($context_id, $right);
	}
	
	protected function check_right($context_id, $right) {
		return isset($this->load()->rights[$context_id][$right]) ? $this->rights[$context_id][$right] : FALSE;
	}
	
	protected function load() {
		if( ! $this->loaded) {
			$rights = $this->db->where('user_id', $this->session->userId())->or_where('user_id', 0)->get('acl')->result();
			foreach($rights as $right)
				foreach(array('read', 'create', 'reply', 'admin') as $action)
					$this->set($right->category_id, $action, $right->$action);
		}
		
		return $this;
	}
	
	protected function set($category_id, $right, $value){
		$this->rights[$category_id][$right] = isset($this->rights[$category_id][$right]) ? max($this->rights[$category_id][$right], $value) : $value;
	}
}