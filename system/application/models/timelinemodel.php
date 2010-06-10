<?php
class TimelineModel extends AutoModel {
	public function __construct() {
		parent::__construct();
		$this->query->distinct()->order_by('id', 'desc');
	}
	
	public function prepare(stdClass $object) {
		switch($object->type) {
			case 'forum_new':
			case 'event_new':
			case 'wiki_new':
				$object->href = '/forum/topic/'.$object->item_id;
				break;
			case 'forum_reply':
			case 'event_reply':
			case 'wiki_reply':
				$object->href = '/forum/redirecttopost/'.$object->item_id;
				break;
			case 'thought':
				$object->href = '/thoughts/view/'.$object->item_id;
				break;
			case 'image':
				$object->href = '/gallery/view/'.$object->item_id;
				break;
			case 'user':
				$object->href = '/user/'.$object->item_id;
				break;
			default:
				$object->href = '/object/view'.$object->item_id;
		}
		return $object;
	}
	
	public function by_categories(Array $categories) {
		$categories[] = 0;
		$this->query->where_in('category_id', $categories);
		return $this;
	}
	
	public function by_users(Array $user_ids) {
		$this->query->where_in('user_id', $user_ids);
		return $this;
	}
	
	public function by_location($location_id) {
		$this->query->where('location', $location_id);
		return $this;
	}
	
	public function only_new() {
		$this->query->where('new', 1);
		return $this;
	}
	
	public function add($user_id, $type, $item_id, $title, $body, $new = TRUE, $created = NULL, $category = 0, $location = NULL) {
		$this->db->delete('timeline', array('item_id' => $item_id, 'type' => $type));
		$this->db->insert('timeline', array(
			'user_id' => $user_id,
			'type' => $type,
			'item_id' => $item_id,
			'title' => $title,
			'body' => $body,
			'created' => is_null($created) ? time() : $created,
			'category_id' => $category,
			'location' => $location,
			'new' => (int) $new
		));
		return $this->db->insert_id();
	}
	
	public function delete($item_id, $type) {
		$this->db->delete('timeline', array('item_id' => $item_id, 'type' => $type));
	}
}