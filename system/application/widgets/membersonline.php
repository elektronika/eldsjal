<?php
class Membersonline extends Widget {
	public function run() {
		$this->usersonline = $this->models->user->online_count();
	}
}