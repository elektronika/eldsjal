<?php
class Upcoming extends Widget {
	public function run() {
		$this->events = $this->models->event->get_upcoming(5, $this->session->usertype());
	}
}