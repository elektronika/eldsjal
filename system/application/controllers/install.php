<?php
class Install extends MY_Controller {
	protected $check_dsn = FALSE; // doh
	
	public function acl_controller() {
		return ! file_exists('system/application/dsn');
	}
	
	public function get_index() {
		
	}
	
	public function post_index() {
		$this->load->library('form_validation');
		
		if($this->form_validation->run() == FALSE) {
			$this->get_index();
		} else {
			// Rulla igång bautadasen
			$this->load->database($this->input->post('dsn'));
			file_put_contents('system/application/dsn', $this->input->post('dsn'));
			$this->migrations->install();
			
			// Fippla till första användaren, som blir admin
			$admin_id = $this->models->user->create($this->input->post('admin_email'));
			$user = new stdClass();
			$user->first_name = $this->input->post('admin_first_name');
			$user->last_name = $this->input->post('admin_last_name');
			$user->usertype = 100;
			$this->db->update('users', $user, array('userid' => $admin_id));
			$this->models->user->set_password($admin_id, $this->input->post('admin_password'));
			
			$this->session->message('Installerat och klart! Let\'s go!);
			$this->redirect('/main');
		}
	}
}