<?php
class convert_userartlist_to_usertags_migration extends migration {
	public function up() {
		// Konvertera taggarna
		$old_tags = $this->db->get('artlist')->result();
		$new_tags = array();
		foreach($old_tags as $tag) {
			$this->db->insert('tags', array('title' => $tag->artName));
			$new_tags[$tag->artId] = $this->db->insert_id();
		}
			
		// Konvertera user-länkningarna
		$old_user_tags = $this->db->get('userartlist')->result();
		foreach($old_user_tags as $user_tag)
			$this->db->insert('users_tags', array('tag_id' => $new_tags[$user_tag->artId], 'user_id' => $user_tag->userId, 'kind' => 'activity'));
	}
	
	public function down() {
		
	}
}