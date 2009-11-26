<?php
class User extends MY_Controller {	
	function get_view($user_slug) {
		$this->user = $this->models->user->get_by_slug($user_slug);
		$this->user->does = $this->models->user->artList($this->user->userid);
	}
	
	function acl_view($user_slug) {
		if( ! $this->session->isLoggedIn()) {
			$user_id = $this->models->user->user_id_for_slug($user_slug);
			return $this->models->user->allow_anonymous_viewers($user_id);
		} else
			return TRUE;
	}
	
	function get_edit($user_slug) {
		$this->user = $this->models->user->get_by_slug($user_slug);
		$this->locations = $this->models->location->get_all_assoc();
	}
	
	function post_edit($user_slug) {
		// Spara profil-datan
	}
	
	function acl_edit($user_slug) {
		return ($this->session->isAdmin() || $this->models->user->user_id_for_slug($user_slug) == $this->session->userId());
	}
	
	function get_admin($user_slug) {
		$this->user = $this->models->user->get_by_slug($user_slug);
		$this->fields = $this->models->user->get_restricted_fields();
		$this->user_array = (array) $user;
	}
	
	function post_admin($user_slug) {
		// Spara lattjo-lajban-datan
	}
	
	function acl_admin($user_slug) {
		return $this->session->isAdmin();
	}
	
	function get_password($user_slug) {
		$this->user = $this->models->user->get_by_slug($user_slug);
	}
	
	function post_password($user_slug) {
		$this->form_validation->set_rules('current', 'Nuvarande lösenord', 'trim|xss_clean|required|callback_password_check');
		$this->form_validation->set_rules('new', 'Nytt lösenord', 'trim|xss_clean|required|min_length[5]');
		$this->form_validation->set_rules('confirm', 'Bekräfta lösenordet', 'trim|xss_clean|required|matches[new]');
		
		$this->form_validation->set_message('required', 'Heddu, fylla i är ett måste!');
		$this->form_validation->set_message('matches', 'Stämmer det inte så blir det inte någon ändring här inte!');
		$this->form_validation->set_message('password_check', 'Mja, du måste kunna ditt gamla lösenord för att få ändra det. Du har ju trots allt loggat in med det...');
		$this->form_validation->set_message('min_length', 'Minst 5 bokstäver måste lösenordet vara, annars går korna inte hem.');

		if($this->form_validation->run() == FALSE) {
			$this->get_password($user_slug);
		} else {
			$user_id = $this->models->user->user_id_for_slug($user_slug);
			$this->models->user->set_password($user_id, $this->input->post('new'));
			$this->user->message('Nuså, nytt lösenord för hela slanten!');
			$this->redirect('/user/'.$user_slug);
		}
	}
	
	function acl_password($user_slug) {
		return ($this->models->user->user_id_for_slug($user_slug) == $this->session->userId());
	}
	
	function password_check($password) {
		return $this->models->user->checkPassword($password);
	}
	
	function get_image($user_slug) {
		$this->user = $this->models->user->get_by_slug($user_slug);
	}
	
	function post_image($user_slug) {
		$this->user = $this->models->user->get_by_slug($user_slug);
		
		$config['upload_path'] = './tmp_upload/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		
		if( ! $this->upload->do_upload('file') ) {
			$this->user->message($this->upload->display_errors(), 'warning');
			redirect('/user/'.$user_slug.'/image');
		} else {
			$upload_data = (object) $this->upload->data();
			$errors = array();
			
			// Byt namn på originalfilen, och lägg den på rätt ställe
			$original_file = $this->util->setting('original_user_image_folder').$user->userid.$upload_data->file_ext;
			if(file_exists($original_file))
				unlink($original_file);
			rename($upload_data->full_path, $original_file);
			
			// Dona thumbnailen
			$config = array(
				'source_image' => $original_file,
				'maintain_ratio' => TRUE,
				'new_image' => $this->util->setting('user_image_folder').'tn_'.$user->userid.'.'.$this->util->setting('default_image_extension'),
				'width' => 100,
				'height' => 100
			);
			$this->image_lib->initialize($config);
			if( ! $this->image_lib->resize()) {
				$errors[] = $this->image_lib->display_errors();
			}
			
			if( ! empty($errors)) {
				foreach($errors as $error)
					$this->user->message($error, 'warning');
				$this->redirect('/user/'.$user_slug.'/image');
			} else {
				$this->models->user->mark_as_having_image($this->user->userid);
				$this->user->message('Ny bild, fränt!');
				$this->redirect('/user/'.$user_slug);				
			}
		}
	}
	
	function acl_image($user_slug) {
		return ($this->session->isAdmin() || $this->models->user->user_id_for_slug($user_slug) == $this->session->userId());
	}
}