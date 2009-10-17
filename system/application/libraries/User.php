<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_User {
	protected $groups;
	protected $settings = array();
	protected $messageTypes = array('notice', 'warning');
	
	public function __construct() {
		$this->CI =& get_instance();
		log_message('debug', "User Class Initialized");
	}
	
	public function usertype() {
		if( !($usertype = $this->CI->session->userdata('usertype')) )
			$usertype = 0;
		return $usertype;
	}
	
	public function isLoggedIn() {
		return ($this->usertype() > 0);
	}
	
	public function hasPrivilege($privilege) {
		return in_array($this->getPrivileges, $privilege);
	}
	
	public function isInGroup($group) {
		return in_array($this->getGroups(), $group);
	}
	
	public function username() {
		return $this->CI->session->userdata('username');
	}
	
	public function userid() {
		return $this->CI->session->userdata('userid');
	}
	
	public function lastlogin() {
		return $this->CI->session->userdata('lastlogin');
	}
	
	public function isAdmin() {
		return ($this->usertype() >= 100);
	}
	
	public function getGroups() {
		if(!is_array($this->groups)) {
			$this->groups = array();
			$groups = $this->CI->db->where('userid', $this->userid())->get('board')->result();
			foreach($groups as $group) {
				switch($group->rights) {
					case 10: // Styrelsen
						$this->groups[] = 'styrelsen';
						break;
					case 3: // Event
						$this->groups[] = 'event';
						break;
					case 5: // Elektronika
						$this->groups[] = 'elektronika';
						break;
					case 100: // Admin
						$this->groups[] = 'admin';
						break;
					case 4: // Internationella
						$this->groups[] = 'internationella';
						break;
				}
			}
		}
		return $this->groups;
	}
	
	public function getPrivileges() {
		return array();
	}
	
	public function authenticate($username, $password) {
		$user = $this->CI->db
			->where('username', $username)
			->where('password', $this->hash($password, NULL))
			->get('users')->row();
		
		if(isset($user->userId)) {
			$this->CI->session->set_userdata('userid', $user->userId);
			$this->CI->session->set_userdata('username', $user->username);
			$this->CI->session->set_userdata('usertype', $user->userType);
			$this->CI->session->set_userdata('lastlogin', $this->CI->util->assureTimestamp($user->lastLogin));
			// print $this->CI->util->assureTimestamp($user->lastLogin).' :: '.$this->CI->session->userdata('lastlogin');
			// die();
			$this->CI->db->update('users', array('online' => 1, 'lastlogin' => $this->CI->util->mysql_date()), array('userid' => $user->userId));
			
			return true;
		} else {
			return false;
		}		
	}
	
	protected function hash($password, $salt) {
		return $password; // *rysa*
	}
	
	public function checkPassword($password) {
			$user = $this->CI->db
				->where('username', $this->username())
				->where('password', $this->hash($password, NULL))
				->get('users')->row();
			return isset($user->userId);
	}
	
	public function logout() {
		$this->CI->session->destroy();
		$this->CI->db->update('users', array('online' => 0), array('userid' => $this->userid()));
	}
	
	public function setting($key, $default = NULL) {
		if(is_null($default))
			$default = $this->CI->util->setting($key);
		return isset($this->settings[$key]) ? $this->settings[$key] : $default;
	}
	
	public function message($message, $type = 'notice') {
		if(in_array($type, $this->messageTypes))
			$this->CI->session->set_flashdata($type, $message);
	}
	
	public function getMessages() {
		$messages = array();
		foreach($this->messageTypes as $type)
			$messages[$type] = $this->CI->session->flashdata($type);
		return $messages;
	}
}