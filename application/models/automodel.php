<?php
class AutoModel {
	protected $table;
	protected $key = 'id';
	protected $remap = array();
	protected $query = NULL;
	
	public function __construct($table = NULL) {
		if(is_null($table))
			$this->table = strtolower(str_replace('Model', '', get_class($this)));
		else
			$this->table = $table;
		
		$this->query =& $this->db;
	}
	
	public function __get($var) {
		return get_instance()->$var;
	}
	
	// public function __call($method, $arguments) {
	// 	$method_parts = explode('_', $method);
	// 	if(current($method_parts) == 'find') {
	// 		return $this->find_by_field($this->reverse_remap_field(implode('_', array_slice($method_parts, 2))), current($arguments));
	// 		// return $this->util->remapLoop($objects, $this->remap);
	// 	}
	// }
	
	public function find_by_field($field, $value) {
		$this->query = $this->db->where($field, $value);
		return $this;
	}
	
	public function all() {
		return $this->get();
	}
	
	public function one() {
		return $this->prepare($this->query->get($this->table, 1)->row());
	}
	
	public function get($limit = NULL, $offset = 0) {
		return $this->prepare_loop($this->query->get($this->table, $limit, $offset)->result());
	}
	
	public function save(stdClass $object) {
		$key = $this->key;
		$object = $this->util->reverse_remap($object, $this->remap);
		if(isset($object->$key))
			return $this->update($object);
		else
			return $this->create($object);
	}
	
	public function update(stdClass $object) {
		$key = $this->key;
		$this->db->update($this->table, $object, array($key => $object->$key));
		return $object->$key;
	}
	
	public function create(stdClass $object) {
		$this->db->insert($this->table, $object);
		return $this->db->insert_id();
	}
	
	protected function prepare(stdClass $object) {
		return $object;
	}
	
	protected function prepare_loop(Array $objects) {
		foreach($objects as $key => $object)
			$objects[$key] = $this->prepare($object);
		return $objects;
	}
	
	protected function remap_field($field) {
		return (isset($this->remap[$field]) ? $this->remap[$field] : $field);
	}
	
	protected function reverse_remap_field($field) {
		$map = array_flip($this->remap);
		return (isset($map[$field]) ? $map[$field] : $field);
	}
}