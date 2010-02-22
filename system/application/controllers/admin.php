<?php
class Admin extends MY_Controller {
	public function acl_controller() {
		return $this->session->isAdmin();
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
		$threads = $this->db->get('forumtopics', 10000, $offset)->result();
		foreach($threads as $thread)
			$this->models->forum->reindex_thread($thread->topicId);
	}
	
	public function get_whatsup() {}
	
	public function post_whatsup() {		
		$this->form_validation->set_rules('text', 'Just nu', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Något måste ju hända!');
		
		if($this->form_validation->run() == FALSE) {
			$this->template = 'admin_whatsup.tpl';
		} else {
			$this->models->whatsup->set($this->input->post('text'), 0);
			$this->session->message('Fixelidonat!');
			$this->redirect('/admin/whatsup');
		}
	}
	
	public function get_tabledata($table) {
		print '<pre>';
		print_r($this->db->query('SHOW FIELDS FROM '.$table)->result());
		print '</pre>';
	}
	
	public function get_settings() {
		$this->view->items = $this->settings->get_all();
		$this->view->page_title = 'Inställningar';
		$this->view->template = 'inputgrid';
		$this->view->form_action = '/admin/settings';
	}
	
	public function post_settings() {
		$this->settings->delete_all();
		foreach($_POST['items'] as $setting)
			if( ! empty($setting['key']))
				$this->settings->set($setting['key'], $setting['value'], $setting['user_id']);
		$this->session->message('Jaru, nu är inställningarna ändrade med.');
		$this->redirect('/admin/settings');
	}
	
	public function get_board() {
		$this->view->items = $this->db->select('userid, rights, title, sort')->order_by('rights', 'desc')->get('board')->result();
		$this->view->page_title = 'Rättigheter';
		$this->view->template = 'inputgrid';
		$this->view->form_action = '/admin/board';
	}
	
	public function post_board() {
		$this->db->empty_table('board');
		foreach($_POST['items'] as $item)
			if( ! empty($item['rights']))
				$this->db->insert('board', $item);
		$this->session->message('Sweet, rättigheterna uppdaterades!');
		$this->redirect('/admin/board');
	}
	
	public function get_log() {
		$this->view->log = $this->db->order_by('date', 'desc')->get('log');
		$this->view->page_title = 'Logg';
	}
	
	public function post_log() {
		$this->db->empty_table('log');
		$this->session->message('Loggen är rensad! *poff* liksom!');
		$this->redirect('/admin/log');
	}
}
