<?php
class TagModel extends AutoModel {
	public function get_all() {
		return $this->db->select('artid AS id, artname AS tag, slug')->get('artlist')->result();
	}
	
	public function get_all_assoc() {
		$tags = $this->get_all();
		$out = array();
		foreach($tags as $tag)
			$out[$tag->id] = $tag->tag;
		return $out;
	}
	
	public function get_by_slugs(Array $slugs) {
		return $this->db->select('artid, artname, slug')->where_in('slug', $slugs)->get('artlist')->result();
	}
}