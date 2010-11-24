<?php
class Revision extends Widget {
	public function run() {
		if(file_exists('revision')) {
			$this->revision_date = date('d/m/y, H:i', filemtime('revision'));
			$this->revision_name = 'rev. '.file_get_contents('revision');
		} else {
			$this->revision_date = 'DEV';
			$this->revision_name = 'DEV';
		}
	}
}