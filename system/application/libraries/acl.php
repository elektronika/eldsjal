<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Acl {	
	protected $rights = array();
	protected $by_right = array();
	protected $loaded = FALSE;
	protected $flush = FALSE;
	
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
		if( ! $this->loaded || $this->flush) {
			if($this->flush || ! $this->loadFromCache())
				$this->loadFromDatabase();
			
			if($this->session->isLoggedIn())
				$this->set(-1, 'read', TRUE);
		}
		
		return $this;
	}
	
	protected function loadFromCache() {
		if($rights = $this->session->userdata('acl_cache')) {
			$this->setRights($rights);
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	protected function saveToCache(Array $rights) {
		$this->session->set_userdata('acl_cache', $rights);
	}
	
	protected function loadFromDatabase() {
		$rights = $this->db->where('user_id', $this->session->userId())->or_where('user_id', 0)->get('acl')->result();
		$this->setRights($rights);
		$this->saveToCache($rights);
	}
	
	protected function setRights(Array $rights) {
		foreach($rights as $right)
			foreach(array('read', 'create', 'reply', 'admin') as $action)
				$this->set($right->category_id, $action, $right->$action);
		
		$this->flush = FALSE;		
		$this->loaded = TRUE;
	}
	
	protected function set($category_id, $right, $value){
		$this->rights[$category_id][$right] = isset($this->rights[$category_id][$right]) ? max($this->rights[$category_id][$right], $value) : $value;
		if((bool) $value)
			$this->by_right[$right][$category_id] = $category_id;
	}
	
	public function get_by_right($right = 'read') {
		if(isset($this->load()->by_right[$right]))
			return $this->by_right[$right];
		else
			return array();
	}
	
	public function flush() {
		$this->rights = array();
		$this->by_right = array();
		$this->loaded = FALSE;
		$this->flush = TRUE;
		$this->load();
		return $this;
	}
}