<?php

class User extends Controller {	
	public function __construct() {
		parent::Controller();
		$this->load->model('user_model');
		$this->load->model('location');
		// $this->output->enable_profiler(TRUE);
	}
	
	function get_view($user_slug) {
		$user = $this->user_model->get_by_slug($user_slug);
		$user->does = $this->user_model->artList($user->userid);
		$this->dwootemplate->assign('user', $user);
		$this->dwootemplate->display('user_view.tpl');
	}
	
	function acl_view($user_slug) {
		if( ! $this->user->isLoggedIn()) {
			$user_id = $this->user_model->user_id_for_slug($user_slug);
			return $this->user_model->allow_anonymous_viewers($user_id);
		} else
			return TRUE;
	}
	
	function get_edit($user_slug) {
		$user = $this->user_model->get_by_slug($user_slug);
		$locations = $this->location->get_all_assoc();
		
		$this->dwootemplate->assign('user', $user);
		$this->dwootemplate->assign('locations', $locations);
		$this->dwootemplate->display('user_edit.tpl');
	}
	
	function post_edit($user_slug) {
		// Spara profil-datan
	}
	
	function acl_edit($user_slug) {
		return ($this->user->isAdmin() || $this->user_model->user_id_for_slug($user_slug) == $this->user->userId());
	}
	
	function get_admin($user_slug) {
		$user = $this->user_model->get_by_slug($user_slug);
		$fields = $this->user_model->get_restricted_fields();
		
		$this->dwootemplate->assign('fields', $fields);
		$this->dwootemplate->assign('user', $user);
		$this->dwootemplate->assign('user_array', (array) $user);
		$this->dwootemplate->display('user_admin.tpl');
	}
	
	function post_admin($user_slug) {
		// Spara lattjo-lajban-datan
	}
	
	function acl_admin($user_slug) {
		return $this->user->isAdmin();
	}
	
	function get_password($user_slug) {
		$user = $this->user_model->get_by_slug($user_slug);

		$this->dwootemplate->assign('user', $user);
		$this->dwootemplate->display('user_password.tpl');
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
			$user_id = $this->user_model->user_id_for_slug($user_slug);
			$this->user_model->set_password($user_id, $this->input->post('new'));
			$this->user->message('Nuså, nytt lösenord för hela slanten!');
			
			$this->load->helper('url');
			redirect('/user/'.$user_slug);
		}
	}
	
	function acl_password($user_slug) {
		return ($this->user_model->user_id_for_slug($user_slug) == $this->user->userId());
	}
	
	function password_check($password) {
		return $this->user->checkPassword($password);
	}
	
	function get_image($user_slug) {
		$user = $this->user_model->get_by_slug($user_slug);
		
		$this->dwootemplate->assign('user', $user);
		$this->dwootemplate->display('user_image.tpl');
	}
	
	function post_image($user_slug) {
		$user = $this->user_model->get_by_slug($user_slug);
		$this->load->helper('url');
		
		$config['upload_path'] = './tmp_upload/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		
		$this->load->library('upload', $config);
		$this->load->library('image_lib');
		
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
				redirect('/user/'.$user_slug.'/image');
			} else {
				$this->user->message('Ny bild, fränt!');
				redirect('/user/'.$user_slug);				
			}
		}
	}
	
	function acl_image($user_slug) {
		return ($this->user->isAdmin() || $this->user_model->user_id_for_slug($user_slug) == $this->user->userId());
	}
}