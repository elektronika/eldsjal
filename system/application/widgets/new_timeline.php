<?php
class New_timeline extends Widget {
	public function run() {
		$this->body_length = $this->settings->get('timeline_body_length');
		$number_of_items = $this->settings->get('timeline_items');
		$categories = $this->acl->get_by_right('read');

		if($timeline_filter = $this->input->get('timeline_filter'))
			if(in_array($timeline_filter, array('all', 'new')))
				$this->settings->set('timeline_filter', $timeline_filter, $this->session->userId());
		
		$show_only_new = $this->settings->get('timeline_filter') == 'new';
		$this->items = $this->models->timeline->get($categories, $show_only_new, $number_of_items);
		$this->timeline_filter = $this->settings->get('timeline_filter');
		$this->url = $this->uri->ruri_string();
	}
}