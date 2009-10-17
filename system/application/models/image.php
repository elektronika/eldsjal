<?php
class Image extends Model {
	protected $remap = array();
	
	public function __construct() {
		parent::Model();
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
		$new_image->uploadedBy = isset($image->userid) ? $image->userid : $this->user->userId();
		
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
			->select('images.*, users.username, users.userid')
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
		$image->src = $this->util->setting('gallery_url').$image->id.'.'.$this->util->setting('default_image_extension');
		return $image;
	}
	
	public function is_private($image_id) {
		return ($this->db->where('imageId', $image_id)->get('images')->row()->private = 1);
	}
	
	public function set_categories($image_id, Array $category_ids) {
		$this->db->delete('imageartlist', array('imageid' => $image_id));
		foreach($category_ids as $id) {
			$this->db->insert('imageartlist', array('artid' => $id, 'imageid' => $image_id));
		}
	}
}