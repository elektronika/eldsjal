<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Session extends CI_Session {
	var $session_id_ttl = 360; // session id time to live (TTL) in seconds
	var $flash_key = 'flash'; // prefix for "flash" variables (eg. flash:new:message)

	protected $groups;
	protected $settings = array();
	protected $messageTypes = array('notice', 'warning');
	protected $object;

	public function MY_Session() {
		$this->object =& get_instance();
		$this->_sess_run();
	}
	
	/**
    * Starts up the session system for current request
    */
    function _sess_run() {
        session_start();
        
        // check if session id needs regeneration
        if ( $this->_session_id_expired() ) {
            // regenerate session id (session data stays the
            // same, but old session storage is destroyed)
            $this->regenerate_id();
        }
        
        // delete old flashdata (from last request)
        $this->_flashdata_sweep();
        
        // mark all new flashdata as old (data will be deleted before next request)
        $this->_flashdata_mark();
    }

	public function usertype() {
		return $this->userdata('usertype', 0);
	}

	public function isLoggedIn() {
		return ($this->userid() > 0);
	}

	public function hasPrivilege($privilege) {
		return in_array($privilege, $this->getPrivileges());
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

	/**
	* Destroys the session and erases session storage
	*/
	function destroy() {
		unset($_SESSION);
		if ( isset( $_COOKIE[session_name()] ) )
			setcookie(session_name(), '', time()-42000, '/');
		session_destroy();
	}

	/**
	* Reads given session attribute value
	*/    
	public function userdata($item, $fallback = FALSE) {
		if($item == 'session_id') //added for backward-compatibility
			return session_id();
		else
			return isset($_SESSION[$item]) ? $_SESSION[$item] : $fallback;
	}

	/**
	* Sets session attributes to the given values
	*/
	public function set_userdata($newdata = array(), $newval = '') {
		if (is_string($newdata))
			$newdata = array($newdata => $newval);

		if (count($newdata) > 0)
			foreach ($newdata as $key => $val)
				$_SESSION[$key] = $val;
	}

	public function lastlogin() {
		return $this->userdata('lastlogin', time());
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
		$privileges = array(
			'newsadmin' => 6,
			'forumadmin' => 6,
			'linksadmin' => 3,
			'calendaradmin' => 3,
			'imageadmin' => 3,
			'wisdomadmin' => 3,
			'useradmin' => 2,
			'triviaadmin' => 2,
			'admin' => 10
		);
		$user_privileges = array();
		
		foreach($privileges as $name => $level)
			if($this->usertype() >= $level)
				$user_privileges[] = $name;
		return $user_privileges;
	}

	public function authenticate($username, $password) {
		$user = $this->object->db->select('userid, salt')->where('username', $username)->get('users')->row();
		if(empty($user))
			return FALSE;
		
		// Om det inte finns något salt så lagras användarens lösenord i klartext, set_password hashar det så allt blir som det ska.
		if(is_null($user->salt))
			$this->object->models->user->set_password($user->userid, $password);
			
		$user = $this->object->db
			->where('username', $username)
			->where('password', $this->hash($password, $user->salt))
			->where('deleted !=', 1)
			->get('users')->row();

		if(isset($user->userId)) {
			$this->load($user);
			$this->object->db->update('users', array('ping' => time(), 'lastlogin' => $this->object->util->mysql_date()), array('userid' => $user->userId));

			return true;
		} else {
			return false;
		}		
	}
	
	protected function load($user = NULL) {
		if(is_null($user))
			$user = $this->object->db->where('userid', $this->userId())->get('users')->row();
		
		$this->set_userdata('userid', $user->userId);
		$this->set_userdata('username', $user->username);
		$this->set_userdata('usertype', $user->userType);
		$this->set_userdata('location', $user->city);
		$this->set_userdata('lastlogin', $this->object->util->assureTimestamp($user->lastLogin));
	}
	
	public function flush() {
		$this->load();
	}

	public function hash($password, $salt) {
		return md5($password.$salt);
	}

	public function checkPassword($password) {
		$salt = $this->object->models->user->get_salt_for_username($this->username());
		return $this->object->models->user->check_password($this->username(), $this->hash($password, $salt));
	}

	public function logout() {
		$this->object->db->update('users', array('ping' => 0), array('userid' => $this->userid()));
		$this->destroy();
	}

	public function message($message, $type = 'notice') {
		if(in_array($type, $this->messageTypes))
			$this->object->session->set_flashdata($type, $message);
	}

	public function getMessages() {
		$messages = array();
		foreach($this->messageTypes as $type)
			if($this->flashdata($type) != '')
				$messages[$type] = $this->flashdata($type);
		return $messages;
	}
	
	/**
    * Erases given session attributes
    */
    function unset_userdata($newdata = array())
    {
        if (is_string($newdata))
        {
            $newdata = array($newdata => '');
        }
    
        if (count($newdata) > 0)
        {
            foreach ($newdata as $key => $val)
            {
                unset($_SESSION[$key]);
            }
        }        
    }
    
    /**
    * Checks if session has expired
    */
    function _session_id_expired() {
        if ( ! isset( $_SESSION['regenerated'] ) ) {
            $_SESSION['regenerated'] = time();
            return false;
        }
        
        $expiry_time = time() - $this->session_id_ttl;
        
        if ( $_SESSION['regenerated'] <=  $expiry_time )
            return true;

        return false;
    }
    
    /**
    * Sets "flash" data which will be available only in next request (then it will
    * be deleted from session). You can use it to implement "Save succeeded" messages
    * after redirect.
    */
    function set_flashdata($key, $value) {
        $flash_key = $this->flash_key.':new:'.$key;
        $this->set_userdata($flash_key, $value);
    }
    
    /**
    * Keeps existing "flash" data available to next request.
    */
    function keep_flashdata($key) {
        $old_flash_key = $this->flash_key.':old:'.$key;
        $value = $this->userdata($old_flash_key);

        $new_flash_key = $this->flash_key.':new:'.$key;
        $this->set_userdata($new_flash_key, $value);
    }

    /**
    * Returns "flash" data for the given key.
    */
    function flashdata($key) {
        $flash_key = $this->flash_key.':old:'.$key;
        return $this->userdata($flash_key);
    }
    
    /**
    * PRIVATE: Internal method - marks "flash" session attributes as 'old'
    */
    function _flashdata_mark() {
        foreach ($_SESSION as $name => $value) {
            $parts = explode(':new:', $name);
            if (is_array($parts) && count($parts) == 2) {
                $new_name = $this->flash_key.':old:'.$parts[1];
                $this->set_userdata($new_name, $value);
                $this->unset_userdata($name);
            }
        }
    }

    /**
    * PRIVATE: Internal method - removes "flash" session marked as 'old'
    */
    function _flashdata_sweep() {
        foreach ($_SESSION as $name => $value) {
            $parts = explode(':old:', $name);
            if (is_array($parts) && count($parts) == 2 && $parts[0] == $this->flash_key)
            	$this->unset_userdata($name);
        }
    }

	/**
	    * Regenerates session id
	    */
	    function regenerate_id()
	    {
	        // copy old session data, including its id
	        $old_session_id = session_id();
	        $old_session_data = $_SESSION;

	        // regenerate session id and store it
	        session_regenerate_id();
	        $new_session_id = session_id();

	        // switch to the old session and destroy its storage
	        session_id($old_session_id);
	        session_destroy();

	        // switch back to the new session id and send the cookie
	        session_id($new_session_id);
	        session_start();

	        // restore the old session data into the new session
	        $_SESSION = $old_session_data;

	        // update the session creation time
	        $_SESSION['regenerated'] = time();

	        // session_write_close() patch based on this thread
	        // http://www.codeigniter.com/forums/viewthread/1624/
	        // there is a question mark ?? as to side affects

	        // end the current session and store session data.
	        session_write_close();
	    }
}