<?php
class UserModel extends AutoModel {
	protected $remap = array();
	
	public function __construct() {
		parent::__construct();
		$this->remap = array(
			'userId' => 'userid',
			'yahoo' => 'phone',
			'locationName' => 'location'
			);
	}
	
	public function user_id_for_slug($slug) {
		return $this->db->query("SELECT userid FROM users WHERE slug = ".$this->db->escape($slug))->row()->userid;
	}
	
	public function get_by_id($user_id) {
		$user = $this->db
			->select('users.*, locations.*, fadder.userid AS fadder_id, fadder.username AS fadder_name')
			->where('users.userid', intval($user_id))
			->join('locations', 'city = locationid', 'left')
			->join('users AS fadder', 'fadder.userid = users.approvedby', 'left')
			->get('users')->row();
		unset($user->password);
		
		$user->birthday = mktime(0, 0, 0, $user->born_month, $user->born_date, $user->born_year);

		$user = $this->util->remap($user, $this->remap);
		
		// Det här kommer från något lattjolajban på edit-sidan. Tydligen fukkas telefon-fältet upp på någe vänster. Jaja.
		if( ! isset($user->phone))
			$user->phone = '';
		
		return $user;
	}
	
	public function get_by_slug($slug) {
		return $this->get_by_id($this->user_id_for_slug($slug));
	}
	
	public function allow_anonymous_viewers($user_id) {
		return ($this->db->query("SELECT private FROM users WHERE userid = {$user_id}")->row()->private < 2);
	}
	
	public function create($email) {
		$this->db->insert('users', array('email' => $email, 'register_date' => $this->util->mysql_date()));
		return $this->db->insert_id();
	}
	
	public function get_restricted_fields() {
		$fields = array('userid', 'lastLogin', 'lastSeen', 'fourlast', 'member', 'slug', 'redirect', 'born_year', 'born_month', 'born_date', 'userType', 'register_date', 'approvedBy', 'eldsjalFind', 'reset_key', 'deleted', 'hasimage');
		return array_combine($fields, $fields);
	}
	
	public function set_password($userId, $password) {
		$salt = $this->generate_salt($userId);
		$this->db->update('users', array('password' => $this->session->hash($password, $salt)), array('userid' => $userId));
	}
	
	public function artList($user_id) {
		$artlist = array();
		$does = $this->db
			->select('artname')
			->where('userid', $user_id)
			->join('artlist', 'userartlist.artid = artlist.artid')
			->get('userartlist')->result();
		foreach($does as $do)
			$artlist[] = $do->artname;
		
		return $artlist;
	}
	
	public function has_images($user_id) {
		return ($this->db->query('SELECT COUNT(*) AS count FROM images WHERE uploadedby = '.$user_id)->row()->count > 0);
	}
	
	public function has_thoughts($user_id) {
		return ($this->db->query('SELECT COUNT(*) AS count FROM diary WHERE userid = '.$user_id)->row()->count > 0);
	}
	
	public function get_salt_for_username($username) {
		return $this->db->where('username', $username)->get('users')->row()->salt;
	}
	
	public function generate_salt($user_id) {
		$salt = md5(microtime());
		$this->db->update('users', array('salt' => $salt), array('userid' => $user_id));
		return $salt;
	}
	
	public function check_password($username, $password) {
		$user = $this->db
			->where('username', $username)
			->where('password', $password)
			->get('users')->row();
		return isset($user->userId);
	}
	
	public function check_unique_username($username) {
		return ($this->db->select('COUNT(*) AS count', FALSE)->where('username', $username)->get('users')->row()->count == 0);
	}
	
	public function check_unique_email($email) {
		return ($this->db->select('COUNT(*) AS count', FALSE)->where('email', $email)->get('users')->row()->count == 0);
	}
	
	public function check_bad_username($username) {
		return ($this->db->select('COUNT(*) AS count', FALSE)->where('username', $username)->get('lockedusernames')->row()->count == 0);
	}
	
