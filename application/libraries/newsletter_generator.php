<?php
class newsletter_generator extends Library {
	public function generate() {
		$user_ids = $this->user_ids();
	}
	
	protected function user_ids() {
		$result = $this->db->query();
	}
}