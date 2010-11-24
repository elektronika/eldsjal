<?php
class WisdomModel extends AutoModel {
	public function get_random() {
		return $this->db->query('SELECT wisdom AS body, wiseboxid AS id FROM wisebox ORDER BY RAND() LIMIT 1')->row();
	}
	
	public function get_all() {
		return $this->db
			->select('wisdom AS body, userid, username, wiseboxid AS id, UNIX_TIMESTAMP(addeddate) AS created')
			->join('users', 'wisebox.addedbyid = users.userid')
			->get('wisebox')->result();
	}
	
	public function get_by_id($wisdom_id) {
		return $this->db
			->select('wisdom AS body, userid, username, wiseboxid AS id, UNIX_TIMESTAMP(addeddate) AS created')
			->join('users', 'wisebox.addedbyid = users.userid')
			->where('wiseboxid', (int) $wisdom_id)
			->get('wisebox')->row();
		}
}
