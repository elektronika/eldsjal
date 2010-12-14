<?php
class Migrations extends Library {
	protected $migration_dir;

	public function __construct() {
		$this->migration_dir = APPPATH.'migrations/';
	}
	
	public function install() {
		$changeset = $this->diff($this->current_schema(), $this->migrations->migrations_result());
		$this->commit_changeset($changeset);
	}
	
	public function current_schema() {
		$schema = array();
		foreach($this->db->list_tables() as $table)
			foreach($this->db->query("SHOW COLUMNS FROM {$table}")->result_array() as $field => $data)
				$schema[$table][$data['Field']] = $data;
		return $schema;
	}
	
	public function migrations_result() {
		$schema = array();
		foreach($this->list_changesets() as $changeset)
			$schema = $this->apply_changes($schema, $this->load_changeset($changeset));
		return $schema;
	}
	
	public function diff(Array $old_schema, Array $new_schema) {
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
	
	public function apply_changes(Array $schema, Array $changeset) {
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
	
	public function list_changesets() {
		$files = scandir($this->migration_dir);
		foreach($files as $id => $file)
			if(substr($file, 0, 1) == '.')
				unset($files[$id]);
		return $files;
	}
	
	public function save_changeset(Array $changeset, $name = '') {
		file_put_contents($this->migration_dir.date('Y-m-d_His').$name, serialize($changeset));
	}
	
	public function load_changeset($name) {
		return unserialize(file_get_contents($this->migration_dir.$name));
	}
	
	public function commit_changeset(Array $changeset) {
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
	
	public function field_data(Array $table) {
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