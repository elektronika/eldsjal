<?php
class Forum extends MY_Controller {	
	public function get_index() {
		$this->util->trail('spanar över forumkategorierna');
		$this->view->categories = $this->models->forum->get_categories_for_usertype($this->session->usertype(), $this->session->userId(), $this->session->lastlogin());
		$this->view->page_title = 'Forum';
		$this->view->sublinks[] = array('href' => '/forum/random', 'title' => 'Slumpad tråd');
		
		if($this->session->isAdmin())
			$this->view->sublinks[] = array('href' => '/forum/add_category', 'title' => 'Lägg till forumkategori');
	}
	
	public function acl_topic($id = 0) {
		$category_id = $this->models->forum->get_topic_by_id((int) $id)->category_id;
		return $this->acl->check($category_id);
	}
	
	public function get_topic($id) {
		$this->load->library('pagination');
		$posts_per_page = $this->settings->get('forum_posts_per_page');
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
			'total_rows' => $topic->posts,
			'cur_page' => $cur_page
		));
		$this->view->pager = $this->pagination->create_links();
		
		$this->view->page_title = $topic->title;
		$this->view->cur_page = $cur_page;
		$this->view->is_last_page = (bool) ($topic->replies - $cur_page < $posts_per_page);
		$this->view->user_can_reply = ($topic->locked != 1) && $this->acl_reply($id);
		$this->view->is_logged_in = $this->session->isLoggedIn();
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
		$this->category_id = $this->models->forum->get_topic_by_id((int) $id)->category_id;
		return $this->session->isloggedin() && $this->acl->check($this->category_id, 'reply');
	}

	public function post_topic($id) {
		$this->category_id = $this->models->forum->get_topic_by_id((int) $id)->category_id;
		
		$this->form_validation->set_rules('body', 'Inlägg', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Men du, är det så bra med tomma inlägg, egentligen?');
		
		if($this->form_validation->run() == FALSE) {
			$this->get_topic($id);
		} else {
			$new_reply = (object) $this->input->post_array(array('body'));
			$new_reply->topicid = $id;
			$new_reply->userid = $this->session->userId();
			
			$post_id = $this->models->forum->create_post($new_reply);
			
			$topic = $this->models->forum->get_topic_by_id((int) $id);
			
			if( (bool) $topic->is_event)
				$item_type = 'event_reply';
			elseif( (bool) $topic->is_wiki)
				$item_type = 'wiki_reply';			
			else
				$item_type = 'forum_reply';
			
			$this->models->timeline->add($this->session->userId(), $item_type, $post_id, $topic->title, $new_reply->body, FALSE, NULL, $this->category_id, $topic->location_id);
			
			$page = floor($this->models->forum->count_posts_in_topic($id) / $this->settings->get('forum_posts_per_page')) * $this->settings->get('forum_posts_per_page');
			$this->session->message('Inlägg sparat!');
			$this->redirect('/forum/topic/'.$id.'/page:'.$page.'#post-'.$post_id);
		}
	}
	
	public function get_category($id) {
		$this->load->library('pagination');
			
		$topics_per_page = $this->settings->get('topics_per_page');
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
		
		$this->view->posts_per_page = $this->settings->get('forum_posts_per_page');
		$category = $this->models->forum->get_category_by_id($id);
		$this->view->category = $category;
		$this->util->trail('kikar runt i forumkategorin '.$category->forumCategoryName, $category->forumSecurityLevel);
		$this->view->page_title = $category->forumCategoryName;
		$this->view->breadcrumbs[] = array('href' => '/forum', 'title' => 'Forum');
		$this->view->administrators = $this->models->user->get_by_ids($this->acl->get_users_by_right((int) $id, 'admin'));
		if($this->acl_new($id))
			$this->view->sublinks[] = array('href' => '/forum/new/'.$category->forumCategoryId, 'title' => 'Ny tråd');
		if($this->acl_admin($id))
			$this->view->sublinks[] = array('href' => '/forum/admin/'.$category->forumCategoryId, 'title' => 'Administrera kategori');
	}
	
	public function acl_category($category_id = 0) {
		return $this->acl->check($category_id);
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
		$this->view->locations = array('0' => '-') + $this->models->location->get_all_assoc();
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
			
			$date_from = datepicker_timestamp('date_from');
			$date_to = datepicker_timestamp('date_to');
			if($date_to < $date_from)
				$date_to = $date_from;
				
			$this->models->forum->set_topic_fields($topic_id, array(
				'is_event' => (int) $this->input->post('is_event'),
				'is_wiki' => (int) $this->input->post('is_wiki'),
				'date_from' => $date_from,
				'date_to' => $date_to,
				'location_id' => (int) $this->input->post('location')
			));
			
			if((bool) $this->input->post('is_event'))
				$item_type = 'event_new';
			elseif((bool) $this->input->post('is_wiki'))
				$item_type = 'wiki_new';			
			else
				$item_type = 'forum_new';
			
			$this->models->timeline->add($this->session->userId(), $item_type, $topic_id, $new_topic->title, $new_topic->body, TRUE, NULL, (int) $id);
			
			$this->session->message('Japp, nu är tråden skapad!');
			$this->redirect('/forum/topic/'.$topic_id);
		}
	}
	
	public function acl_new($id = 0) {
		return $this->session->isloggedin() && $this->acl->check($id, 'create');
	}
	
	public function get_edit($post_id) {
		$post = $this->models->forum->get_post_by_id($post_id);
		$this->view->post = $post;
		$topic = $this->models->forum->get_topic_by_id($post->topic_id);
		$this->view->topic = $topic;
		$this->view->is_first_post = $this->models->forum->post_is_first($post->id);
		$this->view->categories = $this->models->forum->get_categories_for_user_assoc($this->session->userId());	
		$this->view->form_action = '/forum/edit/'.$post_id;				
		$this->view->is_moderator = $this->session->isAdmin();
		$this->util->trail('ångrar sig, och redigerar ett inlägg');
		$this->view->page_title = 'Redigera inlägg';
		$this->view->years_ahead = $this->settings->get('calendar_years_ahead');
		$this->view->years_back = 0;
		$this->view->breadcrumbs[] = array('href' => '/forum', 'title' => 'Forum');
		$this->view->breadcrumbs[] = array('href' => '/forum/category/'.$topic->forumCategoryID, 'title' => $topic->forumCategoryName);		
		$this->view->locations = array('0' => '-') + $this->models->location->get_all_assoc();
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
					
				$date_from = datepicker_timestamp('date_from');
				$date_to = datepicker_timestamp('date_to');
				if($date_to < $date_from)
					$date_to = $date_from;
					
				$this->models->forum->set_topic_fields($post->topic_id, array(
					'topicname' => $this->input->post('title'),
					'is_event' => (int) $this->input->post('is_event'),
					'date_from' => $date_from,
					'date_to' => $date_to,
					'is_wiki' => (int) $this->input->post('is_wiki'),
					'location_id' => (int) $this->input->post('location')
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
		$category_id = 0;
		return $this->models->forum->topic_is_wiki((int) $post_id) || $this->models->forum->post_creator((int) $post_id) == $this->session->userId() || $this->acl->check($category_id, 'admin');
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
		$this->models->timeline->delete($post_id, 'forum_reply');
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
		$category_id = 0;
		return $this->models->forum->post_creator($post_id) == $this->session->userId() || $this->acl->check($category_id, 'admin');
	}
	
	public function get_random() {
		$topic_id = $this->models->forum->get_random_topic($this->acl->get_by_right('read'));
		$this->redirect('/forum/topic/'.$topic_id);
	}
	
	public function get_redirectupdated($topic_id) {
		$latest = $this->db->query("SELECT COUNT(*) AS previous, MAX(messageid) AS max FROM forummessages WHERE topicid = {$topic_id} AND messagedate < (SELECT FROM_UNIXTIME(time) FROM forumtracks WHERE topic_id = {$topic_id} AND user_id = ".$this->session->userid().")")->row();
		$per_page = $this->settings->get('forum_posts_per_page');
		$page = floor($latest->previous / $per_page) * $per_page;
		$this->redirect('/forum/topic/'.$topic_id.'/page:'.$page.'#post-'.$latest->max);
	}
	
	public function get_redirecttopost($post_id) {
		$post = $this->models->forum->get_post_by_id((int) $post_id);
		$previous = $this->db->query("SELECT COUNT(*) AS previous FROM forummessages WHERE topicid = {$post->topic_id} AND messageid < {$post->id}")->row()->previous;
		$per_page = $this->settings->get('forum_posts_per_page');
		$page = floor($previous / $per_page) * $per_page;
		$this->redirect("/forum/topic/{$post->topic_id}/page:{$page}#post-{$post->id}");
	}
	
	public function get_admin($category_id) {
		$category = $this->models->forum->get_category_by_id((int) $category_id);
		$this->view->page_title = 'Administrera kategorin '.$category->forumCategoryName;
		$this->view->form_action = '/forum/admin/'.(int) $category_id;
		$this->view->default_acl = $this->models->forum->get_default_acl((int) $category_id);
		$this->view->user_acls = $this->models->forum->get_user_acls((int) $category_id);
		$this->view->sublinks[] = array('title' => 'Tillbaka till kategorin', 'href' => '/forum/category/'.(int) $category_id);
		$this->view->category = (object) array('title' => $category->forumCategoryName, 'body' => $category->forumCategoryDesc);
	}
	
	public function post_admin($category_id) {		
		$this->form_validation->set_rules('title', 'Namn', 'trim|xss_clean|required');
		$this->form_validation->set_rules('body', 'Beskrivning', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Något måste det stå, annars blir det galet.');	
		
		if ($this->form_validation->run() == FALSE) {
			$this->get_admin($category_id);
		} else {
			$this->db->update('forumcategory', array('forumCategoryName' => $this->input->post('title'), 'forumCategoryDesc' => $this->input->post('body')), array('forumCategoryId' => (int) $category_id));
			
			// Sätt default-ACL'en
			$this->models->forum->set_acl(0, (int) $category_id, 
				isset($_POST['default_acl']['read']), 
				isset($_POST['default_acl']['create']), 
				isset($_POST['default_acl']['reply']));
		
			// Pytsa dit ACL'en för varje användare
			foreach($_POST['user_acls'] as $user_id => $acl) {
				$this->models->forum->set_acl((int) $user_id, (int) $category_id,
					isset($_POST['user_acls'][$user_id]['read']),
					isset($_POST['user_acls'][$user_id]['create']),
					isset($_POST['user_acls'][$user_id]['reply']),
					isset($_POST['user_acls'][$user_id]['admin']));
					$this->alerts->add('flush', (int) $user_id);
				}
		
			// Lägg till ACL för användaren, om den finns
			if(isset($_POST['new_acl']['username']) && ! empty($_POST['new_acl']['username'])) {
				$user = $this->db->select('userid')->where('username', $this->input->xss_clean($_POST['new_acl']['username']))->get('users')->row();
				if(isset($user->userid)) {
					$this->models->forum->set_acl($user->userid, (int) $category_id, 
						isset($_POST['new_acl']['read']), 
						isset($_POST['new_acl']['create']), 
						isset($_POST['new_acl']['reply']), 
						isset($_POST['new_acl']['admin']));
					$this->alerts->add('flush', (int) $user->userid);
				} else
					$this->session->message('Sorry, ingen användare matchade det användarnamnet.', 'warning');
			}
		
			$this->session->message('Sidärja, då vart det uppdaterat. Snajsigt!');
			$this->redirect('/forum/admin/'.(int) $category_id);
		}
	}
	
	public function acl_admin($category_id = 0) {
		return $this->acl->check((int) $category_id, 'admin');
	}
	
	public function acl_add_category() {
		return $this->session->isAdmin();
	}
	
	public function get_add_category() {
		$this->view->page_title = 'Lägg till forumkategori';
	}
	
	public function post_add_category() {
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Namn', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'Något måste den heta hörru.');
				
		if($this->form_validation->run() == FALSE) {
			$this->get_add_category();
		} else {
			$category_id = $this->models->forum->add_category($this->input->post('title'));
			$this->models->forum->set_acl($this->session->userId(), $category_id, TRUE, TRUE, TRUE, TRUE);
			$this->redirect('/forum/category/'.$category_id);
		}
	}
}