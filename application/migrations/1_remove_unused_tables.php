<?php
class remove_unused_tables_migration extends migration {
	public function up() {
		$this->dbforge->drop_table('address');
		$this->dbforge->drop_table('parenthistory');
		$this->dbforge->drop_table('pendingadoption');
		$this->dbforge->drop_table('pendingdelete');
		$this->dbforge->drop_table('log');
	}
	
	public function down() {}
}
?>