<?php
class Admin extends MY_Controller {
	protected $show_in_maintenance_mode = TRUE;
	
	public function get_settings() {
		$this->view->items = $this->settings->get_all();
		$this->view->page_title = 'Inställningar';
		$this->view->template = 'inputgrid';
		$this->view->form_action = '/admin/settings';
	}
	
	public function post_settings() {
		$this->settings->delete_all();
		foreach($_POST['items'] as $setting)
			if( ! empty($setting['key'])) {
				$this->settings->set($setting['key'], $setting['value'], $setting['user_id']);
				if($setting['user_id'] != 0)
					$this->alerts->add('flush', $setting['user_id']);
			}
		$this->alerts->add('flush');
		$this->session->message('Jaru, nu är inställningarna ändrade med.');
		$this->redirect('/admin/settings');
	}
	
	public function acl_settings() {
		return $this->session->isAdmin();
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
	
	public function acl_board() {
		return $this->session->isAdmin();
	}
	
	public function get_wisdom($wisdom_id = NULL) {
		if( ! is_null($wisdom_id))
			$wisdom = $this->models->wisdom->get_by_id((int) $wisdom_id);
		else
			$wisdom = (object) array('body' => '');
		$this->view->template = 'list';
		$this->view->items = $this->models->wisdom->get_all();
		$this->view->item_function = 'wisdom_item';
		$this->view->page_title = 'Vishetsadmin';
		$this->view->before = form_open('/admin/wisdom/'.$wisdom_id).textarea('body', 'Vishet', rqForm($wisdom->body)).submit('Spara vishet').form_close();
		$this->view->sublinks[] = array('href' => '/admin/wisdom', 'title' => 'Ny vishet');
	}
	
	public function post_wisdom($wisdom_id = NULL) {
		if(is_null($wisdom_id)) {
			if($this->input->post('body') != '') {
				$this->db->insert('wisebox', array('wisdom' => $this->input->post('body'), 'addedbyid' => $this->session->userid(), 'addeddate' => $this->util->mysql_date()));
				$this->session->message('Vishet sparad!');
			}
		} else {
			if($this->input->post('body') != '') {
				$this->db->update('wisebox', array('wisdom' => $this->input->post('body'), 'addedbyid' => $this->session->userid(), 'addeddate' => $this->util->mysql_date()), array('wiseboxid' => (int) $wisdom_id));
				$this->session->message('Vishet uppdaterad!');
			} else {
				$this->db->delete('wisebox', array('wiseboxid' => (int) $wisdom_id));
				$this->session->message('Vishet raderad!');
			}
		}
		$this->redirect('/admin/wisdom');		
	}
	
	public function acl_wisdom() {
		return $this->acl->check($this->settings->get('wisdom_category'));
	}
	
	public function get_flush() {
		$this->alerts->add('flush', $this->session->userId());
		$this->redirect('/main');
	}
	
	public function get_massmail() {
		$this->view->page_title = 'Massmail';
		$this->view->from_email = $this->settings->get('email_from');
		$this->view->from_name = $this->settings->get('email_from_name');
	}
	
	public function post_massmail() {
		die('Näe, vi väntar nog lite med den här funktionen');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Ämne', 'trim|required|xss_clean');
		$this->form_validation->set_rules('from_email', 'Från', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('from_name', 'Från', 'trim|required|xss_clean');
		$this->form_validation->set_rules('body', 'Meddelande', 'trim|required|xss_clean');
		
		$this->form_validation->set_message('required', 'Måste fyllas i. Jättemåste.');
		$this->form_validation->set_message('valid_email', 'Sorry, det måste vara en riktig adress.');
		
		if( ! $this->form_validation->run() === TRUE) {
			$this->get_massmail();
		} else {
			$this->load->library('email');
			$this->email->initialize(array('bcc_batch_mode' => TRUE));
			$emails = array();
			$success_count = 0;
			$fail_count = 0;
			
			if( ! $this->input->post('broadcast')) {
				$emails[] = $this->models->user->get_by_id($this->session->userId())->email;
			} else {				
				// Hämta alla adresser
				$users = $this->db->select('email')->where('newsletter', 1)->get('users')->result();
				
				// Validera adresser
				foreach($users as $user)
					if($this->form_validation->valid_email(trim($user->email)))
						$emails[] = trim($user->email);
			}

			// And off we go!		    
			$this->email->to($this->input->post('from_email'));
			$this->email->bcc($emails);
			$this->email->from($this->input->post('from_email'), $this->input->post('from_name'));
			$this->email->subject($this->input->post('title'));
			$this->email->message($this->input->post('body'));
			if($this->email->send())
				$success_count++;
			else
				$fail_count++;
			
			$this->session->message('Av '.count($emails).' mail lyckades '.$success_count);
			$this->redirect('/admin/massmail');
		}
	}
	
	public function acl_massmail() {
		return $this->session->isAdmin();
	}
	
	public function get_flushall() {
		$users = $this->db->select('userid')->get('users')->result();
		foreach($users as $user)
			$this->alerts->add('flush', $user->userid);
		$this->session->message(count($users).' användare flushade!');
		$this->redirect('/main');
	}
	
	public function acl_flushall() {
		return $this->session->isAdmin();
	}
	
	public function get_maintenance($state = 'off', $key = NULL) {
		if( ! is_null($key))
			if($key == $this->settings->get('maintenance_key')) {
				if($state == 'on')
					file_put_contents(APPPATH.'maintenance', '');
				else
					unlink(APPPATH.'maintenance');
			}

		$this->view->template = 'maintenance_mode';
	}
	
	public function get_console() {
		$this->view->page_title = 'SQL-konsol';
		$this->view->platform = $this->db->platform();
		$this->view->version = $this->db->version();
		$this->view->query = '';
	}
	
	public function post_console() {
		$this->get_console();
		$query = $this->db->query($this->input->post('query'));
		$this->view->result = $query->result();
		$this->view->num_rows = $query->num_rows();
		$this->view->insert_id = $this->db->insert_id();
		$this->view->affected_rows = $this->db->affected_rows();
		$this->view->query = $this->db->last_query();
	}
	
	public function acl_console() {
		return $this->session->isAdmin();
	}
}
