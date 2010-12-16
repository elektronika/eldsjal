<?php
class Migrations {
	protected $ci;
	protected $meta_table;
	protected $migrations_path;
	protected $current_version = NULL;
	protected $versions = NULL;
	
	public function __construct() {
		$this->ci = get_instance();
		$this->ci->config->load('migrations');
		$this->meta_table = $this->ci->config->item('migrations_meta_table');
		$this->migrations_path = $this->ci->config->item('migrations_path');
		$this->ci->load->dbforge();
		$this->setup_meta_table();
	}
	
	public function install() {
		$this->version($this->max_version());
	}
	
	public function version($target) {
		if($target > $this->current()) {
			foreach(range($this->current() + 1, $target) as $version)
				$this->get_migration($version)->up();
		} elseif($target < $this->current()) {
			foreach(range($this->current(), $target + 1) as $version)
				$this->get_migration($version)->down();
		}
		
		if($target != $this->current())
			$this->set_version($target);
	}
	
	public function current() {
		if(is_null($this->current_version))
			$this->current_version = $this->ci->db->get($this->meta_table)->row()->version;
		return $this->current_version;
	}
	
	public function max_version() {
		return max(array_keys($this->get_migrations()));
	}
	
	protected function set_version($version) {
		$this->ci->db->update($this->meta_table, array('version' => $version));
		$this->current_version = $version;
	}
	
	protected function setup_meta_table() {
		if( ! $this->ci->db->table_exists($this->meta_table)) {
			$this->ci->dbforge->add_field(array('version' => array('type' => 'INT', 'constraint' => 9)));
			$this->ci->dbforge->create_table($this->meta_table, TRUE);
			$this->ci->db->insert($this->meta_table, array('version' => 0));
		}
	}
	
	protected function get_migration($version) {
		$file_name = $this->versions[$version];
		$class_name = preg_replace('/\d_|\.php/', '', basename($this->versions[$version])).'_migration';
		require($file_name);
		return new $class_name($this->ci);
	}
	
	protected function get_migrations() {
		if(is_null($this->versions)) {
			$this->versions = array();
			$files = glob($this->migrations_path.'*.php');
			foreach($files as $number => $file)
				if($number = preg_replace('/\D/', '', basename($file)))
					$this->versions[$number] = $file;
		}
		return $this->versions;
	}
}

abstract class Migration {
	protected $db;
	protected $dbforge;
	
	public function __construct($ci) {
		$this->db = $ci->db;
		$this->dbforge = $ci->dbforge;
	}
	
	abstract public function up();
	abstract public function down();
}