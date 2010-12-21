<?php
class UserModel extends AutoModel {
	protected $remap = array();
	
	public function __construct() {
		$this->remap = array(
			'userId' => 'userid',
			'yahoo' => 'phone',
			'locationName' => 'location'
			);
	}
	
	public function get_by_id($user_id) {
		$user = $this->db
			->select('users.*, locations.*, fadder.userid AS fadder_id, fadder.username AS fadder_name')
			->where('users.userid', intval($user_id))
			->join('locations', 'city = locationid', 'left')
			->join('users AS fadder', 'fadder.userid = users.approvedby', 'left')
			->get('users')->row();
		
		$user->birthday = mktime(0, 0, 0, $user->born_month, $user->born_date, $user->born_year);

		$user = $this->util->remap($user, $this->remap);
		
		// Det här kommer från något lattjolajban på edit-sidan. Tydligen fukkas telefon-fältet upp på någe vänster. Jaja.
		if( ! isset($user->phone))
			$user->phone = '';
		
		return $user;
	}
	
	protected function prepare(stdClass $user) {
		$user->birthday = mktime(0, 0, 0, $user->born_month, $user->born_date, $user->born_year);
		$user = $this->util->remap($user, $this->remap);
		// Det här kommer från något lattjolajban på edit-sidan. Tydligen fukkas telefon-fältet upp på någe vänster. Jaja.
		if( ! isset($user->phone))
			$user->phone = '';
		return $user;
	}
	
	public function by_ids(Array $ids) {
		if( ! empty($ids))
			$this->query->where_in('userid', $ids);
		return $this;
	}
	
	public function by_id($id) {
		$this->query->where('userid', $id);
		return $this;
	}
	
	public function by_birthday($month, $day) {
		$this->query->where(array('born_month' => $month, 'born_date' => $day));
		return $this;
	}
	
	public function join_fadder() {
		$this->query->select('fadder.userid AS fadder_id, fadder.username AS fadder_name')->join('users AS fadder', 'fadder.userid = users.approvedby', 'left');
		return $this;
	}
	
	public function join_location() {
		$this->query->join('locations', 'city = locationid', 'left');
		return $this;	
	}
	
	public function get_by_ids(Array $ids) {
		return ! empty($ids) ? $this->db->select('userid, username, ping')->where_in('userid', $ids)->get('users')->result() : array();
	}
	
	public function allow_anonymous_viewers($user_id) {
		return ($this->db->query("SELECT private FROM users WHERE userid = {$user_id}")->row()->private < 2);
	}
	
	public function create($email) {
		$this->db->insert('users', array('email' => $email, 'register_date' => $this->util->mysql_date()));
		return $this->db->insert_id();
	}
	
	public function get_restricted_fields() {
		$fields = array('userid', 'lastLogin', 'lastSeen', 'fourlast', 'member', 'redirect', 'born_year', 'born_month', 'born_date', 'userType', 'register_date', 'approvedBy', 'eldsjalFind', 'reset_key', 'deleted', 'hasimage', 'salt', 'password');
		return array_combine($fields, $fields);
	}
	
	public function set_password($userId, $password) {
		$salt = $this->generate_salt($userId);
		$this->db->update('users', array('password' => $this->session->hash($password, $salt)), array('userid' => $userId));
	}
	
	public function artList($user_id) {
		$artlist = array();
		$does = $this->db
			->select('artname, artlist.artid')
			->where('userid', $user_id)
			->join('artlist', 'userartlist.artid = artlist.artid')
			->get('userartlist')->result();
		foreach($does as $do)
			$artlist[$do->artid] = $do->artname;
		
		return $artlist;
	}
	
	public function set_art_list($user_id, $art_list) {
		$this->db->where('userid', $user_id)->delete('userartlist');
		foreach($art_list as $art)
			$this->db->insert('userartlist', array('userid' => $user_id, 'artid' => $art));
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
		$salt = $this->db->where('username', $username)->get('users')->row()->salt;
		$user = $this->db
			->where('username', $username)
			->where('password', $this->session->hash($password, $salt))
			->where('deleted', 0)
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
		$names = $this->db->select('userid, username')->where_in('userid', $user_ids)->get('users')->result();
		foreach($names as $name)
			$out[$name->userid] = $name;
		return $out;
	}
	
	public function get_by_birthday($month, $day) {
		return $this->db->select('userid, username, ping')->where(array('born_month' => $month, 'born_date' => $day))->get('users')->result();
	}
	
