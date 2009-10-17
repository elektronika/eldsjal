<?php
class Admin extends Controller {
	public function __construct() {
		parent::Controller();
		$this->output->enable_profiler(TRUE);
	}

	public function acl_controller() {
		return $this->user->isAdmin();
	}
	
	public function get_generate() {
		// Doctrine::generateModelsFromDb(APPPATH . DIRECTORY_SEPARATOR . 'models');
		print 'models generated';
	}
	
	public function get_artslug() {
		$artlist = $this->db->get('artlist')->result();
		foreach($artlist as $art) {
			$slug = $this->util->slugify($art->artName);
			$this->db->query("UPDATE artlist SET slug = '{$slug}' WHERE artid = {$art->artId}");
		}
	}
	
	public function get_userslug() {
		$userlist = $this->db->get('users')->result();
		foreach($userlist as $user) {
			$slug = $this->util->slugify($user->username);
			$this->db->query("UPDATE users SET slug = '{$slug}' WHERE userid = {$user->userId}");
		}
	}
	
	public function get_reindex_all_threads($offset) {
		$this->load->model('forum_model');
		
		$threads = $this->db->get('forumtopics', 10000, $offset)->result();
		foreach($threads as $thread)
			$this->forum_model->reindex_thread($thread->topicId);
	}
	
	public function get_whatsup() {
		$this->dwootemplate->display('admin_whatsup.tpl');
	}
	
	public function post_whatsup() {
		$this->load->model('whatsup');
		
		$this->form_validation->set_rules('text', 'Just nu', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Något måste ju hända!');
		
		if($this->form_validation->run() == FALSE) {
			$this->get_whatsup();
		} else {
			$this->whatsup->set($this->input->post('text'), 0);
			$this->user->message('Fixelidonat!');
			$this->load->helper('url');
			redirect('/admin/whatsup');
		}
	}
	
	public function get_tabledata($table) {
		print '<pre>';
		print_r($this->db->query('SHOW FIELDS FROM '.$table)->result());
		print '</pre>';
	}
}
