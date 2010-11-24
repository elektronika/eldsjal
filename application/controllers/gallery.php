<?php
class Gallery extends MY_Controller {		
	public function _remap($method) {
		$arguments = array_slice($this->uri->segment_array(), 2);
		if(method_exists($this, $method))
			call_user_func_array(array($this, $method), $arguments);
		else
			$this->get_index();
	}
	
	public function get_index() {
		$this->load->library('pagination');
		$images_per_page = $this->settings->get('images_per_page');
		$cur_page = $this->arguments->get('page', 0);
		
		// Taggar
		if($tagArgs = $this->arguments->getArray('tags')) {
			$tags = $this->models->tag->get_by_slugs($tagArgs);
			foreach($tags as $tag) {
				$tag_ids[] = $tag->artid;
				$tag_names[] = $tag->artname;
				$tag_slugs[] = $tag->slug;
			}
		}
		
		// Hämta bilderna från databasen
		$this->db->select('images.*')->where('private', 0)->order_by('imageuploaddate DESC');
		if(isset($tags))
			$this->_tags_filter($this->db, $tag_ids);
		if($user = $this->arguments->get('user'))
			$this->_user_filter($this->db, $user);
		$this->view->images = $this->db->get('images', $images_per_page, $cur_page)->result();
		
		$this->view->tagcloud_prefix = '/gallery/tags:';
		$this->view->page_title = 'Bilder';
		
		// Taggmolnet
		if(isset($tags)) {
			$this->view->page_title = 'Bilder ('.implode(', ', $tag_names).')';
			$tagcloud_prefix = '/gallery/tags:'.implode(':', $tag_slugs).':';
			
			$tag_joins = '';
			foreach ($tags as $x => $tag)
		    	$tag_joins .= " JOIN imageartlist ia_{$x} ON ial.imageid = ia_{$x}.imageid AND ia_{$x}.artid = '{$tag->artid}'";
			unset($tag);

			$whereors = "ial.artid = '".implode("' OR ial.artid = '", $tag_ids)."'";			
			$tagcloud = $this->db->query("SELECT DISTINCT ial.artid AS tid, al.artname AS tag, slug, COUNT(DISTINCT ial.imageid) AS size FROM imageartlist AS ial JOIN artlist AS al ON ial.artid = al.artid {$tag_joins} WHERE NOT ($whereors) GROUP BY al.artid ORDER BY size DESC")->result();
		} else {
			$tagcloud_prefix = '/gallery/tags:';
			$tagcloud = $this->db->query('SELECT artname AS tag, COUNT( * ) AS size, slug FROM `imageartlist` JOIN artlist ON imageartlist.artid = artlist.artid GROUP BY artname ORDER BY size DESC')->result();
		}
		
		// "Avtaggningslänkarna"
		if(isset($tags)) {
			foreach($tags as $key => &$tag) {
				$tags_tmp = $tag_slugs;
				unset($tags_tmp[$key]);
				if(count($tags_tmp) > 0)
					$tag->href = 'tags:'.implode(':', $tags_tmp);
				else
					$tag->href = '';
			}
			unset($tag);
			
			$this->view->tags = $tags;
		}
		
		// Siduppdelning
		$this->db->where('private', 0);
		if(isset($tags))
			$this->_tags_filter($this->db, $tag_ids);
		if($user = $this->arguments->get('user'))
			$this->_user_filter($this->db, $user);
		$number_of_images = $this->db->get('images')->num_rows;
		
		$pagination_tags = isset($tags) ? 'tags:'.implode(':', $tag_slugs).'/' : '';
		$this->pagination->initialize(array(
			'base_url' => '/gallery/'.$pagination_tags.'page:',
			'per_page' => $images_per_page,
			'total_rows' => $number_of_images,
			'cur_page' => $cur_page
		));		
		$this->view->pager = $this->pagination->create_links();
		$this->view->template = 'gallery_index';
		$this->view->tagcloud_prefix = $tagcloud_prefix;
		$this->view->tagcloud = $tagcloud;		
		$this->view->sublinks[] = array('href' => '/gallery/upload', 'title' => 'Ladda upp bild');
		$this->view->sublinks[] = array('href' => '/gallery/random', 'title' => 'Slumpa bild!');
	
		$this->util->trail('spanar på lite schyssta bilder');
	}
	
	// Borde egentligen ligga i image-modellen
	protected function _tags_filter(&$db, $tag_ids) {
		$db->select('COUNT(artid) AS matches')
			->join('imageartlist', 'images.imageid = imageartlist.imageid')
			->where_in('imageartlist.artid', $tag_ids)
			->group_by('imageartlist.imageid')
			->having('matches', count($tag_ids));
	}
	
	// Borde egentligen ligga i image-modellen
	protected function _user_filter(&$db, $user_id) {		
		$db->where('uploadedby', (int) $user_id);
	}
	
	public function get_upload() {
		$this->view->tags = $this->models->tag->get_all();
		$this->util->trail('laddar upp en bild. Yay!');
	}
	
