<?php
class added_by_in_images_tags_migration extends migration {
	public function up() {
		$this->dbforge->add_column('images_tags', array(
			'added_by' => array(
				'type' => 'int'
			)
		));
		$this->db->query('CREATE INDEX added_by ON images_tags(added_by)');
	}
	
	public function down() {
		$this->dbforge->drop_column('images_tags', 'added_by');
	}
}