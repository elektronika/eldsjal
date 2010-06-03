<?php
class Topmenu extends Widget {
	public function run() {
		$this->show_search = $this->session->isLoggedIn();
	}
}