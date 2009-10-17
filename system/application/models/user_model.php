<?php
class User_model extends Model {
	private $remap = array();
	
	public function __construct() {
		parent::Model();
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
			->where('userid', intval($user_id))
			->join('locations', 'city = locationid')
			->get('users')->row();
		unset($user->password);
		$user->birthday = mktime(0, 0, 0, $user->born_month, $user->born_date, $user->born_year);
		$user->actions = array(
			array('title' => 'Presentation', 'class' => 'presentation', 'href' => '/user/'.$user->slug),
			array('title' => 'Gästbok', 'class' => 'guestbook', 'href' => '/user/'.$user->slug.'/guestbook'),
			array('title' => 'Meddelande', 'class' => 'message', 'href' => '/message/new/'.$user->slug)
		);
		
		if($this->has_images($user_id))
			$user->actions[] = array('title' => 'Bilder', 'class' => 'images', 'href' => '/user/'.$user->slug.'/images');
		if($this->has_thoughts($user_id))
			$user->actions[] = array('title' => 'Tankar', 'class' => 'thoughts', 'href' => '/user/'.$user->slug.'/thoughts');
			
		if($user->userId == $this->user->userId() || $this->user->isAdmin()) {
			$user->actions[] = array('title' => 'Inställningar', 'class' => 'usersettings', 'href' => '/user/'.$user->slug.'/edit');
			$user->actions[] = array('title' => 'Byt bild', 'class' => 'image', 'href' => '/user/'.$user->slug.'/image');
		}
		if($this->user->isAdmin())
			$user->actions[] = array('title' => 'Admin', 'class' => 'admin', 'href' => '/user/'.$user->slug.'/admin');

		return $this->util->remap($user, $this->remap);
	}
	
	public function get_by_slug($slug) {
		return $this->get_by_id($this->user_id_for_slug($slug));
	}
	
	public function allow_anonymous_viewers($user_id) {
		return ($this->db->query("SELECT private FROM users WHERE userid = {$user_id}")->row()->private < 2);
	}
	
	public function save($user) {
		
	}
	
	public function create($username, $email) {
		
	}
	
	public function get_restricted_fields() {
		return array('userid', 'lastLogin', 'lastSeen', 'fourlast', 'member', 'slug', 'redirect', 'born_year', 'born_month', 'born_date', 'userType', 'register_date', 'approvedBy', 'eldsjalFind');
	}
	
	public function set_password($userId, $password) {
		$this->db->update('users', array('password' => $password), array('userid' => $userId));
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
}