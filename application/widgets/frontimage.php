<?php
class Frontimage extends Widget {
	public function run() {
		$this->image = $this->db->query("SELECT imageid,filetype, imagename, width, height FROM images WHERE private = 0 AND approved = 1 ORDER BY RAND() LIMIT 1")->row();
	}
}