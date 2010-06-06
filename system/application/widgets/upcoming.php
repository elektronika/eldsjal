<?php
class Upcoming extends Widget {
	public function run() {
		$this->events = $this->models->event->get_upcoming($this->acl->get_by_right('read'), 5);
	}
}