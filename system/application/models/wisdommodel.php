<?php
class WisdomModel extends AutoModel {
	public function get_random() {
		return $this->db->query('SELECT wisdom FROM wisebox ORDER BY RAND() LIMIT 1')->row()->wisdom;
	}
}
