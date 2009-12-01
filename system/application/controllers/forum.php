<?php
class Forum extends MY_Controller {	
	public function get_index() {
		$this->categories = $this->models->forum->get_categories_for_usertype($this->session->usertype(), $this->session->userId(), $this->session->lastlogin());
	}
	
	public function acl_topic($id) {
		return $this->models->forum->acl_topic($id, $this->session->usertype());
	}
	
	public function get_topic($id) {
		$posts_per_page = $this->util->setting('forum_posts_per_page');
		$cur_page = $this->arguments->get('page', 0);

		$this->topic = $this->models->forum->get_topic_by_id($id);
		$this->posts = $this->models->forum->get_posts_for_topic($id, $cur_page, $posts_per_page);
		
		if($this->session->isLoggedIn())
			$this->models->forum->add_track($id, $this->session->userId());
		
		$this->pagination->initialize(array(
			'base_url' => '/forum/topic/'.$id.'/page:',
			'per_page' => $posts_per_page,
			'total_rows' => $this->topic->replies + 1,
			'cur_page' => $cur_page
		));
		$this->pager = $this->pagination->create_links();
		
		$this->dwootemplate->assign('user_can_reply', ($this->topic->locked != 1));
	}
	
	public function post_topic($id) {
		$this->form_validation->set_rules('body', 'Inlägg', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Men du, är det så bra med tomma inlägg, egentligen?');
		
		if($this->form_validation->run() == FALSE) {
			$this->get_topic($id);
		} else {
			$new_reply = (object) $this->input->post_array(array('body'));
			$new_reply->topicid = $id;
			$new_reply->userid = $this->session->userId();
			
			$post_id = $this->models->forum->create_post($new_reply);
			
			$this->redirect('/forum/topic/'.$id.'#post-'.$post_id);
		}
	}
		
	public function acl_category($id) {
		return $this->models->forum->acl_category($id, $this->session->usertype());
	}
	
	public function get_category($id) {		
		$topics_per_page = $this->session->setting('topics_per_page');
		$this->posts_per_page = $this->session->setting('forum_posts_per_page');
		$topics_in_category = $this->models->forum->count_topics_in_category($id);

		$cur_page = $this->arguments->get('page', 0);
		
		$this->topics = $this->models->forum->get_topics_in_category($id, $cur_page, $topics_per_page, $this->session->userId(), $this->session->lastlogin(), $this->posts_per_page);
		
		$this->pagination->initialize(array(
			'base_url' => '/forum/category/'.$id.'/page:',
			'per_page' => $topics_per_page,
			'total_rows' => $topics_in_category,
			'cur_page' => $cur_page
		));
		$this->pager = $this->pagination->create_links();

		$this->category = $this->models->forum->get_category_by_id($id);
	}
	
	public function get_new($id = 1) {
		$this->categories = $this->models->forum->get_categories_for_usertype_assoc($this->session->usertype());
		$this->template = 'forum_new_topic.tpl';
	}
	
	public function post_new() {
		$this->form_validation->set_rules('title', 'Rubrik', 'trim|xss_clean|required');
		$this->form_validation->set_rules('body', 'Inlägg', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Fältet "%s" måste fyllas i hörru.');
		
		if ($this->form_validation->run() == FALSE) {
			$this->template = 'forum_new_topic.tpl';
		} else {
			if(!$this->acl_category($this->input->post('category')))
				die('Permission denied');
			
			$new_topic = (object) $this->input->post_array(array('title', 'body', 'category'));
			$new_topic->userid = $this->session->userId();
			
			$topic_id = $this->models->forum->create_topic($new_topic);
			
			$this->redirect('/forum/topic/'.$topic_id);
		}
	}
	
	public function acl_new() {
		return $this->session->isLoggedIn();
	}
	
	public function get_edit($post_id) {
		$this->post = $this->models->forum->get_post_by_id($post_id);
		$this->topic = $this->models->forum->get_topic_by_id($post->topic_id);
		$this->is_first_post = $this->models->forum->post_is_first($post->id);
		$this->categories = $this->models->forum->get_categories_for_usertype_assoc($this->session->usertype());	
		$this->form_action = '/forum/edit/'.$post_id;				
		$this->is_moderator = $this->session->isAdmin();
	}
	
	public function post_edit($post_id) {
		$post_is_first = $this->models->forum->post_is_first($post_id);
		$post = $this->models->forum->get_post_by_id($post_id);
		
		if($post_is_first)
			$this->form_validation->set_rules('title', 'Rubrik', 'trim|xss_clean|required');
		$this->form_validation->set_rules('body', 'Inlägg', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Tomma fält är inte ok, pysen.');	
		
		if ($this->form_validation->run() == FALSE) {
			$this->get_edit($post_id);
		} else {
			if($this->session->isAdmin()) {
				// if(!$this->acl_category($this->input->post('category')))
				// 				die('Permission denied');
			}
			
			if($post_is_first)
				$this->models->forum->rename_topic($post->topic_id, $this->input->post('title'));
			
			$this->models->forum->update_post($post_id, $this->input->post('body'));
			
			$this->redirect('/forum/topic/'.$post->topic_id);
		}
	}

	public function acl_edit($post_id) {
		// Kolla om användaren äger posten, har extra rättigheter eller är admin
		return $this->session->isAdmin() || $this->models->forum->post_creator($post_id) == $this->session->userId();
	}

	public function get_delete($post_id) {}
	
	public function post_delete($post_id) {
		$topic_id = $this->models->forum->topic_id_for_post($post_id);
		$this->models->forum->delete_post($post_id);
		$this->session->message('Inlägg raderat');
		$this->redirect('/forum/topic/'.$topic_id);
		/*
		if($this->forum->post_is_first($post_id)) {
			// Radera tråd
			$category = $this->forum->get_category_for_post($post_id);
			$topic = $this->forum->get_topic_for_post($post_id);
			$this->forum->delete_topic($topic->id);
			// $this->user->message('Tråden "'.$topic->title.'" borttagen');
			redirect('/forum/category/'.$category->id);
		} else {
			// Radera inlägg
			$topic = $this->forum->get_topic_for_post($post_id);
			$this->forum->delete_post($post_id);
			// $this->user->message('Post i tråden "'.$topic->title.'" borttagen');
		}
		*/
	}

	public function acl_delete($post_id) {
		// Kolla om användaren äger posten, har extra rättigheter eller är admin
		return $this->session->isAdmin() || $this->models->forum->post_creator($post_id) == $this->session->userId();
	}
	
	public function get_random() {
		$topic_id = $this->models->forum->get_random_topic($this->session->usertype());
		$this->redirect('/forum/topic/'.$topic_id);
	}
}