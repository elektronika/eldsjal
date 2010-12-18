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
}