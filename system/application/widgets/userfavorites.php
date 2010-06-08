<?php
class Userfavorites extends Widget {
	public function run() {
		$this->items = $this->models->user->get_favorites($this->session->userId());
	}
}