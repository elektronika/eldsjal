<?php
class TagModel extends AutoModel {
	public function get_all($for_images = TRUE) {
		if( ! $for_images)
			$this->db->where('image_only !=', 1);
		return $this->db->select('artid AS id, artname AS tag, slug')->get('artlist')->result();
	}
	
	public function get_all_assoc($for_images = TRUE) {
		$tags = $this->get_all($for_images);
		$out = array();
		foreach($tags as $tag)
			$out[$tag->id] = $tag->tag;
		return $out;
	}
	
	public function get_by_slugs(Array $slugs) {
		return $this->db->select('artid, artname, slug')->where_in('slug', $slugs)->get('artlist')->result();
	}
	
	public function get_by_ids(Array $ids) {
		return $this->db->where_in('id', $ids)->get('tags')->result();
	}
	
	public function tags_to_array($tags) {
		return array_filter(array_map('mb_strtolower', array_map('trim', explode(',', $tags))));
	}
	
	public function tag_ids(Array $tag_names, $create_new = FALSE) {
		if(empty($tag_names))
			return array();
			
		$tags = $this->db->where_in('title', $tag_names)->get('tags')->result();
		$tag_ids = array();
		
		foreach($tags as $tag)
			$tag_ids[$tag->title] = $tag->id;
		
		if($create_new) {
			$new_tags = array_diff($tag_names, array_keys($tag_ids));
			foreach($new_tags as $tag)
				$tag_ids[$tag] = $this->create_tag($tag);			
		}
			
		return $tag_ids;
	}
	
	public function create_tag($title) {
		$this->db->insert('tags', array('title' => $title));
		return $this->db->insert_id();
	}
	
	public function search_tags($term, $wildcard = 'both') {
		$matches = $this->db->like('title', $term, $wildcard)->get('tags')->result();
		$out = array();
		foreach($matches as $match)
			$out[] = $match->title;
		return $out;
	}
}