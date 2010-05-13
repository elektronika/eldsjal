<?php
class Messages extends Widget {
	public function run() {
		$this->messages = $this->session->getMessages();
	}
}