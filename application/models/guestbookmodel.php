<?php
class GuestbookModel extends AutoModel {
	protected $remap = array();
	
	public function __construct() {
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
	
	public function between_users($user_id_1, $user_id_2, $offset, $limit) {
		$posts = $this->db
			->where("(touserid = {$user_id_1} AND fromuserid = {$user_id_2}) OR (touserid = {$user_id_2} AND fromuserid = {$user_id_1})")
			->join('users', 'users.userid = guestbook.fromuserid')
			->order_by('date DESC')
			->get('guestbook', $limit, $offset)->result();
		return $this->util->remapLoop($posts, $this->remap);
	}
	
	
	public function get_post_by_id($post_id) {
		
	}
	
	public function is_to_user($post_id, $user_id) {
		return $this->db->where(array('guestbookid' => $post_id, 'touserid' => $user_id))->get('guestbook')->num_rows() > 0;
	}
	
	public function is_by_user($post_id, $user_id) {
		return $this->db->where(array('guestbookid' => $post_id, 'fromuserid' => $user_id))->get('guestbook')->num_rows() > 0;
	}
	
	public function count_posts_for_user($user_id) {
		return $this->db->select('COUNT(*) AS count')->where('touserid', $user_id)->get('guestbook')->row()->count;
	}
	
	public function count_posts_between_users($user_id_1, $user_id_2) {
		return $this->db->select('COUNT(*) AS count')->where("(touserid = {$user_id_1} AND fromuserid = {$user_id_2}) OR (touserid = {$user_id_2} AND fromuserid = {$user_id_1})")->get('guestbook')->row()->count;
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
	
	public function delete($post_id) {
		return $this->db->delete('guestbook', array('guestbookId' => (int) $post_id));
	}
	
	public function mark_all_as_read($user_id) {
		return $this->db->update('guestbook', array('unread' => 0), array('unread' => 1, 'touserid' => $user_id));
	}
}