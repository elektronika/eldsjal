<?php
class Latestlogins extends Widget {
	public function run() {
		$this->logins = $this->models->user->get_latest_logins(6);
	}
}