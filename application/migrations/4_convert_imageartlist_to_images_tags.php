<?php
class convert_imageartlist_to_images_tags_migration extends migration {
	public function up() {
		$this->dbforge->add_field('id');
		$this->dbforge->add_field(array(
			'image_id' => array(
				'type' => 'int'
			),
			'tag_id' => array(
				'type' => 'int'
			)
		));
		$this->dbforge->add_key('image_id');
		$this->dbforge->add_key('tag_id');
		$this->dbforge->create_table('images_tags');
		
		// Ta reda på tagg-id'n
		$old_tags = $this->db->get('artlist')->result();
		$new_tags = $this->db->get('tags')->result();
		$new_tags_map = array();
		$tag_map = array();

		foreach($new_tags as $tag)
			$new_tags_map[$tag->title] = $tag->id;

		foreach($old_tags as $tag)
			$tag_map[$tag->artId] = $new_tags_map[$tag->artName];
			
		// Konvertera image-tag-länkningarna
		$old_image_tags = $this->db->get('imageartlist')->result();
		foreach($old_image_tags as $image_tag)
			$this->db->insert('images_tags', array('tag_id' => $tag_map[$image_tag->artId], 'image_id' => $image_tag->imageId));
	}
	
	public function down() {
		$this->dbforge->drop_table('images_tags');
	}
}