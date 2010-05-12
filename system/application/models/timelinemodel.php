<?php
class TimelineModel extends AutoModel {
	public function get($user_id, $limit = 20, $offset = 0) {
		return $this->db
			->select('u.username, u.userid, t.*')
			->from('timeline AS t')
			->join('users AS u', 't.user_id = u.userid')
			->join('acl AS default_acl', 't.category_id = default_acl.category_id AND default_acl.user_id = 0', 'left')
			->join('acl AS user_acl', "t.category_id = user_acl.category_id AND user_acl.user_id = {$user_id}", 'left')
			->where('GREATEST(IFNULL(user_acl.read, 0), IFNULL(default_acl.read, 0)) >', 0)
			->get('timeline', $limit, $offset)->result();
	}
	
	public function add($user_id, $type, $item_id, $title, $body, $created = NULL, $category = 0) {
		$this->db->delete('timeline', array('item_id' => $item_id, 'type' => $type));
		$this->db->insert('timeline', array(
			'user_id' => $user_id,
			'type' => $type,
			'item_id' => $item_id,
			'title' => $title,
			'body' => $body,
			'created' => is_null($created) ? time() : $created,
			'category_id' => $category
		));
		return $this->db->insert_id();
	}
}