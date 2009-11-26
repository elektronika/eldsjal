<?php
class LocationModel extends AutoModel {
	public function __construct() {
		parent::Model();
	}
	
	public function get_all() {
		return $this->db->select('locationid AS id, locationname AS title')->order_by('sortorder')->get('locations')->result();
	}
	
	public function get_all_assoc() {
		$locations = $this->get_all();
		$out = array();
		foreach($locations as $location) {
			$out[$location->id] = $location->title;
		}
		return $out;
	}
}