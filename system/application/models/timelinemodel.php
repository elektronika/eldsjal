<?php
class TimelineModel extends AutoModel {
	public function get(Array $categories, $only_new = FALSE, $limit = 20, $offset = 0) {
		$categories[] = 0;
		$items = $this->db
			->select('t.*, t.id AS href')
			->from('timeline AS t');
			// ->join('users AS u', 't.user_id = u.userid');
			// ->join('acl AS default_acl', 't.category_id = default_acl.category_id AND default_acl.user_id = 0', 'left')
			// ->join('acl AS user_acl', "t.category_id = user_acl.category_id AND user_acl.user_id = {$user_id}", 'left')
			// ->where('GREATEST(IFNULL(user_acl.read, 0), IFNULL(default_acl.read, 0)) >', 0)
			$items->distinct()->order_by('id', 'desc')->where_in('t.category_id', $categories);
		if($only_new)
			$items->where('new', 1);
		return $items->get('timeline', $limit, $offset)->result();
	}
	
	public function add($user_id, $type, $item_id, $title, $body, $new = TRUE, $created = NULL, $category = 0) {
		$this->db->delete('timeline', array('item_id' => $item_id, 'type' => $type));
		$this->db->insert('timeline', array(
			'user_id' => $user_id,
			'type' => $type,
			'item_id' => $item_id,
			'title' => $title,
			'body' => $body,
			'created' => is_null($created) ? time() : $created,
			'category_id' => $category,
			'new' => (int) $new
		));
		return $this->db->insert_id();
	}
}