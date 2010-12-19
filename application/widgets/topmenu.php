<?php
class Topmenu extends Widget {
	public function run() {
		$this->show_search = $this->session->isLoggedIn();
		$this->active = $this->uri->segment(1);
		$this->calendar_alerts = counter($this->alerts->count('events'));
		$this->forum_alerts = counter($this->alerts->count('forum'));
		$this->gallery_alerts = counter($this->alerts->count('image_tag'));
	}
}