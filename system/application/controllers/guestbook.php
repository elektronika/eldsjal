<?php
class Guestbook extends Controller {	
	public function __construct() {
		parent::Controller();
		$this->load->model('guestbook_model', 'guestbook');
		$this->load->model('user_model');
		// $this->output->enable_profiler(TRUE);
	}
	
	public function get_view($user_slug) {
		$this->load->library('pagination');
		
		$user = $this->user_model->get_by_slug($user_slug);
		$offset = $this->arguments->get('page', 0);
		$posts_per_page = $this->user->setting('guestbook_posts_per_page');
		$number_of_posts = $this->guestbook->count_posts_for_user($user->userid);
		
		$posts = $this->guestbook->to_user($user->userid, $offset, $posts_per_page);

		$this->pagination->initialize(array(
			'base_url' => '/user/'.$user_slug.'/guestbook/page:',
			'per_page' => $posts_per_page,
			'total_rows' => $number_of_posts,
			'cur_page' => $offset
		));
		$pager = $this->pagination->create_links();
		
		$this->dwootemplate->assign('pager', $pager);		
		$this->dwootemplate->assign('user', $user);		
		$this->dwootemplate->assign('posts', $posts);
		$this->dwootemplate->display('guestbook_view.tpl');
	}
	
	public function get_edit($post_id) {
		$post = $this->guestbook->get_post_by_id($post_id);
		$this->dwootemplate->assign('post', $post);
		$this->dwootemplate->display('guestbook_edit.tpl');
	}
	
	public function post_edit($post_id) {
		return $this->user->isAdmin() || $this->guestbook->is_by_user($post_id, $this->user->userId());
	}
	
	public function acl_edit($post_id) {
		return $this->user->isLoggedIn();
	}
	
	public function get_delete($post_id) {
		
	}
	
	public function post_delete($post_id) {
		
	}
	
	public function acl_delete($post_id) {
		return $this->user->isAdmin() || $this->guestbook->is_by_user($post_id, $this->user->userId()) || $this->guestbook->is_to_user($post_id, $this->user->userId());
	}
	
	public function post_ajax_add($user_id) {
		$this->form_validation->set_rules('body', 'Gästboksmeddelande', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Om du inte har något att säga så kan du lika gärna låta bli. :)');
		if($this->form_validation->run() == FALSE) {
			$this->dwootemplate->assign('userid', $user_id);
			$this->dwootemplate->display('usermenu_guestbook.tpl');
		} else {
			$this->guestbook->add($this->input->post('body'), $this->user->userId(), $user_id);
			print 'Gött hörru, nu är det donat!';
		}
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */