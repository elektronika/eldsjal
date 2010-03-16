<?php
class Forum extends MY_Controller {	
	public function get_index() {
		$this->util->trail('spanar över forumkategorierna');
		$this->view->categories = $this->models->forum->get_categories_for_usertype($this->session->usertype(), $this->session->userId(), $this->session->lastlogin());
		$this->view->page_title = 'Forum';
		$this->view->sublinks[] = array('href' => '/forum/random', 'title' => 'Slumpad tråd');
		
		if($this->session->isAdmin())
			$this->view->sublinks[] = array('href' => '/forum/admin', 'title' => 'Hantera kategorier');
	}
	
	public function acl_topic($id) {
		return $this->models->forum->acl_topic($id, $this->session->usertype());
	}
	
	public function get_topic($id) {
		$this->load->library('pagination');
		$posts_per_page = $this->util->setting('forum_posts_per_page');
		$cur_page = (int) $this->arguments->get('page', 0);

		$topic = $this->models->forum->get_topic_by_id((int) $id);
		$this->util->trail('läser tråden '.$topic->title, $topic->forumSecurityLevel);
		$this->view->topic = $topic;
		$this->view->posts = $this->models->forum->get_posts_for_topic((int) $id, $cur_page, $posts_per_page);
		
		if($this->session->isLoggedIn())
			$this->models->forum->add_track($id, $this->session->userId());
		
		$this->pagination->initialize(array(
			'base_url' => '/forum/topic/'.$id.'/page:',
			'per_page' => $posts_per_page,
			'total_rows' => $topic->replies + 1,
			'cur_page' => $cur_page
		));
		$this->view->pager = $this->pagination->create_links();
		$this->view->page_title = $topic->title;
		$this->view->cur_page = $cur_page;
		$this->view->is_last_page = (bool) ($topic->replies - $cur_page < $posts_per_page);
		$this->view->user_can_reply = ($topic->locked != 1) && $this->acl_reply($id);
		$this->view->breadcrumbs[] = array('href' => '/forum', 'title' => 'Forum');
		$this->view->breadcrumbs[] = array('href' => '/forum/category/'.$topic->forumCategoryID, 'title' => $topic->forumCategoryName);
		
		if($topic->is_event) {
			$this->view->sublinks[] = array('href' => '/calendar/browse/'.date('Y', $topic->date_from).'/'.date('m', $topic->date_from), 'title' => datespan($topic->date_from, $topic->date_to));
			if($this->models->event->user_has_signed_up($this->session->userId(), $id))
				$this->view->sublinks[] = array('href' => '/calendar/signoff/'.$id, 'title' => 'Njae, jag ska nog inte med. :/');
			else
				$this->view->sublinks[] = array('href' => '/calendar/signup/'.$id, 'title' => 'Sign me up scotty!');
			$attendees = $this->models->event->get_attendees($id);
			if(count($attendees) > 0)
				$this->view->sublinks[] = array('href' => '/calendar/attendees/'.$id, 'title' => 'Deltagarlistan ('.count($attendees).' ska med)');
		}

	}
	
	public function acl_reply($id) {
		return $this->session->isloggedin() && $this->models->forum->acl_topic($id, $this->session->usertype());
	}

