Migrations - versioning your database schema
============================================

What it does
------------
*	Gives a way to manage changes to your database schema
*	Automatically creates a database table called 'migrations' (configurable) to keep track of the currently installed schema version

What it doesn't
---------------
* 	Create migrations automatically

Methods:
--------
* `install()` - brings the schema to the latest version
* `current()` - returns the current schema version
* `version($number)` - brings the schema to the specified version number
* `max_version()` - returns the number of the latest migration

About migration classes
---------------------
*	Must extend the migration class
*	File must be named (number)_(migration name)
*	Class must be named (migration name)_migration
* 	Can use the `db` and `dbforge` objects as in regular controllers
* 	Must be placed in the application/migrations folder (configurable)

Example migration
-----------------
`APPPATH/migrations/1_init.php`

	<?php 
	class init_migration extends migration {
		public function up() {
			$this->dbforge->add_field('id');
			$this->dbforge->add_field(array(
				'title' => array(
					'type' => 'varchar',
					'constraint' => 50
				),
				'body' => array(
					'type' => 'text'
				)
			));
			$this->dbforge->create_table('posts');
		}
	
		public function down() {
			$this->dbforge->drop_table('posts');
		}
	}

Configuration
-------------
There are two configurable variables, change them by creating a file called `migrations.php` in the `application/config` folder. Here's an example with the default values:

	<?php
	$config["migrations_path"] = APPPATH . "migrations/";
	$config["migrations_meta_table"] = 'migrations';