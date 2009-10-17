<?php
class Guestbook_model extends Model {
	protected $remap = array();
	
	public function __construct() {
		parent::Model();
		$this->remap = array(
			'message' => 'body',
			'fromUserId' => 'userid',
			'date' => 'created'
		);
	}
	
	public function to_user($user_id, $offset, $limit) {
		$posts = $this->db
			->where('touserid', $user_id)
			->join('users', 'users.userid = guestbook.fromuserid')
			->order_by('date DESC')
			->get('guestbook', $limit, $offset)->result();
		return $this->util->remapLoop($posts, $this->remap);
	}
	
	public function get_post_by_id($post_id) {
		
	}
	
	public function is_to_user($post_id, $user_id) {
		
	}
	
	public function is_by_user($post_id, $user_id) {
		
	}
	
	public function count_posts_for_user($user_id) {
		return $this->db->select('COUNT(*) AS count')->where('touserid', $user_id)->get('guestbook')->row()->count;
	}
	
	public function add($body, $from, $to) {
		$post = new stdClass();
		$post->message = $body;
		$post->fromuserid = $from;
		$post->touserid = $to;
		$post->unread = 1;
		$post->date = $this->util->mysql_date();
		
		$this->db->insert('guestbook', $post);
		
		return $this->db->insert_id();
	}
}