	public function post_topic($id) {
		if( ! $this->session->isloggedin())
			die('Permission denied');
		$this->form_validation->set_rules('body', 'Inlägg', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Men du, är det så bra med tomma inlägg, egentligen?');
		
		if($this->form_validation->run() == FALSE) {
			$this->get_topic($id);
		} else {
			$new_reply = (object) $this->input->post_array(array('body'));
			$new_reply->topicid = $id;
			$new_reply->userid = $this->session->userId();
			
			$post_id = $this->models->forum->create_post($new_reply);
			$page = floor($this->models->forum->count_posts_in_topic($id) / $this->util->setting('forum_posts_per_page')) * $this->util->setting('forum_posts_per_page');
			$this->session->message('Inlägg sparat!');
			$this->redirect('/forum/topic/'.$id.'/page:'.$page.'#post-'.$post_id);
		}
	}
	
	public function get_category($id) {
		$this->load->library('pagination');
			
		$topics_per_page = $this->session->setting('topics_per_page');
		$topics_in_category = $this->models->forum->count_topics_in_category($id);

		$cur_page = $this->arguments->get('page', 0);
		
		$this->view->topics = $this->models->forum->get_topics_in_category($id, $cur_page, $topics_per_page, $this->session->userId(), $this->session->lastlogin());
		
		$this->pagination->initialize(array(
			'base_url' => '/forum/category/'.$id.'/page:',
			'per_page' => $topics_per_page,
			'total_rows' => $topics_in_category,
			'cur_page' => $cur_page
		));
		$this->view->pager = $this->pagination->create_links();
		$this->view->posts_per_page = $this->session->setting('forum_posts_per_page');
		$category = $this->models->forum->get_category_by_id($id);
		$this->view->category = $category;
		$this->util->trail('kikar runt i forumkategorin '.$category->forumCategoryName, $category->forumSecurityLevel);
		$this->view->page_title = $category->forumCategoryName;
		$this->view->breadcrumbs[] = array('href' => '/forum', 'title' => 'Forum');
		if($this->acl_new($id))
			$this->view->sublinks[] = array('href' => '/forum/new/'.$category->forumCategoryId, 'title' => 'Ny tråd');
	}
	
	public function get_new($id) {
		$this->view->category = $this->models->forum->get_category_by_id($id);
		$this->view->template = 'forum_new_topic';
		$this->util->trail('är på gång att starta en ny tråd i forumet. Håll i dig!');
		$this->view->page_title = 'Ny forumtråd';
		$this->view->breadcrumbs[] = array('href' => '/forum', 'title' => 'Forum');
		$this->view->breadcrumbs[] = array('href' => '/forum/category/'.$this->view->category->forumCategoryId, 'title' => $this->view->category->forumCategoryName);		
		$this->view->is_event = $this->input->get('event');
		$this->view->years_ahead = $this->settings->get('calendar_years_ahead');
		$this->view->years_back = 0;
	}
	
	public function post_new($id) {
		$this->form_validation->set_rules('title', 'Rubrik', 'trim|xss_clean|required');
		$this->form_validation->set_rules('body', 'Inlägg', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Fältet "%s" måste fyllas i hörru.');
		
		if ($this->form_validation->run() == FALSE) {
			$this->get_new($id);
		} else {		
			$new_topic = (object) $this->input->post_array(array('title', 'body'));
			$new_topic->category = intval($id);
			$new_topic->userid = $this->session->userId();
			
			$topic_id = $this->models->forum->create_topic($new_topic);
			
			$this->models->forum->set_topic_fields($topic_id, array(
				'is_event' => (int) $this->input->post('is_event'),
				'date_from' => datepicker_timestamp('date_from'),
				'date_to' => datepicker_timestamp('date_to')
			));
			
			$this->session->message('Japp, nu är tråden skapad!');
			$this->redirect('/forum/topic/'.$topic_id);
		}
	}
	
	public function acl_new($id) {
		return $this->session->isloggedin() && $this->models->forum->acl_category_new($id, $this->session->usertype());
	}
	
	public function get_edit($post_id) {
		$post = $this->models->forum->get_post_by_id($post_id);
		$this->view->post = $post;
		$topic = $this->models->forum->get_topic_by_id($post->topic_id);
		$this->view->topic = $topic;
		$this->view->is_first_post = $this->models->forum->post_is_first($post->id);
		$this->view->categories = $this->models->forum->get_categories_for_usertype_assoc($this->session->usertype());	
		$this->view->form_action = '/forum/edit/'.$post_id;				
		$this->view->is_moderator = $this->session->isAdmin();
		$this->util->trail('ångrar sig, och redigerar ett inlägg');
		$this->view->page_title = 'Redigera inlägg';
		$this->view->years_ahead = $this->settings->get('calendar_years_ahead');
		$this->view->years_back = 0;
		$this->view->breadcrumbs[] = array('href' => '/forum', 'title' => 'Forum');
		$this->view->breadcrumbs[] = array('href' => '/forum/category/'.$topic->forumCategoryID, 'title' => $topic->forumCategoryName);		
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
			if($post_is_first) {
				$this->models->forum->rename_topic($post->topic_id, $this->input->post('title'));
				if($this->session->isAdmin())
					$this->models->forum->set_topic_fields($post->topic_id, array(
						'sticky' => (int) $this->input->post('sticky'),
						'locked' => (int) $this->input->post('locked'),
						'forumcategoryid' => (int) $this->input->post('category')
					));
				$this->models->forum->set_topic_fields($post->topic_id, array(
					'topicname' => $this->input->post('title'),
					'is_event' => (int) $this->input->post('is_event'),
					'date_from' => datepicker_timestamp('date_from'),
					'date_to' => datepicker_timestamp('date_to')
				));
			}
			if($post->body != $this->input->post('body'))
				$this->models->forum->update_post($post_id, $this->input->post('body'));
			$this->session->message('Inlägget uppdaterat!');
			$this->redirect('/forum/topic/'.$post->topic_id);
		}
	}

	public function acl_edit($post_id) {
		// Kolla om användaren äger posten, har extra rättigheter eller är admin
		return $this->session->isAdmin() || $this->models->forum->post_creator($post_id) == $this->session->userId();
	}

	public function get_delete($post_id) {
		$this->view->template = 'confirm';
		$this->view->message = 'Är du säker på att du vill ta bort inlägget?';
		$this->view->form_action = '/forum/delete/'.$post_id;
		$this->util->trail('funderar på att ta bort något! :-o');
		$this->view->page_title = 'Radera inlägg';
	}
	
	public function post_delete($post_id) {
		$topic_id = $this->models->forum->topic_id_for_post((int) $post_id);
		$this->models->forum->delete_post((int) $post_id);
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
	
	public function get_redirectupdated($topic_id) {
		$latest = $this->db->query("SELECT COUNT(*) AS previous, MAX(messageid) AS max FROM forummessages WHERE topicid = {$topic_id} AND messagedate < (SELECT FROM_UNIXTIME(time) FROM forumtracks WHERE topic_id = {$topic_id} AND user_id = ".$this->session->userid().")")->row();
		$per_page = $this->session->setting('forum_posts_per_page');
		$page = floor($latest->previous / $per_page) * $per_page;
		$this->redirect('/forum/topic/'.$topic_id.'/page:'.$page.'#post-'.$latest->max);
	}
	
	public function get_redirecttopost($post_id) {
		$post = $this->models->forum->get_post_by_id((int) $post_id);
		$previous = $this->db->query("SELECT COUNT(*) AS previous FROM forummessages WHERE topicid = {$post->topic_id} AND messageid < {$post->id}")->row()->previous;
		$per_page = $this->session->setting('forum_posts_per_page');
		$page = floor($previous / $per_page) * $per_page;
		$this->redirect("/forum/topic/{$post->topic_id}/page:{$page}#post-{$post->id}");
	}
	
	public function get_admin() {
		$this->view->items = $this->db->order_by('forumCategorySortOrder', 'asc')->get('forumcategory')->result();
		$this->view->page_title = 'Forumskategorier';
		$this->view->template = 'inputgrid';
		$this->view->form_action = '/forum/admin';
	}
	
	public function post_admin() {
		// $this->db->empty_table('board');
		// foreach($_POST['items'] as $item)
		// 	if( ! empty($item['rights']))
		// 		$this->db->insert('board', $item);
		$this->session->message('Sådärja!');
		$this->redirect('/forum/admin');
	}
	
	public function acl_admin() {
		return $this->session->isAdmin();
	}
}