	public function get_latest_logins($limit = 10) {
		return $this->db->select('userid, username, lastlogin')->order_by('lastlogin', 'desc')->get('users', $limit)->result();
	}
	
	public function sublinks($user_id, $active = NULL) {
		$sublinks = array();
		
		$sublinks['presentation'] = array('href' => '/user/'.$user_id, 'title' => 'Presentation');
		$sublinks['guestbook'] = array('href' => '/guestbook/view/'.$user_id, 'title' => 'Gästbok');
		if($this->session->userid() != $user_id)
			$sublinks['message'] = array('href' => '/messages/new/'.$user_id, 'title' => 'Meddelande');
		if($this->has_images($user_id))
			$sublinks['gallery'] = array('href' => '/gallery/user/'.$user_id, 'title' => 'Bilder');
		if($this->has_thoughts($user_id))
			$sublinks['thoughts'] = array('href' => '/thoughts/user/'.$user_id, 'title' => 'Tankar');
		if($this->session->userid() == $user_id || $this->session->isAdmin())
			$sublinks['settings'] = array('href' => '/user/'.$user_id.'/edit', 'title' => 'Inställningar');
		if($this->session->userid() != $user_id)
			$sublinks['fav'] = array('href' => '/user/'.$user_id.'/fav', 'title' => 'Favva!');
		if($this->session->isAdmin())
			$sublinks['admin'] = array('href' => '/user/'.$user_id.'/admin', 'title' => 'Admin');
			
		if( ! is_null($active))
			unset($sublinks[$active]);
			
		return $sublinks;
	}
	
	public function add_address_info($user) {
		// $address = $this->db->where('userid', $user->userid)->get('address')->row();
		// if( ! empty($address)) {
		// 	$user->street_address = $address->Gatuadress1;
		// 	$user->postal_code = $address->Postnummer;
		// 	$user->postal_city = $address->Stad;
		// 	$user->country = $address->Land;
		// } else {
		// 	$user->street_address = 
		// 	$user->postal_code = 
		// 	$user->postal_city = 
		// 	$user->country = '';
		// }
		
		return $user;
	}
	
	public function has_fadder($user_id) {
		return $this->db->select('approvedby')->where('userid', $user_id)->get('users')->row()->approvedby > 0;
	}
	
	public function is_deleted($user_id) {
		return $this->db->select('deleted')->where('userid', $user_id)->get('users')->row()->deleted > 0;
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
	
	public function add_favorite($user_id, $favorite_id) {
		$this->db->insert('user_favorites', array('user_id' => $user_id, 'favorite_id' => $favorite_id));
	}
	
	public function remove_favorite($user_id, $favorite_id) {
		$this->db->delete('user_favorites', array('user_id' => $user_id, 'favorite_id' => $favorite_id));
	}
	
	public function get_favorites($user_id, $only_online = FALSE, $location = FALSE) {
		if($only_online)
			$this->db->where('ping >', (time() - $this->settings->get('online_timeout')));
		if($location)
			$this->db->where('city', $location);
		$users = $this->db->select('username, userid, ping')->where('user_id', $user_id)->join('users', 'userid = favorite_id')->order_by('ping', 'desc')->get('user_favorites')->result();
		$out = array();
		foreach($users as $user)
			$out[$user->userid] = $user;
		return $out;
	}
	
	public function get_tags($user_id, $kind = NULL, $structure_by_kind = FALSE) {
		$tags = $this->db->where('user_id', $user_id)->join('tags', 'tags.id = tag_id')->get('users_tags')->result();
		if($structure_by_kind) {
			$tags_structured = array('teach' => array(), 'learn' => array());
			foreach($tags as $tag) {
				$kind = is_null($tag->kind) ? 'tag' : $tag->kind;
				$tags_structured[$kind][] = $tag->title;
			}
			$tags = $tags_structured;
		} else {
			$tags_structured = array();
			foreach($tags as $tag)
				$tags_structured[] = $tag->title;
			$tags = $tags_structured;
		}
		return $tags;
	}
	
	public function set_tags($user_id, $kind, Array $tag_ids) {
		$this->db->delete('users_tags', array('user_id' => $user_id, 'kind' => $kind));
		foreach($tag_ids as $tag_id)
			$this->db->insert('users_tags', array('user_id' => $user_id, 'kind' => $kind, 'tag_id' => $tag_id));
	}
	
	public function user_ids_by_location($location_id) {
		$user_ids = array();
		$users = $this->db->select('userid AS id')->where('city', $location_id)->get('users')->result_array();
		foreach($users as $user)
			$user_ids[$user['id']] = $user['id'];
		return $user_ids;
	}
}