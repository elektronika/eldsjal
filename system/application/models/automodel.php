<?php
if ( ! class_exists('Model')) {
	load_class('Model', FALSE);
}

class AutoModel extends Model {
	protected $table;
	protected $key = 'id';
	protected $remap = array();
	protected $query = NULL;
	
	public function __construct($table = NULL) {
		parent::Model();
		if(is_null($table))
			$this->table = strtolower(str_replace('Model', '', get_class($this)));
		else
			$this->table = $table;
	}
	
	public function __call($method, $arguments) {
		$method_parts = explode('_', $method);
		if(current($method_parts) == 'find') {
			return $this->find_by_field($this->reverse_remap_field(implode('_', array_slice($method_parts, 2))), current($arguments));
			// return $this->util->remapLoop($objects, $this->remap);
		}
	}
	
	public function find_by_field($field, $value) {
		$this->query = $this->db->where($field, $value);
		return $this;
	}
	
	public function all() {
		return $this->util->remapLoop($this->query->get($this->table)->result(), $this->remap);
	}
	
	public function one() {
		return $this->util->remap($this->query->get($this->table, 1)->row(), $this->remap);
	}
	
	public function save($object) {
		$key = $this->key;
		$object = $this->util->reverse_remap($object, $this->remap);
		if(isset($object->$key))
			$this->update($object);
		else
			$this->create($object);
	}
	
	public function update($object) {
		$key = $this->key;
		$this->db->update($this->table, $object, array($key => $object->$key));
	}
	
	public function create($object) {
		$this->db->insert($this->table, $object);
		return $this->db->insert_id();
	}
	
	protected function remap_field($field) {
		return (isset($this->remap[$field]) ? $this->remap[$field] : $field);
	}
	
	protected function reverse_remap_field($field) {
		$map = array_flip($this->remap);
		return (isset($map[$field]) ? $map[$field] : $field);
	}
}