<?php
class ImageModel extends AutoModel {
	protected $remap = array();
	
	public function __construct() {
		$this->remap = array(
			'imageName' => 'title',
			'imageDesc' => 'body',
			'imageUploadDate' => 'created',
			'imageId' => 'id'
		);
	}
	
	public function get_all() {
		return $this->db->get('images');
	}
	
	public function save(stdClass $image) {
		$new_image = new stdClass();
		$new_image->imageName = $image->title;
		$new_image->imageDesc = $image->body;
		$new_image->imageUploadDate = date('Y-m-d H:i:s');
		$new_image->filetype = 'jpg';
		$new_image->private = $image->private;
		$new_image->approved = 0;
		$new_image->uploadedBy = isset($image->userid) ? $image->userid : $this->session->userId();
		
		if(isset($image->id)) {
			$this->db->update('images', $new_image, array('imageid' => $image->id));
			$image_id = $image->id;
		} else {
			$this->db->insert('images', $new_image);
			$image_id =  $this->db->insert_id();			
		}
		
		return $image_id;
	}
	
	public function get_by_id($image_id) {
		$image = $this->db
			->select('images.*, users.username, users.userid, users.deleted, users.online')
			->where('imageid', intval($image_id))
			->join('users', 'users.userid = images.uploadedby')
			->get('images')->row();
		$image = $this->util->remap($image, $this->remap);
		return $this->decorate($image);
	}
	
	public function get_random_public_id() {
		return $this->db
			->select('imageid')
			->where('private', '<> 0')
			->order_by('RAND()')
			->get('images')->row()->imageid;	
		}
	
	protected function decorate(stdClass $image) {
		$image->src = $this->settings->get('gallery_url').$image->id.'.'.$this->settings->get('default_image_extension');
		return $image;
	}
	
	public function is_private($image_id) {
		return ($this->db->where('imageId', $image_id)->get('images')->row()->private = 1);
	}
	
	public function set_tags($image_id, Array $tag_ids) {
		$this->db->delete('images_tags', array('image_id' => $image_id));
		foreach($tag_ids as $id) {
			$this->db->insert('images_tags', array('tag_id' => $id, 'image_id' => $image_id));
		}
	}
	
	public function get_tags($image_id) {
		return $this->db
			->select('tags.*')
			->join('images_tags', 'images_tags.tag_id = tags.id')
			->where('image_id', $image_id)
			->get('tags')
			->result();
	}
	
	public function get_tags_assoc($image_id) {
		$out = array();
		foreach($this->get_tags($image_id) as $tag)
			$out[$tag->id] = $tag->title;
		return $out;
	}
	
	public function untag($image_id, $tag_id) {
		$this->db->where(array('image_id' => $image_id, 'tag_id' => $tag_id))->delete('images_tags');
	}
	
	public function add_tags($image_id, Array $tag_ids) {
		foreach($tag_ids as $tag_id)
			$this->add_tag($image_id, $tag_id);
	}
	
	public function add_tag($image_id, $tag_id) {
		$this->db->insert('images_tags', array('image_id' => $image_id, 'tag_id' => $tag_id));
	}
}