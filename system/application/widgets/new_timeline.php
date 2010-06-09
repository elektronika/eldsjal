<?php
class New_timeline extends Widget {
	public function run() {
		$this->body_length = $this->settings->get('timeline_body_length');
		$number_of_items = $this->settings->get('timeline_items');
		$categories = $this->acl->get_by_right('read');
		
		if( ! $this->session->isLoggedIn())	
			foreach($this->settings->get_array('timeline_exclude_categories') as $cat_id)
				unset($categories[$cat_id]);
		
		if(isset($_GET['timeline_filter']) && $this->session->isLoggedIn())
			if(in_array($_GET['timeline_filter'], array('all', 'new', 'local', 'favorites')))
				$this->settings->set('timeline_filter', $_GET['timeline_filter'], $this->session->userId());

		$filter = $this->settings->get('timeline_filter');
		// Fulhack pga att CI's db-lib inte gillar parallella queries. Crazy.
		if($filter == 'favorites')
			$favorites = array_keys($this->models->user->get_favorites($this->session->userId()));
		$timeline = $this->models->timeline->by_categories($categories);
		
		switch($filter) {
			case 'new':
				$timeline->only_new();
				break;
			case 'local':
				$timeline->by_location($this->session->userdata('location'));
				break;
			case 'favorites':
				$timeline->by_users($favorites);
				break;
		}
			
		$this->items = $timeline->get($number_of_items);
		$this->timeline_filter = $filter;
		$this->url = $this->uri->ruri_string();
		$this->show_filter = $this->session->isLoggedIn();
	}
}