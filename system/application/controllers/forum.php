<?php
class Forum extends Controller {
	public function __construct() {
		parent::Controller();
		// if($this->user->isAdmin())
		// 		$this->output->enable_profiler(TRUE);
		$this->load->model('forum_model');
	}
	
	public function get_index() {
		$categories = $this->forum_model->get_categories_for_usertype($this->user->usertype(), $this->user->userId(), $this->user->lastlogin());
		
		$this->dwootemplate->assign('categories', $categories);
		$this->dwootemplate->display('forum_index.tpl');
	}
	
	public function acl_topic($id) {
		return $this->forum_model->acl_topic($id, $this->user->usertype());
	}
	
	public function get_topic($id) {
		$topic = $this->forum_model->get_topic_by_id($id);
		$posts = $this->forum_model->get_posts_for_topic($id);
		
		if($this->user->isLoggedIn())
			$this->forum_model->add_track($id, $this->user->userId());
		
		$this->dwootemplate->assign('posts', $posts);
		$this->dwootemplate->assign('user_can_reply', ($topic->locked != 1));
		$this->dwootemplate->assign('topic', $topic);
		$this->dwootemplate->display('forum_topic.tpl');
	}
	
	public function post_topic($id) {
		$this->form_validation->set_rules('body', 'Inlägg', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Men du, är det så bra med tomma inlägg, egentligen?');
		
		if($this->form_validation->run() == FALSE) {
			$this->get_topic($id);
		} else {
			$new_reply = new stdClass();
			$new_reply->body = $this->input->post('body');
			$new_reply->topicid = $id;
			$new_reply->userid = $this->user->userId();
			
			$post_id = $this->forum_model->create_post($new_reply);
			
			$this->load->helper('url');
			redirect('/forum/topic/'.$id.'#post-'.$post_id);
		}
	}
		
	public function acl_category($id) {
		return $this->forum_model->acl_category($id, $this->user->usertype());
	}
	
	public function get_category($id) {
		$this->load->library('pagination');
		
		$topics_per_page = $this->user->setting('topics_per_page');
		$topics_in_category = $this->forum_model->count_topics_in_category($id);

		$cur_page = $this->arguments->get('page', 0);
		
		$topics = $this->forum_model->get_topics_in_category($id, $cur_page, $topics_per_page, $this->user->userId(), $this->user->lastlogin());
		
		$this->pagination->initialize(array(
			'base_url' => '/forum/category/'.$id.'/page:',
			'per_page' => $topics_per_page,
			'total_rows' => $topics_in_category,
			'cur_page' => $cur_page
		));
		$pager = $this->pagination->create_links();

		$category = $this->forum_model->get_category_by_id($id);
		
		$this->dwootemplate->assign('pager', $pager);
		$this->dwootemplate->assign('topics', $topics);
		$this->dwootemplate->assign('category', $category);
		$this->dwootemplate->display('forum_category.tpl');
	}
	
	public function get_new($id = 1) {
		$categories = $this->forum_model->get_categories_for_usertype_assoc($this->user->usertype());
		
		$this->dwootemplate->assign('categories', $categories);
		$this->dwootemplate->display('forum_new_topic.tpl');
	}
	
	public function post_new() {
		$this->form_validation->set_rules('title', 'Rubrik', 'trim|xss_clean|required');
		$this->form_validation->set_rules('body', 'Inlägg', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Fältet "%s" måste fyllas i hörru.');
		
		if ($this->form_validation->run() == FALSE) {
			$this->dwootemplate->display('forum_new_topic.tpl');
		} else {
			if(!$this->acl_category($this->input->post('category')))
				die('Permission denied');
			
			$new_topic = new stdClass();
			$new_topic->title = $this->input->post('title');
			$new_topic->body = $this->input->post('body');
			$new_topic->category = $this->input->post('category');
			$new_topic->userid = $this->user->userId();
			
			$topic_id = $this->forum_model->create_topic($new_topic);
			
			$this->load->helper('url');			
			redirect('/forum/topic/'.$topic_id);
		}
	}
	
	public function get_edit($post_id) {
		$post = $this->forum_model->get_post_by_id($post_id);
		$topic = $this->forum_model->get_topic_by_id($post->topic_id);
		$post_is_first = $this->forum_model->post_is_first($post->id);
		$categories = $this->forum_model->get_categories_for_usertype_assoc($this->user->usertype());
		
		$this->dwootemplate->assign('form_action', '/forum/edit/'.$post_id);		
		$this->dwootemplate->assign('is_moderator', $this->user->isAdmin());		
		$this->dwootemplate->assign('categories', $categories);		
		$this->dwootemplate->assign('post', $post);
		$this->dwootemplate->assign('topic', $topic);
		$this->dwootemplate->assign('is_first_post', $post_is_first);
		$this->dwootemplate->display('forum_edit.tpl');
	}
	
	public function post_edit($post_id) {
		$post_is_first = $this->forum_model->post_is_first($post_id);
		$post = $this->forum_model->get_post_by_id($post_id);
		
		if($post_is_first)
			$this->form_validation->set_rules('title', 'Rubrik', 'trim|xss_clean|required');
		$this->form_validation->set_rules('body', 'Inlägg', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Tomma fält är inte ok, pysen.');	
		
		if ($this->form_validation->run() == FALSE) {
			$this->get_edit($post_id);
		} else {
			if($this->user->isAdmin()) {
				// if(!$this->acl_category($this->input->post('category')))
				// 				die('Permission denied');
			}
			
			if($post_is_first) {
				$this->forum_model->rename_topic($post->topic_id, $this->input->post('title'));
			}
			
			$this->forum_model->update_post($post_id, $this->input->post('body'));
			
			$this->load->helper('url');			
			redirect('/forum/topic/'.$post->topic_id);
		}
	}

	public function acl_edit($post_id) {
		// Kolla om användaren äger posten, har extra rättigheter eller är admin
		return $this->user->isAdmin() || $this->forum_model->post_creator($post_id) == $this->user->userId();
	}

	public function get_delete($post_id) {
		
	}
	
	public function post_delete($post_id) {
		$this->load->helper('url');
		$topic_id = $this->forum_model->topic_id_for_post($post_id);
		$this->forum_model->delete_post($post_id);
		$this->user->message('Inlägg raderat');
		redirect('/forum/topic/'.$topic_id);
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
		return $this->user->isAdmin() || $this->forum_model->post_creator($post_id) == $this->user->userId();
	}
	
	public function get_random() {
		$topic_id = $this->forum_model->get_random_topic($this->user->usertype());
		$this->load->helper('url');
		redirect('/forum/topic/'.$topic_id);
	}
}