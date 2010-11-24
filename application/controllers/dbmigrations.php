<?php
/*
class Migration {
	protected $changeset = array();
	
	public function __construct() {
		$this->changeset = array('add' => array(), 'delete' => array(), 'modify' => array());
	}
	
	public function add($identifier, $params = array()) {
		$this->changeset['add'][$identifier] = $params;
		return $this;
	}
	
	public function delete($identifier) {
		$this->changeset['delete'][$identifier] = $identifier;
		return $this;
	}
	
	public function modify($identifier, $params) {
		$this->changeset['modify'][$identifier] = $params;
		return $this;
	}
	
	public function toAdd() {
		return $this->changeset['add'];
	}
	
	public function toDelete() {
		return $this->changeset['delete'];
	}
	
	public function toModify() {
		return $this->changeset['modify'];
	}
}

class SchemaMigrator {
	public function migrate(Schema $current, Schema $target) {
		$migration = new Migration();
		
		foreach(array_diff($target->tables(), $current->tables()) as $table)
			$migration->add($table);
		
		foreach(array_diff($current->tables(), $target->tables()) as $table)
			$migration->delete($table);
		
		return $migration;
	}
}

abstract class Schema {
	protected $schema = array();
	protected $indexes = array();
	protected $migrations = array();
	
	abstract public function __construct();
	
	public function tables() {
		return array_keys($this->schema);
	}
	
	public function fields($table) {
		return array_keys($this->schema[$table]);
	}
	
	public function field($table, $field) {
		return $this->schema[$table][$field];
	}
	
	public function indexes($table) {
		return $this->indexes[$table];
	}
	
	public function apply(Migration $migration) {
		$this->migrations[] = $migration;
	}
	
	abstract public function commit();
}

class CodeIgniterSchema extends Schema {
	protected $ci;
	
	public function __construct(&$ci) {
		$this->ci =& $ci;
		$this->ci->load->dbforge();
		// Läs in schemat
	}
	
	public function commit() {
		foreach($this->migrations as $migration) {
			foreach($migration->tablesToAdd() as $table) {
				foreach($this->schema[$table] as $field => $data)
					$this->ci->dbforge->add_field($this->ciFieldData($data));
				$this->ci->dbforge->create_table($table);				
			}
			
			foreach($migration->tablesToDelete() as $table)
				$this->ci->dbforge->drop_table($table);
			
			foreach($migration->fieldsToAdd() as $table => $fields)
				foreach($fields as $field)
					$this->ci->dbforge->add_column($table, $field);
			
			foreach($migration->fieldsToDelete() as $table => $fields)
				foreach($fields as $field)
					$this->ci->dbforge->drop_column($table, $field);
		}
		
		return $this;
	}
	
	protected function ciFieldData(Array $table) {
		$fields = array();
		foreach($table as $field => $data) {
			$field_type = explode('(', $data['Type']);
			$fields[$field]['type'] = current($field_type);
			if(count($field_type) > 1) $fields[$field]['constraint'] = rtrim(next($field_type), ')');
			if($fields[$field]['type'] == 'varchar' || ! empty($data['Default'])) $fields[$field]['default'] = $data['Default'];
			if($data['Null'] == 'YES') $fields[$field]['null'] = TRUE;
			if($data['Extra'] == 'auto_increment') $fields[$field]['auto_increment'] = TRUE;
		}
		return $fields;
	}
}

// Uppdatera databasen
$migrator = new SchemaMigrator();
$current = new MySqlSchema($dsn);
$target = new MigrationDirectorySchema($migration_dir);
$migration = $migrator->migrate($current, $target);
$current->apply($migration)->commit();

// Uppdatera migrations
$migrator = new SchemaMigrator();
$target = new MySqlSchema($dsn);
$current = new MigrationDirectorySchema($migration_dir);
$migration = $migrator->migrate($current, $target);
$current->apply($migration)->commit();
*/

class DbMigrations extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('migrations');
	}
	
	public function acl_controller() {
		return $this->session->isAdmin();
	}
	
	public function get_schema() {
		$this->redirect = TRUE;
		$current_schema = $this->migrations->current_schema();

		$changeset = $this->migrations->diff(array(), $current_schema);

		$json = json_encode($changeset);
		print_r(json_decode($json));
	}
	
	public function get_create() {
		$changeset = $this->migrations->diff($this->migrations->migrations_result(), $this->migrations->current_schema());
		if( ! empty($changeset))
			$this->migrations->save_changeset($changeset);
		$this->redirect = TRUE;
		print_r($changeset);
	}
	
	public function get_commit() {
		$changeset = $this->migrations->diff($this->migrations->current_schema(), $this->migrations->migrations_result());
		$this->migrations->commit_changeset($changeset);
		$this->view->template = 'layout';
		$this->show_profiler = TRUE;
	}
}