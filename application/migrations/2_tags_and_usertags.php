<?php
class tags_and_usertags_migration extends migration {
	public function up() {
		// Tags-tabellen
		$this->dbforge->add_field('id');
		$this->dbforge->add_field(array(
			'title' => array(
				'type' => 'varchar',
				'constraint' => 50
			)
		));
		$this->dbforge->add_key('title');
		$this->dbforge->create_table('tags');
		
		// Usertags-tabellen
		$this->dbforge->add_field('id');
		$this->dbforge->add_field(array(
			'user_id' => array(
				'type' => 'int'
			),
			'tag_id' => array(
				'type' => 'int'
			),
			'kind' => array(
				'type' => 'varchar',
				'constraint' => 20
			)
		));
		$this->dbforge->add_key('user_id');
		$this->dbforge->add_key('tag_id');
		$this->dbforge->add_key('kind');
		$this->dbforge->create_table('users_tags');
	}
	
	public function down() {
		$this->dbforge->drop_table('tags');
		$this->dbforge->drop_table('users_tags');
	}
}
?>