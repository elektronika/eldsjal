<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Session extends CI_Session {
	protected $groups;
	protected $settings = array();
	protected $messageTypes = array('notice', 'warning');
	protected $object;
	
	public function MY_Session() {
		parent::CI_Session();
		$this->object =& get_instance();
	}
	
	public function usertype() {
		return $this->userdata('usertype', 0);
	}
	
	public function isLoggedIn() {
		return ($this->usertype() > 0);
	}
	
	public function hasPrivilege($privilege) {
		return in_array($this->getPrivileges(), $privilege);
	}
	
	public function isInGroup($group) {
		return in_array($this->getGroups(), $group);
	}
	
	public function username() {
		return $this->userdata('username', 'Gäst');
	}
	
	public function userid() {
		return $this->userdata('userid', 0);
	}
	
	public function userdata($item, $fallback = FALSE) {
		$data = parent::userdata($item);
		if($data === FALSE)
			$data = $fallback;
		return $data;
	}
	
	public function lastlogin() {
		return $this->userdata('lastlogin', 0);
	}
	
	public function isAdmin() {
		return ($this->usertype() >= 100);
	}
	
	public function getGroups() {
		if( ! is_array($this->groups)) {
			$groupNames = array(
				10 => 'styrelsen',
				3 => 'event',
				5 => 'elektronika',
				100 => 'admin',
				4 => 'internationella'
			);
			$this->groups = array();
			$groups = $this->object->models->user->get_groups($this->userId());
			foreach($groups as $group)
				$this->groups[$group->rights] = $groupNames[$group->rights];
		}
		return $this->groups;
	}
	
	public function getPrivileges() {
		return array();
	}
	
	public function authenticate($username, $password) {
		$salt = $this->object->models->user->get_salt_for_username($username);
		$user = $this->object->db
			->where('username', $username)
			->where('password', $this->hash($password, $salt))
			->get('users')->row();
		
		if(isset($user->userId)) {
			$this->set_userdata('userid', $user->userId);
			$this->set_userdata('username', $user->username);
			$this->set_userdata('usertype', $user->userType);
			$this->set_userdata('lastlogin', $this->object->util->assureTimestamp($user->lastLogin));
			$this->object->db->update('users', array('online' => 1, 'lastlogin' => $this->object->util->mysql_date()), array('userid' => $user->userId));
			
			return true;
		} else {
			return false;
		}		
	}
	
	protected function hash($password, $salt) {
		return $password; // *rysa*
	}
	
	public function checkPassword($password) {
		$salt = $this->object->models->user->get_salt_for_username($this->username());
		return $this->object->models->user->check_password($this->username(), $this->hash($password, $salt));
	}
	
	public function logout() {
		$this->destroy();
		$this->object->db->update('users', array('online' => 0), array('userid' => $this->userid()));
	}
	
	public function setting($key, $default = NULL) {
		if(is_null($default))
			$default = $this->object->util->setting($key);
		return isset($this->settings[$key]) ? $this->settings[$key] : $default;
	}
	
	public function message($message, $type = 'notice') {
		if(in_array($type, $this->messageTypes))
			$this->object->session->set_flashdata($type, $message);
	}
	
	public function getMessages() {
		$messages = array();
		foreach($this->messageTypes as $type)
			$messages[$type] = $this->flashdata($type);
		return $messages;
	}
}