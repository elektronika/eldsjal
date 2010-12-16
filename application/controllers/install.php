<?php
class Install extends Controller {
	protected $check_dsn = FALSE; // doh
	public $redirect = TRUE;
	public $show_profiler = FALSE;
	
	public function __construct() {
		parent::Controller();
		$this->output->enable_profiler(TRUE);
	}
	
	public function acl_controller() {
		return ! file_exists('system/application/dsn');
	}
	
	public function get_install() {				
		$this->load->view('install');
	}
	
	public function post_install() {
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('dsn', 'DSN', 'trim|xss_clean|required');
		$this->form_validation->set_rules('admin_email', 'Admin-email', 'trim|xss_clean|required|valid_email');
		$this->form_validation->set_rules('admin_username', 'Admin-användarnamn', 'trim|xss_clean|required');
		$this->form_validation->set_rules('admin_first_name', 'Admin-förnamn', 'trim|xss_clean|required');
		$this->form_validation->set_rules('admin_last_name', 'Admin-efternamn', 'trim|xss_clean|required');
		$this->form_validation->set_rules('admin_password', 'Admin-lösenord', 'trim|xss_clean|required');
		
		$this->form_validation->set_message('required', 'Den där måste vara med serru.');
		
		if($this->form_validation->run() == FALSE) {
			$this->get_install();
		} else {
			// Rulla igång bautadasen
			$this->load->database($this->input->post('dsn'));
			file_put_contents(APPPATH.'dsn', $this->input->post('dsn'));
			
			$this->load->library('migrations');
			$this->migrations->install();
						
			// Fippla till första användaren, som blir admin
			$admin_id = $this->models->user->create($this->input->post('admin_email'));
			$user = new stdClass();
			$user->username = $this->input->post('admin_username');
			$user->first_name = $this->input->post('admin_first_name');
			$user->last_name = $this->input->post('admin_last_name');
			$user->usertype = 100;
			$this->db->update('users', $user, array('userid' => $admin_id));
			$this->models->user->set_password($admin_id, $this->input->post('admin_password'));
			
			$this->session->message('Installerat och klart! Let\'s go!');
			$this->redirect('/main');
		}
	}
}