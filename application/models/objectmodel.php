<?php
class ObjectModel extends AutoModel {	
	public function prepare(stdClass $object) {
		return $object;
	}
	
	public function by_id($id) {
		$this->query->where('id', $id);
		return $this;
	}
}