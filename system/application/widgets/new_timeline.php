<?php
class New_timeline extends Widget {
	public function run() {
		$this->body_length = $this->settings->get('timeline_body_length');
		$number_of_items = $this->settings->get('timeline_items');
		$categories = $this->acl->get_by_right('read');
		
		$this->items = $this->models->timeline->get($categories, FALSE, $number_of_items);
	}
}