<?php
class Acl implements Cacheable {	
	protected $rights = array();
	protected $by_right = array();
	protected $loaded = FALSE;
	protected $flush = FALSE;
	protected $user_id;
	protected $override;
	
	public function __construct($user_id = 0, $override = FALSE) {
		$this->user_id = $user_id;
		$this->override = FALSE;
	}
	
	public function retrieveCacheData() {
		return array('rights' => $this->rights, 'by_right' => $this->by_right);
	}
	
	public function injectCacheData(Array $data) {
		$this->rights = $data['rights'];
		$this->by_right = $data['by_right'];
		return $this->loaded = TRUE;
	}
	
	public function check($context_id, $right = 'read') {
		return $this->override ? TRUE : $this->check_right($context_id, $right);
	}
	
	protected function db() {
		return get_instance()->db;
	}
	
	protected function check_right($context_id, $right) {
		return isset($this->load()->rights[$context_id][$right]) ? $this->rights[$context_id][$right] : FALSE;
	}
	
	protected function load() {
		if( ! $this->loaded || $this->flush) {
			if($this->flush || ! $this->loadFromCache())
				$this->loadFromDatabase();
			
			if($this->user_id != 0)
				$this->set(-1, 'read', TRUE);
			$this->set(0, 'read', TRUE);
		}
		
		return $this;
	}
	
	protected function loadFromCache() {
		// if($rights = $this->session->userdata('acl_cache')) {
		// 	$this->setRights($rights);
		// 	return TRUE;
		// } else {
		// 	return FALSE;
		// }
		return FALSE;
	}
	
	protected function saveToCache(Array $rights) {
		// $this->session->set_userdata('acl_cache', $rights);
	}
	
	protected function loadFromDatabase() {
		$rights = $this->db()->where('user_id', $this->user_id)->or_where('user_id', 0)->get('acl')->result();
		$this->setRights($rights);
		// $this->saveToCache($rights);
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
	
	public function get_users_by_right($category_id, $right = 'read') {
		$users = $this->db()->where('category_id', $category_id)->where($right, 1)->get('acl')->result();
		$out = array();
		foreach($users as $user)
			$out[$user->user_id] = $user->user_id;
		return $out;
	}
}