	public function get_groups($user_id) {
		return $this->db->where('userid', $userid)->get('board')->result();
	}
	
	public function mark_as_having_image($user_id) {
		$this->db->update('users', array('hasimage' => 1), array('userid' => $user_id));
	}
	
	public function delete_image($user_id) {
		$this->db->update('users', array('hasimage' => 0), array('userid' => $user_id));
	}
		
	public function get_names_for(Array $user_ids) {
		$out = array();
		$names = $this->db->select('userid, username, slug')->where_in('userid', $user_ids)->get('users')->result();
		foreach($names as $name)
			$out[$name->userid] = $name;
		return $out;
	}
	
	public function get_by_birthday($month, $day) {
		return $this->db->select('userid, username, slug')->where(array('born_month' => $month, 'born_date' => $day))->get('users')->result();
	}
	
	public function get_latest_logins($limit = 10) {
		return $this->db->select('userid, username, slug, lastlogin')->order_by('lastlogin', 'desc')->get('users', $limit)->result();
	}
	
	public function sublinks($user_id, $active = NULL) {
		$sublinks = array();
		
		$sublinks['presentation'] = array('href' => '/user/'.$user_id, 'title' => 'Presentation');
		$sublinks['guestbook'] = array('href' => '/guestbook/view/'.$user_id, 'title' => 'Gästbok');
		$sublinks['message'] = array('href' => '/messages/new/'.$user_id, 'title' => 'Meddelande');
		if($this->has_images($user_id))
			$sublinks['gallery'] = array('href' => '/gallery/user/'.$user_id, 'title' => 'Bilder');
		if($this->has_thoughts($user_id))
			$sublinks['thoughts'] = array('href' => '/thoughts/user/'.$user_id, 'title' => 'Tankar');
		if($this->session->userid() == $user_id || $this->session->isAdmin())
			$sublinks['settings'] = array('href' => '/user/'.$user_id.'/edit', 'title' => 'Inställningar');
		if($this->session->isAdmin())
			$sublinks['admin'] = array('href' => '/user/'.$user_id.'/admin', 'title' => 'Admin');
			
		if( ! is_null($active))
			unset($sublinks[$active]);
			
		return $sublinks;
	}
	
	public function add_address_info($user) {
		$address = $this->db->where('userid', $user->userid)->get('address')->row();
		if( ! empty($address)) {
			$user->street_address = $address->Gatuadress1;
			$user->postal_code = $address->Postnummer;
			$user->postal_city = $address->Stad;
			$user->country = $address->Land;
		} else {
			$user->street_address = 
			$user->postal_code = 
			$user->postal_city = 
			$user->country = '';
		}
		
		return $user;
	}
	
	public function has_fadder($user_id) {
		return $this->db->select('approvedby')->where('userid', $user_id)->get('users')->row()->approvedby > 0;
	}
	
	public function privacy_level($user_id) {
		return $this->db->select('privacy')->where('userid', $user_id)->get('users')->row()->privacy;
	}
	
	public function create_reset_key($user_id) {
		$reset_key = md5(microtime());
		$this->db->update('users', array('reset_key' => $reset_key), array('userid' => $user_id));
		return $reset_key;
	}
	
	public function validate_reset_key($user_id, $reset_key) {
		return $this->db->where('userid', $user_id)->where('reset_key', $reset_key)->get('users')->num_rows() > 0;
	}
	
	public function get_by_email($email) {
		$user_id = $this->db->where('email', $email)->get('users')->row()->userId;
		return $this->get_by_id($user_id);
	}
	
	public function online_count() {
		return $this->db->where('ping >', (time() - $this->settings->get('online_timeout')))->count_all_results('users');
	}
	
	public function mark_as_confirmed($user_id) {
		$this->db->update('users', array('confirmed' => 1), array('userid' => $user_id));
	}
}