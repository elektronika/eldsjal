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
			if(in_array($_GET['timeline_filter'], array('all', 'new')))
				$this->settings->set('timeline_filter', $_GET['timeline_filter'], $this->session->userId());
		
		$show_only_new = $this->settings->get('timeline_filter') == 'new';
		$this->items = $this->models->timeline->get($categories, $show_only_new, $number_of_items);
		$this->timeline_filter = $this->settings->get('timeline_filter');
		$this->url = $this->uri->ruri_string();
		$this->show_filter = $this->session->isLoggedIn();
	}
}