	public function post_upload() {
		$config['upload_path'] = './tmp_upload/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		
		$this->load->library('upload', $config);
		
		$this->form_validation->set_rules('title', 'Rubrik', 'trim|xss_clean|required');
		$this->form_validation->set_rules('body', 'Beskrivning', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Fältet "%s" måste fyllas i hörru.');
				
		if($this->form_validation->run() == FALSE) {
			$this->get_upload();
		} else {
			if( ! $this->upload->do_upload('file', $config)) {
				$this->session->message($this->upload->display_errors(), 'warning');
				$this->get_upload();
			} else {
				$upload_data = $this->upload->data();
				$error = '';

				// Mata in i bautadasen
				$image = (object) $this->input->post_array(array('title', 'body', 'private'));
				$image_id = $this->models->image->save($image);
				
				$this->models->timeline->add($this->session->userId(), 'image', $image_id, $image->title, $image->body, TRUE, NULL, 0, $this->session->userdata('location'));

				// Byt namn på originalfilen
				$original_file = $this->settings->get('original_image_folder').$image_id.$upload_data['file_ext'];
				rename($upload_data['full_path'], $original_file);
				
				$image_size = getimagesize($original_file);
				// 0 = width, 1 = height
				$resize_axis = $image_size[0] > $image_size[1] ? 'height' : 'width';
				$other_axis = $resize_axis == 'height' ? 'width' : 'height';
				
				// Dona thumbnailen
				$config = array(
					'source_image' => $original_file,
					'maintain_ratio' => TRUE,
					'new_image' => $this->settings->get('gallery_folder').'tn_'.$image_id.'.'.$this->settings->get('default_image_extension'),
					$resize_axis => 100,
					$other_axis => 300
				);
				
				$this->load->library('image_lib');
				$this->image_lib->initialize($config);
				if( ! $this->image_lib->resize()) {
					$error .= $this->image_lib->display_errors();
				}
				
				$this->image_lib->clear();
				
				// Dona den storare bilden
				$resize_axis = ($image_size[0] > $image_size[1]) ? 'width' : 'height';
				$other_axis = ($resize_axis == 'height') ? 'width' : 'height';
				$config = array(
					'source_image' => $original_file,
					'maintain_ratio' => TRUE,
					'new_image' => $this->settings->get('gallery_folder').$image_id.'.'.$this->settings->get('default_image_extension'),
					$resize_axis => 1000,
					$other_axis => 999
				);
				$this->image_lib->initialize($config);
				if( ! $this->image_lib->resize()) {
					$error .= $this->image_lib->display_errors();
				}
				
				// Lägg till kategorier
				if($tags = $this->input->post('tag'))
					$this->models->image->set_categories($image_id, array_keys($tags));
				
				if( ! empty($error))
					$this->session->message($error, 'warning');
				$this->session->message('Uppladdat och klart!');
				$this->redirect('/gallery/view/'.$image_id);
			}
		}
	}
	
	public function acl_upload() {
		return $this->session->isLoggedIn();
	}
	
	public function get_view($image_id) {
		$image = $this->models->image->get_by_id((int) $image_id);
		if($image->userid == $this->session->userid() || $this->session->isAdmin())
			$image->actions[] = array('href' => '/gallery/delete/'.$image->id, 'title' => 'Radera', 'class' => 'delete');
		$this->view->sublinks[] = array('href' => '/gallery', 'title' => 'Tillbaka till galleriet');
		$this->view->sublinks[] = array('href' => '/gallery/user/'.$image->userid, 'title' => $image->username.'s andra bilder');
		$this->view->sublinks[] = array('href' => '/gallery/random', 'title' => 'Slumpa bild!');
		$this->view->page_title = $image->title;
		$this->view->image = $image;
		$this->view->prefix = "[b]Kommentar till bilden {$image->title}[/b]: ";
		$this->util->trail('kikar på en bild.');
	}
	
	public function get_random() {
		$this->redirect('/gallery/view/'.$this->models->image->get_random_public_id());
	}
	
	public function acl_view($image_id) {
		return $this->models->image->is_private($image_id) ? $this->session->isLoggedIn() : TRUE;
	}
	
	public function get_edit($image_id) {
		$this->view->image = $this->models->image->get_by_id($image_id);
	}
	
	public function acl_edit($image_id) {
		// Kolla om användaren äger bilden, har lattjo rättigheter, eller är admin. Just nu mest bara admin.
		return $this->session->isAdmin();
	}
	
	public function get_user($user_id) {
		$user = $this->models->user->get_by_id((int) $this->uri->rsegment(3));
		$this->view->images = $this->db
			->where('uploadedby', (int) $user_id)
			->order_by('imageuploaddate', 'DESC')
			->get('images')->result();
		$this->view->sublinks = $this->models->user->sublinks($user->userid, 'gallery');
		$this->view->page_title = $user->username.'s bilder';
		$this->view->template = 'gallery_index';
		$this->util->trail("tittar på {$user->username}s bilder");
	}
	
	public function get_delete($image_id) {
		$this->view->template = 'confirm';
		$this->view->message = 'Är du säker på att du vill ta bort bilden?';
		$this->view->form_action = '/gallery/delete/'.$image_id;
		$this->util->trail('funderar på att ta bort något! :-o');
		$this->view->page_title = 'Radera bild';	
	}
	
	public function post_delete($image_id) {
		$image = $this->models->image->get_by_id((int) $image_id);
		$this->db->delete('images', array('imageid' => $image->id));
		$this->db->delete('imageartlist', array('imageid' => $image->id));
		@unlink($this->settings->get('gallery_folder').$image->id.'.'.$this->settings->get('default_image_extension'));
		@unlink($this->settings->get('gallery_folder').'tn_'.$image->id.'.'.$this->settings->get('default_image_extension'));
		$this->models->timeline->delete($image->id, 'image');
		$this->session->message('Poff botta!');
		$this->redirect('/gallery');
	}
	
	public function acl_delete($image_id) {
		return ($this->session->isAdmin() || $this->models->image->get_by_id((int) $image_id)->userid == $this->session->userid());
	}
}