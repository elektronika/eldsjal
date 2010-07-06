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

class Migrations extends MY_Controller {
	protected $migration_dir;
	
	public function __construct() {
		parent::__construct();
		$this->migration_dir = APPPATH.'migrations/';
	}
	
	public function get_index() {
		
	}
	
	public function get_schema() {
		$this->redirect = TRUE;
		$current_schema = $this->current_schema();
		$schema = array();

		$changeset = $this->diff(array(), $current_schema);

		$json = json_encode($changeset);
		print_r(json_decode($json));
	}
	
	public function get_create() {
		$changeset = $this->diff($this->migrations_result(), $this->current_schema());
		if( ! empty($changeset))
			$this->save_changeset($changeset);
		$this->redirect = TRUE;
		print_r($changeset);
	}
	
	public function get_commit() {
		$changeset = $this->diff($this->current_schema(), $this->migrations_result());
		$this->commit_changeset($changeset);
		$this->view->template = 'layout';
		$this->show_profiler = TRUE;
	}
	
	protected function current_schema() {
		$schema = array();
		foreach($this->db->list_tables() as $table)
			foreach($this->db->query("SHOW COLUMNS FROM {$table}")->result_array() as $field => $data)
				$schema[$table][$data['Field']] = $data;
		return $schema;
	}
	
	protected function migrations_result() {
		$schema = array();
		foreach($this->list_changesets() as $changeset)
			$schema = $this->apply_changes($schema, $this->load_changeset($changeset));
		return $schema;
	}
	
	protected function diff(Array $old_schema, Array $new_schema) {
		$changeset = array();
		
		$tables_to_delete = array_diff(array_keys($old_schema), array_keys($new_schema));
		if( ! empty($tables_to_delete))
			$changeset['tables']['delete'] = $tables_to_delete;
		
		$tables_to_add = array_diff(array_keys($new_schema), array_keys($old_schema));
		if( ! empty($tables_to_add))
			$changeset['tables']['add'] = $tables_to_add;
		
		$tables = array_keys($new_schema);
		foreach($tables as $table) {
			if(isset($old_schema[$table])) {
				$fields_to_delete = array_diff(array_keys($old_schema[$table]), array_keys($new_schema[$table]));
				if( ! empty($fields_to_delete))
					$changeset['fields']['delete'][$table] = $fields_to_delete;
			}
			
			if(isset($old_schema[$table]))
				$fields_to_add = array_diff(array_keys($new_schema[$table]), array_keys($old_schema[$table]));
			else
				$fields_to_add = array_keys($new_schema[$table]);
			
			if( ! empty($fields_to_add))
				foreach($fields_to_add as $field)
					$changeset['fields']['add'][$table][$field] = $new_schema[$table][$field];
		}
		
		return $changeset;
	}
	
	protected function apply_changes(Array $schema, Array $changeset) {
		// Tables first
		if(isset($changeset['tables']['add']))
			foreach($changeset['tables']['add'] as $table)
				if( ! isset($schema[$table]))
					$schema[$table] = array();
		
		if(isset($changeset['tables']['delete']))
			foreach($changeset['tables']['delete'] as $table)
				if(isset($schema[$table]))
					unset($schema[$table]);
					
		// if(isset($changeset['tables']['modify']))
		// 	foreach($changeset['tables']['modify'] as $old_table => $new_table)
		// 		if(isset($schema[$table])) {
		// 			$schema[$new_table] = $old_table;
		// 			unset($schema['old_table'])
		// 		}
			
		// Then fields
		if(isset($changeset['fields']['add']))
			foreach($changeset['fields']['add'] as $table => $fields)
				foreach($fields as $field => $data)
					if( ! isset($schema[$table][$field]) && empty($schema[$table][$field]))
						$schema[$table][$field] = $data;
		
		if(isset($changeset['fields']['delete']))
			foreach($changeset['fields']['delete'] as $table => $fields)
				foreach($fields as $field)
					if(isset($schema[$table][$field]))
						unset($schema[$table][$field]);
					
		// if(isset($changeset['fields']['modify']))
		// 	foreach($changeset['fields']['modify'] as $old_table => $new_table)
		// 		if(isset($schema[$table])) {
		// 			$schema[$new_table] = $old_table;
		// 			unset($schema['old_table'])
		// 		}
		
		return $schema;
	}
	
	protected function list_changesets() {
		$files = scandir($this->migration_dir);
		foreach($files as $id => $file)
			if(substr($file, 0, 1) == '.')
				unset($files[$id]);
		return $files;
	}
	
	protected function save_changeset(Array $changeset, $name = '') {
		file_put_contents($this->migration_dir.date('Y-m-d_His').$name, serialize($changeset));
	}
	
	protected function load_changeset($name) {
		return unserialize(file_get_contents($this->migration_dir.$name));
	}
	
	protected function commit_changeset(Array $changeset) {
		$this->load->dbforge();
		
		foreach($changeset['tables']['add'] as $table) {
			$fields = $this->field_data($changeset['fields']['add'][$table]);
			$this->dbforge->add_field($fields);
			foreach($fields as $field => $definition)
				if(isset($definition['auto_increment']))
					$this->dbforge->add_key($field, TRUE);

			$this->dbforge->create_table($table);
			unset($changeset['fields'][$table]);
		}
		
		foreach($changeset['tables']['delete'] as $table)
			$this->dbforge->drop_table($table);
		
		foreach($changeset['fields']['add'] as $table)
			$this->dbforge->add_column($table, $this->field_data($table));
			
		if(isset($changeset['fields']['delete']))
			foreach($changeset['fields']['delete'] as $table)
				foreach($table as $field)
					$this->dbforge->drop_column($table, $field);
	}
	
	protected function field_data(Array $table) {
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