<?php
class Tag extends Model {
	public function __construct() {
		parent::Model();
	}
	
	public function get_all() {
		return $this->db->select('artid AS id, artname AS tag, slug')->get('artlist')->result();
	}
	
	public function get_by_slugs(Array $slugs) {
		return $this->db->select('artid, artname, slug')->where_in('slug', $slugs)->get('artlist')->result();
	}
}