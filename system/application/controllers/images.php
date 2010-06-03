<?php
class Images extends MY_Controller {
	public function get_user($user_id, $type = 'original') {
		$image_src = $this->settings->get('original_user_image_folder').$user_id.'.'.$this->settings->get('default_image_extension');
		$this->handle_image($image_src, $type, 'users');			
	}
	
	public function get_gallery($image_id, $type = 'original') {
		$image_src = $this->settings->get('original_image_folder').$image_id.'.'.$this->settings->get('default_image_extension');
		$this->handle_image($image_src, $type, 'gallery');
	}
	
	protected function handle_image($src, $type, $folder) {
		if( ! file_exists($src)) {
			show_error('Original image not found');
			die();
		}
		
		$this->load->library('image_lib');
		
		// Sätt variabler oberoende av bildtyp
		$image_size = getimagesize($src);
		// 0 = width, 1 = height
		$wider_than_tall = (bool) $image_size[0] > $image_size[1];
		$extension = $this->settings->get('default_image_extension');
		$filename = pathinfo($src);
		$filename = $filename['filename'];
		
		$config = array(
			'maintain_ratio' => TRUE,
			'source_image' => $src,
			'new_image' => "images/$folder/$filename/$type.$extension"
		);
		
		// Sätt variabler beroende på bildtyp
		switch($type) {
			case 'thumbnail':
				$config['height'] = $wider_than_tall ? 100 : 300;
				$config['width'] = $wider_than_tall ? 300 : 100;
				break;
			case 'large':
				$config['height'] = $wider_than_tall ? 999 : 1000;
				$config['width'] = $wider_than_tall ? 1000 : 999;
				break;
			default:
				$this->redirect($src);
				die();
		}
		
		// Processa
		$this->image_lib->initialize($config);
		$this->image_lib->resize() or die($this->image_lib->display_errors());
		
		// Redirecta
		$this->redirect($config['new_image']);
	}
}